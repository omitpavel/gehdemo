<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Iboards\Symphony\Master\BreachReason;
use Illuminate\Support\Facades\DB;

class CommonSymphonyController extends Controller
{
    public function SetSymphonyDefaultConstantsValue(&$process_array, &$success_array)
    {
        RetriveConstantSettingValues($process_array, "ibox_constant_symphony_data");
        $breach_reason_no_breach_data                                           = BreachReason::where('breach_reason_no_breach_status', '=', 1)->get();
        if (isset($breach_reason_no_breach_data) && count($breach_reason_no_breach_data) > 0)
        {
            foreach ($breach_reason_no_breach_data as $row)
            {
                if ($row->id != "")
                {
                    $process_array["no_breach_list_names"][]                    = $row->reason_name;
                    $process_array["no_breach_list_ids"][]                      = $row->id;
                }
            }
        }
    }
    public function TriageCountOnEveryHourArrayConversionTargetTimes(&$array_return, $array_to_process, $index_val, $check_index,$min_check)
    {
        $temp_data_store                                        = array();
        for ($x = 0; $x < 24; $x++)
        {
            $array_return[$x][$index_val.'_patients_seen']                  = 0;
            $array_return[$x][$index_val.'_greater_than']                   = 0;
            $array_return[$x][$index_val.'_avg_time']                       = 0;
            $array_return[$x][$index_val.'_longer_time']                    = 0;
        }
        if (isset($array_to_process))
        {
            if (is_array($array_to_process))
            {
                if (count($array_to_process) > 0)
                {
                    foreach ($array_to_process as $row)
                    {
                        if (isset($row[$check_index]))
                        {
                            $time_get                           = date("H", strtotime($row[$check_index]));
                            $min_difference                     = TimeDifferenceInMinutes($row["symphony_registration_date_time"], $row[$check_index]);
                            if ($min_difference > 0)
                            {
                                $temp_data_store[$time_get][]   = $min_difference;
                            }
                        }
                    }
                }
            }
        }


        foreach ($array_return as $key => $row)
        {
            $key_temp               =   $row["hour"];
            if (isset($temp_data_store[$key_temp]))
            {

                $temp_greater_than                  = 0;
                foreach($temp_data_store[$key_temp] as $rqw)
                {
                    if($rqw > $min_check)
                    {
                        $temp_greater_than++;
                    }
                }
                if (is_array($temp_data_store[$key_temp]))
                {
                    $array_return[$key][$index_val.'_patients_seen']        =    count($temp_data_store[$key_temp]);
                    $array_return[$key][$index_val.'_longer_time']          =    number_format(max($temp_data_store[$key_temp]), 0, '.', '');
                    $array_return[$key][$index_val.'_avg_time']             =    number_format(array_sum($temp_data_store[$key_temp]) / count($temp_data_store[$key_temp]), 0, '.', '');
                    $array_return[$key][$index_val.'_greater_than']         =    $temp_greater_than;
                }
            }
        }
    }

    public function CountOnEveryHourArrayConversionBreaches(&$array_return, $array_to_process, $index_val, $process_array,$start_date_summary_process,$end_date_summary_process)
    {


        $start_time_n =  strtotime($start_date_summary_process);
        $end_time_n=  strtotime($end_date_summary_process);

        $temp_data_store                                    = array();
        $no_breach_list                                 = array();
        if (isset($process_array["no_breach_list_ids"]) && count($process_array["no_breach_list_ids"]) > 0)
        {
            $no_breach_list                             = $process_array["no_breach_list_ids"];
        }
        for ($x = 0; $x < 24; $x++)
        {
            $array_return[$x][$index_val]               = 0;
        }
        if (isset($array_to_process))
        {
            if (is_array($array_to_process))
            {
                if (count($array_to_process) > 0)
                {
                    foreach ($array_to_process as $row)
                    {
                        if (isset($row['symphony_estimated_breach_time']))
                        {
                            if (isset($row["breach_reason_update_id"]))
                            {
                                if ($row["breach_reason_update_id"] != null && $row["breach_reason_update_id"] != "")
                                {
                                    if (!in_array($row["breach_reason_update_id"], $no_breach_list))
                                    {
                                        $breach_time_n = strtotime($row['symphony_estimated_breach_time']);

                                        if($breach_time_n >= $start_time_n && $breach_time_n <= $end_time_n)
                                        {
                            
                                        $time_get                       = date("H", strtotime($row['symphony_estimated_breach_time']));
                                        $temp_data_store[$time_get][]   = $row;

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }




        foreach ($array_return as $key => $row)
        {
            $key_temp               =   $row["hour"];
            if (isset($temp_data_store[$key_temp]))
            {
                if (is_array($temp_data_store[$key_temp]))
                {
                    $array_return[$key][$index_val]     =   count($temp_data_store[$key_temp]);
                }
            }
        }
    }
    public function AdmittedDischargedBreachedArrayProcess($data_array_process, $process_array)
    {
        $return_array["admitted_patients"]              = array();
        $return_array["discharged_patients"]            = array();
        $return_array["breached_patients"]              = array();
        $no_breach_list                                 = array();
        $ibox_symphony_admitted_exclude_wards           = RetriveSpecificConstantSettingValues("ibox_symphony_admitted_patients_without_wards", "ibox_constant_symphony_data");
        if (isset($process_array["no_breach_list_ids"]) && count($process_array["no_breach_list_ids"]) > 0)
        {
            $no_breach_list                             = $process_array["no_breach_list_ids"];
        }
        if (!empty($data_array_process))
        {
            if (count($data_array_process) > 0)
            {
                foreach ($data_array_process as $row)
                {
                    if (isset($row["symphony_discharge_date"]))
                    {
                        if ($row["symphony_discharge_date"] != null)
                        {
                            if (isset($row["symphony_discharge_outcome_val"]))
                            {
                                if ($row["symphony_discharge_outcome_val"] == 0)
                                {
                                    $return_array["discharged_patients"][]                  = $row;
                                }
                                if ($row["symphony_discharge_outcome_val"] == 1)
                                {
                                    if (!in_array($row["symphony_discharge_ward"], $ibox_symphony_admitted_exclude_wards))
                                    {
                                        $return_array["admitted_patients"][]                    = $row;
                                    }
                                    else
                                    {
                                        $return_array["discharged_patients"][]                  = $row;
                                    }
                                }
                            }
                            if (isset($row["breach_reason_update_id"]))
                            {
                                if ($row["breach_reason_update_id"] != null && $row["breach_reason_update_id"] != "")
                                {
                                    if (!in_array($row["breach_reason_update_id"], $no_breach_list))
                                    {
                                        $return_array["breached_patients"][]                        = $row;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $return_array;
    }

    public function PatientAllSpecialityArrayProcess($data_array_process)
    {
        $return_array                           = array();
        if (!empty($data_array_process))
        {
            if (count($data_array_process) > 0)
            {
                foreach ($data_array_process as $row)
                {
                    if (isset($row["symphony_specialty"]) && $row["symphony_specialty"] != '')
                    {
                        $lower_spec                             = strtolower($row["symphony_specialty"]);
                        $return_array[$lower_spec][]            = $row;

                    }
                }
            }
        }
        return $return_array;
    }

    public function GetAnePatientCategorySplitUpArrayWithAllAtdTypesForSummary($data_array_process, &$process_array)
    {
        $return_array                                           = array();
        if (!empty($data_array_process))
        {
            if (count($data_array_process) > 0)
            {
                foreach ($data_array_process as $row)
                {
                    if (isset($row["symphony_atd_type"]) && $row["symphony_atd_type"] != '')
                    {
                        $lower_spec                             = strtolower($row["symphony_atd_type"]);
                        $return_array[$lower_spec][]            = $row;
                    }
                }
            }
        }
        return $return_array;
    }

    public function PatientsOnSpecificDateArrayProcess($data_array_process, $process_array, $column_check)
    {
        $return_array              = array();
        if (!empty($data_array_process))
        {
            if (count($data_array_process) > 0)
            {
                foreach ($data_array_process as $row)
                {
                    if (isset($row[$column_check]))
                    {
                        if ($row[$column_check] != null)
                        {
                            $check_date_column_processed =  date('Y-m-d', strtotime($row[$column_check]));
                            if ($process_array["ane_today_date_check"] ==  $check_date_column_processed)
                            {
                                $return_array[]              = $row;
                            }
                        }
                    }
                }
            }
        }
        return $return_array;
    }



    public function GetBreachedArrayProcessFrom240Minutes($data_array_process, $process_array)
    {
        $return_array                                       = array();
        $breach_time_seconds                                = $process_array["ed_breach_time_in_seconds"];
        if (!empty($data_array_process))
        {
            if (count($data_array_process) > 0)
            {
                foreach ($data_array_process as $row)
                {
                    if (isset($row["symphony_registration_date_time"])  && $row["symphony_registration_date_time"] != '' && isset($row["symphony_discharge_date"]) && $row["symphony_discharge_date"] != '')
                    {
                        $date_from                          = $row["symphony_registration_date_time"];
                        $date_to                            = $row["symphony_discharge_date"];
                        $seconds_difference                 = TimeDifferenceInSeconds($date_from, $date_to);
                        if ($seconds_difference > $breach_time_seconds)
                        {
                            $return_array[]                 = $row;
                        }
                    }
                }
            }
        }
        return $return_array;
    }
    public function CategorywiseAttendanceDetailsProcessArray($data_array_process, &$return_array, $process_array)
    {
        $patient_type_all                                                   = RetriveSpecificConstantSettingValues("ibox_symphony_main_patient_category", "ibox_constant_symphony_data");
        $return_array["total"]["arrived"]                                   = 0;
        $return_array["total"]["breach"]                                    = 0;
        $return_array["total"]["performance"]                               = 100;
        $return_array["total"]["performance_text_colour"]                   = "#129c4a";
        if (count($patient_type_all) > 0)
        {
            foreach ($patient_type_all as $ind_type)
            {
                $return_array[$ind_type]["arrived"]                         = 0;
                $return_array[$ind_type]["breach"]                          = 0;
                $return_array[$ind_type]["performance"]                     = 100;
                $return_array[$ind_type]["performance_text_colour"]         = "#129c4a";

                if (!isset($data_array_process[$ind_type]))
                {
                    $data_array_process[$ind_type]                          = array();
                }
                if (CheckCountArrayToProcess($data_array_process[$ind_type]))
                {
                    $breached_attendance_today                              = $this->GetBreachedArrayProcessFrom240Minutes($data_array_process[$ind_type], $process_array);
                    $return_array[$ind_type]["arrived"]                     = count($data_array_process[$ind_type]);
                    $return_array[$ind_type]["breach"]                      = count($breached_attendance_today);
                    $return_array[$ind_type]["performance"]                 = PerformanceCalculationAne(count($breached_attendance_today), count($data_array_process[$ind_type]), 0);
                    $return_array[$ind_type]["performance_text_colour"]     = PerformanceShowTextColourSetting($return_array[$ind_type]["performance"]);
                    $return_array["total"]["arrived"]                       = $return_array["total"]["arrived"] + $return_array[$ind_type]["arrived"];
                    $return_array["total"]["breach"]                        = $return_array["total"]["breach"] + $return_array[$ind_type]["breach"];
                }
            }
            $return_array["total"]["performance"]                           = PerformanceCalculationAne($return_array["total"]["breach"], $return_array["total"]["arrived"], 0);
            $return_array["total"]["performance_text_colour"]               = PerformanceShowTextColourSetting($return_array["total"]["performance"]);
        }
    }


    public function LocationWiseAttendanceDetailsProcessWithOthersArray($data_array_process, &$return_array, $process_array)
    {
        $patient_type_all                                                   = ["MiAMi", "Paeds","Resus","Ambulatory Majors","Majors"];
        $return_array["total"]["arrived"]                                   = 0;
        $return_array["total"]["breach"]                                    = 0;
        $return_array["total"]["performance"]                               = 100;
        $return_array["total"]["performance_text_colour"]                   = "#129c4a";

        $return_array["Majors"]["arrived"]                                   = 0;
        $return_array["Majors"]["breach"]                                    = 0;
        $return_array["Majors"]["performance"]                               = 100;
        $return_array["Majors"]["performance_text_colour"]                   = "#129c4a";

        $return_array['Others']["arrived"]                                  = 0;
        $return_array['Others']["breach"]                                   = 0;
        $return_array['Others']["performance"]                              = 100;
        $return_array['Others']["performance_text_colour"]                  = "#129c4a";

        if (count($patient_type_all) > 0)
        {
            foreach ($patient_type_all as $ind_type)
            {
                $return_array[$ind_type]["arrived"]                         = 0;
                $return_array[$ind_type]["breach"]                          = 0;
                $return_array[$ind_type]["performance"]                     = 100;
                $return_array[$ind_type]["performance_text_colour"]         = "#129c4a";
            }
        }
        $patient_category_array_to_process                                  = array();
        $patient_category_array_to_process['Others']                        = array();
        $patient_category_array_to_process['Majors']                        = array();

        if (count($data_array_process) > 0)
        {
            foreach ($data_array_process as $row_index => $row_val)
            {

                if (in_array($row_index, $patient_type_all))
                {
                    $patient_category_array_to_process[$row_index]          = $data_array_process[$row_index];
                }
                else
                {
                    if (strtolower($row_index) == 'majors' || strtolower($row_index) == 'ambulatory majors' || strtolower($row_index) == 'resus')
                    {
                        $patient_category_array_to_process['Majors']            = array_merge($patient_category_array_to_process['Majors'], $data_array_process[$row_index]);
                    }
                    else
                    {
                        $patient_category_array_to_process['Others']            = array_merge($patient_category_array_to_process['Others'], $data_array_process[$row_index]);
                    }
                }
            }
        }
        if (count($patient_category_array_to_process) > 0)
        {
            foreach ($patient_category_array_to_process as $ind_type => $val)
            {

                $breached_attendance_today                              = $this->GetBreachedArrayProcessFrom240Minutes($patient_category_array_to_process[$ind_type], $process_array);
                $return_array[$ind_type]["arrived"]                     = count($patient_category_array_to_process[$ind_type]);
                $return_array[$ind_type]["breach"]                      = count($breached_attendance_today);
                $return_array[$ind_type]["performance"]                 = PerformanceCalculationAne(count($breached_attendance_today), count($patient_category_array_to_process[$ind_type]), 0);
                $return_array[$ind_type]["performance_text_colour"]     = PerformanceShowTextColourSetting($return_array[$ind_type]["performance"]);
                $return_array["total"]["arrived"]                       = $return_array["total"]["arrived"] + $return_array[$ind_type]["arrived"];
                $return_array["total"]["breach"]                        = $return_array["total"]["breach"] + $return_array[$ind_type]["breach"];
            }
            $return_array["total"]["performance"]                           = PerformanceCalculationAne($return_array["total"]["breach"], $return_array["total"]["arrived"], 0);
            $return_array["total"]["performance_text_colour"]               = PerformanceShowTextColourSetting($return_array["total"]["performance"]);
        }
    }

    public function AttendanceSinceDateTimeDataProcess($data_array_process, $date_time_to_check, $column_index)
    {
        $return_array                                       = array();
        if ($date_time_to_check != "")
        {
            if (!empty($data_array_process))
            {
                if (count($data_array_process) > 0)
                {
                    foreach ($data_array_process as $row)
                    {
                        if (isset($row[$column_index]))
                        {
                            if ($row[$column_index] != null && $row[$column_index] != "")
                            {
                                if (strtotime($row[$column_index]) >= strtotime($date_time_to_check))
                                {
                                    $return_array[]             = $row;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $return_array;
    }
    public function StillInAnePatientsRetrieveArray($data_array_process)
    {
        $return_array                               = array();
        if (CheckCountArrayToProcess($data_array_process))
        {
            foreach ($data_array_process as $row)
            {
                if (isset($row["symphony_still_in_ae"]))
                {
                    if ($row["symphony_still_in_ae"] == 1)
                    {
                        $return_array[]                 = $row;
                    }
                }
            }
        }
        return $return_array;
    }
    public function AneTimeSeriesDataProcess($data_array_process, &$return_array, &$process_array)
    {
        $data_array                                     = array();
        $data_array["green_data_array"]                 = array();
        $data_array["yellow_data_array"]                = array();
        $data_array["orange_data_array"]                = array();
        $data_array["red_data_array"]                   = array();
        $data_array["purple_data_array"]                = array();
        $return_array["green_time"]                     = "00:00 To 01:29";
        $return_array["green_value"]                    = 0;
        $return_array["yellow_time"]                    = "01:30 To 02:59";
        $return_array["yellow_value"]                   = 0;
        $return_array["orange_time"]                    = "03:00 To 03:59";
        $return_array["orange_value"]                   = 0;
        $return_array["red_time"]                       = "04:00 To 11:59";
        $return_array["red_value"]                      = 0;
        $return_array["purple_time"]                    = "12+";
        $return_array["purple_value"]                   = 0;
        $return_array["total"]                          = 0;
        $total                                          = 0;
        if (!empty($data_array_process))
        {
            if (count($data_array_process) > 0)
            {
                foreach ($data_array_process as $row)
                {
                    if (isset($row["minutes"]))
                    {
                        $minutes_difference                        = $row["minutes"];
                        if ($minutes_difference >= 720)
                        {
                            $data_array["purple_data_array"][]     = $row;
                        }
                        elseif ($minutes_difference >= 240)
                        {
                            $data_array["red_data_array"][]        = $row;
                        }
                        elseif ($minutes_difference >= 180)
                        {
                            $data_array["orange_data_array"][]     = $row;
                        }
                        elseif ($minutes_difference >= 90)
                        {
                            $data_array["yellow_data_array"][]     = $row;
                        }
                        elseif ($minutes_difference >= 0)
                        {
                            $data_array["green_data_array"][]      = $row;
                        }
                        $total++;
                    }
                }
            }
        }
        $return_array["green_value"]            =   count($data_array["green_data_array"]);
        $return_array["yellow_value"]           =   count($data_array["yellow_data_array"]);
        $return_array["orange_value"]           =   count($data_array["orange_data_array"]);
        $return_array["red_value"]              =   count($data_array["red_data_array"]);
        $return_array["purple_value"]           =   count($data_array["purple_data_array"]);
        $return_array["total"]                  =   $total;
    }

    
    public function AmbulanceWalkinArrayProcess($data_array_process)
    {
        $ambulance_parameter                    = RetriveSpecificConstantSettingValues("ibox_symphony_ambulance_parameter", "ibox_constant_symphony_data");
        $return_array["ambulance_arrival"]      = array();
        $return_array["walkin_arrival"]         = array();
        if (!empty($data_array_process))
        {
            if (count($data_array_process) > 0)
            {
                foreach ($data_array_process as $row)
                {
                    if (isset($row["symphony_arrival_mode"]))
                    {
                        if (in_array($row["symphony_arrival_mode"], $ambulance_parameter))
                        {
                            $return_array["ambulance_arrival"][] = $row;
                        }
                        else
                        {
                            $return_array["walkin_arrival"][] = $row;
                        }
                    }
                    else
                    {
                        $return_array["walkin_arrival"][] = $row;
                    }
                }
            }
        }
        return $return_array;
    }

    public function PatientSpecialityArrayProcess($data_array_process)
    {
        $speciality_grouping                    = RetriveSpecificConstantSettingValues("ibox_symphony_main_specialities_grouping", "ibox_constant_symphony_data");
        $return_array                           = array();
        if (count($speciality_grouping))
        {
            foreach ($speciality_grouping as $key => $val)
            {
                $return_array[$val]             = array();
            }
            $return_array['others']             = array();
        }
        if (!empty($data_array_process))
        {
            if (count($data_array_process) > 0)
            {
                foreach ($data_array_process as $row)
                {
                    if (isset($row["symphony_specialty"]) && $row["symphony_specialty"] != '')
                    {
                        $lower_spec                             = strtolower($row["symphony_specialty"]);
                        if (isset($return_array[$lower_spec]))
                        {
                            $return_array[$lower_spec][]        = $row;
                        }
                        else
                        {
                            $return_array['others'][]           = $row;
                        }
                    }
                }
            }
        }
        return $return_array;
    }




    public function BoxPlotValueSetFromArray(&$return_array, $data_array_process, $index_process, $date_from_index, $date_to_index)
    {

        $return_array[$index_process]["box_plot_maximum"]                       = 0;
        $return_array[$index_process]["box_plot_minimum"]                       = 0;
        $return_array[$index_process]["box_plot_median"]                        = 0;
        $return_array[$index_process]["box_plot_upper_quartile"]                = 0;
        $return_array[$index_process]["box_plot_lower_quartile"]                = 0;
        $return_array[$index_process]["box_plot_average_time"]                  = "";

        $date_time_now                                                          = CurrentDateOnFormat();
        $temp_array_minute_difference                                           = array();
        if (count($data_array_process) > 0)
        {
            foreach ($data_array_process as $row)
            {
                if (isset($row[$date_from_index]))
                {
                    $date_from                              = $row[$date_from_index];
                    $date_to                                = $date_time_now;
                    if (isset($row[$date_to_index]))
                    {
                        if ($row[$date_to_index] != null && $row[$date_to_index] != "")
                        {
                            $date_to                        = $row[$date_to_index];
                        }
                    }
                    $minutes_difference                     = TimeDifferenceInMinutes($date_from, $date_to);
                    $temp_array_minute_difference[]         = $minutes_difference;
                }
            }
        }
        if (count($temp_array_minute_difference) > 0)
        {
            $return_array[$index_process]["box_plot_maximum"] = NumberFormatCustom(max($temp_array_minute_difference), 0);
            $return_array[$index_process]["box_plot_minimum"] = NumberFormatCustom(min($temp_array_minute_difference), 0);
            $return_array[$index_process]["box_plot_median"] = NumberFormatCustom(round(array_sum($temp_array_minute_difference) / count($temp_array_minute_difference)), 0);
            $return_array[$index_process]["box_plot_upper_quartile"] = NumberFormatCustom(round(($return_array[$index_process]["box_plot_maximum"]  + $return_array[$index_process]["box_plot_median"]) / 2), 0);
            $return_array[$index_process]["box_plot_lower_quartile"] = NumberFormatCustom(round(($return_array[$index_process]["box_plot_minimum"] + $return_array[$index_process]["box_plot_median"]) / 2), 0);
            $return_array[$index_process]["box_plot_average_time"] = ConvertMinutesToHourMinutesWithTextFormated($return_array[$index_process]["box_plot_median"]);
        }
    }
    public function AneEdOverviewTimeSeriesDataProcess($data_array_process, &$return_array, &$process_array)
    {
        $data_array                                     = array();
        $data_array["green_data_array"]                 = array();
        $data_array["yellow_data_array"]                = array();
        $data_array["orange_data_array"]                = array();
        $data_array["red_data_array"]                   = array();
        $data_array["purple_data_array"]                = array();


        $return_array["green_time"]                     = "00:00 To 01:29";
        $return_array["green_value"]                    = 0;
        $return_array["yellow_time"]                    = "01:30 To 03:29";
        $return_array["yellow_value"]                   = 0;
        $return_array["orange_time"]                    = "03:30 To 03:59";
        $return_array["orange_value"]                   = 0;
        $return_array["red_time"]                       = "04:00 To 11.59";
        $return_array["red_value"]                      = 0;
        $return_array["purple_time"]                    = "12+";
        $return_array["purple_value"]                   = 0;
        $return_array["total"]                          = 0;

        $total                                          = 0;
        if (!empty($data_array_process))
        {
            if (count($data_array_process) > 0)
            {
                foreach ($data_array_process as $row)
                {
                    if (isset($row["symphony_registration_date_time"]))
                    {
                        $date_from                          = $row["symphony_registration_date_time"];
                        $date_to                            = $process_array["date_time_now"];
                        if (isset($row["symphony_discharge_date"]))
                        {
                            if ($row["symphony_discharge_date"] != null)
                            {
                                $date_to                    = $row["symphony_discharge_date"];
                            }
                        }
                        $minutes_difference                 = TimeDifferenceInMinutes($date_from, $date_to);
                        if ($minutes_difference >= 0 && $minutes_difference < 90) {
                            $data_array["green_data_array"][] = $row;
                        } elseif ($minutes_difference >= 90 && $minutes_difference < 210) {
                            $data_array["yellow_data_array"][] = $row;
                        } elseif ($minutes_difference >= 210 && $minutes_difference < 240) {
                            $data_array["orange_data_array"][] = $row;
                        } elseif ($minutes_difference >= 240 && $minutes_difference < 720) {
                            $data_array["red_data_array"][] = $row;
                        } else {
                            $data_array["purple_data_array"][] = $row;
                        }
                        $total++;
                    }
                }
            }
        }
        $return_array["green_value"]            =   count($data_array["green_data_array"]);
        $return_array["yellow_value"]           =   count($data_array["yellow_data_array"]);
        $return_array["orange_value"]           =   count($data_array["orange_data_array"]);
        $return_array["red_value"]              =   count($data_array["red_data_array"]);
        $return_array["purple_value"]           =   count($data_array["purple_data_array"]);
        $return_array["total"]                  =   $total;
    }
    public function CountOnEveryHourArrayConversionInEdData(&$array_return, $array_to_process, $index_val, $check_index, $start_date)
    {
        $temp_data_store                                    = array();
        for ($x = 0; $x < 24; $x++)
        {
            $array_return[$x][$index_val]               = 0;
        }
        if (isset($array_to_process))
        {
            if (is_array($array_to_process))
            {
                if (count($array_to_process) > 0)
                {
                    foreach ($array_to_process as $row)
                    {
                        if (isset($row[$check_index]))
                        {
                            for ($x = 0; $x < 24; $x++)
                            {
                                if ($x < 10)
                                {
                                    $time_check                         = "0" . $x;
                                }
                                else
                                {
                                    $time_check                         = $x;
                                }
                                $check_last_date_time                   = "";
                                if (isset($row["symphony_discharge_date"]))
                                {
                                    if ($row["symphony_discharge_date"] != null && $row["symphony_discharge_date"] != "")
                                    {
                                        $check_last_date_time           = $row["symphony_discharge_date"];
                                    }
                                }
                                if ($check_last_date_time == "")
                                {
                                    $check_last_date_time               = date("Y-m-d H:i:s");
                                }
                                $request_date_hour                      = date("H", strtotime($row[$check_index]));
                                if ((int)$request_date_hour <= (int)$time_check)
                                {
                                    $date_create_to_check               = date('Y-m-d H:i:s', strtotime($start_date . "+$x hour"));
                                    if (strtotime($date_create_to_check) <= strtotime($check_last_date_time))
                                    {
                                        $temp_data_store[$time_check][] = $row;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach ($array_return as $key => $row)
        {
            $key_temp               =   $row["hour"];
            if (isset($temp_data_store[$key_temp]))
            {
                if (is_array($temp_data_store[$key_temp]))
                {
                    $array_return[$key][$index_val]     =   count($temp_data_store[$key_temp]);
                }
            }
        }
    }
    public function CountOnEveryHourArrayConversionStillInEd(&$array_return, $array_to_process, $index_val, $start_date, $end_date)
    {
        $temp_data_store                            = array();
        $start_check_date                           = date('Y-m-d', strtotime($start_date));
        for ($x = 0; $x < 24; $x++)
        {
            $array_return[$x][$index_val] = 0;
        }


        if (isset($array_to_process))
        {
            if (is_array($array_to_process))
            {
                if (count($array_to_process) > 0)
                {
                    foreach ($array_to_process as $row)
                    {

                        $reg_check_time                             = strtotime($row["symphony_registration_date_time"]);
                        $dis_check_time                             = strtotime($end_date);
                        if (isset($row["symphony_discharge_date"]) && $row["symphony_discharge_date"] != '' && $row["symphony_discharge_date"] != null)
                        {
                            $dis_check_time                         = strtotime($row["symphony_discharge_date"]);
                        }
                        for ($xc = 0; $xc < 24; $xc++)
                        {
                            $check_date_start_time                  = strtotime(date('Y-m-d H:00:00', strtotime($start_check_date . " + $xc hour")));
                            $check_date_end_time                    = strtotime(date('Y-m-d H:59:59', strtotime($start_check_date . " + $xc hour")));


                            $check_real_time                         = strtotime(date('Y-m-d H:59:59'));
                            $check_real_time_compare                 = strtotime(date('Y-m-d H:00:00', $check_date_end_time));

                            if ($reg_check_time <= $check_date_end_time && $dis_check_time >= $check_date_start_time && $check_real_time >= $check_real_time_compare)
                            {
                                $key                                = (int) date('H', $check_date_start_time);
                                $array_return[$key][$index_val]     = $array_return[$key][$index_val] + 1;
                            }
                        }
                    }
                }
            }
        }
    }

    public function CountOnEveryHourArrayConversionTargetTimes(&$array_return, $array_to_process, $index_val, $check_index,$min_check)
    {
        $temp_data_store                                        = array();
        for ($x = 0; $x < 24; $x++)
        {
            $array_return[$x]['patients_seen']                  = 0;
            $array_return[$x]['greater_than']                   = 0;
            $array_return[$x]['avg_time']                       = 0;
            $array_return[$x]['longer_time']                    = 0;
        }
        if (isset($array_to_process))
        {
            if (is_array($array_to_process))
            {
                if (count($array_to_process) > 0)
                {
                    foreach ($array_to_process as $row)
                    {
                        if (isset($row[$check_index]))
                        {
                            $time_get                           = date("H", strtotime($row[$check_index]));
                            $min_difference                     = TimeDifferenceInMinutes($row["symphony_registration_date_time"], $row[$check_index]);
                            if ($min_difference > 0)
                            {
                                $temp_data_store[$time_get][]   = $min_difference;
                            }
                        }
                    }
                }
            }
        }


        foreach ($array_return as $key => $row)
        {
            $key_temp               =   $row["hour"];
            if (isset($temp_data_store[$key_temp]))
            {

                $temp_greater_than                  = 0;
                foreach($temp_data_store[$key_temp] as $rqw)
                {
                    if($rqw > $min_check)
                    {
                        $temp_greater_than++;
                    }
                }
                if (is_array($temp_data_store[$key_temp]))
                {
                    $array_return[$key]['patients_seen']        =    count($temp_data_store[$key_temp]);
                    $array_return[$key]['longer_time']          =    number_format(max($temp_data_store[$key_temp]), 0, '.', '');
                    $array_return[$key]['avg_time']             =    number_format(array_sum($temp_data_store[$key_temp]) / count($temp_data_store[$key_temp]), 0, '.', '');
                    $array_return[$key]['greater_than']         =    $temp_greater_than;
                }
            }
        }
    }


    public function AverageTimeOnEveryHourArrayConversion(&$array_return, $array_to_process, $index_val, $check_index)
    {
        $temp_data_store                                        = array();
        for ($x = 0; $x < 24; $x++)
        {
            $array_return[$x][$index_val]                       = 0;
        }
        if (isset($array_to_process))
        {
            if (is_array($array_to_process))
            {
                if (count($array_to_process) > 0)
                {
                    foreach ($array_to_process as $row)
                    {
                        if (isset($row[$check_index]))
                        {
                            $time_get                           = date("H", strtotime($row[$check_index]));
                            $min_difference                     = TimeDifferenceInMinutes($row["symphony_registration_date_time"], $row[$check_index]);


                            if ($min_difference > 0)
                            {
                                $temp_data_store[$time_get][]   = $min_difference;
                            }
                        }
                    }
                }
            }
        }
        foreach ($array_return as $key => $row)
        {
            $key_temp               =   $row["hour"];
            if (isset($temp_data_store[$key_temp]))
            {
                if (is_array($temp_data_store[$key_temp]))
                {
                    $array_return[$key][$index_val]     =    number_format(array_sum($temp_data_store[$key_temp]) / count($temp_data_store[$key_temp]), 0, '.', '');
                }
            }
        }
    }

    public function CountOnEveryHourArrayConversionMaxValEdProfile(&$array_return, $array_to_process, $index_val)
    {
        for ($x = 0; $x < 24; $x++)
        {
            $array_return[$x][$index_val]                   = 0;
        }

        if (isset($array_to_process))
        {
            if (is_array($array_to_process))
            {
                if (count($array_to_process) > 0)
                {
                    foreach ($array_to_process as $row)
                    {
                        if (isset($row['key']) && $row['key'] == $index_val)
                        {
                            if ($row['hour'] >= 0 && $row['hour']  <= 23)
                            {
                                $array_return[$row['hour']][$index_val]   = $row["val"];
                            }
                        }
                    }
                }
            }
        }
    }


    public function CountOnEveryHourArrayConversionMaxVal(&$array_return, $array_to_process, $index_val, $check_index)
    {
        $temp_data_store                                    = array();
        for ($x = 0; $x < 24; $x++)
        {
            $array_return[$x][$index_val]                   = 0;
        }

        if (isset($array_to_process))
        {
            if (is_array($array_to_process))
            {
                if (count($array_to_process) > 0)
                {
                    foreach ($array_to_process as $row)
                    {
                        if (isset($row[$check_index]))
                        {
                            $time_get                       = date("H", strtotime($row[$check_index]));
                            $temp_data_store[$time_get][]   = $row["symphony_ed_history_value"];
                        }
                    }
                }
            }
        }

        foreach ($array_return as $key => $row)
        {
            $key_temp               =   $row["hour"];
            if (isset($temp_data_store[$key_temp]))
            {
                if (is_array($temp_data_store[$key_temp]))
                {
                    $array_return[$key][$index_val]     =   max($temp_data_store[$key_temp]);
                }
            }
        }
    }
    public function GetAnePatientCategorySplitUpArrayWithAtdTypes($data_array_process, &$process_array)
    {
        $attendance_main        = $process_array['ibox_symphony_main_patient_category'];
        $attendance_ed          = $process_array['ibox_symphony_main_patient_category_ed'];


        $process_array['attendance_arr']['attendance_main']     = array();
        $process_array['attendance_arr']['attendance_ed']       = array();

        if (count($data_array_process) > 0)
        {
            foreach ($data_array_process as $row)
            {
                if (in_array($row['symphony_atd_type'], $attendance_main))
                {
                    $process_array['attendance_arr']['attendance_main'][]   = $row;
                }

                if (in_array($row['symphony_atd_type'], $attendance_ed))
                {
                    $process_array['attendance_arr']['attendance_ed'][]   = $row;
                }
            }
        }
    }
    public function GetAnePatientCategorySplitUpArrayWithAllAtdTypes($data_array_process, &$process_array)
    {
        $attendance_main                        = $process_array['ibox_symphony_main_patient_category'];
        $return_array                           = array();
        if (count($attendance_main))
        {
            foreach ($attendance_main as $val)
            {
                $return_array[$val]             = array();
            }
            $return_array['others']             = array();
        }
        if (!empty($data_array_process))
        {
            if (count($data_array_process) > 0)
            {
                foreach ($data_array_process as $row)
                {
                    if (isset($row["symphony_atd_type"]) && $row["symphony_atd_type"] != '')
                    {
                        $lower_spec                             = $row["symphony_atd_type"];
                        if (isset($return_array[$lower_spec]))
                        {
                            $return_array[$lower_spec][]        = $row;
                        }
                        else
                        {
                            $return_array['others'][]           = $row;
                        }
                    }
                }
            }
        }
        return $return_array;
    }








    public function GetAttendancePatientTimeInDepartment($data_array_process, &$process_array)
    {
        $return_array                                           = array();
        $return_array['hour_240']                               = array();
        $return_array['hour_180']                               = array();
        $return_array['hour_120']                               = array();
        $return_array['hour_60']                                = array();
        $return_array['hour_0']                                 = array();
        if (!empty($data_array_process))
        {
            if (count($data_array_process) > 0)
            {
                foreach ($data_array_process as $row)
                {
                    $time_in_department                         = ValuePresentThenSetForVariable($row, "symphony_registration_date_time", 3, "symphony_discharge_date");
                    if ($time_in_department > 240)
                    {
                        $return_array['hour_240'][]             = $row;
                    }
                    else if ($time_in_department > 180)
                    {
                        $return_array['hour_180'][]             = $row;
                    }
                    else if ($time_in_department > 120)
                    {
                        $return_array['hour_120'][]             = $row;
                    }
                    else if ($time_in_department > 60)
                    {
                        $return_array['hour_60'][]              = $row;
                    }
                    else
                    {
                        $return_array['hour_0'][]               = $row;
                    }
                }
            }
        }
        return $return_array;
    }















    public function GetAneMainPatientCategoryReplace($replace_name, $process_array)
    {
        $category_name      = $process_array['ibox_symphony_main_patient_category_with_index'];
        if (isset($category_name[$replace_name]))
        {
            return $category_name[$replace_name];
        }
        else
        {
            return ucwords($replace_name);
        }
    }
    public function AmbulanceHourDifferenceCountTwelve($data_array_process)
    {
        $return_array                           = array();
        for ($x = 1; $x <= 12; $x++)
        {
            $y                                  = $x;
            if ($x == 12)
            {
                $y                              = $x . "+";
            }
            $return_array[$y]                   = 0;
        }
        $date_time_now                          = CurrentDateOnFormat();
        if (isset($data_array_process))
        {
            if (is_array($data_array_process))
            {
                if (count($data_array_process) > 0)
                {
                    foreach ($data_array_process as $row)
                    {
                        if (isset($row["symphony_registration_date_time"]))
                        {
                            $date_from                              = $row["symphony_registration_date_time"];
                            $date_to                                = $date_time_now;
                            if (isset($row["symphony_discharge_date"]))
                            {
                                if ($row["symphony_discharge_date"] != null)
                                {
                                    $date_to                        = $row["symphony_discharge_date"];
                                }
                            }
                            $hour_difference                        = TimeDifferenceInHourUpperLimit($date_from, $date_to);
                            if ($hour_difference != 0)
                            {
                                if ($hour_difference >= 12)
                                {
                                    $return_array["12+"]               = $return_array["12+"] + 1;
                                }
                                else
                                {
                                    $return_array[$hour_difference] = $return_array[$hour_difference] + 1;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $return_array;
    }


    public function countCasesByHourAndSpecialty($data_array_process)
    {
        $return_array = array(
            'ED_zero_to_four' => 0,
            'ED_four_to_eight' => 0,
            'ED_eight_to_twelve' => 0,
            'ED_twelve_to_twenty_four' => 0,
            'ED_twenty_four_plus' => 0,
            'UTC_zero_to_four' => 0,
            'UTC_four_to_eight' => 0,
            'UTC_eight_to_twelve' => 0,
            'UTC_twelve_to_twenty_four' => 0,
            'UTC_twenty_four_plus' => 0
        );

        if (count($data_array_process) > 0)
        {
            foreach ($data_array_process as $row)
            {
                if (isset($row['symphony_discharge_date']) && $row['symphony_discharge_date'] != null)
                {
                    $time_diff_min           = TimeDifferenceInMinutes($row['symphony_arrival_date'], $row['symphony_discharge_date']);
                    if ($time_diff_min > 1440)
                    {
                        $return_array[$row['symphony_atd_type'] . '_twenty_four_plus'] = $return_array[$row['symphony_atd_type'] . '_twenty_four_plus'] + 1;
                    }
                    elseif ($time_diff_min > 720)
                    {
                        $return_array[$row['symphony_atd_type'] . '_twelve_to_twenty_four'] = $return_array[$row['symphony_atd_type'] . '_twelve_to_twenty_four'] + 1;
                    }
                    elseif ($time_diff_min > 480)
                    {
                        $return_array[$row['symphony_atd_type'] . '_eight_to_twelve'] = $return_array[$row['symphony_atd_type'] . '_eight_to_twelve'] + 1;
                    }
                    elseif ($time_diff_min > 240)
                    {
                        $return_array[$row['symphony_atd_type'] . '_four_to_eight'] = $return_array[$row['symphony_atd_type'] . '_four_to_eight'] + 1;
                    }
                    else
                    {
                        $return_array[$row['symphony_atd_type'] . '_zero_to_four'] = $return_array[$row['symphony_atd_type'] . '_zero_to_four'] + 1;
                    }
                }
            }
        }
        return $return_array;
    }
}
