<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Common\CommonReportController;
use App\Models\History\HistoryCamisIboxBoardRoundDischargeComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundCDT;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundDischargeComment;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Governance\GovernanceController;
use App\Http\Controllers\Common\HistoryController;
use App\Models\Common\IboxDashboards;
use App\Models\Common\IboxSettings;
use App\Models\Common\IboxUserDtocMenu;
use App\Models\Common\User;
use App\Models\Iboards\Camis\Master\DtocAuthority;
use App\Models\Iboards\Camis\Master\DtocCurrentService;
use App\Models\Iboards\Camis\Master\DtocCurrentStatus;
use App\Models\Iboards\Camis\Master\DtocPathway;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\Master\DischargeTrackerDropdown;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundDtocComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundCareRequirement;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPathwayRequirement;
use App\Models\Iboards\Camis\Data\CamisIboxDischargeAssigned;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsFullList;
use App\Models\Governance\GovernanceFrontendCamisOperationLogs;
use App\Models\Iboards\Camis\Data\CamisIboxPatientInformationDetails;
use App\Models\Iboards\Camis\Master\DtocServiceByPathway;
use App\Models\History\HistoryCamisIboxBoardDtocComment;
use App\Models\History\HistoryCamisIboxBoardRoundCDTComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundCDTComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundEDReferral;
use App\Models\Iboards\Camis\Data\CamisIboxDtocMonthlyStored;
use App\Models\Iboards\Camis\Master\ReasonToResideGroup;
use App\Models\Iboards\Camis\View\CamisIboxWardWeeklyDischarge;
use App\Models\Iboards\Symphony\View\SymphonyAttendanceView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Brian2694\Toastr\Facades\Toastr;

class DischargeTrackerController extends Controller
{

    public $common_report_controller;
    public function __construct(CommonReportController $common_report_controller)
    {
        $this->common_report_controller = $common_report_controller;
    }
    public function ReferralTab()
    {
        if (CheckDashboardPermission('discharge_tracker_referral_view')) {
            $success_array['reason_to_reside']                              = ReasonToResideGroup::where('status', 1)->get();

            return view('Dashboards.Camis.DischargeTracker.Referral', compact('success_array'));
        } elseif (CheckDashboardPermission('discharge_tracker_complex_discharge_view')) {
            return redirect()->route('discharged.index');
        } elseif (CheckDashboardPermission('discharge_tracker_medfit_')) {
            return redirect()->route('discharged.medfit');
        } elseif (CheckDashboardPermission('discharge_tracker_month_summary_view')) {
            return redirect()->route('discharged.month.summary');
        } elseif (CheckDashboardPermission('discharge_tracker_month_list_summary_view')) {
            return redirect()->route('discharged.monthlist.summary');
        } elseif (CheckDashboardPermission('discharge_tracker_patient_search_view')) {
            return redirect()->route('discharged.patient.search');
        } elseif (CheckDashboardPermission('discharge_tracker_discharge_view')) {
            return redirect()->route('discharged.dischargepatient');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }


    public function ReferralDataLoad(Request $request)
    {
        $cdt_patients = CamisIboxBoardRoundCDT::when($request->tab == 'pending', function ($q) {
            return $q->where('cdt_status', 0);
        })->when($request->tab == 'review', function ($q) {
            return $q->where('cdt_status', 2);
        })->when($request->tab == 'reject', function ($q) {
            return $q->where('cdt_status', 3);
        })->pluck('patient_id')->toArray();
        $wards = Wards::where('status', 1)->orderBy('ward_name', 'asc')->pluck('ward_name', 'id')->toArray();


        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();



        $patients_list = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $cdt_patients)->whereIn('ibox_ward_id', $wards_ids)->with(['BoardRoundCdt', 'BoardRoundCDTCommentHistory', 'BoardRoundMedicallyFitData'])

            ->when($request->filled('ward_id'), function ($q) use ($request) {
                $q->whereIn('camis_patient_ward_id', $request->ward_id);
            })
            ->unless($request->filled('ward_id'), function ($q) {
                $q->whereIn('camis_patient_ward_id', AllWardToIDArray());
            })->when($request->filled('search_text'), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('camis_patient_pas_number', 'like', "%{$request->search_text}%");
                    $q->orWhere('camis_patient_forename', 'like', "%{$request->search_text}%");
                    $q->orWhere('camis_patient_surname', 'like', "%{$request->search_text}%");
                    $q->orWhere('camis_patient_id', 'like', "%{$request->search_text}%");
                    $q->orWhere('camis_patient_name', 'like', "%{$request->search_text}%");
                });
            })


            ->select('ibox_actual_bed_full_name', 'camis_patient_sex', 'camis_patient_name', 'camis_patient_pas_number', 'camis_consultant_name', 'camis_patient_admission_date_time', 'ibox_ward_name', 'camis_patient_id')
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_number', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')->get()->toArray();


        $patients = array_reduce($patients_list, function ($carry, $item) {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($patients);
        $tab = $request->tab;
        $success_array['reason_to_reside']                              = ReasonToResideGroup::where('status', 1)->get();

        if ($request->tab == 'pending') {
            $view = View::make('Dashboards.Camis.DischargeTracker.Partials.CdtReferralPending', compact('patients', 'tab', 'wards', 'success_array'));
        } elseif ($request->tab == 'review') {
            $view = View::make('Dashboards.Camis.DischargeTracker.Partials.CdtReferralReview', compact('patients', 'tab', 'wards', 'success_array'));
        } elseif ($request->tab == 'reject') {
            $view = View::make('Dashboards.Camis.DischargeTracker.Partials.CdtReferralReject', compact('patients', 'tab', 'wards', 'success_array'));
        }

        $sections = $view->render();
        return $sections;
    }

    public function ReferralSaveStatus(Request $request)
    {
        $camis_patient_id   =  $request->camis_patient_id;
        $cdt_status   =  $request->status;
        $cdt_comments = $request->cdt_comments;
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundCDT";
        $date_time_now                                              = CurrentDateOnFormat();
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $username                                                   = Sentinel::findById($user_id)->username ?? '';

        $success_array["date_time"]                                 = CurrentDateOnFormat();
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        if ($camis_patient_id != "" && $user_id != "") {


            $gov_text_before_arr                                    = CamisIboxBoardRoundCDT::where('patient_id', '=', $camis_patient_id)->first();

            $updated_data                                           = $gov_text_before_arr;
            $updated_data->cdt_status                               = $cdt_status;

            if ($cdt_status == 2) {
                $updated_data->to_be_review_date                    = $date_time_now;
                $updated_data->reviewed_by_username                 = $username;
                $updated_data->reviewed_by                          = $user_id;
                $gov_status                                         = 'To Be Reviewed';
            } else if ($cdt_status == 3) {
                $updated_data->rejected_date                        = $date_time_now;
                $updated_data->rejected_by                          = $user_id;
                $updated_data->rejected_by_username                 = $username;
                $gov_status                                         = 'Rejected';
            } else if ($cdt_status == 1) {
                $updated_data->accepted_date                        = $date_time_now;
                $updated_data->accepted_by                          = $user_id;
                $updated_data->accepted_by_username                 = $username;
                $gov_status                                         = 'Accepted';
            }

            $updated_data->updated_by                               = $user_id;
            $updated_data->updated_by_username                      = $username;
            $updated_data->save();
            $functional_identity                                    = 'CDT Status';

            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
            $success_array["message"]                           = DataUpdatedMessage();

            $updated_array                                  = $updated_data->getOriginal();
            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                if ($gov_text_before_arr) {
                    $gov_text_before                        = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                     = CamisIboxBoardRoundCDT::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_status, $gov_text_after_arr, $functional_identity, 2);
                }
            }



            if ($cdt_comments != '') {
                $history_modal                                          = "App\Models\History\HistoryCamisIboxBoardRoundCDTComment";
                $gov_text_before_arr                                    = array();
                $updated_data                                           = ['patient_id' => $camis_patient_id, 'cdt_comment' => $cdt_comments, 'updated_by' => $user_id];
                $get_id                                                 = CamisIboxBoardRoundCDTComment::insertGetId($updated_data);
                $functional_identity                                    = 'Patient CDT Comments';
                if ($get_id  != '' && $get_id > 0) {
                    $updated_data                                       = CamisIboxBoardRoundCDTComment::updateOrCreate(['id' => $get_id], ['patient_id' => $camis_patient_id]);
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $gov_text_before                                    = array();
                    $gov_text_after_arr                                 = CamisIboxBoardRoundCDTComment::where('id', '=', $get_id)->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $cdt_comments, $gov_text_after_arr, $functional_identity, 1);
                }
                $success_array["message"]          = DataAddedMessage();
            }
        }


        $cdt_patients = CamisIboxBoardRoundCDT::when($request->tab == 'pending', function ($q) {
            return $q->where('cdt_status', 0);
        })->when($request->tab == 'review', function ($q) {
            return $q->where('cdt_status', 2);
        })->when($request->tab == 'reject', function ($q) {
            return $q->where('cdt_status', 3);
        })->pluck('patient_id')->toArray();
        $wards = Wards::where('status', 1)->orderBy('ward_name', 'asc')->pluck('ward_name', 'id')->toArray();
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();

        $patients_list = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $cdt_patients)->whereIn('ibox_ward_id', $wards_ids)->with(['BoardRoundCdt', 'BoardRoundCDTComment'])->when($request->filled('ward_id'), function ($q) use ($request) {
            $q->whereIn('camis_patient_ward_id', $request->ward_id);
        })
            ->unless($request->filled('ward_id'), function ($q) {
                $q->whereIn('camis_patient_ward_id', AllWardToIDArray());
            })
            ->select('ibox_actual_bed_full_name', 'camis_patient_sex', 'camis_patient_name', 'camis_patient_pas_number', 'camis_consultant_name', 'camis_patient_admission_date_time', 'ibox_ward_name', 'camis_patient_id')
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_number', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')->get()->toArray();


        $patients = array_reduce($patients_list, function ($carry, $item) {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($patients);
        $tab = $request->tab;
        if ($request->tab == 'pending') {
            $view = View::make('Dashboards.Camis.DischargeTracker.Partials.CdtReferralPending', compact('patients', 'tab', 'wards', 'success_array'));
        } elseif ($request->tab == 'review') {
            $view = View::make('Dashboards.Camis.DischargeTracker.Partials.CdtReferralReview', compact('patients', 'tab', 'wards', 'success_array'));
        } elseif ($request->tab == 'reject') {
            $view = View::make('Dashboards.Camis.DischargeTracker.Partials.CdtReferralReject', compact('patients', 'tab', 'wards', 'success_array'));
        }
        $success_array["html"] = $view->render();
        return ReturnArrayAsJsonToScript($success_array);
    }


    public function RemovedPatientFormCDT(Request $request)
    {

        $camis_patient_id   =  $request->camis_patient_id;
        $cdt_status   =  $request->status;
        $cdt_comments = $request->cdt_comments;
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundCDT";
        $date_time_now                                              = CurrentDateOnFormat();
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $username                                                   = Sentinel::findById($user_id)->username ?? '';

        $success_array["date_time"]                                 = CurrentDateOnFormat();
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        if ($camis_patient_id != "" && $user_id != "") {


            $gov_text_before_arr                                    = CamisIboxBoardRoundCDT::where('patient_id', '=', $camis_patient_id)->first();

            $updated_data                                           = $gov_text_before_arr;
            $updated_data->cdt_status                               = $cdt_status;

            if ($cdt_status == 4) {
                $updated_data->removed_at                           = $date_time_now;
                $updated_data->removed_by_username                 = $username;
                $updated_data->removed_by                          = $user_id;
            }

            $updated_data->updated_by                               = $user_id;
            $updated_data->updated_by_username                      = $username;
            $updated_data->save();
            $functional_identity                                    = 'CDT Status';

            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
            $success_array["message"]                           = DataUpdatedMessage();

            $updated_array                                  = $updated_data->getOriginal();
            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                if ($gov_text_before_arr) {
                    $gov_text_before                        = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                     = CamisIboxBoardRoundCDT::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Removed', $gov_text_after_arr, $functional_identity, 2);
                }
            }
            if ($cdt_comments != '') {
                $history_modal                                          = "App\Models\History\HistoryCamisIboxBoardRoundCDTComment";
                $gov_text_before_arr                                    = array();
                $updated_data                                           = ['patient_id' => $camis_patient_id, 'cdt_comment' => $cdt_comments, 'updated_by' => $user_id];
                $get_id                                                 = CamisIboxBoardRoundCDTComment::insertGetId($updated_data);
                $functional_identity                                    = 'Patient CDT Comments';
                if ($get_id  != '' && $get_id > 0) {
                    $updated_data                                       = CamisIboxBoardRoundCDTComment::updateOrCreate(['id' => $get_id], ['patient_id' => $camis_patient_id]);
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $gov_text_before                                    = array();
                    $gov_text_after_arr                                 = CamisIboxBoardRoundCDTComment::where('id', '=', $get_id)->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $cdt_comments, $gov_text_after_arr, $functional_identity, 1);
                }
                $success_array["message"]          = DataAddedMessage();
            }

            $success_array["status"]    = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }


    public function Index()
    {

        if (CheckDashboardPermission('discharge_tracker_complex_discharge_view')) {
            $success_array['reason_to_reside']                              = ReasonToResideGroup::where('status', 1)->get();

            return view('Dashboards.Camis.DischargeTracker.Index', compact('success_array'));
        } elseif (CheckDashboardPermission('discharge_tracker_medfit_')) {
            return redirect()->route('discharged.medfit');
        } elseif (CheckDashboardPermission('discharge_tracker_month_summary_view')) {
            return redirect()->route('discharged.month.summary');
        } elseif (CheckDashboardPermission('discharge_tracker_month_list_summary_view')) {
            return redirect()->route('discharged.monthlist.summary');
        } elseif (CheckDashboardPermission('discharge_tracker_patient_search_view')) {
            return redirect()->route('discharged.patient.search');
        } elseif (CheckDashboardPermission('discharge_tracker_discharge_view')) {
            return redirect()->route('discharged.dischargepatient');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }

    public function DischargeTrackerDataLoad(Request $request)
    {

        $success_array = [];

        $pathway_patients = [];

        $patient_ids = CamisIboxBoardRoundCDT::where('cdt_status', 1)->pluck('patient_id')->toArray();

        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();
        $base_query = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')
            ->where('ibox_bed_type', 'Bed')
            ->whereIn('ibox_ward_id', $wards_ids)
            ->where('ibox_ward_short_name', '!=', 'XXTW')
            ->whereNull('camis_patient_discharge_date_time')
            ->with([
                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                },
                'BoardRoundEstimatedDischargeDate' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
                },
                'BoardRoundDtocComments' => function ($q) {
                    $q->orderBy('created_at', 'desc');
                },
                'BoardRoundPathwayRequirement.DtocPathway',
                'BoardRoundPathwayRequirement.DtocAuthority',
                'BoardRoundPathwayRequirement.DtocStatus',
                'BoardRoundReasonToReside.ReasonToResideCategory',
                'PotentialDefinite',
                'PatientWiseFlags',
                'BoardRoundEdn',
                'BoardRoundTto',
                'PatientVitalPacInfo',
                'BoardRoundCdt'
            ])
            ->whereIn('camis_patient_id', $patient_ids)
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_number', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')
            ->limit(1500);

        $all_patients = $base_query->get();





        $filtered_patients = [];

        foreach ($all_patients as $patient) {

            $patientArr = $patient->toArray();

            if ($request->filled('medfit')) {

                $selected = $request->medfit;
                $medfit_status = $patientArr['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null;

                if (in_array(1, $selected) && in_array(0, $selected)) {
                } elseif (in_array(1, $selected) && !in_array(0, $selected)) {
                    if ($medfit_status != 1) {
                        continue;
                    }
                } elseif (in_array(0, $selected) && !in_array(1, $selected)) {
                    if ($medfit_status == 1) {
                        continue;
                    }
                } else {
                    continue;
                }
            }


            if ($request->filled('pathway_id')) {
                $pathway_id = $patientArr['board_round_pathway_requirement']['dtoc_pathway_id'] ?? null;
                if (in_array('blank', $request->pathway_id)) {
                    if (!empty($pathway_id) && !in_array($pathway_id, $request->pathway_id)) {
                        continue;
                    }
                } else {
                    if (!in_array($pathway_id, $request->pathway_id)) {
                        continue;
                    }
                }
            }

            if ($request->filled('authority_id')) {
                $auth_id = $patientArr['board_round_pathway_requirement']['service_id'] ?? null;
                if (in_array('blank', $request->authority_id)) {
                    if (!empty($auth_id) && !in_array($auth_id, $request->authority_id)) {
                        continue;
                    }
                } else {
                    if (!in_array($auth_id, $request->authority_id)) {
                        continue;
                    }
                }
            }

            if ($request->filled('service_id')) {
                $service_id = $patientArr['board_round_pathway_requirement']['service_by_pathway_id'] ?? null;
                if (in_array('blank', $request->service_id)) {
                    if (!empty($service_id) && !in_array($service_id, $request->service_id)) {
                        continue;
                    }
                } else {
                    if (!in_array($service_id, $request->service_id)) {
                        continue;
                    }
                }
            }

            if ($request->filled('search_text')) {
                $search = strtolower($request->search_text);
                if (
                    stripos($patientArr['camis_patient_pas_number'], $search) === false &&
                    stripos($patientArr['camis_patient_surname'], $search) === false &&
                    stripos($patientArr['camis_patient_forename'], $search) === false
                ) {
                    continue;
                }
            }

            if ($request->filled('ward_id') && !in_array($patientArr['ibox_ward_id'], $request->ward_id)) {
                continue;
            }

            if ($request->filled('cdt') && $request->cdt == 1) {
                if (!isset($patientArr['board_round_cdt']['created_at'])) {
                    continue;
                }
                $success_array['ctd_search'] = 1;
            }

            if ($request->filled('date')) {
                $planned_date = $patientArr['board_round_pathway_requirement']['planned_discharge_date'] ?? null;
                if (!$planned_date || date('Y-m-d', strtotime($planned_date)) != $request->date) {
                    continue;
                }
            }

            $filtered_patients[] = $patientArr;
        }

        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 1:
                    usort($filtered_patients, fn($a, $b) => strcmp($a['camis_patient_surname'], $b['camis_patient_surname']));
                    break;
                case 2:
                    usort($filtered_patients, fn($a, $b) => strcmp($b['camis_patient_surname'], $a['camis_patient_surname']));
                    break;
                case 3:
                    usort($filtered_patients, function ($a, $b) {
                        return strtotime($a['board_round_pathway_requirement']['planned_discharge_date'] ?? '9999-12-31') -
                            strtotime($b['board_round_pathway_requirement']['planned_discharge_date'] ?? '9999-12-31');
                    });
                    break;
                case 4:
                    usort($filtered_patients, function ($a, $b) {
                        return strtotime($b['board_round_pathway_requirement']['planned_discharge_date'] ?? '0000-01-01') -
                            strtotime($a['board_round_pathway_requirement']['planned_discharge_date'] ?? '0000-01-01');
                    });
                    break;
            }
        }

        $all_patients = $filtered_patients;
        $all_patients = array_reduce($filtered_patients, function ($carry, $item) {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);

        $all_patients = array_filter(
            array_map(
                fn($wards) => array_filter($wards, fn($value) => !empty($value)),
                $all_patients
            ),
            fn($wards) => !empty($wards)
        );
        if (!$request->filled('sort_by')) {
            ksort($all_patients);
        }


        $success_array['ward_list'] = Wards::where('status', 1)->orderBy('ward_name', 'asc')->get()->toArray();
        $success_array['selected_ward_id'] = $request->ward_id;
        $success_array['selected_medfit'] = $request->medfit;
        $success_array['selected_authority_id'] = $request->authority_id;
        $success_array['selected_service_id'] = $request->service_id;
        $success_array['selected_pathway_id'] = $request->pathway_id;
        $success_array['dtoc_path_way_drop'] = DtocPathway::where('status', '=', 1)->orderBy('dtoc_pathway_text', 'ASC')->get();
        $success_array['selected_search_text'] = $request->search_text;
        $success_array['all_patients'] = $all_patients;
        $success_array['dtoc_service_value_drop'] = DtocServiceByPathway::where('status', 1)->orderBy('service_text_value', 'asc')->pluck('service_text_value', 'id')->toArray();
        $success_array['dtoc_current_service_value_drop'] = DtocCurrentService::where('status', 1)->orderBy('service_text_value', 'asc')->pluck('service_text_value', 'id')->toArray();


        $ward_list = Wards::with('PrimaryWardType')->where('status', 1)

            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ward_name', 'asc')
            ->get()->toArray();

        $medical_wards = [];
        $surgical_wards = [];
        $other_wards = [];
        foreach ($ward_list as $item) {
            if (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'medical') {
                $medical_wards[] = $item;
            } elseif (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'surgical') {
                $surgical_wards[] = $item;
            } elseif (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'others') {
                $other_wards[] = $item;
            }
        }

        $all_wards_filter                              = Wards::where('status', '=', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();

        $discharges_today = CamisIboxPatientInformationDetails::with('BoardRoundCdt')->whereIn('camis_patient_ward', $all_wards_filter)->whereNotNull('camis_patient_id')->whereDate('camis_patient_discharge_date', Carbon::today())->get()->toArray();
        $success_array['discharges_today'] = count(ArrayFilter($discharges_today, function ($item) {
            return (isset($item['board_round_cdt']['cdt_status']) && $item['board_round_cdt']['cdt_status'] == 1);
        }));

        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.ComplexDischarge', compact('success_array', 'medical_wards', 'surgical_wards', 'other_wards'));
        $sections = $view->render();
        return $sections;
    }



    public function DischargeTrackerPrint(Request $request)
    {

        $success_array = [];

        $pathway_patients = [];

        $patient_ids = CamisIboxBoardRoundCDT::where('cdt_status', 1)->pluck('patient_id')->toArray();

        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();
        $base_query = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')
            ->where('ibox_bed_type', 'Bed')
            ->whereIn('ibox_ward_id', $wards_ids)
            ->where('ibox_ward_short_name', '!=', 'XXTW')
            ->whereNull('camis_patient_discharge_date_time')
            ->with([
                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                },
                'BoardRoundEstimatedDischargeDate' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
                },
                'BoardRoundDtocComments' => function ($q) {
                    $q->orderBy('created_at', 'desc');
                },
                'BoardRoundPathwayRequirement.DtocPathway',
                'BoardRoundPathwayRequirement.DtocAuthority',
                'BoardRoundPathwayRequirement.DtocStatus',
                'BoardRoundReasonToReside.ReasonToResideCategory',
                'PotentialDefinite',
                'PatientWiseFlags',
                'BoardRoundEdn',
                'BoardRoundTto',
                'PatientVitalPacInfo',
                'BoardRoundCdt'
            ])
            ->whereIn('camis_patient_id', $patient_ids)
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_number', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')
            ->limit(1500);

        $all_patients = $base_query->get();





        $filtered_patients = [];

        foreach ($all_patients as $patient) {

            $patientArr = $patient->toArray();

            if ($request->filled('medfit')) {

                $selected = $request->medfit;
                $medfit_status = $patientArr['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null;

                if (in_array(1, $selected) && in_array(0, $selected)) {
                } elseif (in_array(1, $selected) && !in_array(0, $selected)) {
                    if ($medfit_status != 1) {
                        continue;
                    }
                } elseif (in_array(0, $selected) && !in_array(1, $selected)) {
                    if ($medfit_status == 1) {
                        continue;
                    }
                } else {
                    continue;
                }
            }

            if ($request->filled('pathway_id')) {
                $pathway_id = $patientArr['board_round_pathway_requirement']['dtoc_pathway_id'] ?? null;
                if (in_array('blank', $request->pathway_id)) {
                    if (!empty($pathway_id) && !in_array($pathway_id, $request->pathway_id)) {
                        continue;
                    }
                } else {
                    if (!in_array($pathway_id, $request->pathway_id)) {
                        continue;
                    }
                }
            }

            if ($request->filled('authority_id')) {
                $auth_id = $patientArr['board_round_pathway_requirement']['service_id'] ?? null;
                if (in_array('blank', $request->authority_id)) {
                    if (!empty($auth_id) && !in_array($auth_id, $request->authority_id)) {
                        continue;
                    }
                } else {
                    if (!in_array($auth_id, $request->authority_id)) {
                        continue;
                    }
                }
            }

            if ($request->filled('service_id')) {
                $service_id = $patientArr['board_round_pathway_requirement']['service_by_pathway_id'] ?? null;
                if (in_array('blank', $request->service_id)) {
                    if (!empty($service_id) && !in_array($service_id, $request->service_id)) {
                        continue;
                    }
                } else {
                    if (!in_array($service_id, $request->service_id)) {
                        continue;
                    }
                }
            }

            if ($request->filled('search_text')) {
                $search = strtolower($request->search_text);
                if (
                    stripos($patientArr['camis_patient_pas_number'], $search) === false &&
                    stripos($patientArr['camis_patient_surname'], $search) === false &&
                    stripos($patientArr['camis_patient_forename'], $search) === false
                ) {
                    continue;
                }
            }

            if ($request->filled('ward_id') && !in_array($patientArr['ibox_ward_id'], $request->ward_id)) {
                continue;
            }

            if ($request->filled('cdt') && $request->cdt == 1) {
                if (!isset($patientArr['board_round_cdt']['created_at'])) {
                    continue;
                }
                $success_array['ctd_search'] = 1;
            }

            if ($request->filled('date')) {
                $planned_date = $patientArr['board_round_pathway_requirement']['planned_discharge_date'] ?? null;
                if (!$planned_date || date('Y-m-d', strtotime($planned_date)) != $request->date) {
                    continue;
                }
            }

            $filtered_patients[] = $patientArr;
        }

        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 1:
                    usort($filtered_patients, fn($a, $b) => strcmp($a['camis_patient_surname'], $b['camis_patient_surname']));
                    break;
                case 2:
                    usort($filtered_patients, fn($a, $b) => strcmp($b['camis_patient_surname'], $a['camis_patient_surname']));
                    break;
                case 3:
                    usort($filtered_patients, function ($a, $b) {
                        return strtotime($a['board_round_pathway_requirement']['planned_discharge_date'] ?? '9999-12-31') -
                            strtotime($b['board_round_pathway_requirement']['planned_discharge_date'] ?? '9999-12-31');
                    });
                    break;
                case 4:
                    usort($filtered_patients, function ($a, $b) {
                        return strtotime($b['board_round_pathway_requirement']['planned_discharge_date'] ?? '0000-01-01') -
                            strtotime($a['board_round_pathway_requirement']['planned_discharge_date'] ?? '0000-01-01');
                    });
                    break;
            }
        }

        $all_patients = $filtered_patients;
        $all_patients = array_reduce($filtered_patients, function ($carry, $item) {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);

        $all_patients = array_filter(
            array_map(
                fn($wards) => array_filter($wards, fn($value) => !empty($value)),
                $all_patients
            ),
            fn($wards) => !empty($wards)
        );
        if (!$request->filled('sort_by')) {
            ksort($all_patients);
        }


        $success_array['ward_list'] = Wards::where('status', 1)->orderBy('ward_name', 'asc')->get()->toArray();
        $success_array['selected_ward_id'] = $request->ward_id;
        $success_array['selected_medfit'] = $request->medfit;
        $success_array['selected_authority_id'] = $request->authority_id;
        $success_array['selected_service_id'] = $request->service_id;
        $success_array['selected_pathway_id'] = $request->pathway_id;
        $success_array['dtoc_path_way_drop'] = DtocPathway::where('status', '=', 1)->orderBy('dtoc_pathway_text', 'ASC')->get();
        $success_array['selected_search_text'] = $request->search_text;
        $success_array['all_patients'] = $all_patients;
        $success_array['dtoc_service_value_drop'] = DtocServiceByPathway::where('status', 1)->orderBy('service_text_value', 'asc')->pluck('service_text_value', 'id')->toArray();
        $success_array['dtoc_current_service_value_drop'] = DtocCurrentService::where('status', 1)->orderBy('service_text_value', 'asc')->pluck('service_text_value', 'id')->toArray();


        $ward_list = Wards::with('PrimaryWardType')->where('status', 1)

            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ward_name', 'asc')
            ->get()->toArray();

        $medical_wards = [];
        $surgical_wards = [];
        $other_wards = [];
        foreach ($ward_list as $item) {
            if (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'medical') {
                $medical_wards[] = $item;
            } elseif (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'surgical') {
                $surgical_wards[] = $item;
            } elseif (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'others') {
                $other_wards[] = $item;
            }
        }

        $all_wards_filter                              = Wards::where('status', '=', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();

        $discharges_today = CamisIboxPatientInformationDetails::with('BoardRoundCdt')->whereIn('camis_patient_ward', $all_wards_filter)->whereNotNull('camis_patient_id')->whereDate('camis_patient_discharge_date', Carbon::today())->get()->toArray();
        $success_array['discharges_today'] = count(ArrayFilter($discharges_today, function ($item) {
            return (isset($item['board_round_cdt']['cdt_status']) && $item['board_round_cdt']['cdt_status'] == 1);
        }));

        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.ComplexDischargesPrint', compact('success_array', 'medical_wards', 'surgical_wards', 'other_wards'));
        $sections = $view->render();
        return $sections;
    }



    public function DischargeFromCDTDataLoad(Request $request)
    {
        $success_array  = array();
        if ($request->filled('complex_date')) {
            $selected_date = $request->complex_date;
        } else {
            $selected_date = date('Y-m-d');
        }
        $keyword = $request->complex_search_text;
        $all_wards                              = Wards::where('status', '=', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();

        $patient_list =  CamisIboxWardPatientInformationWithBedDetailsFullList::with(['DischargeAssignedData', 'BoardRoundCdt', 'OtherNotes'])->whereIn('camis_patient_ward', $all_wards)->whereNotNull('camis_patient_id')
            ->where(function ($q) use ($keyword) {
                $q->where('camis_patient_name', 'like', '%' . $keyword . '%')
                    ->orWhere('camis_patient_id', 'like', '%' . $keyword . '%')
                    ->orWhere('camis_patient_pas_number', 'like', '%' . $keyword . '%')
                    ->orWhere('camis_patient_surname', 'like', '%' . $keyword . '%')
                    ->orWhere('camis_patient_forename', 'like', '%' . $keyword . '%');
            })
            ->when($request->filled('complex_time'), function ($query) use ($request) {
                return $query->where(function ($q) use ($request) {
                    $los_21_plus = Carbon::parse($request->complex_date)->subDays(21)->toDateString();

                    if ($request->complex_time == 1) {
                        $q->whereTime('camis_patient_discharge_date_time', '<=', '' . $request->complex_date . ' 17:00:00');
                    } elseif ($request->complex_time == 2) {
                        $q->whereTime('camis_patient_discharge_date_time', '>=', '' . $request->complex_date . ' 17:00:00')
                            ->whereTime('camis_patient_discharge_date_time', '<=', ' ' . $request->date . '23:59:00');
                    } elseif ($request->complex_time == 3) {
                        $q->whereTime('camis_patient_discharge_date_time', '<=', '' . $request->complex_date . ' 17:00:00')
                            ->whereDate('camis_patient_admission_date_time', '<', $los_21_plus);
                    } elseif ($request->complex_time == 4) {
                        $q->whereTime('camis_patient_discharge_date_time', '>=', '' . $request->complex_date . ' 17:00:00')
                            ->whereTime('camis_patient_discharge_date_time', '<=', '' . $request->complex_date . ' 23:59:00')
                            ->whereDate('camis_patient_admission_date_time', '<', $los_21_plus);
                    }
                });
            })
            ->when($request->filled('ward_id_cdt'), function ($q) use ($request) {
                $q->whereIn('camis_patient_ward_id', $request->ward_id_cdt);
            })
            ->whereDate('camis_patient_discharge_date', $selected_date)->get()->toArray();

        $patient_list_cdt = ArrayFilter($patient_list, function ($item) {
            return (isset($item['board_round_cdt']['cdt_status']) && $item['board_round_cdt']['cdt_status'] == 1);
        });
        $success_array['all_wards'] = Wards::pluck('ward_name', 'ward_short_name')->toArray();


        $success_array['discharges_from_cdt_count'] = count($patient_list_cdt);
        $final_patient_list = array_reduce($patient_list_cdt, function ($carry, $item) use ($success_array) {
            $ward_short_name = $item['camis_patient_ward'];
            $ward_name = $success_array['all_wards'][$ward_short_name] ?? 'Unknown Ward';
            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($final_patient_list);
        $success_array['patient_list'] = $final_patient_list;
        $success_array['discharge_tracker_dropdown'] = DischargeTrackerDropdown::where('status', 1)->get();


        $discharges_today = CamisIboxWardPatientInformationWithBedDetailsFullList::with('BoardRoundCdt')->whereIn('camis_patient_ward', $all_wards)->whereNotNull('camis_patient_id')->whereDate('camis_patient_discharge_date', Carbon::today())->get()->toArray();
        $success_array['discharges_today'] = count(ArrayFilter($discharges_today, function ($item) {
            return (isset($item['board_round_cdt']['cdt_status']) && $item['board_round_cdt']['cdt_status'] == 1);
        }));

        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.ComplexDischargesDataLoad', compact('success_array'));
        $sections = $view->render();
        return $sections;
    }

    public function EDReferral(Request $request)
    {
        $all_wards                              = Wards::where('status', '=', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();

        $success_array = array();
        $success_array['discharges_today'] = CamisIboxPatientInformationDetails::whereIn('camis_patient_ward', $all_wards)->whereNotNull('camis_patient_id')->whereDate('camis_patient_discharge_date', Carbon::today())->count();

        $patient_list_data = CamisIboxBoardRoundEDReferral::with('PatientInformation')->get()->toArray();
        $patient_list = [];
        foreach ($patient_list_data as $patient) {
            if (!isset($patient['patient_information']['symphony_attendance_id'])) {
                continue;
            }
            $patient_list[] = $patient['patient_information'];
        }
        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.ReferralDataLoad', compact('success_array', 'patient_list'));
        $sections = $view->render();
        return $sections;
    }

    public function EDReferralPatientSearch(Request $request)
    {


        $patient_id                                         = SymphonyAttendanceView::when($request->filled('search_query'), function ($query) use ($request) {
            return $query->where(function ($q) use ($request) {
                $q->where('symphony_pas_number', 'like', '%' . $request->search_query . '%')
                    ->orWhere('symphony_attendance_id', 'like', '%' . $request->search_query . '%')
                    ->orWhere('symphony_patient_id', 'like', '%' . $request->search_query . '%')
                    ->orWhere('symphony_patient_name', 'like', '%' . $request->search_query . '%');
            });
        })->pluck('symphony_attendance_id')->toArray();
        $patient_list_data = CamisIboxBoardRoundEDReferral::with('PatientInformation')->whereIn('patient_id', $patient_id)->get()->toArray();
        $patient_list = [];
        foreach ($patient_list_data as $patient) {
            if (!isset($patient['patient_information']['symphony_attendance_id'])) {
                continue;
            }
            $patient_list[] = $patient['patient_information'];
        }
        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.EDReferralPatientList', compact('patient_list'));
        return $view->render();
    }

    public function SearchEDPatient(Request $request)
    {
        $existing_patient = CamisIboxBoardRoundEDReferral::pluck('patient_id')->toArray();

        $still_in_ane_patients_list                                         = SymphonyAttendanceView::when($request->filled('search_query') && $request->search_query != '', function ($query) use ($request) {
            return $query->where(function ($q) use ($request) {
                $q->where('symphony_pas_number', 'like', '%' . $request->search_query . '%')
                    ->orWhere('symphony_attendance_id', 'like', '%' . $request->search_query . '%')
                    ->orWhere('symphony_patient_id', 'like', '%' . $request->search_query . '%')
                    ->orWhere('symphony_patient_name', 'like', '%' . $request->search_query . '%');
            });
        })->orderBy('symphony_registration_date_time', 'ASC')->limit(50)->get()->toArray();

        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.EDReferralPatientSearch', compact('existing_patient', 'still_in_ane_patients_list'));
        $sections = $view->render();
        return $sections;
    }

    public function EDReferralSavePatient(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundEDReferral";
        $date_time_now                                              = CurrentDateOnFormat();
        $patients_id                                                = $request->patient_ids;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));

        if (count($patients_id) > 0 && $user_id != "") {
            foreach ($patients_id as $camis_patient_id) {
                $gov_text_before_arr                                    = CamisIboxBoardRoundEDReferral::where('patient_id', '=', $camis_patient_id)->first();
                $updated_data                                           = CamisIboxBoardRoundEDReferral::updateOrCreate(['patient_id' => $camis_patient_id], ['updated_by' => $user_id]);
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
                $functional_identity                                    = 'ED Referral';

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundEDReferral::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Patient Added', $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {

                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundEDReferral::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Patient Added', $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            }
        }
        $patient_list_data = CamisIboxBoardRoundEDReferral::with('PatientInformation')->get()->toArray();
        $patient_list = [];
        foreach ($patient_list_data as $patient) {
            if (!isset($patient['patient_information']['symphony_attendance_id'])) {
                continue;
            }
            $patient_list[] = $patient['patient_information'];
        }
        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.EDReferralPatientList', compact('patient_list'));
        $success_array["html"] = $view->render();


        $success_array["status"]                                    = 1;
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function EDReferralRemovePatient(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundEDReferral";
        $date_time_now                                              = CurrentDateOnFormat();
        $patient_id                                                 = $request->patient_id;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $gov_text_before_arr                                        = CamisIboxBoardRoundEDReferral::where('patient_id', '=', $patient_id)->first();
        if ($gov_text_before_arr != null) {
            CamisIboxBoardRoundEDReferral::where('patient_id', '=', $patient_id)->delete();
            $updated_data                                    = $gov_text_before_arr;
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
            $success_array["message"]                        = DataRemovalMessage();
            $gov_text_before                                 = $gov_text_before_arr->toArray();
            $gov_text_after_arr                              = array();
            $this->GovernanceBoardRoundUpdatePreCall($patient_id, $gov_text_before, 'Patient Removed', $gov_text_after_arr, 'ED Referral', 3);
            $success_array["status"]                                    = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }
    public function RemovedPatients()
    {
        return view('Dashboards.Camis.DischargeTracker.RemovedPatient');
    }

    public function RemovedPatientDataLoad(Request $request)

    {
        $patient_ids = CamisIboxBoardRoundCDT::where('cdt_status', 4)->pluck('patient_id')->toArray();

        $patients_list = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $patient_ids)->with(['BoardRoundCdt', 'BoardRoundCDTComment'])

            ->when($request->filled('ward_id'), function ($q) use ($request) {
                $q->whereIn('camis_patient_ward_id', $request->ward_id);
            })
            ->unless($request->filled('ward_id'), function ($q) {
                $q->whereIn('camis_patient_ward_id', AllWardToIDArray());
            })
            ->select('ibox_actual_bed_full_name', 'camis_patient_sex', 'camis_patient_name', 'camis_patient_pas_number', 'camis_consultant_name', 'camis_patient_admission_date_time', 'ibox_ward_name', 'camis_patient_id')
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_number', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')->get()->toArray();


        $patients = array_reduce($patients_list, function ($carry, $item) {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($patients);


        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.CdtRemoved', compact('patients'));
        $sections = $view->render();
        return $sections;
    }

    public function FetchReferralDtocInfo(Request $request)
    {
        $success_array = [];
        $success_array['patient_move'] = 0;

        $selected_ward_id = $request->ward_id;
        $selected_medfit = $request->medfit;
        $selected_search_text = $request->search_text;
        $patient_ids = CamisIboxBoardRoundCDT::where('cdt_status', 1)->pluck('patient_id')->toArray();
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();

        $base_query = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'BoardRoundMedicallyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
            },
            'BoardRoundPathwayRequirement',
            'BoardRoundCareRequirement',
            'BoardRoundCdt',
            'DischargeAssignedData'
        ])->whereNotNull('camis_patient_id')
            ->where('ibox_bed_type', 'Bed')
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->whereIn('ibox_ward_id', $wards_ids)
            ->whereIn('camis_patient_id', $patient_ids)
            ->orderBy('ibox_ward_name', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_number', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')->get();


        $filtered_patients = [];


        foreach ($base_query as $patient) {

            if (!in_array($patient->camis_patient_id, $patient_ids)) {
                continue;
            }

            $patientArr = $patient->toArray();

            if ($request->filled('medfit')) {

                $selected = $request->medfit;
                $medfit_status = $patientArr['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null;

                if (in_array(1, $selected) && in_array(0, $selected)) {
                } elseif (in_array(1, $selected) && !in_array(0, $selected)) {
                    if ($medfit_status != 1) {
                        continue;
                    }
                } elseif (in_array(0, $selected) && !in_array(1, $selected)) {
                    if ($medfit_status == 1) {
                        continue;
                    }
                } else {
                    continue;
                }
            }

            if ($request->filled('pathway_id')) {
                $pathway_id = $patientArr['board_round_pathway_requirement']['dtoc_pathway_id'] ?? null;
                if (in_array('blank', $request->pathway_id)) {
                    if (!empty($pathway_id) && !in_array($pathway_id, $request->pathway_id)) {
                        continue;
                    }
                } else {
                    if (!in_array($pathway_id, $request->pathway_id)) {
                        continue;
                    }
                }
            }

            if ($request->filled('authority_id')) {
                $auth_id = $patientArr['board_round_pathway_requirement']['service_id'] ?? null;
                if (in_array('blank', $request->authority_id)) {
                    if (!empty($auth_id) && !in_array($auth_id, $request->authority_id)) {
                        continue;
                    }
                } else {
                    if (!in_array($auth_id, $request->authority_id)) {
                        continue;
                    }
                }
            }

            if ($request->filled('service_id')) {
                $service_id = $patientArr['board_round_pathway_requirement']['service_by_pathway_id'] ?? null;
                if (in_array('blank', $request->service_id)) {
                    if (!empty($service_id) && !in_array($service_id, $request->service_id)) {
                        continue;
                    }
                } else {
                    if (!in_array($service_id, $request->service_id)) {
                        continue;
                    }
                }
            }

            if ($request->filled('search_text')) {
                $search = strtolower($request->search_text);
                if (
                    stripos($patientArr['camis_patient_pas_number'], $search) === false &&
                    stripos($patientArr['camis_patient_surname'], $search) === false &&
                    stripos($patientArr['camis_patient_forename'], $search) === false
                ) {
                    continue;
                }
            }

            if ($request->filled('ward_id') && !in_array($patientArr['ibox_ward_id'], $request->ward_id)) {
                continue;
            }

            if ($request->filled('cdt') && $request->cdt == 1) {
                if (!isset($patientArr['board_round_cdt']['created_at'])) {
                    continue;
                }
                $success_array['ctd_search'] = 1;
            }

            if ($request->filled('date')) {
                $planned_date = $patientArr['board_round_pathway_requirement']['planned_discharge_date'] ?? null;
                if (!$planned_date || date('Y-m-d', strtotime($planned_date)) != $request->date) {
                    continue;
                }
            }

            $filtered_patients[] = $patientArr;
        }

        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 1:
                    usort($filtered_patients, fn($a, $b) => strcmp($a['camis_patient_surname'], $b['camis_patient_surname']));
                    break;
                case 2:
                    usort($filtered_patients, fn($a, $b) => strcmp($b['camis_patient_surname'], $a['camis_patient_surname']));
                    break;
                case 3:
                    usort($filtered_patients, function ($a, $b) {
                        return strtotime($a['board_round_pathway_requirement']['planned_discharge_date'] ?? '9999-12-31') -
                            strtotime($b['board_round_pathway_requirement']['planned_discharge_date'] ?? '9999-12-31');
                    });
                    break;
                case 4:
                    usort($filtered_patients, function ($a, $b) {
                        return strtotime($b['board_round_pathway_requirement']['planned_discharge_date'] ?? '0000-01-01') -
                            strtotime($a['board_round_pathway_requirement']['planned_discharge_date'] ?? '0000-01-01');
                    });
                    break;
            }
        }
        $all_patients = $filtered_patients;

        $all_patients = array_values($all_patients);

        $current_patient_index = array_search($request->camis_patient_id, array_column($all_patients, 'camis_patient_id'));

        $next_patient = null;
        $prev_patient = null;

        if ($current_patient_index !== false) {
            if ($current_patient_index > 0) {
                $prev_patient = $all_patients[$current_patient_index - 1]['camis_patient_id'];
            }
            if ($current_patient_index < count($all_patients) - 1) {
                $next_patient = $all_patients[$current_patient_index + 1]['camis_patient_id'];
            }
        }
        $success_array['patient'] = $all_patients[$current_patient_index];
        $success_array['next_patient'] = $next_patient;
        $success_array['prev_patient'] = $prev_patient;
        $current_service_id = $success_array['patient']['board_round_pathway_requirement']['dtoc_pathway_id'] ?? 0;
        $success_array['dtoc_path_way_drop'] = DtocPathway::where('status', '=', 1)->orderBy('dtoc_pathway_text', 'ASC')->get();
        $success_array['dtoc_current_status_drop'] = DtocCurrentStatus::where('status', '=', 1)->orderBy('dtoc_current_status_text', 'ASC')->get();
        $success_array['dtoc_authority_drop'] = DtocAuthority::where('status', '=', 1)->orderBy('dtoc_authority_text', 'ASC')->get();
        $success_array['dtoc_service_value_drop'] = DtocServiceByPathway::where('pathway_id', $current_service_id)->where('pathway_id', '!=', 0)->where('status', 1)->orderBy('service_text_value', 'asc')->pluck('service_text_value', 'id')->toArray();
        $success_array['dtoc_current_service_value_drop'] = DtocCurrentService::where('status', 1)->orderBy('service_text_value', 'asc')->pluck('service_text_value', 'id')->toArray();
        $success_array['users'] = User::pluck('username', 'id')->toArray();
        $success_array['discharge_tracker_dropdown'] = DischargeTrackerDropdown::where('status', 1)->get();
        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.DtocModal', compact('success_array'));
        $sections = $view->render();
        return $sections;
    }


    public function FetchDtocInfo(Request $request)
    {
        $success_array = [];
        if ($request->filled('medfit_status') && $request->medfit_status == 1) {
            $success_array['patient_move'] = 0;
        } else {
            $success_array['patient_move'] = 1;
        }
        $selected_ward_id = $request->ward_id;
        $selected_medfit = $request->medfit;
        $selected_search_text = $request->search_text;
        $patient_ids = CamisIboxBoardRoundCDT::where('cdt_status', 1)->pluck('patient_id')->toArray();
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();

        $base_query = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'BoardRoundMedicallyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
            },
            'BoardRoundPathwayRequirement',
            'BoardRoundCareRequirement',
            'BoardRoundCdt',
            'DischargeAssignedData'
        ])->whereNotNull('camis_patient_id')
            ->where('ibox_bed_type', 'Bed')
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->whereIn('ibox_ward_id', $wards_ids)
            ->whereIn('camis_patient_id', $patient_ids)
            ->orderBy('ibox_ward_name', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_number', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')->get()->toArray();


        $filtered_patients = [];

        foreach ($base_query as $patientArr) {


            if ($request->filled('medfit')) {

                $selected = $request->medfit;
                $medfit_status = $patientArr['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null;

                if (in_array(1, $selected) && in_array(0, $selected)) {
                } elseif (in_array(1, $selected) && !in_array(0, $selected)) {
                    if ($medfit_status != 1) {
                        continue;
                    }
                } elseif (in_array(0, $selected) && !in_array(1, $selected)) {
                    if ($medfit_status == 1) {
                        continue;
                    }
                } else {
                    continue;
                }
            }

            if ($request->filled('pathway_id')) {
                $pathway_id = $patientArr['board_round_pathway_requirement']['dtoc_pathway_id'] ?? null;
                if (in_array('blank', $request->pathway_id)) {
                    if (!empty($pathway_id) && !in_array($pathway_id, $request->pathway_id)) {
                        continue;
                    }
                } else {
                    if (!in_array($pathway_id, $request->pathway_id)) {
                        continue;
                    }
                }
            }

            if ($request->filled('authority_id')) {
                $auth_id = $patientArr['board_round_pathway_requirement']['service_id'] ?? null;
                if (in_array('blank', $request->authority_id)) {
                    if (!empty($auth_id) && !in_array($auth_id, $request->authority_id)) {
                        continue;
                    }
                } else {
                    if (!in_array($auth_id, $request->authority_id)) {
                        continue;
                    }
                }
            }

            if ($request->filled('service_id')) {
                $service_id = $patientArr['board_round_pathway_requirement']['service_by_pathway_id'] ?? null;
                if (in_array('blank', $request->service_id)) {
                    if (!empty($service_id) && !in_array($service_id, $request->service_id)) {
                        continue;
                    }
                } else {
                    if (!in_array($service_id, $request->service_id)) {
                        continue;
                    }
                }
            }

            if ($request->filled('search_text')) {
                $search = strtolower($request->search_text);
                if (
                    stripos($patientArr['camis_patient_pas_number'], $search) === false &&
                    stripos($patientArr['camis_patient_surname'], $search) === false &&
                    stripos($patientArr['camis_patient_forename'], $search) === false
                ) {
                    continue;
                }
            }

            if ($request->filled('ward_id') && !in_array($patientArr['ibox_ward_id'], $request->ward_id)) {
                continue;
            }

            if ($request->filled('cdt') && $request->cdt == 1) {
                if (!isset($patientArr['board_round_cdt']['created_at'])) {
                    continue;
                }
                $success_array['ctd_search'] = 1;
            }

            if ($request->filled('date')) {
                $planned_date = $patientArr['board_round_pathway_requirement']['planned_discharge_date'] ?? null;
                if (!$planned_date || date('Y-m-d', strtotime($planned_date)) != $request->date) {
                    continue;
                }
            }

            $filtered_patients[] = $patientArr;
        }





        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 1:
                    usort($filtered_patients, fn($a, $b) => strcmp($a['camis_patient_surname'], $b['camis_patient_surname']));
                    break;
                case 2:
                    usort($filtered_patients, fn($a, $b) => strcmp($b['camis_patient_surname'], $a['camis_patient_surname']));
                    break;
                case 3:
                    usort($filtered_patients, function ($a, $b) {
                        return strtotime($a['board_round_pathway_requirement']['planned_discharge_date'] ?? '9999-12-31') -
                            strtotime($b['board_round_pathway_requirement']['planned_discharge_date'] ?? '9999-12-31');
                    });
                    break;
                case 4:
                    usort($filtered_patients, function ($a, $b) {
                        return strtotime($b['board_round_pathway_requirement']['planned_discharge_date'] ?? '0000-01-01') -
                            strtotime($a['board_round_pathway_requirement']['planned_discharge_date'] ?? '0000-01-01');
                    });
                    break;
            }
        }

        $all_patients = $filtered_patients;
        $all_patients = array_reduce($filtered_patients, function ($carry, $item) {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);

        $all_patients = array_filter(
            array_map(
                fn($wards) => array_filter($wards, fn($value) => !empty($value)),
                $all_patients
            ),
            fn($wards) => !empty($wards)
        );
        if (!$request->filled('sort_by')) {
            ksort($all_patients);
        }
        $flattened = collect($all_patients)->flatten(1)->values()->all();




        $current_patient_index = array_search($request->camis_patient_id, array_column($flattened, 'camis_patient_id'));

        $next_patient = null;
        $prev_patient = null;

        if ($current_patient_index !== false) {
            if ($current_patient_index > 0) {
                $prev_patient = $flattened[$current_patient_index - 1]['camis_patient_id'];
            }
            if ($current_patient_index < count($flattened) - 1) {
                $next_patient = $flattened[$current_patient_index + 1]['camis_patient_id'];
            }
        }
        $success_array['patient'] = $flattened[$current_patient_index];
        $success_array['next_patient'] = $next_patient;
        $success_array['prev_patient'] = $prev_patient;
        $current_service_id = $success_array['patient']['board_round_pathway_requirement']['dtoc_pathway_id'] ?? 0;
        $success_array['dtoc_path_way_drop'] = DtocPathway::where('status', '=', 1)->orderBy('dtoc_pathway_text', 'ASC')->get();
        $success_array['dtoc_current_status_drop'] = DtocCurrentStatus::where('status', '=', 1)->orderBy('dtoc_current_status_text', 'ASC')->get();
        $success_array['dtoc_authority_drop'] = DtocAuthority::where('status', '=', 1)->orderBy('dtoc_authority_text', 'ASC')->get();
        $success_array['dtoc_service_value_drop'] = DtocServiceByPathway::where('pathway_id', $current_service_id)->where('pathway_id', '!=', 0)->where('status', 1)->orderBy('service_text_value', 'asc')->pluck('service_text_value', 'id')->toArray();
        $success_array['dtoc_current_service_value_drop'] = DtocCurrentService::where('status', 1)->orderBy('service_text_value', 'asc')->pluck('service_text_value', 'id')->toArray();
        $success_array['users'] = User::pluck('username', 'id')->toArray();
        $success_array['discharge_tracker_dropdown'] = DischargeTrackerDropdown::where('status', 1)->get();
        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.DtocModal', compact('success_array'));
        $sections = $view->render();
        return $sections;
    }




    public function SaveDtocInfo(Request $request)
    {
        $ward_summary_controller                                    = new WardSummaryController;
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardPathwayRequirement";
        $care_history_modal                                         = "App\Models\History\HistoryCamisIboxBoardCareRequirement";
        $cdt_history_modal                                          = "App\Models\History\HistoryCamisIboxBoardRoundCDT";
        $discharge_pathway_history_modal                            = "App\Models\History\HistoryCamisDischargeDataAssigned";


        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $dtoc_pathway_id                                            = $request->pathway_value;
        $dtoc_current_status_id                                     = $request->dtoc_current_status ?? null;
        $dtoc_authority_id                                          = $request->reason_code_value;
        $planned_discharge_date                                     = $request->planned_discharge_date != null ? Carbon::parse($request->planned_discharge_date)->format('d-m-Y') : null;
        $others_authority_text                                      = $request->others_authority_text;
        $dtoc_authority                                             = DtocAuthority::where('id', '=', $dtoc_authority_id)->first();
        $dtoc_authority_text                                        = $dtoc_authority->dtoc_authority_text ?? null;
        $dtoc_authority_code                                        = $dtoc_authority->dtoc_authority_code ?? null;


        $dtoc_current_status   = '';
        $dtoc_current_status_coded   = '';
        $dtoc_current_status_delay_code   = '';
        $success_array['dtoc_current_status'] = '';
        if ($dtoc_current_status_id != '') {
            $dtoc_current_status                                        = DtocCurrentStatus::where('id', '=', $dtoc_current_status_id)->first();
            $dtoc_current_status_coded                                  = $dtoc_current_status->dtoc_current_status_coded ?? '';

            $dtoc_current_status_delay_code                             = $dtoc_current_status->dtoc_current_status_delay_code ?? '';
            $success_array['dtoc_current_status']                       = $dtoc_current_status->dtoc_current_status_text ?? '';
        }

        $dtoc_service_id                                          = $request->dtoc_service;
        $dtoc_service_text = '';
        $success_array['dtoc_service_text'] = '';
        if ($dtoc_service_id != null) {
            $dtoc_service                                             = DtocCurrentService::where('id', $dtoc_service_id)->where('status', 1)->first();
            $dtoc_service_text                                        = $dtoc_service->service_text_value ?? '';

            if (strtolower($dtoc_service_text) == 'ooa') {
                $success_array['dtoc_service_text']                       = '' . $dtoc_service_text . ': ' . $request->others_authority_text;
            } else {
                $success_array['dtoc_service_text']                       = $dtoc_service_text;
            }
        }

        $service_by_pathway_id = $request->dtoc_service_by_pathway;
        $service_by_pathway_text = '';
        $success_array['service_by_pathway_text'] = '';
        if ($service_by_pathway_id != null) {
            $service_by_pathway = DtocServiceByPathway::where('status', 1)->where('id', $service_by_pathway_id)->first();
            $service_by_pathway_text = $service_by_pathway->service_text_value ?? '';

            $success_array['service_by_pathway_text']   = $service_by_pathway_text;
        }


        $care_requirements_pdna_not_required                        = $request->care_pdna_not_required;
        $care_requirements_pdna_nurse                               = $request->care_pdna_nurse;
        $care_requirements_pdna_idt                                 = $request->care_pdna_idt;
        $care_requirements_pdna_sent                                = $request->care_pdna_sent;
        $success_array['dtoc_authority_text']                       = $dtoc_authority->dtoc_authority_text ?? '';
        $dtoc_pathway_data                                          = DtocPathway::where('id', '=', $request->pathway_value)->first();
        $success_array['dtoc_pathway_text']                         = $dtoc_pathway_data->dtoc_pathway_text ?? '';


        if ($care_requirements_pdna_not_required != 0) {
            $care_requirements_pdna_not_required_date = CurrentDateOnFormat();
        } else {
            $care_requirements_pdna_not_required_date = '';
        }

        if ($care_requirements_pdna_nurse != 0) {
            $care_requirements_pdna_nurse_date = CurrentDateOnFormat();
        } else {
            $care_requirements_pdna_nurse_date = '';
        }

        if ($care_requirements_pdna_idt != 0) {
            $care_requirements_pdna_idt_date = CurrentDateOnFormat();
        } else {
            $care_requirements_pdna_idt_date = '';
        }

        if ($care_requirements_pdna_sent != 0) {
            $care_requirements_pdna_sent_date = CurrentDateOnFormat();
        } else {
            $care_requirements_pdna_sent_date = '';
        }


        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundPathwayRequirement::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxBoardRoundPathwayRequirement::updateOrCreate(['patient_id' => $camis_patient_id], ['dtoc_pathway_text' => $dtoc_pathway_data->dtoc_pathway_text ?? '', 'dtoc_pathway_id' => $dtoc_pathway_id, 'dtoc_current_status_id' => $dtoc_current_status_id, 'dtoc_current_status_coded' => $dtoc_current_status_coded, 'dtoc_current_status_delay_code' => $dtoc_current_status_delay_code, 'dtoc_authority_id' => $dtoc_authority_id, 'dtoc_authority_text' => $dtoc_authority_text, 'planned_discharge_date' => $planned_discharge_date,  'dtoc_authority_code' => $dtoc_authority_code, 'service_id' => $dtoc_service_id, 'dtoc_service_text' => $dtoc_service_text, 'service_by_pathway_id' => $service_by_pathway_id, 'service_by_pathway_text' => $service_by_pathway_text,  'updated_by' => $user_id, 'others_authority_text' => $others_authority_text]);

            $functional_identity                                    = 'Pathway Requirement';
            $gov_updated_info = '';
            if (isset($dtoc_pathway_data->dtoc_pathway_text) && !empty($dtoc_pathway_data->dtoc_pathway_text)) {
                $gov_updated_info .= ' Pathway : ' . $dtoc_pathway_data->dtoc_pathway_text;
            }
            if (isset($service_by_pathway_text) && !empty($service_by_pathway_text)) {
                $gov_updated_info .= ' Services : ' . $service_by_pathway_text;
            }
            if (isset($dtoc_authority_text) && !empty($dtoc_authority_text)) {
                $gov_updated_info .= ' Reason Code : ' . $dtoc_authority_text;
            }
            if (isset($dtoc_service_text) && !empty($dtoc_service_text)) {

                if (strtolower($dtoc_service_text) == 'ooa') {
                    $gov_updated_info .= ' Authority : OOA(' . $others_authority_text . ')';
                } else {
                    $gov_updated_info .= ' Authority : ' . $dtoc_service_text;
                }
            }
            if (isset($planned_discharge_date) && !empty($planned_discharge_date)) {
                $gov_updated_info .= ' Confirmed Discharge Date : ' . $planned_discharge_date;
            }






            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundPathwayRequirement::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_updated_info, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundPathwayRequirement::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_updated_info, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }





            $gov_text_before_arr                                    = CamisIboxBoardRoundCareRequirement::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data = CamisIboxBoardRoundCareRequirement::updateOrCreate(
                ['patient_id' => $camis_patient_id],
                [
                    'care_requirements_pdna_not_required' => $care_requirements_pdna_not_required,
                    'care_requirements_pdna_not_required_date' => empty($care_requirements_pdna_not_required_date) ? null : $care_requirements_pdna_not_required_date,
                    'care_requirements_pdna_nurse' => $care_requirements_pdna_nurse,
                    'care_requirements_pdna_nurse_date' => empty($care_requirements_pdna_nurse_date) ? null : $care_requirements_pdna_nurse_date,
                    'care_requirements_pdna_idt' => $care_requirements_pdna_idt,
                    'care_requirements_pdna_idt_date' => empty($care_requirements_pdna_idt_date) ? null : $care_requirements_pdna_idt_date,
                    'care_requirements_pdna_sent' => $care_requirements_pdna_sent,
                    'care_requirements_pdna_sent_date' => empty($care_requirements_pdna_sent_date) ? null : $care_requirements_pdna_sent_date,
                    'updated_by' => $user_id,
                ]
            );
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $care_history_modal);
            $functional_identity                                    = 'Care Requirement';

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $care_history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundCareRequirement::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Patient Care Requirement Added From DTOC', $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $care_history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundCareRequirement::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Patient Care Requirement Updated From DTOC', $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }

            $success_array["status"]                                    = 1;
            $success_array["planned_discharge_date"]                    = $planned_discharge_date ? PredefinedDateFormatForPD($planned_discharge_date) : '--';
        }

        $cdt_checkbox_messages = '';


        $gov_text_before_arr                                    = CamisIboxBoardRoundCDT::where('patient_id', '=', $camis_patient_id)->first();


        $cdt_updated_data = array();
        if ($gov_text_before_arr->discharge_for_today != $request->discharge_for_today) {
            $cdt_updated_data['discharge_for_today'] = $request->discharge_for_today;
            $cdt_updated_data['discharge_for_today_by'] = $user_id;
            $cdt_updated_data['discharge_for_today_time'] = CurrentDateOnFormat();
            if ($request->discharge_for_today == 1) {
                $cdt_checkbox_messages .= ' Discharge For Today Checked';
            } else {
                $cdt_checkbox_messages .= ' Discharge For Today Unchecked';
            }
        }

        if ($gov_text_before_arr->is_equipment != $request->is_equipment) {
            $cdt_updated_data['is_equipment'] = $request->is_equipment;
            $cdt_updated_data['is_equopment_by'] = $user_id;
            $cdt_updated_data['is_equipment_time'] = CurrentDateOnFormat();
            if ($request->is_equipment == 1) {
                $cdt_checkbox_messages .= ' Equipment Checked';
            } else {
                $cdt_checkbox_messages .= ' Equipment Unchecked';
            }
        }

        if ($gov_text_before_arr->cdt_action != $request->cdt_action) {
            $cdt_updated_data['cdt_action'] = $request->cdt_action;
            $cdt_updated_data['cdt_action_by'] = $user_id;
            $cdt_updated_data['cdt_action_time'] = CurrentDateOnFormat();
            if ($request->cdt_action == 1) {
                $cdt_checkbox_messages .= ' CDT Action Checked';
            } else {
                $cdt_checkbox_messages .= ' CDT Action Unchecked';
            }
        }

        if (!empty($cdt_updated_data)) {
            $updated_data                                           = CamisIboxBoardRoundCDT::updateOrCreate(['patient_id' => $camis_patient_id], $cdt_updated_data);

            $functional_identity                                    = 'CDT Patient Updated';

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $cdt_history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();

                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundCDT::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $cdt_checkbox_messages, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $cdt_history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundCDT::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $cdt_checkbox_messages, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
        }
        if ($request->filled('dt_drop_id')) {
            $patient_discharges_pathway                                 = $request->dt_drop_id;
            $discharge_pathwhay_cat                                     = DischargeTrackerDropdown::where('discharge_drop_id', $patient_discharges_pathway)->first();
            $discharge_pathway_name                                     = $discharge_pathwhay_cat->discharge_pathway_name;
            $discharge_pathway_extra                                    = $discharge_pathwhay_cat->discharge_pathway_extra_name;
            $pathway_full_name                                          = $discharge_pathwhay_cat->discharge_drop_name;
            $camis_patient_data                                         = CamisIboxPatientInformationDetails::where('camis_patient_id', '=', $camis_patient_id)->first();
            $admit_time                                                 = $camis_patient_data->camis_patient_admission_date_time ?? null;


            $discharge_pathway_gov_text_before_arr                       = CamisIboxDischargeAssigned::where('camis_patient_id', '=', $camis_patient_id)->first();
            $discharge_pathway_updated_data                                           = CamisIboxDischargeAssigned::updateOrCreate(['camis_patient_id' => $camis_patient_id], ['dt_drop_id' => $patient_discharges_pathway, 'discharge_tracker_discharge_patients_assigned' => date('Y-m-d'), 'admission_date' => $admit_time, 'pathway_name' => $discharge_pathway_name, 'pathway_extra_name' => $discharge_pathway_extra, 'updated_by' => $user_id]);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($discharge_pathway_updated_data, $discharge_pathway_history_modal);
            $discharge_pathway_functional_identity                                    = 'Camis Discharge Pathway Data Assigned';

            if ($discharge_pathway_updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($discharge_pathway_updated_data, $discharge_pathway_history_modal, 1);
                $discharge_pathway_updated_array                                      = $discharge_pathway_updated_data->getOriginal();
                $discharge_pathway_gov_text_before                                                      = array();
                if (count($discharge_pathway_updated_array) > 0 && isset($discharge_pathway_updated_array["id"])) {
                    $discharge_pathway_gov_text_after_arr                             = CamisIboxDischargeAssigned::where('id', '=', $discharge_pathway_updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $discharge_pathway_gov_text_before, $pathway_full_name, $discharge_pathway_gov_text_after_arr, $discharge_pathway_functional_identity, 1);
                }
            } else {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($discharge_pathway_updated_data, $discharge_pathway_history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($discharge_pathway_updated_data->getChanges()) > 0) {
                    $discharge_pathway_updated_array                                  = $discharge_pathway_updated_data->getOriginal();
                    if (count($discharge_pathway_updated_array) > 0 && isset($discharge_pathway_updated_array["id"])) {
                        if ($discharge_pathway_gov_text_before_arr) {
                            $discharge_pathway_gov_text_before                        = $discharge_pathway_gov_text_before_arr->toArray();
                            $discharge_pathway_gov_text_after_arr                     = CamisIboxDischargeAssigned::where('id', '=', $discharge_pathway_updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $discharge_pathway_gov_text_before, $pathway_full_name, $discharge_pathway_gov_text_after_arr, $discharge_pathway_functional_identity, 2);
                        }
                    }
                }
            }
        } else {
            $discharge_pathway_data = CamisIboxDischargeAssigned::where('camis_patient_id', '=', $camis_patient_id)->first();
            if ($discharge_pathway_data != null) {
                $discharge_pathway_functional_identity                                    = 'Camis Discharge Pathway Data Assigned';

                $history_controller->HistoryTableDataInsertFromUpdateCreate($discharge_pathway_data, $discharge_pathway_history_modal, 3);
                $gov_text_after_arr                              = array();
                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $discharge_pathway_data->toArray(), 'Discharged Pathway Removed', array(), $discharge_pathway_functional_identity, 3);
                $discharge_pathway_data->delete();
            }
        }



        if ($request->has('is_referral')) {

            if ($request->tab == 'pending') {
                $cdt_tab = 0;
            } else {
                $cdt_tab = 2;
            }

            $cdt_patients = CamisIboxBoardRoundCDT::where('cdt_status', $cdt_tab)->pluck('patient_id')->toArray();
            $wards = Wards::where('status', 1)->orderBy('ward_name', 'asc')->pluck('ward_name', 'id')->toArray();
            $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();

            $patients_list = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $cdt_patients)->with(['BoardRoundCdt', 'BoardRoundCDTComment'])->when($request->filled('ward_id'), function ($q) use ($request) {
                return $q->whereIn('camis_patient_ward_id', WardToIDArray($request->ward_id));
            })
                ->select('ibox_actual_bed_full_name', 'camis_patient_name', 'camis_patient_pas_number', 'camis_consultant_name', 'camis_patient_admission_date_time', 'ibox_ward_name', 'camis_patient_id', 'camis_patient_sex')
                ->where('disabled_on_all_dashboard_except_ward_summary', 0)
                ->whereIn('ibox_ward_id', $wards_ids)
                ->orderBy('ibox_bed_group_name', 'ASC')
                ->orderBy('ibox_bed_group_number', 'ASC')
                ->orderBy('ibox_bed_priority', 'ASC')
                ->orderBy('ibox_bed_no', 'ASC')->get()->toArray();


            $patients = array_reduce($patients_list, function ($carry, $item) {
                $ward_name = $item['ibox_ward_name'];

                $carry[$ward_name][] = $item;

                return $carry;
            }, []);
            ksort($patients);
            $tab = $request->tab;
            $view = View::make('Dashboards.Camis.DischargeTracker.Partials.CdtReferral', compact('patients', 'tab', 'wards'));
            $success_array["html"] = $view->render();
            return ReturnArrayAsJsonToScript($success_array);
        }
        $cdt_final_date                                    = CamisIboxBoardRoundCDT::where('patient_id', '=', $camis_patient_id)->first();

        $success_array['cdt_status'] = PatientCDTStatus($cdt_final_date->cdt_action, $cdt_final_date->cdt_action_time, $cdt_final_date->is_equipment, $cdt_final_date->is_equipment_time, $cdt_final_date->discharge_for_today, $cdt_final_date->discharge_for_today_time);


        return ReturnArrayAsJsonToScript($success_array);
    }
    public function GetCDTTimeline(Request $request)
    {

        $success_array["status"]                                =   1;
        $success_array["message"]                               =   'ok';
        $searches = ['pathway', 'discharge tracker', 'care requirement', 'cdt status', 'cdt Comment'];
        $searches = array_map('strtolower', $searches);

        $query = GovernanceFrontendCamisOperationLogs::where('gov_patient_id', $request->camis_patient_id)
            ->where(function ($q) use ($searches) {
                $q->where(DB::raw('LOWER(gov_func_identity)'), 'LIKE', '%pathway%');

                foreach ($searches as $value) {
                    $q->orWhere(DB::raw('LOWER(gov_func_identity)'), 'LIKE', '%' . $value . '%');
                }
            });

        $success_array['governance_data'] = $query->latest()->get();
        $view                                                   =   View::make('Dashboards.Camis.DischargeTracker.Partials.CDTTimeline', compact('success_array'));
        return $view->render();
    }
    public function FetchDtocComment(Request $request)
    {
        $camis_patient_id = $request->camis_patient_id;
        $dtoc_comment_id = $request->comment_id;

        $edit_comment = CamisIboxBoardRoundDtocComment::where('id', $dtoc_comment_id)->first();

        $comment_list = CamisIboxBoardRoundDtocComment::where('patient_id', $camis_patient_id)->where('status', 1)->latest()->get();
        $view                                                           = View::make('Dashboards.Camis.DischargeTracker.Partials.CommentModalData', compact('comment_list', 'camis_patient_id', 'edit_comment'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function FetchCDTComment(Request $request)
    {
        $camis_patient_id = $request->camis_patient_id;
        $comments = '';
        $comment_list = CamisIboxBoardRoundCDTComment::where('patient_id', $camis_patient_id)->orderBy('updated_at', 'desc')->get()->toArray();
        $view                                                           = View::make('Dashboards.Camis.DischargeTracker.Partials.CDTCommentsOffcanvas', compact('comment_list'));
        $sections                                                       = $view->render();
        return $sections;
    }


    public function SaveCDTComment(Request $request)
    {

        $camis_patient_id   =  $request->camis_patient_id;
        $cdt_comments = $request->patient_cdt_comments;
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundCDTComment";
        $date_time_now                                              = CurrentDateOnFormat();
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $username                                                   = Sentinel::findById($user_id)->username ?? '';

        $success_array["date_time"]                                 = CurrentDateOnFormat();
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        if ($camis_patient_id != "" && $user_id != "") {


            $gov_text_before_arr                                    = CamisIboxBoardRoundCDTComment::where('patient_id', '=', $camis_patient_id)->orderBy('updated_at', 'desc')->first();
            if (isset($gov_text_before_arr->cdt_comment) && $gov_text_before_arr->cdt_comment == $cdt_comments) {

                $success_array["status"]    = 2;
                $success_array["message"]   = 'You Have Entered Same Comments';

                return ReturnArrayAsJsonToScript($success_array);
            }

            $updated_data                                           = CamisIboxBoardRoundCDTComment::create(['patient_id' => $camis_patient_id, 'cdt_comment' => $cdt_comments, 'updated_by' => $user_id]);

            $functional_identity                                    = 'Patient CDT Comments';

            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
            $success_array["message"]                           = DataUpdatedMessage();

            $updated_array                                  = $updated_data->getOriginal();
            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                if ($gov_text_before_arr) {
                    $gov_text_before                        = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                     = CamisIboxBoardRoundCDTComment::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $cdt_comments, $gov_text_after_arr, $functional_identity, 2);
                }
            }
            $success_array["status"]    = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function FetchGlobalDtocInfo(Request $request)
    {
        $success_array = [];




        $success_array['patient'] = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $request->camis_patient_id)->with([
            'BoardRoundMedicallyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
            },
            'BoardRoundPathwayRequirement',
            'BoardRoundCareRequirement',
            'BoardRoundCdt',
            'DischargeAssignedData'
        ])->whereNotNull('camis_patient_id')
            ->first()->toArray();

        $current_service_id = $success_array['patient']['board_round_pathway_requirement']['dtoc_pathway_id'] ?? 0;
        $success_array['dtoc_path_way_drop'] = DtocPathway::where('status', '=', 1)->orderBy('dtoc_pathway_text', 'ASC')->get();
        $success_array['dtoc_current_status_drop'] = DtocCurrentStatus::where('status', '=', 1)->orderBy('dtoc_current_status_text', 'ASC')->orderBy('dtoc_current_status_delay_code')->get();
        $success_array['dtoc_authority_drop'] = DtocAuthority::where('status', '=', 1)->orderBy('id', 'ASC')->get();
        $success_array['dtoc_service_value_drop'] = DtocServiceByPathway::where('pathway_id', $current_service_id)->where('pathway_id', '!=', 0)->where('status', 1)->pluck('service_text_value', 'id')->toArray();
        $success_array['dtoc_current_service_value_drop'] = DtocCurrentService::where('status', 1)->pluck('service_text_value', 'id')->toArray();
        $success_array['users'] = User::pluck('username', 'id')->toArray();
        $success_array['discharge_tracker_dropdown'] = DischargeTrackerDropdown::where('status', 1)->get();

        $view = View::make('Common.Modals.DtocModal', compact('success_array'));
        $sections = $view->render();
        return $sections;
    }

    public function FetchDtocCurrentService(Request $request)
    {
        $dtoc_current_service = DtocServiceByPathway::where('pathway_id', $request->pathway_value)->where('status', 1)->orderBy('service_text_value', 'asc')->pluck('service_text_value', 'id')->toArray();

        return response()->json($dtoc_current_service);
    }

    public function DtocWardCommentList($camis_patient_id)
    {
        $comment_list = CamisIboxBoardRoundDtocComment::where('patient_id', $camis_patient_id)->where('status', 1)->latest()->get();

        $view                                                           = View::make('Dashboards.Camis.DischargeTracker.Partials.CommentList', compact('comment_list', 'camis_patient_id'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function DtocWardGlobalCommentList($camis_patient_id)
    {
        $comment_list = CamisIboxBoardRoundDtocComment::where('patient_id', $camis_patient_id)->where('status', 1)->latest()->get();

        $view                                                           = View::make('Common.View.DischargeCommentList', compact('comment_list', 'camis_patient_id'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function DtocWardAllCommentList($camis_patient_id)
    {
        $comment_list = CamisIboxBoardRoundDtocComment::where('patient_id', $camis_patient_id)->where('status', 1)->latest()->get();

        $view                                                           = View::make('Dashboards.Camis.DischargeTracker.Partials.ViewAllCommentList', compact('comment_list', 'camis_patient_id'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function CommentHistory(Request $request)
    {
        $camis_patient_id     = $request->camis_patient_id;
        $patient = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $camis_patient_id)->first();
        $comment_list = HistoryCamisIboxBoardDtocComment::where('patient_id', $camis_patient_id)->with('User')->get();

        $view                                                           = View::make('Dashboards.Camis.DischargeTracker.Partials.CommentHistoryData', compact('comment_list', 'patient'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function SaveTUAsDefault(Request $request)
    {
        Session::put('initial_type', 'TU');
        return 'success';
    }

    public function SaveComment(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardDtocComment";
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $dtoc_patient_id                                            = $request->camis_patient_id;
        $dtoc_initials                                              = ($request->initials) ? $request->initials : '';
        $comment_priority                                              = $request->priority ? $request->priority : 0;
        $dtoc_dates                                                 = CurrentDateOnFormat();
        $dtoc_cmts                                                  = ($request->text) ? $request->text : '';
        $dtoc_dates_n                                               = PredefinedDateFormatDtocCommentDate($dtoc_dates);
        $join_cmt                                                   = $dtoc_initials . " - " . $dtoc_dates_n . " - " . $dtoc_cmts;
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime(CurrentDateOnFormat()));

        if ($dtoc_patient_id != "" && $user_id != "") {
            $gov_text_before                                        = '';
            $updated_data                                           = CamisIboxBoardRoundDtocComment::create(['patient_id' => $dtoc_patient_id, 'initials' => $dtoc_initials, 'date' => $dtoc_dates, 'priority' => $comment_priority, 'comments' => $dtoc_cmts, 'join_comments' => $join_cmt, 'updated_by' => $user_id, 'status' => 1]);
            $updated_data_array                                     = $updated_data->toArray();
            $updated_data_array['created_at']                       = PredefinedStandardDateFormatChange($updated_data_array['created_at']);
            $updated_data_array['updated_at']                       = PredefinedStandardDateFormatChange($updated_data_array['updated_at']);

            $functional_identity                                    = 'Discharge Tracker Comment';

            if (isset($updated_data_array) && count($updated_data_array) > 0) {
                $history_controller->HistoryTableDataInsertFromInsert($updated_data_array, $history_modal);
                $success_array["message"]                           = DataAddedMessage();
                $gov_text_before                                    = array();
                if (count($updated_data_array) > 0 && isset($updated_data_array['id'])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundDtocComment::where('id', '=', $updated_data_array['id'])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($dtoc_patient_id, $gov_text_before, $join_cmt, $gov_text_after_arr, $functional_identity, 1);

                    $success_array["status"]                        = 1;
                    $success_array['last_id']                       = $updated_data_array['id'];
                    $success_array['last_comment']                  = $updated_data_array['join_comments'];
                }
            }
        }

        $success_array = array();

        $success_array['offcanvas'] = self::DtocWardAllCommentList($dtoc_patient_id);
        $success_array['page'] = self::DtocWardCommentList($dtoc_patient_id);

        return $success_array;
    }




    public function NotApplicableComment(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardDtocComment";
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $cmt_dtoc_id                                                = $request->comment_id;
        $dtoc_patient_id                                            = CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->first()->patient_id;
        $dtoc_initials                                              = ($request->initials) ? $request->initials : '';
        $comment_priority                                              = ($request->priority) ? $request->priority : 0;
        $dtoc_dates                                                 = CurrentDateOnFormat();
        $dtoc_cmts                                                  = ($request->text) ? $request->text : '';
        $dtoc_dates_n                                               = PredefinedDateFormatDtocCommentDate($dtoc_dates);
        $join_cmt                                                   = $dtoc_dates_n . " - " . $dtoc_cmts;
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime(CurrentDateOnFormat()));
        $updated_data_array                                         = array();

        if ($cmt_dtoc_id != "" & $dtoc_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->first();
            $updated_data                                           = CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->update(['status' => 0]);
            $functional_identity                                    = 'Discharge Tracker Comment';
            if ($updated_data) {
                if ($gov_text_before_arr->comments != '' && $dtoc_cmts == '') {
                    CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->delete();
                    $updated_data_array                               = $gov_text_before_arr->toArray();
                    $updated_data_array['created_at']                 = PredefinedStandardDateFormatChange($updated_data_array['created_at']);
                    $updated_data_array['updated_at']                 = PredefinedStandardDateFormatChange($updated_data_array['updated_at']);
                    $history_controller->HistoryTableDataInsertFromDelete($updated_data_array, $history_modal);
                    $success_array["message"]                         = DataRemovalMessage();
                    $gov_text_before                                  = $updated_data_array;
                    $gov_text_after_arr                               = array();
                    $gov_des = $gov_text_before_arr->join_comments . '- Not Applicalable';
                    $this->GovernanceBoardRoundUpdatePreCall($dtoc_patient_id, $gov_text_before, $gov_des, $gov_text_after_arr, $functional_identity, 3);
                    $success_array["updated_date"]                    = '';
                    $success_array["status"]                          = 1;
                    $success_array['last_comment']                    = $updated_data_array['join_comments'];
                } else {
                    $updated_data_array                               = CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->first()->toArray();
                    $updated_data_array['created_at']                 = PredefinedStandardDateFormatChange($updated_data_array['created_at']);
                    $updated_data_array['updated_at']                 = PredefinedStandardDateFormatChange($updated_data_array['updated_at']);
                    $history_controller->HistoryTableDataInsertFromUpdate($updated_data_array, $history_modal);
                    $success_array["message"]                         = DataUpdatedMessage();
                    $success_array["status"]                          = 1;
                    $success_array['last_comment']                    = $updated_data_array['join_comments'];
                    if (isset($updated_data_array) && count($updated_data_array) > 0 && isset($updated_data_array['id'])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                         = $gov_text_before_arr->toArray();
                            $gov_text_before['created_at']           = PredefinedStandardDateFormatChange($gov_text_before['created_at']);
                            $gov_text_before['updated_at']           = PredefinedStandardDateFormatChange($gov_text_before['updated_at']);

                            $gov_text_after_arr                      = CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->first();
                            $this->GovernanceBoardRoundUpdatePreCall($dtoc_patient_id, $gov_text_before, $join_cmt, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
        }

        $success_array = array();

        $success_array['offcanvas'] = self::DtocWardAllCommentList($dtoc_patient_id);
        $success_array['page'] = self::DtocWardCommentList($dtoc_patient_id);

        return $success_array;
    }


    public function RemoveComment(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardDtocComment";
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $cmt_dtoc_id                                                = $request->comment_id;
        $dtoc_patient_id                                            = CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->first()->patient_id;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime(CurrentDateOnFormat()));
        $updated_data_array                                         = array();

        if ($cmt_dtoc_id != "" & $dtoc_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->first();
            $functional_identity                                    = 'Discharge Tracker Comment';

            if ($gov_text_before_arr != '') {
                CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->delete();
                $updated_data_array                               = $gov_text_before_arr->toArray();
                $updated_data_array['created_at']                 = PredefinedStandardDateFormatChange($updated_data_array['created_at']);
                $updated_data_array['updated_at']                 = PredefinedStandardDateFormatChange($updated_data_array['updated_at']);
                $history_controller->HistoryTableDataInsertFromDelete($updated_data_array, $history_modal);
                $success_array["message"]                         = DataRemovalMessage();
                $gov_text_before                                  = $updated_data_array;
                $gov_text_after_arr                               = array();
                $this->GovernanceBoardRoundUpdatePreCall($dtoc_patient_id, $gov_text_before, 'Removed', $gov_text_after_arr, $functional_identity, 3);
                $success_array["updated_date"]                    = '';
                $success_array["status"]                          = 1;
                $success_array['last_comment']                    = $updated_data_array['join_comments'];
            }
        }

        $success_array = array();

        $success_array['offcanvas'] = self::DtocWardAllCommentList($dtoc_patient_id);
        $success_array['page'] = self::DtocWardCommentList($dtoc_patient_id);

        return $success_array;
    }

    public function UpdateComment(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardDtocComment";
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $cmt_dtoc_id                                                = $request->comment_id;
        $dtoc_patient_id                                            = CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->first()->patient_id;
        $dtoc_initials                                              = ($request->initials) ? $request->initials : '';
        $comment_priority                                              = ($request->priority) ? $request->priority : 0;
        $dtoc_dates                                                 = CurrentDateOnFormat();
        $dtoc_cmts                                                  = ($request->text) ? $request->text : '';
        $dtoc_dates_n                                               = PredefinedDateFormatDtocCommentDate($dtoc_dates);
        $join_cmt                                                   = $dtoc_dates_n . " - " . $dtoc_cmts;
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime(CurrentDateOnFormat()));
        $updated_data_array                                         = array();

        if ($cmt_dtoc_id != "" & $dtoc_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->first();
            $updated_data                                           = CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->update(['patient_id' => $dtoc_patient_id, 'initials' => $dtoc_initials, 'date' => $dtoc_dates, 'comments' => $dtoc_cmts, 'priority' => $comment_priority, 'join_comments' => $join_cmt, 'updated_by' => $user_id]);
            $functional_identity                                    = 'Discharge Tracker Comment';
            if ($updated_data) {
                if ($gov_text_before_arr->comments != '' && $dtoc_cmts == '') {
                    CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->delete();
                    $updated_data_array                               = $gov_text_before_arr->toArray();
                    $updated_data_array['created_at']                 = PredefinedStandardDateFormatChange($updated_data_array['created_at']);
                    $updated_data_array['updated_at']                 = PredefinedStandardDateFormatChange($updated_data_array['updated_at']);
                    $history_controller->HistoryTableDataInsertFromDelete($updated_data_array, $history_modal);
                    $success_array["message"]                         = DataRemovalMessage();
                    $gov_text_before                                  = $updated_data_array;
                    $gov_text_after_arr                               = array();
                    $this->GovernanceBoardRoundUpdatePreCall($dtoc_patient_id, $gov_text_before, $join_cmt, $gov_text_after_arr, $functional_identity, 3);
                    $success_array["updated_date"]                    = '';
                    $success_array["status"]                          = 1;
                    $success_array['last_comment']                    = $updated_data_array['join_comments'];
                } else {
                    $updated_data_array                               = CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->first()->toArray();
                    $updated_data_array['created_at']                 = PredefinedStandardDateFormatChange($updated_data_array['created_at']);
                    $updated_data_array['updated_at']                 = PredefinedStandardDateFormatChange($updated_data_array['updated_at']);
                    $history_controller->HistoryTableDataInsertFromUpdate($updated_data_array, $history_modal);
                    $success_array["message"]                         = DataUpdatedMessage();
                    $success_array["status"]                          = 1;
                    $success_array['last_comment']                    = $updated_data_array['join_comments'];
                    if (isset($updated_data_array) && count($updated_data_array) > 0 && isset($updated_data_array['id'])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                         = $gov_text_before_arr->toArray();
                            $gov_text_before['created_at']           = PredefinedStandardDateFormatChange($gov_text_before['created_at']);
                            $gov_text_before['updated_at']           = PredefinedStandardDateFormatChange($gov_text_before['updated_at']);

                            $gov_text_after_arr                      = CamisIboxBoardRoundDtocComment::where('id', '=', $cmt_dtoc_id)->first();
                            $this->GovernanceBoardRoundUpdatePreCall($dtoc_patient_id, $gov_text_before, $join_cmt, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
        }

        $success_array = array();

        $success_array['offcanvas'] = self::DtocWardAllCommentList($dtoc_patient_id);
        $success_array['page'] = self::DtocWardCommentList($dtoc_patient_id);

        return $success_array;
    }


    public function Export(Request $request)
    {

        $selectedSearchText = $request->search_text;
        $allColumns = [
            //'patient_id'             => 'Patient ID',
            'nhs_number'             => 'NHS Number',
            'pas_id'                 => 'Hospital Number',
            'name'                   => 'Name',
            'dob'                    => 'Date Of Birth',
            'admission_date'         => 'Admission Date',
            'ward'                   => 'Ward',
            //'bed'                    => 'Bay & Bed',
            'referral_date'          => 'Referral Date',
            'services'               => 'Services',
            // 'current_status'         => 'Current Status',
            'los'                    => 'LOS',
            'medfit'                 => 'Med Fit',
            'confirm_discharge_date' => 'Confirmed Discharge Date',
            'pathway_name'           => 'Pathway',
            'authority_name'         => 'Authority',
            //'reason_name'            => 'Reason Code',
            'comment'                => 'Latest Comment',
        ];
        $patient_ids = CamisIboxBoardRoundCDT::where('cdt_status', 1)->pluck('patient_id')->toArray();

        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();

        $base_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $patient_ids)
            ->where('ibox_bed_type', 'Bed')
            ->whereIn('ibox_ward_id', $wards_ids)
            ->whereNull('camis_patient_discharge_date_time')
            ->with([
                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                },
                'BoardRoundEstimatedDischargeDate' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
                },
                'BoardRoundDtocComments',
                'BoardRoundPathwayRequirement.DtocPathway',
                'BoardRoundPathwayRequirement.DtocStatus',
                'BoardRoundPathwayRequirement.DtocAuthority',
                'BoardRoundReasonToReside.ReasonToResideCategory',
                'BoardRoundCareRequirement',
                'BoardRoundCdt'
            ])
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ibox_ward_name', 'ASC')
            ->orderBy('ibox_actual_bed_full_name', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')
            ->limit(1500);

        $all_patients = $base_query->get()->toArray();



        if ($request->filled('medfit') && $request->medfit != 'null') {

            if (in_array(1, explode(',', $request->medfit)) && in_array(0, explode(',', $request->medfit))) {
            } else if (in_array(1, explode(',', $request->medfit)) && !in_array(0, explode(',', $request->medfit))) {
                $all_patients = array_filter($all_patients, function ($patient) use ($request) {
                    return isset($patient['board_round_medically_fit_data']['patient_medically_fit_status']) &&
                        in_array($patient['board_round_medically_fit_data']['patient_medically_fit_status'], explode(',', $request->medfit));
                });
            } elseif (!in_array(1, explode(',', $request->medfit)) && in_array(0, explode(',', $request->medfit))) {
                $all_patients = array_filter($all_patients, function ($patient) {
                    return empty($patient['board_round_medically_fit_data']) ||
                        $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 0;
                });
            }
        }






        if ($request->filled('pathway_id')  && $request->pathway_id != 'null') {
            $all_patients = array_filter($all_patients, function ($patient) use ($request) {
                if (in_array('blank', explode(',', $request->pathway_id))) {
                    return (!isset($patient['board_round_pathway_requirement']['dtoc_pathway_id']) ||
                        empty($patient['board_round_pathway_requirement']['dtoc_pathway_id']) ||
                        (isset($patient['board_round_pathway_requirement']['dtoc_pathway_id']) &&
                            in_array($patient['board_round_pathway_requirement']['dtoc_pathway_id'], explode(',', $request->pathway_id))));
                } else {
                    return isset($patient['board_round_pathway_requirement']['dtoc_pathway_id']) &&
                        in_array($patient['board_round_pathway_requirement']['dtoc_pathway_id'], explode(',', $request->pathway_id));
                }
            });
        }



        if ($request->filled('authority_id')  && $request->authority_id != 'null') {
            $all_patients = array_filter($all_patients, function ($patient) use ($request) {


                if (in_array('blank', explode(',', $request->authority_id))) {
                    return (!isset($patient['board_round_pathway_requirement']['service_id']) ||
                        empty($patient['board_round_pathway_requirement']['service_id']) ||
                        (isset($patient['board_round_pathway_requirement']['service_id']) &&
                            in_array($patient['board_round_pathway_requirement']['service_id'], explode(',', $request->authority_id))));
                } else {
                    return isset($patient['board_round_pathway_requirement']['service_id']) &&
                        in_array($patient['board_round_pathway_requirement']['service_id'], explode(',', $request->authority_id));
                }
            });
        }





        if ($request->filled('service_id') && $request->service_id != 'null') {
            $all_patients = array_filter($all_patients, function ($patient) use ($request) {


                if (in_array('blank', explode(',', $request->service_id))) {
                    return (!isset($patient['board_round_pathway_requirement']['service_by_pathway_id']) ||
                        empty($patient['board_round_pathway_requirement']['service_by_pathway_id']) ||
                        (isset($patient['board_round_pathway_requirement']['service_by_pathway_id']) &&
                            in_array($patient['board_round_pathway_requirement']['service_by_pathway_id'], explode(',', $request->service_id))));
                } else {
                    return isset($patient['board_round_pathway_requirement']['service_by_pathway_id']) &&
                        in_array($patient['board_round_pathway_requirement']['service_by_pathway_id'], explode(',', $request->service_id));
                }
            });
        }



        if ($request->filled('search_text')) {
            $all_patients = array_filter($all_patients, function ($patient) use ($request) {
                $selected_search_text = $request->search_text;
                return (
                    stripos($patient['camis_patient_pas_number'], $selected_search_text) !== false ||
                    stripos($patient['camis_patient_surname'], $selected_search_text) !== false ||
                    stripos($patient['camis_patient_forename'], $selected_search_text) !== false
                );
            });
        }
        if ($request->filled('ward_id') && $request->ward_id != 'null') {
            $all_patients = array_filter($all_patients, function ($patient) use ($request) {
                return in_array($patient['ibox_ward_id'], $request->ward_id);
            });
        }
        if ($request->filled('date')) {
            $all_patients = array_filter($all_patients, function ($patient) use ($request) {


                if (!isset($patient['board_round_pathway_requirement']['planned_discharge_date'])) {
                    return false;
                }
                return (date('Y-m-d', strtotime($patient['board_round_pathway_requirement']['planned_discharge_date'])) == $request->date);
            });
        }
        if ($request->filled('sort_by') && $request->sort_by == 1) {
            usort($all_patients, function ($a, $b) {
                return strcmp($a['camis_patient_surname'], $b['camis_patient_surname']);
            });
        } elseif ($request->filled('sort_by') && $request->sort_by == 2) {
            usort($all_patients, function ($a, $b) {
                return strcmp($b['camis_patient_surname'], $a['camis_patient_surname']);
            });
        } elseif ($request->filled('sort_by') && $request->sort_by == 3) {

            usort($all_patients, function ($a, $b) {
                if (isset($a['board_round_pathway_requirement']['planned_discharge_date']) && isset($b['board_round_pathway_requirement']['planned_discharge_date'])) {
                    $dateA = strtotime($a['board_round_pathway_requirement']['planned_discharge_date']);
                    $dateB = strtotime($b['board_round_pathway_requirement']['planned_discharge_date']);
                    return $dateA - $dateB;
                }
                return 0;
            });
        } elseif ($request->filled('sort_by') && $request->sort_by == 4) {
            usort($all_patients, function ($a, $b) {
                if (isset($a['board_round_pathway_requirement']['planned_discharge_date']) && isset($b['board_round_pathway_requirement']['planned_discharge_date'])) {
                    $dateA = strtotime($a['board_round_pathway_requirement']['planned_discharge_date']);
                    $dateB = strtotime($b['board_round_pathway_requirement']['planned_discharge_date']);
                    return $dateB - $dateA;
                }
                return 0;
            });
        }


        $name = 'Discharge Tracker';
        $heading = ["NHS Number", "Hospital Number", "Name", "Date Of Birth", "Admission Date", "Ward", "Referral Date", "Services", "LOS", "Med Fit", "Confirmed Discharge Date", "Pathway", "Authority",   "Latest Comment"];
        $patientList = collect($all_patients);
        $rows = $patientList->map(function ($patient) {

            $latestComment = '';
            if (!empty($patient['board_round_dtoc_comments'])) {
                usort($patient['board_round_dtoc_comments'], function ($a, $b) {
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                });
                $latestComment = $patient['board_round_dtoc_comments'][0]['join_comments'] ?? '';
            }

            $medfit = (isset($patient['board_round_medically_fit_data']['patient_medically_fit_status'])
                && $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1) ? 'Yes' : 'No';

            $referral_date = '';
            if (isset($patient['board_round_cdt']['cdt_status']) &&  $patient['board_round_cdt']['cdt_status'] == 1) {
                if (isset($patient['board_round_cdt']['accepted_by_username'], $patient['board_round_cdt']['accepted_date'])) {
                    $referral_date = $patient['board_round_cdt']['accepted_by_username'] . ' - ' . PredefinedDateFormatFor24Hour($patient['board_round_cdt']['accepted_date']);
                }
            }

            $service_by_pathway_text = $patient['board_round_pathway_requirement']['service_by_pathway_text'] ?? '--';
            $current_status_text     = $patient['board_round_pathway_requirement']['dtoc_status']['dtoc_current_status_text'] ?? '--';
            $confirm_discharge_date  = isset($patient['board_round_pathway_requirement']['planned_discharge_date'])
                ? PredefinedDateFormatForPD($patient['board_round_pathway_requirement']['planned_discharge_date'])
                : '--';

            $pathway_name = $patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text'] ?? '--';

            if (!empty($patient['board_round_pathway_requirement']['dtoc_service_text'])) {
                $authority_name = (strtolower($patient['board_round_pathway_requirement']['dtoc_service_text']) == 'ooa')
                    ? 'OOA: ' . $patient['board_round_pathway_requirement']['others_authority_text']
                    : $patient['board_round_pathway_requirement']['dtoc_service_text'];
            } else {
                $authority_name = '--';
            }

            $reason_name = $patient['board_round_pathway_requirement']['dtoc_authority']['dtoc_authority_text'] ?? '--';

            return [
                //'patient_id'             => $patient['camis_patient_id'] ?? '',
                'nhs_number'             => $patient['camis_patient_nhs_number'] ?? '',
                'pas_id'                 => $patient['camis_patient_pas_number'] ?? '',
                'name'                   => $patient['camis_patient_name'] ?? '',
                'dob'                    => !empty($patient['camis_patient_date_of_birth']) ? PredefinedDateFormatForPD($patient['camis_patient_date_of_birth']) : '--',
                'admission_date'         => !empty($patient['camis_patient_admission_date_time']) ? PredefinedDateFormatFor24Hour($patient['camis_patient_admission_date_time']) : '',
                'ward'                   => $patient['ibox_ward_name'] ?? '',
                //'bed'                    => $patient['ibox_actual_bed_full_name'] ?? '',
                'referral_date'          => $referral_date,
                'services'               => $service_by_pathway_text,
                //'current_status'         => $current_status_text,
                'los'                    => NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date'], date('Y-m-d')) . ' Days',
                'medfit'                 => $medfit,
                'confirm_discharge_date' => $confirm_discharge_date,
                'pathway_name'           => $pathway_name,
                'authority_name'         => $authority_name,
                //'reason_name'            => $reason_name,
                'comment'                => $latestComment,
            ];
        });

        $requested = collect(explode(',', (string)$request->input('columns', '')))
            ->map(fn($k) => trim($k))
            ->filter()
            ->unique()
            ->values();

        $selected = $requested->isNotEmpty()
            ? $requested->filter(fn($k) => array_key_exists($k, $allColumns))->values()
            : collect(array_keys($allColumns));

        $heading = $selected->map(fn($k) => $allColumns[$k])->all();

        $dischargeList = $rows->map(fn($row) => collect($row)->only($selected)->all());

        $name = 'Discharge Tracker';
        return ExportFunction($dischargeList, $heading, $name);
    }





    public function MedfitTab(Request $request)
    {

        if (CheckDashboardPermission('discharge_tracker_medfit_')) {
            $success_array['reason_to_reside']                              = ReasonToResideGroup::where('status', 1)->get();

            return view('Dashboards.Camis.DischargeTracker.Medfit', compact('success_array'));
        } elseif (CheckDashboardPermission('discharge_tracker_month_summary_view')) {
            return redirect()->route('discharged.month.summary');
        } elseif (CheckDashboardPermission('discharge_tracker_month_list_summary_view')) {
            return redirect()->route('discharged.monthlist.summary');
        } elseif (CheckDashboardPermission('discharge_tracker_patient_search_view')) {
            return redirect()->route('discharged.patient.search');
        } elseif (CheckDashboardPermission('discharge_tracker_discharge_view')) {
            return redirect()->route('discharged.dischargepatient');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }

    public function MedfitDataLoad(Request $request)
    {
        if ($request->tab == 'yes' && CheckSpecificPermission('discharge_tracker_medfit_yes_view')) {
            return self::MedFitYesDataLoad();
        } elseif ($request->tab == 'yes_day' && CheckSpecificPermission('discharge_tracker_medfit_yes_view')) {
            $success_array = [];

            if ($request->filled('date')) {
                $date = $request->date;
            } else {
                $date = date('Y-m-d');
            }

            $data = CamisIboxDtocMonthlyStored::where('date', $date)

                ->orderBy('date', 'asc')
                ->get()->toArray();

            $day_summary = [];
            $cdt_count = 0;
            foreach ($data as $item) {
                $authority = $item['authority'];
                if ($authority == 'cdt') {
                    $cdt_count = $item['cdt_patients'];
                    continue;
                }

                if (!isset($day_summary[$authority])) {
                    $day_summary[$authority] = [
                        'pathway_0' => 0,
                        'pathway_1' => 0,
                        'pathway_2' => 0,
                        'pathway_3' => 0,
                    ];
                }

                foreach (['pathway_0', 'pathway_1', 'pathway_2', 'pathway_3'] as $pathway_key) {
                    $day_summary[$authority][$pathway_key] += $item[$pathway_key];
                }
            }
            $day_summary = array_map(function ($item) {
                $item['total'] = array_sum($item);
                return $item;
            }, $day_summary);
            $success_array['cdt_patients'] = $cdt_count;
            $success_array['medfit_data'] = $day_summary;
            $success_array['selected_date'] = $date;
            $view = View::make('Dashboards.Camis.DischargeTracker.Partials.MedfitYesDayData', compact('success_array'));
            $sections = $view->render();
            return $sections;
        } else {
            if (CheckSpecificPermission('discharge_tracker_medfit_no_view')) {
                return self::MedFitNoDataLoad();
            } else {
                return PermissionDenied();
            }
        }
    }

    public function MedFitYesDataLoad()
    {
        $success_array = array();
        $cdt_patients = CamisIboxBoardRoundCDT::where('cdt_status', 1)->pluck('patient_id')->toArray();
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();

        $base_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $cdt_patients)->where('disabled_on_all_dashboard_except_ward_summary', 0)->whereNull('camis_patient_discharge_date_time')
            ->select('camis_patient_id')
            ->where('ibox_bed_type', 'Bed')
            ->whereIn('ibox_ward_id', $wards_ids)
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->whereNull('camis_patient_discharge_date_time')
            ->with([
                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                },

            ])

            ->orderBy('ibox_ward_name', 'ASC')
            ->orderBy('ibox_actual_bed_full_name', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')
            ->get()->toArray();

        $medfit_yes_patients = array_filter($base_query, function ($patient) {
            return !empty($patient['board_round_medically_fit_data']) &&
                $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1;
        });

        $camis_patient_ids = array_column(array_filter($medfit_yes_patients, function ($item) {
            return isset($item['camis_patient_id']);
        }), 'camis_patient_id');

        $query = CamisIboxBoardRoundPathwayRequirement::selectRaw('dtoc_service_text,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 0%" THEN 1 ELSE 0 END) as p0,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 1%" THEN 1 ELSE 0 END) as p1,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 2%" THEN 1 ELSE 0 END) as p2,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 3%" THEN 1 ELSE 0 END) as p3,
            COUNT(*) as total')
            ->whereIn('patient_id', $camis_patient_ids)
            ->groupBy('dtoc_service_text');

        $results = $query->get();

        foreach ($results as $result) {
            $service = $result->dtoc_service_text;
            $success_array[$service]['service'] = $service;
            $success_array[$service]['p0'] = $result->p0;
            $success_array[$service]['p1'] = $result->p1;
            $success_array[$service]['p2'] = $result->p2;
            $success_array[$service]['p3'] = $result->p3;
            $success_array[$service]['total'] = ($result->p0 + $result->p1 + $result->p2 + $result->p3);
        }
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();

        $all_inpatients                                                 = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->whereIn('ibox_ward_id', $wards_ids)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('camis_patient_id')->toArray();
        $cdt_count = CamisIboxBoardRoundCDT::whereIn('cdt_status', [0])->whereIn('patient_id', $all_inpatients)->get()->toArray();

        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.MedfitYesLiveData', compact('success_array', 'cdt_count'));
        $sections = $view->render();
        return $sections;
    }



    public function MedfitYesExport()
    {
        $success_array = array();
        $cdt_patients = CamisIboxBoardRoundCDT::where('cdt_status', 1)->pluck('patient_id')->toArray();
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();

        $base_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('ibox_ward_id', $wards_ids)->whereIn('camis_patient_id', $cdt_patients)->where('disabled_on_all_dashboard_except_ward_summary', 0)->whereNull('camis_patient_discharge_date_time')
            ->select('camis_patient_id')
            ->where('ibox_bed_type', 'Bed')
            ->whereNull('camis_patient_discharge_date_time')
            ->with([
                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                },
            ])

            ->orderBy('ibox_ward_name', 'ASC')
            ->orderBy('ibox_actual_bed_full_name', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')
            ->get()->toArray();

        $medfit_yes_patients = array_filter($base_query, function ($patient) {
            return !empty($patient['board_round_medically_fit_data']) &&
                $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1;
        });

        $camis_patient_ids = array_column(array_filter($medfit_yes_patients, function ($item) {
            return isset($item['camis_patient_id']);
        }), 'camis_patient_id');



        $query = CamisIboxBoardRoundPathwayRequirement::selectRaw('dtoc_service_text,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 0%" THEN 1 ELSE 0 END) as p0,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 1%" THEN 1 ELSE 0 END) as p1,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 2%" THEN 1 ELSE 0 END) as p2,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 3%" THEN 1 ELSE 0 END) as p3,
            COUNT(*) as total')
            ->whereIn('patient_id', $camis_patient_ids)
            ->groupBy('dtoc_service_text');

        $results = $query->get();

        $p_tbc = 0;
        $p0 = 0;
        $p1 = 0;
        $p2 = 0;
        $p3 = 0;
        $total = 0;

        foreach ($results as $result) {
            $service = $result->dtoc_service_text;
            $success_array[$service]['service'] = $service;
            $success_array[$service]['p0'] = $result->p0;
            $success_array[$service]['p1'] = $result->p1;
            $success_array[$service]['p2'] = $result->p2;
            $success_array[$service]['p3'] = $result->p3;
            $success_array[$service]['total'] = ($result->p0 + $result->p1 + $result->p2 + $result->p3);

            $p_tbc += $result->p_tbc;
            $p0 += $result->p0;
            $p1 += $result->p1;
            $p2 += $result->p2;
            $p3 += $result->p3;
            $total += ($result->p0 + $result->p1 + $result->p2 + $result->p3);
        }

        $extra_data = ['service' => 'Total', 'p0' => $p0, 'p1' => $p1, 'p2' => $p2, 'p3' => $p3, 'total' => $total];
        array_push($success_array, $extra_data);

        $data = collect($success_array);

        $name = 'Medfit Yes List';
        $heading =  ["Service", "P TBC", "P0", "P1", "P2", "P3", "Total"];
        return ExportFunction($data, $heading, $name);
    }



    public function MedfitYesContentLoad(Request $request)
    {
        $success_array = array();
        $service = $request->service;
        $pathway_type = $request->pathway_type;

        $cdt_patients = CamisIboxBoardRoundCDT::where('cdt_status', 1)->pluck('patient_id')->toArray();
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();

        $base_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('ibox_ward_id', $wards_ids)->whereIn('camis_patient_id', $cdt_patients)->whereNull('camis_patient_discharge_date_time')
            ->select('camis_patient_id')
            ->where('ibox_bed_type', 'Bed')
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->whereNull('camis_patient_discharge_date_time')
            ->with([
                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                },
            ])

            ->orderBy('ibox_ward_name', 'ASC')
            ->orderBy('ibox_actual_bed_full_name', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')
            ->get()->toArray();

        $medfit_yes_patients = array_filter($base_query, function ($patient) {
            return !empty($patient['board_round_medically_fit_data']) &&
                $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1;
        });

        $camis_patient_ids = array_column(array_filter($medfit_yes_patients, function ($item) {
            return isset($item['camis_patient_id']);
        }), 'camis_patient_id');



        $oathway_name = match ($pathway_type) {
            'P0' => 'Pathway 0',
            'P1' => 'Pathway 1',
            'P2' => 'Pathway 2',
            'P3' => 'Pathway 3',
            'TOTAL' => 'TOTAL',
        };

        $patient_ids = CamisIboxBoardRoundPathwayRequirement::whereIn('patient_id', $camis_patient_ids)
            ->when($service != 'TOTAL', function ($query) use ($service) {
                return $query->where('dtoc_service_text', $service);
            })
            ->when($pathway_type != 'TOTAL', function ($query) use ($oathway_name) {
                return $query->where('dtoc_pathway_text', 'like', $oathway_name . '%');
            })

            ->whereHas('PatientInformationWithBedDetails', function ($q) {
                $q->whereNull('camis_patient_discharge_date_time');
            })
            ->pluck('patient_id')
            ->unique()
            ->toArray();
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();

        $patients = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('ibox_ward_id', $wards_ids)->whereIn('camis_patient_id', $patient_ids)
            ->with([
                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                },
                'BoardRoundEstimatedDischargeDate' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
                },
                'BoardRoundDtocComments',
                'BoardRoundPathwayRequirement.DtocPathway',
                'BoardRoundPathwayRequirement.DtocStatus',
                'BoardRoundPathwayRequirement.DtocAuthority',
                'BoardRoundReasonToReside.ReasonToResideCategory',
                'PotentialDefinite',
                'BoardRoundEdn',
                'BoardRoundTto',
                'PatientVitalPacInfo',
                'PatientWiseFlags',
                'BoardRoundCdt'
            ])
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ibox_ward_name', 'ASC')
            ->orderBy('ibox_actual_bed_full_name', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')
            ->limit(1500)
            ->get()
            ->toArray();

        $ward_names = array_unique(array_column($patients, 'ibox_ward_name'));

        $success_array['all_wards'] = $ward_names;
        $success_array['all_patients'] = $patients;

        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.MedfitYesPatientList', compact('success_array'));
        $sections = $view->render();
        return $sections;
    }



    public function MedfitNoDataCalculation(&$success_array)
    {
        $all_wards                                      = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->orderBy('ward_name', 'asc')->get();
        $all_wards_filter                               = Wards::where('status', '=', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->orderBy('ward_short_name', 'ASC')->get()->toArray();
        $base_query                                     = CamisIboxWardPatientInformationWithBedDetailsView::select('camis_patient_id', 'ibox_ward_id', 'ibox_ward_name')
            ->whereNotNull('camis_patient_id')->where('ibox_bed_type', 'Bed')->whereNull('camis_patient_discharge_date_time')->whereIn('ibox_ward_id', array_column($all_wards_filter, 'id'))
            ->with(['BoardRoundMedicallyFitData', 'BoardRoundReasonToReside' => function ($q) {
                $q->whereNull('reason_to_reside_end_date')->where('patient_reason_to_reside_status', '!=', 0);
            }, 'BoardRoundReasonToReside.ReasonToResideCategory'])
            ->orderBy('ibox_ward_name', 'ASC')
            ->orderBy('ibox_actual_bed_full_name', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')

            ->get()->toArray();
        $physiology_total                               = 0;
        $treatment_total                                = 0;
        $recovery_total                                 = 0;
        $function_total                                 = 0;
        $r2r_total                                      = 0;
        $primary_reason_total                                 = 0;
        $rehabilation_total                                       = 0;
        $total_total                                    = 0;
        $success_array                                  = [];
        $data = [];

        foreach ($all_wards as $wards) {
            $data[$wards->ward_name]['ward_name'] = $wards->ward_name;
            $data[$wards->ward_name]['physiology'] = 0;

            $data[$wards->ward_name]['recovery'] = 0;
            $data[$wards->ward_name]['treatment'] = 0;
            $data[$wards->ward_name]['function'] = 0;
            $data[$wards->ward_name]['primary_reason'] = 0;
            $data[$wards->ward_name]['rehabilation'] = 0;
            $data[$wards->ward_name]['rr_not_set'] = 0;
        }
        foreach ($base_query as $patient) {
            $ward = $patient['ibox_ward_name'];
            $data[$ward]['ward_name'] = $ward;
            if (isset($patient['board_round_medically_fit_data']['patient_medically_fit_status']) && $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1) {
                continue;
            }

            if (isset($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category']) && !empty($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category'])) {
                if (strtolower($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category']) == 'physiology') {
                    $data[$ward]['physiology']++;
                    $physiology_total++;
                } elseif (strtolower($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category']) == 'recovery') {
                    $data[$ward]['recovery']++;
                    $recovery_total++;
                } elseif (strtolower($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category']) == 'treatment') {
                    $data[$ward]['treatment']++;
                    $treatment_total++;
                } elseif (strtolower($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category']) == 'function') {
                    $data[$ward]['function']++;
                    $function_total++;
                } elseif (strtolower($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category']) == strtolower('Primary_Reason_-_Criteria_to_Reside')) {
                    $data[$ward]['primary_reason']++;
                    $primary_reason_total++;
                } elseif (strtolower($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category']) == strtolower('Rehabilitation._Reablement_And_Recovery_Stage')) {
                    $data[$ward]['rehabilation']++;
                    $rehabilation_total++;
                }
                $total_total++;
            } elseif (isset($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category']) && empty($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category'])) {
                $data[$ward]['rr_not_set']++;
                $r2r_total++;
                $total_total++;
            } elseif (!isset($patient['board_round_reason_to_reside']['patient_id'])) {
                $data[$ward]['rr_not_set']++;
                $r2r_total++;
                $total_total++;
            }
        }
        $data['Total']['ward_name'] = 'Total';
        $data['Total']['physiology'] = $physiology_total;
        $data['Total']['recovery'] = $recovery_total;
        $data['Total']['treatment'] = $treatment_total;
        $data['Total']['function'] = $function_total;

        $data['Total']['primary_reason'] = $primary_reason_total;
        $data['Total']['rehabilation'] = $rehabilation_total;


        $data['Total']['rr_not_set'] = $r2r_total;
        $data = array_map(function ($values) {
            foreach ($values as $key => $value) {
                if (!is_numeric($value)) {
                    $values[$key] = 0;
                }
            }
            $values['total'] = array_sum($values);
            return $values;
        }, $data);


        $success_array['result'] = $data;
    }
    public function MedFitNoDataLoad()
    {
        $process_array                                  = array();
        $success_array                                  = array();
        $this->MedfitNoDataCalculation($success_array);
        $view                                           = View::make('Dashboards.Camis.DischargeTracker.Partials.MedfitNoData', compact('success_array'));
        $sections                                       = $view->render();
        return $sections;
    }

    public function MedfitNoExport()
    {
        $process_array                                  = array();
        $success_array                                  = array();
        $this->MedfitNoDataCalculation($success_array);

        $data                                           = collect(array_values($success_array['result']));

        $name                                           = 'Medfit No List';
        $heading                                        = ["Ward Name", "PHYSIOLOGY", "RECOVERY", "TREATMENT", "FUNCTION", "PR-CTR", "RRR Stage", "R2R NOT SET", "Total"];

        return ExportFunction($data, $heading, $name);
    }


    public function MonthSummary()
    {

        if (CheckDashboardPermission('discharge_tracker_month_summary_view')) {
            return view('Dashboards.Camis.DischargeTracker.MonthSummary');
        } elseif (CheckDashboardPermission('discharge_tracker_month_list_summary_view')) {
            return redirect()->route('discharged.monthlist.summary');
        } elseif (CheckDashboardPermission('discharge_tracker_patient_search_view')) {
            return redirect()->route('discharged.patient.search');
        } elseif (CheckDashboardPermission('discharge_tracker_discharge_view')) {
            return redirect()->route('discharged.dischargepatient');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }

    public function MonthListSummary()
    {

        if (CheckDashboardPermission('discharge_tracker_month_list_summary_view')) {
            return view('Dashboards.Camis.DischargeTracker.MonthListSummary');
        } elseif (CheckDashboardPermission('discharge_tracker_patient_search_view')) {
            return redirect()->route('discharged.patient.search');
        } elseif (CheckDashboardPermission('discharge_tracker_discharge_view')) {
            return redirect()->route('discharged.dischargepatient');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }

    public function MonthSummaryDataLoad(Request $request)
    {
        $success_array = array();
        $current_date = Carbon::now();

        $last_12_months = [];
        for ($i = 0; $i < 12; $i++) {
            $last_12_months[] = $current_date->format('F Y');
            $current_date->subMonth();
        }

        if ($request->filled('month')) {
            $selected_date = $request->month;
        } else {
            $selected_date = date('F Y');
        }

        $carbon_date = Carbon::createFromFormat('F Y', $selected_date);

        $month = $carbon_date->format('m');
        $year = $carbon_date->format('Y');

        $success_array['month_list'] = $last_12_months;
        $success_array['selected_date'] = $selected_date;




        $data = CamisIboxDtocMonthlyStored::where('authority', '!=', 'cdt')->whereMonth('updated_at', $month)
            ->whereYear('updated_at', $year)

            ->orderBy('date', 'asc')
            ->get()->toArray();


        $month_summary = [];

        foreach ($data as $item) {
            $authority = $item['authority'];


            if (!isset($month_summary[$authority])) {
                $month_summary[$authority] = [
                    'pathway_0' => 0,
                    'pathway_1' => 0,
                    'pathway_2' => 0,
                    'pathway_3' => 0,
                ];
            }

            foreach (['pathway_0', 'pathway_1', 'pathway_2', 'pathway_3'] as $pathway_key) {
                $month_summary[$authority][$pathway_key] += $item[$pathway_key];
            }
        }


        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.MonthSummary', compact('success_array', 'month_summary'));
        $sections = $view->render();
        return $sections;
    }


    public function MonthListSummaryDataLoad(Request $request)
    {
        $success_array = [];
        $current_date = Carbon::now();
        $last_12_months = [];

        for ($i = 0; $i < 12; $i++) {
            $last_12_months[] = $current_date->format('F Y');
            $current_date->subMonth();
        }

        $selected_date = $request->filled('month') ? $request->month : date('F Y');
        $carbon_date = Carbon::createFromFormat('F Y', $selected_date);
        $month = $carbon_date->format('m');
        $year = $carbon_date->format('Y');

        $success_array['month_list'] = $last_12_months;
        $success_array['selected_date'] = $selected_date;
        $success_array['data'] = [];
        $success_array['month_data'] = [];


        $data = CamisIboxDtocMonthlyStored::where('authority', '!=', 'cdt')->when(function ($query) use ($month, $year) {
            $query->whereMonth('date', $month)
                ->whereYear('date', $year);
        })

            ->orderBy('date', 'asc')
            ->get()->toArray();


        $day_summary = [];

        $month_summary = [];

        foreach ($data as $item) {
            $date = $item['date'];
            $authority = $item['authority'];

            if (!isset($day_summary[$date][$authority])) {
                $day_summary[$date][$authority] = [
                    'pathway_0' => 0,
                    'pathway_1' => 0,
                    'pathway_2' => 0,
                    'pathway_3' => 0,
                ];
            }

            if (!isset($month_summary[$authority])) {
                $month_summary[$authority] = [
                    'pathway_0' => 0,
                    'pathway_1' => 0,
                    'pathway_2' => 0,
                    'pathway_3' => 0,
                ];
            }

            foreach (['pathway_0', 'pathway_1', 'pathway_2', 'pathway_3'] as $pathway_key) {
                $day_summary[$date][$authority][$pathway_key] += $item[$pathway_key];
                $month_summary[$authority][$pathway_key] += $item[$pathway_key];
            }
        }


        ksort($day_summary);
        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.MonthListSummary', compact('success_array', 'day_summary', 'month_summary'));
        $sections = $view->render();
        return $sections;
    }


    public function PatientSearch(Request $request)
    {
        if (CheckDashboardPermission('discharge_tracker_patient_search_view')) {
            return view('Dashboards.Camis.DischargeTracker.PatientSearch');
        } elseif (CheckDashboardPermission('discharge_tracker_discharge_view')) {
            return redirect()->route('discharged.dischargepatient');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }

    public function PatientSearchDataLoad(Request $request)
    {
        $success_array  = array();
        $patient_key = $request->patient_key;


        if ($request->filled('patient_key')) {
            $all_wards                              = Wards::where('status', '=', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();


            $success_array['all_patients'] = CamisIboxWardPatientInformationWithBedDetailsFullList::whereNotNull('camis_patient_id')
                ->whereNotNull('camis_patient_ward_id')
                ->where('disabled_on_all_dashboard_except_ward_summary', 0)
                ->whereIn('camis_patient_ward', $all_wards)
                ->with([
                    'BoardRoundMedicallyFitData' => function ($q) {
                        $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                    },
                    'BoardRoundEstimatedDischargeDate' => function ($q) {
                        $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
                    },
                    'BoardRoundDtocComments',
                    'BoardRoundPathwayRequirement.DtocPathway',
                    'BoardRoundPathwayRequirement.DtocAuthority',
                    'BoardRoundReasonToReside.ReasonToResideCategory'
                ])

                ->when($request->filled('patient_key'), function ($query) use ($patient_key) {
                    return $query->where(function ($q) use ($patient_key) {
                        $q->where('camis_patient_name', 'like', '%' . $patient_key . '%')
                            ->orWhere('camis_patient_id', 'like', '%' . $patient_key . '%')
                            ->orWhere('camis_patient_pas_number', 'like', '%' . $patient_key . '%')
                            ->orWhere('camis_patient_surname', 'like', '%' . $patient_key . '%')
                            ->orWhere('camis_patient_forename', 'like', '%' . $patient_key . '%');
                    });
                })
                ->orderBy('camis_patient_ward', 'ASC')
                ->limit(1500)
                ->get()
                ->toArray();
        } else {
            $success_array['all_patients'] = array();
        }
        $wards_list = array_unique(array_column($success_array['all_patients'], 'camis_patient_ward'));
        asort($wards_list);
        $success_array['ward_list'] = Wards::where('status', 1)->pluck('ward_name', 'ward_short_name')->toArray();
        $success_array['all_wards'] = $wards_list;
        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.PatientSearch', compact('success_array'));
        $sections = $view->render();
        return $sections;
    }

    public function Discharges(Request $request)
    {

        if (CheckDashboardPermission('discharge_tracker_discharge_view')) {
            return view('Dashboards.Camis.DischargeTracker.Discharges');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }

    public function DischargeDataLoad(Request $request)
    {
        $success_array  = array();
        if ($request->filled('date')) {
            $selected_date = $request->date;
        } else {
            $selected_date = date('Y-m-d');
        }
        $keyword = $request->search_text;
        $all_wards                              = Wards::where('status', '=', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();

        $patient_list =  CamisIboxWardPatientInformationWithBedDetailsFullList::with(['DischargeAssignedData', 'OtherNotes'])->whereIn('camis_patient_ward', $all_wards)->whereNotNull('camis_patient_id')
            ->where(function ($q) use ($keyword) {
                $q->where('camis_patient_name', 'like', '%' . $keyword . '%')
                    ->orWhere('camis_patient_id', 'like', '%' . $keyword . '%')
                    ->orWhere('camis_patient_pas_number', 'like', '%' . $keyword . '%')
                    ->orWhere('camis_patient_surname', 'like', '%' . $keyword . '%')
                    ->orWhere('camis_patient_forename', 'like', '%' . $keyword . '%');
            })
            ->when($request->filled('time'), function ($query) use ($request) {
                return $query->where(function ($q) use ($request) {
                    $los_21_plus = Carbon::parse($request->date)->subDays(21)->toDateString();

                    if ($request->time == 1) {
                        $q->whereTime('camis_patient_discharge_date_time', '<=', '' . $request->date . ' 17:00:00');
                    } elseif ($request->time == 2) {
                        $q->whereTime('camis_patient_discharge_date_time', '>=', '' . $request->date . ' 17:00:00')
                            ->whereTime('camis_patient_discharge_date_time', '<=', ' ' . $request->date . '23:59:00');
                    } elseif ($request->time == 3) {
                        $q->whereTime('camis_patient_discharge_date_time', '<=', '' . $request->date . ' 17:00:00')
                            ->whereDate('camis_patient_admission_date_time', '<', $los_21_plus);
                    } elseif ($request->time == 4) {
                        $q->whereTime('camis_patient_discharge_date_time', '>=', '' . $request->date . ' 17:00:00')
                            ->whereTime('camis_patient_discharge_date_time', '<=', '' . $request->date . ' 23:59:00')
                            ->whereDate('camis_patient_admission_date_time', '<', $los_21_plus);
                    }
                });
            })
            ->when($request->filled('ward_id'), function ($q) use ($request) {
                $q->whereIn('camis_patient_ward_id', $request->ward_id);
            })
            ->whereDate('camis_patient_discharge_date', $selected_date)->get()->toArray();

        $success_array['all_wards'] = Wards::pluck('ward_name', 'ward_short_name')->toArray();
        $success_array['discharges_from_cdt_count'] = count($patient_list);
        $final_patient_list = array_reduce($patient_list, function ($carry, $item) use ($success_array) {
            $ward_short_name = $item['camis_patient_ward'];
            $ward_name = $success_array['all_wards'][$ward_short_name] ?? 'Unknown Ward';
            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($final_patient_list);
        $success_array['patient_list'] = $final_patient_list;
        $success_array['discharge_tracker_dropdown'] = DischargeTrackerDropdown::where('status', 1)->get();
        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.DischargesDataLoad', compact('success_array'));
        $sections = $view->render();
        return $sections;
    }


    public function DischargeDataSave(Request $request)
    {
        $success_array  = array();
        $camis_patient_id = $request->camis_patient_id;
        $dt_drop_id = $request->dt_drop_id;
        $admit_time = $request->admit_time;
        $discharge_time = $request->discharge_time;
        $history_controller = new HistoryController;
        $history_modal = "App\Models\History\HistoryCamisDischargeDataAssigned";
        $user_id = Session()->get('LOGGED_USER_ID', '');
        $date_time_now = CurrentDateOnFormat();
        $discharge_cat = DischargeTrackerDropdown::where('discharge_drop_id', $dt_drop_id)->first();
        $pathway_name = $discharge_cat->discharge_pathway_name ?? '';
        $pathway_full_name = $discharge_cat->discharge_drop_name ?? '';
        $pathway_extra = $discharge_cat->discharge_pathway_extra_name ?? '';
        $functional_identity                                    = 'Camis Discharge Pathway Data Assigned';

        if ($request->filled('camis_patient_id')) {
            if ($request->filled('dt_drop_id') && $discharge_cat != null) {

                $gov_text_before_arr                                    = CamisIboxDischargeAssigned::where('camis_patient_id', '=', $camis_patient_id)->first();
                $updated_data                                           = CamisIboxDischargeAssigned::updateOrCreate(['camis_patient_id' => $camis_patient_id], ['dt_drop_id' => $dt_drop_id, 'discharge_tracker_discharge_patients_assigned' => date('Y-m-d'), 'discharge_date' => $discharge_time, 'admission_date' => $admit_time, 'pathway_name' => $pathway_name, 'pathway_extra_name' => $pathway_extra, 'updated_by' => $user_id]);
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxDischargeAssigned::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $pathway_full_name, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxDischargeAssigned::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $pathway_full_name, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            } else {
                $gov_text_before_arr                                    = CamisIboxDischargeAssigned::where('camis_patient_id', '=', $camis_patient_id)->first();
                if ($gov_text_before_arr) {

                    $updated_data                                    = $gov_text_before_arr;
                    $history_controller->HistoryTableDataInsertFromDelete($updated_data->toArray(), $history_modal, 3);
                    $success_array["message"]                        = DataRemovalMessage();
                    $gov_text_before                                 = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                              = array();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                    CamisIboxDischargeAssigned::where('camis_patient_id', '=', $camis_patient_id)->delete();
                }
            }
            $success_array["status"]                                    = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }









    public function GetMedfitTimeline(Request $request)
    {
        $patient = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $request->camis_patient_id)->first();
        $success_array['medfit_dates'] = $patient->MedFitHistoryData();
        $success_array['medfit_history'] = $patient->MedFitDates();
        $success_array['dtoc_current_status_drop'] = DtocCurrentStatus::pluck('dtoc_current_status_text', 'id')->toArray();
        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.MedfitTimelineContent', compact('success_array'));
        $sections = $view->render();
        return $sections;
    }


    public function PerformanceTab(Request $request)
    {

        return view('Dashboards.Camis.DischargeTracker.Performance');
    }

    public function IndexRefreshDataLoad(Request $request)
    {


        // 🔥 DEMO SWITCH: set true to always use dummy data, even if DB has some
        $forceDummy = true;

        $rrand = function (int $min, int $max) {
            return mt_rand($min, $max);
        };

        $process_array = [];
        $success_array = [];

        $ward_id        = WardToIDArray($request->ward_id);
        $medfit         = $request->medfit_status;
        $reason_code_id = $request->reason_code_id;
        $status         = $request->status;

        // real wards list (keep)
        $all_wards = Wards::where('status', 1)
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->pluck('ward_name', 'id')
            ->toArray();

        // current week (Sun–Sat)
        $start_of_week = Carbon::now()->startOfWeek(Carbon::SUNDAY)->startOfDay();
        $end_of_week   = Carbon::now()->endOfWeek(Carbon::SATURDAY)->endOfDay();

        $week_discharges = [];
        $current_date    = $start_of_week->copy();

        while ($current_date <= $end_of_week) {
            $day_name = strtolower($current_date->format('l'));
            $week_discharges[$day_name] = 0;
            $current_date->addDay();
        }

        // master lists (keep from DB)
        $reason_list = DtocAuthority::where('status', '=', 1)
            ->orderBy('dtoc_authority_text', 'ASC')
            ->pluck('dtoc_authority_text', 'id')
            ->toArray();

        $authority_list = DtocCurrentService::where('status', 1)
            ->orderBy('service_text_value', 'asc')
            ->pluck('service_text_value', 'id')
            ->toArray();

        $pathway_list = DtocPathway::where('status', '=', 1)
            ->orderBy('dtoc_pathway_text', 'asc')
            ->pluck('dtoc_pathway_text', 'id')
            ->toArray();

        $patient_by_authority = [];
        $patient_by_reason    = [];
        $patient_by_pathway   = [];

        foreach ($reason_list as $reason_id => $reason_name) {
            $patient_by_reason[$reason_id] = 0;
        }

        foreach ($pathway_list as $pathway_id => $pathway_name) {
            $patient_by_pathway[$pathway_name] = 0;
            foreach ($authority_list as $authority_id => $auth_name) {
                if (in_array($auth_name, ['Warwickshire', 'Leicestershire', 'OOA', 'CRS', 'CRT', 'ICB'])) {
                    $patient_by_authority[$pathway_name][$auth_name] = 0;
                }
            }
        }

        $cdt_approved = 0;
        $cdt_awaiting = 0;
        $patient_list = [];

        // =============== REAL DATA QUERIES (may be empty) ===============

        $out_patients_records = CamisIboxWardWeeklyDischarge::with([
            'BoardRoundCdt',
            'BoardRoundMedicallyFitData',
            'BoardRoundPathwayRequirement'
        ])
            ->whereBetween('camis_patient_discharge_date_time', [$start_of_week, $end_of_week])
            ->when($request->filled('ward_id'), function ($q) use ($request) {
                $q->whereIn('camis_patient_ward_id', $request->ward_id);
            })
            ->unless($request->filled('ward_id'), function ($q) {
                $q->whereIn('camis_patient_ward_id', AllWardToIDArray());
            })
            ->orderBy('camis_patient_discharge_date_time', 'desc')
            ->get()
            ->toArray();

        $in_patients_records = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')
            ->where('ibox_bed_type', 'Bed')
            ->when($request->filled('ward_id'), function ($q) use ($request) {
                $q->whereIn('camis_patient_ward_id', $request->ward_id);
            })
            ->unless($request->filled('ward_id'), function ($q) {
                $q->whereIn('camis_patient_ward_id', AllWardToIDArray());
            })
            ->whereNull('camis_patient_discharge_date_time')
            ->with([
                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                },
                'BoardRoundPathwayRequirement.DtocPathway',
                'BoardRoundPathwayRequirement.DtocAuthority',
                'BoardRoundPathwayRequirement.DtocStatus',
                'BoardRoundCdt'
            ])
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_number', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')
            ->get()
            ->toArray();

        // =============== PROCESS REAL DATA IF EXISTS ===============

        foreach ($out_patients_records as $out) {
            if ($request->filled('ward_id') && !in_array($out['camis_patient_ward_id'], $ward_id)) {
                continue;
            }
            if ($request->filled('medfit_status')) {
                $medfit_status = $out['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null;

                if ($request->medfit_status == 1 && $medfit_status != 1) {
                    continue;
                } elseif ($request->medfit_status == 2 && $medfit_status != 0) {
                    continue;
                }
            }

            if ($request->filled('reason_code_id')) {
                if (!isset($out['board_round_pathway_requirement']['dtoc_authority_id'])) {
                    continue;
                } else {
                    if ($out['board_round_pathway_requirement']['dtoc_authority_id'] != $request->reason_code_id) {
                        continue;
                    }
                }
            }
            if (isset($out['board_round_cdt']['cdt_status']) && $out['board_round_cdt']['cdt_status'] == 1) {
                if (isset($week_discharges[strtolower($out['dayname'])])) {
                    $week_discharges[strtolower($out['dayname'])]++;
                }
            }
        }

        foreach ($in_patients_records as $in_patient) {
            $medfit_status = $in_patient['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null;

            if ($request->filled('ward_id') && !in_array($in_patient['camis_patient_ward_id'], $ward_id)) {
                continue;
            }

            if ($request->filled('medfit_status')) {
                if ($request->medfit_status == 1 && $medfit_status != 1) {
                    continue;
                } elseif ($request->medfit_status == 2 && $medfit_status != 0) {
                    continue;
                }
            }

            if ($request->filled('reason_code_id')) {
                if (!isset($in_patient['board_round_pathway_requirement']['dtoc_authority_id'])) {
                    continue;
                } else {
                    if ($in_patient['board_round_pathway_requirement']['dtoc_authority_id'] != $request->reason_code_id) {
                        continue;
                    }
                }
            }

            $patient_reason_id    = $in_patient['board_round_pathway_requirement']['dtoc_authority_id'] ?? null;
            $patient_pathway_id   = $in_patient['board_round_pathway_requirement']['dtoc_pathway_id'] ?? null;
            $patient_authority_id = $in_patient['board_round_pathway_requirement']['service_id'] ?? null;
            $pathway_text_to_check = $pathway_list[$patient_pathway_id] ?? null;
            $pathway_auth_name     = $authority_list[$patient_authority_id] ?? null;

            $patient_cdt_status = $in_patient['board_round_cdt']['cdt_status'] ?? null;

            if (isset($patient_by_reason[$patient_reason_id])) {
                $patient_by_reason[$patient_reason_id]++;
            }
            if (isset($patient_by_authority[$pathway_text_to_check][$pathway_auth_name])) {
                $patient_by_authority[$pathway_text_to_check][$pathway_auth_name]++;
            }

            if (isset($patient_by_pathway[$pathway_text_to_check])) {
                $patient_by_pathway[$pathway_text_to_check]++;
            }

            if ($patient_cdt_status == 1) {
                $cdt_approved++;
            }
            if (isset($in_patient['board_round_cdt']['cdt_status'])) {
                if ($patient_cdt_status == 0 || $patient_cdt_status == 2) {
                    $cdt_awaiting++;
                }
            }

            if (isset($in_patient['board_round_cdt']['cdt_status']) && in_array($patient_cdt_status, [1])) {
                $patient_data                   = [];
                $patient_data['ward_name']      = $all_wards[$in_patient['camis_patient_ward_id']] ?? 'Unknown Ward';
                $patient_data['bed_name']       = $in_patient['ibox_actual_bed_full_name'];
                $patient_data['pas_id']         = $in_patient['camis_patient_pas_number'];
                $patient_data['patient_name']   = $in_patient['camis_patient_forename'] . ' ' . $in_patient['camis_patient_surname'];
                $patient_data['los']            = PatientLos($in_patient['camis_patient_admission_date_time']);
                $patient_data['los_since_medfit'] = ($medfit_status == 1)
                    ? PatientLos($in_patient['board_round_medically_fit_data']['updated_at'])
                    : '--';
                $patient_data['pathway']        = $pathway_text_to_check ?? '--';
                $patient_data['reason']         = $reason_list[$patient_reason_id] ?? '--';

                $patient_list[] = $patient_data;
            }
        }

        // group by ward
        $ward_wise_patients = array_reduce($patient_list, function ($carry, $item) {
            $ward_name = $item['ward_name'];
            $carry[$ward_name][] = $item;
            return $carry;
        }, []);

        ksort($ward_wise_patients);
        arsort($patient_by_reason);

        $success_array['patient_list']        = $ward_wise_patients;
        $success_array['patient_by_reason']   = ArrayFilter($patient_by_reason, fn($v) => $v !== 0);
        $success_array['patient_by_authority'] = $patient_by_authority;
        $success_array['patient_by_pathway']  = $patient_by_pathway;
        $success_array['cdt_approved']        = $cdt_approved;
        $success_array['cdt_awaiting']        = $cdt_awaiting;

        $success_array['today_discharge'] = $week_discharges[strtolower(date('l'))] ?? 0;
        $success_array['discharges_this_week'] = array_combine(
            array_map(function ($day) {
                return strtoupper(substr($day, 0, 3));
            }, array_keys($week_discharges)),
            array_values($week_discharges)
        );
        $success_array['all_wards']   = $all_wards;
        $success_array['reason_list'] = $reason_list;

        // ==========================
        // 🔥 DUMMY LAYER FOR DEMO
        // ==========================

        $noRealPatients   = empty($success_array['patient_list']);
        $noRealDischarge  = empty(array_filter($success_array['discharges_this_week']));

        $useDummy = $forceDummy || ($noRealPatients && $noRealDischarge);

        if ($useDummy) {
            // stable seed so the same week looks the same each refresh
            mt_srand(crc32('DTOC_PERF|' . $start_of_week->format('Y-m-d') . '|' . $end_of_week->format('Y-m-d')));

            // fallback reason list if DB is empty
            if (empty($reason_list)) {
                $reason_list = [
                    1 => 'Awaiting Social Care',
                    2 => 'Awaiting Community Services',
                    3 => 'Awaiting Medical Decision',
                    4 => 'Awaiting Diagnostics',
                    5 => 'Reason to be Confirmed',
                ];
            }

            // fallback pathways & authorities if DB is empty
            if (empty($pathway_list)) {
                $pathway_list = [
                    1 => 'Pathway 0',
                    2 => 'Pathway 1',
                    3 => 'Pathway 2',
                ];
            }
            if (empty($authority_list)) {
                $authority_list = [
                    1 => 'Warwickshire',
                    2 => 'Leicestershire',
                    3 => 'OOA',
                    4 => 'CRS',
                    5 => 'CRT',
                    6 => 'ICB',
                ];
            }

            // rebuild containers
            $patient_by_reason   = [];
            $patient_by_authority = [];
            $patient_by_pathway  = [];

            foreach ($reason_list as $reason_id => $reason_name) {
                $patient_by_reason[$reason_id] = 0;
            }

            foreach ($pathway_list as $pathway_id => $pathway_name) {
                $patient_by_pathway[$pathway_name] = 0;
                foreach ($authority_list as $authority_id => $auth_name) {
                    if (in_array($auth_name, ['Warwickshire', 'Leicestershire', 'OOA', 'CRS', 'CRT', 'ICB'])) {
                        $patient_by_authority[$pathway_name][$auth_name] = 0;
                    }
                }
            }

            // randomise weekly discharges (per day)
            $week_discharges = [];
            $current_date    = $start_of_week->copy();
            while ($current_date <= $end_of_week) {
                $dayKey = strtolower($current_date->format('l'));
                $week_discharges[$dayKey] = $rrand(0, 8); // 0–8 discharges per day
                $current_date->addDay();
            }

            $success_array['today_discharge'] = $week_discharges[strtolower(date('l'))] ?? 0;
            $success_array['discharges_this_week'] = array_combine(
                array_map(fn($d) => strtoupper(substr($d, 0, 3)), array_keys($week_discharges)),
                array_values($week_discharges)
            );

            // generate dummy patients
            $wards = array_values($all_wards);
            if (empty($wards)) {
                $wards = ['Ward A', 'Ward B', 'Ward C'];
            }

            $totalPatients   = $rrand(15, 40);
            $cdt_approved    = 0;
            $cdt_awaiting    = 0;
            $patient_list_flat = [];

            // valid authority names to match your original filter
            $validAuthNames = array_values(
                array_intersect($authority_list, ['Warwickshire', 'Leicestershire', 'OOA', 'CRS', 'CRT', 'ICB'])
            );
            if (empty($validAuthNames)) {
                $validAuthNames = array_values($authority_list);
            }

            for ($i = 0; $i < $totalPatients; $i++) {
                $reasonId    = array_rand($reason_list);
                $pathwayId   = array_rand($pathway_list);
                $pathwayName = $pathway_list[$pathwayId];

                $authName = $validAuthNames[array_rand($validAuthNames)];
                $wardName = $wards[array_rand($wards)];

                $isApproved = (mt_rand(0, 100) < 60); // ~60% approved
                if ($isApproved) {
                    $cdt_approved++;
                } else {
                    $cdt_awaiting++;
                }

                $los        = $rrand(1, 14);
                $losMedfit  = $rrand(0, $los);
                $patient    = [
                    'ward_name'        => $wardName,
                    'bed_name'         => 'B' . $rrand(1, 28),
                    'pas_id'           => 'PAS' . $rrand(100000, 999999),
                    'patient_name'     => 'Patient ' . $rrand(1000, 9999),
                    'los'              => $los,
                    'los_since_medfit' => $losMedfit > 0 ? $losMedfit : '--',
                    'pathway'          => $pathwayName,
                    'reason'           => $reason_list[$reasonId],
                ];

                $patient_list_flat[] = $patient;

                $patient_by_reason[$reasonId]++;
                if (isset($patient_by_pathway[$pathwayName])) {
                    $patient_by_pathway[$pathwayName]++;
                }
                if (isset($patient_by_authority[$pathwayName][$authName])) {
                    $patient_by_authority[$pathwayName][$authName]++;
                }
            }

            // regroup by ward for the view
            $ward_wise_patients = [];
            foreach ($patient_list_flat as $p) {
                $ward_wise_patients[$p['ward_name']][] = $p;
            }
            ksort($ward_wise_patients);
            arsort($patient_by_reason);

            $success_array['patient_list']        = $ward_wise_patients;
            $success_array['patient_by_reason']   = ArrayFilter($patient_by_reason, fn($v) => $v !== 0);
            $success_array['patient_by_authority'] = $patient_by_authority;
            $success_array['patient_by_pathway']  = $patient_by_pathway;
            $success_array['cdt_approved']        = $cdt_approved;
            $success_array['cdt_awaiting']        = $cdt_awaiting;

            // keep real ward & reason master lists
            $success_array['all_wards']   = $all_wards;
            $success_array['reason_list'] = $reason_list;
        }

        // =================== RENDER VIEW ===================

        $view     = View::make('Dashboards.Camis.DischargeTracker.Partials.PerformanceTabLoad', compact('success_array'));
        $sections = $view->render();
        return $sections;
    }


    public function CDTPerformancePatientExport(Request $request)
    {

        if ($request->filled('ward_id')) {
            $ward_id = explode(',', $request->input('ward_id'));
        } else {
            $ward_id = AllWardToIDArray();
        }

        $medfit                                     = $request->medfit_status;
        $reason_code_id                             = $request->reason_code_id;
        $status                                     = $request->status;
        $all_wards = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_name', 'id')->toArray();
        $reason_list = DtocAuthority::where('status', '=', 1)->orderBy('dtoc_authority_text', 'ASC')->pluck('dtoc_authority_text', 'id')->toArray();
        $authority_list = DtocCurrentService::where('status', 1)->orderBy('service_text_value', 'asc')->pluck('service_text_value', 'id')->toArray();
        $pathway_list = DtocPathway::where('status', '=', 1)->orderBy('dtoc_pathway_text', 'asc')->pluck('dtoc_pathway_text', 'id')->toArray();
        $in_patients_records = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')
            ->where('ibox_bed_type', 'Bed')
            ->when($request->filled('ward_id'), function ($q) use ($request) {
                $q->whereIn('camis_patient_ward_id', explode(',', $request->input('ward_id')));
            })
            ->unless($request->filled('ward_id'), function ($q) {

                $q->whereIn('camis_patient_ward_id', AllWardToIDArray());
            })
            ->whereNull('camis_patient_discharge_date_time')
            ->with([
                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                },
                'BoardRoundPathwayRequirement.DtocPathway',
                'BoardRoundPathwayRequirement.DtocAuthority',
                'BoardRoundPathwayRequirement.DtocStatus',
                'BoardRoundCdt'
            ])
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_number', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')
            ->get()->toArray();


        foreach ($in_patients_records as $in_patient) {
            $medfit_status = $in_patient['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null;

            if ($request->filled('ward_id') && !in_array($in_patient['camis_patient_ward_id'], $ward_id)) {
                continue;
            }

            if ($request->filled('medfit_status')) {
                if ($request->medfit_status == 1 && $medfit_status != 1) {
                    continue;
                } elseif ($request->medfit_status == 2 && $medfit_status != 0) {
                    continue;
                }
            }

            if ($request->filled('reason_code_id')) {
                if (!isset($in_patient['board_round_pathway_requirement']['dtoc_authority_id'])) {
                    continue;
                } else {
                    if ($in_patient['board_round_pathway_requirement']['dtoc_authority_id'] != $request->reason_code_id) {
                        continue;
                    }
                }
            }
            $patient_reason_id = $in_patient['board_round_pathway_requirement']['dtoc_authority_id'] ?? null;
            $patient_pathway_id = $in_patient['board_round_pathway_requirement']['dtoc_pathway_id'] ?? null;
            $patient_authority_id = $in_patient['board_round_pathway_requirement']['service_id'] ?? null;
            $pathway_auth_name = $authority_list[$patient_authority_id] ?? null;
            $pathway_text_to_check = $pathway_list[$patient_pathway_id] ?? null;



            if (isset($in_patient['board_round_cdt']['cdt_status']) && in_array($in_patient['board_round_cdt']['cdt_status'], [0, 1, 2])) {
                $patient_data = array();
                $patient_data['ward_name'] = $all_wards[$in_patient['camis_patient_ward_id']];
                $patient_data['bed_name'] = $in_patient['ibox_actual_bed_full_name'];
                $patient_data['pas_id'] = $in_patient['camis_patient_pas_number'];
                $patient_data['patient_name'] = $in_patient['camis_patient_forename'] . ' ' . $in_patient['camis_patient_surname'];
                $patient_data['los'] = PatientLos($in_patient['camis_patient_admission_date_time']);
                $patient_data['los_since_medfit'] = ($medfit_status == 1) ? PatientLos($in_patient['board_round_medically_fit_data']['updated_at']) : '--';
                $patient_data['pathway'] = $pathway_text_to_check ?? '--';
                $patient_data['reason'] = $reason_list[$patient_reason_id] ?? '--';



                $patient_list[] = $patient_data;
            }
        }
        ksort($patient_data);
        $name = 'CDT Performance';
        $heading = ["Ward", "Bed Name", "Hospital Number", "Patient Name", "LOS",   "LOS Since Medfit", "Pathway", "Reason Code"];
        return ExportFunction(collect($patient_list), $heading, $name);
    }
    public function CDTPerformanceOffcanvasInPatientList(Request $request)
    {
        $ward_id                                    = WardToIDArray($request->ward_id);
        $medfit                                     = $request->medfit_status;
        $reason_code_id                             = $request->reason_code_id;
        $status                                     = $request->status;
        $all_wards = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_name', 'id')->toArray();
        $reason_list = DtocAuthority::where('status', '=', 1)->orderBy('dtoc_authority_text', 'ASC')->pluck('dtoc_authority_text', 'id')->toArray();
        $authority_list = DtocCurrentService::where('status', 1)->orderBy('service_text_value', 'asc')->pluck('service_text_value', 'id')->toArray();
        $pathway_list = DtocPathway::where('status', '=', 1)->orderBy('dtoc_pathway_text', 'asc')->pluck('dtoc_pathway_text', 'id')->toArray();

        $in_patients_records = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')
            ->where('ibox_bed_type', 'Bed')
            ->whereIn('camis_patient_ward_id', array_keys($all_wards))
            ->whereNull('camis_patient_discharge_date_time')
            ->with([
                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                },
                'BoardRoundPathwayRequirement.DtocPathway',
                'BoardRoundPathwayRequirement.DtocAuthority',
                'BoardRoundPathwayRequirement.DtocStatus',
                'BoardRoundCdt'
            ])
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_number', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')
            ->get()->toArray();
        $patient_list = [];
        foreach ($in_patients_records as $in_patient) {
            $medfit_status = $in_patient['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null;
            $patient_reason_id = $in_patient['board_round_pathway_requirement']['dtoc_authority_id'] ?? null;
            $patient_pathway_id = $in_patient['board_round_pathway_requirement']['dtoc_pathway_id'] ?? null;
            $patient_authority_id = $in_patient['board_round_pathway_requirement']['service_id'] ?? null;
            $pathway_service_text = $in_patient['board_round_pathway_requirement']['dtoc_service_text'] ?? null;
            $patient_cdt_status = $in_patient['board_round_cdt']['cdt_status'] ?? null;
            $pathway_auth_name = $authority_list[$patient_authority_id] ?? null;
            $pathway_text_to_check = $pathway_list[$patient_pathway_id] ?? null;
            $dtoc_authority_code_to_check = $in_patient['board_round_pathway_requirement']['dtoc_authority_code'] ?? null;



            if ($request->filled('ward_id') && !in_array($in_patient['camis_patient_ward_id'], $ward_id)) {
                continue;
            }

            if ($request->filled('medfit_status')) {
                if ($request->medfit_status == 1 && $medfit_status != 1) {
                    continue;
                } elseif ($request->medfit_status == 2 && $medfit_status != 0) {
                    continue;
                }
            }

            if ($request->filled('reason_code_id')) {
                if(empty($in_patient['board_round_pathway_requirement']['dtoc_authority_id'])){
                    continue;
                }
            }


            if ($request->filled('reason')) {
                if(empty($in_patient['board_round_pathway_requirement']['dtoc_authority_id'])){
                    continue;
                }
            }



            if ($request->filled('pathway') && $request->pathway != null) {
                if (empty($pathway_text_to_check)) {
                    continue;
                }
            }

            if ($request->filled('authority') && $request->authority != null) {
                if (empty($pathway_service_text)) {
                    continue;
                }
            }

            if ($request->filled('cdt_status') && $request->cdt_status == 1) {
                if ($patient_cdt_status != 1) {
                    continue;
                }
            }

            $patient_data = array();
            $patient_data['ward_name'] = $all_wards[$in_patient['camis_patient_ward_id']] ?? '';
            $patient_data['bed_name'] = $in_patient['ibox_actual_bed_full_name'];
            $patient_data['pas_id'] = $in_patient['camis_patient_pas_number'];
            $patient_data['patient_name'] = $in_patient['camis_patient_forename'] . ' ' . $in_patient['camis_patient_surname'];
            $patient_data['medfit'] = ($medfit_status == 1) ? 'Yes - ' . PredefinedYearFormat($in_patient['board_round_medically_fit_data']['updated_at']) : 'No';
            $patient_data['los'] = PatientLos($in_patient['camis_patient_admission_date_time']);
            $patient_data['los_since_medfit'] = ($medfit_status == 1) ? PatientLos($in_patient['board_round_medically_fit_data']['updated_at']) : '--';
            $patient_data['pathway'] = $pathway_text_to_check ?? '--';
            $patient_data['reason'] = $reason_list[$patient_reason_id] ?? '--';

            $patient_list[] = $patient_data;
        }
        $view = View::make('Dashboards.Camis.DischargeTracker.Partials.CDTPerformancePatientOffcanvas', compact('patient_list'));
        return $view->render();
    }


    public function DischargeTodayOffcanvas(Request $request)
    {
        $ward_id                                    = WardToIDArray($request->ward_id);
        $medfit                                     = $request->medfit_status;
        $reason_code_id                             = $request->reason_code_id;
        $status                                     = $request->status;
        $all_wards = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_name', 'id')->toArray();
        $out_patients_records = CamisIboxPatientInformationDetails::with(['BoardRoundCdt', 'BoardRoundMedicallyFitData', 'BoardRoundPathwayRequirement'])

            ->whereDate('camis_patient_discharge_date_time', Carbon::today())
            ->whereIn('camis_patient_ward_id', array_keys($all_wards))
            ->orderBy('camis_patient_discharge_date_time', 'desc')
            ->get()->toArray();
        $patient_list = [];
        foreach ($out_patients_records as $out) {
            if ($request->filled('ward_id') && !in_array($out['camis_patient_ward_id'], $ward_id)) {
                continue;
            }
            if ($request->filled('medfit_status')) {
                $medfit_status = $out['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null;

                if ($request->medfit_status == 1 && $medfit_status != 1) {
                    continue;
                } elseif ($request->medfit_status == 2 && $medfit_status != 0) {
                    continue;
                }
            }

            if ($request->filled('reason_code_id')) {
                if (!isset($out['board_round_pathway_requirement']['dtoc_authority_id'])) {
                    continue;
                } else {
                    if ($out['board_round_pathway_requirement']['dtoc_authority_id'] != $request->reason_code_id) {
                        continue;
                    }
                }
            }

            $out['ward_name'] = $all_wards[$out['camis_patient_ward_id']] ?? '';
            if (isset($out['board_round_cdt']['cdt_status']) && $out['board_round_cdt']['cdt_status'] == 1) {
                $patient_list[] = $out;
            }
        }
        $view                                       = View::make('Dashboards.Camis.DischargeTracker.Partials.CDTPerformanceDischargeToday', compact('patient_list', 'all_wards'));
        $sections                                   = $view->render();
        return $sections;
    }


    public function CDTPendingOffcanvas(Request $request)
    {
        $ward_id                                    = WardToIDArray($request->ward_id);
        $medfit                                     = $request->medfit_status;
        $reason_code_id                             = $request->reason_code_id;
        $status                                     = $request->status;
        $all_wards = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_name', 'id')->toArray();
        $cdt_patients = CamisIboxBoardRoundCDT::whereIn('cdt_status', [0, 2])->pluck('patient_id')->toArray();
        $wards = Wards::where('status', 1)->orderBy('ward_name', 'asc')->pluck('ward_name', 'id')->toArray();
        $in_patients_records = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $cdt_patients)->with(['BoardRoundCdt', 'BoardRoundCDTComment'])->when($request->filled('ward_id'), function ($q) use ($request) {
            return $q->whereIn('camis_patient_ward_id', WardToIDArray($request->ward_id));
        })
            ->select('ibox_actual_bed_full_name', 'camis_patient_ward_id', 'camis_patient_sex', 'camis_patient_name', 'camis_patient_pas_number', 'camis_consultant_name', 'camis_patient_admission_date_time', 'ibox_ward_name', 'camis_patient_id')
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ibox_bed_group_name', 'ASC')
            ->orderBy('ibox_bed_group_number', 'ASC')
            ->orderBy('ibox_bed_priority', 'ASC')
            ->orderBy('ibox_bed_no', 'ASC')->get()->toArray();

        $patient_list = [];
        foreach ($in_patients_records as $in_patient) {
            $medfit_status = $in_patient['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null;

            if ($request->filled('ward_id') && !in_array($in_patient['camis_patient_ward_id'], $ward_id)) {
                continue;
            }

            if ($request->filled('medfit_status')) {
                if ($request->medfit_status == 1 && $medfit_status != 1) {
                    continue;
                } elseif ($request->medfit_status == 2 && $medfit_status != 0) {
                    continue;
                }
            }
            $in_patient['ward_name'] = $all_wards[$in_patient['camis_patient_ward_id']] ?? '';
            $patient_list[] = $in_patient;
        }
        $view                                       = View::make('Dashboards.Camis.DischargeTracker.Partials.CDTPerformancePendingCDT', compact('patient_list', 'all_wards'));
        $sections                                   = $view->render();
        return $sections;
    }

    public function GetCDTCommentHistory(Request $request)
    {
        $camis_patient_id = $request->camis_patient_id;
        $comment_id = $request->comment_id;
        $users = User::pluck('username', 'id')->toArray();
        $cdt_details      = CamisIboxBoardRoundCDT::where('patient_id', '=', $camis_patient_id)->first();
        $comments_list = HistoryCamisIboxBoardRoundCDTComment::where('id', $comment_id)->where('patient_id', $camis_patient_id)->orderBy('history_id', 'desc')->take(500)->get()->toArray();
        $current_cdt_comment = CamisIboxBoardRoundCDTComment::where('patient_id', '=', $camis_patient_id)->first()->cdt_comment ?? '';
        $view                                                           = View::make('Dashboards.Camis.DischargeTracker.Partials.CdtCommentModalData', compact('camis_patient_id', 'comments_list', 'users', 'cdt_details', 'current_cdt_comment'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function RemoveCDTCommentHistory(Request $request)
    {
        $ward_controller                                            = new WardSummaryController;
        $date_time_now                                              = CurrentDateOnFormat();
        $comment_id                                                 = $request->comment_id;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));


        if ($user_id != "") {
            $gov_text_before_arr                                    = HistoryCamisIboxBoardRoundCDTComment::where('history_id', '=', $comment_id)->first();
            $ward_controller->GovernanceBoardRoundUpdatePreCall($gov_text_before_arr->patient_id, $gov_text_before_arr->toArray(), '', array(), 'Patient CDT Comments', 3);

            $gov_text_before_arr->history_status = 3;
            $gov_text_before_arr->updated_by = $user_id;
            $gov_text_before_arr->save();

            $success_array["status"]                                    = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function ReviewTabSaveCDTComment(Request $request)
    {

        $history_controller                                         = new HistoryController;
        $ward_controller                                            = new WardSummaryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundCDTComment";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $cdt_comment                                                = $request->comment;
        $comment_id                                                 = $request->comment_id;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $success_array["cdt_comment"]                               = $cdt_comment;

        if ($camis_patient_id != "" && $user_id != "") {
            if (!empty($cdt_comment)) {
                $gov_text_before_arr                                    = CamisIboxBoardRoundCDTComment::where('patient_id', '=', $camis_patient_id)->first();
                $updated_data                                           = CamisIboxBoardRoundCDTComment::updateOrCreate(['patient_id' => $camis_patient_id, 'id' => $comment_id], ['cdt_comment' => $cdt_comment, 'updated_by' => $user_id]);
                $functional_identity                                    = 'Patient CDT Comments';

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundCDTComment::where('id', '=', $updated_array["id"])->first();
                        $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $cdt_comment, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {

                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundCDTComment::where('id', '=', $updated_array["id"])->first();
                                $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $cdt_comment, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            } else {
                $gov_text_before_arr                                    = CamisIboxBoardRoundCDTComment::where('patient_id', '=', $camis_patient_id)->first();
                if ($gov_text_before_arr) {
                    $functional_identity                                    = 'Patient CDT Comments';
                    $updated_data                                    = $gov_text_before_arr;
                    $history_controller->HistoryTableDataInsertFromDelete($updated_data->toArray(), $history_modal, 3);
                    $success_array["message"]                        = DataRemovalMessage();
                    $gov_text_before                                 = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                              = array();
                    $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                    CamisIboxBoardRoundCDTComment::where('patient_id', '=', $camis_patient_id)->delete();
                }
            }
            $success_array["status"]                                    = 1;
        }
        $camis_patient_id = $request->camis_patient_id;
        $comment_id = $request->comment_id;
        $users = User::pluck('username', 'id')->toArray();
        $cdt_details      = CamisIboxBoardRoundCDT::where('patient_id', '=', $camis_patient_id)->first();
        $comments_list = HistoryCamisIboxBoardRoundCDTComment::where('id', $comment_id)->where('patient_id', $camis_patient_id)->orderBy('history_id', 'desc')->take(500)->get()->toArray();

        $view                                                           = View::make('Dashboards.Camis.DischargeTracker.Partials.CdtCommentModalData', compact('camis_patient_id', 'comments_list', 'users', 'cdt_details'));
        $success_array['html']                                                       = $view->render();

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function OtherNotes(Request $request)
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
        $view                                                           = View::make('Dashboards.Camis.DischargeTracker.Partials.OtherNotesData', compact('camis_patient_id', 'comments_list', 'users', 'history_status'));
        $sections                                                       = $view->render();
        $success_array["sections"]                                      = $sections;
        $success_array["current_comment"]                             = $current_comment;
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function SaveOtherNotes(Request $request)
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

        return ReturnArrayAsJsonToScript($success_array);
    }


    public function GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_desc, $gov_text_after_arr, $functional_identity, $operation)
    {
        $gov_data                                   = array();
        if ($operation == 1) {
            if ($gov_text_after_arr) {
                $gov_text_after                     = $gov_text_after_arr->toArray();
            }

            if (isset($gov_text_after["id"])) {
                $gov_data["gov_text_before"]        = "";
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 2) {
            if ($gov_text_after_arr) {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }

        if ($operation == 4) {
            if ($gov_text_after_arr) {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 5) {
            if ($gov_text_after_arr) {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 3) {
            if (isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = "";
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if (!empty($gov_data)) {
            if (count($gov_data) > 0) {

                $governance = new GovernanceController;
                $governance->GovernanceStoreCamisData($gov_data);
            }
        }
    }
}
