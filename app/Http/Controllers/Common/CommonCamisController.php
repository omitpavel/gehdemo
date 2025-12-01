<?php

namespace App\Http\Controllers\Common;

use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundEstimatedDischargeDate;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundInfectionRisk;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPharmacyComment;
use App\Models\Iboards\Symphony\Data\OpelCurrentStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Iboards\Camis\WardSummaryController;
use App\Models\History\HistoryCamisIboxBoardRoundPatientStatus;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientTasks;
use App\Models\Iboards\Camis\Master\BedRedReason;
use App\Models\Iboards\Camis\Master\TaskGroup;
use App\Models\Iboards\Camis\Master\DpTasks;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskAkiAssessmentTasks;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskNofTasks;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskSepsisTasks;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use App\Models\Iboards\Camis\Master\DtocPathway;
use App\Models\Iboards\Camis\Master\InfectionControl;
use App\Models\Iboards\Camis\Master\TaskCategory;
use App\Models\Iboards\Camis\View\CamisIboxWardWeeklyDischarge;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Session;

class CommonCamisController extends Controller
{
    public function PatientBedDetailsWardSummary($ward_id, $process_array, &$success_array)
    {
        $data_array                 = array();
        $ward_patient_list_array    = array();
        $patient_array              = CamisIboxWardPatientInformationWithBedDetailsView::with([
                                    'PatientWiseFlags'=>function($q){
                                        $q->where('patient_flag_status_value',1);
                                    },
                                    'BoardRoundAdmittingReason'=>function($q){
                                        $q->select('id','patient_id','patient_admitting_reason');
                                    },
                                    'BoardRoundSocialHistory'=>function($q){
                                        $q->select('id','patient_id','patient_social_history');
                                    },
                                    'BoardRoundPatientGoal'=>function($q){
                                        $q->select('id','patient_id','patient_patient_goal');
                                    },
                                    'BoardRoundPastMedicalHistory'=>function($q){
                                        $q->select('id','patient_id','patient_past_medical_history');
                                    },

                                    'BoardRoundPharmacyData'=>function($q){
                                        $q->select('id','patient_id','pharmacy_drug_history','pharmacy_antibiotic_iv_status','pharmacy_antibiotic_oral_status','pharmacy_latest_comment','updated_at');
                                    },
                                    'BoardRoundMedicallyFitData'=>function($q){
                                        $q->select('id','patient_id','patient_medically_fit_status','patient_medically_fit_status_comment');
                                    },
                                    'BoardRoundTherapyFitData'=>function($q){
                                        $q->select('id','patient_id','patient_therapy_fit_status');
                                    },
                                    'BoardRoundEstimatedDischargeDate'=>function($q){
                                        $q->select('id','patient_id','patient_estimated_discharge_date','patient_estimated_discharge_date_comment');
                                    },
                                    'BoardRoundStatus'=>function($q) use($ward_id){
                                        $q->where('ward_id', $ward_id);
                                    },
                                    'PatientHandOver',
                                    'BoardRoundPatientTasks',
                                    'BoardRoundPatientTasks.PatientTaskGroup',
                                    'BoardRoundPatientTasks.PatientTaskCategory',
                                    'AllowedToMove',
                                    'RedGreenBed',
                                    'RedGreenBed.RedGreenReason',
                                    'PotentialDefinite',
                                    'PatientVitalPacInfo',
                                    'IboxBedStatus',
                                    'BoardRoundEdn',
                                    'BoardRoundTto',
                                    'BoardRoundCdt', 'BoardRoundLevel'
                                ])->where('ibox_ward_id', '=', $ward_id)->where('ibox_bed_type', '=', 'Bed')->get();


        if (count($patient_array) > 0)
        {
            $data_array       = $patient_array->toArray();
            array_unshift($data_array, null);
            unset($data_array[0]);
        }
        $success_array['patient_details'] = $data_array;
        $all_wards = Wards::select('id', 'ward_short_name', 'ward_name', 'ward_shown_name')->where('status', 1)->get()->toArray();

        $success_array['ward_array'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_shown_name']) ? $ward_data['ward_shown_name'] : $ward_data['ward_name'];
            return $carry;
        }, []);



        $view = View::make('Dashboards.Camis.WardSummary.PatientBoardRoundInfo', compact('success_array'));

    }




    public function GetAllConsultantByWard(&$ward_id, &$process_array, &$success_array)
    {

        $name_array = array_filter(array_unique(array_column($success_array['patient_details'], 'camis_consultant_name')), function($value) {
            return $value !== null;
        });
        $new_keys = array_map(function($value) {
            return str_replace(' ', '_ibox_', $value);
        }, $name_array);

        $combined_array = array_combine($new_keys, $name_array);

        $success_array['consultnat_list'] = $combined_array;

    }

    public function WardSummaryEddCalculate(&$process_array, &$success_array)
    {
        $one_to_three                        = 0;
        $four_to_seven                       = 0;
        $eight_more                          = 0;
        $patient_edds = CamisIboxBoardRoundEstimatedDischargeDate::whereIn('patient_id',$process_array['patient_ids'])->whereDate('patient_estimated_discharge_date', '<', Carbon::today()->toDateString())
            ->get();
        foreach ($patient_edds as $data) {
            $estimatedDischargeDate = Carbon::parse($data->patient_estimated_discharge_date);

            $differenceInDays = Carbon::today()->diffInDays($estimatedDischargeDate);

            if ($differenceInDays >= 1 && $differenceInDays <= 3) {
                $one_to_three++;
            } elseif ($differenceInDays >= 4 && $differenceInDays <= 7) {
                $four_to_seven++;
            } elseif ($differenceInDays >= 8) {
                $eight_more++;
            }
        }

        $success_array['one_to_three'] = $one_to_three;
        $success_array['four_to_seven'] = $four_to_seven;
        $success_array['eight_more'] = $eight_more;

    }




    public function GenderWiseEmptyBed(&$process_array, &$success_array){
        $success_array['empty_bed_female'] = count(array_filter($success_array['patient_details'], function ($patient_array) {
            return (empty($patient_array['camis_patient_id']) && strtolower($patient_array['bay_gender_value']) == strtolower('female') && strtolower($patient_array['ibox_bed_status_camis']) == strtolower('open'));
        }));
        $success_array['empty_bed_male'] = count(array_filter($success_array['patient_details'], function ($patient_array) {
            return (empty($patient_array['camis_patient_id']) && strtolower($patient_array['bay_gender_value']) == strtolower('male') && strtolower($patient_array['ibox_bed_status_camis']) == strtolower('open'));
        }));
        $success_array['empty_bed_sideroom'] = count(array_filter($success_array['patient_details'], function ($patient_array) {
            return (empty($patient_array['camis_patient_id']) && strtolower($patient_array['bay_gender_value']) == strtolower('side room') && strtolower($patient_array['ibox_bed_status_camis']) == strtolower('open'));
        }));
    }




    public function AllTaskList(&$process_array, &$success_array, $user_group = null){
        $dp_task = DpTasks::when($user_group != null, function ($query) use ($user_group) {
            return $query->where('user_task_group', $user_group);
        })->pluck('auto_populate_task_name')->toArray();
        $board_round_user_task_aki_assesment_task = BoardRoundUserTaskAkiAssessmentTasks::when($user_group != null, function ($query) use ($user_group) {
            return $query->where('user_task_group', $user_group);
        })->pluck('auto_populate_task_name')->toArray();
        $board_round_user_task_nof_task = BoardRoundUserTaskNofTasks::when($user_group != null, function ($query) use ($user_group) {
            return $query->where('user_task_group', $user_group);
        })->pluck('auto_populate_task_name')->toArray();
        $board_round_user_task_sepsis_task = BoardRoundUserTaskSepsisTasks::when($user_group != null, function ($query) use ($user_group) {
            return $query->where('user_task_group', $user_group);
        })->pluck('auto_populate_task_name')->toArray();

        $all_task_combine = array_merge($dp_task, $board_round_user_task_aki_assesment_task, $board_round_user_task_nof_task, $board_round_user_task_sepsis_task);
        $success_array['all_tasks_list'] = $all_task_combine;
    }

    public function PatientDetailsBedDefaultValueSettings(&$process_array, &$success_array)
    {
        $ward_patient_list_array                                                                = array();
        $patient_count                                                                          = 0;
        $ward_patient_surname_array     = array();

        if (count($success_array['patient_details']) > 0)
        {
            foreach ($success_array['patient_details'] as $key => $val)
            {
                if ($val['camis_patient_surname'] != '')
                {
                    $ward_patient_surname_array[] =  trim($val['camis_patient_surname']);
                }
            }
        }
        $ward_patient_surname_count_values             = array_count_values($ward_patient_surname_array);
        $camis_patient_id_prev                         = '';
        $camis_patient_id_prev_key                     = '';

        if (count($success_array['patient_details']) > 0)
        {
            foreach ($success_array['patient_details'] as $key => $val)
            {

                $success_array['patient_details'][$key]['patient_bed_bay']                      = ($val['ibox_bed_group_number'] != 0) ? $val['ibox_bed_group_name'] . ' ' . $val['ibox_bed_group_number'] : $val['ibox_bed_group_name'];
                $success_array['patient_details'][$key]['ibox_patient_hide_name']               = '';
                $success_array['patient_details'][$key]['ibox_patient_admit_date_los_value']    = 0;
                $success_array['patient_details'][$key]['ibox_patient_surname_count']           = 0;

                if ($val['camis_patient_id'] == '')
                {

                    if ($val['ibox_bed_status_camis'] == 'open')
                    {
                        $success_array['patient_details'][$key]['ibox_bed_tab_colour_set']      = $process_array['camis_ward_summary_empty_bed_tab_colour_default'];
                        $success_array['patient_details'][$key]['ibox_bed_text_colour_set']     = $process_array['camis_ward_summary_empty_bed_tab_text_colour_default'];
                    }
                    else
                    {
                        $success_array['patient_details'][$key]['ibox_bed_tab_colour_set']      = $process_array['camis_ward_summary_closed_bed_tab_colour_default'];
                        $success_array['patient_details'][$key]['ibox_bed_text_colour_set']     = $process_array['camis_ward_summary_closed_bed_tab_text_colour_default'];
                    }
                }
                else
                {
                    $patient_count++;
                    $success_array['patient_details'][$key]['ibox_patient_hide_name']                           = 'Patient ' . WardBedShowPatientCharacter($patient_count);
                    $success_array['patient_details'][$key]['ibox_patient_admit_date_los_value']                = NumberOfDaysBetweenTwoDates($val['camis_patient_admission_date'], date('Y-m-d'));
                    $success_array['patient_details'][$key]['camis_patient_name']                               = ucwords(strtolower(trim($val['camis_patient_name'])));
                    $success_array['patient_details'][$key]['camis_patient_post_code']                          = trim($val['camis_patient_post_code']);
                    if (isset($ward_patient_surname_count_values[$success_array['patient_details'][$key]['camis_patient_surname']]))
                    {
                        $success_array['patient_details'][$key]['ibox_patient_surname_count']                   = $ward_patient_surname_count_values[$success_array['patient_details'][$key]['camis_patient_surname']];
                    }
                    $success_array['patient_details'][$key]['camis_patient_id_prev_bed_order']                  = ($camis_patient_id_prev != '') ? $camis_patient_id_prev : '';
                    $success_array['patient_details'][$key]['camis_patient_id_curr_bed_order']                  = $val['camis_patient_id'];
                    $success_array['patient_details'][$key]['camis_patient_id_next_bed_order']                  = '';
                    if ($camis_patient_id_prev_key  != '')
                    {
                        $success_array['patient_details'][$camis_patient_id_prev_key]['camis_patient_id_next_bed_order']          = $val['camis_patient_id'];
                    }
                    $camis_patient_id_prev                                                                      = $val['camis_patient_id'];
                    $camis_patient_id_prev_key                                                                  = $key;
                    $success_array['patient_details'][$key]['flags']                                            = $val['patient_wise_flags'];

                }
            }
            $success_array['infection_control'] = InfectionControl::where('status', 1)->get();
        }
    }


    public function PatientDetailsArrangingForWardListing(&$process_array, &$success_array)
    {
        $ward_patient_list_array        = array();

        if (count($success_array['patient_details']) > 0)
        {
            foreach ($success_array['patient_details'] as $key => $val)
            {
                $ward_patient_list_array[$val['patient_bed_bay']][] = $val;
            }
        }
        $success_array['ward_patient_list_array'] = $ward_patient_list_array;
    }





    public function DefiniteDischargePatientList($ward_id, &$process_array, &$success_array)
    {
        $success_array['patient_definite_today'] = array_values(array_filter($success_array['patient_details'], function($item) {
            return (isset($item['potential_definite']['type']) && in_array($item['potential_definite']['type'], [2]) && in_array($item['potential_definite']['potential_definite_date'], [Carbon::now()->toDateString()]));
        }));
    }

    public function PotentialDischargePatientList($ward_id, &$process_array, &$success_array)
    {
        $success_array['patient_potential_today'] = array_values(array_filter($success_array['patient_details'], function($item) {

            return (isset($item['potential_definite']['type']) && in_array($item['potential_definite']['type'], [1])&& in_array($item['potential_definite']['potential_definite_date'], [Carbon::now()->toDateString()]));
        }));
    }



    public function WeeklyTarget($ward_id, &$process_array, &$success_array){
        $success_array['daily_target']  = $process_array['ward_details']['ward_daily_goal'];
        $current_date = Carbon::now();

        $start_of_current_week = $current_date->startOfWeek()->format('Y-m-d H:i:s');
        $end_of_current_week = $current_date->endOfWeek()->format('Y-m-d 11:59:s');

        $out_patients_records = CamisIboxWardWeeklyDischarge::select('camis_patient_id', 'dayname')->where('camis_patient_ward_id', $ward_id)

            ->whereBetween('camis_patient_discharge_date_time', [$start_of_current_week, $end_of_current_week])

            ->orderBy('camis_patient_discharge_date_time', 'desc')
            ->get()->toArray();

        $day_wise_counts = [
            'monday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'monday');
            })),
            'tuesday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'tuesday');
            })),
            'wednesday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'wednesday');
            })),
            'thursday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'thursday');
            })),
            'friday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'friday');
            })),
            'saturday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'saturday');
            })),
            'sunday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'sunday');
            })),
        ];

        $success_array['weekly_discharges_total'] = count($out_patients_records);
        $success_array['weekly_discharges'] = $day_wise_counts;

    }

    public function GetPatientDetailsInformationSummary(Request $request)
    {
        $process_array                      = array();
        $success_array                      = array();
        $camis_patient_id                   = CleanString($request->camis_patient_id);
        $group_number_count_arr             = array();
        $patient_details                    = array();
        $flag_array                         = array();
        $user_id                            = Session()->get('LOGGED_USER_ID', '');


        if($request->is_boardround == 1){
            $ward_summary_controller = new WardSummaryController;
            $ward_summary_controller->InsertBoardRoundData($camis_patient_id);

        }
        $patient_info_details      = CamisIboxWardPatientInformationWithBedDetailsView::with(['PatientWiseFlags'=>function($q){
            $q->where('patient_flag_status_value',1);
        },
            'AllowedToMove', 'RedGreenBed', 'RedGreenBed.RedGreenReason', 'PotentialDefinite', 'BoardRoundPastMedicalHistory','BoardRoundPatientGoal','BoardRoundTherapyFitData','BoardRoundMedicallyFitData', 'BoardRoundEstimatedDischargeDate', 'BoardRoundReasonToReside', 'BoardRoundReasonToReside.ReasonToResideCategory', 'BoardRoundTto', 'BoardRoundEdn', 'BoardRoundCdt', 'BoardRoundPharmacyData', 'BoardRoundAdmittingReason', 'BoardRoundSocialHistory', 'BoardRoundWorkingDiagnosis',
            'BoardRoundPathwayRequirement',
            'BoardRoundCareRequirement','BoardRoundDtocComments' => function ($query) {
                $query->orderBy('date', 'DESC');
            },'PatientVitalPacInfo', 'BoardRoundLevel'
        ])->where('camis_patient_id', '=', $camis_patient_id)->first();

        if (strtolower($patient_info_details->ibox_ward_short_name) != 'rltsauip')
        {
            $show_flag_group                    = BoardRoundFlagList::where('show_on_normal_ward', '=', 1)->where('status', '=', 1)->orderBy('patient_flag_group_number_normal_ward', 'ASC')->pluck('patient_flag_group_number_normal_ward')->toArray();

            foreach($show_flag_group as $flag_group){
                $flag_array[$flag_group]['group_id'] = $flag_group;
                $flag_array[$flag_group]['flag_list'] = BoardRoundFlagList::where('show_on_normal_ward', '=', 1)->where('status', '=', 1)->where('patient_flag_group_number_normal_ward', $flag_group)->orderBy('patient_flag_group_number_normal_ward', 'ASC')->orderBy('patient_flag_priority_normal_ward', 'ASC')->get()->toArray();
            }
        } else {
            $show_flag_group                    = BoardRoundFlagList::where('show_on_sau_ward', '=', 1)->where('status', '=', 1)->orderBy('patient_flag_group_number_sau_ward', 'ASC')->pluck('patient_flag_group_number_sau_ward')->toArray();

            foreach($show_flag_group as $flag_group){
                $flag_array[$flag_group]['group_id'] = $flag_group;
                $flag_array[$flag_group]['flag_list'] = BoardRoundFlagList::where('show_on_sau_ward', '=', 1)->where('status', '=', 1)->where('patient_flag_group_number_sau_ward', $flag_group)->orderBy('patient_flag_group_number_sau_ward', 'ASC')->orderBy('patient_flag_priority_sau_ward', 'ASC')->get()->toArray();
            }
        }


        $board_round_text                                           = 'boardround_'.$patient_info_details->ibox_ward_id.'_'.$user_id;
        $board_round_type                                           = 'boardround_type_'.$patient_info_details->ibox_ward_id.'_'.$user_id;
        $board_round_doctor_id                                      = 'boardround_doctor_'.$patient_info_details->ibox_ward_id.'_'.$user_id;
        $board_round_last_patient                                   = 'boardround_last_patient_'.$patient_info_details->ibox_ward_id.'_'.$user_id;

        $board_round_order                                          = $request->board_round_order;
        $ward_id = $patient_info_details->ibox_ward_id;
        $current_time = Carbon::now();
        $current_hour = $current_time->format('H');

        $bed_order =  CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $patient_info_details->ibox_ward_id)->whereNotNull('camis_patient_id')->where('ibox_bed_type', '=', 'Bed');

        if ($request->has('is_boardround') && $request->is_boardround == 1 && Session::has('boardround_data') && Session::get('boardround_data') == $board_round_text) {
            if(Session::has($board_round_type) && Session::get($board_round_type) == 'stranded'){
                $bed_order = $bed_order->whereDate('camis_patient_admission_date', '<=', Carbon::now()->subDays(7)->toDateString());
            } elseif(Session::has($board_round_type) && Session::get($board_round_type) == 'doctor'){
                $bed_order = $bed_order->where('camis_consultant_name', str_replace('_ibox_', ' ', Session::get($board_round_doctor_id)));
            }
        }
        if ($request->has('board_round_order') && $request->board_round_order == 1){
            if ($current_hour >= 0 && $current_hour <= 11)
            {
                $existing_query = HistoryCamisIboxBoardRoundPatientStatus::where('is_board_round', 1)
                    ->where('ward_id', $ward_id)
                    ->whereDate('updated_at', now()->toDateString())
                    ->whereRaw("SUBSTRING(updated_at, 12, 2) BETWEEN '00' AND '11'")
                    ->pluck('patient_id')->toArray();
            }
            else
            {
                $existing_query = HistoryCamisIboxBoardRoundPatientStatus::where('is_board_round', 1)
                    ->where('ward_id', $ward_id)
                    ->whereDate('updated_at', now()->toDateString())
                    ->whereRaw("SUBSTRING(updated_at, 12, 2) BETWEEN '12' AND '23'")
                    ->pluck('patient_id')->toArray();
            }
            $bed_order = $bed_order->whereNotIn('camis_patient_id', $existing_query);

        }
        $bed_order = $bed_order->pluck('camis_patient_id')->toArray();
        $currentBedIndex = array_search($patient_info_details->camis_patient_id, $bed_order);
        $next_patient = null;
        if ($currentBedIndex !== false && $currentBedIndex < count($bed_order) - 1) {
            $next_patient = $bed_order[$currentBedIndex + 1];
        }
        $prev_patient = null;
        if ($currentBedIndex !== false && $currentBedIndex > 0) {
            $prev_patient = $bed_order[$currentBedIndex - 1];
        }
        if (isset($patient_info_details) && isset($patient_info_details->camis_patient_id) && isset($patient_info_details->ibox_bed_no))
        {
            if ($patient_info_details->camis_patient_id != '' && $patient_info_details->ibox_bed_no != '')
            {
                $patient_details       = $patient_info_details->toArray();
            }
        }
        if (count($patient_details) > 0)
        {

            if($request->is_boardround == 1){
                if($next_patient != null){
                    Session::put($board_round_last_patient, $next_patient);
                } else {
                    Session::put($board_round_last_patient, $patient_details['camis_patient_id']);
                }
            }

            $patient_details['patient_bed_bay']                         = ($patient_details['ibox_bed_group_number'] != 0) ? $patient_details['ibox_bed_group_name'] . ' ' . $patient_details['ibox_bed_group_number'] : $patient_details['ibox_bed_group_name'];
            $patient_details['ibox_patient_admit_date_los_value']       = NumberOfDaysBetweenTwoDates($patient_details['camis_patient_admission_date'], date('Y-m-d'));
            $patient_details['ibox_patient_admit_date_los_value_ward']  = NumberOfDaysBetweenTwoDates($patient_details['camis_patient_ward_start_date'], date('Y-m-d'));
            $patient_details['camis_patient_name']                      = ucwords(strtolower(trim($patient_details['camis_patient_name'])));
            $patient_details['camis_consultant_name']                   = ucwords(strtolower(trim($patient_details['camis_consultant_name'])));
            $patient_details['camis_patient_post_code']                 = trim($patient_details['camis_patient_post_code']);
            $patient_details['camis_consultant_code_description']       = ucwords(strtolower(trim($patient_details['camis_consultant_code_description'])));
            $patient_details['camis_consultant_code_description']       = (strlen($patient_details['camis_consultant_code_description']) < 5) ? strtoupper($patient_details['camis_consultant_code_description']) : $patient_details['camis_consultant_code_description'];
//            $patient_details['total_ward_history_movement']             = CamisIboxWardHistory::select('id')->where('id', $patient_details['camis_patient_id'])->count();
            $los_text_show_head                                         = 'LOS ' . $patient_details['ibox_patient_admit_date_los_value'];
            $los_text_show_head                                        .= ($patient_details['ibox_patient_admit_date_los_value'] > 1) ? ' Days ' : ' Day ';
            $los_text_show_head                                        .= 'Total With ' . $patient_details['ibox_patient_admit_date_los_value_ward'];
            $los_text_show_head                                        .= ($patient_details['ibox_patient_admit_date_los_value_ward'] > 1) ? ' Days ' : ' Day ';
            $los_text_show_head                                        .= 'On This Ward';
            $patient_details['boardround_header_text_value']            = $patient_details['patient_bed_bay'] . ' : ' . $patient_details['ibox_bed_no'] . ' - ' . $patient_details['camis_patient_name'] . ' (' . $patient_details['camis_patient_age'] . ') - ' . $los_text_show_head;
            $patient_details['each_patient']                            = $patient_details['patient_bed_bay'] . ' : ' . $patient_details['ibox_bed_no'] . ' - ' . $patient_details['camis_patient_name'] .' ('.$patient_details['camis_patient_age'].')';
            $patient_details['patient_ward_bed_info']                   = $patient_details['ibox_ward_name'].' - '.$patient_details['patient_bed_bay'] . ' - ' . $patient_details['ibox_bed_no'];
            $patient_details['patient_name_age']                        = $patient_details['camis_patient_forename'].'  '.$patient_details['camis_patient_surname']  .' - '.' '.$patient_details['camis_patient_age'].' Years';
            $patient_details['patient_los']                             = $los_text_show_head;
            $patient_details['patient_herat_rate']                      = $patient_details['patient_vital_pac_info']['herat_rate_val'] ?? 0;
            $patient_details['patient_ews']                             = $patient_details['patient_vital_pac_info']['totalews'] ?? 0;
            $patient_details['patient_temperature']                     = $patient_details['patient_vital_pac_info']['Temperature_val'] ?? 0;
            $patient_details['patient_weight']                          = $patient_details['patient_vital_pac_info']['patient_weight_details'] ?? 0;


            $patient_details['cpi_details']                          = '--';
        }
        $this->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
        $success_array['patient_details']        = $patient_details;
        $success_array['show_flag_list']         = $flag_array;
        $infection_risk_flag = CamisIboxBoardRoundPatientFlag::where('patient_flag_status_value', 1)->where('patient_flag_name','ibox_patient_flag_infection_risk')->where('patient_id',$camis_patient_id)->first();
        $success_array['camis_ic_status'] = 'riskfree';
        $success_array['camis_ic_text'] = 'No Infection';
        $success_array['camis_ic_status'] = 'negetive';
        if ($infection_risk_flag != null){

            $flag_record = CamisIboxBoardRoundInfectionRisk::where('patient_id', $camis_patient_id)
                ->where('is_primary', 1)
                ->first();

            $primary_flag = $flag_record ? $flag_record->toArray() : [];

            if (!empty($primary_flag)) {
                if ((($primary_flag['infection_type'] == "CONFIRMED" || $primary_flag['infection_type'] == "QUERY"))) {
                    $success_array['camis_ic_status'] = 'posetive';
                    $success_array['camis_ic_text'] = $primary_flag['infection_name'] . ' - ' . ucwords(strtolower($primary_flag['infection_type']));
                } else {
                    if ($primary_flag['infection_type'] == 'CANSTAYINBAY') {
                        $ic_text = 'CAN STAY IN BED';
                    } else {
                        $ic_text = $primary_flag['infection_type'];
                    }
                    $success_array['camis_ic_status'] = 'negetive';
                    $success_array['camis_ic_text'] = $primary_flag['infection_name'] . ' - ' . ucwords(strtolower($ic_text));
                }
            }

        }

        $success_array['group_number_width_arr']  = $show_flag_group;
        $success_array['next_patient']            = $next_patient;
        $success_array['prev_patient']            = $prev_patient;


        $success_array['today']  = Carbon::now();

        $success_array['tomorrow'] = Carbon::now()->addDay();

        $success_array['dayAfterTomorrow']   = Carbon::now()->addDays(2);
        $pharmacy_latest_comment            = CamisIboxBoardRoundPharmacyComment::where('patient_id', $camis_patient_id)->orderBy('id', 'desc')->first()->pharmacy_comment ?? '';
        $success_array["pharmacy_latest_comment"]                   = $pharmacy_latest_comment;

        $success_array['dtoc_path_way_drop']                            = DtocPathway::where('status', '=', 1)->get();
        $success_array['bed_red_reason']                                = BedRedReason::where('status', '=', 1)->get();
        $all_wards = Wards::select('id', 'ward_short_name', 'ward_name', 'ward_shown_name')->where('status', 1)->get()->toArray();

        $success_array['ward_array'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_shown_name']) ? $ward_data['ward_shown_name'] : $ward_data['ward_name'];
            return $carry;
        }, []);


        if (strtolower($patient_info_details->ibox_ward_short_name) != 'rltsauip')
        {
            $view = View::make('Dashboards.Camis.WardSummary.PatientBoardRoundInfo', compact('success_array'));
        } else {

            $view = View::make('Dashboards.Camis.WardSummary.SAUPatientBoardRoundInfo', compact('success_array'));
        }
        $sections = $view->render();
        return $sections;
    }
    public function GetBoardRoundSummery(Request $request)
    {
        $process_array                      = array();
        $success_array                      = array();
        $camis_patient_id                   = CleanString($request->camis_patient_id);
        $group_number_count_arr             = array();
        $patient_details                    = array();
        $flag_array                         = array();
        $user_id                            = Session()->get('LOGGED_USER_ID', '');



        if($request->is_boardround == 1){
            $ward_summary_controller = new WardSummaryController;
            $ward_summary_controller->InsertBoardRoundData($camis_patient_id);

        }
        $patient_info_details      = CamisIboxWardPatientInformationWithBedDetailsView::with(['PatientWiseFlags'=>function($q){
            $q->where('patient_flag_status_value',1);
        },
            'AllowedToMove', 'RedGreenBed', 'RedGreenBed.RedGreenReason', 'PotentialDefinite', 'BoardRoundPastMedicalHistory','BoardRoundPatientGoal','BoardRoundMedicallyFitData','BoardRoundTherapyFitData', 'BoardRoundEstimatedDischargeDate', 'BoardRoundReasonToReside', 'BoardRoundReasonToReside.ReasonToResideCategory', 'BoardRoundTto', 'BoardRoundEdn', 'BoardRoundCdt', 'BoardRoundPharmacyData', 'BoardRoundAdmittingReason', 'BoardRoundSocialHistory', 'BoardRoundWorkingDiagnosis',
            'BoardRoundPathwayRequirement',
            'BoardRoundCareRequirement','BoardRoundDtocComments' => function ($query) {
                $query->orderBy('date', 'DESC');
            },'PatientVitalPacInfo', 'BoardRoundLevel'
        ])->where('camis_patient_id', '=', $camis_patient_id)->first();
        if (strtolower($patient_info_details->ibox_ward_short_name) != 'rltsauip')
        {
            $show_flag_group                    = BoardRoundFlagList::where('show_on_normal_ward', '=', 1)->where('status', '=', 1)->orderBy('patient_flag_group_number_normal_ward', 'ASC')->pluck('patient_flag_group_number_normal_ward')->toArray();

            foreach($show_flag_group as $flag_group){
                $flag_array[$flag_group]['group_id'] = $flag_group;
                $flag_array[$flag_group]['flag_list'] = BoardRoundFlagList::where('show_on_normal_ward', '=', 1)->where('status', '=', 1)->where('patient_flag_group_number_normal_ward', $flag_group)->orderBy('patient_flag_group_number_normal_ward', 'ASC')->orderBy('patient_flag_priority_normal_ward', 'ASC')->get()->toArray();
            }
        } else {
            $show_flag_group                    = BoardRoundFlagList::where('show_on_sau_ward', '=', 1)->where('status', '=', 1)->orderBy('patient_flag_group_number_sau_ward', 'ASC')->pluck('patient_flag_group_number_sau_ward')->toArray();

            foreach($show_flag_group as $flag_group){
                $flag_array[$flag_group]['group_id'] = $flag_group;
                $flag_array[$flag_group]['flag_list'] = BoardRoundFlagList::where('show_on_sau_ward', '=', 1)->where('status', '=', 1)->where('patient_flag_group_number_sau_ward', $flag_group)->orderBy('patient_flag_group_number_sau_ward', 'ASC')->orderBy('patient_flag_priority_sau_ward', 'ASC')->get()->toArray();
            }
        }
        $board_round_text                                           = 'boardround_'.$patient_info_details->ibox_ward_id.'_'.$user_id;
        $board_round_type                                           = 'boardround_type_'.$patient_info_details->ibox_ward_id.'_'.$user_id;
        $board_round_doctor_id                                      = 'boardround_doctor_'.$patient_info_details->ibox_ward_id.'_'.$user_id;
        $board_round_last_patient                                   = 'boardround_last_patient_'.$patient_info_details->ibox_ward_id.'_'.$user_id;

        $board_round_order                                          = $request->board_round_order;
        $ward_id = $patient_info_details->ibox_ward_id;
        $current_time = Carbon::now();
        $current_hour = $current_time->format('H');

        $bed_order =  CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $patient_info_details->ibox_ward_id)->whereNotNull('camis_patient_id')->where('ibox_bed_type', '=', 'Bed');

        if ($request->has('is_boardround') && $request->is_boardround == 1 && Session::has('boardround_data') && Session::get('boardround_data') == $board_round_text) {
            if(Session::has($board_round_type) && Session::get($board_round_type) == 'stranded'){
                $bed_order = $bed_order->whereDate('camis_patient_admission_date', '<=', Carbon::now()->subDays(7)->toDateString());
            } elseif(Session::has($board_round_type) && Session::get($board_round_type) == 'doctor'){
                $bed_order = $bed_order->where('camis_consultant_name', str_replace('_ibox_', ' ', Session::get($board_round_doctor_id)));
            }
        }
        if ($request->has('board_round_order') && $request->board_round_order == 1){
            if ($current_hour >= 0 && $current_hour <= 11)
            {
                $existing_query = HistoryCamisIboxBoardRoundPatientStatus::where('is_board_round', 1)
                    ->where('ward_id', $ward_id)
                    ->whereDate('updated_at', now()->toDateString())
                    ->whereRaw("SUBSTRING(updated_at, 12, 2) BETWEEN '00' AND '11'")
                    ->pluck('patient_id')->toArray();
            }
            else
            {
                $existing_query = HistoryCamisIboxBoardRoundPatientStatus::where('is_board_round', 1)
                    ->where('ward_id', $ward_id)
                    ->whereDate('updated_at', now()->toDateString())
                    ->whereRaw("SUBSTRING(updated_at, 12, 2) BETWEEN '12' AND '23'")
                    ->pluck('patient_id')->toArray();
            }
            $bed_order = $bed_order->whereNotIn('camis_patient_id', $existing_query);

        }
        $bed_order = $bed_order->pluck('camis_patient_id')->toArray();
        $currentBedIndex = array_search($patient_info_details->camis_patient_id, $bed_order);
        $next_patient = null;
        if ($currentBedIndex !== false && $currentBedIndex < count($bed_order) - 1) {
            $next_patient = $bed_order[$currentBedIndex + 1];
        }
        $prev_patient = null;
        if ($currentBedIndex !== false && $currentBedIndex > 0) {
            $prev_patient = $bed_order[$currentBedIndex - 1];
        }
        if (isset($patient_info_details) && isset($patient_info_details->camis_patient_id) && isset($patient_info_details->ibox_bed_no))
        {
            if ($patient_info_details->camis_patient_id != '' && $patient_info_details->ibox_bed_no != '')
            {
                $patient_details       = $patient_info_details->toArray();
            }
        }
        if (count($patient_details) > 0)
        {

            if($request->is_boardround == 1){
                if($next_patient != null){
                    Session::put($board_round_last_patient, $next_patient);
                } else {
                    Session::put($board_round_last_patient, $patient_details['camis_patient_id']);
                }
            }

            $patient_details['patient_bed_bay']                         = ($patient_details['ibox_bed_group_number'] != 0) ? $patient_details['ibox_bed_group_name'] . ' ' . $patient_details['ibox_bed_group_number'] : $patient_details['ibox_bed_group_name'];
            $patient_details['ibox_patient_admit_date_los_value']       = NumberOfDaysBetweenTwoDates($patient_details['camis_patient_admission_date'], date('Y-m-d'));
            $patient_details['ibox_patient_admit_date_los_value_ward']  = NumberOfDaysBetweenTwoDates($patient_details['camis_patient_ward_start_date'], date('Y-m-d'));
            $patient_details['camis_patient_name']                      = ucwords(strtolower(trim($patient_details['camis_patient_name'])));
            $patient_details['camis_consultant_name']                   = ucwords(strtolower(trim($patient_details['camis_consultant_name'])));
            $patient_details['camis_patient_post_code']                 = trim($patient_details['camis_patient_post_code']);
            $patient_details['camis_consultant_code_description']       = ucwords(strtolower(trim($patient_details['camis_consultant_code_description'])));
            $patient_details['camis_consultant_code_description']       = (strlen($patient_details['camis_consultant_code_description']) < 5) ? strtoupper($patient_details['camis_consultant_code_description']) : $patient_details['camis_consultant_code_description'];
//            $patient_details['total_ward_history_movement']             = CamisIboxWardHistory::select('id')->where('id', $patient_details['camis_patient_id'])->count();
            $los_text_show_head                                         = 'LOS ' . $patient_details['ibox_patient_admit_date_los_value'];
            $los_text_show_head                                        .= ($patient_details['ibox_patient_admit_date_los_value'] > 1) ? ' Days ' : ' Day ';
            $los_text_show_head                                        .= 'Total With ' . $patient_details['ibox_patient_admit_date_los_value_ward'];
            $los_text_show_head                                        .= ($patient_details['ibox_patient_admit_date_los_value_ward'] > 1) ? ' Days ' : ' Day ';
            $los_text_show_head                                        .= 'On This Ward';
            $patient_details['boardround_header_text_value']            = $patient_details['patient_bed_bay'] . ' : ' . $patient_details['ibox_bed_no'] . ' - ' . $patient_details['camis_patient_name'] . ' (' . $patient_details['camis_patient_age'] . ') - ' . $los_text_show_head;
            $patient_details['each_patient']                            = $patient_details['patient_bed_bay'] . ' : ' . $patient_details['ibox_bed_no'] . ' - ' . $patient_details['camis_patient_name'] .' ('.$patient_details['camis_patient_age'].')';
            $patient_details['patient_ward_bed_info']                   = $patient_details['ibox_ward_name'].' - '.$patient_details['patient_bed_bay'] . ' - ' . $patient_details['ibox_bed_no'];
            $patient_details['patient_name_age']                        = $patient_details['camis_patient_forename'].'  '.$patient_details['camis_patient_surname']  .' - '.' '.$patient_details['camis_patient_age'].' Years';
            $patient_details['patient_los']                             = $los_text_show_head;
            $patient_details['patient_herat_rate']                      = $patient_details['patient_vital_pac_info']['herat_rate_val'] ?? 0;
            $patient_details['patient_ews']                             = $patient_details['patient_vital_pac_info']['totalews'] ?? 0;
            $patient_details['patient_temperature']                     = $patient_details['patient_vital_pac_info']['Temperature_val'] ?? 0;
            $patient_details['patient_weight']                          = $patient_details['patient_vital_pac_info']['patient_weight_details'] ?? 0;


            $patient_details['cpi_details']                          = '--';
        }
        $this->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
        $success_array['patient_details']        = $patient_details;
        $success_array['show_flag_list']         = $flag_array;
        $infection_risk_flag = CamisIboxBoardRoundPatientFlag::where('patient_flag_status_value', 1)->where('patient_flag_name','ibox_patient_flag_infection_risk')->where('patient_id',$camis_patient_id)->first();
        $success_array['camis_ic_status'] = 'riskfree';
        $success_array['camis_ic_text'] = 'No Infection';
        $success_array['camis_ic_status'] = 'negetive';


        if ($infection_risk_flag != null){

            $flag_record = CamisIboxBoardRoundInfectionRisk::where('patient_id', $camis_patient_id)
                ->where('is_primary', 1)
                ->first();

            $primary_flag = $flag_record ? $flag_record->toArray() : [];

            if (!empty($primary_flag)) {
                if ((($primary_flag['infection_type'] == "CONFIRMED" || $primary_flag['infection_type'] == "QUERY"))) {
                    $success_array['camis_ic_status'] = 'posetive';
                    $success_array['camis_ic_text'] = $primary_flag['infection_name'] . ' - ' . ucwords(strtolower($primary_flag['infection_type']));
                } else {
                    if ($primary_flag['infection_type'] == 'CANSTAYINBAY') {
                        $ic_text = 'CAN STAY IN BED';
                    } else {
                        $ic_text = $primary_flag['infection_type'];
                    }
                    $success_array['camis_ic_status'] = 'negetive';
                    $success_array['camis_ic_text'] = $primary_flag['infection_name'] . ' - ' . ucwords(strtolower($ic_text));
                }
            }


        }

        $success_array['group_number_width_arr']  = $show_flag_group;
        $success_array['next_patient']            = $next_patient;
        $success_array['prev_patient']            = $prev_patient;


        $success_array['today']  = Carbon::now();

        $success_array['tomorrow'] = Carbon::now()->addDay();

        $success_array['dayAfterTomorrow']   = Carbon::now()->addDays(2);
        $pharmacy_latest_comment            = CamisIboxBoardRoundPharmacyComment::where('patient_id', $camis_patient_id)->orderBy('id', 'desc')->first()->pharmacy_comment ?? '';
        $success_array["pharmacy_latest_comment"]                   = $pharmacy_latest_comment;

        $success_array['dtoc_path_way_drop']                            = DtocPathway::where('status', '=', 1)->get();
        $success_array['bed_red_reason']                                = BedRedReason::where('status', '=', 1)->get();
        $all_wards = Wards::select('id', 'ward_short_name', 'ward_name', 'ward_shown_name')->where('status', 1)->get()->toArray();

        $success_array['ward_array'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_shown_name']) ? $ward_data['ward_shown_name'] : $ward_data['ward_name'];
            return $carry;
        }, []);


        if (strtolower($patient_info_details->ibox_ward_short_name) == 'rltsauip')
        {
            $view = View::make('Dashboards.Camis.WardSummary.GlobalPatientBoardRoundInfoSAU', compact('success_array'));
        } else {
            $view = View::make('Dashboards.Camis.WardSummary.GlobalPatientBoardRoundInfo', compact('success_array'));
        }

        $sections = $view->render();
        return $sections;
    }


    public function WardSummaryPatientBoardRoundTaskListOfPatient(&$success_array, $camis_patient_id, $task_type = 0)
    {

        $patient_task_list_obj                                              = CamisIboxBoardRoundPatientTasks::where('patient_id', '=', $camis_patient_id)->where(function ($query)
        {

            $query->where('task_not_applicable_status', '!=', 1)

                ->where('task_completed_status', '!=', 1);
        })->orderBy('id', 'asc')->get();

        $patient_task_list_complete                                         = CamisIboxBoardRoundPatientTasks::where('patient_id', '=', $camis_patient_id)->where(function ($query)
        {

            $query->where('task_not_applicable_status', 1)

                ->orWhere('task_completed_status', 1);
        })->orderBy('id', 'asc')->get();
        $master_task_group                                                  = TaskGroup::pluck('task_group_name', 'id')->all();
        $master_task_category                                               = TaskCategory::where('task_category_index_value', '!=', 0)->pluck('task_category_name', 'task_category_index_value')->toArray();
        $success_array = array();
        $task_to_be_completed                                               = array();
        $task_completed                                                     = array();
        if (count($patient_task_list_complete) > 0)
        {
            $patient_task_list_com                                              = $patient_task_list_complete->toArray();
            foreach ($patient_task_list_com as $key => $row)
            {
                $task_data_list                                             = $row;
                $patient_task_show_string                                   = '';
                $patient_task_show_string_class                             = '';




                if ($task_data_list['task_not_applicable_status'] == 1)
                {
                    $patient_task_show_string                          .= '#NA - ';
                }
                if (isset($master_task_category[$task_data_list['task_category']]) && $master_task_category[$task_data_list['task_category']] != '')
                {
                    $patient_task_show_string_class                     = strtolower($master_task_category[$task_data_list['task_category']]);
                    $patient_task_show_string                          .= '#' . $master_task_category[$task_data_list['task_category']] . '';
                }

                if ($task_data_list['task_dp_status_order_value'] != 0 && $task_data_list['task_category'] == 6)
                {
                    if ($task_data_list['task_not_applicable_status'] == 1 || $task_data_list['task_completed_status'] == 1)
                    {

                        $patient_task_show_string .= ' ' . $task_data_list['task_dp_status_order_value'] . ' ';
                    }
                    else
                    {
                        $patient_task_show_string .= ' ' . $task_data_list['task_dp_status_order_value'] . ' ';
                    }
                }
                if (!empty($patient_task_show_string))
                {
                    if (isset($master_task_category[$task_data_list['task_category']]) && $master_task_category[$task_data_list['task_category']] != '')
                    {
                        $patient_task_show_string                              .= ' - ' . $task_data_list['task_description'];
                    }
                    else
                    {
                        $patient_task_show_string                              .= ' ' . $task_data_list['task_description'];
                    }
                }
                else
                {
                    $patient_task_show_string                              .= $task_data_list['task_description'];
                }


                if ($task_data_list['task_daily'] == 1)
                {
                    $patient_task_show_string                          .= ' - Daily';
                }

                if ($task_data_list['task_not_applicable_status'] == 1)
                {
                    $patient_task_show_string                          .= ' - ' . PredefinedDateFormatFor24Hour($task_data_list['task_not_applicable_at']);
                }
                else
                {
                    $patient_task_show_string                          .= ' - ' . PredefinedDateFormatFor24Hour($task_data_list['task_completed_at']);
                }
                if (isset($master_task_group[$task_data_list['task_group']]) && $master_task_group[$task_data_list['task_group']] != '')
                {
                    $patient_task_show_string                          .= ' - ' . $master_task_group[$task_data_list['task_group']];
                }

                $task_data_list['patient_task_show_string']             = $patient_task_show_string;
                $task_data_list['patient_task_show_string_class']       = $patient_task_show_string_class;
                $task_completed[]                                       = $task_data_list;
            }
        }

        if (count($patient_task_list_obj) > 0)
        {
            $patient_task_list                                              = $patient_task_list_obj->toArray();
            foreach ($patient_task_list as $key => $row)
            {
                $task_data_list                                             = $row;
                $patient_task_show_string                                   = '';
                $patient_task_show_string_class                             = '';


                if (isset($master_task_category[$task_data_list['task_category']]) && $master_task_category[$task_data_list['task_category']] != '')
                {
                    $patient_task_show_string                          .= '#' . $master_task_category[$task_data_list['task_category']] . '';
                    $patient_task_show_string_class                     = strtolower($master_task_category[$task_data_list['task_category']]);
                }

                if ($task_data_list['task_dp_status_order_value'] != 0 && $task_data_list['task_category'] == 6)
                {
                    if ($task_data_list['task_not_applicable_status'] == 1 || $task_data_list['task_completed_status'] == 1)
                    {
                        $patient_task_show_string .= ' ' . $task_data_list['task_dp_status_order_value'] . ' ';
                    }
                    else
                    {
                        $patient_task_show_string .= ' ' . $task_data_list['task_dp_status_order_value'] . ' ';
                    }
                }

                if (!empty($patient_task_show_string))
                {
                    $patient_task_show_string                              .= ' - ' . $task_data_list['task_description'];
                }
                else
                {
                    $patient_task_show_string                              .= $task_data_list['task_description'];
                }
                if ($task_data_list['task_daily'] == 1)
                {
                    $patient_task_show_string                          .= ' - Daily';
                }
                $patient_task_show_string                              .= ' - ' . PredefinedDateFormatFor24Hour($task_data_list['task_estimated_date_for_completion']);
                if (isset($master_task_group[$task_data_list['task_group']]) && $master_task_group[$task_data_list['task_group']] != '')
                {
                    $patient_task_show_string                          .= ' - ' . $master_task_group[$task_data_list['task_group']];
                    $task_data_list['task_grp']                         = $master_task_group[$task_data_list['task_group']];
                }

                if ($task_data_list['task_priority'])
                {
                    $patient_task_show_string_class                     = 'priority';
                }
                $task_data_list['patient_task_show_string']             = $patient_task_show_string;
                $task_data_list['patient_task_show_string_class']       = $patient_task_show_string_class;
                $task_to_be_completed[]                                 = $task_data_list;
            }
        }
        $success_array['task_to_be_completed']                              = $task_to_be_completed;
        $success_array['task_completed']                                    = $task_completed;
        $success_array['pedning_dp_task']                                   = $patient_task_list_obj->toArray();
    }

    public function TaskOfPatients(&$tasks, $camis_patient_id)
    {
        if (count($tasks)>1){
            $tasks = CamisIboxBoardRoundPatientTasks::with('PatientTaskCategory')->where('patient_id', '=', $camis_patient_id)->latest()->get();
        }else{
            $tasks = CamisIboxBoardRoundPatientTasks::with('PatientTaskCategory')->where('patient_id', '=', $camis_patient_id)->where('task_category',2)->latest()->get();
        }

        $master_task_group = TaskGroup::pluck('task_group_name', 'id')->all();
        $success_array = array();
        $task_to_be_completed = array();
        $task_completed = array();
        if (count($tasks) > 0) {
            $patient_task_list = $tasks->toArray();
            foreach ($patient_task_list as $key => $row) {
                $task_data_list = $row;
                $patient_task_show_string = '';
                $patient_task_show_string_class = '';


                if ($task_data_list['task_not_applicable_status'] == 1 || $task_data_list['task_completed_status'] == 1) {

                    if ($task_data_list['task_dp_status_order_value'] == 0 && $task_data_list['task_category'] != 6) {
                        $task_data_list['task_dp_status_order_value'] = '';
                    }

                    if ($task_data_list['task_not_applicable_status'] == 1) {
                        $patient_task_show_string .= '#NA ';
                    }
                    if (isset($task_data_list['patient_task_category']) && $task_data_list['patient_task_category'] != '') {
                        $patient_task_show_string_class = substr(strtolower($task_data_list['patient_task_category']['task_category_name']), 1);
                        $patient_task_show_string .= '#' . $task_data_list['patient_task_category']['task_category_name'] . '';
                    }
                    if ($task_data_list['task_category'] == 6) {
                        $patient_task_show_string .= 0;
                    }
                    if(!empty($patient_task_show_string)){
                        $patient_task_show_string                              .= ' - '.$task_data_list['task_description'];
                    } else {
                        $patient_task_show_string                              .= $task_data_list['task_description'];
                    }
                    if ($task_data_list['task_daily'] == 1)
                    {
                        $patient_task_show_string                          .= ' - Daily';
                    }
                    if ($task_data_list['task_not_applicable_status'] == 1) {
                        $patient_task_show_string .= ' - ' . PredefinedDateFormatBoardRoundTaskToBeCompleted($task_data_list['task_not_applicable_at']);
                    } else {
                        $patient_task_show_string .= ' - ' . PredefinedDateFormatBoardRoundTaskToBeCompleted($task_data_list['task_completed_at']);
                    }
                    if (isset($master_task_group[$task_data_list['task_group']]) && $master_task_group[$task_data_list['task_group']] != '') {
                        $patient_task_show_string .= ' - ' . $master_task_group[$task_data_list['task_group']];
                    }

                    $task_data_list['patient_task_show_string'] = $patient_task_show_string;
                    $task_data_list['patient_task_show_string_class'] = $patient_task_show_string_class;
                    $task_completed[] = $task_data_list;
                } else {
                    if ($task_data_list['task_dp_status_order_value'] == 0 && $task_data_list['task_category'] != 6) {
                        $task_data_list['task_dp_status_order_value'] = '';
                    }
                    if (isset($task_data_list['patient_task_category']) && $task_data_list['patient_task_category'] != '') {


                        $patient_task_show_string .= '#' . $task_data_list['patient_task_category']['task_category_name'] . ' ' . $task_data_list['task_dp_status_order_value'] . ' - ';
                        $patient_task_show_string_class = substr(strtolower($task_data_list['patient_task_category']['task_category_name']), 1);
                    }
                    $patient_task_show_string .= $task_data_list['task_description'];
                    $patient_task_show_string .= ' - ' . PredefinedDateFormatBoardRoundTaskToBeCompleted($task_data_list['task_estimated_date_for_completion']);
                    if (isset($master_task_group[$task_data_list['task_group']]) && $master_task_group[$task_data_list['task_group']] != '') {
                        $patient_task_show_string .= ' - ' . $master_task_group[$task_data_list['task_group']];
                        $task_data_list['task_grp'] = $master_task_group[$task_data_list['task_group']];
                    }
                    if ($task_data_list['task_priority']) {
                        $patient_task_show_string_class = 'priority_task';
                    }
                    $task_data_list['patient_task_show_string'] = $patient_task_show_string;
                    $task_data_list['patient_task_show_string_class'] = $patient_task_show_string_class;
                    $task_to_be_completed[] = $task_data_list;
                }
            }
        }

        $success_array['task_to_be_completed'] = $task_to_be_completed;
        $success_array['task_completed'] = $task_completed;
        return $success_array;
    }



    public function OutstandingTasks($camis_patient_id, $task_doctor_at_night = null)
    {

        if(!is_null($task_doctor_at_night)) {
            $tasks = CamisIboxBoardRoundPatientTasks::with('PatientTaskCategory')->where('patient_id', '=', $camis_patient_id)
                ->where('task_doctor_at_night', 1)
                ->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->latest()->get();
        }else {
            $tasks = CamisIboxBoardRoundPatientTasks::with('PatientTaskCategory')->where('patient_id', '=', $camis_patient_id)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->latest()->get();

        }


        $master_task_group = TaskGroup::pluck('task_group_name', 'id')->all();
        $success_array = array();
        $task_to_be_completed = array();
        $task_completed = array();
        if (count($tasks) > 0) {
            $patient_task_list = $tasks->toArray();
            foreach ($patient_task_list as $key => $row) {
                $task_data_list = $row;
                $patient_task_show_string = '';
                $patient_task_show_string_class = '';



                if ($task_data_list['task_dp_status_order_value'] == 0 && $task_data_list['task_category'] != 6) {
                    $task_data_list['task_dp_status_order_value'] = '';
                }
                if (isset($task_data_list['patient_task_category']) && $task_data_list['patient_task_category'] != '') {
                    $patient_task_show_string .= '#' . $task_data_list['patient_task_category']['task_category_name'] . ' ' . $task_data_list['task_dp_status_order_value'] . ' - ';
                    $patient_task_show_string_class = substr(strtolower($task_data_list['patient_task_category']['task_category_name']), 1);
                }
                $patient_task_show_string .= $task_data_list['task_description'];
                if ($task_data_list['task_daily'] == 1)
                {
                    $patient_task_show_string                          .= ' - Daily';
                }
                $patient_task_show_string .= ' - ' . PredefinedDateFormatBoardRoundTaskToBeCompleted($task_data_list['task_estimated_date_for_completion']);
                if (isset($master_task_group[$task_data_list['task_group']]) && $master_task_group[$task_data_list['task_group']] != '') {
                    $patient_task_show_string .= ' - ' . $master_task_group[$task_data_list['task_group']];
                    $task_data_list['task_grp'] = $master_task_group[$task_data_list['task_group']];
                }
                if ($task_data_list['task_priority']) {
                    $patient_task_show_string_class = 'priority_task';
                }
                $task_data_list['patient_task_show_string'] = $patient_task_show_string;
                $task_data_list['patient_task_show_string_class'] = $patient_task_show_string_class;
                $task_to_be_completed[] = $task_data_list;

            }
        }

        $success_array['task_to_be_completed'] = $task_to_be_completed;
        $success_array['task_completed'] = $task_completed;
        return $success_array;
    }

    public function OpelStatus($status_type, &$success_array)
    {
        $opel_data = OpelCurrentStatus::where('ane_opel_status_data_type', '=', $status_type)->first();
        $success_array["ane_opel_status_data"] = 0;
        $success_array["ane_opel_status_data_show_status"] = 0;

        if (isset($opel_data->id)) {

            if ($opel_data->ane_opel_status_data == 1) {
                    $success_array["ane_opel_status_data"] = $opel_data->ane_opel_status_data;
                    $success_array["ane_opel_status_data_show_status"] = $opel_data->ane_opel_status_data_show_status;
                    $success_array["color"] = '#00b050';

            } elseif ($opel_data->ane_opel_status_data == 2) {
                    $success_array["ane_opel_status_data"] = $opel_data->ane_opel_status_data;
                    $success_array["ane_opel_status_data_show_status"] = $opel_data->ane_opel_status_data_show_status;
                    $success_array["color"] = '#ffbf00';

            } elseif ($opel_data->ane_opel_status_data == 3) {
                    $success_array["ane_opel_status_data"] = $opel_data->ane_opel_status_data;
                    $success_array["ane_opel_status_data_show_status"] = $opel_data->ane_opel_status_data_show_status;
                    $success_array["color"] = '#f44336';

            } elseif ($opel_data->ane_opel_status_data == 4) {
                    $success_array["ane_opel_status_data"] = $opel_data->ane_opel_status_data;
                    $success_array["ane_opel_status_data_show_status"] = $opel_data->ane_opel_status_data_show_status;
                    $success_array["color"] = '#000000';

            } else {
                $success_array["ane_opel_status_data"] = 0;
            }

        }
    }

    public function GetVirtualWardPatientInformation(&$process_array, &$success_array)
    {

        $ward_id = (isset($success_array['ward_id']) & !empty($success_array['ward_id'])) ? $success_array['ward_id'] : AllWardToIDArray();
        $now = date('Y-m-d');
        $patient_id = $success_array['patient_ids'];

        $data_array       = array();
        $patient_array      = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'PatientWiseFlags'=>function($q){
                $q->where('patient_flag_status_value',1);
            },
            'BoardRoundMedicallyFitData'=>function($q){
                $q->select('id','patient_id','patient_medically_fit_status','patient_medically_fit_status_comment');
            },
            'BoardRoundTherapyFitData'=>function($q){
                $q->select('id','patient_id','patient_therapy_fit_status');
            },
            'BoardRoundEstimatedDischargeDate'=>function($q){
                $q->select('id','patient_id','patient_estimated_discharge_date','patient_estimated_discharge_date_comment');
            },
            'ward'=>function($q){
                $q->with('PrimaryWardType',function ($q){
                    $q->select('id','ward_type');
                });
            },
            'BoardRoundPatientTasks' => function ($q) {
                $q->where('task_completed_status', 0)
                    ->where('task_not_applicable_status', 0)->orderBy('created_at', 'desc');
            },
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory',
            'PatientVitalPacInfo',
            'BoardRoundCdt',
            'BoardRoundEdn',
            'BoardRoundTto',
            'FrailtyPosition.FrailtyPosition.bedGroup','PatientPosition.SdecPosition.bedGroup',

        ])->whereIn('camis_patient_id', $patient_id)->whereIn('ibox_ward_id', $ward_id)
            ->withCount(['BoardRoundPatientTasks'=>function ($q) {
                $q->where('task_completed_status', 0)
                    ->where('task_not_applicable_status', 0);
            }])->where('disabled_on_all_dashboard_except_ward_summary', 0)->get();


        $ward_lists = Wards::orderBy('ward_name', 'ASC')->pluck('ward_name', 'id')->toArray();

        if (count($patient_array) > 0) {
            $data_array       = $patient_array->toArray();
            array_unshift($data_array, null);
            unset($data_array[0]);
        }

        $data_format = array();
        foreach ($data_array as $key=>$patient) {
            $data_format[$ward_lists[$patient['ibox_ward_id']]." - ".$patient['ward']['primary_ward_type']['ward_type']][] =  $patient;
        }

        $success_array['vw_n'] = str_replace("-"," ", $success_array['ward']);
        $success_array['patient_details'] = $data_format;


    }

}
