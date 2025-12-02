<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Common\CommonCamisController;
use App\Http\Controllers\Common\CommonReportController;
use App\Http\Controllers\Common\HistoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Governance\GovernanceController;
use App\Models\Governance\GovernanceFrontendCamisOperationLogs;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Data\CamisIboxDPVirtualWardComment;
use App\Models\Iboards\Camis\Data\CamisIboxDPVirtualWardPatientStatus;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientTasks;
use App\Models\Iboards\Camis\Data\CamisIboxDPTaskDailySummary;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsFullList;
use App\Models\Iboards\Camis\View\CamisIboxPatientInfoVitalpacView;
use App\Models\History\HistoryCamisDPVirtualPatientData;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskSepsisTasks;
use App\Models\Iboards\Camis\Master\DpTasks;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\View\CamisIboxDeterioratingPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Sentinel;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;
class DeterioratingPatientController extends Controller
{
    public $common_report_controller;
    public function __construct(CommonReportController $common_report_controller)
    {
        $this->common_report_controller = $common_report_controller;
    }

    public function Index()
    {
        $success_array['sepsis_task']                                   = BoardRoundUserTaskSepsisTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();

        if(CheckDashboardPermission('dp_dashboard_new_patients_view')){
            return view('Dashboards.Camis.DeterioratingPatient.Index', compact('success_array'));
        } elseif(CheckDashboardPermission('dp_dashboard_stepdown_patients_view')){
            return redirect()->route('stepdown.patient');
        } elseif(CheckDashboardPermission('dp_dashboard_reviewed_patients_view')){
            return redirect()->route('reviewed.patient');
        } elseif(CheckDashboardPermission('dp_dashboard_removed_patients_view')){
            return redirect()->route('removed.patient');
        } elseif(CheckDashboardPermission('dp_dashboard_dp_summary_view')){
            return redirect()->route('DPSummaryMenu');
        } elseif(CheckDashboardPermission('dp_dashboard_patient_search_view')){
            return redirect()->route('patient.search');
        } elseif(CheckDashboardPermission('dp_dashboard_summary_view')){
            return redirect()->route('patient.task.summary');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }

    }

    public function ReviewedPatients()
    {
        $success_array['sepsis_task']                                   = BoardRoundUserTaskSepsisTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();

        if(CheckDashboardPermission('dp_dashboard_reviewed_patients_view')){
            return view('Dashboards.Camis.DeterioratingPatient.ReviewedPatient', compact('success_array'));
        } elseif(CheckDashboardPermission('dp_dashboard_removed_patients_view')){
            return redirect()->route('removed.patient');
        } elseif(CheckDashboardPermission('dp_dashboard_dp_summary_view')){
            return redirect()->route('DPSummaryMenu');
        } elseif(CheckDashboardPermission('dp_dashboard_patient_search_view')){
            return redirect()->route('patient.search');
        } elseif(CheckDashboardPermission('dp_dashboard_summary_view')){
            return redirect()->route('patient.task.summary');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }


    }

    public function RemovedPatients()
    {

        $success_array['sepsis_task']                                   = BoardRoundUserTaskSepsisTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();

        if(CheckDashboardPermission('dp_dashboard_removed_patients_view')){
            return view('Dashboards.Camis.DeterioratingPatient.RemovedPatient', compact('success_array'));
        } elseif(CheckDashboardPermission('dp_dashboard_dp_summary_view')){
            return redirect()->route('DPSummaryMenu');
        } elseif(CheckDashboardPermission('dp_dashboard_patient_search_view')){
            return redirect()->route('patient.search');
        } elseif(CheckDashboardPermission('dp_dashboard_summary_view')){
            return redirect()->route('patient.task.summary');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }


    }


    public function StepdownPatients()
    {
        $success_array['sepsis_task']                                   = BoardRoundUserTaskSepsisTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();

        if(CheckDashboardPermission('dp_dashboard_stepdown_patients_view')){
            return view('Dashboards.Camis.DeterioratingPatient.StepdownPatient', compact('success_array'));
        } elseif(CheckDashboardPermission('dp_dashboard_reviewed_patients_view')){
            return redirect()->route('reviewed.patient');
        } elseif(CheckDashboardPermission('dp_dashboard_removed_patients_view')){
            return redirect()->route('removed.patient');
        } elseif(CheckDashboardPermission('dp_dashboard_dp_summary_view')){
            return redirect()->route('DPSummaryMenu');
        } elseif(CheckDashboardPermission('dp_dashboard_patient_search_view')){
            return redirect()->route('patient.search');
        } elseif(CheckDashboardPermission('dp_dashboard_summary_view')){
            return redirect()->route('patient.task.summary');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }


    }

    public function DpTaskDetail(Request $request)
    {
        if(CheckDashboardPermission('dp_dashboard_task_details_view')){
            $all_wards   = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_name', 'id')->toArray();
            return view('Dashboards.Camis.DeterioratingPatient.TaskDetail', compact('all_wards'));
        } elseif(CheckDashboardPermission('dp_dashboard_patient_search_view')){
            return redirect()->route('patient.search');
        } elseif(CheckDashboardPermission('dp_dashboard_summary_view')){
            return redirect()->route('patient.task.summary');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }




    public function NewPatientDataLoad(Request $request)
    {
        $vitalpac_table = CamisIboxPatientInfoVitalpacView::ReturnTableName();
        $patients_table = CamisIboxWardPatientInformationWithBedDetailsView::ReturnTableName();

        $active_wards = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('id')->toArray();

        $dp_patients = CamisIboxDeterioratingPatient::whereIn('camis_patient_ward_id', $active_wards)->where('type', 1)->pluck('patient_id')->toArray();

        $patient_query = CamisIboxWardPatientInformationWithBedDetailsView::leftJoin(
            $vitalpac_table,
            function ($join) use ($patients_table, $vitalpac_table) {
                $join->on(
                    DB::raw("{$patients_table}.camis_patient_id COLLATE utf8mb4_general_ci"),
                    '=',
                    DB::raw("{$vitalpac_table}.camis_patient_id COLLATE utf8mb4_general_ci")
                );
            }
        )
        ->select("{$patients_table}.*", "{$vitalpac_table}.totalews")

        ->with([
            'PatientWiseFlags'=>function($q){
                $q->where(function($query){
                    $query->whereIn('patient_flag_name',['ibox_patient_flag_nurse_concern','ibox_patient_flag_covid_dp']);
                });
            },
            'BoardRoundPatientTasks'=>function($q){
                $q->whereIn('task_category', [6,7,8])->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->orderBy('created_at', 'desc');
            },
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory',
            'PatientVitalPacInfo',
            'DPVirtualWardComment'=>function($q){
                $q->orderBy('created_at', 'desc');
            },
            'BoardRoundMedicallyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
            },
            'DPVirtualWardStatus'
        ])->when($request->filled('ward_id'), function ($q) use($request){
            return $q->whereIn('ibox_ward_id', $request->ward_id);
        })->unless($request->filled('ward_id'), function ($q) {
            $q->whereIn('ibox_ward_id', AllWardToIDArray());
        })

        ->when($request->filled('sort_by'), function ($q) use($request,$patients_table,$vitalpac_table){
            if($request->sort_by == 'surname_asc'){
                $q->orderBy("{$patients_table}.camis_patient_surname", 'ASC');
            } elseif($request->sort_by == 'surname_desc'){
                $q->orderBy("{$patients_table}.camis_patient_surname", 'DESC');
            }  elseif($request->sort_by == 'ews_asc'){
            $q->orderBy($vitalpac_table.'.totalews', 'asc');
            } elseif($request->sort_by == 'ews_desc'){
                $q->orderBy($vitalpac_table.'.totalews', 'desc');
            }

        })
        ->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('ibox_bed_type', '=', 'Bed')
        ->get()->toArray();

        $success_array['patient_data'] = ArrayFilter($patient_query, function($value) use($dp_patients){
            return in_array($value['camis_patient_id'], $dp_patients);
        });

        $patient_to_exclude = CamisIboxWardPatientInformationWithBedDetailsView::where('disabled_on_all_dashboard_except_ward_summary', 1)->whereNotNull('camis_patient_id')->pluck('camis_patient_id')->toArray();


        $all_groups = CamisIboxDeterioratingPatient::whereIn('camis_patient_ward_id', $active_wards)->whereNotIn('patient_id', $patient_to_exclude)->pluck('type', 'patient_id')->toArray();

        $success_array['total_patients'] = count($all_groups);
        $new = 0;
        $reviewed = 0;
        $removed = 0;
        $discharge_to_dp = 0;
        $sd = 0;
        foreach($all_groups as $key => $value){
            if($value == 1){
                $new++;
            } elseif($value == 2){
                $reviewed++;
            } elseif($value == 3){
                $removed++;
            } elseif($value == 4){
                $discharge_to_dp++;
            } elseif($value == 5){
                $sd++;
            }
        }



        $success_array['new_patients'] = $new;
        $success_array['step_down_count'] = $sd;
        $success_array['seen_patients'] = $reviewed + $removed;
        $success_array['not_for_dp'] = $removed;
        $success_array['discharge_dp'] = $discharge_to_dp;
        $success_array['this_month'] = HistoryCamisDPVirtualPatientData::whereNotIn('patient_id', $patient_to_exclude)->whereMonth('created_at', '=', Carbon::now()->month)->where('type', 1)->count();
        $success_array['tab_name'] = 'new_patient';
        $success_array['all_wards']   = Wards::where('status', 1)->pluck('ward_name', 'id')->toArray();
        $success_array['selected_ward_id'] = $request->ward_id;
        $success_array['selected_sort_by'] = $request->sort_by;
        return view('Dashboards.Camis.DeterioratingPatient.Partials.PatientListDataLoad')->with($success_array);

    }

    public function ReviewedPatientDataLoad(Request $request)
    {
        $vitalpac_table = CamisIboxPatientInfoVitalpacView::ReturnTableName();
        $patients_table = CamisIboxWardPatientInformationWithBedDetailsView::ReturnTableName();
        $active_wards = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('id')->toArray();

        $dp_patients = CamisIboxDeterioratingPatient::whereIn('camis_patient_ward_id', $active_wards)->where('type', 2)->pluck('patient_id')->toArray();

        $patient_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn("{$patients_table}.camis_patient_id", $dp_patients)->leftJoin(
            $vitalpac_table,
            function ($join) use ($patients_table, $vitalpac_table) {
                $join->on(
                    DB::raw("{$patients_table}.camis_patient_id COLLATE utf8mb4_general_ci"),
                    '=',
                    DB::raw("{$vitalpac_table}.camis_patient_id COLLATE utf8mb4_general_ci")
                );
            }
        )
        ->select("{$patients_table}.*", "{$vitalpac_table}.totalews")

        ->with([
            'PatientWiseFlags'=>function($q){
                $q->where(function($query){
                    $query->whereIn('patient_flag_name',['ibox_patient_flag_nurse_concern','ibox_patient_flag_covid_dp','ibox_patient_flag_stepdown']);
                });
            },
            'BoardRoundPatientTasks'=>function($q){
                $q->where('task_category', 6)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->orderBy('id', 'asc');
            },
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory',
            'PatientVitalPacInfo',
            'DPVirtualWardComment'=>function($q){
                $q->orderBy('id', 'asc');
            },
            'BoardRoundMedicallyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
            },
            'DPVirtualWardStatus'
        ])->when($request->filled('ward_id'), function ($q) use ($request) {
                $q->whereIn('ibox_ward_id', $request->ward_id);
            })
            ->unless($request->filled('ward_id'), function ($q) {
                $q->whereIn('ibox_ward_id', AllWardToIDArray());
            })->when($request->filled('sort_by'), function ($q) use($request,$patients_table,$vitalpac_table){
            if($request->sort_by == 'surname_asc'){
                $q->orderBy("{$patients_table}.camis_patient_surname", 'ASC');
            } elseif($request->sort_by == 'surname_desc'){
                $q->orderBy("{$patients_table}.camis_patient_surname", 'DESC');
            }  elseif($request->sort_by == 'ews_asc'){
            $q->orderBy($vitalpac_table.'.totalews', 'asc');
            } elseif($request->sort_by == 'ews_desc'){
                $q->orderBy($vitalpac_table.'.totalews', 'desc');
            }
        })->where('ibox_bed_type', '=', 'Bed')->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();


        $success_array['patient_data'] = ArrayFilter($patient_query, function($value) use($dp_patients){
            return in_array($value['camis_patient_id'], $dp_patients);
        });



        $patient_to_exclude = CamisIboxWardPatientInformationWithBedDetailsView::where('disabled_on_all_dashboard_except_ward_summary', 1)->whereNotNull('camis_patient_id')->pluck('camis_patient_id')->toArray();

        $all_groups = CamisIboxDeterioratingPatient::whereIn('camis_patient_ward_id', $active_wards)->whereNotIn('patient_id', $patient_to_exclude)->pluck('type', 'patient_id')->toArray();

        $success_array['total_patients'] = count($all_groups);
        $new = 0;
        $reviewed = 0;
        $removed = 0;
        $discharge_to_dp = 0;
        $sd = 0;
        foreach($all_groups as $key => $value){
            if($value == 1){
                $new++;
            } elseif($value == 2){
                $reviewed++;
            } elseif($value == 3){
                $removed++;
            } elseif($value == 4){
                $discharge_to_dp++;
            } elseif($value == 5){
                $sd++;
            }
        }



        $success_array['new_patients'] = $new;
        $success_array['step_down_count'] = $sd;
        $success_array['seen_patients'] = $reviewed + $removed;
        $success_array['not_for_dp'] = $removed;
        $success_array['discharge_dp'] = $discharge_to_dp;
        $success_array['this_month'] = HistoryCamisDPVirtualPatientData::whereNotIn('patient_id', $patient_to_exclude)->whereMonth('created_at', '=', Carbon::now()->month)->where('type', 1)->count();

        $success_array['tab_name'] = 'reviewed_patient';
        $success_array['all_wards']   = Wards::where('status', 1)->pluck('ward_name', 'id')->toArray();
        $success_array['selected_ward_id'] = $request->ward_id;
        $success_array['selected_sort_by'] = $request->sort_by;
        return view('Dashboards.Camis.DeterioratingPatient.Partials.PatientListDataLoad')->with($success_array);

    }


    public function StepdowndPatientDataLoad(Request $request)
    {
        $vitalpac_table = CamisIboxPatientInfoVitalpacView::ReturnTableName();
        $patients_table = CamisIboxWardPatientInformationWithBedDetailsView::ReturnTableName();
        $active_wards = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('id')->toArray();
        $dp_patients = CamisIboxDeterioratingPatient::whereIn('camis_patient_ward_id', $active_wards)->where('type', 5)->pluck('patient_id')->toArray();

        $patient_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn("{$patients_table}.camis_patient_id", $dp_patients)->leftJoin(
            $vitalpac_table,
            function ($join) use ($patients_table, $vitalpac_table) {
                $join->on(
                    DB::raw("{$patients_table}.camis_patient_id COLLATE utf8mb4_general_ci"),
                    '=',
                    DB::raw("{$vitalpac_table}.camis_patient_id COLLATE utf8mb4_general_ci")
                );
            }
        )
        ->select("{$patients_table}.*", "{$vitalpac_table}.totalews")

        ->with([
            'PatientWiseFlags'=>function($q){
                $q->where(function($query){
                    $query->where('patient_flag_name','ibox_patient_flag_stepdown');
                });
            },
            'BoardRoundPatientTasks'=>function($q){
                $q->where('task_category', 6)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->orderBy('id', 'asc');
            },
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory',
            'PatientVitalPacInfo',
            'DPVirtualWardComment'=>function($q){
                $q->orderBy('created_at', 'asc');
            },
            'BoardRoundMedicallyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
            },
            'DPVirtualWardStatus'
        ])->when($request->filled('ward_id'), function ($q) use($request){
            return $q->whereIn('ibox_ward_id', $request->ward_id);
        })->unless($request->filled('ward_id'), function ($q) {
            $q->whereIn('ibox_ward_id', AllWardToIDArray());
        })->when($request->filled('sort_by'), function ($q) use($request,$patients_table,$vitalpac_table){
            if($request->sort_by == 'surname_asc'){
                $q->orderBy("{$patients_table}.camis_patient_surname", 'ASC');
            } elseif($request->sort_by == 'surname_desc'){
                $q->orderBy("{$patients_table}.camis_patient_surname", 'DESC');
            }  elseif($request->sort_by == 'ews_asc'){
            $q->orderBy($vitalpac_table.'.totalews', 'asc');
            } elseif($request->sort_by == 'ews_desc'){
                $q->orderBy($vitalpac_table.'.totalews', 'desc');
            }

        })->where('ibox_bed_type', '=', 'Bed')->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();

        $success_array['patient_data'] = ArrayFilter($patient_query, function($value) use($dp_patients){
            return in_array($value['camis_patient_id'], $dp_patients);
        });


        $patient_to_exclude = CamisIboxWardPatientInformationWithBedDetailsView::where('disabled_on_all_dashboard_except_ward_summary', 1)->whereNotNull('camis_patient_id')->pluck('camis_patient_id')->toArray();

        $all_groups = CamisIboxDeterioratingPatient::whereIn('camis_patient_ward_id', $active_wards)->whereNotIn('patient_id', $patient_to_exclude)->pluck('type', 'patient_id')->toArray();

        $success_array['total_patients'] = count($all_groups);
        $new = 0;
        $reviewed = 0;
        $removed = 0;
        $discharge_to_dp = 0;
        $sd = 0;
        foreach($all_groups as $key => $value){
            if($value == 1){
                $new++;
            } elseif($value == 2){
                $reviewed++;
            } elseif($value == 3){
                $removed++;
            } elseif($value == 4){
                $discharge_to_dp++;
            } elseif($value == 5){
                $sd++;
            }
        }



        $success_array['new_patients'] = $new;
        $success_array['step_down_count'] = $sd;
        $success_array['seen_patients'] = $reviewed + $removed;
        $success_array['not_for_dp'] = $removed;
        $success_array['discharge_dp'] = $discharge_to_dp;
        $success_array['this_month'] = HistoryCamisDPVirtualPatientData::whereNotIn('patient_id', $patient_to_exclude)->whereMonth('created_at', '=', Carbon::now()->month)->where('type', 1)->count();
        $success_array['tab_name'] = 'stepdown_patient';
        $success_array['selected_ward_id'] = $request->ward_id;
        $success_array['selected_sort_by'] = $request->sort_by;
        return view('Dashboards.Camis.DeterioratingPatient.Partials.PatientListDataLoad')->with($success_array);

    }


    public function RemovedPatientDataLoad(Request $request)
    {
        $vitalpac_table = CamisIboxPatientInfoVitalpacView::ReturnTableName();
        $patients_table = CamisIboxWardPatientInformationWithBedDetailsView::ReturnTableName();
        $active_wards = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('id')->toArray();

        $dp_patients = CamisIboxDeterioratingPatient::whereIn('camis_patient_ward_id', $active_wards)->where('type', 3)->pluck('patient_id')->toArray();
        $patient_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn("{$patients_table}.camis_patient_id", $dp_patients)->leftJoin(
            $vitalpac_table,
            function ($join) use ($patients_table, $vitalpac_table) {
                $join->on(
                    DB::raw("{$patients_table}.camis_patient_id COLLATE utf8mb4_general_ci"),
                    '=',
                    DB::raw("{$vitalpac_table}.camis_patient_id COLLATE utf8mb4_general_ci")
                );
            }
        )
        ->select("{$patients_table}.*", "{$vitalpac_table}.totalews")

        ->with([
            'PatientWiseFlags'=>function($q){
                $q->where(function($query){
                    $query->whereIn('patient_flag_name',['ibox_patient_flag_nurse_concern','ibox_patient_flag_covid_dp','ibox_patient_flag_stepdown']);
                });
            },
            'BoardRoundPatientTasks'=>function($q){
                $q->where('task_category', 6)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->orderBy('id', 'asc');
            },
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory',
            'PatientVitalPacInfo',
            'DPVirtualWardComment'=>function($q){
                $q->orderBy('created_at', 'asc');
            },
            'BoardRoundMedicallyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
            },
            'DPVirtualWardStatus'
        ])->when($request->filled('ward_id'), function ($q) use($request){
            return $q->whereIn('ibox_ward_id', $request->ward_id);
        })->unless($request->filled('ward_id'), function ($q) {
            $q->whereIn('ibox_ward_id', AllWardToIDArray());
        })->when($request->filled('sort_by'), function ($q) use($request,$patients_table, $vitalpac_table){
            if($request->sort_by == 'surname_asc'){
                $q->orderBy("{$patients_table}.camis_patient_surname", 'ASC');
            } elseif($request->sort_by == 'surname_desc'){
                $q->orderBy("{$patients_table}.camis_patient_surname", 'DESC');
            }  elseif($request->sort_by == 'ews_asc'){
            $q->orderBy($vitalpac_table.'.totalews', 'asc');
            } elseif($request->sort_by == 'ews_desc'){
                $q->orderBy($vitalpac_table.'.totalews', 'desc');
            }

        })->where('ibox_bed_type', '=', 'Bed')->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();



        $success_array['patient_data'] = ArrayFilter($patient_query, function($value) use($dp_patients){
            return in_array($value['camis_patient_id'], $dp_patients);
        });




        $patient_to_exclude = CamisIboxWardPatientInformationWithBedDetailsView::where('disabled_on_all_dashboard_except_ward_summary', 1)->whereNotNull('camis_patient_id')->pluck('camis_patient_id')->toArray();

        $all_groups = CamisIboxDeterioratingPatient::whereIn('camis_patient_ward_id', $active_wards)->whereNotIn('patient_id', $patient_to_exclude)->pluck('type', 'patient_id')->toArray();

        $success_array['total_patients'] = count($all_groups);
        $new = 0;
        $reviewed = 0;
        $removed = 0;
        $discharge_to_dp = 0;
        $sd = 0;
        foreach($all_groups as $key => $value){
            if($value == 1){
                $new++;
            } elseif($value == 2){
                $reviewed++;
            } elseif($value == 3){
                $removed++;
            } elseif($value == 4){
                $discharge_to_dp++;
            } elseif($value == 5){
                $sd++;
            }
        }



        $success_array['new_patients'] = $new;
        $success_array['step_down_count'] = $sd;
        $success_array['seen_patients'] = $reviewed + $removed;
        $success_array['not_for_dp'] = $removed;
        $success_array['discharge_dp'] = $discharge_to_dp;
        $success_array['this_month'] = HistoryCamisDPVirtualPatientData::whereNotIn('patient_id', $patient_to_exclude)->whereMonth('created_at', '=', Carbon::now()->month)->where('type', 1)->count();
        $success_array['tab_name'] = 'removed_patient';
        $success_array['all_wards']   = Wards::where('status', 1)->pluck('ward_name', 'id')->toArray();
        $success_array['selected_ward_id'] = $request->ward_id;
        $success_array['selected_sort_by'] = $request->sort_by;
        return view('Dashboards.Camis.DeterioratingPatient.Partials.PatientListDataLoad')->with($success_array);

    }
    public function AllPatientsDataLoad(Request $request){
        $vitalpac_table = CamisIboxPatientInfoVitalpacView::ReturnTableName();
        $patients_table = CamisIboxWardPatientInformationWithBedDetailsView::ReturnTableName();
        $active_wards = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('id')->toArray();

        $dp_patients = CamisIboxBoardRoundPatientTasks::whereIn('camis_patient_ward_id', $active_wards)->where('task_category', 6)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->pluck('patient_id')->unique()->toArray();
        $patient_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn("{$patients_table}.camis_patient_id", $dp_patients)->leftJoin(
            $vitalpac_table,
            function ($join) use ($patients_table, $vitalpac_table) {
                $join->on(
                    DB::raw("{$patients_table}.camis_patient_id COLLATE utf8mb4_general_ci"),
                    '=',
                    DB::raw("{$vitalpac_table}.camis_patient_id COLLATE utf8mb4_general_ci")
                );
            }
        )
        ->select("{$patients_table}.*", "{$vitalpac_table}.totalews")

        ->with([
            'PatientWiseFlags'=>function($q){
                $q->where(function($query){
                    $query->whereIn('patient_flag_name',['ibox_patient_flag_nurse_concern','ibox_patient_flag_covid_dp','ibox_patient_flag_stepdown']);
                });
            },
            'BoardRoundPatientTasks'=>function($q){
                $q->where('task_category', 6)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->orderBy('id', 'asc');
            },
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory',
            'PatientVitalPacInfo',
            'DPVirtualWardComment'=>function($q){
                $q->orderBy('created_at', 'asc');
            },
            'BoardRoundMedicallyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
            },
            'DPVirtualWardStatus'
        ])->when($request->filled('ward_id'), function ($q) use($request){
            return $q->whereIn('ibox_ward_id', $request->ward_id);
        })->unless($request->filled('ward_id'), function ($q) {
            $q->whereIn('ibox_ward_id', AllWardToIDArray());
        })->when($request->filled('sort_by'), function ($q) use($request,$patients_table, $vitalpac_table){
            if($request->sort_by == 'surname_asc'){
                $q->orderBy("{$patients_table}.camis_patient_surname", 'ASC');
            } elseif($request->sort_by == 'surname_desc'){
                $q->orderBy("{$patients_table}.camis_patient_surname", 'DESC');
            }  elseif($request->sort_by == 'ews_asc'){
            $q->orderBy($vitalpac_table.'.totalews', 'asc');
            } elseif($request->sort_by == 'ews_desc'){
                $q->orderBy($vitalpac_table.'.totalews', 'desc');
            }

        })->where('ibox_bed_type', '=', 'Bed')->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();

        $success_array['patient_data'] = ArrayFilter($patient_query, function($value) use($dp_patients){
            return in_array($value['camis_patient_id'], $dp_patients);
        });

        $patient_to_exclude = CamisIboxWardPatientInformationWithBedDetailsView::where('disabled_on_all_dashboard_except_ward_summary', 1)->whereNotNull('camis_patient_id')->pluck('camis_patient_id')->toArray();

        $all_groups = CamisIboxDeterioratingPatient::whereIn('camis_patient_ward_id', $active_wards)->whereNotIn('patient_id', $patient_to_exclude)->pluck('type', 'patient_id')->toArray();

        $success_array['total_patients'] = count($all_groups);
        $new = 0;
        $reviewed = 0;
        $removed = 0;
        $discharge_to_dp = 0;
        $sd = 0;
        foreach($all_groups as $key => $value){
            if($value == 1){
                $new++;
            } elseif($value == 2){
                $reviewed++;
            } elseif($value == 3){
                $removed++;
            } elseif($value == 4){
                $discharge_to_dp++;
            } elseif($value == 5){
                $sd++;
            }
        }



        $success_array['new_patients'] = $new;
        $success_array['step_down_count'] = $sd;
        $success_array['seen_patients'] = $reviewed + $removed;
        $success_array['not_for_dp'] = $removed;
        $success_array['discharge_dp'] = $discharge_to_dp;
        $success_array['this_month'] = HistoryCamisDPVirtualPatientData::whereNotIn('patient_id', $patient_to_exclude)->whereMonth('created_at', '=', Carbon::now()->month)->where('type', 1)->count();

        $success_array['tab_name'] = 'all_patient';
        $success_array['all_wards']   = Wards::where('status', 1)->pluck('ward_name', 'id')->toArray();
        $success_array['selected_ward_id'] = $request->ward_id;
        $success_array['selected_sort_by'] = $request->sort_by;
        return view('Dashboards.Camis.DeterioratingPatient.Partials.PatientListDataLoad')->with($success_array);
    }

    public function AllPatients(Request $request){
        $all_wards   = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_name', 'id')->toArray();
        return view('Dashboards.Camis.DeterioratingPatient.AllPatient', compact('all_wards'));
    }


    public function ActionDischargeToWard(Request $request){

        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisDPVirtualPatientData";
        $camis_patient_id                                           = $request->camis_patient_id;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "")
        {
            $gov_text_before_arr                                    = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxDPVirtualWardPatientStatus::updateOrCreate(['patient_id' => $camis_patient_id], ['type' => 4, 'updated_by' => $user_id]);
            $functional_identity                                    = 'DP Virtual Ward Data';

            if ($updated_data->wasRecentlyCreated)
            {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"]))
                {
                    $gov_text_after_arr                             = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Discharged To Ward', $gov_text_after_arr, $functional_identity, 1);
                }
            }
            else
            {

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
                            $gov_text_after_arr                     = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Discharged To Ward', $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["status"]                                    = 1;



            $history_controller                                         = new HistoryController;
            $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPatientFlag";
            $camis_patient_id                                           = $request->camis_patient_id;

            $patient_data = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $camis_patient_id)->with([
                'PatientWiseFlags'=>function($q){
                    $q->where(function($query){
                        $query->whereIn('patient_flag_name',['ibox_patient_flag_nurse_concern','ibox_patient_flag_stepdown','ibox_patient_flag_covid_dp']);
                    });
                }])->first();
            if($patient_data != null && $patient_data->PatientWiseFlags->count() > 0){
                foreach($patient_data->PatientWiseFlags as $patient_flag){
                    $patient_flag_name = $patient_flag->patient_flag_name;
                    $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
                    $success_array["message"]                                   = ErrorOccuredMessage();
                    $success_array["status"]                                    = 0;

                    if ($camis_patient_id != "" && $user_id != "")
                    {
                        $gov_text_before_arr                                    = CamisIboxBoardRoundPatientFlag::where('patient_id', '=', $camis_patient_id)->where('patient_flag_name', $patient_flag_name)->first();

                        if (isset($gov_text_before_arr->id) && $gov_text_before_arr->id != '')
                        {
                            $master_flag_data                                   = BoardRoundFlagList::where('patient_flag_stored_name', '=', $patient_flag_name)->first();

                            if (isset($master_flag_data->id) && $master_flag_data->id != '')
                            {
                                $flag_set_name                                  = $master_flag_data->patient_flag_name;
                            }
                            $gov_text_before_arr->flag_updated_ward = $patient_data->camis_patient_ward_id ?? 0;

                            $gov_text_before_arr->save();


                            CamisIboxBoardRoundPatientFlag::where('id', '=', $gov_text_before_arr->id)->delete();
                            $updated_data                                       = $gov_text_before_arr;
                            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
                            $functional_identity                                = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_patient_flag", "ibox_governance_frontend_functional_names");
                            $success_array["message"]                           = DataRemovalMessage();
                            $gov_text_before                                    = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                                 = array();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before,  $flag_set_name, $gov_text_after_arr, $functional_identity, 3);
                            $success_array["status"]                            = 1;


                        }
                    }
                }
            }


        }



        $patient_to_exclude = CamisIboxWardPatientInformationWithBedDetailsView::where('disabled_on_all_dashboard_except_ward_summary', 1)->whereNotNull('camis_patient_id')->pluck('camis_patient_id')->toArray();

        $all_groups = CamisIboxDeterioratingPatient::whereNotIn('patient_id', $patient_to_exclude)->pluck('type', 'patient_id')->toArray();

        $success_array['total_patients'] = count($all_groups);
        $new = 0;
        $reviewed = 0;
        $removed = 0;
        $discharge_to_dp = 0;
        $sd = 0;
        foreach($all_groups as $key => $value){
            if($value == 1){
                $new++;
            } elseif($value == 2){
                $reviewed++;
            } elseif($value == 3){
                $removed++;
            } elseif($value == 4){
                $discharge_to_dp++;
            } elseif($value == 5){
                $sd++;
            }
        }



        $success_array['new_patients'] = $new;
        $success_array['step_down_count'] = $sd;
        $success_array['seen_patients'] = $reviewed + $removed;
        $success_array['not_for_dp'] = $removed;
        $success_array['discharge_dp'] = $discharge_to_dp;
        $success_array['this_month'] = HistoryCamisDPVirtualPatientData::whereNotIn('patient_id', $patient_to_exclude)->whereMonth('created_at', '=', Carbon::now()->month)->where('type', 1)->count();


        return ReturnArrayAsJsonToScript($success_array);

    }


    public function ActionReviewedPatient(Request $request){

        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisDPVirtualPatientData";
        $camis_patient_id                                           = $request->camis_patient_id;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "")
        {
            $gov_text_before_arr                                    = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxDPVirtualWardPatientStatus::updateOrCreate(['patient_id' => $camis_patient_id], ['type' => 2, 'updated_by' => $user_id]);
            $functional_identity                                    = 'DP Virtual Ward Data';

            if ($updated_data->wasRecentlyCreated)
            {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"]))
                {
                    $gov_text_after_arr                             = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Move To Reviewed Patients', $gov_text_after_arr, $functional_identity, 1);
                }
            }
            else
            {

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
                            $gov_text_after_arr                     = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Move To Reviewed Patients', $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["status"]                                    = 1;

        }
        $patient_to_exclude = CamisIboxWardPatientInformationWithBedDetailsView::where('disabled_on_all_dashboard_except_ward_summary', 1)->whereNotNull('camis_patient_id')->pluck('camis_patient_id')->toArray();

        $all_groups = CamisIboxDeterioratingPatient::whereNotIn('patient_id', $patient_to_exclude)->pluck('type', 'patient_id')->toArray();

        $success_array['total_patients'] = count($all_groups);
        $new = 0;
        $reviewed = 0;
        $removed = 0;
        $discharge_to_dp = 0;
        $sd = 0;
        foreach($all_groups as $key => $value){
            if($value == 1){
                $new++;
            } elseif($value == 2){
                $reviewed++;
            } elseif($value == 3){
                $removed++;
            } elseif($value == 4){
                $discharge_to_dp++;
            } elseif($value == 5){
                $sd++;
            }
        }



        $success_array['new_patients'] = $new;
        $success_array['step_down_count'] = $sd;
        $success_array['seen_patients'] = $reviewed + $removed;
        $success_array['not_for_dp'] = $removed;
        $success_array['discharge_dp'] = $discharge_to_dp;
        $success_array['this_month'] = HistoryCamisDPVirtualPatientData::whereNotIn('patient_id', $patient_to_exclude)->whereMonth('created_at', '=', Carbon::now()->month)->where('type', 1)->count();

        return ReturnArrayAsJsonToScript($success_array);

    }


    public function ActionStepDownPatient(Request $request){

        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisDPVirtualPatientData";
        $camis_patient_id                                           = $request->camis_patient_id;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "")
        {
            $gov_text_before_arr                                    = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxDPVirtualWardPatientStatus::updateOrCreate(['patient_id' => $camis_patient_id], ['type' => 5, 'updated_by' => $user_id]);
            $functional_identity                                    = 'DP Virtual Ward Data';

            if ($updated_data->wasRecentlyCreated)
            {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"]))
                {
                    $gov_text_after_arr                             = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Move To Step Down Patients', $gov_text_after_arr, $functional_identity, 1);
                }
            }
            else
            {

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
                            $gov_text_after_arr                     = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Move To Step Down Patients', $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["status"]                                    = 1;

        }
        $patient_to_exclude = CamisIboxWardPatientInformationWithBedDetailsView::where('disabled_on_all_dashboard_except_ward_summary', 1)->whereNotNull('camis_patient_id')->pluck('camis_patient_id')->toArray();

        $all_groups = CamisIboxDeterioratingPatient::whereNotIn('patient_id', $patient_to_exclude)->pluck('type', 'patient_id')->toArray();

        $success_array['total_patients'] = count($all_groups);
        $new = 0;
        $reviewed = 0;
        $removed = 0;
        $discharge_to_dp = 0;
        $sd = 0;
        foreach($all_groups as $key => $value){
            if($value == 1){
                $new++;
            } elseif($value == 2){
                $reviewed++;
            } elseif($value == 3){
                $removed++;
            } elseif($value == 4){
                $discharge_to_dp++;
            } elseif($value == 5){
                $sd++;
            }
        }



        $success_array['new_patients'] = $new;
        $success_array['step_down_count'] = $sd;
        $success_array['seen_patients'] = $reviewed + $removed;
        $success_array['not_for_dp'] = $removed;
        $success_array['discharge_dp'] = $discharge_to_dp;
        $success_array['this_month'] = HistoryCamisDPVirtualPatientData::whereNotIn('patient_id', $patient_to_exclude)->whereMonth('created_at', '=', Carbon::now()->month)->where('type', 1)->count();

        return ReturnArrayAsJsonToScript($success_array);

    }


    public function ActionRemovedPatient(Request $request){

        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisDPVirtualPatientData";
        $camis_patient_id                                           = $request->camis_patient_id;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "")
        {
            $gov_text_before_arr                                    = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxDPVirtualWardPatientStatus::updateOrCreate(['patient_id' => $camis_patient_id], ['type' => 3, 'updated_by' => $user_id]);
             $functional_identity                                    = 'DP Virtual Ward Data';

            if ($updated_data->wasRecentlyCreated)
            {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"]))
                {
                    $gov_text_after_arr                             = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Move To Removed Patients', $gov_text_after_arr, $functional_identity, 1);
                }
            }
            else
            {

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
                            $gov_text_after_arr                     = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Move To Removed Patients', $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["status"]                                    = 1;

        }
        $patient_to_exclude = CamisIboxWardPatientInformationWithBedDetailsView::where('disabled_on_all_dashboard_except_ward_summary', 1)->whereNotNull('camis_patient_id')->pluck('camis_patient_id')->toArray();

        $all_groups = CamisIboxDeterioratingPatient::whereNotIn('patient_id', $patient_to_exclude)->pluck('type', 'patient_id')->toArray();

        $success_array['total_patients'] = count($all_groups);
        $new = 0;
        $reviewed = 0;
        $removed = 0;
        $discharge_to_dp = 0;
        $sd = 0;
        foreach($all_groups as $key => $value){
            if($value == 1){
                $new++;
            } elseif($value == 2){
                $reviewed++;
            } elseif($value == 3){
                $removed++;
            } elseif($value == 4){
                $discharge_to_dp++;
            } elseif($value == 5){
                $sd++;
            }
        }



        $success_array['new_patients'] = $new;
        $success_array['step_down_count'] = $sd;
        $success_array['seen_patients'] = $reviewed + $removed;
        $success_array['not_for_dp'] = $removed;
        $success_array['discharge_dp'] = $discharge_to_dp;
        $success_array['this_month'] = HistoryCamisDPVirtualPatientData::whereNotIn('patient_id', $patient_to_exclude)->whereMonth('created_at', '=', Carbon::now()->month)->where('type', 1)->count();

        return ReturnArrayAsJsonToScript($success_array);

    }


    public function PatientSearch(Request $request)
    {

        if(CheckDashboardPermission('dp_dashboard_patient_search_view')){
            return view('Dashboards.Camis.DeterioratingPatient.PatientSearch');
        } elseif(CheckDashboardPermission('dp_dashboard_summary_view')){
            return redirect()->route('patient.task.summary');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }

    }

    public function PatientSearchData(Request $request)
    {
        $search_data                                                     = $request->search_data;
        $all_wards                              = Wards::where('status', '=', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();


        $patient_details                                                 = CamisIboxWardPatientInformationWithBedDetailsFullList::where(function($q) use ($search_data) {
                                                                                $q->where('camis_patient_pas_number', 'like', "%{$search_data}%");
                                                                                $q->orWhere('camis_patient_forename', 'like', "%{$search_data}%");
                                                                                $q->orWhere('camis_patient_surname', 'like', "%{$search_data}%");
                                                                                $q->orWhere('camis_patient_id', 'like', "%{$search_data}%");
                                                                        })->with(['BoardRoundPatientTasks'=>function($q){
                                                                            $q->whereIn('task_category', [6,7,8])->orderBy('created_at', 'desc');
                                                                        }])
                                                                        ->withCount(['BoardRoundPatientTasks' => function($q) {
                                                                            $q->whereIn('task_category', [6, 7, 8]);
                                                                        }])
                                                                        ->whereIn('camis_patient_ward',$all_wards)
                                                                        ->where('disabled_on_all_dashboard_except_ward_summary', 0)
                                                                        ->get()->toArray();

        $view                                                           = View::make('Dashboards.Camis.DeterioratingPatient.Partials.PatientSearchDataLoad', compact('patient_details'));
        $sections                                                       = $view->render();

        return $sections;

    }

    public function ExportPatientDpTasks($pat_id)
    {
        $camis_patient_id = $pat_id;
        if($camis_patient_id == !'') {

            $patient_dp_tasks = CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->whereIn('task_category', [6,7,8])
                ->with('PatientInformationWithBedDetails:camis_patient_id,ibox_ward_name')
                ->select([
                    'patient_id',
                    'task_description', 'task_dp_status_order_value','task_estimated_date_for_completion',
                    'task_completed_status','task_created_at',
                    'task_created_ward','task_completed_at',
                    'task_completed_by','task_created_by','task_not_applicable_ward','task_not_applicable_by','task_not_applicable_at','task_not_applicable_status','task_completed_ward','task_extra_data'

                ])
                ->get();

            if(count($patient_dp_tasks) > 0) {
                foreach ($patient_dp_tasks as $key=>$task) {
                    $completed_user_name = Sentinel::findById($task->task_completed_by);
                    $created_user_name = Sentinel::findById($task->task_created_by);
                    $notapplicable_user_name = Sentinel::findById($task->task_not_applicable_by);


                    $data[] = array(
                        ++$key,
                        '#DP '.$task->task_dp_status_order_value.' - '.$task->task_description,
                        $task->task_extra_data,
                        $task->task_completed_status == 1
                            ? 'Completed'
                            : ($task->task_not_applicable_status == 1
                            ? 'Not Applicable'
                            : ''),
                        $task->task_created_at,
                        $created_user_name->username ?? '',
                        $task->WardDetail->ward_name ?? null,
                        $task->task_completed_at ?? '',
                        $completed_user_name->username ?? '',
                        $task->CompletedWard->ward_name ?? null,
                        $notapplicable_user_name->username ?? '',
                        $task->task_not_applicable_at ?? '',
                        $task->NotApplicableWard->ward_name ?? null,

                    );
                }

            } else {
                $data = [];
            }

        }


        $name = $pat_id.'-DpTaskLists';
        $heading =  ["Sl No","Task", "Data Entered", "Task Status", "Created At", "Created By", "Created Ward", "Completed At", "Completed By", "Completed Ward","Not Applicable By","Not Applicable At","Not Applicable Ward"];
        return ExportFunction(collect($data), $heading, $name);
    }



    public function DpCommentsLists($camis_patient_id)
    {
        $comment_list = CamisIboxDPVirtualWardComment::where('patient_id', $camis_patient_id)->orderBy('created_at', 'desc')->get();

        $view                                                           = View::make('Dashboards.Camis.DeterioratingPatient.Partials.Comment', compact('comment_list', 'camis_patient_id'));
        $sections                                                       = $view->render();
        return $sections;
    }
    public function FetchAllComments (Request $request)
    {
        $camis_patient_id = $request->camis_patient_id;
        $comment_list = CamisIboxDPVirtualWardComment::where('patient_id', $request->camis_patient_id)->orderBy('created_at', 'desc')->get();

        $view                                                           = View::make('Dashboards.Camis.DeterioratingPatient.Partials.AllCommentList', compact('comment_list', 'camis_patient_id'));
        $sections                                                       = $view->render();
        return $sections;
    }


    public function SaveDpComment(Request $request)
    {
        $history_controller = new HistoryController();
        $history_modal = 'App\Models\History\HistoryCamisDataDPVirtualWardComment';
        $logged_user_id = Session()->get('LOGGED_USER_ID', '');
        $camis_patient_id = $request->camis_patient_id;
        $comment_text = $request->comments;

        if(isset($logged_user_id) && isset($camis_patient_id)) {

            $updated_data                                           = CamisIboxDPVirtualWardComment::create(['patient_id' => $camis_patient_id, 'additional_comment' => $comment_text, 'updated_by' => $logged_user_id]);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_board_round_dp_virtual_ward_comments", "ibox_governance_frontend_functional_names");

            $updated_data_array                                     = $updated_data->toArray();
            $updated_data_array['created_at']                       = PredefinedStandardDateFormatChange($updated_data_array['created_at']);
            $updated_data_array['updated_at']                       = PredefinedStandardDateFormatChange($updated_data_array['updated_at']);

            if (isset($updated_data_array) && count($updated_data_array) > 0)
            {
                $history_controller->HistoryTableDataInsertFromInsert($updated_data_array, $history_modal);
                $gov_text_before                                    = array();
                if (count($updated_data_array) > 0 && isset($updated_data_array['id']))
                {
                    $gov_text_after_arr                             = CamisIboxDPVirtualWardComment::where('id', '=', $updated_data_array['id'])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id,$gov_text_before,  $comment_text, $gov_text_after_arr, $functional_identity, 1);
                }
            }
        }

        return $this->DpCommentsLists($camis_patient_id);

    }

    public function UpdateDpComment(Request $request)
    {
        $history_controller = new HistoryController();
        $history_modal = 'App\Models\History\HistoryCamisDataDPVirtualWardComment';
        $logged_user_id = Session()->get('LOGGED_USER_ID', '');
        $camis_patient_id = $request->camis_patient_id;
        $comment_id = $request->comment_id ?? null;
        $comment_text = $request->comments;
        $updated_data_array                                         = array();


        if($camis_patient_id != "" & $comment_text != "" && $logged_user_id != "")
        {
            $gov_text_before_arr                                    = CamisIboxDPVirtualWardComment::where('id', '=', $comment_id)->first();
            $updated_data                                           = CamisIboxDPVirtualWardComment::where('id', '=', $comment_id)->update(['additional_comment' => $comment_text, 'patient_id' => $camis_patient_id, 'updated_by' => $logged_user_id]);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_board_round_dp_virtual_ward_comments", "ibox_governance_frontend_functional_names");
            if($updated_data)
            {

                $updated_data_array                               = $gov_text_before_arr->toArray();
                $updated_data_array['created_at']                 = PredefinedStandardDateFormatChange($updated_data_array['created_at']);
                $updated_data_array['updated_at']                 = PredefinedStandardDateFormatChange($updated_data_array['updated_at']);
                $history_controller->HistoryTableDataInsertFromUpdate($updated_data_array, $history_modal);
                $gov_text_before                                  = $updated_data_array;
                $gov_text_after_arr                               = CamisIboxDPVirtualWardComment::where('id', '=', $comment_id)->first();;
                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $comment_text, $gov_text_after_arr, $functional_identity, 2);

            }
        }

        return $this->DpCommentsLists($camis_patient_id);

    }

    public function DeleteDpComment(Request $request)
    {
        $history_controller = new HistoryController();
        $history_modal = 'App\Models\History\HistoryCamisDataDPVirtualWardComment';
        $logged_user_id = Session()->get('LOGGED_USER_ID', '');

        $camis_patient_id = $request->camis_patient_id;
        $comment_id = $request->comment_id ?? null;
        $date_time_now                                               = CurrentDateOnFormat();

        if($camis_patient_id != "" & $logged_user_id != "")
        {
            $gov_text_before_arr                                     = CamisIboxDPVirtualWardComment::where('id', '=', $comment_id)->first();
            CamisIboxDPVirtualWardComment::where('id', '=', $comment_id)->delete();
            $updated_data_array                                      = $gov_text_before_arr->toArray();
            $updated_data_array['created_at']                        = PredefinedStandardDateFormatChange($updated_data_array['created_at']);
            $updated_data_array['updated_at']                        = PredefinedStandardDateFormatChange($updated_data_array['updated_at']);
            $history_controller->HistoryTableDataInsertFromDelete($updated_data_array, $history_modal, 3);
            $functional_identity                                     = RetriveSpecificConstantSettingValues("ibox_board_round_dp_virtual_ward_comments", "ibox_governance_frontend_functional_names");
            $success_array["message"]                                = DataRemovalMessage();
            $gov_text_before                                         = $updated_data_array;
            $gov_text_after_arr                                      = array();
            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_text_before_arr->additional_comment, $gov_text_after_arr, $functional_identity, 3);
            $success_array["updated_date"]                           = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["status"]                                 = 1;
            $success_array['camis_patient_id']                       = $updated_data_array['patient_id'];
            $success_array['last_id']                                = $updated_data_array['id'];
            $success_array['last_comment']                           = $updated_data_array['additional_comment'];
        }

        return $this->DpCommentsLists($camis_patient_id);
    }

    public function DailyPlanHistory(Request $request)
    {
        $success_array["status"]                                =   1;
        $success_array["message"]                               =   'ok';
        $success_array["ward_name"]                             =   $request->patient_ward;
        $patient_id                                             =   $request->patient_id;
        if($patient_id != "") {
            $success_array['governance_data']                   =   GovernanceFrontendCamisOperationLogs::where('gov_patient_id', $patient_id)->latest()->get();
            $view                                               =   View::make('Dashboards.Camis.WardSummary.BoardRoundModals.ShowHistory', compact('success_array'));
            $success_array['sections']                          =   $view->render();
            return $success_array['sections'];
        } else {
            return "";
        }

    }








    public function PatientTaskSummary(Request $request)
    {


        if(CheckDashboardPermission('dp_dashboard_summary_view')){
            return view('Dashboards.Camis.DeterioratingPatient.TaskSummary');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }

    }

    public function TaskSummaryFilter(Request $request)
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

        $success_array['selected_ward'] = $request->ward_id;
        $success_array['all_wards']   = Wards::where('status', 1)->pluck('ward_name', 'id')->toArray();
        $first_day_of_month = Carbon::parse($selected_date)->startOfMonth();
        $last_day_of_month = Carbon::parse($selected_date)->endOfMonth();
        $master_dp_task = DpTasks::where('status', 1)->pluck('auto_populate_task_name')->toArray();

        $ward_ids = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('id')->toArray();
        $created_task = CamisIboxBoardRoundPatientTasks::where('task_category', 6)
        ->when($request->filled('ward_id'), function ($q) use($request){
            return $q->whereIn('task_created_ward', $request->ward_id);
        })->unless($request->filled('ward_id'), function ($q) {
            $q->whereIn('task_created_ward', AllWardToIDArray());
        })
            ->where('task_completed_status', 1)
            ->whereBetween('task_created_at', [$first_day_of_month->startOfDay(), $last_day_of_month->endOfDay()])
            ->get()
            ->toArray();

        $series_of_task = array_reduce($created_task, function ($carry, $item)
        {
            $patient_id = $item['patient_id'];
            $dp_status_order_value = $item['task_dp_status_order_value'];

            if (!isset($carry[$patient_id]))
            {
                $carry[$patient_id] = [];
            }

            if (!isset($carry[$patient_id][$dp_status_order_value]))
            {
                $carry[$patient_id][$dp_status_order_value] = true;
            }

            return $carry;
        }, []);
        $series_of_task = array_sum(array_map('count', $series_of_task));


        $escalation_yes_count = count(ArrayFilter($created_task, function ($item)
        {
            if (
                isset($item['task_extra_data'], $item['task_description'], $item['task_created_at'])
                && !empty($item['task_extra_data'])
            )
            {
                $escalation_json = json_decode($item['task_extra_data'], true);

                if (
                    isset($escalation_json['escalation_status'])
                    && $escalation_json['escalation_status'] == 'Yes'
                    && isset($item['task_description']) && $item['task_description'] == 'Escalation Status'
                    && isset($item['task_created_at'])
                )
                {
                    return true;
                }
            }

            return false;
        }));
        $escalation_no_count = count(ArrayFilter($created_task, function ($item)
        {
            if (
                isset($item['task_extra_data'], $item['task_description'], $item['task_created_at'])
                && !empty($item['task_extra_data'])
            )
            {
                $escalation_json = json_decode($item['task_extra_data'], true);

                if (
                    isset($escalation_json['escalation_status'])
                    && $escalation_json['escalation_status'] != 'Yes'
                    && isset($item['task_description']) && $item['task_description'] == 'Escalation Status'
                    && isset($item['task_created_at'])
                )
                {
                    return true;
                }
            }

            return false;
        }));


        $success_array['escalation_count'] = $series_of_task;









        $success_array['escalation_yes_count'] = $escalation_yes_count;

        $success_array['escalation_no_count'] = $escalation_no_count;


        $startDate = Carbon::create($year, $month, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth();

        $period = CarbonPeriod::create($startDate, $endDate);
        $list_date = [];

        $date_list = [];
        $list_task_time = [];
        foreach ($period as $date) {
            $filtered_tasks = array();
            foreach($created_task as $task_row){

                if(date('Y-m-d', strtotime($task_row['task_created_at'])) == $date->format('Y-m-d') &&
                ($task_row['task_completed_at'] !== null || $task_row['task_not_applicable_at'] !== null)){
                    $filtered_tasks[] = $task_row;
                }

            }
            $date_list[] = $date->format('jS M');
            $patient_ids = array_unique(array_column($filtered_tasks, 'patient_id'));

            $total_time_in_seconds = array();
            $task_count = count($filtered_tasks);
            $total_time_in_seconds_val = 0;
            foreach($master_dp_task as $task_name){
                $total_time_in_seconds[$task_name] = ['time' => 0, 'task' => 0];
            }
            foreach ($filtered_tasks as $task) {
                $task_description = $task['task_description'];
                $estimated_date = strtotime($task['task_created_at']);
                $completed_date = strtotime($task['task_completed_at'] ?? $task['task_not_applicable_at']);
                $total_time_in_seconds[$task_description]['time'] += abs($completed_date - $estimated_date);
                $total_time_in_seconds[$task_description]['task']++;

                $time_taken = abs($completed_date - $estimated_date) / 3600;

                if (!isset($list_task_time[$task_description])) {
                    $list_task_time[$task_description] = ['total_time' => 0, 'task_count' => 0];
                }

                $list_task_time[$task_description]['total_time'] += $time_taken;
                $list_task_time[$task_description]['task_count']++;
            }

            foreach ($total_time_in_seconds as $task_description => $data) {

                $average_time = ($data['task'] > 0) ? round($data['time'] / $data['task'], 2) : 0;
                $total_time_in_seconds[$task_description]['average'] = $average_time;
            }


            $total_time_in_seconds_val = max(array_column($total_time_in_seconds, 'average'));
            $average_time_in_hours = round(($total_time_in_seconds_val > 0) ? ($total_time_in_seconds_val / 3600) : 0, 2);
            $average_time_in_minutes = ceil($average_time_in_hours * 60);

            $list_date[$date->format('Y-m-d')] = [
                'patient_count' => count($patient_ids),
                'average_time_in_hour' => $average_time_in_hours,
                'average_time_in_minutes' => $average_time_in_minutes,
            ];
        }


        foreach ($list_task_time as $task_description => $data) {

            $average_time = ($data['task_count'] > 0) ? round($data['total_time'] / $data['task_count'], 2) : 0;
            $list_task_time[$task_description]['average_time'] = $average_time;
        }

        $patients_count = array_column($list_date, 'patient_count');
        array_unshift($patients_count, 'Number Of Patients');
        $complete_time_in_hours = array_column($list_date, 'average_time_in_hour');
        array_unshift($complete_time_in_hours, 'Completion Time In Hours');

        $success_array['patient_counts'] = $patients_count;
        $success_array['average_times_in_hours'] = $complete_time_in_hours;

        $complete_time_in_minutes = array_column($list_date, 'average_time_in_minutes');
        array_unshift($complete_time_in_minutes, 'Completion Time In Minutes');
        $success_array['average_times_in_minutes'] = $complete_time_in_minutes;

        $success_array['list_all_date'] = array_keys($list_date);


        $task_list_data =array();
        foreach($master_dp_task as $task_name){
            if(!isset($list_task_time[$task_name])){
                $task_list_data[$task_name]  = [
                    "total_time" => 0,
                    "task_count" => 0,
                    "average_time" => 0
                ];
            } else {
                $task_list_data[$task_name] = $list_task_time[$task_name];
            }
        }

        $c3_chart_xaxis = array_keys($task_list_data);
        array_unshift($c3_chart_xaxis, 'x');

        $c3_chart_yaxis = array_column($task_list_data, 'average_time');
        array_unshift($c3_chart_yaxis, 'Hours');
        $success_array['list_task_time_keys'] = array_map(function ($description) {
            //return Str::limit($description, 25);
            return $description;
        }, $c3_chart_xaxis);

        $success_array['list_task_time_averages'] = $c3_chart_yaxis;

        $success_array['date_list'] = $date_list;
        $view = View::make('Dashboards.Camis.DeterioratingPatient.Partials.TaskSummaryDataLoad', compact('success_array'));
        $result = $view->render();
        return $result;


    }
    public function DPSummaryMenu(Request $request)
    {


        if(CheckDashboardPermission('dp_dashboard_dp_summary_view')){
            return view('Dashboards.Camis.DeterioratingPatient.DPSummary');
        } elseif(CheckDashboardPermission('dp_dashboard_patient_search_view')){
            return redirect()->route('patient.search');
        } elseif(CheckDashboardPermission('dp_dashboard_summary_view')){
            return redirect()->route('patient.task.summary');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }

    }
    public function DPSummaryData(Request $request)
    {

        $process_array = array();
        $success_array = array();

        if($request->ward_id != null){
            $process_array['ward_id'] =  $request->ward_id;
        }else{
            $process_array['ward_id'] =  Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('id')->toArray();
        }
        if($request->tab_type != null){
            $process_array['tab_type'] =  $request->tab_type;
        }else{
            $process_array['tab_type'] = 'daily_summary';
        }
        $return_value = match ($process_array['tab_type']) {
            "ward_summary" => 'DPWardSummaryData',
            'daily_summary' => 'DPDailySummaryData',
            'monthly_summary' => 'DPMonthlySummaryData',

        };
        $master_dp_task = DpTasks::where('status', 1)->pluck('auto_populate_task_name')->toArray();

        $all_wards = Wards::whereIn('ward_type_primary', [13,14,16])->where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->select('ward_url_name', 'ward_type_primary', 'ward_short_name')->get()->toArray();
        if($process_array['tab_type'] == 'ward_summary'){
            $current_date = Carbon::now();

            $last_12_months = [];
            for ($i = 0; $i < 12; $i++) {
                $last_12_months[] = $current_date->format('F Y');
                $current_date->subMonth();
            }

            if ($request->filled('selected_date')) {
                $selected_date = $request->selected_date;
            } else {
                $selected_date = date('F Y');
            }

            $carbon_date = Carbon::createFromFormat('d F Y', date('d F Y', strtotime($selected_date)));

            $month = $carbon_date->format('m');
            $year = $carbon_date->format('Y');


            $previous_5_month = [];
            for ($i = 0; $i < 6; $i++) {
                $previous_5_month[] = $carbon_date->copy()->subMonths($i)->format('F Y');
            }

            $previous_5_month = array_reverse($previous_5_month);

            $success_array['previous_5_month'] = $previous_5_month;
            $success_array['month_list'] = $last_12_months;
            $success_array['selected_date'] = $selected_date;


            $start_date = Carbon::createFromFormat('F Y', $previous_5_month[0])->startOfMonth();
            $end_date = Carbon::createFromFormat('F Y', end($previous_5_month))->endOfMonth();

            $data = CamisIboxDPTaskDailySummary::whereIn('ward_id', AllWardToShortNameArray())->select('date','ward_id', 'dp_task_list_completed_count', 'completed_in_tweleve_hr')->whereBetween('date', [$start_date->format('Y-m-01'), $end_date->format('Y-m-t')])
                 ->get()->toArray();


            $ward_wise_task = array_reduce($data, function ($carry, $item) {
                $ward_name = $item['ward_id'];

                $carry[$ward_name][] = $item;

                return $carry;
            }, []);
            ksort($ward_wise_task);
            $ward_summary_data = array();

            foreach($all_wards as $ward_name){
                foreach($previous_5_month as $month_count){
                    $ward_short_name = strtolower($ward_name['ward_short_name']);
                    $ward_summary_data[$ward_name['ward_type_primary']][$ward_short_name][$month_count]['month'] = $month_count;
                    $ward_summary_data[$ward_name['ward_type_primary']][$ward_short_name][$month_count]['created_task'] = 0;
                    $ward_summary_data[$ward_name['ward_type_primary']][$ward_short_name][$month_count]['completed_task'] = 0;
                    $ward_summary_data[$ward_name['ward_type_primary']][$ward_short_name][$month_count]['list_of_complete'] = 0;
                }

            }
            foreach($ward_wise_task as $ward_url => $task_data){
                foreach($all_wards as $ward_name){
                    $ward_short_name = $ward_name['ward_url_name'];

                    foreach($previous_5_month as $month_count){
                        $start_date = date('Y-m-01', strtotime($month_count));
                        $end_date = date('Y-m-t', strtotime($month_count));
                        $filtered_tasks = array_filter($task_data, function ($item) use ($ward_short_name, $start_date, $end_date) {

                             return ($item['ward_id'] == $ward_short_name) && ($item['date'] >= $start_date && $item['date'] <= $end_date);
                        });

                        if(array_sum(array_column($filtered_tasks, "dp_task_list_completed_count")) > 0){
                            $ward_summary_data[$ward_name['ward_type_primary']][$ward_short_name][$month_count]['month'] = $month_count;
                            $ward_summary_data[$ward_name['ward_type_primary']][$ward_short_name][$month_count]['created_task'] = array_sum(array_column($filtered_tasks, "dp_task_list_completed_count"));
                            $ward_summary_data[$ward_name['ward_type_primary']][$ward_short_name][$month_count]['completed_task'] = array_sum(array_column($filtered_tasks, "completed_in_tweleve_hr"));
                            $ward_summary_data[$ward_name['ward_type_primary']][$ward_short_name][$month_count]['list_of_complete'] = array_sum(array_column($filtered_tasks, "completed_in_tweleve_hr"));
                        }

                    }
                }
            }
            $success_array['all_ward_with_name'] = Wards::whereIn('ward_type_primary', [13,14,16])->where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_name', 'ward_url_name')->toArray();
            $ward_type_order = [13, 14, 16];

            $success_array['all_data'] = array_replace(array_flip($ward_type_order), $ward_summary_data);


        } elseif($process_array['tab_type'] == 'daily_summary') {
            if($request->filled('start_date') && $request->filled('end_date')) {
                $from_date = $request->start_date;
                $to_date   = $request->end_date;
            } else {
                $from_date = date('Y-m-01');
                $to_date = date('Y-m-t');
            }
            $wards = Wards::where('status',1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('id')->toArray();

            $ward_ids = $process_array['ward_id'];



            $from_date = Carbon::parse($from_date);
            $to_date = Carbon::parse($to_date);
            $from_date = $from_date->startOfDay();
            $to_date = $to_date->endOfDay();
            $created_task = CamisIboxBoardRoundPatientTasks::where('task_category', 6)

            ->when($request->filled('ward_id'), function ($q) use ($request) {
                $q->whereIn('task_created_ward', $request->ward_id);
            })
            ->unless($request->filled('ward_id'), function ($q) {
                $q->whereIn('task_created_ward', AllWardToIDArray());
            })

            ->whereBetween('task_created_at', [$from_date->startOfDay(), $to_date->endOfDay()])->get()->toArray();
            $period = CarbonPeriod::create($from_date, $to_date);
            $completed_task_list = array_filter($created_task, function ($item)
            {
                if ($item['task_completed_status'] == 1) {
                    return true;
                }
                return false;
            });
            $all_dates = [];
            $escalation_all = [];

            foreach ($period as $date) {
                $formatted_ate = $date->format('Y-m-d');
                $formatted_date_human = $date->format('jS M Y');

                $escalation_all[$formatted_ate] = [
                    'date' => $formatted_date_human,
                    'escalation' => 0,
                    'escalation_yes' => 0,
                    'escalation_no' => 0
                ];


                $date_task = array_filter($completed_task_list, function ($item) use($formatted_ate)
                {
                    if (date('Y-m-d', strtotime($item['task_created_at'])) ==  $formatted_ate ){
                        return true;
                    }
                    return false;
                });


                foreach($master_dp_task as $master_task){
                    $filter_task_by_name = array_filter($date_task, function ($item) use($formatted_ate, $master_task)
                    {
                        if (date('Y-m-d', strtotime($item['task_created_at'])) ==  $formatted_ate && $item['task_description'] == $master_task){
                            return true;
                        }
                        return false;
                    });

                    $all_dates[$formatted_ate]['date'] = $formatted_date_human;
                    $total_time_in_seconds = 0;
                    $task_count = count($filter_task_by_name);

                    foreach ($filter_task_by_name as $filter_task) {
                        $task_description = $filter_task['task_description'];
                        $estimated_date = strtotime($filter_task['task_created_at']);
                        $completed_date = strtotime($filter_task['task_completed_at'] ?? $filter_task['task_not_applicable_at']);
                        $total_time_in_seconds += abs($completed_date - $estimated_date);

                        $time_taken = abs($completed_date - $estimated_date) / 3600;

                        if (!isset($list_task_time[$task_description])) {
                            $list_task_time[$task_description] = ['total_time' => 0, 'task_count' => 0];
                        }

                        $list_task_time[$task_description]['total_time'] += $time_taken;
                        $list_task_time[$task_description]['task_count']++;
                    }



                    $average_time_in_hours = round(($task_count > 0) ? ($total_time_in_seconds / 3600 / $task_count) : 0, 2);
                    $average_time_in_minutes = ceil($average_time_in_hours * 60);


                    $all_dates[$date->format('Y-m-d')][$master_task] = $average_time_in_minutes;

                    $all_dates[$formatted_ate][$formatted_ate] = $formatted_ate;

                }



            }


            foreach ($created_task as $task) {
                $date = Carbon::parse($task['task_created_at']);

                $escalation_all[$date->format('Y-m-d')]['date'] = $date->format('jS M Y');


                if (stripos($task['task_description'], 'escalation status') !== false && date('Y-m-d', strtotime($task['task_created_at'])) == $date->format('Y-m-d')) {
                    $escalation_all[$date->format('Y-m-d')]['escalation']++;
                }
                if (stripos($task['task_description'], 'escalation status') !== false && date('Y-m-d', strtotime($task['task_created_at'])) == $date->format('Y-m-d') && !empty($task['task_extra_data'])) {

                    $escalation_json = json_decode($task['task_extra_data'], true);
                    if(is_array($escalation_json) && isset($escalation_json['escalation_status'])){
                        if(is_array($escalation_json) && strtolower($escalation_json['escalation_status']) == 'yes'){
                            $escalation_all[$date->format('Y-m-d')]['escalation_yes']++;
                        } elseif(is_array($escalation_json) && strtolower($escalation_json['escalation_status']) == 'no'){
                            $escalation_all[$date->format('Y-m-d')]['escalation_no']++;
                        }
                    }

                }



            }
            $success_array['all_dates'] = $all_dates;
            $success_array['escalation_all'] = $escalation_all;
            $success_array['ward_id'] = $process_array['ward_id'];

        }
        $success_array['master_dp_task'] = $master_dp_task;
        $view = View::make('Dashboards.Camis.DeterioratingPatient.Partials.'.$return_value, compact('success_array'));
        $sections = $view->render();
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

    public function FetchDPTaskList(Request $request){
        $success_array = array();
        $camis_common_controller                                                = new CommonCamisController;
        $camis_common_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $request->camis_patient_id);

        return view('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData',compact('success_array'));
    }

}
