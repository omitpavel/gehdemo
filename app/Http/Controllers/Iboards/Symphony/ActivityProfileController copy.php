<?php

namespace App\Http\Controllers\Iboards\Symphony;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Governance\GovernanceController;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonSymphonyController;
use App\Models\Iboards\Symphony\Data\SymphonyAttendance;
use App\Models\Iboards\Symphony\View\SymphonyAttendanceView;
use App\Models\Iboards\Symphony\Data\SymphonyBreachReasonUserUpdate;
use App\Models\Iboards\Symphony\Master\BreachReason;
use Illuminate\Support\Facades\View;
use App\Models\Common\User;
use Illuminate\Support\Facades\DB;
use Toastr;
class ActivityProfileController extends Controller
{
    public function Index(Request $request)
    {
        if(!CheckDashboardPermission('activity_profile_view')){
            Toastr::error('Permission Denied');
            return back();
        }
        $common_controller                  = new CommonController;
        $common_symphony_controller         = new CommonSymphonyController;
        $process_array                      = array();
        $success_array                      = array();
        $success_array["page_sub_title"]    = date('l jS F H:i');
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);
        return view('Dashboards.Symphony.ActivityProfile.Index', compact('success_array'));
    }
    public function ContentDataLoad(Request $request)
    {


        $process_array                      = array();
        $success_array                      = array();
        //$filter_value = '2023-06-01';
        $filter_value_start                 = $request->filter_value_start;
        $filter_value_end                   = $request->filter_value_end;
        $process_array["start_date"]        = ($filter_value_start != "") ? date('Y-m-d 00:00:00', strtotime($filter_value_start)) : CurrentDateOnFormat();
        $process_array["end_date"]        = ($filter_value_end != "") ? date('Y-m-d 23:59:59', strtotime($filter_value_end)) : CurrentDateOnFormat();


        CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "day");
        $this->PageDataLoad($process_array, $success_array);
        $view                               = View::make('Dashboards.Symphony.ActivityProfile.IndexDataLoad', compact('success_array'));
        $sections                           = $view->render();
        return $sections;
    }




    public function PageDataLoad(&$process_array, &$success_array)
    {
        $common_controller                                          = new CommonController;
        $common_symphony_controller                                 = new CommonSymphonyController;
        $table_symphony_attendence_etl_db_name                      = SymphonyAttendance::ReturnDatabaseName();

        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);


        $all_type_attendance_on_specific_dates_array                = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($process_array["start_date"], $process_array["end_date"]))->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();


        $symphony_ed_activity_hourly_summary                        = DB::select("CALL $table_symphony_attendence_etl_db_name.sp_symphony_ed_activity_hourly_summary('" . $process_array['start_date'] . "','" . $process_array["end_date"] . "')");

        $process_array["symphony_ed_activity_hourly_summary"]       = ReturnObjectMultiArrayAsSequentialArray($symphony_ed_activity_hourly_summary);


        $success_array['date_filter_tab_1_date_to_show']            = PredefinedDateFormatShowOnCalendarDashboard($process_array["start_date"]);

        $success_array['date_filter_tab_1_date_to_show_day']        = date('d',strtotime($process_array["start_date"]));
        $success_array['date_filter_tab_1_date_to_show_day_week']   = date('l',strtotime($process_array["start_date"]));
        $success_array['date_filter_tab_1_date_to_show_month']      = date('F',strtotime($process_array["start_date"]));



        $success_array["filter_value_selected"]                     = PredefinedStandardDateFormatChangeDateAlone($process_array["start_date"]);

        $common_symphony_controller->GetAnePatientCategorySplitUpArrayWithAtdTypes($all_type_attendance_on_specific_dates_array, $process_array);
        $process_array['attendance_arr']['attendance_all'] = $all_type_attendance_on_specific_dates_array;



        $this->ActivityProfileTopMatrix($success_array, $process_array);
        $this->ActivityProfileAdmittedDtaTriageMatrix($success_array, $process_array);
        $this->ActivityProfileHourlyData($success_array, $process_array);
    }

    public function ActivityProfileTopMatrix(&$success_array, &$process_array)
    {
        $common_controller = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;
        $process_array["attendence_data_processed"]                 = $common_controller->ArrayFindInBetweenDateTimeOfFields($process_array['attendance_arr']['attendance_all'], $process_array["start_date"], $process_array["end_date"], 'symphony_registration_date_time');

        $admitted_discharge_breach_array                            = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($process_array["attendence_data_processed"], $process_array);
        $process_array["breach_data_processed"]                     = $admitted_discharge_breach_array["breached_patients"];

        //Attendence, Breaches & Performance All  (ED, EYE & UTC)
        $success_array["attendence_total"]                          = count($process_array["attendence_data_processed"]);
        $success_array["breaches"]                                  = count($admitted_discharge_breach_array["breached_patients"]);
        $success_array["performance_overall"]                       = PerformanceCalculationAne($success_array["breaches"], $success_array["attendence_total"], 0);

        $attendence_admitted_discharged                             = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($process_array["attendence_data_processed"], $process_array);
        $breached_admitted_discharged                               = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($process_array["breach_data_processed"], $process_array);

        $ambulance_walkin_arrival_array                             = $common_symphony_controller->AmbulanceWalkinArrayProcess($process_array["attendence_data_processed"]);
        $ambulance_admitted_discharged                              = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($ambulance_walkin_arrival_array["ambulance_arrival"], $process_array);
        $walkin_admitted_discharged                                 = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($ambulance_walkin_arrival_array["walkin_arrival"], $process_array);

        //Conversion Admitted Section
        $success_array["conversion_rate_admitted_count"]            = count($attendence_admitted_discharged["admitted_patients"]);
        $success_array["conversion_rate_admitted_percentage"]       = PercentageCalculationOfValues(count($attendence_admitted_discharged["admitted_patients"]), count($process_array["attendence_data_processed"]), 0);

        //Performance Admitted & Non Admitted Section
        $success_array["performance_admitted_percentage"]           = PerformanceCalculationAne(count($breached_admitted_discharged["admitted_patients"]), count($attendence_admitted_discharged["admitted_patients"]), 0);
        $success_array["performance_non_admitted_percentage"]       = PerformanceCalculationAne(count($breached_admitted_discharged["discharged_patients"]), count($attendence_admitted_discharged["discharged_patients"]), 0);

        // Total admitted patients
        $total_admitted = count($breached_admitted_discharged["admitted_patients"]) + count($attendence_admitted_discharged["admitted_patients"]);

        // Total non-admitted patients
        $total_non_admitted = count($breached_admitted_discharged["discharged_patients"]) + count($attendence_admitted_discharged["discharged_patients"]);

        $success_array["total_admitted_performance"]                = $total_admitted;
        $success_array["total_non_admitted_performance"]            = $total_non_admitted;


        //Ambulance Arrival Section
        $success_array["ambulance_arrival_total_count"]             = count($ambulance_walkin_arrival_array["ambulance_arrival"]);
        $success_array["ambulance_arrival_home_count"]              = count($ambulance_admitted_discharged["discharged_patients"]);
        $success_array["ambulance_arrival_home_percentage"]         = PercentageCalculationOfValues(count($ambulance_admitted_discharged["discharged_patients"]), count($ambulance_walkin_arrival_array["ambulance_arrival"]), 0);
        $success_array["ambulance_arrival_admitted_count"]          = count($ambulance_admitted_discharged["admitted_patients"]);
        $success_array["ambulance_arrival_admitted_percentage"]     = PercentageCalculationOfValues(count($ambulance_admitted_discharged["admitted_patients"]), count($ambulance_walkin_arrival_array["ambulance_arrival"]), 0);

        //Walk In Section
        $success_array["walk_in_arrival_total_count"]               = count($ambulance_walkin_arrival_array["walkin_arrival"]);
        $success_array["walk_in_arrival_home_count"]                = count($walkin_admitted_discharged["discharged_patients"]);
        $success_array["walk_in_arrival_home_percentage"]           = PercentageCalculationOfValues(count($walkin_admitted_discharged["discharged_patients"]), count($ambulance_walkin_arrival_array["walkin_arrival"]), 0);
        $success_array["walk_in_arrival_admitted_count"]            = count($walkin_admitted_discharged["admitted_patients"]);
        $success_array["walk_in_arrival_admitted_percentage"]       = PercentageCalculationOfValues(count($walkin_admitted_discharged["admitted_patients"]), count($ambulance_walkin_arrival_array["walkin_arrival"]), 0);
    }




    public function ActivityProfileAdmittedDtaTriageMatrix(&$success_array, &$process_array)
    {
        $common_controller                                          = new CommonController;
        $common_symphony_controller                                 = new CommonSymphonyController;
        $triage_category_data_array                                 = $common_controller->ArrayColumnCategoryWiseGrouping($process_array["attendence_data_processed"], 'symphony_triage_category');
        $triage_category                                            = array();
        if (isset($triage_category_data_array))
        {
            if (count($triage_category_data_array) > 0)
            {
                $x = 0;
                foreach ($triage_category_data_array as $key => $row)
                {
                    $triage_category[$x]["category_label"]  =   $key;
                    $triage_category[$x]["category_count"]  =   count($row);
                    $x++;
                }
            }
        }
        MultiArraySortCustom($triage_category, "category_label", "asc");

        $success_array["triage_category_x"]                  = "[]";
        $success_array["triage_category_y"]                  = "[]";
        $triage_category_x_arr                               = array();
        $triage_category_y_arr                               = array();
        if (count($triage_category) > 0)
        {
            foreach ($triage_category as $row)
            {
                $triage_category_x_arr[]                     = "'" . $row['category_label'] . "'";
                $triage_category_y_arr[]                     = $row['category_count'];
            }
        }
        if (count($triage_category_x_arr) > 0)
        {
            $success_array["triage_category_x"]              = "[" . implode(", ", $triage_category_x_arr) . "]";
        }
        if (count($triage_category_y_arr) > 0)
        {
            $success_array["triage_category_y"]              = "[" . implode(", ", $triage_category_y_arr) . "]";
        }
        $dta_waits_less_2                                           = array();
        $dta_waits_less_4                                           = array();
        $dta_waits_greater_4                                        = array();
        if (isset($process_array["attendence_data_processed"]))
        {
            if (count($process_array["attendence_data_processed"]) > 0)
            {
                $x = 0;
                $curr_time_to_chk                                   = CurrentDateOnFormat();
                foreach ($process_array["attendence_data_processed"] as $key => $row)
                {
                    if ($row['symphony_request_date'] != '' && $row['symphony_request_date'] != null)
                    {
                        $time_difference_request_in_minutes         = 0;
                        if ($row['symphony_discharge_date'] != '' && $row['symphony_discharge_date'] != null)
                        {
                            $time_difference_request_in_minutes     = TimeDifferenceInMinutes($row['symphony_discharge_date'], $row['symphony_request_date']);
                        }
                        else
                        {
                            $time_difference_request_in_minutes     = TimeDifferenceInMinutes($curr_time_to_chk, $row['symphony_request_date']);
                        }

                        if ($time_difference_request_in_minutes < 120)
                        {
                            $dta_waits_less_2[]                     = $row;
                        }
                        else if ($time_difference_request_in_minutes < 240)
                        {
                            $dta_waits_less_4[]                     = $row;
                        }
                        else
                        {
                            $dta_waits_greater_4[]                  = $row;
                        }
                    }
                }
            }
        }
        $success_array["dta_waits_x"]                  = "['Less Than 2 Hours','2 To 4 Hours','Greater Than 4 Hours']";
        $success_array["dta_waits_y"]                  = "[" . count($dta_waits_less_2) . "," . count($dta_waits_less_4) . "," . count($dta_waits_greater_4) . "]";

        //Admitted by Speciality Section
        $admitted_by_spec_data_array                    = $common_controller->ArrayColumnCategoryWiseGrouping($process_array["attendence_data_processed"], 'symphony_specialty');
        $admitted_by_speciality                         = array();
        if (isset($admitted_by_spec_data_array))
        {
            if (count($admitted_by_spec_data_array) > 0)
            {
                $x = 0;
                foreach ($admitted_by_spec_data_array as $key => $row)
                {
                    $admitted_by_speciality[$x]["category_label"]  =   $key;
                    $admitted_by_speciality[$x]["category_count"]  =   count($row);
                    $x++;
                }
            }
        }
        MultiArraySortCustom($admitted_by_speciality, "category_label", "asc");

        $success_array["admitted_by_speciality_x"]                  = "[]";
        $success_array["admitted_by_speciality_y"]                  = "[]";
        $admitted_by_speciality_x_arr                               = array();
        $admitted_by_speciality_y_arr                               = array();
        if (count($admitted_by_speciality) > 0)
        {
            foreach ($admitted_by_speciality as $row)
            {
                $admitted_by_speciality_x_arr[]                     = "'" . $row['category_label'] . "'";
                $admitted_by_speciality_y_arr[]                     = $row['category_count'];
            }
        }

        if (count($admitted_by_speciality_x_arr) > 0)
        {
            $success_array["admitted_by_speciality_x"]              = "[" . implode(", ", $admitted_by_speciality_x_arr) . "]";
        }
        if (count($admitted_by_speciality_y_arr) > 0)
        {
            $success_array["admitted_by_speciality_y"]              = "[" . implode(", ", $admitted_by_speciality_y_arr) . "]";
        }
    }

    public function ActivityProfileHourlyData(&$success_array, &$process_array)
    {
        $common_controller = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;
        $attendence_hour_data_processed                             = $common_controller->ArrayFindInBetweenDateTimeOfFields($process_array['attendance_arr']['attendance_all'], $process_array["start_date"], $process_array["end_date"], 'symphony_registration_date_time');
        $attendence_hour_data_processed_still_in                    = $process_array['attendance_arr']['attendance_all'];
        $left_ed_hour_data_processed                                = $common_controller->ArrayFindInBetweenDateTimeOfFields($process_array['attendance_arr']['attendance_all'], $process_array["start_date"], $process_array["end_date"], 'symphony_discharge_date');



        $right_matrix_performance = array();

        foreach ($process_array['ibox_symphony_final_location_category_main'] as $location) {
            $right_matrix_performance['time_wise_preformance'][str_replace(' ', '_', strtolower($location))]['attendance'] = count(array_filter($process_array['attendance_arr']['attendance_main'], function($ed_left_data) use ($location) {
                return strtolower($ed_left_data['symphony_final_location']) == strtolower($location);
            }));
        }


        foreach ($process_array['ibox_symphony_final_location_category_main'] as $location) {
            $right_matrix_performance['time_wise_preformance'][str_replace(' ', '_', strtolower($location))]['left_ed'] = count(array_filter($left_ed_hour_data_processed, function($ed_left_data) use ($location) {
                return strtolower($ed_left_data['symphony_final_location']) == strtolower($location);
            }));
        }

        $breach_hour_data_processed_total_arr                       = $common_controller->ArrayFindInBetweenDateTimeOfFields($process_array['attendance_arr']['attendance_main'], $process_array["start_date"], $process_array["end_date"], 'symphony_discharge_date');
        $breach_hour_data_processed_total_arr_all                   = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($breach_hour_data_processed_total_arr, $process_array);

        $breach_hour_data_processed                       = $common_controller->ArrayFindInBetweenDateTimeOfFields($breach_hour_data_processed_total_arr_all['breached_patients'], $process_array["start_date"], $process_array["end_date"], 'symphony_estimated_breach_time');

        foreach ($process_array['ibox_symphony_final_location_category_main'] as $location) {
            $right_matrix_performance['time_wise_preformance'][str_replace(' ', '_', strtolower($location))]['breaches'] = count(array_filter($breach_hour_data_processed, function($ed_left_data) use ($location) {
                return strtolower($ed_left_data['symphony_final_location']) == strtolower($location);
            }));
        }
        $right_matrix_with_performance = array_map("CalculateHourlyBreachPerformancePerformance", $right_matrix_performance['time_wise_preformance']);


        $success_array['right_matrix_with_performance']             = $right_matrix_with_performance;
        $attendence_year_hour_data_processed                        = $process_array['attendance_arr']['attendance_main'];


        $top_hour_data                                              = array();
        $common_controller->CountOnEveryHourAddPrimaryHour($top_hour_data);
        $common_controller->CountOnEveryHourArrayConversion($top_hour_data, $attendence_hour_data_processed, "arrivals", "symphony_registration_date_time");
        $common_controller->CountOnEveryHourArrayConversion($top_hour_data, $left_ed_hour_data_processed, "left_ed", "symphony_discharge_date");
        $common_controller->CountOnEveryHourArrayConversion($top_hour_data, $breach_hour_data_processed, "breaches", "symphony_estimated_breach_time");
        //   $common_symphony_controller->CountOnEveryHourArrayConversionStillInEd($top_hour_data,$attendence_hour_data_processed_still_in,"still_in_ed",$process_array["start_date"],$process_array["end_date"]);

        for ($x = 0; $x < 24; $x++)
        {
            $top_hour_data[$x]['still_in_ed']               = 0;
        }

        if (count($process_array["symphony_ed_activity_hourly_summary"]) > 0)
        {
            foreach ($process_array["symphony_ed_activity_hourly_summary"] as $row)
            {
                $time_to_process                                                = date('Y-m-d') . $row['hour'] . ':00';
                $index_of_streaming_arr                                         = (int) date('H', strtotime($time_to_process));
                if ($row['key'] == 'majors' || $row['key'] == 'utc' || $row['key'] == 'resus' || $row['key'] == 'paed_eds' || $row['key'] == 'others')
                {
                    if (!isset($top_hour_data[$index_of_streaming_arr]['still_in_ed']))
                    {
                        $top_hour_data[$index_of_streaming_arr]['still_in_ed'] = 0;
                    }
                    $top_hour_data[$index_of_streaming_arr]['still_in_ed'] = (int) $top_hour_data[$index_of_streaming_arr]['still_in_ed'] + (int) $row['val'];
                }
            }
        }

        $top_hour_data_with_performance = array_map("CalculateHourlyBreachPerformancePerformance", $top_hour_data);
        $success_array["top_hour_data"]                             =  $top_hour_data_with_performance;
        $min_max_category_array                                     =  ['arrivals', 'left_ed', 'still_in_ed','breaches', 'performance'];
        $this->HourlyMinMaxArrayCategoryHeatMap($top_hour_data_with_performance, $success_array, $min_max_category_array, 'top_hour_data');

        $patient_per_hour                                           = array();
        $left_ed_hour_admitted_discharged                           = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($left_ed_hour_data_processed, $process_array);
        $common_controller->CountOnEveryHourAddPrimaryHour($patient_per_hour);
        $common_controller->CountOnEveryHourArrayConversion($patient_per_hour, $attendence_hour_data_processed, "arrivals", "symphony_registration_date_time");
        $common_controller->CountOnEveryHourArrayConversion($patient_per_hour, $breach_hour_data_processed, "breaches", "symphony_estimated_breach_time");
        $common_controller->CountOnEveryHourArrayConversion($patient_per_hour, $attendence_year_hour_data_processed, "forecast", "symphony_registration_date_time");
        $common_controller->CountOnEveryHourArrayConversion($patient_per_hour, $left_ed_hour_data_processed, "left_ed", "symphony_discharge_date");
        $common_controller->CountOnEveryHourArrayConversion($patient_per_hour, $left_ed_hour_admitted_discharged["admitted_patients"], "admitted", "symphony_discharge_date");
        $common_controller->CountOnEveryHourArrayConversionYearAverage($patient_per_hour, "forecast", 10);
        $success_array["patient_per_hour"]                          = $patient_per_hour;

        $success_array["patient_per_hour_1"]                        = "['admitted',]";
        $success_array["patient_per_hour_2"]                        = "['leftED',]";
        $success_array["patient_per_hour_3"]                        = "['arrivals',]";
        $success_array["patient_per_hour_4"]                        = "['forecast',]";
        $success_array["patient_per_hour_5"]                        = "['breaches',]";

        $patient_per_hour_1_arr                                     = array();
        $patient_per_hour_2_arr                                     = array();
        $patient_per_hour_3_arr                                     = array();
        $patient_per_hour_4_arr                                     = array();
        $patient_per_hour_5_arr                                     = array();

        if (count($patient_per_hour) > 0)
        {
            foreach ($patient_per_hour as $row)
            {
                $patient_per_hour_1_arr[]                           = $row['admitted'] * -1;
                $patient_per_hour_2_arr[]                           = $row['left_ed'] * -1;
                $patient_per_hour_3_arr[]                           = $row['arrivals'];
                $patient_per_hour_4_arr[]                           = $row['forecast'];
                $patient_per_hour_5_arr[]                           = $row['breaches'];
            }
        }


        if (count($patient_per_hour_1_arr) > 0)
        {
            $success_array["patient_per_hour_1"]                    = "['Discharge Outcome Admitted'," . implode(", ", $patient_per_hour_1_arr) . "]";
        }
        if (count($patient_per_hour_2_arr) > 0)
        {
            $success_array["patient_per_hour_2"]                    = "['Discharge Outcome Home'," . implode(", ", $patient_per_hour_2_arr) . "]";
        }
        if (count($patient_per_hour_3_arr) > 0)
        {
            $success_array["patient_per_hour_3"]                    = "['arrivals'," . implode(", ", $patient_per_hour_3_arr) . "]";
        }
        if (count($patient_per_hour_4_arr) > 0)
        {
            $success_array["patient_per_hour_4"]                    = "['forecast'," . implode(", ", $patient_per_hour_4_arr) . "]";
        }
        if (count($patient_per_hour_5_arr) > 0)
        {
            $success_array["patient_per_hour_5"]                    = "['breaches'," . implode(", ", $patient_per_hour_5_arr) . "]";
        }

        $arrival_method                                             = array();
        $ambulance_walkin_hour_arrival_array                        = $common_symphony_controller->AmbulanceWalkinArrayProcess($attendence_hour_data_processed);
        $common_controller->CountOnEveryHourAddPrimaryHour($arrival_method);
        $common_controller->CountOnEveryHourArrayConversion($arrival_method, $ambulance_walkin_hour_arrival_array["ambulance_arrival"], "ambulance", "symphony_registration_date_time");
        $common_controller->CountOnEveryHourArrayConversion($arrival_method, $ambulance_walkin_hour_arrival_array["walkin_arrival"], "walk_in", "symphony_registration_date_time");
        $success_array["arrival_method"]                            = $arrival_method;

        $min_max_category_array                                     =  ['ambulance', 'walk_in'];
        $this->HourlyMinMaxArrayCategoryHeatMap($arrival_method, $success_array, $min_max_category_array, 'arrival_method');






        $triage_date_data_processed                                 = $common_controller->ArrayFindInBetweenDateTimeOfFields($process_array['attendance_arr']['attendance_all'], $process_array["start_date"], $process_array["end_date"], 'symphony_triage_date');
        $ed_clinician_data_processed                                = $common_controller->ArrayFindInBetweenDateTimeOfFields($process_array['attendance_arr']['attendance_all'], $process_array["start_date"], $process_array["end_date"], 'symphony_seen_ae_date');
        $spec_doctor_data_processed                                 = $common_controller->ArrayFindInBetweenDateTimeOfFields($process_array['attendance_arr']['attendance_all'], $process_array["start_date"], $process_array["end_date"], 'symphony_refferal_date');

        $target_times                                               = array();
        $common_controller->CountOnEveryHourAddPrimaryHour($target_times);
        $common_controller->CountOnEveryHourArrayConversion($target_times, $triage_date_data_processed, "triage", "symphony_triage_date");
        $common_symphony_controller->AverageTimeOnEveryHourArrayConversion($target_times, $triage_date_data_processed, "triage_longer_time", "symphony_triage_date");
        $common_controller->CountOnEveryHourArrayConversion($target_times, $ed_clinician_data_processed, "ed_clinician", "symphony_seen_ae_date");
        $common_symphony_controller->AverageTimeOnEveryHourArrayConversion($target_times, $ed_clinician_data_processed, "ed_clinician_longer_time", "symphony_seen_ae_date");
        $common_controller->CountOnEveryHourArrayConversion($target_times, $spec_doctor_data_processed, "speciality_doctor", "symphony_refferal_date");
        $common_symphony_controller->AverageTimeOnEveryHourArrayConversion($target_times, $spec_doctor_data_processed, "speciality_doctor_longer_time", "symphony_refferal_date");
        $success_array["target_times"]                              = $target_times;

        $min_max_category_array                                     =  ['triage', 'ed_clinician','speciality_doctor'];
        $this->HourlyMinMaxArrayCategoryHeatMap($target_times, $success_array, $min_max_category_array, 'target_times');



        $triage_times                                               = array();
        $common_controller->CountOnEveryHourAddPrimaryHour($triage_times);
        $common_symphony_controller->CountOnEveryHourArrayConversionTargetTimes($triage_times, $triage_date_data_processed, "triage", "symphony_triage_date",15);
        $min_max_category_array                                     =  ['patients_seen', 'greater_than','avg_time','longer_time'];
        $this->HourlyMinMaxArrayCategoryHeatMap($triage_times, $success_array, $min_max_category_array, 'triage_times');
        $success_array["triage_times"]                              = $triage_times;

        $ed_clinician_times                                         = array();
        $common_controller->CountOnEveryHourAddPrimaryHour($ed_clinician_times);
        $common_symphony_controller->CountOnEveryHourArrayConversionTargetTimes($ed_clinician_times, $ed_clinician_data_processed, "ed_clinician", "symphony_seen_ae_date",60);
        $min_max_category_array                                     =  ['patients_seen', 'greater_than','avg_time','longer_time'];
        $this->HourlyMinMaxArrayCategoryHeatMap($ed_clinician_times, $success_array, $min_max_category_array, 'ed_clinician_times');
        $success_array["ed_clinician_times"]                        = $ed_clinician_times;

        $spec_doctor_times                                          = array();
        $common_controller->CountOnEveryHourAddPrimaryHour($spec_doctor_times);
        $common_symphony_controller->CountOnEveryHourArrayConversionTargetTimes($spec_doctor_times, $spec_doctor_data_processed, "spec_doctor", "symphony_refferal_date",60);
        $min_max_category_array                                     =  ['patients_seen', 'greater_than','avg_time','longer_time'];
        $this->HourlyMinMaxArrayCategoryHeatMap($spec_doctor_times, $success_array, $min_max_category_array, 'spec_doctor_times');
        $success_array["spec_doctor_times"]                         = $spec_doctor_times;













        $target_times_graph                                         = array();
        $common_controller->CountOnEveryHourAddPrimaryHour($target_times_graph);
        $common_controller->CountOnEveryHourArrayConversion($target_times_graph, $triage_date_data_processed, "triage", "symphony_triage_date");
        $common_controller->CountOnEveryHourArrayConversion($target_times_graph, $ed_clinician_data_processed, "ed_clinician", "symphony_seen_ae_date");
        $common_controller->CountOnEveryHourArrayConversion($target_times_graph, $spec_doctor_data_processed, "speciality_doctor", "symphony_refferal_date");
        $success_array["target_times_graph"]                        = $target_times_graph;

        $success_array["target_times_x"]                            = "[]";
        $success_array["target_times_1"]                            = "['data1',]";
        $success_array["target_times_2"]                            = "['data2',]";
        $success_array["target_times_3"]                            = "['data3',]";
        $target_times_x_arr                                         = array();
        $target_times_1_arr                                         = array();
        $target_times_2_arr                                         = array();
        $target_times_3_arr                                         = array();
        if (count($target_times_graph) > 0)
        {
            foreach ($target_times_graph as $row)
            {
                $target_times_x_arr[]                               = "'" . $row['hour'] . "'";
                $target_times_1_arr[]                               = $row['triage'];
                $target_times_2_arr[]                               = $row['ed_clinician'];
                $target_times_3_arr[]                               = $row['speciality_doctor'];
            }
        }

        if (count($target_times_x_arr) > 0)
        {
            $success_array["target_times_x"]                        = "[" . implode(", ", $target_times_x_arr) . "]";
        }
        if (count($target_times_1_arr) > 0)
        {
            $success_array["target_times_1"]                        = "['data1'," . implode(", ", $target_times_1_arr) . "]";
        }
        if (count($target_times_2_arr) > 0)
        {
            $success_array["target_times_2"]                        = "['data2'," . implode(", ", $target_times_2_arr) . "]";
        }
        if (count($target_times_3_arr) > 0)
        {
            $success_array["target_times_3"]                        = "['data3'," . implode(", ", $target_times_3_arr) . "]";
        }











        $dta_hourly_details                                         = $process_array["symphony_ed_activity_hourly_summary"];
        $dta                                                        = array();
        $common_controller->CountOnEveryHourAddPrimaryHour($dta);
        $common_symphony_controller->CountOnEveryHourArrayConversionMaxValEdProfile($dta, $dta_hourly_details, "dta_still_in_ed");
        $common_symphony_controller->CountOnEveryHourArrayConversionMaxValEdProfile($dta, $dta_hourly_details, "dta_reffered");
        $common_symphony_controller->CountOnEveryHourArrayConversionMaxValEdProfile($dta, $dta_hourly_details, "dta_made");
        $common_symphony_controller->CountOnEveryHourArrayConversionMaxValEdProfile($dta, $dta_hourly_details, "dta_beds_ready");

        $success_array["dta"]                                       = $dta;

        $min_max_category_array                                     =  ['dta_beds_ready', 'dta_still_in_ed','dta_reffered','dta_made'];
        $this->HourlyMinMaxArrayCategoryHeatMap($dta, $success_array, $min_max_category_array, 'dta');










        $referred                                                   = array();
        $common_controller->CountOnEveryHourAddPrimaryHour($referred);
        $common_symphony_controller->CountOnEveryHourArrayConversionMaxValEdProfile($referred, $dta_hourly_details, "dta_reffered");
        $common_symphony_controller->CountOnEveryHourArrayConversionMaxValEdProfile($referred, $dta_hourly_details, "dta_referred_total");
        $success_array["referred"]                                  = $referred;
        $success_array["referred_data_x"]                           = "[]";
        $success_array["referred_data_1"]                           = "['data1',]";
        $success_array["referred_data_2"]                           = "['data2',]";
        $referred_data_x_arr                                        = array();
        $referred_data_1_arr                                        = array();
        $referred_data_2_arr                                        = array();


        if (count($referred) > 0)
        {
            foreach ($referred as $row)
            {
                $referred_data_x_arr[]                              = "'" . $row['hour'] . "'";
                $referred_data_1_arr[]                              = $row['dta_reffered'];
                $referred_data_2_arr[]                              = $row['dta_referred_total'];
            }
        }

        if (count($referred_data_x_arr) > 0)
        {
            $success_array["referred_data_x"]                       = "[" . implode(", ", $referred_data_x_arr) . "]";
        }
        if (count($referred_data_1_arr) > 0)
        {
            $success_array["referred_data_1"]                       = "['data1'," . implode(", ", $referred_data_1_arr) . "]";
        }
        if (count($referred_data_2_arr) > 0)
        {
            $success_array["referred_data_2"]                       = "['data2'," . implode(", ", $referred_data_2_arr) . "]";
        }









        MultiArraySortCustom($breach_data_patient_records_all, "Breach_Time", "asc");
        $success_array["breach_data"]                                           = json_encode($breach_data_patient_records_all);
        $patients_still_in_ed                                                   = array();
        $common_controller->CountOnEveryHourAddPrimaryHour($patients_still_in_ed);
        $streamed_to                                                            = array();
        $common_controller->CountOnEveryHourAddPrimaryHour($streamed_to);
        if (count($process_array["symphony_ed_activity_hourly_summary"]) > 0)
        {
            foreach ($process_array["symphony_ed_activity_hourly_summary"] as $row)
            {
                $time_to_process                                                = date('Y-m-d') . $row['hour'] . ':00';
                $index_of_streaming_arr                                         = (int)date('H', strtotime($time_to_process));
                if ($row['key'] == 'majors' || $row['key'] == 'utc' || $row['key'] == 'resus' || $row['key'] == 'paed_eds' || $row['key'] == 'others')
                {
                    $patients_still_in_ed[$index_of_streaming_arr][$row['key']] = $row['val'];
                }
                if ($row['key'] == 'arrival_major' || $row['key'] == 'arrival_resus' || $row['key'] == 'arrival_utc' || $row['key'] == 'arrival_paed_eds' || $row['key'] == 'arrival_others')
                {
                    $streamed_to[$index_of_streaming_arr][$row['key']] = $row['val'];
                }
            }
        }

        $success_array["patient_still_in_ed"]                                   = $patients_still_in_ed;
        $min_max_category_array =  ['utc', 'others', 'majors','resus', 'paed_eds'];
        $this->HourlyMinMaxArrayCategoryHeatMap($patients_still_in_ed, $success_array, $min_max_category_array, 'patients_still_in_ed');
    }





    public function HourlyMinMaxArrayCategoryHeatMap($process_array, &$success_array, $min_max_category_array, $row_name)
    {
        if (count($min_max_category_array) > 0)
        {
            foreach ($min_max_category_array as $row)
            {
                $category_max_min               = array_column($process_array, $row);
                if (count($category_max_min) > 0)
                {
                    $index_name = $row . '_' . $row_name;
                    $success_array[$index_name . "_max"]                         = max($category_max_min);
                    $success_array[$index_name . "_min"]                         = min($category_max_min);
                }
                else
                {
                    $index_name = $row . '_' . $row_name;
                    $success_array[$index_name . "_max"]                         = 0;
                    $success_array[$index_name . "_min"]                         = 0;
                }
            }
        }
    }
}
