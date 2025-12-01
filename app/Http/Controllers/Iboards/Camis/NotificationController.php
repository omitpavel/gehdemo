<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Common\HistoryController;
use App\Http\Controllers\Controller;
use App\Models\Common\User;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundAllowedToMove;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundMovementNotification;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundRedGreenBed;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\View\CamisIboxPatientWardMovement;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Illuminate\Support\Facades\Route;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class NotificationController extends Controller
{
    public function Index()
    {
        // if (!CheckDashboardPermission('view_all_notification_view')) {
        //     Toastr::error('Permission Denied');
        //     return back();
        // }
        return view('Common.View.Notification.Index');
    }

    /**
     * Helper: pull Allowed-to-Move notifications for the current user (type=7)
     * Returns [array $mapped, bool $isNumericUserType]
     */
    private function allowedToMoveNotifications(Carbon $sinceOrStart, ?Carbon $until = null): array
    {
        $loggedUserId = session()->get('LOGGED_USER_ID', '');
        $userType = User::find($loggedUserId)->user_type ?? 0; // << required way
        $isNumeric = is_numeric($userType);

        if (in_array(request()->currentRoute, ['ward.sdec', 'ward.sdec.boardround'])) {
            $userType = ['RLTSDECPW', 'RLTSDECIP'];
        } elseif (in_array(request()->currentRoute, ['ward.frailty', 'ward.frailty.boardround'])) {
            $userType = ['RLTFAU'];
        } elseif (in_array(request()->currentRoute, ['ward.discharge.lounge', 'ward.discharge.lounge.boardround'])) {
            $userType = ['RLTDISCHARGE'];
        } elseif (request()->filled('current_ward')) {
            $userType = [strtoupper(request()->current_ward)];
        }


        $all_inpatients = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('ibox_ward_id', AllWardToIDArray())
            ->whereNotNull('camis_patient_id')
            ->pluck('camis_patient_id')
            ->toArray();

        $q = CamisIboxBoardRoundAllowedToMove::with(['PatientInformationWithBedDetails' => function ($q) {
            $q->select('camis_patient_id', 'camis_patient_name', 'ibox_actual_bed_full_name', 'camis_patient_pas_number', 'camis_patient_ward');
        }])
            ->whereIn('patient_id', $all_inpatients)
            ->when(!empty($userType), function ($query) use ($userType) {
                $query->where(function ($q) use ($userType) {
                    $q->whereIn('patient_allowed_to_be_moved_from', $userType)
                        ->orWhereIn('patient_allowed_to_be_moved_to', $userType);
                });
            });

        if ($until) {
            $q->whereBetween('updated_at', [$sinceOrStart, $until]);
        } else {
            $q->where('updated_at', '>=', $sinceOrStart);
        }

        $rows = $q->get()->toArray();
        $users = User::pluck('username', 'id')->toArray();


        $mapped = [];
        foreach ($rows as $r) {

            if (!isset($r['patient_information_with_bed_details']['camis_patient_ward'])) {
                continue;
            }
            if ($r['patient_information_with_bed_details']['camis_patient_ward'] != $r['patient_allowed_to_be_moved_from']) {
                continue;
            }

            if (strtolower($r['patient_allowed_to_be_moved_to']) == 'do not move') {
                continue;
            }

            if (!in_array(request()->currentRoute, ['ward.ward-details', 'ward.frailty', 'ward.sdec', 'ward.discharge.lounge', 'ward.boardround', 'ward.sdec.boardround', 'ward.frailty.boardround', 'ward.discharge.lounge.boardround'])) {

                continue;
            }
            $action_user = '';
            $action_time = '';
            $status_formatted = '';
            $declined_reason = '';
            if ($r['status'] == 1) {
                $action_user = $users[$r['accepted_by']] ?? '';
                $action_time = PredefinedDateFormatFor24Hour($r['accepted_time']);
                $status_formatted = 'Accepted';
                $declined_reason = '';
            } else if ($r['status'] == 2) {
                $action_user = $users[$r['declined_by']] ?? '';
                $action_time = PredefinedDateFormatFor24Hour($r['declined_time']);
                $status_formatted = 'Declined';
                $declined_reason = $r['declined_reason'] ?? '';
            }

            if (in_array($r['patient_allowed_to_be_moved_to'], $userType)) {
                $can_receive = 1;
            } else {
                $can_receive = 0;
            }

            $mapped[] = [
                'camis_patient_id'   => $r['patient_id'],
                'camis_patient_name' => $r['patient_information_with_bed_details']['camis_patient_name'] ?? '',
                'notification_time'  => $r['updated_at'],
                'notification_type'  => 7, // Allowed-to-Move
                'status'             => $r['status'] ?? 0,
                'action_time'        => $action_time,
                'action_user'        => $action_user,
                'status_formatted'   => $status_formatted,
                'declined_reason'    => $declined_reason,
                'can_receive'        => $can_receive,
                'move_to'            => $r['patient_allowed_to_be_moved_to'] ?? '',
                'move_from'          => $r['patient_allowed_to_be_moved_from'] ?? '',
                'move_comment'       => $r['patient_allowed_to_be_moved_comment'] ?? '',
                'camis_patient_bed'  => $r['patient_information_with_bed_details']['ibox_actual_bed_full_name'] ?? '',
                'camis_patient_pas_number'  => $r['patient_information_with_bed_details']['camis_patient_pas_number'] ?? '',
            ];
        }
        return [$mapped, $isNumeric];
    }

    public function OffcanvasDataLoad(Request $request)
    {
        $since = Carbon::now()->subDay();

        $all_inpatients = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('ibox_ward_id', AllWardToIDArray())
            ->whereNotNull('camis_patient_id')
            ->pluck('camis_patient_id')
            ->toArray();

        // Red/Green (5/6)
        $green_bed_patients = CamisIboxBoardRoundRedGreenBed::with(['PatientInformationWithBedDetails' => function ($q) {
            $q->select('camis_patient_id', 'camis_patient_name', 'ibox_actual_bed_full_name', 'ibox_ward_name', 'camis_patient_pas_number');
        }])
            ->where('updated_at', '>=', $since)
            ->whereIn('patient_id', $all_inpatients)
            ->get()->toArray();

        // ETL (1..4)
        $etl_notifications = CamisIboxPatientWardMovement::where('notification_time', '>=', $since)->get()->toArray();

        $all_notification = [];

        foreach ($green_bed_patients as $red_green) {
            $all_notification[] = [
                'camis_patient_id'   => $red_green['patient_id'],
                'notification_time'  => $red_green['updated_at'],
                'status'             => 0,
                'action_time'        => '',
                'action_user'        => '',
                'status_formatted'   => '',
                'declined_reason'    => '',
                'can_receive'        => 0,
                'camis_patient_name' => $red_green['patient_information_with_bed_details']['camis_patient_name'] ?? '',
                'camis_patient_ward' => $red_green['patient_information_with_bed_details']['ibox_ward_name'] ?? '',
                'camis_patient_bed' => $red_green['patient_information_with_bed_details']['ibox_actual_bed_full_name'] ?? '',
                'notification_type'  => $red_green['patient_red_green_status'] == 1 ? 5 : 6,
                'camis_patient_pas_number'  => $red_green['patient_information_with_bed_details']['camis_patient_pas_number'] ?? '',
            ];
        }

        foreach ($etl_notifications as $etl_notif) {
            $all_notification[] = $etl_notif;
        }

        // Allowed-to-Move (7)
        [$allowedToMove, $isNumericUserType] = $this->allowedToMoveNotifications($since);
        $all_notification = array_merge($all_notification, $allowedToMove);

        // If user_type is NON-numeric => show only type 7
        if (!$isNumericUserType) {
            $all_notification = array_values(array_filter($all_notification, fn($n) => ($n['notification_type'] ?? null) === 7));
        }

        // Exclude already acknowledged by me
        $my_notification = CamisIboxBoardRoundMovementNotification::where('updated_by', session()->get('LOGGED_USER_ID', ''))
            ->where('notification_time', '>=', $since)
            ->get()->toArray();

        $filtered_notifications = array_filter($all_notification, function ($notif) use ($my_notification) {
            foreach ($my_notification as $my_notif) {
                $notifTime   = Carbon::parse($notif['notification_time'])->format('Y-m-d H:i:s');
                $myNotifTime = Carbon::parse($my_notif['notification_time'])->format('Y-m-d H:i:s');
                if (
                    ($notif['notification_type'] ?? null) == $my_notif['notification_type'] &&
                    $notifTime == $myNotifTime &&
                    $notif['camis_patient_id'] == $my_notif['camis_patient_id']
                ) {
                    return false;
                }
            }
            return true;
        });

        // Build view data
        $data = [];
        $all_wards = Wards::pluck('ward_name', 'ward_short_name')->toArray();

        usort($filtered_notifications, fn($a, $b) => strtotime($b['notification_time']) <=> strtotime($a['notification_time']));

        foreach ($filtered_notifications as $notification) {
            $type = '';
            $string = '';
            $class = '';

            if ($notification['notification_type'] == 1) {
                $string = 'This Patient Has Been Admitted To ' . $all_wards[$notification['ward_moved_to']];
                $type = 'Admitted';
                $class = 'green-bg-notification';
            } elseif ($notification['notification_type'] == 2) {
                $string = 'This patient moved from ' . $all_wards[$notification['ward_moved_from']] . ' to ' . $all_wards[$notification['ward_moved_to']];
                $type = 'Move To';
                $class = 'primary-bg-notification';
            } elseif ($notification['notification_type'] == 3) {
                $string = 'This patient moved from ' . $all_wards[$notification['ward_moved_from']] . ' ' . $notification['bed_moved_from'] . ' to ' . $notification['bed_moved_to'];
                $type = 'Move To';
                $class = 'primary-bg-notification';
            } elseif ($notification['notification_type'] == 4) {
                $string = 'This patient discharged from ' . $all_wards[$notification['ward_moved_to']] . ' ' . $notification['bed_moved_to'];
                $type = 'Discharged';
                $class = 'green-bg-notification';
            } elseif ($notification['notification_type'] == 5) {
                $string = 'This patient marked as Red Bed. Current Bed & Ward : '
                    . $notification['camis_patient_ward']
                    . ' (' . $notification['camis_patient_bed'] . ')';
                $type = 'Red Green Bed';
                $class = 'danger-bg-notification';
            } elseif ($notification['notification_type'] == 6) {
                $string = 'This patient marked as Green Bed. Current Bed & Ward : '
                    . $notification['camis_patient_ward']
                    . ' (' . $notification['camis_patient_bed'] . ')';
                $type = 'Red Green Bed';
                $class = 'green-bg-notification';
            } elseif ($notification['notification_type'] == 7) {
                $to   = $notification['move_to']   ?? '';
                $camis_patient_bed = $notification['camis_patient_bed'] ?? '';
                $from = $notification['move_from'] ?? '';
                $cmt  = trim((string)($notification['move_comment'] ?? ''));
                $type = 'Allowed To Move';
                $class = 'warning-bg-notification'; // choose your CSS
                $string = 'Allowed to move from '
                    . ($all_wards[$from] ?? $from)
                    . ($camis_patient_bed !== '' ? " ({$camis_patient_bed})" : '')
                    . ' to '
                    . ($all_wards[$to] ?? $to)
                    . ($cmt !== '' ? ('. Comment: ' . $cmt) : '');
            }

            $data[] = [
                'notification_type'  => $notification['notification_type'],
                'patient_id'         => $notification['camis_patient_id'],
                'camis_patient_pas_number'         => $notification['camis_patient_pas_number'],
                'camis_patient_name' => $notification['camis_patient_name'] ?? '',
                'type'               => $type,
                'string'             => $string,
                'class'              => $class,
                'status'             => $notification['status'] ?? null,
                'action_time'        => $notification['action_time'] ?? null,
                'action_user'        => $notification['action_user'] ?? null,
                'status_formatted'   => $notification['status_formatted'] ?? null,
                'declined_reason'    => $notification['declined_reason'] ?? null,
                'can_receive'        => $notification['can_receive'] ?? false,
                'format_time'        => PatientLos($notification['notification_time']),
                'time'               => $notification['notification_time'],
            ];
        }
        $view = View::make('Common.Modals.Partials.SiteTeamNotificationData', compact('data'));
        return $view->render();
    }

    public function SingleApprove(Request $request)
    {
        $loggedUserId = session()->get('LOGGED_USER_ID', '');
        $userType = User::find($loggedUserId)->user_type ?? 0; // << required way
        $isNumeric = is_numeric($userType);

        // Non-numeric user type can ONLY approve type 7
        if (!$isNumeric && (int)$request->notification_type !== 7) {
            Toastr::error('Permission Denied');
            return back();
        }

        CamisIboxBoardRoundMovementNotification::create([
            'camis_patient_id'  => $request->patient_id,
            'notification_type' => $request->notification_type,
            'notification_time' => $request->notification_time,
            'updated_by'        => $loggedUserId,
        ]);

        // Re-render the drawer
        return $this->OffcanvasDataLoad($request);
    }


    public function MoveToNotificationAction(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundAllowedToMove";
        $date_time_now                                              = CurrentDateOnFormat();
        $ward_controller                                            = new WardSummaryController;
        $camis_patient_id                                           = $request->patient_id;
        if ($request->action == 'decline') {
            $data = ['declined_reason' => $request->reject_reason, 'declined_by' => Session()->get('LOGGED_USER_ID', ''), 'declined_time' => $date_time_now, 'status' => 2, 'accepted_by' => null, 'accepted_time' => null];
            $allowed_text = 'Allowed To Move Notifications Declined';
        } elseif ($request->action == 'accept') {
            $allowed_text = 'Allowed To Move Notifications Accepted';
            $data = ['accepted_by' => Session()->get('LOGGED_USER_ID', ''), 'accepted_time' => $date_time_now, 'status' => 1, 'declined_by' => null, 'declined_time' => null, 'declined_reason' => null];
        }


        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr        = CamisIboxBoardRoundAllowedToMove::where('patient_id', '=', $camis_patient_id)->first();
            $data['updated_at'] = $gov_text_before_arr->updated_at ?? $date_time_now;
            $updated_data = CamisIboxBoardRoundAllowedToMove::withoutTimestamps(function () use ($camis_patient_id, $data) {
                return CamisIboxBoardRoundAllowedToMove::updateOrCreate(
                    ['patient_id' => $camis_patient_id],
                    $data
                );
            });

            $functional_identity        = 'Allowed To Move Notifications';
            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundAllowedToMove::where('id', '=', $updated_array["id"])->first();
                    $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $allowed_text, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundAllowedToMove::where('id', '=', $updated_array["id"])->first();
                            $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $allowed_text, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $notification = CamisIboxBoardRoundAllowedToMove::with(['PatientInformationWithBedDetails' => function ($q) {
                $q->select('camis_patient_id', 'camis_patient_name', 'ibox_actual_bed_full_name', 'ibox_ward_name');
            }])->where('patient_id', $camis_patient_id)->first();
            $all_wards = Wards::pluck('ward_name', 'ward_short_name')->toArray();
            $from = $notification->patient_allowed_to_be_moved_from ?? '';
            $to   = $notification->patient_allowed_to_be_moved_to ?? '';
            $camis_patient_bed = $notification->patient_information_with_bed_details->ibox_actual_bed_full_name ?? '';
            $cmt  = trim((string)($notification->patient_allowed_to_be_moved_comment ?? ''));
            $string = 'Allowed to move from '
                . ($all_wards[$from] ?? $from)
                . ($camis_patient_bed !== '' ? " ({$camis_patient_bed})" : '')
                . ' to '
                . ($all_wards[$to] ?? $to)
                . ($cmt !== '' ? ('. Comment: ' . $cmt) : '');

            $patient_name = $notification['patient_information_with_bed_details']['camis_patient_name'] ?? '';
            $pass_number = $notification['patient_information_with_bed_details']['camis_patient_pas_number'] ?? '';
            $users = User::pluck('username', 'id')->toArray();
            $action_user = '';
            $action_time = '';
            $status_formatted = '';
            $declined_reason = '';
            if ($notification['status'] == 1) {
                $action_user = $users[$notification['accepted_by']] ?? '';
                $action_time = PredefinedDateFormatFor24Hour($notification['accepted_time']);
                $status_formatted = 'Accepted';
                $declined_reason = '';
            } else if ($notification['status'] == 2) {
                $action_user = $users[$notification['declined_by']] ?? '';
                $action_time = PredefinedDateFormatFor24Hour($notification['declined_time']);
                $status_formatted = 'Declined';
                $declined_reason = $notification['declined_reason'] ?? '';
            }

            $success_array['html'] = View::make('Common.Modals.Partials.AllowedToMoveNotificationCard', compact('notification', 'string', 'patient_name', 'pass_number', 'action_user', 'status_formatted', 'action_time', 'declined_reason'))->render();



            $success_array["updated_date"]                          = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["updated_date_show"]                     = date('jS M H:i', strtotime($date_time_now));

            $success_array["status"]                                = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }




    public function AllApprove(Request $request)
    {
        $since = Carbon::now()->subDay();
        $loggedUserId = session()->get('LOGGED_USER_ID', '');
        $userType = User::find($loggedUserId)->user_type ?? 0; // << required way
        $isNumeric = is_numeric($userType);

        $all_inpatients = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('ibox_ward_id', AllWardToIDArray())
            ->whereNotNull('camis_patient_id')
            ->pluck('camis_patient_id')
            ->toArray();

        // Red/Green
        $green_bed_patients = CamisIboxBoardRoundRedGreenBed::with(['PatientInformationWithBedDetails' => function ($q) {
            $q->select('camis_patient_id', 'camis_patient_name', 'ibox_ward_name', 'ibox_actual_bed_full_name');
        }])
            ->where('updated_at', '>=', $since)
            ->whereIn('patient_id', $all_inpatients)
            ->get()->toArray();

        // ETL
        $etl_notifications = CamisIboxPatientWardMovement::where('notification_time', '>=', $since)->get()->toArray();

        $all_notification = [];

        foreach ($green_bed_patients as $red_green) {
            $all_notification[] = [
                'camis_patient_id'   => $red_green['patient_id'],
                'notification_time'  => $red_green['updated_at'],
                'camis_patient_name' => $red_green['patient_information_with_bed_details']['camis_patient_name'] ?? '',
                'camis_patient_ward' => $red_green['patient_information_with_bed_details']['ibox_ward_name'] ?? '',
                'camis_patient_bed' => $red_green['patient_information_with_bed_details']['ibox_actual_bed_full_name'] ?? '',
                'notification_type'  => $red_green['patient_red_green_status'] == 1 ? 5 : 6,
            ];
        }

        foreach ($etl_notifications as $etl_notif) {
            $all_notification[] = $etl_notif;
        }

        // Allowed-to-Move
        [$allowedToMove, $isNumericUserType] = $this->allowedToMoveNotifications($since);
        // $isNumericUserType equals $isNumeric, but keep the helper’s return for clarity
        $all_notification = array_merge($all_notification, $allowedToMove);

        // Non-numeric => only type 7
        if (!$isNumericUserType) {
            $all_notification = array_values(array_filter($all_notification, fn($n) => ($n['notification_type'] ?? null) === 7));
        }

        // Filter out already approved
        $my_notification = CamisIboxBoardRoundMovementNotification::where('updated_by', $loggedUserId)
            ->where('notification_time', '>=', $since)
            ->get()->toArray();

        $filtered_notifications = array_filter($all_notification, function ($notif) use ($my_notification) {
            foreach ($my_notification as $my_notif) {
                $notifTime   = Carbon::parse($notif['notification_time'])->format('Y-m-d H:i:s');
                $myNotifTime = Carbon::parse($my_notif['notification_time'])->format('Y-m-d H:i:s');
                if (
                    ($notif['notification_type'] ?? null) == $my_notif['notification_type'] &&
                    $notifTime == $myNotifTime &&
                    $notif['camis_patient_id'] == $my_notif['camis_patient_id']
                ) {
                    return false;
                }
            }
            return true;
        });

        usort($filtered_notifications, fn($a, $b) => strtotime($b['notification_time']) <=> strtotime($a['notification_time']));

        foreach ($filtered_notifications as $notification) {
            if ($notification['notification_type'] == 7) {
                continue;
            }
            CamisIboxBoardRoundMovementNotification::create([
                'camis_patient_id'  => $notification['camis_patient_id'],
                'notification_type' => $notification['notification_type'],
                'notification_time' => $notification['notification_time'],
                'updated_by'        => $loggedUserId,
            ]);
        }

        Toastr::success('All Accepted');
        return redirect()->route('notification.index');
    }

    public function TopCount()
    {
        $since = Carbon::now()->subDay();
        $loggedUserId = session()->get('LOGGED_USER_ID', '');
        $userType = User::find($loggedUserId)->user_type ?? 0; // << required way
        $isNumeric = is_numeric($userType);

        $all_inpatients = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('ibox_ward_id', AllWardToIDArray())
            ->whereNotNull('camis_patient_id')
            ->pluck('camis_patient_id')
            ->toArray();

        // Red/Green
        $green_bed_patients = CamisIboxBoardRoundRedGreenBed::with(['PatientInformationWithBedDetails' => function ($q) {
            $q->select('camis_patient_id', 'camis_patient_name');
        }])
            ->where('updated_at', '>=', $since)
            ->whereIn('patient_id', $all_inpatients)
            ->get()->toArray();

        // ETL
        $etl_notifications = CamisIboxPatientWardMovement::where('notification_time', '>=', $since)->get()->toArray();

        $all_notification = [];

        foreach ($green_bed_patients as $red_green) {
            $all_notification[] = [
                'camis_patient_id'   => $red_green['patient_id'],
                'notification_time'  => $red_green['updated_at'],
                'camis_patient_name' => $red_green['patient_information_with_bed_details']['camis_patient_name'] ?? '',
                'notification_type'  => $red_green['patient_red_green_status'] == 1 ? 5 : 6,
            ];
        }
        foreach ($etl_notifications as $etl_notif) {
            $all_notification[] = $etl_notif;
        }

        // Allowed-to-Move
        [$allowedToMove, $isNumericUserType] = $this->allowedToMoveNotifications($since);
        $all_notification = array_merge($all_notification, $allowedToMove);

        // Non-numeric => only type 7
        if (!$isNumericUserType) {
            $all_notification = array_values(array_filter($all_notification, fn($n) => ($n['notification_type'] ?? null) === 7));
        }

        // Remove already acknowledged
        $my_notification = CamisIboxBoardRoundMovementNotification::where('updated_by', $loggedUserId)
            ->where('notification_time', '>=', $since)
            ->get()->toArray();

        $filtered_notifications = array_filter($all_notification, function ($notif) use ($my_notification) {
            foreach ($my_notification as $my_notif) {
                $notifTime   = Carbon::parse($notif['notification_time'])->format('Y-m-d H:i:s');
                $myNotifTime = Carbon::parse($my_notif['notification_time'])->format('Y-m-d H:i:s');
                if (
                    ($notif['notification_type'] ?? null) == $my_notif['notification_type'] &&
                    $notifTime == $myNotifTime &&
                    $notif['camis_patient_id'] == $my_notif['camis_patient_id']
                ) {
                    return false;
                }
            }
            return true;
        });

        return str_pad((int)count($filtered_notifications), 2, '0', STR_PAD_LEFT);
    }

    public function IndexDataload(Request $request)
    {
        if ($request->filled('date')) {
            $start_date = Carbon::parse($request->date)->startOfDay()->addSecond();
            $end_date   = Carbon::parse($request->date)->endOfDay();
        } else {
            $start_date = Carbon::now()->startOfDay()->addSecond();
            $end_date   = Carbon::now()->endOfDay();
        }

        $loggedUserId = session()->get('LOGGED_USER_ID', '');
        $userType = User::find($loggedUserId)->user_type ?? 0; // << required way
        $isNumeric = is_numeric($userType);

        $all_inpatients = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('ibox_ward_id', AllWardToIDArray())
            ->whereNotNull('camis_patient_id')
            ->pluck('camis_patient_id')
            ->toArray();

        // Red/Green (5/6)
        $green_bed_patients = CamisIboxBoardRoundRedGreenBed::with(['PatientInformationWithBedDetails' => function ($q) {
            $q->select('camis_patient_id', 'camis_patient_name', 'ip_admission_type_description', 'camis_patient_pas_number', 'ibox_ward_name', 'ibox_actual_bed_full_name');
        }])
            ->whereBetween('updated_at', [$start_date, $end_date])
            ->whereIn('patient_id', $all_inpatients)
            ->when($request->filled('type'), function ($query) use ($request) {
                if ($request->type == 5) {
                    return $query->where('patient_red_green_status', 1);
                } else {
                    return $query->where('patient_red_green_status', 2);
                }
            })
            ->get()->toArray();

        // ETL (1..4)
        $etl_notifications = CamisIboxPatientWardMovement::whereBetween('notification_time', [$start_date, $end_date])
            ->when($request->filled('search_text'), function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('camis_patient_id', 'LIKE', '%' . $request->search_text . '%')
                        ->orWhere('camis_patient_name', 'LIKE', '%' . $request->search_text . '%');
                });
            })
            ->when($request->filled('type'), function ($query) use ($request) {
                return $query->where('notification_type', $request->type);
            })
            ->get()->toArray();

        $all_notification = [];

        // Red/Green push into combined list
        foreach ($green_bed_patients as $patient) {
            $details = $patient['patient_information_with_bed_details'] ?? [];
            if (empty($details['camis_patient_id'])) continue;

            if ($request->filled('search_text')) {
                $t = $request->search_text;
                $idMatch   = stripos($patient['patient_id'], $t) !== false;
                $nameMatch = stripos($details['camis_patient_name'] ?? '', $t) !== false;
                if (!$idMatch && !$nameMatch) continue;
            }

            $all_notification[] = [
                'camis_patient_id'                => $patient['patient_id'],
                'notification_time'               => $patient['updated_at'],
                'ip_admission_type_description'   => $details['ip_admission_type_description'] ?? '',
                'camis_patient_name'              => $details['camis_patient_name'] ?? '',
                'notification_type'               => $patient['patient_red_green_status'] == 1 ? 5 : 6,
                'camis_patient_pas_number'        => $details['camis_patient_pas_number'] ?? '',
                'camis_patient_ward' => $details['ibox_ward_name'] ?? '',
                'camis_patient_bed' => $details['ibox_actual_bed_full_name'] ?? '',
                'status'             => 0,
                'action_time'        => '',
                'action_user'        => '',
                'status_formatted'   => '',
                'declined_reason'    => '',
                'can_receive'    => '',
            ];
        }

        // ETL push
        foreach ($etl_notifications as $etl_notif) {
            $all_notification[] = $etl_notif;
        }

        // Allowed-to-Move (type 7), filtered for current user
        [$allowedToMove, $isNumericUserType] = $this->allowedToMoveNotifications($start_date, $end_date);

        // Apply search & "type" filters for type 7 too
        $allowedToMove = array_values(array_filter($allowedToMove, function ($n) use ($request) {
            if ($request->filled('type') && (int)$request->type !== 7) return false;
            if ($request->filled('search_text')) {
                $t = $request->search_text;
                $idMatch   = stripos((string)$n['camis_patient_id'], $t) !== false;
                $nameMatch = stripos((string)($n['camis_patient_name'] ?? ''), $t) !== false;
                if (!$idMatch && !$nameMatch) return false;
            }
            return true;
        }));

        $all_notification = array_merge($all_notification, $allowedToMove);

        // Non-numeric user => only type 7
        if (!$isNumericUserType) {
            $all_notification = array_values(array_filter($all_notification, fn($n) => ($n['notification_type'] ?? null) === 7));
        }

        // Build response rows
        $data = [];
        $all_wards = Wards::pluck('ward_name', 'ward_short_name')->toArray();

        usort($all_notification, fn($a, $b) => strtotime($b['notification_time']) <=> strtotime($a['notification_time']));

        foreach ($all_notification as $notification) {
            $string = '';
            $type = '';

            if ($notification['notification_type'] == 1) {
                $string = 'This Patient Has Been Admitted To ' . $all_wards[$notification['ward_moved_to']];
                $type = 'Admitted';
            } elseif ($notification['notification_type'] == 2) {
                $string = 'This patient moved from ' . $all_wards[$notification['ward_moved_from']] . ' to ' . $all_wards[$notification['ward_moved_to']];
                $type = 'Move To';
            } elseif ($notification['notification_type'] == 3) {
                $string = 'This patient moved from ' . $all_wards[$notification['ward_moved_from']] . ' ' . $notification['bed_moved_from'] . ' to ' . $notification['bed_moved_to'];
                $type = 'Move To';
            } elseif ($notification['notification_type'] == 4) {
                $string = 'This patient discharged from ' . $all_wards[$notification['ward_moved_to']] . ' ' . $notification['bed_moved_to'];
                $type = 'Discharged';
            } elseif ($notification['notification_type'] == 5) {
                $string = 'This patient marked as Red Bed. Current Bed & Ward : '
                    . $notification['camis_patient_ward']
                    . ' (' . $notification['camis_patient_bed'] . ')';
                $type = 'Red Green Bed';
            } elseif ($notification['notification_type'] == 6) {
                $string = 'This patient marked as Green Bed. Current Bed & Ward : '
                    . $notification['camis_patient_ward']
                    . ' (' . $notification['camis_patient_bed'] . ')';
                $type = 'Red Green Bed';
            } elseif ($notification['notification_type'] == 7) {
                $to   = $notification['move_to']   ?? '';
                $from = $notification['move_from'] ?? '';
                $camis_patient_bed = $notification['camis_patient_bed'] ?? '';
                $cmt  = trim((string)($notification['move_comment'] ?? ''));
                $type = 'Allowed To Move';
                $string = 'Allowed to move from '
                    . ($all_wards[$from] ?? $from)
                    . ($camis_patient_bed !== '' ? " ({$camis_patient_bed})" : '')
                    . ' to '
                    . ($all_wards[$to] ?? $to)
                    . ($cmt !== '' ? ('. Comment: ' . $cmt) : '');
            }

            $data[] = [
                'admission_type'           => $notification['ip_admission_type_description'] ?? '',
                'camis_patient_pas_number' => $notification['camis_patient_pas_number'] ?? '',
                'camis_patient_id'         => $notification['camis_patient_id'],
                'status'                   => $notification['status'] ?? null,
                'action_time'             => $notification['action_time'] ?? null,
                'action_user'           => $notification['action_user'] ?? null,
                'status_formatted'      => $notification['status_formatted'] ?? null,
                'declined_reason'       => $notification['declined_reason'] ?? null,
                'can_receive'            => $notification['can_receive'] ?? false,
                'camis_patient_name'       => $notification['camis_patient_name'] ?? '',
                'notification_time'        => $notification['notification_time'],
                'action'                   => $type,
                'string'                   => $string,
            ];
        }

        $view = View::make('Common.View.Notification.IndexDataLoad', compact('data'));
        return $view->render();
    }
}
