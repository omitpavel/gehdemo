<?php

namespace App\Http\Controllers\Iboards\Symphony;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonSymphonyController;
use App\Http\Controllers\Controller;
use App\Models\Iboards\Symphony\Data\SymphonyAttendance;
use App\Models\Iboards\Symphony\View\SymphonyAttendanceView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class ReferralToSpecialityController extends Controller
{
    public function Index()
    {
        $common_controller                  = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;
        $process_array                      = array();
        $success_array                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);

        $process_array["start_date_week_summary"]   = CurrentDateOnFormat();
        $process_array["end_date_week_summary"]     = "";
        CalculateStartEndDateAccordingSelection($process_array["start_date_week_summary"], $process_array["end_date_week_summary"], "week");
        $referral_records_array_week_summary        = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($process_array["start_date_week_summary"], $process_array["end_date_week_summary"]))->where('symphony_specialty','<>','')->whereIn('symphony_atd_type', $process_array["ibox_symphony_main_patient_category"])->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
        $success_array["data_summary"]              = $this->ReferralDataProcessSplitUp($referral_records_array_week_summary, $process_array);
        $success_array["filter_value_selected"]     = date("Y-m-d",strtotime($process_array["start_date_week_summary"]));
        $success_array["filter_array"]              = LastNumberOfWeeksArrayForDropdownOperation(CurrentDateOnFormat(), 12);
        $success_array["filter_mode"]               = 1;
        $success_array["page_sub_title"]                = date('l jS F H:i');
        return view('Dashboards.Symphony.ReferralToSpeciality.Index', compact('success_array'));
    }

    public function ContentDataLoad(Request $request)
    {
        $common_controller = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;
        $process_array = array();
        $success_array = array();

        $filter_value = $request->filter_value;
        $filter_mode = $request->filter_mode;

        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);

        if ($filter_mode == 1 || $filter_mode == 2 || $filter_mode == 3)
        {
            if ($filter_mode == 1)
            {
                if(CheckSpecificPermission('referral_to_speciality_week_view')){
                    $process_array["start_date_week_summary"]   = ($filter_value != "") ? $filter_value : CurrentDateOnFormat();
                    $process_array["end_date_week_summary"]     = "";
                    CalculateStartEndDateAccordingSelection($process_array["start_date_week_summary"], $process_array["end_date_week_summary"], "week");
                    $referral_records_array_week_summary        = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($process_array["start_date_week_summary"], $process_array["end_date_week_summary"]))->where('symphony_specialty','<>','')->whereIn('symphony_atd_type', $process_array["ibox_symphony_main_patient_category"])->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
                    $success_array["data_summary"]              = $this->ReferralDataProcessSplitUp($referral_records_array_week_summary, $process_array);
                    $success_array["filter_value_selected"]     = date("Y-m-d",strtotime($process_array["start_date_week_summary"]));
                    $success_array["filter_array"]              = LastNumberOfWeeksArrayForDropdownOperation(CurrentDateOnFormat(), 12);
                } else {
                    return PermissionDenied();
                }
            }

            if ($filter_mode == 2)
            {
                if(CheckSpecificPermission('referral_to_speciality_month_view')){
                    $process_array["start_date_month_summary"]  = ($filter_value != "") ? $filter_value : CurrentDateOnFormat();
                    $process_array["end_date_month_summary"]    = "";
                    CalculateStartEndDateAccordingSelection($process_array["start_date_month_summary"], $process_array["end_date_month_summary"], "month");
                    $referral_records_array_month_summary       = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($process_array["start_date_month_summary"], $process_array["end_date_month_summary"]))->where('symphony_specialty','<>','')->whereIn('symphony_atd_type', $process_array["ibox_symphony_main_patient_category"])->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
                    $success_array["data_summary"]              = $this->ReferralDataProcessSplitUp($referral_records_array_month_summary, $process_array);
                    $success_array["filter_value_selected"]     = date("Y-m-d",strtotime($process_array["start_date_month_summary"]));
                    $success_array["filter_array"]              = LastNumberOfMonthsArrayForDropdownOperation(CurrentDateOnFormat(), 12);
                } else {
                    return PermissionDenied();
                }
            }
            if ($filter_mode == 3)
            {
                if(CheckSpecificPermission('referral_to_speciality_last_1000_view')){
                    $process_array["start_date_last_1000"]  = CurrentDateOnFormat();
                    $process_array["end_date_last_1000"]    = "";
                    CalculateStartEndDateAccordingSelection($process_array["start_date_last_1000"], $process_array["end_date_last_1000"], "last 1000");
                    $referral_records_array_last_1000           = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($process_array["start_date_last_1000"], $process_array["end_date_last_1000"]))->where('symphony_specialty','<>','')->whereIn('symphony_atd_type', $process_array["ibox_symphony_main_patient_category"])->orderBy('symphony_registration_date_time', 'DESC')->limit(1000)->get()->toArray();
                    $success_array["data_summary"]     = $this->ReferralDataProcessSplitUp($referral_records_array_last_1000, $process_array);
                    $success_array["filter_value_selected"]     = "";
                    $success_array["filter_array"]              = array();
                } else {
                    return PermissionDenied();
                }
            }
            $success_array["filter_mode"]                   = $filter_mode;
            $view                                           = View::make('Dashboards.Symphony.ReferralToSpeciality.IndexDataLoadTabContent', compact('success_array'));
            $sections                                       = $view->render();
            return $sections;
        }
        else
        {
            return false;
        }
    }
    public function ReferralDataProcessSplitUp($data_array_process, &$process_array)
    {
        $common_symphony_controller = new CommonSymphonyController;
        $return_array = array();
        $ambulance_walkin_arrival_array = $common_symphony_controller->AmbulanceWalkinArrayProcess($data_array_process);
        $overall_data_values_with_speciality = $this->ReferralSpecialityDataProcessBySpeciality($data_array_process, $data_array_process, $process_array);
        $ambulance_data_values_with_speciality = $this->ReferralSpecialityDataProcessBySpeciality($data_array_process, $ambulance_walkin_arrival_array["ambulance_arrival"], $process_array);
        $walkin_data_values_with_speciality = $this->ReferralSpecialityDataProcessBySpeciality($data_array_process, $ambulance_walkin_arrival_array["walkin_arrival"], $process_array);
        MultiArraySortCustom($overall_data_values_with_speciality, "symphony_specialty", "asc");
        MultiArraySortCustom($ambulance_data_values_with_speciality, "symphony_specialty", "asc");
        MultiArraySortCustom($walkin_data_values_with_speciality, "symphony_specialty", "asc");
        $return_array["overall_data_values_with_speciality"] = $overall_data_values_with_speciality;
        $return_array["ambulance_data_values_with_speciality"] = $ambulance_data_values_with_speciality;
        $return_array["walkin_data_values_with_speciality"] = $walkin_data_values_with_speciality;
        return $return_array;
    }

    public function ReferralSpecialityDataProcessBySpeciality($overall_array_process, $data_array_process, &$process_array)
    {
        $speciality_data_array = array();
        $data_values_with_speciality = array();

        if (CheckCountArrayToProcess($overall_array_process))
        {
            foreach ($overall_array_process as $row)
            {
                if (isset($row["symphony_specialty"]))
                {
                    if ($row["symphony_specialty"] != "")
                    {
                        $speciality_data_array[$row["symphony_specialty"]][] = array();
                    }
                }
            }
        }

        if (CheckCountArrayToProcess($data_array_process))
        {
            foreach ($data_array_process as $row)
            {
                if (isset($row["symphony_specialty"]))
                {
                    if ($row["symphony_specialty"] != "")
                    {
                        $speciality_data_array[$row["symphony_specialty"]][] = $row;
                    }
                }
            }
        }
        
        if (isset($speciality_data_array))
        {
            if (is_array($speciality_data_array))
            {
                if (count($speciality_data_array) > 0)
                {
                    foreach ($speciality_data_array as $spec => $row)
                    {
                        $data_values_with_speciality[$spec]["symphony_specialty"] = $spec;
                        $this->CalculateCountOfBreachedAdmittedDischarged($row, $data_values_with_speciality, $spec, $process_array);
                        $this->CalculateBoxPlotValuesOfSpeciality($row, $data_values_with_speciality, $spec, $process_array);
                    }
                }
            }
        }
        return $data_values_with_speciality;
    }
    public function CalculateCountOfBreachedAdmittedDischarged($data_array_process, &$data_values_with_speciality, $speciality, &$process_array)
    {
        $common_symphony_controller = new CommonSymphonyController;
        $admitted_discharge_breach_array =  $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($data_array_process, $process_array);
        $data_values_with_speciality[$speciality]["total"] = count($data_array_process);
        $data_values_with_speciality[$speciality]["breached"] = count($admitted_discharge_breach_array["breached_patients"]);
        $data_values_with_speciality[$speciality]["admitted"] = count($admitted_discharge_breach_array["admitted_patients"]);
        $data_values_with_speciality[$speciality]["discharged"] = count($admitted_discharge_breach_array["discharged_patients"]);
    }
    public function CalculateBoxPlotValuesOfSpeciality($data_array_process, &$data_values_with_speciality, $speciality)
    {
        $common_symphony_controller = new CommonSymphonyController;
        $common_symphony_controller->BoxPlotValueSetFromArray($data_values_with_speciality, $data_array_process, $speciality, "symphony_registration_date_time", "symphony_discharge_date");
    }
}
