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
use App\Models\Iboards\Symphony\Data\SymphonyAttendanceCalculatedHourlyEDSummary;
use App\Models\Iboards\Symphony\Data\SymphonyAttendanceCalculatedDailyEDSummary;
use Illuminate\Support\Facades\View;
use App\Models\Common\User;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class ActivityProfileController extends Controller
{
    public function Index(Request $request)
    {
        if (!CheckDashboardPermission('activity_profile_view'))
        {
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
        $filter_value_start                 = $request->filter_value_start;
        $filter_value_end                   = $request->filter_value_end;

        $process_array["start_date"]        = ($filter_value_start != "") ? date('Y-m-d 00:00:00', strtotime($filter_value_start)) : date('Y-m-d 00:00:00');
        $process_array["end_date"]          = ($filter_value_end != "") ? date('Y-m-d 23:59:59', strtotime($filter_value_end)) : date('Y-m-d 23:59:59');
        $this->PageDataLoad($process_array, $success_array);
        $success_array = json_decode(file_get_contents('demo_data/ane/activity_profile.txt'), true);
        $view                               = View::make('Dashboards.Symphony.ActivityProfile.IndexDataLoad', compact('success_array'));
        $sections                           = $view->render();
        return $sections;
    }




    public function PageDataLoad(&$process_array, &$success_array)
    {
        $common_controller                                          = new CommonController;
        $common_controller                                          = new CommonController;
        $common_symphony_controller                                 = new CommonSymphonyController;
        $category_breach_details                                    = array();

        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);

        $all_type_attendance_on_specific_dates_array                = SymphonyAttendanceView::whereBetween('symphony_discharge_date', array($process_array["start_date"], $process_array["end_date"]))->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
        $process_array["attendence_today_all"]                       = $all_type_attendance_on_specific_dates_array;
        $attendance_location_specific_today                          = $common_controller->ArrayColumnCategoryWiseGrouping($process_array["attendence_today_all"], 'symphony_final_location');
        $common_symphony_controller->LocationWiseAttendanceDetailsProcessWithOthersArray($attendance_location_specific_today, $category_breach_details, $process_array);
        $success_array["top_matrix"]["category_breach_details"]                             = $category_breach_details;






        $success_array['date_filter_tab_1_date_to_show']            = PredefinedDateFormatShowOnCalendarDashboard($process_array["start_date"]);
        $success_array['date_filter_tab_1_date_to_show_day']        = date('d', strtotime($process_array["start_date"]));
        $success_array['date_filter_tab_1_date_to_show_day_week']   = date('l', strtotime($process_array["start_date"]));
        $success_array['date_filter_tab_1_date_to_show_month']      = date('F', strtotime($process_array["start_date"]));
        $success_array["filter_value_selected"]                     = PredefinedStandardDateFormatChangeDateAlone($process_array["start_date"]);

        $process_array['attendance_arr']['attendance_main']         = $all_type_attendance_on_specific_dates_array;
        $this->ActivityProfileTopMatrix($success_array, $process_array);
        $this->ActivityProfileAdmittedDtaTriageMatrix($success_array, $process_array);
        $this->ActivityProfileHourlyData($success_array, $process_array);
    }

    public function ActivityProfileTopMatrix(&$success_array, &$process_array)
    {
        $common_controller = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;

        $process_array["attendence_data_processed"]                 = $common_controller->ArrayFindInBetweenDateTimeOfFields($process_array['attendance_arr']['attendance_main'], $process_array["start_date"], $process_array["end_date"], 'symphony_discharge_date');

        $admitted_discharge_breach_array                            = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($process_array["attendence_data_processed"], $process_array);
        $process_array["breach_data_processed"]                     = $admitted_discharge_breach_array["breached_patients"];

        //Attendence, Breaches & Performance All  (ED, EYE & UTC)
        $success_array["attendence_total"]                          = count($process_array["attendence_data_processed"]);
        $success_array["breaches"]                                  = count($admitted_discharge_breach_array["breached_patients"]);
        $overall_discharges                                         = $common_controller->ArrayFindInBetweenDateTimeOfFields($process_array['attendance_arr']['attendance_main'], $process_array['start_date'], $process_array['end_date'], 'symphony_discharge_date');

        $success_array["performance_overall"]                       = PerformanceCalculationAne($success_array["breaches"], count($overall_discharges), 0);

        $attendence_admitted_discharged                             = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($process_array["attendence_data_processed"], $process_array);
        $breached_admitted_discharged                               = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($process_array["breach_data_processed"], $process_array);

        $ambulance_walkin_arrival_array                             = $common_symphony_controller->AmbulanceWalkinArrayProcess($process_array["attendence_data_processed"]);
        $ambulance_admitted_discharged                              = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($ambulance_walkin_arrival_array["ambulance_arrival"], $process_array);
        $walkin_admitted_discharged                                 = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($ambulance_walkin_arrival_array["walkin_arrival"], $process_array);

        $admitted_left_ed                                           = $common_controller->ArrayFindInBetweenDateTimeOfFields($attendence_admitted_discharged["admitted_patients"], $process_array['start_date'], $process_array['end_date'], 'symphony_discharge_date');
        $nonadmitted_left_ed                                         = $common_controller->ArrayFindInBetweenDateTimeOfFields($attendence_admitted_discharged["discharged_patients"], $process_array['start_date'], $process_array['end_date'], 'symphony_discharge_date');

        //Conversion Admitted Section
        $success_array["conversion_rate_admitted_count"]            = count($admitted_left_ed);
        $success_array["conversion_rate_admitted_percentage"]       = PercentageCalculationOfValues(count($nonadmitted_left_ed), count($process_array["attendence_data_processed"]), 0);




        //Performance Admitted & Non Admitted Section
        $success_array["performance_admitted_percentage"]           = PerformanceCalculationAne(count($breached_admitted_discharged["admitted_patients"]), count($admitted_left_ed), 0);
        $success_array["performance_non_admitted_percentage"]       = PerformanceCalculationAne(count($breached_admitted_discharged["discharged_patients"]), count($nonadmitted_left_ed), 0);

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
        $common_controller = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;
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
                $triage_category_y_arr[]                        = $row['category_count'];
                $row['category_label']                          = str_replace("-", " ", $row['category_label']);

                if (strpos($row['category_label'], ' '))
                {
                    $xpat                                       = explode(' ', $row['category_label']);
                    $triage_category_x_arr[]                    = "[" . implode(", ",  array_map(function ($val)
                    {
                        return sprintf("'%s'", ucwords($val));
                    }, $xpat)) . "]";
                }
                else
                {
                    $triage_category_x_arr[]                     = "'" . $row['category_label'] . "'";
                }
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
        $success_array["dta_waits_x"]                               = "['Less Than 2 Hours','2 To 4 Hours','Greater Than 4 Hours']";
        $success_array["dta_waits_y"]                               = "[" . count($dta_waits_less_2) . "," . count($dta_waits_less_4) . "," . count($dta_waits_greater_4) . "]";

        //Admitted by Speciality Section
        $admitted_by_spec_data_array                                = $common_controller->ArrayColumnCategoryWiseGrouping($process_array["attendence_data_processed"], 'symphony_specialty');
        $admitted_by_speciality                                     = array();
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
        //        if (count($admitted_by_speciality) > 0)
        //        {
        //            foreach ($admitted_by_speciality as $row)
        //            {
        //
        //                $admitted_by_speciality_y_arr[]                     = $row['category_count'];
        //
        //                if (strpos($row['category_label'], "Children's Acute Transport Service") !== false)
        //                {
        //                    $row['category_label'] = "CATS";
        //                }
        //
        //
        //                $row['category_label']                          = str_replace("-", " ", $row['category_label']);
        //                $row['category_label']                          = str_replace("'", "`", $row['category_label']);
        //                if (strpos($row['category_label'], ' '))
        //                {
        //                    $xpat                                       = explode(' ', $row['category_label']);
        //                    $admitted_by_speciality_x_arr[]                    = "[" . implode(", ",  array_map(function ($val)
        //                    {
        //                        return sprintf("'%s'", ucwords($val));
        //                    }, $xpat)) . "]";
        //                }
        //                else
        //                {
        //                    $admitted_by_speciality_x_arr[]                     = "'" . $row['category_label'] . "'";
        //                }
        //            }
        //        }



        if (count($admitted_by_speciality) > 0)
        {
            foreach ($admitted_by_speciality as $row)
            {
                $row['category_label'] = str_replace("'", "", $row['category_label']);
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
        $all_type_attendance_ed_sum                                  = SymphonyAttendanceCalculatedDailyEDSummary::whereBetween('ed_summary_date', array($process_array["start_date"], $process_array["end_date"]))->orderBy('ed_summary_date', 'ASC')->get()->toArray();
        $loc_check_breach = ['utc','majors', 'resus', 'paed_eds','others'];
        $right_matrix_breach = array();
        foreach ($loc_check_breach as $loc_r)
        {
            $right_matrix_breach[$loc_r]['attendance']              = 0;
            $right_matrix_breach[$loc_r]['breached']                = 0;
            $right_matrix_breach[$loc_r]['performance']             = 0;
        }

        $right_matrix_breach['total']['attendance']              = 0;
        $right_matrix_breach['total']['breached']                = 0;
        $right_matrix_breach['total']['performance']             = 0;

        if (count($all_type_attendance_ed_sum) > 0)
        {
            foreach ($all_type_attendance_ed_sum  as $row_b)
            {
                foreach ($loc_check_breach as $loc_r)
                {
                    if ($row_b['ed_summary_key_value'] == 'symphony_attendance_' . $loc_r)
                    {
                        $right_matrix_breach[$loc_r]['attendance'] =  $right_matrix_breach[$loc_r]['attendance'] + $row_b['ed_summary_value'];
                    }
                    if ($row_b['ed_summary_key_value'] == 'symphony_breached_' . $loc_r)
                    {
                        $right_matrix_breach[$loc_r]['breached'] =  $right_matrix_breach[$loc_r]['breached'] + $row_b['ed_summary_value'];
                    }
                }
            }
        }
        if (count($right_matrix_breach) > 0)
        {
            foreach ($right_matrix_breach as $key => $row_b)
            {

                $right_matrix_breach[$key]['performance']                       = PerformanceCalculationAne($row_b["breached"], $row_b['attendance'], 0);
                $right_matrix_breach['total']['attendance']                     =  $right_matrix_breach['total']['attendance'] + $row_b['attendance'];
                $right_matrix_breach['total']['breached']                       =  $right_matrix_breach['total']['breached'] + $row_b['breached'];
            }
        }
        $right_matrix_breach['total']['performance']                       = PerformanceCalculationAne($right_matrix_breach['total']['breached'], $right_matrix_breach['total']['attendance'], 0);
        $success_array["right_matrix_breach"]                              = $right_matrix_breach;
    }

    public function HourWiseGroupingForHourDataED(&$main_sec_hour_data, $attendance_data_array)
    {
        if (count($attendance_data_array) > 0)
        {
            foreach ($attendance_data_array as $row_arr)
            {
                $time_get                       = (int)date("H", strtotime($row_arr['ed_summary_time']));
                if (count($row_arr) > 0)
                {
                    foreach ($row_arr as $key_show => $row_val)
                    {
                        if (isset($main_sec_hour_data[$time_get][$key_show]))
                        {
                            $main_sec_hour_data[$time_get][$key_show] = $main_sec_hour_data[$time_get][$key_show] + $row_val;
                        }
                    }
                }
            }
        }
    }


    public function ForActivityProfileEveryHourCountOnEveryHourAddPrimaryValue(&$array_to_process, $index_array)
    {
        for ($x = 0; $x < 24; $x++)
        {
            $array_to_process[$x]["hour"]               = ($x < 10) ? "0" . $x : "" . $x;
            if (count($index_array) > 0)
            {
                foreach ($index_array as $row)
                {
                    $array_to_process[$x][$row]               = 0;
                }
            }
        }
    }

    public function ActivityProfileHourlyData(&$success_array, &$process_array)
    {

        $common_controller                                          = new CommonController;
        $common_symphony_controller                                 = new CommonSymphonyController;
























        $all_type_attendance_hourly_ed_sum                                  = SymphonyAttendanceCalculatedHourlyEDSummary::whereBetween('ed_summary_date_time', array($process_array["start_date"], $process_array["end_date"]))->orderBy('ed_summary_date_time', 'ASC')->get()->toArray();
        $still_in_ed_value_intialisation                                    = ['still_in_ae_utc', 'still_in_ae_majors', 'still_in_ae_resus', 'still_in_ae_others','still_in_ae_paed_eds'];
        $patients_still_in_ed                                               = array();
        $this->ForActivityProfileEveryHourCountOnEveryHourAddPrimaryValue($patients_still_in_ed, $still_in_ed_value_intialisation);
        $this->HourWiseGroupingForHourDataED($patients_still_in_ed, $all_type_attendance_hourly_ed_sum);
        $this->HourlyMinMaxArrayCategoryHeatMap($patients_still_in_ed, $success_array, $still_in_ed_value_intialisation, 'patients_still_in_ed');
        $success_array["patients_still_in_ed"]                              = $patients_still_in_ed;


        $top_hour_data_intialisation                                        = ['ane_attendance_arrivals', 'ane_attendance_left_ed', 'ane_attendance_breaches', 'ane_attendance_admitted', 'ane_attendance_discharged', 'ane_attendance_forecast'];
        $top_hour_data                                                      = array();
        $this->ForActivityProfileEveryHourCountOnEveryHourAddPrimaryValue($top_hour_data, $top_hour_data_intialisation);
        $this->HourWiseGroupingForHourDataED($top_hour_data, $all_type_attendance_hourly_ed_sum);
        for ($x = 0; $x < 24; $x++)
        {
            $top_hour_data[$x]['ane_attendance_still_in_ed']                               = 0;
        }
        if (count($success_array["patients_still_in_ed"]) > 0)
        {
            foreach ($success_array["patients_still_in_ed"] as $key => $row)
            {
                $time_to_process                                            = date('Y-m-d') . $row['hour'] . ':00';
                $temp_still_in_ed_total                                     = 0;
                if (count($still_in_ed_value_intialisation) > 0)
                {
                    foreach ($still_in_ed_value_intialisation  as $row_still)
                    {
                        if (isset($row[$row_still]))
                        {
                            $temp_still_in_ed_total = $temp_still_in_ed_total + $row[$row_still];
                        }
                    }
                }
                $top_hour_data[$key]['ane_attendance_still_in_ed']                         = $temp_still_in_ed_total;
            }
        }
        $top_hour_data_with_performance                                     = array_map("CalculateHourlyBreachPerformancePerformanceHourly", $top_hour_data);
        $success_array["top_hour_data"]                                     =  $top_hour_data_with_performance;

        $top_hour_data_intialisation                                        = ['ane_attendance_arrivals', 'ane_attendance_left_ed', 'ane_attendance_breaches', 'ane_attendance_admitted', 'ane_attendance_discharged', 'ane_attendance_forecast', 'ane_attendance_still_in_ed'];
        $this->HourlyMinMaxArrayCategoryHeatMap($top_hour_data, $success_array, $top_hour_data_intialisation, 'top_hour_data');



        $patient_per_hour_1_arr                                     = array();
        $patient_per_hour_2_arr                                     = array();
        $patient_per_hour_3_arr                                     = array();
        $patient_per_hour_4_arr                                     = array();
        $patient_per_hour_5_arr                                     = array();
        $days_between                                               = NumberOfDaysBetweenTwoDates($process_array["start_date"], $process_array["end_date"]) + 1;

        if (count($top_hour_data) > 0)
        {
            foreach ($top_hour_data as $row)
            {
                $patient_per_hour_1_arr[]                           = $row['ane_attendance_admitted'] * -1;
                $patient_per_hour_2_arr[]                           = $row['ane_attendance_discharged'] * -1;
                $patient_per_hour_3_arr[]                           = $row['ane_attendance_arrivals'];
                $patient_per_hour_4_arr[]                           = $row['ane_attendance_forecast'];
                $patient_per_hour_5_arr[]                           = $row['ane_attendance_breaches'];
            }
        }

        if (count($patient_per_hour_1_arr) > 0)
        {
            $success_array["patient_per_hour_1"]                    = "['admitted'," . implode(", ", $patient_per_hour_1_arr) . "]";
        }
        if (count($patient_per_hour_2_arr) > 0)
        {
            $success_array["patient_per_hour_2"]                    = "['leftED'," . implode(", ", $patient_per_hour_2_arr) . "]";
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

        $triage_times_intialisation                                         = ['triage_patients_seen', 'triage_greater_than', 'triage_avg_time', 'triage_longer_time'];
        $triage_times                                                       = array();
        $this->ForActivityProfileEveryHourCountOnEveryHourAddPrimaryValue($triage_times, $triage_times_intialisation);
        $this->HourWiseGroupingForHourDataED($triage_times, $all_type_attendance_hourly_ed_sum);
        $this->HourlyMinMaxArrayCategoryHeatMap($triage_times, $success_array, $triage_times_intialisation, 'triage_times');
        $success_array["triage_times"]                                      = $triage_times;


        $ed_clinician_times_intialisation                                   = ['ed_clinician_patients_seen', 'ed_clinician_greater_than', 'ed_clinician_avg_time', 'ed_clinician_longer_time'];
        $ed_clinician_times                                                 = array();
        $this->ForActivityProfileEveryHourCountOnEveryHourAddPrimaryValue($ed_clinician_times, $ed_clinician_times_intialisation);
        $this->HourWiseGroupingForHourDataED($ed_clinician_times, $all_type_attendance_hourly_ed_sum);
        $this->HourlyMinMaxArrayCategoryHeatMap($ed_clinician_times, $success_array, $ed_clinician_times_intialisation, 'ed_clinician_times');
        $success_array["ed_clinician_times"]                                = $ed_clinician_times;





        $arrival_method_intialisation                                       = ['ane_attendance_ambulance','ane_attendance_walk_in'];
        $arrival_method                                                     = array();
        $this->ForActivityProfileEveryHourCountOnEveryHourAddPrimaryValue($arrival_method, $arrival_method_intialisation);
        $this->HourWiseGroupingForHourDataED($arrival_method, $all_type_attendance_hourly_ed_sum);
        $this->HourlyMinMaxArrayCategoryHeatMap($arrival_method, $success_array, $arrival_method_intialisation, 'arrival_method');
        $success_array["arrival_method"]                                    = $arrival_method;


        $triage_cat_intialisation                                           = ['triage_category_1', 'triage_category_2', 'triage_category_3', 'triage_category_4', 'triage_category_5'];
        $triage_cat                                                         = array();
        $this->ForActivityProfileEveryHourCountOnEveryHourAddPrimaryValue($triage_cat, $triage_cat_intialisation);
        $this->HourWiseGroupingForHourDataED($triage_cat, $all_type_attendance_hourly_ed_sum);
        $this->HourlyMinMaxArrayCategoryHeatMap($triage_cat, $success_array, $triage_cat_intialisation, 'triage_cat');
        $success_array["triage_cat"]                                        = $triage_cat;



        $dta_value_intialisation                                            = ['dta_total_patient', 'dta_assigned_patient'];
        $dta                                                                = array();
        $this->ForActivityProfileEveryHourCountOnEveryHourAddPrimaryValue($dta, $dta_value_intialisation);
        $this->HourWiseGroupingForHourDataED($dta, $all_type_attendance_hourly_ed_sum);
        $this->HourlyMinMaxArrayCategoryHeatMap($dta, $success_array, $dta_value_intialisation, 'dta');
        $success_array["dta"]                                               = $dta;
    }


    public function ArrayColumnCategoryWiseGroupingForTriage(&$process_array, $data_array_process, $column_index1, $column_index2)
    {

        $date_check_to_start                                                = $process_array["start_date"];
        $date_check_to_end                                                  = $process_array["end_date"];
        $return_array                                                       = array();
        if (count($data_array_process) > 0)
        {
            foreach ($data_array_process as $row)
            {
                if (isset($row[$column_index1]) && isset($row[$column_index2]) && strtotime($date_check_to_start) <= strtotime($row[$column_index2]) && strtotime($date_check_to_end) >= strtotime($row[$column_index2]))
                {
                    if ($row[$column_index1] != null && $row[$column_index1] != "")
                    {
                        $return_array[$row[$column_index1]][]           = $row;
                    }
                }
            }
        }
        return $return_array;
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
