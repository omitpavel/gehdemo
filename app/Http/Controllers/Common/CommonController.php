<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Common\IboxSettings;
use App\Models\Common\FlashMessage;
use App\Models\Common\User;
use App\Models\Iboards\Symphony\Master\BreachReason;
use Exception;

class CommonController extends Controller
{

    public function SetDefaultConstantsValue(&$process_array, &$success_array)
    {
        $process_array["date_time_now"]                                         = CurrentDateOnFormat();
        $success_array["date_time_now"]                                         = CurrentDateOnFormat();
        $success_array["script_error_message"]                                  = ErrorOccuredMessage();

        GetWeekDaysNames($process_array);
        RetriveConstantSettingValues($process_array, "ibox_constant_database_names");
        RetriveConstantSettingValues($process_array, "ibox_constant_default_setting_values");
        $success_array['ibox_tab_switch_refresh_time']                          = $process_array['ibox_tab_switch_refresh_time'];
        // Get Top Marquee Scroll Message
        $this->GetPageHeadFlashMessageScrollContent($process_array, $success_array);
        $ibox_constant_array     = IboxSettings::get();
        if (count($ibox_constant_array) > 0)
        {
            foreach ($ibox_constant_array  as $row)
            {

                if ($row->description_type == 1)
                {
                    $process_array[$row->key_value] = (int)$row->description;
                }
                elseif ($row->description_type == 2)
                {
                    $process_array[$row->key_value] = $row->description;
                }
                elseif ($row->description_type == 3)
                {
                    $des_array = json_decode($row->description, true);
                    $data_array = array();

                    foreach ($des_array as $key => $val)
                    {
                        $data_array[$key] = $val;
                    }

                    $process_array[$row->key_value] =  $data_array;
                }
            }
        }
    }

    public function GetPageHeadFlashMessageScrollContent(&$process_array, &$success_array)
    {
        $flash_message                                                          = FlashMessage::first();
        $success_array["flash_message_to_show"]                                 = "";
        if ($flash_message)
        {
            if (isset($flash_message->message) && $flash_message->status == 1)
            {
                $success_array["flash_message_to_show"]                         = $flash_message->message;
            }
        }
    }

    /************************************************** IBOX SETTINGS FUNCTIONS STARTS **************************************************/
    public function DnsNameCheckIfEnabled($ip)
    {
        $default_val                =   RetriveSpecificConstantSettingValues('ibox_dns_name_check_enable_status', "ibox_constant_default_setting_values");
        if ($default_val == 1)
        {
            try
            {
                if ($ip != "")
                {
                    $output         = shell_exec("ping -n 1 -a $ip");
                    $dns_name_arr   = explode(" ", $output);
                    if (isset($dns_name_arr[1]))
                    {
                        return  $dns_name_arr[1];
                    }
                }
            }
            catch (Exception $e)
            {
                return "";
            }
        }
        return "";
    }


    public function GettingAutoSetAdminDetails(&$process_array)
    {
        // Auto Set User Details
        $auto_set_admin_id                                                      = RetriveSpecificConstantSettingValues('ibox_auto_set_admin_id', "ibox_constant_default_setting_values");
        $user_det                                                               = User::where('id', $auto_set_admin_id)->first();
        $process_array["auto_set_admin_name"]                                   = $user_det->username;
        $process_array["auto_set_admin_id"]                                     = $user_det->id;
    }


    /************************************************** IBOX SETTINGS FUNCTIONS ENDS **************************************************/



    public function ArrayColumnCategoryWiseGrouping($data_array_process, $column_index)
    {
        $return_array                                                       = array();
        if (count($data_array_process) > 0)
        {
            foreach ($data_array_process as $row)
            {
                if (isset($row[$column_index]))
                {
                    if ($row[$column_index] != null && $row[$column_index] != "")
                    {
                        $return_array[$row[$column_index]][]           = $row;
                    }
                }
            }
        }
        return $return_array;
    }

    public function ArrayColumnCategoryWiseGroupingPresentingComplaint($data_array_process, $column_index)
    {
        $return_array                                                       = array();
        if (count($data_array_process) > 0)
        {
            foreach ($data_array_process as $row)
            {
                if (isset($row[$column_index]))
                {

                    $row[$column_index]                                 = strtolower(trim($row[$column_index]));
                    if ($row[$column_index] != null && $row[$column_index] != "")
                    {
                        $return_array[$row[$column_index]][]           = $row;
                    }
                }
            }
        }
        return $return_array;
    }


    public function ArrayFindInBetweenDateTimeOfFields($data_array_process, $start_date, $end_date, $field_index)
    {
        $return_array                                       = array();
        $start_time                                         = strtotime($start_date);
        $end_time                                           = strtotime($end_date);

        if (CheckCountArrayToProcess($data_array_process))
        {
            foreach ($data_array_process as $row)
            {
                if (isset($row[$field_index]) && $row[$field_index] != '' && $row[$field_index] != null)
                {
                    $check_date_time                        = strtotime($row[$field_index]);
                    if ($start_time <=  $check_date_time && $check_date_time <= $end_time)
                    {
                        $return_array[]                     = $row;
                    }
                }
            }
        }
        return $return_array;
    }


    public function CountOnEveryHourAddPrimaryHour(&$array_to_process)
    {
        for ($x = 0; $x < 24; $x++)
        {
            $array_to_process[$x]["hour"]               = ($x < 10) ? "0" . $x : "" . $x;
        }
    }
    public function ArrayFindInBetweenDateTimeOfFieldsOnCriteria($data_array_process, $start_date, $end_date, $field_index, $compare_val)
    {
        $return_array                                       = array();
        $start_time                                         = strtotime($start_date);
        $end_time                                           = strtotime($end_date);

        if (CheckCountArrayToProcess($data_array_process))
        {
            foreach ($data_array_process as $row)
            {
                if (isset($row[$field_index]) && $row[$field_index] != '' && $row[$field_index] != null)
                {
                    $check_date_time                        = strtotime($row[$field_index]);
                    if ($start_time <=  $check_date_time && $check_date_time <= $end_time)
                    {
                        $minute_diff                                = 0;
                        $minute_diff                                = TimeDifferenceInMinutes($row['symphony_registration_date_time'], $row[$field_index]);
                        if ($minute_diff > $compare_val)
                        {
                            $return_array[]                     = $row;
                        }
                    }
                }
            }
        }
        return $return_array;
    }

    public function CountOnEveryHourArrayConversion(&$array_return, $array_to_process, $index_val, $check_index)
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
                            $time_get                       = date("H", strtotime($row[$check_index]));
                            $temp_data_store[$time_get][]   = $row;
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


    public function CountOnEveryHourArrayConversionYearAverage(&$array_return, $index_val, $avearge_val)
    {
        foreach ($array_return as $key => $row)
        {
            if (isset($array_return[$key][$index_val]))
            {
                if ($array_return[$key][$index_val] != 0)
                {
                    $array_return[$key][$index_val] = number_format(($array_return[$key][$index_val] / $avearge_val), 0, '.', '');
                }
            }
        }
    }

    public function HourCalculation($hourDifference)
    {
        $zeroToFour = 0;
        $fourToEight = 0;
        $eightToTweleve = 0;
        $tweleveToTwentyFour = 0;
        $twentyFourPlus = 0;
        if ($hourDifference >= 0 && $hourDifference <= 4)
        {
            $zeroToFour++;
        }
        elseif ($hourDifference > 4 && $hourDifference <= 8)
        {
            $fourToEight++;
        }
        elseif ($hourDifference > 8 && $hourDifference <= 12)
        {
            $eightToTweleve++;
        }
        elseif ($hourDifference > 12 && $hourDifference <= 24)
        {
            $tweleveToTwentyFour++;
        }
        elseif ($hourDifference > 24)
        {
            $twentyFourPlus++;
        }
    }


    public function calculateHourDifference($arrivalDate, $dischargeDate)
    {
        $arrivalDateTime = Carbon::parse($arrivalDate);
        $dischargeDateTime = Carbon::parse($dischargeDate);
        $interval = $arrivalDateTime->diff($dischargeDateTime);
        return $interval->h; // Difference in hours
    }




    public function IndexCategoryFindSumDetailsProcessArray($data_array_process, $index_check)
    {
        $return_array                                                        = array();

        if (count($data_array_process) > 0)
        {
            foreach ($data_array_process as $row)
            {

                //                // Calculate the difference in hours


                if (!isset($return_array[$row[$index_check]]))
                {
                    $return_array[$row[$index_check]]                = 1;
                }
                else
                {
                    $return_array[$row[$index_check]]++;
                }
            }
        }
        return $return_array;
    }

    public function ValuePresentThenSetForVariableCheckColour($process_value, $data_check)
    {
        $return_value                           = "";
        if (isset($process_value))
        {
            if ($process_value != "")
            {
                $return_value                           = "breach-popup-colour-00b300";
                if ($process_value > $data_check)
                {
                    $return_value               = "breach-popup-colour-FF0000";
                }
            }
        }
        return $return_value;
    }

    public function DifferenceBetweenTwoTimesFromArray($data_array_process, &$return_array, $date_from_index, $date_to_index)
    {
        $date_time_now                                                          = CurrentDateOnFormat();


        if (CheckCountArrayToProcess($data_array_process))
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
                    $return_array[]                         = $minutes_difference;
                }
            }
        }
    }

    public function ValuePresentThenSetForVariableCheckLarger($process_value, $data_check, $process_return)
    {
        $return_value               = $process_return;
        if (isset($process_value))
        {
            if ($process_value != "")
            {
                if ($process_value > $data_check)
                {
                    $return_value   = $process_value - $data_check;
                }
            }
        }
        return $return_value;
    }

    public function CountOnEveryHourArrayConversionDirectWeek(&$array_return, $array_to_process, $check_index)
    {
        $temp_data_store                                    = array();
        $start                                              = date("Y-m-d", strtotime('monday this week'));
        for ($x = 0; $x < 7; $x++)
        {
            $st_date                                        = date("D", strtotime(" + $x days", strtotime($start)));
            $array_return[$st_date]                         = 0;
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
                            $time_get                       = date("D", strtotime($row[$check_index]));
                            $temp_data_store[$time_get][]   = $row;
                        }
                    }
                }
            }
        }

        foreach ($array_return as $key => $row)
        {
            $key_temp               =   $key;
            if (isset($temp_data_store[$key_temp]))
            {
                if (is_array($temp_data_store[$key_temp]))
                {
                    $array_return[$key]     =   count($temp_data_store[$key_temp]);
                }
            }
        }
    }

    public function CountOnEveryHourArrayConversionDirectHour(&$array_return, $array_to_process, $check_index)
    {
        $temp_data_store                                    = array();
        for ($x = 0; $x < 24; $x++)
        {
            if ($x < 10)
            {
                $y            = "0" . $x;
            }
            else
            {
                $y            = "" . $x;
            }

            $array_return[$y]              = 0;
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


                            $temp_data_store[$time_get][]   = $row;
                        }
                    }
                }
            }
        }

        foreach ($array_return as $key => $row)
        {
            $key_temp               =   $key;
            if (isset($temp_data_store[$key_temp]))
            {
                if (is_array($temp_data_store[$key_temp]))
                {
                    $array_return[$key]     =   count($temp_data_store[$key_temp]);
                }
            }
        }
    }

    public function CalculateFinancialFromMonthFinancialYearStartDate($check_date_cal)
    {
        $return_string = date("Y-04-01", strtotime($check_date_cal));
        $check_string_month = date("m", strtotime($check_date_cal));
        if ($check_string_month == "01" || $check_string_month == "02" || $check_string_month == "03")
        {
            $return_string = date("Y-04-01", strtotime($check_date_cal . " -1 year"));
        }
        else
        {
            $return_string = date("Y-04-01", strtotime($check_date_cal));
        }

        return $return_string;
    }

    public function CalculateQuaterFromMonthFinancialYear($month)
    {
        $return_string = "Q1";
        if ($month == "01" || $month == "02" || $month == "03")
        {
            $return_string = "Q4";
        }
        else if ($month == "04" || $month == "05" || $month == "06")
        {
            $return_string = "Q1";
        }
        else if ($month == "07" || $month == "08" || $month == "09")
        {
            $return_string = "Q2";
        }
        else if ($month == "10" || $month == "11" || $month == "12")
        {
            $return_string = "Q3";
        }
        return $return_string;
    }

    public function CalculateQuaterFromMonthFinancialYearStartDate($check_date_cal)
    {
        $return_string = date("Y-04-01", strtotime($check_date_cal));
        $check_string_month = date("m", strtotime($check_date_cal));
        if ($check_string_month == "01" || $check_string_month == "02" || $check_string_month == "03")
        {
            $return_string = date("Y-01-01", strtotime($check_date_cal));
        }
        else if ($check_string_month == "04" || $check_string_month == "05" || $check_string_month == "06")
        {
            $return_string = date("Y-04-01", strtotime($check_date_cal));
        }
        else if ($check_string_month == "07" || $check_string_month == "08" || $check_string_month == "09")
        {
            $return_string = date("Y-07-01", strtotime($check_date_cal));
        }
        else if ($check_string_month == "10" || $check_string_month == "11" || $check_string_month == "12")
        {
            $return_string = date("Y-10-01", strtotime($check_date_cal));
        }
        return $return_string;
    }
    public function SeriliseDataArrayToBeProcessed($data_array, $serilise_row_name)
    {
        $return_array                           = array();
        if (count($data_array) > 0)
        {
            foreach ($data_array as $row)
            {
                if (!isset($return_array[$row[$serilise_row_name]]['ed_summary_date']))
                {
                    $return_array[$row[$serilise_row_name]]['ed_summary_date']  = $row[$serilise_row_name];
                }
                $return_array[$row[$serilise_row_name]][$row['ed_summary_key_value']]  = $row['ed_summary_value'];
            }
        }
        return $return_array;
    }

    public function BreachReasonDataAutoInsert()
    {
        $common_controller                                  = new CommonController;
        $common_symphony_controller                         = new CommonSymphonyController;

        $process_array                                      = array();
        $success_array                                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);

        $process_array["start_date"]                        = CurrentDateOnFormat();
        CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "last 30 days");
    }

    public function CountOnEveryHourArrayConversionAdmittedDischarged(&$array_return, $array_to_process, $check_index)
    {
        $temp_data_store_admitted                                                = array();
        $temp_data_store_discharged                                              = array();
        for ($x = 0; $x < 24; $x++)
        {
            $array_return[$x]['ane_attendance_admitted']                = 0;
            $array_return[$x]['ane_attendance_discharged']              = 0;
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
                            if ($row["symphony_discharge_outcome_val"] == 0)
                            {
                                $temp_data_store_discharged[$time_get][]                  = $row;
                            }
                            if ($row["symphony_discharge_outcome_val"] == 1)
                            {
                                $temp_data_store_admitted[$time_get][]                    = $row;
                            }
                        }
                    }
                }
            }
        }

     

        foreach ($array_return as $key => $row)
        {
            $key_temp               =   $row["hour"];
            if (isset($temp_data_store_discharged[$key_temp]))
            {
                if (is_array($temp_data_store_discharged[$key_temp]))
                {
                    $array_return[$key]['ane_attendance_discharged']     =   count($temp_data_store_discharged[$key_temp]);
                }
            }


            if (isset($temp_data_store_admitted[$key_temp]))
            {
                if (is_array($temp_data_store_admitted[$key_temp]))
                {
                    $array_return[$key]['ane_attendance_admitted']     =   count($temp_data_store_admitted[$key_temp]);
                }
            }
        }
    }
}
