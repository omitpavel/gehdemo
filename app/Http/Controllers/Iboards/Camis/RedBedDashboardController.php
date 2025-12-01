<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Common\CommonReportController;
use App\Http\Controllers\Controller;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundRedGreenBed;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\View;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\Master\BedRedReason;
use App\Http\Controllers\Common\HistoryController;
use App\Http\Controllers\Governance\GovernanceController;

class RedBedDashboardController extends Controller
{

    public function Index()
    {
        if(CheckDashboardPermission('flow_dashboard_red_bed_view') || CheckDashboardPermission('flow_dashboard_redbed_performance_view')){
            return view('Dashboards.Camis.RedBed.Index');
        } elseif(CheckDashboardPermission('doctor_at_night_dashboard_view')){
            return redirect()->route('doctor.at.night');
        } elseif(CheckDashboardPermission('leaflet_dashboard_view')){
            return redirect()->route('virtual.ward.leaflet');
        } elseif(CheckDashboardPermission('stranded_dashboard')){
            return redirect()->route('site.stranded_patients');
        } elseif(CheckDashboardPermission('r_to_r_view_')){
            return redirect()->route('reason_reside.dashboard');
        } elseif(CheckDashboardPermission('surgical_wards_dashboard_view')){
            return redirect()->route('surgical.ward');
        }
        elseif (CheckDashboardPermission('allowed_to_move_dashboard_view'))
        {
            return redirect()->route('allowed_to_move.dashboard');
        }
        elseif(CheckDashboardPermission('discharged_patient_is_view_dashbaord_view')){
            return redirect()->route('discharges_patient.dashboard');
        } elseif(CheckDashboardPermission('site_office_report_view')){
            return redirect()->route('site.office');
        } elseif(CheckDashboardPermission('flow_dashboard_patient_search_view')){
            return redirect()->route('global.patient.search');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }

    }

    public function RedBedReasonList(Request $request){


        $success_array                                                  = array();
        $wards                                                          = Wards::orderBy('ward_name', 'ASC')->where('status', 1)->pluck('ward_name','id')->toArray();
        $success_array['selected_ward_id']                              =  ($request->filled('ward_id')) ? $request->ward_id : array();
        $success_array['selected_reason_id']                            = $request->reason_id ?? '';

        if(is_numeric($request->reason_id)){
           $filter_reason = BedRedReason::where('id', $request->reason_id)->pluck('id')->unique()->toArray();
        } else {
            $filter_reason = BedRedReason::where('red_text_value', 'like', '%'.$request->reason_id.'%')->pluck('id')->unique()->toArray();
        }

        $patient_ids        = CamisIboxBoardRoundRedGreenBed::where('patient_red_green_status', 1);

        $categroy_lists      = clone $patient_ids;
        $categroy_lists      = $categroy_lists->pluck('patient_red_green_status_reason_code')->toArray();
        $categroy_list = array();
        foreach($categroy_lists as $list){

            $cat_list = json_decode($list, true);

            $categroy_list = array_merge($categroy_list, array_keys($cat_list));
        }
        $patient_ids = $patient_ids->when($request->filled('reason_id'), function ($q) use ($filter_reason) {

            $q->where(function ($query) use ($filter_reason) {
                foreach ($filter_reason as $reason_id) {
                    $query->orWhere(function ($subQuery) use ($reason_id) {
                        $subQuery->orWhereRaw("JSON_EXTRACT(patient_red_green_status_reason_code, '$.\"$reason_id\"') IS NOT NULL");
                    });
                }
            });

            return $q;
        })->pluck('patient_id')->unique()->toArray();




        $patient_info       = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('disabled_on_all_dashboard_except_ward_summary', 0)->with([
            'BoardRoundMedicallyFitData'=>function($q){
                $q->select('id','patient_id','patient_medically_fit_status','patient_medically_fit_status_comment', 'updated_at');
            },
            'BoardRoundEstimatedDischargeDate'=>function($q){
                $q->select('id','patient_id','patient_estimated_discharge_date','patient_estimated_discharge_date_comment');
            },
            'PatientWiseFlags'=>function($q){
                $q->where('patient_flag_status_value',1);
            },

            'BoardRoundPatientTasks' =>function($q){
                $q->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->with('PatientTaskCategory')->orderBy('id', 'asc');
            },

            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory',
            'PatientVitalPacInfo',
            'RedGreenBed'
        ])->when($request->filled('ward_id'), function ($q) use($request){
            return $q->whereIn('ibox_ward_id', $request->ward_id);
        })->whereIn('camis_patient_id', $patient_ids)->withCount(['BoardRoundPatientTasks' => function ($q)
        {
            $q->where('task_completed_status', 0)
                ->where('task_not_applicable_status', 0);
        }])->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();

        $success_array['total_patient']                                  = count($patient_info);
        $success_array['red_bed_reason_list']                                 = BedRedReason::where('status', 1)->pluck('red_text_value', 'id')->toArray();

        $red_bed_reason_data_process = array();
        foreach ($patient_info as $patient) {
            $red_bed_reason_data_process[$patient['ibox_ward_name']][] = $patient;
        }
        $success_array['red_bed_reason']                                 = BedRedReason::whereIn('id', array_unique($categroy_list))->pluck('red_text_value', 'id')->unique()->toArray();

        $success_array['patients_list']                                 = $red_bed_reason_data_process;
        $success_array['ward_list']                                     = $wards;

        $view                                                           = View::make('Dashboards.Camis.RedBed.ReasonListTab', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;


    }

    public function RedBedExport (Request $request){


        $success_array                                                  = array();
        $wards                                                          = Wards::orderBy('ward_name', 'ASC')->where('status', 1)->pluck('ward_name','id')->toArray();
        $success_array['selected_ward_id']                              = $request->ward_id;
        $success_array['selected_reason_id']                            = $request->reason_id ?? '';

        if(is_numeric($request->reason_id)){
           $filter_reason = BedRedReason::where('id', $request->reason_id)->pluck('id')->unique()->toArray();
        } else {
            $filter_reason = BedRedReason::where('red_text_value', 'like', '%'.$request->reason_id.'%')->pluck('id')->unique()->toArray();
        }

        $patient_ids        = CamisIboxBoardRoundRedGreenBed::where('patient_red_green_status', 1)->when($request->filled('reason_id'), function ($q) use ($filter_reason) {

            $q->where(function ($query) use ($filter_reason) {
                foreach ($filter_reason as $reason_id) {
                    $query->orWhere(function ($subQuery) use ($reason_id) {
                        $subQuery->orWhereRaw("JSON_EXTRACT(patient_red_green_status_reason_code, '$.\"$reason_id\"') IS NOT NULL");
                    });
                }
            });

            return $q;
        })->pluck('patient_id')->unique()->toArray();




        $patient_info       = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->with([
            'BoardRoundMedicallyFitData'=>function($q){
                $q->select('id','patient_id','patient_medically_fit_status','patient_medically_fit_status_comment', 'updated_at');
            },
            'BoardRoundEstimatedDischargeDate'=>function($q){
                $q->select('id','patient_id','patient_estimated_discharge_date','patient_estimated_discharge_date_comment');
            },

            'RedGreenBed'
        ])->when($request->filled('ward_id'), function ($q) use($request){
            return $q->whereIn('ibox_ward_id', explode(',', $request->input('ward_id')));
        })->whereIn('camis_patient_id', $patient_ids)->withCount(['BoardRoundPatientTasks' => function ($q)
        {
            $q->where('task_completed_status', 0)
                ->where('task_not_applicable_status', 0);
        }])->where('disabled_on_all_dashboard_except_ward_summary', 0)->get();

        $name = 'Red Bed Patients';
        $heading = [
            "Sl No",
            "Camis Patient ID",
            "Ward",
            "Bay & Bed",
            "Name",
            "Pas Number",
            "Consultant",
            "Med Fit",
            "LOS",
            "EDD",
            "RedBed Pending"
        ];

        $dischargeList = CommonReportController::RedBedDashboardExport($patient_info);
        return ExportFunction($dischargeList, $heading, $name);

    }

    public function ApproveReason(Request $request){

        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundRedGreenBed";
        $date_time_now                                              = CurrentDateOnFormat();
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');


        $success_array['message']  = ErrorOccuredMessage();
        $gov_text_before_arr                                    = CamisIboxBoardRoundRedGreenBed::where('patient_id', '=', $request->patient_id)->first();

        $success_array['status'] = 0;
        if($request->filled('reason_id')){
            $reason_id = $request->reason_id;
            $reason = json_decode($gov_text_before_arr->patient_red_green_status_reason_code, true);
            $exist_row = $reason[$reason_id];
            $reason[$reason_id] = [
                'reason_id' => $reason_id,
                'created_time' => isset($exist_row['created_time']) ? $exist_row['created_time'] : $gov_text_before_arr->updated_at,
                'is_complete' => 1,
                'completed_time' => CurrentDateOnFormat(),
            ];
            $pending_task = count(array_filter($reason, function($value) {
                return ((!isset($value['is_complete']) && $value == 0) || (isset($value['is_complete']) && $value['is_complete'] == 0));
            }));
            if($pending_task < 1){
                $status = 2;
                $success_array['pending_task'] = 0;
            } else {
                $status = 1;
                $success_array['pending_task'] = 1;
            }


            $updated_data                                           = CamisIboxBoardRoundRedGreenBed::updateOrCreate(['patient_id' => $request->patient_id], ['patient_red_green_status' => $status, 'patient_red_green_status_reason_code' => json_encode($reason), 'updated_by' => $user_id]);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_red_green_bed", "ibox_governance_frontend_functional_names");



            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
            $success_array["message"]                           = DataUpdatedMessage();
            if (count($updated_data->getChanges()) > 0)
            {
                $updated_array                                  = $updated_data->getOriginal();
                if (count($updated_array) > 0 && isset($updated_array["id"]))
                {
                    if ($gov_text_before_arr)
                    {
                        $gov_text_before                        = $gov_text_before_arr->toArray();
                        $gov_text_after_arr                     = CamisIboxBoardRoundRedGreenBed::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($request->patient_id, $gov_text_before, $status, $gov_text_after_arr, $functional_identity, 2);
                    }
                }
            }


        }
        $ward                                                                = $request->ward_id;
        $patient['camis_patient_id']                                         = $request->patient_id;
        $patient['red_green_bed']['patient_red_green_status_reason_code']    = json_encode($reason);
        $success_array['message']                                             = DataUpdatedMessage();
        $success_array['status']                                              = 1;
        $success_array['red_bed_reason_list']                                 = BedRedReason::where('status', 1)->pluck('red_text_value', 'id')->toArray();
        $view                                                                 = View::make('Dashboards.Camis.RedBed.Partials.ReasonList', compact('success_array', 'patient', 'ward'));
        $success_array['html']                                                = $view->render();
        return $success_array;

    }


    public function RedBedPerformance(Request $request){
        $all_ward_name_by_shortname = Wards::where('status', 1)

        ->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_name','ward_short_name')->unique()->toArray();
        $ward_list = Wards::with('PrimaryWardType')->where('status', 1)

        ->where('disabled_on_all_dashboard_except_ward_summary', 0)
        ->orderBy('ward_name', 'asc')
        ->get()->toArray();

        $medical_wards = [];
        $surgical_wards = [];
        $other_wards = [];
        foreach($ward_list as $item){
            if(isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'medical'){
                $medical_wards[] = $item;
            } elseif(isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'surgical'){
                $surgical_wards[] = $item;
            } elseif(isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'others'){
                $other_wards[] = $item;
            }
        }
        if (!$request->filled('ward_id')){
            $ward_id = array_column($ward_list, 'id');
        }else{
            $ward_id = $request->ward_id;
        }
        $master_patient_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('ibox_ward_id', $ward_id);
        $all_reason_list = BedRedReason::pluck('red_text_value','id')->unique()->toArray();
        $patient_by_task = [];
        foreach($all_reason_list as $reasons => $task_name){
            $patient_by_task[$reasons] = 0;
        }


        $clinical_review_ids = [];
        $diagnostics_ids = [];
        $discharge_plan_ids = [];


        $clinical_patient_count = [];
        $diagnostics_patient_count = [];
        $discharge_plan_patient_count = [];
        foreach($all_reason_list as $reason_id => $reasons){
            if(stripos($reasons, 'clinical review - ') !== false){
                array_push($clinical_review_ids, $reason_id);
            } elseif(stripos($reasons, 'diagnostics -') !== false){
                array_push($diagnostics_ids, $reason_id);
            } elseif(stripos($reasons, 'discharge plan -') !== false){
                array_push($discharge_plan_ids, $reason_id);
            }
        }

        $patient_query = clone $master_patient_query;
        $red_bed_inpatients = $patient_query->pluck('camis_patient_id')->toArray();
        $red_bed_patients = CamisIboxBoardRoundRedGreenBed::whereIn('patient_id', $red_bed_inpatients)->when($request->filled('reason_id'), function ($q) use ($request) {

            $q->where(function ($query) use ($request) {
                foreach ($request->reason_id as $reason_id) {
                    $query->orWhere(function ($subQuery) use ($reason_id) {
                        $subQuery->orWhereRaw("JSON_EXTRACT(patient_red_green_status_reason_code, '$.\"$reason_id\"') IS NOT NULL");
                    });
                }
            });
            return $q;
        })->with('PatientInformationWithBedDetails')->get()->toArray();

        $patients_id = [];

        $completed_clinical_task_count = 0;
        $completed_clinical_task_days = 0;
        $completed_diagnostics_task_count = 0;
        $completed_diagnostics_task_days = 0;
        $completed_discharge_plan_task_count = 0;
        $completed_discharge_plan_task_days = 0;
        $patient_list_with_pending_task = [];
        foreach($red_bed_patients as $red_patient){
            $reason_list = json_decode($red_patient['patient_red_green_status_reason_code'], true);


            if($red_patient['patient_red_green_status'] == 1){
                array_push($patients_id, $red_patient['patient_id']);

                $pending_task = ArrayFilter($reason_list, function($value) use($request) {
                    if(!isset($value['reason_id'])){
                        return false;
                    }
                    if($request->filled('reason_id')){
                        return ((!isset($value['is_complete']) && $value == 0) || (isset($value['is_complete']) && $value['is_complete'] == 0) && (isset($value['reason_id']) && in_array($value['reason_id'],$request->reason_id)));
                    } else {
                        return ((!isset($value['is_complete']) && $value == 0) || (isset($value['is_complete']) && $value['is_complete'] == 0));
                    }
                });
                foreach($pending_task as $key => $type){

                    if(!is_numeric($key)){
                        $key = $type['reason_id'];
                    }
                    if(isset($type['created_time'])){
                        $pending_reason_name  = $all_reason_list[$key];
                        $created_time = PredefinedDateFormatFor24Hour($type['created_time']);
                        $pending_delay_time  = PatientLos($type['created_time'], CurrentDateOnFormat());
                    } else {
                        $pending_reason_name  = $all_reason_list[$key];
                        $created_time = PredefinedDateFormatFor24Hour($red_patient['updated_at']);
                        $pending_delay_time  = PatientLos($red_patient['updated_at'], CurrentDateOnFormat());
                    }

                    $patient_list_with_pending_task[] = ['patient_bed' => $red_patient['patient_information_with_bed_details']['ibox_actual_bed_full_name'], 'patient_name' => $red_patient['patient_information_with_bed_details']['camis_patient_name'], 'patient_pas_number' => $red_patient['patient_information_with_bed_details']['camis_patient_pas_number'], 'patient_ward' => $all_ward_name_by_shortname[$red_patient['patient_information_with_bed_details']['camis_patient_ward']], 'patient_reason' => $pending_reason_name, 'patient_delay_time' => $pending_delay_time, 'reason_created_time' => $created_time];
                    if(in_array($key, $clinical_review_ids)){
                        array_push($clinical_patient_count, $red_patient['patient_id']);
                    } elseif(in_array($key, $diagnostics_ids)){
                        array_push($diagnostics_patient_count, $red_patient['patient_id']);
                    } elseif(in_array($key, $discharge_plan_ids)){
                        array_push($discharge_plan_patient_count, $red_patient['patient_id']);
                    }

                    $patient_by_task[$key] += 1;
                }

            }
            $reason_list = json_decode($red_patient['patient_red_green_status_reason_code'], true);



            $complete_task = ArrayFilter($reason_list, function($value) use($request){
                if(!isset($value['reason_id'])){
                    return false;
                }
                if($request->filled('reason_id')){
                    return (isset($value['reason_id']) && in_array($value['reason_id'],$request->reason_id));
                } else {
                    return true;
                }
            });
            foreach($complete_task as $task_id => $task){
                if(!is_numeric($task_id)){
                    $task_id = $type['reason_id'];
                }
                if(isset($task['completed_time']) && empty($task['completed_time'])){
                    $task['completed_time'] = CurrentDateOnFormat();
                }
                if(in_array($task_id, $clinical_review_ids)){
                    $completed_clinical_task_count++;
                    $completed_clinical_task_days += NumberOfHoursBetweenTwoDates($task['created_time'], $task['completed_time']);
                } elseif(in_array($task_id, $diagnostics_ids)){
                    $completed_diagnostics_task_count++;
                    $completed_diagnostics_task_days += NumberOfHoursBetweenTwoDates($task['created_time'], $task['completed_time']);
                } elseif(in_array($task_id, $discharge_plan_ids)){
                    $completed_discharge_plan_task_count++;
                    $completed_discharge_plan_task_days += NumberOfHoursBetweenTwoDates($task['created_time'], $task['completed_time']);
                }
            }

        }
        $success_array['clinical_patient_count'] = $clinical_patient_count;
        $success_array['diagnostics_patient_count'] = $diagnostics_patient_count;
        $success_array['discharge_plan_patient_count'] = $discharge_plan_patient_count;


        $total_patients = (count($success_array['clinical_patient_count'])+count($success_array['diagnostics_patient_count'])+count($success_array['discharge_plan_patient_count']));

        $success_array['clinical_percentage'] = CalculatePercentageOfTwoValues($total_patients, count($success_array['clinical_patient_count']));
        $success_array['diagnostics_percentage'] = CalculatePercentageOfTwoValues($total_patients, count($success_array['diagnostics_patient_count']));
        $success_array['discharge_plan_percentage'] = CalculatePercentageOfTwoValues($total_patients, count($success_array['discharge_plan_patient_count']));


        $success_array['clinical_patient_avg'] = $completed_clinical_task_count > 0
            ? HoursToDaysCalculation($completed_clinical_task_days / $completed_clinical_task_count)
            : 0;

        $success_array['diagnostics_patient_avg'] = $completed_diagnostics_task_count > 0
            ? HoursToDaysCalculation($completed_diagnostics_task_days / $completed_diagnostics_task_count)
            : 0;

        $success_array['discharge_plan_patient_avg'] = $completed_discharge_plan_task_count > 0
            ? HoursToDaysCalculation($completed_discharge_plan_task_days / $completed_discharge_plan_task_count)
            : 0;


        $patient_with_reason = ArrayFilter($patient_by_task, function($value) {
            return ($value != 0);
        });
        $patients_reason = [];
        foreach($patient_with_reason as $task_id => $patient_reason){
            $patients_reason[] = [
                'x' => str_replace(' - ', "\n", $all_reason_list[$task_id]),
                'y' => $patient_reason
            ];
            // $patients_reason[] = [
            //     'x' => strlen($all_reason_list[$task_id]) < 27
            //         ? str_replace(' - ', " ", $all_reason_list[$task_id])
            //         : str_replace(' ', "\n", str_replace(' - ', " ", $all_reason_list[$task_id])),
            //     'y' => $patient_reason
            // ];
        }
        $red_bed_reason_list = BedRedReason::pluck('red_text_value','id')->unique()->toArray();
        $success_array['clinical_review'] = ArrayFilter($red_bed_reason_list, function($value) {

            return  stripos(strtolower($value), 'clinical review') !== false;

        });

        $success_array['discharge_plan'] = ArrayFilter($red_bed_reason_list, function($value) {

            return  stripos(strtolower($value), 'discharge plan') !== false;

        });

        $success_array['diagnostics'] = ArrayFilter($red_bed_reason_list, function($value) {

            return  stripos(strtolower($value), 'diagnostics') !== false;

        });

        usort($patient_list_with_pending_task, function ($a, $b) {
            $timeA = strtotime($a['reason_created_time']);
            $timeB = strtotime($b['reason_created_time']);
            return $timeA <=> $timeB;
        });
        $success_array['red_bed_reason_list']                                 = $all_reason_list;

        $success_array['medical_wards'] = $medical_wards;
        $success_array['surgical_wards'] = $surgical_wards;
        $success_array['other_wards'] = $other_wards;
        $success_array['tree_data']                                    = json_encode($patients_reason, JSON_PRETTY_PRINT);
        $success_array['patient_list_with_pending_task']               = $patient_list_with_pending_task;
        $success_array['wards']                                        = Wards::orderBy('ward_name', 'ASC')->where('status', 1)->pluck('ward_name','id')->toArray();
        $view                                                          = View::make('Dashboards.Camis.RedBed.PerformanceTab', compact('success_array'));
        $sections                                                      = $view->render();
        return $sections;
    }


    public function RedBedPerformanceRightSection(Request $request){
        $all_ward_name_by_shortname = Wards::pluck('ward_name','ward_short_name')->unique()->toArray();

        $master_patient_query = CamisIboxWardPatientInformationWithBedDetailsView::when($request->filled('ward_id'), function ($q) use ($request) {
            return $q->whereIn('ibox_ward_id', $request->ward_id);
        })->where('disabled_on_all_dashboard_except_ward_summary', 0);
        $all_reason_list = BedRedReason::when($request->filled('reason_id'), function ($q) use ($request) {
            return $q->whereIn('id', $request->reason_id);
        })->when($request->filled('reason_name'), function ($q) use ($request) {
            return $q->where('red_text_value', 'like', $request->reason_name.'%');
        })->pluck('red_text_value','id')->unique()->toArray();
        $patient_by_task = [];
        foreach($all_reason_list as $reasons => $task_name){
            $patient_by_task[$reasons] = 0;
        }


        $patient_query = clone $master_patient_query;
        $red_bed_inpatients = $patient_query->pluck('camis_patient_id')->toArray();
        $red_bed_patients = CamisIboxBoardRoundRedGreenBed::where('patient_red_green_status', 1)->whereIn('patient_id', $red_bed_inpatients)->when($request->filled('reason_id'), function ($q) use ($all_reason_list) {

            $q->where(function ($query) use ($all_reason_list) {
                foreach (array_keys($all_reason_list) as $reason_id) {
                    $query->orWhere(function ($subQuery) use ($reason_id) {
                        $subQuery->orWhereRaw("JSON_EXTRACT(patient_red_green_status_reason_code, '$.\"$reason_id\"') IS NOT NULL");
                    });
                }
            });
            return $q;
        })->with('PatientInformationWithBedDetails')->get()->toArray();

        $patients_id = [];


        $patient_list_with_pending_task = [];
        foreach($red_bed_patients as $red_patient){
            $reason_list = json_decode($red_patient['patient_red_green_status_reason_code'], true);


            if($red_patient['patient_red_green_status'] == 1){
                array_push($patients_id, $red_patient['patient_id']);

                $pending_task = ArrayFilter($reason_list, function($value) use($all_reason_list) {
                    if(!isset($value['reason_id'])){
                        return false;
                    }
                    return ((!isset($value['is_complete']) && $value == 0) || (isset($value['is_complete']) && $value['is_complete'] == 0) && (isset($value['reason_id']) && in_array($value['reason_id'],array_keys($all_reason_list))));

                });


                foreach($pending_task as $key => $type){
                    if(!is_numeric($key)){
                        $key = $type['reason_id'];
                    }

                    if(isset($type['created_time'])){
                        $pending_reason_name  = $all_reason_list[$key];
                        $created_time = PredefinedDateFormatFor24Hour($type['created_time']);
                        $pending_delay_time  = PatientLos($type['created_time'], CurrentDateOnFormat());
                    } else {
                        $pending_reason_name  = $all_reason_list[$key];
                        $created_time = PredefinedDateFormatFor24Hour($red_patient['updated_at']);
                        $pending_delay_time  = PatientLos($red_patient['updated_at'], CurrentDateOnFormat());
                    }

                    $patient_list_with_pending_task[] = ['patient_bed' => $red_patient['patient_information_with_bed_details']['ibox_actual_bed_full_name'], 'patient_name' => $red_patient['patient_information_with_bed_details']['camis_patient_name'], 'patient_pas_number' => $red_patient['patient_information_with_bed_details']['camis_patient_pas_number'], 'patient_ward' => $all_ward_name_by_shortname[$red_patient['patient_information_with_bed_details']['camis_patient_ward']], 'patient_reason' => $pending_reason_name, 'patient_delay_time' => $pending_delay_time, 'reason_created_time' => $created_time];

                    $patient_by_task[$key] += 1;
                }

            }
            $reason_list = json_decode($red_patient['patient_red_green_status_reason_code'], true);

        }

        $patient_with_reason = ArrayFilter($patient_by_task, function($value) {
            return ($value != 0);
        });
        $patients_reason = [];
        foreach($patient_with_reason as $task_id => $patient_reason){
            $patients_reason[] = [
                'x' => str_replace(' - ', "\n", $all_reason_list[$task_id]),
                'y' => $patient_reason
            ];

            // $patients_reason[] = [
            //     'x' => strlen($all_reason_list[$task_id]) < 3
            //         ? str_replace(' - ', " ", $all_reason_list[$task_id])
            //         : str_replace(' ', "\n", str_replace(' - ', " ", $all_reason_list[$task_id])),
            //     'y' => $patient_reason
            // ];


        }


        usort($patient_list_with_pending_task, function ($a, $b) {
            $timeA = strtotime($a['reason_created_time']);
            $timeB = strtotime($b['reason_created_time']);
            return $timeA <=> $timeB;
        });
        $success_array['red_bed_reason_list']                                 = $all_reason_list;

        $success_array['tree_data']                                    = json_encode($patients_reason, JSON_PRETTY_PRINT);
        $success_array['patient_list_with_pending_task']               = $patient_list_with_pending_task;
        $view                                                          = View::make('Dashboards.Camis.RedBed.Partials.RightSection', compact('success_array'));
        $sections                                                      = $view->render();
        return $sections;
    }

    public function RedBedPerformancePatientList(Request $request){

        $all_ward_name_by_shortname = Wards::pluck('ward_name','ward_short_name')->unique()->toArray();


        $master_patient_query = CamisIboxWardPatientInformationWithBedDetailsView::when($request->filled('ward_id'), function ($q) use ($request) {
            return $q->whereIn('ibox_ward_id', $request->ward_id);
        })->where('disabled_on_all_dashboard_except_ward_summary', 0);
        $all_reason_list = BedRedReason::when($request->filled('reason_id'), function ($q) use ($request) {
            return $q->where('red_text_value', $request->reason_id);
        })->pluck('red_text_value','id')->unique()->toArray();
        $patient_by_task = [];
        foreach($all_reason_list as $reasons => $task_name){
            $patient_by_task[$reasons] = 0;
        }


        $patient_query = clone $master_patient_query;
        $red_bed_inpatients = $patient_query->pluck('camis_patient_id')->toArray();
        $red_bed_patients = CamisIboxBoardRoundRedGreenBed::where('patient_red_green_status', 1)->whereIn('patient_id', $red_bed_inpatients)->when($request->filled('reason_id'), function ($q) use ($all_reason_list) {

            $q->where(function ($query) use ($all_reason_list) {
                foreach (array_keys($all_reason_list) as $reason_id) {
                    $query->orWhere(function ($subQuery) use ($reason_id) {
                        $subQuery->orWhereRaw("JSON_EXTRACT(patient_red_green_status_reason_code, '$.\"$reason_id\"') IS NOT NULL");
                    });
                }
            });
            return $q;
        })->with('PatientInformationWithBedDetails')->get()->toArray();



        $patient_list_with_pending_task = [];
        foreach($red_bed_patients as $red_patient){
            $reason_list = json_decode($red_patient['patient_red_green_status_reason_code'], true);


            if($red_patient['patient_red_green_status'] == 1){

                $pending_task = ArrayFilter($reason_list, function($value) use($all_reason_list) {
                    if(!isset($value['reason_id'])){
                        return false;
                    }
                    return ((!isset($value['is_complete']) && $value == 0) || (isset($value['is_complete']) && $value['is_complete'] == 0) && (isset($value['reason_id']) && in_array($value['reason_id'],array_keys($all_reason_list))));

                });


                foreach($pending_task as $key => $type){

                    if(isset($type['created_time'])){
                        $pending_reason_name  = $all_reason_list[$key];
                        $created_time = PredefinedDateFormatFor24Hour($type['created_time']);
                        $pending_delay_time  = PatientLos($type['created_time'], CurrentDateOnFormat());
                    } else {
                        $pending_reason_name  = $all_reason_list[$key];
                        $created_time = PredefinedDateFormatFor24Hour($red_patient['updated_at']);
                        $pending_delay_time  = PatientLos($red_patient['updated_at'], CurrentDateOnFormat());
                    }

                    $patient_list_with_pending_task[] = ['patient_bed' => $red_patient['patient_information_with_bed_details']['ibox_actual_bed_full_name'], 'patient_name' => $red_patient['patient_information_with_bed_details']['camis_patient_name'], 'patient_pas_number' => $red_patient['patient_information_with_bed_details']['camis_patient_pas_number'], 'patient_ward' => $all_ward_name_by_shortname[$red_patient['patient_information_with_bed_details']['camis_patient_ward']], 'patient_reason' => $pending_reason_name, 'patient_delay_time' => $pending_delay_time, 'reason_created_time' => $created_time];

                }

            }

        }
        usort($patient_list_with_pending_task, function ($a, $b) {
            $timeA = strtotime($a['reason_created_time']);
            $timeB = strtotime($b['reason_created_time']);
            return $timeA <=> $timeB;
        });

        $success_array['patient_list_with_pending_task']               = $patient_list_with_pending_task;
        $view                                                          = View::make('Dashboards.Camis.RedBed.Partials.PatientList', compact('success_array'));
        $sections                                                      = $view->render();
        return $sections;
    }

    public function GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_desc, $gov_text_after_arr, $functional_identity, $operation)
    {
        $gov_data                                   = array();
        if ($operation == 1)
        {
            if ($gov_text_after_arr)
            {
                $gov_text_after                     = $gov_text_after_arr->toArray();
            }

            if (isset($gov_text_after["id"]))
            {
                $gov_data["gov_text_before"]        = "";
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 2)
        {
            if ($gov_text_after_arr)
            {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"]))
            {

                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;

            }
        }

        if ($operation == 4)
        {
            if ($gov_text_after_arr)
            {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"]))
            {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 5)
        {
            if ($gov_text_after_arr)
            {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"]))
            {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 3)
        {
            if (isset($gov_text_before["id"]))
            {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = "";
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if (!empty($gov_data))
        {
            if (count($gov_data) > 0)
            {

                $governance = new GovernanceController;
                $governance->GovernanceStoreCamisData($gov_data);
            }
        }
    }

}
