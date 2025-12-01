<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Common\HistoryController;
use App\Http\Controllers\Controller;
use App\Models\Common\User;
use App\Models\History\HistoryCamisIboxBoardRoundDischargeComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundDischargeComment;
use App\Models\Iboards\Camis\Data\CamisIboxPatientInformationDetails;
use App\Models\Iboards\Camis\Master\DischargeTrackerDropdown;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsFullList;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class DischargesPatientController extends Controller
{
    public function GetIndex()
    {
        if (CheckDashboardPermission('discharged_patient_is_view_dashbaord_view')) {
            return view('Dashboards.Camis.DischargePatient.Index');
        } elseif (CheckDashboardPermission('site_office_report_view')) {
            return redirect()->route('site.office');
        } elseif (CheckDashboardPermission('flow_dashboard_patient_search_view')) {
            return redirect()->route('global.patient.search');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }


    public function IndexRefreshDataLoad(Request $request)
    {
        $process_array                                                  = array();
        $success_array                                                  = array();

        if ($request->date != null) {
            $process_array['date']                             = Carbon::parse($request->date);
        } else {
            $process_array['date']                             = Carbon::now();
        }
        if ($request->ward_id != null) {

            $process_array['ward_id']                                   = $request->ward_id;
        } else {
            $process_array['ward_id']                                   = 'all';
        }

        if ($request->search_input != null) {
            $process_array['date']                                          = null;
            $process_array['ward_id']                                       = 'all';
            $process_array['search_input']                                  = $request->search_input;
        } else {
            $process_array['search_input']                                   = null;
        }
        if (CheckAnyPermission(['discharged_patient_is_view_dashbaord_view'])) {
            $this->PageDataLoad($process_array, $success_array);
        } else {
            return PermissionDenied();
        }
        $success_array['discharge_tracker_dropdown'] = DischargeTrackerDropdown::where('status', 1)->get();

        $view                                                           = View::make('Dashboards.Camis.DischargePatient.IndexDataLoad', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }
    public function PageDataLoad(&$process_array, &$success_array)
    {

        $success_array                                  = array();
        $success_array["script_error_message"]          = ErrorOccuredMessage();
        $wards = Wards::where('status', 1)->get();
        if ($process_array['ward_id'] == 'all') {
            $ward_id = AllWardToIDArray();
        } else {
            $ward_id = $process_array['ward_id'];
        }
        $searchTerm = $process_array['search_input'];
        $all_wards                              = Wards::where('status', '=', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();

        $patient_array = CamisIboxWardPatientInformationWithBedDetailsFullList::whereIn('camis_patient_ward_id', $ward_id)
            ->whereNotNull('camis_patient_discharge_date_time')
            ->when(!empty($searchTerm), function ($query) use ($searchTerm) {
                return $query->where(function ($q) use ($searchTerm) {
                    $q->where('camis_patient_id', 'like', "%{$searchTerm}%")
                        ->orWhere('camis_patient_name', 'like', "%{$searchTerm}%")
                        ->orWhere('camis_patient_pas_number', 'like', "%{$searchTerm}%");
                });
            })
            ->when(empty($searchTerm) && !empty($process_array['date']), function ($query) use ($process_array) {
                return $query->whereDate('camis_patient_discharge_date_time', $process_array['date']);

            })
            ->select(['camis_patient_id', 'camis_patient_ward', 'camis_patient_admission_date_time', 'camis_patient_discharge_date_time', 'camis_patient_sex', 'camis_patient_name', 'camis_patient_pas_number', 'camis_patient_discharge_destination'])
            ->with([ 'DischargeAssignedData:camis_patient_id,dt_drop_id,id', 'OtherNotes:id,patient_id,discharge_comment' ])
            ->get()->toArray();



        $success_array['all_wards']      = Wards::where('status', 1)->pluck('ward_name', 'ward_short_name')->toArray();
        $success_array['discharges_from_cdt_count'] = count($patient_array);
        $ward_wise_patients = array_reduce($patient_array, function ($carry, $item) use ($success_array) {
            $ward_short_name = $item['camis_patient_ward'];
            $ward_name = $success_array['all_wards'][$ward_short_name] ?? 'Unknown Ward';

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);

        ksort($ward_wise_patients);
        $success_array['total_patients']      = $patient_array;
        $success_array['patient_details']     = $ward_wise_patients;
        $success_array['date']           = $process_array['date'];
        $success_array['wards']          = $wards;



        return $success_array;
    }



    public function Modal($id)
    {
        $patient_array      = CamisIboxPatientInformationDetails::with([
            'BoardRoundPatientTasks' => function ($q) {
                $q->where('task_completed_status', 1)->get();
            },
            'BoardRoundCareRequirement' => function ($q) {
                $q->with('PathwayGroup');
            },
            'BoardRoundPathwayRequirement' => function ($q) {
                $q->with('DtocPathway', 'DtocAuthority', 'DtocStatus');
            },
            'BoardRoundAdmittingReason',
            'BoardRoundSocialHistory',
            'BoardRoundPatientGoal',
            'BoardRoundSocialHistory',
            'PatientWiseFlags',
            'BoardRoundPharmacyData',
            'PatientHandOver',
            'BoardRoundMedicallyFitData',
            'BoardRoundDtocComments',

            'PotentialDefinite',

        ])->where('camis_patient_id', $id)
            ->first();

        return view('Common.View.CommonDischargeSummaryData', compact('patient_array'));
    }

    public function ModalPrint($id)
    {
        $patient_array      = CamisIboxPatientInformationDetails::with([
            'BoardRoundPatientTasks' => function ($q) {
                $q->where('task_completed_status', 1)->get();
            },
            'BoardRoundCareRequirement' => function ($q) {
                $q->with('PathwayGroup');
            },
            'BoardRoundPathwayRequirement' => function ($q) {
                $q->with('DtocPathway', 'DtocAuthority', 'DtocStatus');
            },
            'BoardRoundAdmittingReason',
            'BoardRoundSocialHistory',
            'BoardRoundPatientGoal',
            'BoardRoundPastMedicalHistory',
            'PatientWiseFlags',
            'BoardRoundPharmacyData',
            'PatientHandOver',
            'BoardRoundMedicallyFitData',
            'BoardRoundDtocComments',

            'PotentialDefinite'
        ])->where('camis_patient_id', $id)
            ->first();


        return view('Common.View.CommonDischargeSummaryPrint', compact('patient_array'));
    }


    public function GetCommentHistory(Request $request)
    {
        $camis_patient_id = $request->camis_patient_id;
        $users = User::pluck('username', 'id')->toArray();
        $history_status = [
            1 => 'Added',
            2 => 'Updated',
            3 => 'Deleted'
        ];
        $current_comment  = CamisIboxBoardRoundDischargeComment::where('patient_id', $camis_patient_id)->first()->discharge_comment ?? '';
        $comments_list = HistoryCamisIboxBoardRoundDischargeComment::where('patient_id', $camis_patient_id)->orderBy('updated_at', 'desc')->get()->toArray();
        $view                                                           = View::make('Dashboards.Camis.DischargePatient.Partials.CommentModalData', compact('camis_patient_id', 'comments_list', 'users', 'history_status'));
        $sections                                                       = $view->render();
        $success_array["sections"]                                      = $sections;
        $success_array["current_comment"]                             = $current_comment;
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function SaveCommentHistory(Request $request)
    {

        $history_controller                                         = new HistoryController;
        $ward_controller                                            = new WardSummaryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundDischargeComment";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $discharge_comment                                          = $request->comment;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $success_array["discharge_comment"]                         = $discharge_comment;
        $functional_identity                                    = 'Discharges Comment';

        if ($camis_patient_id != "" && $user_id != "") {
            if ($discharge_comment != '') {
                $gov_text_before_arr                                    = CamisIboxBoardRoundDischargeComment::where('patient_id', '=', $camis_patient_id)->first();
                $updated_data                                           = CamisIboxBoardRoundDischargeComment::updateOrCreate(['patient_id' => $camis_patient_id], ['discharge_comment' => $discharge_comment, 'updated_by' => $user_id]);

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundDischargeComment::where('id', '=', $updated_array["id"])->first();
                        $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $discharge_comment, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {

                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundDischargeComment::where('id', '=', $updated_array["id"])->first();
                                $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $discharge_comment, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            } else {
                $gov_text_before_arr                                    = CamisIboxBoardRoundDischargeComment::where('patient_id', '=', $camis_patient_id)->first();
                if ($gov_text_before_arr) {

                    $updated_data                                    = $gov_text_before_arr;
                    $history_controller->HistoryTableDataInsertFromDelete($updated_data->toArray(), $history_modal, 3);
                    $success_array["message"]                        = DataRemovalMessage();
                    $gov_text_before                                 = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                              = array();
                    $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                    CamisIboxBoardRoundDischargeComment::where('patient_id', '=', $camis_patient_id)->delete();
                }
            }
            $success_array["status"]                                    = 1;
        }
        $users = User::pluck('username', 'id')->toArray();
        $history_status = [
            1 => 'Added',
            2 => 'Updated',
            3 => 'Deleted'
        ];
        $comments_list = HistoryCamisIboxBoardRoundDischargeComment::where('patient_id', $camis_patient_id)->orderBy('updated_at', 'desc')->get()->toArray();
        $view                                                           = View::make('Dashboards.Camis.DischargePatient.Partials.PartialCommentData', compact('camis_patient_id', 'comments_list', 'users', 'history_status'));
        $success_array["sections"]                                      = $view->render();
        return ReturnArrayAsJsonToScript($success_array);
    }
}
