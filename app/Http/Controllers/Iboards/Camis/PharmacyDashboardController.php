<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Controller;

use App\Models\History\HistoryCamisDataPhamacyScreened;
use App\Models\History\HistoryCamisIboxBoardRoundPharmacyData;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientTasks;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPharmacyComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPharmacyData;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPharmacyScreened;
use App\Models\Iboards\Camis\Master\TaskGroup;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\View;
use function Symfony\Component\Mime\Header\all;

class PharmacyDashboardController extends Controller
{

    public function IndexRefreshDataLoad( Request $request)
    {
        $process_array                                                  = array();
        $success_array                                                  = array();

        if ($request->drug_history_type != null)
        {
            $process_array['drug_history_type']                             = $request->drug_history_type;
        }else{
            $process_array['drug_history_type']                             = 'all';
        }
        if ($request->antibiotic_type != null)
        {
            $process_array['antibiotic_type']                             = $request->antibiotic_type;
        }else{
            $process_array['antibiotic_type']                             = 'all_patient';
        }
        if ($request->screened_status != null)
        {
            $process_array['screened_status']                             = $request->screened_status;
        }else{
            $process_array['screened_status']                             = 'all_patient';
        }



        if ($request->ward_id != null)
        {
            $process_array['ward_id']                                   = $request->ward_id;

        }else{
            $process_array['ward_id']                                   = 'all';
        }

        if($request->tab_type != null){
            $process_array['tab_type']                                   = $request->tab_type;
        } else {
            $process_array['tab_type']                                   = 'pharmacy_list';
        }


        $this->PageDataLoad($process_array, $success_array);


        $return_value = match ($process_array['tab_type']) {
            "pharmacy_list" => 'PharmacyListDataLoad',
            'pharmacy_screened' => 'PharmacyScreenedDataLoad',
        };

        $view                                                           = View::make('Dashboards.Camis.PharmacyDashboard.'.$return_value, compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }
    public function PageDataLoad(&$process_array, &$success_array)
    {

        $success_array                                  = array();
        $success_array["script_error_message"]          = ErrorOccuredMessage();







        $wards = WardList();
        if ($process_array['ward_id'] == 'all'){
            $ward_id = AllWardToIDArray();
        }else{
            $ward_id = $process_array['ward_id'];
        }


        if($process_array['tab_type'] == 'pharmacy_list'){
            if($process_array['drug_history_type'] == 'all'){
                $drug_history_type = [0,1,2,3];
            }else{
                $drug_history_type = [(int)$process_array['drug_history_type']];
            }
            $patient_id_base_query = CamisIboxBoardRoundPharmacyData::whereIn('pharmacy_drug_history',$drug_history_type);

            $patient_id_base_query = clone $patient_id_base_query;
            if ($process_array['antibiotic_type'] == 'all_antibiotic'){
                $patient_id = $patient_id_base_query
                    ->where(function ($query) {
                        $query->whereNotNull('pharmacy_antibiotic_iv_date')
                            ->orWhereNotNull('pharmacy_antibiotic_oral_date');
                    })
                    ->pluck('patient_id')
                    ->toArray();
            }elseif ($process_array['antibiotic_type'] == 'iv'){
                $patient_id  =   $patient_id_base_query
                    ->whereNotNull('pharmacy_antibiotic_iv_date')
                    ->pluck('patient_id')
                    ->toArray();
            }
            elseif ($process_array['antibiotic_type'] == 'oral'){
                $patient_id  =   $patient_id_base_query
                    ->whereNotNull('pharmacy_antibiotic_oral_date')
                    ->pluck('patient_id')
                    ->toArray();
            }else{
                $patient_id =  $patient_id_base_query->pluck('patient_id')
                    ->toArray();
            }


            $patient_array_base_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_ward_id',$ward_id)->with([
                'BoardRoundPatientTasks'=>function($q){
                    $q->with('PatientTaskGroup')->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->orderBy('created_at', 'desc');
                },'BoardRoundPatientTasks.PatientTaskGroup',
                'BoardRoundPatientTasks.PatientTaskCategory',
                'BoardRoundPharmacyData',
                'BoardRoundPharmacyComment'=>function($q){
                    $q->orderBy('created_at', 'desc');
                },
            ])
            ->whereNotNull('camis_patient_id')->where('ibox_bed_type', '=', 'Bed')->where('disabled_on_all_dashboard_except_ward_summary', 0);
            $patient_array_base_query = clone $patient_array_base_query;
            if(($process_array['antibiotic_type'] != 'all_patient')){
                $patient_array =   $patient_array_base_query->whereIn('camis_patient_id', $patient_id)->get()->toArray();
            }elseif(($process_array['drug_history_type'] != 'all') && ($process_array['antibiotic_type'] == 'all_patient')){
                $patient_array =   $patient_array_base_query->whereIn('camis_patient_id', $patient_id)->get()->toArray();
            }else{

                $patient_array =   $patient_array_base_query->get()->toArray();
            }

        }elseif ($process_array['tab_type'] == 'pharmacy_screened'){

            $patient_id = CamisIboxBoardRoundPharmacyScreened::whereIn('ward_id',$ward_id)->pluck('patient_id')->toArray();
            $patient_screened_base_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_ward_id',$ward_id)->with([
                'PharmacyScreenedData',

            ])

                ->whereNotNull('camis_patient_id')->where('ibox_bed_type', '=', 'Bed')->where('disabled_on_all_dashboard_except_ward_summary', 0);



            $patient_array  = clone $patient_screened_base_query;
            $total_screened  = clone $patient_screened_base_query;
            $total_not_screened  = clone $patient_screened_base_query;
            $total_screened_patient =  $total_screened->whereIn('camis_patient_id', $patient_id)->count();
            $success_array['total_screened_patient']      = $total_screened_patient;

            $total_not_screened = $total_not_screened->whereNotIn('camis_patient_id', $patient_id)->count();

            $success_array['total_not_screened']      = $total_not_screened;

            $success_array['total_screened_not_screened']      = $total_not_screened + $total_screened_patient;

            if($process_array['screened_status'] == 'all_patient'){
                $patient_array = $patient_array->get()->toArray();
            }else{
                if($process_array['screened_status'] == '2'){
                    $patient_array = $patient_array->whereIn('camis_patient_id', $patient_id)->get()->toArray();
                }elseif ($process_array['screened_status'] == '1'){
                    $patient_array = $patient_array->whereNotIn('camis_patient_id', $patient_id)->get()->toArray();
                }

            }

        }


        $ward_wise_patients = array_reduce($patient_array, function ($carry, $item) {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($ward_wise_patients);

        $pharmacyTaskGroup = TaskGroup::where('task_group_name', 'pharmacy')->first();

        $pharmacy_task_group_id = $pharmacyTaskGroup->id ?? 46;
        $success_array['pharmacy_task_group'] = $pharmacy_task_group_id;
        $success_array['total_patients']      = $patient_array;
        $success_array['patient_details']     = $ward_wise_patients;
        $success_array['drug_history_type']   = $process_array['drug_history_type'];
        $success_array['antibiotic_type']     = $process_array['antibiotic_type'];
        $success_array['screened_status']     = $process_array['screened_status'];

        $success_array['tab_type']            = $process_array['tab_type'];

        return $success_array;

    }


    public function Index()
    {
        if(CheckDashboardPermission('pharmacy_dashboard_')){
            return view('Dashboards.Camis.PharmacyDashboard.index');
        } elseif(CheckDashboardPermission('flow_dashboard_red_bed_view') || CheckDashboardPermission('flow_dashboard_redbed_performance_view')){
            return redirect()->route('red.bed.dashboard');
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

    public function AllComment(Request $request){
        if(CheckSpecificPermission('pharmacy_all_comment_view')){
            $all_comments = CamisIboxBoardRoundPharmacyComment::where('patient_id',$request->patient_id)->latest()->get()->toArray();
            return view('Dashboards.Camis.PharmacyDashboard.Partial.AllComments',compact('all_comments'));
        }else{
            Toastr::error('Permission Denied');
            return back();
        }


    }

    public function PharmacyHistory(Request $request)
    {
        if(CheckSpecificPermission('pharmacy_history_view')){
            $base_query =  HistoryCamisIboxBoardRoundPharmacyData::where('patient_id', $request->patient_id);

            $iv_history_data_query = $base_query
                ->whereNotNull('pharmacy_antibiotic_iv_date')
                ->orderBy('pharmacy_antibiotic_iv_date', 'asc')
                ->select('pharmacy_antibiotic_iv_date', 'pharmacy_antibiotic_iv_status')
                ->get()
                ->toArray();


            $iv_history_list = [];
            $start_date = null;
            $previous_date = null;

            foreach ($iv_history_data_query as $entry) {
                $date = $entry['pharmacy_antibiotic_iv_date'];
                $status = $entry['pharmacy_antibiotic_iv_status'];

                if ($status == 1) {
                    $start_date = $date;
                } elseif ($status == 0 && $start_date !== null) {
                    $iv_history_list[] = ['start_date' => $start_date, 'end_date' => $date];
                    $start_date = null;
                }

            }

            if ($start_date !== null) {
                $iv_history_list[] = ['start_date' => $start_date, 'end_date' => null];
            }




            $oral_history_data_query = $base_query
                ->orderBy('pharmacy_antibiotic_oral_date', 'asc')
                ->whereNotNull('pharmacy_antibiotic_oral_date')
                ->select('pharmacy_antibiotic_oral_date', 'pharmacy_antibiotic_oral_status')
                ->get()
                ->toArray();

            $oral_history_list = [];

            $start_date = null;
            foreach ($oral_history_data_query as $entry) {
                $date = $entry['pharmacy_antibiotic_oral_date'];
                $status = $entry['pharmacy_antibiotic_oral_status'];

                if ($status == 1) {
                    $start_date = $date;
                } elseif ($status == 0 && $start_date !== null) {
                    $oral_history_list[] = ['start_date' => $start_date, 'end_date' => $date];
                    $start_date = null;
                }
            }

            if ($start_date !== null) {
                $oral_history_list[] = ['start_date' => $start_date, 'end_date' => null];
            }

            return view('Dashboards.Camis.PharmacyDashboard.Partial.PharmacyHistory',compact('iv_history_list', 'oral_history_list'));
        }else{
            Toastr::error('Permission Denied');
            return back();
        }


    }

    public function AllScreenedHistory(Request $request)
    {
        if(CheckSpecificPermission('pharmacy_screened_history_view')){
            $all_screenedHistory = HistoryCamisDataPhamacyScreened::where('patient_id',$request->patient_id)->with('Ward')->get()->toArray();
            return view('Dashboards.Camis.PharmacyDashboard.Partial.AllScreenedHistoryData',compact('all_screenedHistory'));
        }else{
            Toastr::error('Permission Denied');
            return back();
        }

    }


    public function TaskByGroup(Request $request)
    {

        $pharmacyTaskGroup = TaskGroup::where('task_group_name', 'pharmacy')->first();

        $pharmacy_task_group_id = $pharmacyTaskGroup->id ?? 46;


        $edit_category = 2;
        $permision = '';
        if($request->task_type == 'pharmacy_task'){
            $task_list = CamisIboxBoardRoundPatientTasks::where('patient_id',$request->patient_id)->where('task_group',$pharmacy_task_group_id)->where('task_completed_status',0)->where('task_not_applicable_status',0)
                ->with(['PatientTaskGroup','PatientTaskCategory'])->orderBy('created_at', 'desc')->get()->toArray();
        }else{
            $task_list = CamisIboxBoardRoundPatientTasks::where('patient_id',$request->patient_id)->where('task_completed_status',0)->where('task_not_applicable_status',0)->with(['PatientTaskGroup','PatientTaskCategory'])->orderBy('created_at', 'desc')->get()->toArray();
        }


        return view('Dashboards.Camis.PharmacyDashboard.Partial.TaskData', compact('task_list', 'edit_category','permision'));
    }







}
