<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Controller;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundReasonToReside;
use App\Models\Iboards\Camis\Data\CamisIboxCalculatedDailySummary;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskAkiAssessmentTasks;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskNofTasks;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskSepsisTasks;
use App\Models\Iboards\Camis\Master\DpTasks;
use App\Models\Iboards\Camis\Master\ReasonToResideGroup;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use App\Models\Iboards\Camis\Master\TaskCategory;
use App\Models\Iboards\Camis\Master\TaskGroup;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\CarbonPeriod;

class ReasonToResideController extends Controller
{
    public function GetIndex()
    {
        if (CheckDashboardPermission('r_to_r_view_'))
        {
            $dp_task = DpTasks::pluck('auto_populate_task_name')->toArray();
            $board_round_user_task_aki_assesment_task = BoardRoundUserTaskAkiAssessmentTasks::pluck('auto_populate_task_name')->toArray();
            $board_round_user_task_nof_task = BoardRoundUserTaskNofTasks::pluck('auto_populate_task_name')->toArray();
            $board_round_user_task_sepsis_task = BoardRoundUserTaskSepsisTasks::pluck('auto_populate_task_name')->toArray();

            $all_task_combine = array_merge($dp_task, $board_round_user_task_aki_assesment_task, $board_round_user_task_nof_task, $board_round_user_task_sepsis_task);
            $success_array['all_tasks_list'] = $all_task_combine;
            $success_array['task_group']                                    = TaskGroup::where('status', '=', 1)->get();
            return view('Dashboards.Camis.ReasonToReside.Index', compact('success_array'));
        }
        elseif (CheckDashboardPermission('surgical_wards_dashboard_view'))
        {
            return redirect()->route('surgical.ward');
        }
        elseif (CheckDashboardPermission('discharged_patient_is_view_dashbaord_view'))
        {
            return redirect()->route('discharges_patient.dashboard');
        }
        elseif (CheckDashboardPermission('site_office_report_view'))
        {
            return redirect()->route('site.office');
        }
        elseif (CheckDashboardPermission('flow_dashboard_patient_search_view'))
        {
            return redirect()->route('global.patient.search');
        }
        else
        {
            Toastr::error('Permission Denied');
            return back();
        }
    }


    public function IndexRefreshDataLoad(Request $request)
    {
        $process_array                                                  = array();
        $success_array                                                  = array();

        if ($request->ward_id != null)
        {

            $process_array['ward_id']                                   = $request->ward_id;
        }
        else
        {
            $process_array['ward_id']                                   = 'all';
        }
        $process_array['reason_id']                                     = $request->reason_id;
        if ($request->tab_type != null)
        {
            $success_array['tab_type']                                  = $request->tab_type;
        }
        else
        {

            if (CheckAnyPermission(['r_to_r_view_patient_list_dashboard_view', 'r_to_r_view_summery_dashboard_view']))
            {

                $success_array['tab_type']                                  = 'summery';
                $success_array['tab_patient_list']                          = 'patient_list';
                $success_array['summery']                                   = 'summery';
            }
            elseif (CheckSpecificPermission('r_to_r_view_summery_dashboard_view'))
            {
                $success_array['tab_type']                                  = 'summery';
                $success_array['tab_patient_list']                          = 'not_permitted';
                $success_array['summery']                                   = 'summery';
            }
            elseif (CheckSpecificPermission('r_to_r_view_patient_list_dashboard_view'))
            {
                $success_array['tab_type']                                  = 'patient_list';
                $success_array['tab_patient_list']                          = 'patient_list';
                $success_array['summery']                          = 'not_permitted';
            }
            else
            {
                return PermissionDenied();
            }
        }


        if (is_numeric($request->reason_id))
        {
            $process_array['filter_reason'] = ReasonToResideGroup::where('id', $request->reason_id)->pluck('id')->unique()->toArray();
        }
        else
        {
            if($request->reason_id == 'Primary_Reason_-_Criteria_to_Reside')
            {
                $process_array['filter_reason'] = ReasonToResideGroup::where('reason_to_reside_text_value_category', 'Primary_Reason_-_Criteria_to_Reside')->pluck('id')->unique()->toArray();
            } elseif($request->reason_id == 'Rehabilitation._Reablement_And_Recovery_Stage')
            {
                $process_array['filter_reason'] = ReasonToResideGroup::where('reason_to_reside_text_value_category', 'Rehabilitation._Reablement_And_Recovery_Stage')->pluck('id')->unique()->toArray();
            } else{
                $process_array['filter_reason'] = ReasonToResideGroup::where('reason_to_reside_text_value', 'like', '' . $request->reason_id . '%')->pluck('id')->unique()->toArray();
            }
        }

        $this->PageDataLoad($process_array, $success_array);

        $return_value = match ($success_array['tab_type'])
        {
            "summery" => 'Summary',
            'patient_list' => 'PatientList',
        };
        $view                                                           = View::make('Dashboards.Camis.ReasonToReside.' . $return_value, compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function PageDataLoad(&$process_array, &$success_array)
    {
        $success_array["script_error_message"]                          = ErrorOccuredMessage();
        $patients_information_table                                     = CamisIboxWardPatientInformationWithBedDetailsView::ReturnTableName();
        $reason_to_reside_table                                         = CamisIboxBoardRoundReasonToReside::ReturnTableName();
        $success_array['show_on_ward_summary_status_check']             = BoardRoundFlagList::where('show_on_normal_ward', 1)->pluck('patient_flag_name', 'patient_flag_stored_name')->toArray();


        $all_inpatients                                                 = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('camis_patient_id')->toArray();
        $ward_list = Wards::with('PrimaryWardType')->where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)
        ->pluck('ward_short_name')->toArray();
        if (strtolower($success_array['tab_type']) == 'summery')
        {

            $all_reason_to_reside = CamisIboxBoardRoundReasonToReside::where('patient_reason_to_reside_status', '!=', 0)->with(['ReasonToResideCategory', 'PatientInformationWithBedDetails'])->whereIn('patient_id', $all_inpatients)->get()->toArray();
            $reason_counts = [
                'Function' => 0,
                'Physiology' => 0,
                'Recovery' => 0,
                'Treatment' => 0,
                'Primary_Reason_-_Criteria_to_Reside' => 0,
                'Rehabilitation._Reablement_And_Recovery_Stage' => 0
            ];
            foreach($ward_list as $ward){
                $ward_wise_reason[$ward] = [
                    'Function' => 0,
                    'Physiology' => 0,
                    'Recovery' => 0,
                    'Treatment' => 0,
                    'Primary_Reason_-_Criteria_to_Reside' => 0,
                    'Rehabilitation._Reablement_And_Recovery_Stage' => 0
                ];
            }

            foreach($all_reason_to_reside as $reason_reside){
                $patient_ward = $reason_reside['patient_information_with_bed_details']['ibox_ward_short_name'];
                if(strtolower($reason_reside['reason_to_reside_category']['reason_to_reside_text_value_category']) == 'function'){
                    $reason_counts['Function']++;
                    if(isset($ward_wise_reason[$patient_ward]['Function'])){
                        $ward_wise_reason[$patient_ward]['Function']++;
                    }
                } elseif(strtolower($reason_reside['reason_to_reside_category']['reason_to_reside_text_value_category']) == 'physiology'){
                    $reason_counts['Physiology']++;
                    if(isset($ward_wise_reason[$patient_ward]['Physiology'])){
                        $ward_wise_reason[$patient_ward]['Physiology']++;
                    }
                } elseif(strtolower($reason_reside['reason_to_reside_category']['reason_to_reside_text_value_category']) == 'recovery'){
                    $reason_counts['Recovery']++;
                    if(isset($ward_wise_reason[$patient_ward]['Recovery'])){
                        $ward_wise_reason[$patient_ward]['Recovery']++;
                    }
                } elseif(strtolower($reason_reside['reason_to_reside_category']['reason_to_reside_text_value_category']) == 'treatment'){
                    $reason_counts['Treatment']++;
                    if(isset($ward_wise_reason[$patient_ward]['Treatment'])){
                        $ward_wise_reason[$patient_ward]['Treatment']++;
                    }
                } elseif(strtolower($reason_reside['reason_to_reside_category']['reason_to_reside_text_value_category']) == strtolower('Primary_Reason_-_Criteria_to_Reside')){
                    $reason_counts['Primary_Reason_-_Criteria_to_Reside']++;
                    if(isset($ward_wise_reason[$patient_ward]['Primary_Reason_-_Criteria_to_Reside'])){
                        $ward_wise_reason[$patient_ward]['Primary_Reason_-_Criteria_to_Reside']++;
                    }
                } elseif(strtolower($reason_reside['reason_to_reside_category']['reason_to_reside_text_value_category']) == strtolower('Rehabilitation._Reablement_And_Recovery_Stage')){
                    $reason_counts['Rehabilitation._Reablement_And_Recovery_Stage']++;
                    if(isset($ward_wise_reason[$patient_ward]['Rehabilitation._Reablement_And_Recovery_Stage'])){
                        $ward_wise_reason[$patient_ward]['Rehabilitation._Reablement_And_Recovery_Stage']++;
                    }
                }
            }

            $success_array['live_percentages'] = array_map(function ($value) use ($all_reason_to_reside)
            {
                $total_patients = count($all_reason_to_reside);
                if ($total_patients != 0)
                {
                    return round(($value / $total_patients) * 100, 2);
                }
                else
                {
                    return 0;
                }
            }, $reason_counts);

            $success_array['no_x_all_wards_shortname'] = array_keys($ward_wise_reason);
            $success_array['all_wards_shortname'] = array_keys($ward_wise_reason);
            array_unshift($success_array['all_wards_shortname'], 'x');

            $success_array['function_count_wardwise'] = array_column($ward_wise_reason, 'Function');
            array_unshift($success_array['function_count_wardwise'], 'Function');

            $success_array['physiology_count_wardwise'] = array_column($ward_wise_reason, 'Physiology');
            array_unshift($success_array['physiology_count_wardwise'], 'Physiology');

            $success_array['recovery_count_wardwise'] = array_column($ward_wise_reason, 'Recovery');
            array_unshift($success_array['recovery_count_wardwise'], 'Recovery');

            $success_array['treatment_count_wardwise'] = array_column($ward_wise_reason, 'Treatment');
            array_unshift($success_array['treatment_count_wardwise'], 'Treatment');


            $success_array['Primary_Reason_-_Criteria_to_Reside_count_wardwise'] = array_column($ward_wise_reason, 'Primary_Reason_-_Criteria_to_Reside');
            array_unshift($success_array['Primary_Reason_-_Criteria_to_Reside_count_wardwise'], 'Primary_Reason_-_Criteria_to_Reside');

            $success_array['rehabilation_reason_count_wardwise_count_wardwise'] = array_column($ward_wise_reason, 'Rehabilitation._Reablement_And_Recovery_Stage');
            array_unshift($success_array['rehabilation_reason_count_wardwise_count_wardwise'], 'Rehabilitation._Reablement_And_Recovery_Stage');

            $success_array['wards_array'] = Wards::pluck('ward_name', 'ward_short_name')->toArray();
            $start_date = Carbon::now()->subDays(30);
            $end_date = Carbon::now();

            $period = CarbonPeriod::create($start_date, $end_date);

            foreach ($period as $date) {
                $date_wise_reason[$date->format('Y-m-d')] = [
                    'Function' => 0,
                    'Physiology' => 0,
                    'Recovery' => 0,
                    'Treatment' => 0,
                    'Primary_Reason_-_Criteria_to_Reside' => 0,
                    'Rehabilitation._Reablement_And_Recovery_Stage' => 0
                ];
            }

            $all_camis_summary_query = CamisIboxCalculatedDailySummary::whereBetween('date', [Carbon::parse($start_date)->format('Y-m-d'), Carbon::parse($end_date)->format('Y-m-d')])->where('summary_key', 'like', 'All_Wards_R2R_%')->get()->toArray();

            $camis_data = CamisDailySummaryArrayRearrange($all_camis_summary_query);

            $date_wise_array = array_map(fn($values) =>
                array_combine(
                    array_map(fn($key) => str_replace("All_Wards_R2R_", "", $key), array_keys($values)),
                    array_values($values)
                ),
                $camis_data
            );
            $date_wise_final_array = array_replace_recursive($date_wise_reason, $date_wise_array);

            $last_30_days = array_keys($date_wise_final_array);

            $success_array['all_dates'] = array_map(fn($date) => Carbon::parse($date)->format('jS M'), $last_30_days);
            array_unshift($success_array['all_dates'], 'x');

            $success_array['function_count_datewise'] = array_column($date_wise_final_array, 'Function');
            array_unshift($success_array['function_count_datewise'], 'Function');

            $success_array['physiology_count_datewise'] = array_column($date_wise_final_array, 'Physiology');
            array_unshift($success_array['physiology_count_datewise'], 'Physiology');

            $success_array['recovery_count_datewise'] = array_column($date_wise_final_array, 'Recovery');
            array_unshift($success_array['recovery_count_datewise'], 'Recovery');

            $success_array['treatment_count_datewise'] = array_column($date_wise_final_array, 'Treatment');
            array_unshift($success_array['treatment_count_datewise'], 'Treatment');


            $success_array['Primary_Reason_-_Criteria_to_Reside_count_datewise'] = array_column($date_wise_final_array, 'Primary_Reason_-_Criteria_to_Reside');
            array_unshift($success_array['Primary_Reason_-_Criteria_to_Reside_count_datewise'], 'Primary_Reason_-_Criteria_to_Reside');

            $success_array['rehabilation_count_datewise'] = array_column($date_wise_final_array, 'Rehabilitation._Reablement_And_Recovery_Stage');
            array_unshift($success_array['rehabilation_count_datewise'], 'Rehabilitation._Reablement_And_Recovery_Stage');




        }
        else
        {

            $wards = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->orderBy('ward_name', 'asc')->get();
            if ($process_array['ward_id'] == 'all')
            {
                $ward_id = AllWardToIDArray();
            }
            else
            {
                $ward_id = $process_array['ward_id'];
            }
            $success_array['reason_list'] = ReasonToResideGroup::whereNotNull('reason_to_reside_text_value')->whereNotIn('id', [0, 1, 2, 3, 4])->pluck('reason_to_reside_text_value', 'id')->toArray();
            $success_array['reason_category'] = ReasonToResideGroup::pluck('reason_to_reside_text_value', 'id')->toArray();
            $category_id = TaskCategory::where('status', 1)->pluck('id')->toArray();

            $patients_list = CamisIboxBoardRoundReasonToReside::join("{$patients_information_table}", "{$reason_to_reside_table}.patient_id", "=", "{$patients_information_table}.camis_patient_id")->whereNull('reason_to_reside_end_date')->when($process_array['reason_id'] != '', function ($q) use ($process_array)
                {
                    return $q->whereIn('patient_reason_to_reside_status', $process_array['filter_reason']);
                })->where('patient_reason_to_reside_status', '!=', 0)->pluck('patient_id')->toArray();

            $patient_array = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_ward_id', $ward_id)->whereIn('camis_patient_id', $patients_list)->with([
                'PotentialDefinite',

                'BoardRoundMedicallyFitData' => function ($q)
                {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                },
                'BoardRoundEstimatedDischargeDate' => function ($q)
                {
                    $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
                },
                'BoardRoundPatientTasks' => function ($q)
                {
                    $q->where('task_completed_status', 0)
                        ->where('task_not_applicable_status', 0)->orderBy('id', 'asc');
                },
                'BoardRoundReasonToReside.ReasonToResideCategory',
                'BoardRoundPatientTasks.PatientTaskGroup',
                'BoardRoundPatientTasks.PatientTaskCategory',
                'PotentialDefinite',
                'PatientVitalPacInfo',
                'PatientWiseFlags'

            ])
                ->withCount(['BoardRoundPatientTasks' => function ($q)
                {
                    $q->where('task_completed_status', 0)
                        ->where('task_not_applicable_status', 0);
                }])->where('disabled_on_all_dashboard_except_ward_summary', 0)
                ->get()->toArray();

            $ward_wise_patients = array_reduce($patient_array, function ($carry, $item)
            {
                $ward_name = $item['ibox_ward_name'];

                $carry[$ward_name][] = $item;

                return $carry;
            }, []);
            ksort($ward_wise_patients);

            $success_array['total_patients']      = $patient_array;
            $success_array['patient_details']     = $ward_wise_patients;
            $success_array['wards']             = $wards;
            $success_array['categorys']         = $category_id;
        }

        return $success_array;
    }
}
