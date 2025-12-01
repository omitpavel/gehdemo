<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Controller;
use App\Models\Common\FlashMessage;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientTasks;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundMedFit;
use App\Models\Iboards\Camis\Master\BedRedReason;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskAkiAssessmentTasks;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskNofTasks;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskSepsisTasks;
use App\Models\Iboards\Camis\Master\DpTasks;
use App\Models\Iboards\Camis\Master\InfectionControl;
use App\Models\Iboards\Camis\Master\ReasonToResideGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Brian2694\Toastr\Facades\Toastr;

class StrandedPatientsController extends Controller
{
    public function Index()
    {
        if(CheckDashboardPermission('stranded_dashboard')){
            $all_wards = Wards::select('id', 'ward_short_name', 'ward_name', 'ward_shown_name')->where('status', 1)->get()->toArray();
            $success_array['ward_array'] = array_reduce($all_wards, function ($carry, $ward_data)
            {
                $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_shown_name']) ? $ward_data['ward_shown_name'] : $ward_data['ward_name'];
                return $carry;
            }, []);
            $success_array['ward_array_full_name'] = array_reduce($all_wards, function ($carry, $ward_data)
            {
                $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_name']) ? $ward_data['ward_name'] : $ward_data['ward_shown_name'];
                return $carry;
            }, []);
            $success_array['aki_task']                                      = BoardRoundUserTaskAkiAssessmentTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
            $success_array['nof_task']                                      = BoardRoundUserTaskNofTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
            $success_array['dp_task']                                       = DpTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
            $success_array['sepsis_task']                                   = BoardRoundUserTaskSepsisTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();

            $success_array['reason_to_reside']                              = ReasonToResideGroup::where('status', 1)->get();
            $red_bed_reason_array                                           = BedRedReason::where('status', '=', 1)->orderBy('red_text_value', 'asc')->pluck('red_text_value', 'id')->toArray();

            $no_red_bed_reason = ArrayFilter($red_bed_reason_array, function($item){


                return strtolower($item) == 'no reason';
            });

            $other_red_bed_reason = ArrayFilter($red_bed_reason_array, function($item){


                return strtolower($item) != 'no reason';
            });

            $success_array['bed_red_reason'] = $no_red_bed_reason + $other_red_bed_reason;
            $success_array['all_flags']                                     = BoardRoundFlagList::where('show_on_normal_ward', 1)->pluck('patient_flag_stored_name')->toArray();
            $success_array['infection_control'] = InfectionControl::where('status', 1)->get();
            $success_array['nof_task']                                      = BoardRoundUserTaskNofTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();


            return view('Dashboards.Camis.StrandedPatients.Index', compact('success_array'));
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

    public function IndexRefreshDataLoad( Request $request)
    {

        $process_array                                                  = array();
        $success_array                                                  = array();
        if ($request->los_type != null)
        {
            $process_array['los_type']                                  = $request->los_type;
        }
        else
        {
            $process_array['los_type']                                  = '0-6';
        }
        if ($request->discharge_day != null)
        {
            $process_array['discharge_day']                             = $request->discharge_day;
        }
        else
        {
            $process_array['discharge_day']                             = 'today';
        }

        if ($request->ward_id != null)
        {
            $process_array['ward_id']                                   = $request->ward_id;
        }
        else
        {
            $process_array['ward_id']                                   = 'all';
        }
        if ($request->task_type != null)
        {
            $process_array['task_type']                                 = $request->task_type;
        }
        else
        {
            $process_array['task_type']                                 = 'all';
        }
        if ($request->discharge_type != null)
        {
            $process_array['discharge_type']                            = $request->discharge_type;
        }
        else
        {
            $process_array['discharge_type']                            = 'all';
        }
        if ($request->medfit_type != null)
        {
            $process_array['medfit_type']                                 = $request->medfit_type;
        }
        else
        {
            $process_array['medfit_type']                                 = 'all';
        }

        if ($request->los_type == null)
        {


            if (CheckAnyPermission(['stranded_dashboard_super_stranded_view', 'stranded_dashboard_0_to_6_days_view', 'stranded_dashboard_7_to_13_days_view','stranded_dashboard_14_to_20_days_view']))
            {

                $process_array['los_type'] = '0-6';
            }
            else if (CheckAnyPermission(['stranded_dashboard_super_stranded_view', 'stranded_dashboard_7_to_13_days_view','stranded_dashboard_14_to_20_days_view']))
            {

                $process_array['los_type'] = '7-13';
            }
            else if (CheckAnyPermission(['stranded_dashboard_7_to_13_days_view']))
            {

                $process_array['los_type'] = '7-13';
            }
            else if (CheckAnyPermission(['stranded_dashboard_14_to_20_days_view']))
            {

                $process_array['los_type'] = '14-20';
            }
            else if (CheckAnyPermission(['stranded_dashboard_super_stranded_view']))
            {

                $process_array['los_type'] = '21+';
            }
            else
            {

                return PermissionDenied();
            }
        }
        else
        {
            $process_array['los_type']                                  = $request->los_type;

        }

        if ($process_array['los_type'] == '0-6')
        {
            $process_array['start_day']                                 = Carbon::now()->subDays(6);
        }elseif ($process_array['los_type'] == '7-13')
        {
            $process_array['start_day']                                 = Carbon::now()->subDays(13);
            $process_array['end_day']                                   = Carbon::now()->subDays(7);
        }elseif ($process_array['los_type'] == '14-20'){
            $process_array['start_day']                                 = Carbon::now()->subDays(20);
            $process_array['end_day']                                   = Carbon::now()->subDays(14);
        }
        else
        {
            $process_array['los_type']                                  = '21+';
            $process_array['startDate']                                 = Carbon::now()->subDays(21);
        }


        $this->PageDataLoad($process_array, $success_array);
        $view                                                           = View::make('Dashboards.Camis.StrandedPatients.IndexDataLoad', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }
    public function PageDataLoad(&$process_array, &$success_array)
    {
        $success_array                                                  = array();
        $flash_message                                                  = FlashMessage::where('status', 1)->first();

        $success_array["script_error_message"]                          = ErrorOccuredMessage();
        $success_array["flash_message"]                                 = $flash_message != null ? $flash_message->message : '';


        $wards           = Wards::where('status',1)->orderBy('ward_name', 'asc')->pluck('ward_name', 'id')->toArray();
        $success_array['show_on_ward_summary_status_check']             = BoardRoundFlagList::where('show_on_normal_ward', 1)->pluck('patient_flag_name', 'patient_flag_stored_name')->toArray();


        $medfit_yes                                                     = CamisIboxBoardRoundMedFit::where('patient_medically_fit_status', 1)->pluck('patient_id')->toArray();
        $site_task                                                      = CamisIboxBoardRoundPatientTasks::where('task_category', 2)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->pluck('patient_id')->toArray();
        $all_wards                                                      = Wards::where('status', 1)->pluck('id')->toArray();
        if ($process_array['los_type'] == '0-6')
        {
            $all_details                                                = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('camis_patient_admission_date', '>=', Carbon::now()->subDays(6));
        }elseif ($process_array['los_type'] == '7-13')
        {
            $all_details                                                = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('camis_patient_admission_date', '<=', Carbon::now()->subDays(7)) ->where('camis_patient_admission_date', '>=', Carbon::now()->subDays(13));
        }elseif ($process_array['los_type'] == '14-20'){
            $all_details                                                = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('camis_patient_admission_date', '<=', Carbon::now()->subDays(14)) ->where('camis_patient_admission_date', '>=', Carbon::now()->subDays(20));
        }
        else
        {
            $all_details                                                = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('camis_patient_admission_date', '<', Carbon::now()->subDays(21));
        }
        $patient_array                                                  = $all_details->when($process_array['medfit_type'] != 'all', function ($q) use ($process_array, $medfit_yes)
        {
            if ($process_array['medfit_type'] == 1)
            {
                return $q->whereIn('camis_patient_id', $medfit_yes);
            }
            else
            {
                return $q->whereNotIn('camis_patient_id', $medfit_yes);
            }
        })->when($process_array['task_type'] != 'all', function ($q) use ($site_task)
        {

            return $q->whereIn('camis_patient_id', $site_task);
        })

            ->with([
                'BoardRoundMedicallyFitData' => function ($q)
                {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment');
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
                'BoardRoundPatientTasks.PatientTaskGroup',
                'BoardRoundPatientTasks.PatientTaskCategory',
                'PotentialDefinite',
                'PatientVitalPacInfo',
                'PatientWiseFlags'

            ])->when($process_array['ward_id'] != 'all', function ($q) use ($process_array)
            {
                return $q->whereIn('camis_patient_ward_id', $process_array['ward_id']);
            })
            ->when($process_array['ward_id'] == 'all', function ($q) use ($all_wards)
            {

                return $q->whereIn('camis_patient_ward_id', $all_wards);
            })
            ->where('camis_patient_id', '<>', null)->where('ibox_bed_type', '=', 'Bed')
            ->withCount(['BoardRoundPatientTasks' => function ($q)
            {
                $q->where('task_completed_status', 0)
                    ->where('task_not_applicable_status', 0);
            }])->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();


        $ward_wise_patients = array_reduce($patient_array, function ($carry, $item)
        {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($ward_wise_patients);

        $success_array['total_patients']      = $patient_array;
        $success_array['patient_details']     = $ward_wise_patients;
        $success_array['wards']               = $wards;
        $success_array['los_type']            = $process_array['los_type'];
        $success_array['task_type']           = $process_array['task_type'];
        $success_array['medfit_type']           = $process_array['medfit_type'];
        return $success_array;
    }

    public function export(Request $request){

        if($request->filled('ward_id')){
            $ward_id = $request->ward_id;
        } else {
            $ward_id = AllWardToIDArray();
        }
        $all_inpatients                                                 = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_ward_id', $ward_id)->whereNotNull('camis_patient_id')->pluck('camis_patient_id')->toArray();
        $medfit_yes                                                     = CamisIboxBoardRoundMedFit::where('patient_medically_fit_status', 1)->whereIn('patient_id', $all_inpatients)->pluck('patient_id')->toArray();
        $site_task                                                      = CamisIboxBoardRoundPatientTasks::where('task_category', 2)->whereIn('patient_id', $all_inpatients)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->pluck('patient_id')->toArray();


        $patient_array = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $all_inpatients)->when(($request->filled('task_type') && $request->task_type == 'site'), function ($q) use($site_task){
            return $q->whereIn('camis_patient_id', $site_task);
        })->when(($request->filled('medfit_type') && $request->medfit_type == '1'), function ($q) use($medfit_yes){
            return $q->whereIn('camis_patient_id', $medfit_yes);
        })->when(($request->filled('medfit_type') && $request->medfit_type == '0'), function ($q) use($medfit_yes){
            return $q->whereNotIn('camis_patient_id', $medfit_yes);
        })->when($request->los_type, function ($q) use ($request)
        {
            if($request->los_type == '0-6'){
                return $q->where('camis_patient_admission_date', '>=', Carbon::now()->subDays(6));
            } elseif($request->los_type == '7-13') {
                return $q->where('camis_patient_admission_date', '<=', Carbon::now()->subDays(7)) ->where('camis_patient_admission_date', '>=', Carbon::now()->subDays(13));
            } elseif($request->los_type == '14-20') {
                return $q->where('camis_patient_admission_date', '<=', Carbon::now()->subDays(14)) ->where('camis_patient_admission_date', '>=', Carbon::now()->subDays(20));
            } elseif($request->los_type == '21+') {
                return $q->where('camis_patient_admission_date', '<', Carbon::now()->subDays(21));
            }
        });


        $patient_array = $patient_array->with([
            'BoardRoundMedicallyFitData'=>function($q){
                $q->select('id','patient_id','patient_medically_fit_status','patient_medically_fit_status_comment', 'updated_at');
            },
            'BoardRoundEstimatedDischargeDate'=>function($q){
                $q->select('id','patient_id','patient_estimated_discharge_date','patient_estimated_discharge_date_comment');
            }
        ])->where('camis_patient_id', '<>', null)->where('ibox_bed_type', '=', 'Bed')->where('disabled_on_all_dashboard_except_ward_summary', 0)->get();
        $name = 'Patient By LOS ('.$request->los_type.' Days)';
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
            "EDD"
        ];
        $patient_list =  $patient_array->map(function ($patient, $index) {


                return [
                    'sn' => $index + 1,
                    'id' => $patient['camis_patient_id'],
                    'ward' => $patient['ibox_ward_name'],
                    'bay_and_bed' => $patient['ibox_actual_bed_full_name'],
                    'name' => $patient['camis_patient_name'],
                    'pas_id' => $patient['camis_patient_pas_number'],
                    'consultant' => $patient['camis_consultant_name'],
                    'medfit' => isset($patient['board_round_medically_fit_data']['patient_medically_fit_status']) && $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'Yes' : 'No',
                    'los' => NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date'], date('Y-m-d')),
                    'edd' => isset($patient['board_round_estimated_discharge_date']['patient_estimated_discharge_date']) ? PredefinedDateFormatShowOnCalendarWithoutDay($patient['board_round_estimated_discharge_date']['patient_estimated_discharge_date']) : '',
                ];

        });
        return ExportFunction($patient_list, $heading, $name);

    }

}
