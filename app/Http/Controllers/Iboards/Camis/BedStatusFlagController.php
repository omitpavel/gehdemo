<?php


namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Illuminate\Support\Facades\View;
use Toastr;
class BedStatusFlagController extends Controller
{
    public function Index(Request $request)
    {
        if(!CheckDashboardPermission('bed_flag_dashboard_view')){
            Toastr::error('Permission Denied');
            return back();
        }
        $success_array['ward'] = null;
        $success_array['selected_flag_lists'] = null;
        $success_array['flag_lists'] = null;

        $patient_ids = CamisIboxBoardRoundPatientFlag::where('patient_flag_status_value',1)->pluck('patient_id');
        $flag_lists = BoardRoundFlagList::select('patient_flag_name','patient_flag_stored_name')->orderBy('patient_flag_name', 'ASC')->get();

        $success_array['patient_id'] = $patient_ids;
        $success_array['flag_lists'] = $flag_lists;
        if($request->filled('ward_option_tab2')){
            $success_array['ward']                        = $request->ward_option_tab2;
        } else {
            $success_array['ward']                        = AllWardToIDArray();
        }
        $this->PageDataLoad($process_array, $success_array);
        $success_array["page_sub_title"]    = date('D jS F, H:i');

        return view('Dashboards.Camis.BedStatusFlag.Index', compact('success_array'));
    }

    public function PageDataLoad(&$process_array, &$success_array)
    {
        $ward = $success_array['ward'];
        $common_controller                                              = new CommonController;
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);

        $ward_lists = Wards::orderBy('ward_name', 'ASC')->where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->get(['ward_name','ward_short_name'])->toArray();
        $flag_lists = BoardRoundFlagList::select('patient_flag_name','patient_flag_stored_name')->orderBy('patient_flag_name', 'ASC')->get();

        $selected_flag_lists = $success_array['selected_flag_lists'] ?  $success_array['selected_flag_lists'] : $flag_lists;

        $sel_fl_text                    =   "";
        $sel_fl_arr                     =   [];
        if(!empty($selected_flag_lists))
        {
            foreach ($selected_flag_lists as $flg_nam)
            {
                $flag_text_value= explode("ibox_patient_flag_", $flg_nam->patient_flag_stored_name);
                if (isset($flag_text_value[1]))
                {
                    if ($flag_text_value[1] != "")
                    {
                        $sel_fl_arr[] = $flag_text_value[1];
                    }
                }
            }
            $sel_fl_text                               = implode(",",$sel_fl_arr);
        }

        $flag_data                                     =   array();
        $i                                             =   0;
        foreach ($flag_lists as $data)
        {
            $flag_data[$i]['patient_flag_name']        = $data->patient_flag_name;
            $flag_data[$i]['patient_flag_stored_name'] = $data->patient_flag_stored_name;
            $flag_data[$i]['only_flag_name']           = substr($data->patient_flag_stored_name, strpos($data->patient_flag_stored_name, "ibox_patient_flag_") + 18);;
            $i++;
        }

        $flag_set_dt_tab2                              =   $sel_fl_text;
        $flag_selected_array_tab2                      =   explode(",",$flag_set_dt_tab2);

        $ward_lists = Wards::orderBy('ward_name', 'ASC')->pluck('ward_name', 'id')->toArray();


        $patient_ids = $success_array['patient_id'];

        $now = date('Y-m-d');
        $query = CamisIboxWardPatientInformationWithBedDetailsView::with(['PatientWiseFlags' => function ($q) {
            $q->select('patient_id');
        }, 'BoardRoundMedicallyFitData',
        'FrailtyPosition.FrailtyPosition.bedGroup','PatientPosition.SdecPosition.bedGroup'])
            ->where('camis_patient_discharge_date', null)
            ->select(
                'ibox_ward_id',
                'camis_patient_id',
                'camis_patient_ward',
                'camis_patient_id as patient_id',
                'camis_patient_pas_number as pass_number',
                'camis_patient_admission_date',
                'camis_patient_age',
                'camis_patient_sex as sex',
                'camis_patient_discharge_date',
                'camis_patient_medical_fit_date as medically_fit',
                'camis_consultant_name as con',
                'camis_consultant_code_group as con_speciality',
                'ibox_ward_name as ward_name',
                'ibox_ward_short_name as ward_short_name',
                'camis_patient_name as name',
                'ibox_actual_bed_full_name as bed_actual_name',
                'ibox_bed_no as bed_no',
                'ibox_bed_group_id as bed_group_id',
                'ibox_bed_group_number as bed_group_number',
                'ibox_bed_group_name as bed_group_name',
                'camis_consultant_code_description',
                'camis_consultant_specialty'
            )
            ->where('disabled_on_all_dashboard_except_ward_summary', '!=', 1)
            ->withCount('PatientWiseFlags');
                $query->whereIn('camis_patient_ward_id', $success_array['ward']);


        $all_patients = $query->get();
        $patient_ids_array = is_array($patient_ids) ? $patient_ids : $patient_ids->toArray();
        $bed_status_flag_patient = $all_patients->filter(function ($patient) use ($patient_ids_array) {
            return in_array($patient->patient_id, $patient_ids_array);
        });

        $patient_flag_count                           = 0;
        $patient_count                                = $bed_status_flag_patient->count();
        $patient_los_count                            = 0;
        $patient_age_count                            = 0;
        $bed_flag_data_processed_tab2                 =   array();

        foreach($bed_status_flag_patient as $patient)
        {
            $ward_id = $patient->ibox_ward_id;
            $bed_flag_data_processed_tab2[$ward_lists[$ward_id]][] = $patient;
            $patient_flag_count                       = $patient_flag_count + $patient->patient_wise_flags_count;
            $patient_los_count                        = $patient_los_count + NumberOfDaysBetweenTwoDates($patient->camis_patient_admission_date, $now);
            $patient_age_count                        = $patient_age_count + $patient->camis_patient_age;
        }

        if($patient_count !=0) {
            $success_array['avg_age_patient']         = round($patient_age_count/$patient_count);
            $success_array['avg_los_patient']         = round($patient_los_count/$patient_count);
            $success_array['avg_flag_patient']        = round($patient_flag_count/$patient_count);
        }


        $success_array['patient_count']               = $patient_count;
        $success_array['ward_lists']                  = $ward_lists;
        $success_array['flag_lists']                  = $flag_data;
        $success_array['patient_lists']               = $bed_flag_data_processed_tab2;
        $success_array["flag_selected_array_tab2"]    = $flag_selected_array_tab2;
    }

    public function BedStatusFlagFilter(Request $request)
    {





        $patient_ids                                  = CamisIboxBoardRoundPatientFlag::when($request->filled('flag_sel_tab2'), function ($q) use($request) {

            return $q->whereIn('patient_flag_name', explode(",", $request->flag_sel_tab2));
        })->pluck('patient_id');
        $flag_lists                                   = BoardRoundFlagList::when($request->filled('flag_sel_tab2'), function ($q) use($request) {

            return $q->whereIn('patient_flag_stored_name', explode(",", $request->flag_sel_tab2));
        })->select('patient_flag_name','patient_flag_stored_name')->orderBy('patient_flag_name', 'ASC')->get();
        $success_array['selected_flag_lists']         = $flag_lists;
        $success_array['patient_id']                  = $patient_ids;


        if($request->filled('ward_option_tab2')){
            $success_array['ward']                        = $request->ward_option_tab2;
        } else {
            $success_array['ward']                        = AllWardToIDArray();
        }
        $this->PageDataLoad($process_array, $success_array);
        $view                                         = View::make('Dashboards.Camis.BedStatusFlag.IndexDataLoad', compact('success_array'));
        $sections                                     = $view->render();
        return $sections;
    }
}
