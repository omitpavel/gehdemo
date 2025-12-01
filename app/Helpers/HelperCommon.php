<?php

use App\Models\Iboards\Camis\Master\TaskGroup;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportReport;
use Illuminate\Support\Facades\Cache;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Carbon\Carbon;;

if (!function_exists('WeekNameShortForm')) {
    function WeekNameShortForm($days_week_arr)
    {
        $shortForms = [
            "Monday" => "Mon",
            "Tuesday" => "Tue",
            "Wednesday" => "Wed",
            "Thursday" => "Thu",
            "Friday" => "Fri",
            "Saturday" => "Sat",
            "Sunday" => "Sun"
        ];

        $shortDays = array_map(function ($day) use ($shortForms) {
            return $shortForms[$day];
        }, $days_week_arr);
        return $shortDays;
    }
}

// *****************************Ibox Common Constants Retrieval Functions*****************************
if (!function_exists('GetWeekDaysNames')) {
    function GetWeekDaysNames(&$process_array)
    {
        $process_array["week_days_small"]                   =  ["mon", "tue", "wed", "thu", "fri", "sat", "sun"];
        $process_array["week_days_full"]                    =  ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"];
    }
}

if (!function_exists('RetriveConstantSettingValues')) {
    function RetriveConstantSettingValues(&$process_array, $constant_name)
    {

        $cache_key = 'constant_settings_' . $constant_name;
        $cache_duration = 60;
        $cached_data = Cache::remember($cache_key, $cache_duration, function () use ($constant_name) {
            return \App\Models\Common\IboxSettings::where('constant_settings_type', $constant_name)
                ->select('key_value', 'description', 'description_type')
                ->get()
                ->keyBy('key_value')
                ->toArray();
        });

        if (!empty($cached_data)) {
            foreach ($cached_data as $key => $data) {
                $description_type = $data['description_type'];
                $val = $data['description'];

                if ($description_type == 1) {
                    $process_array[$key] = (int)$val;
                } elseif ($description_type == 2) {
                    $process_array[$key] = $val;
                } elseif ($description_type == 3) {
                    $process_array[$key] = json_decode($val, true);
                }
            }
        }
    }
}


if (!function_exists('HeatMapColourMakerFromMaxMinPerformance')) {
    function HeatMapColourMakerFromMaxMinPerformance($percent)
    {

        if ($percent > 80) {
            return 'bg-col-green';
        } elseif ($percent >= 76 && $percent <= 80) {
            return 'bg-col-amber';
        } elseif ($percent >= 73 && $percent <= 75) {
            return 'bg-col-red';
        } else {
            return 'bg-col-black';
        }
    }
}

if (!function_exists('PredefinedYearFormat')) {
    function PredefinedYearFormat($read_date)
    {
        // Convert the input date to a Unix timestamp and format it
        return date("D jS M Y", strtotime($read_date));
    }
}



if (!function_exists('RetriveConstantSettingArray')) {
    function RetriveConstantSettingArray($constant_name)
    {
        $process_array = array();
        $cache_key = 'constant_settings_array' . $constant_name;
        $cache_duration = 60;
        $cached_data = Cache::remember($cache_key, $cache_duration, function () use ($constant_name) {
            return \App\Models\Common\IboxSettings::where('constant_settings_type', $constant_name)
                ->select('key_value', 'description', 'description_type')
                ->get()
                ->keyBy('key_value')
                ->toArray();
        });

        if (!empty($cached_data)) {
            foreach ($cached_data as $key => $data) {
                $description_type = $data['description_type'];
                $val = $data['description'];

                if ($description_type == 1) {
                    $process_array[$key] = (int)$val;
                } elseif ($description_type == 2) {
                    $process_array[$key] = $val;
                } elseif ($description_type == 3) {
                    $process_array[$key] = json_decode($val, true);
                }
            }
        }
        return $process_array;
    }
}

function IsLinkExists($source, $target, $haystack)
{
    foreach ($haystack as $key => $value) {
        if ($value['source'] === $source && $value['target'] === $target) {
            return $key;
        }
    }
    return false;
}

function IsNodeExists($key, $array)
{
    foreach ($array as $item) {
        if (in_array($key, $item)) {
            return true;
        }
    }
    return false;
}

if (!function_exists('RetriveSpecificConstantSettingValues')) {
    function RetriveSpecificConstantSettingValues($connection_index, $constant_name)
    {
        $cache_key = 'constant_settings_single' . $connection_index;
        $cache_duration = 60;
        $constant_val_array = Cache::remember($cache_key, $cache_duration, function () use ($constant_name, $connection_index) {
            return \App\Models\Common\IboxSettings::select('description', 'description_type')->where('constant_settings_type', $constant_name)->where('key_value', $connection_index)->first();
        });

        if (isset($constant_val_array->description)) {

            if ($constant_val_array->description_type == 1) {
                return (int)$constant_val_array->description;
            } elseif ($constant_val_array->description_type == 2) {
                return $constant_val_array->description;
            } elseif ($constant_val_array->description_type == 3) {
                return json_decode($constant_val_array->description, true);
            }
        } else {
            return null;
        }
    }
}


if (!function_exists('ReturnArrayAsJsonToScript')) {
    function ReturnArrayAsJsonToScript($return_array)
    {
        if ($return_array) {
            if (!is_array($return_array)) {
                $return_array = $return_array->toArray();
            }
            $return_array["return_status_check"] = "sucess";
        } else {
            $return_array["return_status_check"] = "empty";
        }
        return  response()->json($return_array);
    }
}


if (!function_exists('ReturnObjectMultiArrayAsSequentialArray')) {
    function ReturnObjectMultiArrayAsSequentialArray($process_array)
    {
        $return_array = array();
        if ($process_array) {
            if (count($process_array) > 0) {
                foreach ($process_array as $row) {
                    $return_array[] =   (array)$row;
                }
            }
        }
        return  $return_array;
    }
}

if (!function_exists('ReturnlaravelObjectMultiArrayAsSequentialArray')) {
    function ReturnlaravelObjectMultiArrayAsSequentialArray($process_array)
    {
        $return_array = array();
        if ($process_array) {
            if (count($process_array) > 0) {
                foreach ($process_array as $row) {
                    $return_array[] =   $row->toArray();
                }
            }
        }
        return  $return_array;
    }
}


if (!function_exists('ReturnObjectSingleArrayAsSequentialArray')) {
    function ReturnObjectSingleArrayAsSequentialArray($process_array)
    {
        $return_array = array();
        if ($process_array) {
            if (isset($process_array)) {
                $return_array =   $process_array->toArray();
            }
        }
        return  $return_array;
    }
}


if (!function_exists('ReturnObjectMultiArrayAsSequentialArrayLaravelQueryArray')) {
    function ReturnObjectMultiArrayAsSequentialArrayLaravelQueryArray($process_array)
    {
        $return_array       = array();
        $process_array      = json_decode(json_encode($process_array));
        $return_array       = json_decode(json_encode($process_array), true);

        return  $return_array;
    }
}





if (!function_exists('LastNumberOfMonthsArrayForDropdownOperation')) {
    function LastNumberOfMonthsArrayForDropdownOperation($date_formatted, $months_number)
    {
        $filter_month_array                                         = array();
        $date_formatted                                             = date("Y-m-01", strtotime($date_formatted));
        for ($x = 0; $x < $months_number; $x++) {
            $start_date                                             = date("Y-m-01", strtotime($date_formatted . " - $x month"));
            $filter_month_array[$x]["filter_text"]                  = date("F Y", strtotime($start_date));
            $filter_month_array[$x]["filter_value"]                 = $start_date;
        }
        return $filter_month_array;
    }
}

if (!function_exists('LastNumberOfWeeksArrayForDropdownOperation')) {
    function LastNumberOfWeeksArrayForDropdownOperation($date_formatted, $weeks_number)
    {
        $filter_week_array                                         = array();
        $start_date                                                 = date("Y-m-d 00:00:00", strtotime($date_formatted . ' monday next week'));
        for ($x = 0; $x < $weeks_number; $x++) {
            $start_date                                             = date("Y-m-d", strtotime($start_date . " - 7 days"));
            $end_date                                               = date("Y-m-d", strtotime($start_date . ' + 6 days'));
            $filter_week_array[$x]["filter_text"]                   = date("D jS M Y", strtotime($start_date)) . "  To  " . date("D jS M Y", strtotime($end_date));
            $filter_week_array[$x]["filter_value"]                  = $start_date;
        }

        return $filter_week_array;
    }
}
if (!function_exists('NumberFormatCustom')) {
    function NumberFormatCustom($process_number, $decimal)
    {
        return (int)number_format($process_number, $decimal, ".", "");
    }
}


if (!function_exists('CheckCountArrayToProcess')) {
    function CheckCountArrayToProcess($array_to_process)
    {
        if (isset($array_to_process)) {
            if (count($array_to_process) > 0) {
                return true;
            }
        }
        return false;
    }
}


if (!function_exists('MultiArraySortCustom')) {
    function MultiArraySortCustom(&$array, $key, $sort_type = "asc")
    {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }
        if ($sort_type == "asc") {
            asort($sorter);
        } else {
            arsort($sorter);
        }
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }
        $array = $ret;
    }
}






if (!function_exists('CurrentDateOnFormat')) {
    function CurrentDateOnFormat()
    {
        return date("Y-m-d H:i:s");
    }
}

if (!function_exists('YesterdayDateOnFormat')) {
    function YesterdayDateOnFormat()
    {
        return date("Y-m-d H:i:s", strtotime("-1 days"));
    }
}

if (!function_exists('PredefinedDateFormatChange')) {
    function PredefinedDateFormatChange($read_date)
    {
        if ($read_date != '') {
            return date("jS M Y, H:i", strtotime($read_date));
        } else {
            return '';
        }
    }
}
if (!function_exists('PredefinedDateFormatForPlannedDichargedDate')) {
    function PredefinedDateFormatForPlannedDichargedDate($read_date)
    {

        if ($read_date != '') {
            return date("D j F Y", strtotime($read_date));
        } else {
            return '';
        }
    }
}
if (!function_exists('PredefinedStandardDateFormatChange')) {
    function PredefinedStandardDateFormatChange($read_date)
    {
        return date("Y-m-d H:i:s", strtotime($read_date));
    }
}
if (!function_exists('PredefinedDateFormatWithoutYearChange')) {
    function PredefinedDateFormatWithoutYearChange($read_date)
    {
        return date("l jS F, H:i", strtotime($read_date));
    }
}

if (!function_exists('PredefinedDateFormatShowOnCalendarDashboard')) {
    function PredefinedDateFormatShowOnCalendarDashboard($read_date)
    {
        return date("D jS M Y", strtotime($read_date));
    }
}
if (!function_exists('PredefinedDateFormatShowOnCalendarDashboardMonthOnly')) {
    function PredefinedDateFormatShowOnCalendarDashboardMonthOnly($read_date)
    {
        return date("F Y", strtotime($read_date));
    }
}
if (!function_exists('PredefinedDateFormatShowOnCalendarDashboardSecond')) {
    function PredefinedDateFormatShowOnCalendarDashboardSecond($read_date)
    {
        return date("jS M Y", strtotime($read_date));
    }
}
if (!function_exists('PredefinedDateFormatBoardRoundTaskToBeCompleted')) {
    function PredefinedDateFormatBoardRoundTaskToBeCompleted($read_date)
    {
        return date("D jS M Y H:i", strtotime($read_date));
    }
}
if (!function_exists('PredefinedStandardDateFormatChangeDateAlone')) {
    function PredefinedStandardDateFormatChangeDateAlone($read_date)
    {
        return date("Y-m-d", strtotime($read_date));
    }
}

if (!function_exists('PredefinedDateAloneFormatChange')) {
    function PredefinedDateAloneFormatChange($read_date)
    {
        return date("jS M, Y", strtotime($read_date));
    }
}

if (!function_exists('PredefinedDateAloneFormatChangeWithDaysOver')) {
    function PredefinedDateAloneFormatChangeWithDaysOver($date1, $date2)
    {
        $date1 = date("Y-m-d", strtotime($date1));
        $date2 = date("Y-m-d", strtotime($date2));
        $days_over = "";
        if ($date1 < $date2) {
            $diff = strtotime($date2) - strtotime($date1);
            $diff = (int) abs(round($diff / 86400));
            if ($diff > 0) {
                $days_over = " (" . $diff . " Days Over)";
            }
        }
        $return_str = date("jS M, Y", strtotime($date1));

        return $return_str . $days_over;
    }
}

if (!function_exists('TimeDifferenceInMinutes')) {
    function TimeDifferenceInMinutes($date1, $date2)
    {
        $from_time = strtotime($date1);
        $to_time = strtotime($date2);
        return round(abs($to_time - $from_time) / 60);
    }
}

if (!function_exists('TimeDifferenceInSeconds')) {
    function TimeDifferenceInSeconds($date1, $date2)
    {
        $from_time = strtotime($date1);
        $to_time = strtotime($date2);
        return round(abs($to_time - $from_time));
    }
}

if (!function_exists('TimeDifferenceInHourUpperLimit')) {
    function TimeDifferenceInHourUpperLimit($date1, $date2)
    {
        $from_time = strtotime($date1);
        $to_time = strtotime($date2);
        $hour = abs(floor(($to_time - $from_time) / 3600));
        $minute = abs(floor(($to_time - $from_time) / 60) % 60);
        $date_time_ret = (float) date("H.i", strtotime($hour . ":" . $minute));
        return (int) number_format(ceil($date_time_ret), 0, '.', '');
    }
}

if (!function_exists('TimeDifferenceInHourMinutes')) {
    function TimeDifferenceInHourMinutes($date1, $date2)
    {
        $from_time = strtotime($date1);
        $to_time = strtotime($date2);

        $hour = abs(floor(($to_time - $from_time) / 3600));
        $minute = abs(floor(($to_time - $from_time) / 60) % 60);
        if ($hour < 10) {
            $hour = "0" . $hour;
        }
        if ($minute < 10) {
            $minute = "0" . $minute;
        }
        return $hour . ":" . $minute;
    }
}

if (!function_exists('TimeDifferenceInHourMinutesTextFormat')) {
    function TimeDifferenceInHourMinutesTextFormat($date1, $date2)
    {
        $from_time = strtotime($date1);
        $to_time = strtotime($date2);
        $hour = abs(floor(($to_time - $from_time) / 3600));
        $minute = abs(floor(($to_time - $from_time) / 60) % 60);

        if ($hour < 10) {
            $hour = "0" . $hour;
        }
        if ($minute < 10) {
            $minute = "0" . $minute;
        }
        return $hour . "H " . $minute . "M";
    }
}

if (!function_exists('TimeDifferenceInHourMinutesSeconds')) {
    function TimeDifferenceInHourMinutesSeconds($date1, $date2)
    {
        $from_time = strtotime($date1);
        $to_time = strtotime($date2);

        $hour = abs(floor(($to_time - $from_time) / 3600));
        $minute = abs(floor(($to_time - $from_time) / 60) % 60);
        $second = ($to_time - $from_time) - ($hour * 3600 + $minute * 60);

        if ($hour < 10) {
            $hour = "0" . $hour;
        }
        if ($minute < 10) {
            $minute = "0" . $minute;
        }
        if ($second < 10) {
            $second = "0" . $second;
        }
        return $hour . ":" . $minute . ":" . $second;
    }
}

if (!function_exists('ConvertMinutesToHourMinutes')) {
    function ConvertMinutesToHourMinutes($minutes)
    {
        if ($minutes != "" && $minutes != null && $minutes > 0) {
            $hours = floor($minutes / 60);
            $minutes = floor($minutes % 60);
            if ($hours < 10) {
                $hours = "0" . $hours;
            }
            if ($minutes < 10) {
                $minutes = "0" . $minutes;
            }
            return $hours . " : " . $minutes;
        } else {
            return "";
        }
    }
}

if (!function_exists('ConvertMinutesToHourMinutesWithText')) {
    function ConvertMinutesToHourMinutesWithText($minutes)
    {
        if ($minutes != "" && $minutes != null && $minutes > 0) {
            $hours = floor($minutes / 60);
            $minutes = floor($minutes % 60);
            if ($hours < 10) {
                $hours = "0" . $hours;
            }
            if ($minutes < 10) {
                $minutes = "0" . $minutes;
            }
            return $hours . " Hour " . $minutes . " Minutes";
        } else {
            return "";
        }
    }
}

if (!function_exists('ConvertSecondsToHourMinutesWithTextFormated')) {
    function ConvertSecondsToHourMinutesWithTextFormated($seconds)
    {
        $return_text = "";
        if ($seconds != "" && $seconds != null && $seconds > 0) {
            $hours      = floor($seconds / 3600);
            $minutes    = floor(($seconds / 60) % 60);
            if ($hours != 0) {
                $return_text .= $hours . " Hr";
            }
            if ($hours != 0 && $minutes != 0) {
                $return_text .= " & ";
            }
            if ($minutes != 0) {
                $return_text .= $minutes . " Min";
            }
        }
        return $return_text;
    }
}

if (!function_exists('ConvertMinutesToHourMinutesWithTextFormated')) {
    function ConvertMinutesToHourMinutesWithTextFormated($minutes)
    {
        $return_text = "";
        if ($minutes != "" && $minutes != null && $minutes > 0) {
            $hours = floor($minutes / 60);
            $minutes = floor($minutes % 60);
            if ($hours != 0) {
                $return_text .= $hours . " Hr";
            }
            if ($hours != 0 && $minutes != 0) {
                $return_text .= " & ";
            }
            if ($minutes != 0) {
                $return_text .= $minutes . " Min";
            }
        }
        return $return_text;
    }
}

if (!function_exists('ConvertMinutesToHourMinutesWithTextFormatedShort')) {
    function ConvertMinutesToHourMinutesWithTextFormatedShort($minutes)
    {
        $hours = floor($minutes / 60);
        $minutes = floor($minutes % 60);
        $ret_text = "";
        if ($minutes != "" && $minutes != null && $minutes > 0) {
            if ($hours != 0) {
                $ret_text .= $hours . " H";
            }
            if ($hours != 0 && $minutes != 0) {
                $ret_text .= " & ";
            }
            if ($minutes != 0) {
                $ret_text .= $minutes . " M";
            }
        }

        return $ret_text;
    }
}

if (!function_exists('ConvertDateTimeToElasticFormat')) {
    function ConvertDateTimeToElasticFormat($datetime)
    {
        $date_format = date("c", strtotime($datetime));
        return $date_format;
    }
}

if (!function_exists('HourByHourZeroSetGraph')) {
    function HourByHourZeroSetGraph()
    {
        $start = date("Y-m-d 00:00:00");
        $array_hour_by_array_intials = array();

        for ($x = 0; $x < 24; $x++) {
            $hour = date('H', strtotime("+$x hour ", strtotime($start)));
            $array_hour_by_array_intials[$hour] = 0;
        }
        return $array_hour_by_array_intials;
    }
}

if (!function_exists('WeekDayByDayZeroSetGraph')) {
    function WeekDayByDayZeroSetGraph()
    {
        $start = date("Y-m-d", strtotime('monday this week'));
        $array_week_day_by_day_intials = array();
        for ($x = 0; $x < 7; $x++) {
            $st_date = date("D", strtotime(" + $x days", strtotime($start)));
            $array_week_day_by_day_intials[$st_date] = 0;
        }
        return $array_week_day_by_day_intials;
    }
}

if (!function_exists('NumberOfDaysBetweenTwoDates')) {
    function NumberOfDaysBetweenTwoDates($date1, $date2)
    {
        $date1 = date("Y-m-d", strtotime($date1));
        $date2 = date("Y-m-d", strtotime($date2));
        $diff = strtotime($date2) - strtotime($date1);
        return (int) abs(round($diff / 86400));
    }
}

if (!function_exists('NumberOfHoursBetweenTwoDates')) {
    function NumberOfHoursBetweenTwoDates($date1, $date2)
    {
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);

        return $date1->diffInHours($date2);
    }
}
if (!function_exists('NumberOfMinutesBetweenTwoDates')) {
    function NumberOfMinutesBetweenTwoDates($date1, $date2)
    {
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);

        return $date1->diffInMinutes($date2);
    }
}

if (!function_exists('HoursToDaysCalculation')) {
    function HoursToDaysCalculation($hours)
    {
        if ($hours <= 0) {
            return 0;
        }

        return (int) ceil($hours / 24);
    }
}





if (!function_exists('NumberOfDays')) {
    function NumberOfDays($date1, $date2)
    {
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);
        $interval = $date1->diff($date2);
        $totalDays = $interval->days;
        return (int) $totalDays;
    }
}


if (!function_exists('ExportFunction')) {
    function ExportFunction($data, $heading, $name = 'Report')
    {
        return Excel::download(new ExportReport($data, $heading), $name . '.csv');
    }
}



if (!function_exists('TimeConvertToDayName')) {
    function TimeConvertToDayName($date1)
    {
        if ($date1 != "") {
            return strtolower(date("l", strtotime($date1)));
        }
        return "";
    }
}

if (!function_exists('CalculateStartEndDateAccordingSelection')) {
    function CalculateStartEndDateAccordingSelection(&$start_date, &$end_date, $type)
    {
        $date_time_now = CurrentDateOnFormat();
        if ($start_date == "") {
            $start_date = date("Y-m-d 00:00:00", strtotime($date_time_now));
        }
        if ($type == "day") {
            $start_date = date("Y-m-d 00:00:00", strtotime($start_date));
            if (empty($end_date) || strtotime($end_date) < strtotime($start_date)) {

                $end_date = date("Y-m-d 23:59:59", strtotime($start_date));
            } else {

                $end_date = date("Y-m-d 23:59:59", strtotime($end_date));
            }
        } elseif ($type == "last seven") {
            $start_date     = date("Y-m-d 00:00:00", strtotime($start_date . " -7 days"));
            $end_date       = date("Y-m-d 23:59:59", strtotime($start_date . " +6 days"));
        } elseif ($type == "week") {
            $start_date = date("Y-m-d 00:00:00", strtotime($start_date . ' monday this week'));
            $end_date = date("Y-m-d 23:59:59", strtotime($start_date . ' +6 days'));
        } elseif ($type == "last week") {
            $start_date = date("Y-m-d 00:00:00", strtotime($start_date . ' monday last week'));
            $end_date = date("Y-m-d 23:59:59", strtotime($start_date . ' +6 days'));
        } elseif ($type == "last 10 days") {
            $start_date = date("Y-m-d 00:00:00", strtotime($start_date . '  -10 days'));
            $end_date = date("Y-m-d 23:59:59");
        } elseif ($type == "last 15 days") {
            $start_date = date("Y-m-d 00:00:00", strtotime($start_date . ' -15 days'));
            $end_date  = date("Y-m-d 23:59:59", strtotime($start_date . " +15 days"));
        } elseif ($type == "last 4 weeks") {
            $start_date_temp = date("Y-m-d 00:00:00", strtotime($start_date . ' monday this week'));
            $start_date = date("Y-m-d 00:00:00", strtotime($start_date_temp . ' -4 weeks'));
            $end_date = date("Y-m-d 23:59:59", strtotime($start_date_temp . ' -1 days'));
        } elseif ($type == "month") {
            $start_date = date("Y-m-01 00:00:00", strtotime($start_date));
            $end_date = date("Y-m-t 23:59:59", strtotime($start_date));
        } elseif ($type == "2 month") {
            $start_date = date("Y-m-01 00:00:00", strtotime($start_date . ' -1 month'));
            $end_date = date("Y-m-t 23:59:59", strtotime($start_date . ' +1 month'));
        } elseif ($type == "year") {
            $start_date = date("Y-m-01 00:00:00", strtotime($start_date . ' -12 month'));
            $end_date = date("Y-m-t 23:59:59", strtotime($start_date . ' +11 month'));
        } elseif ($type == "last_365") {
            $start_date = date("Y-m-d 00:00:00", strtotime($start_date . ' -365 days'));
            $end_date = date("Y-m-d 23:59:59", strtotime($start_date . ' +364 days'));
        } elseif ($type == "last 1000") {
            $start_date = date("Y-m-d 00:00:00", strtotime($start_date . '  -20 days'));
            $end_date = date("Y-m-d 23:59:59", strtotime($start_date . ' +21 days'));
        } elseif ($type == "last 30 days") {
            $start_date = date("Y-m-d 00:00:00", strtotime($start_date . '  -29 days'));
            $end_date = date("Y-m-d 23:59:59");
        } elseif ($type == "last_84") {
            $start_date = date("Y-m-d 00:00:00", strtotime($start_date . '  -83 days'));
            $end_date = date("Y-m-d 23:59:59");
        } elseif ($type == "last_90") {
            $start_date = date("Y-m-d 00:00:00", strtotime($start_date . '  -89 days'));
            $end_date = date("Y-m-d 23:59:59");
        }
    }
}

if (!function_exists('NumberOfWeekDaysInMonth')) {
    function NumberOfWeekDaysInMonth($n, $firstday)
    {
        $days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
        $count_days = array();
        for ($i = 0; $i < 7; $i++) {
            $count_days[$i] = 4;
        }
        $pos = 0;
        for ($i = 0; $i < 7; $i++) {
            if ($firstday == $days[$i]) {
                $pos = $i;
                break;
            }
        }
        $inc = $n - 28;
        for ($i = $pos; $i < $pos + $inc; $i++) {
            if ($i > 6) {
                $count_days[$i % 7] = 5;
            } else {
                $count_days[$i] = 5;
            }
        }
        return $count_days;
    }
}





if (!function_exists('ArrayAverageConversionWithNumbers')) {
    function ArrayAverageConversionWithNumbers(&$data_array, $average_number, $decimal)
    {
        if (isset($data_array)) {
            if (is_array($data_array)) {
                if (count($data_array) > 0) {
                    foreach ($data_array as $key => $val) {
                        $data_array[$key]    =   number_format(($val / $average_number), $decimal, '.', '');
                    }
                }
            }
        }
    }
}

if (!function_exists('ArrayAverageConversionWithNumbersByArrayWeek')) {
    function ArrayAverageConversionWithNumbersByArrayWeek(&$data_array, $week_counts_array, $decimal)
    {
        $week_days              = ["Mon" => 0, "Tue" => 1, "Wed" => 2, "Thu" => 3, "Fri" => 4, "Sat" => 5, "Sun" => 6];
        if (isset($data_array)) {
            if (is_array($data_array)) {
                if (count($data_array) > 0) {
                    foreach ($data_array as $key => $val) {
                        $week_index             = $week_days[$key];
                        $data_array[$key]       = number_format(($val / $week_counts_array[$week_index]), $decimal, '.', '');
                    }
                }
            }
        }
    }
}

if (!function_exists('RoundNumberToZeroDecimalPoints')) {
    function RoundNumberToZeroDecimalPoints($number_to_parse)
    {
        $number_to_parse            =    number_format(round($number_to_parse), 0, '.', '');
        return $number_to_parse;
    }
}

if (!function_exists('ValuePresentThenSetForVariable')) {
    function ValuePresentThenSetForVariable($process_array, $process_value, $date_check, $process_value_2 = "")
    {
        $return_value                               = "";
        $date_time_now                              = CurrentDateOnFormat();
        $date_1                                     = $process_array[$process_value];
        if (isset($process_array[$process_value])) {
            if ($process_array[$process_value] != null) {
                if ($date_check == 0) {
                    $return_value                    = $process_array[$process_value];
                }
                if ($date_check == 1) {
                    if ($date_1 != '1900-01-01 00:00:00.000' && $date_1 != '1970-01-01 00:00:00.000') {
                        $return_value                    = PredefinedDateFormatChange($date_1);
                    }
                }
                if ($date_check == 2) {
                    if (isset($process_array[$process_value_2])) {
                        if ($process_array[$process_value_2] != null) {
                            $return_value            = TimeDifferenceInMinutes($date_1, $process_array[$process_value_2]);
                        }
                    }
                }
                if ($date_check == 3) {
                    $date_to                         = $date_time_now;
                    if (isset($process_array[$process_value_2])) {
                        if ($process_array[$process_value_2] != null) {
                            $date_to                 = $process_array[$process_value_2];
                        }
                    }
                    $return_value                    = TimeDifferenceInMinutes($date_1, $date_to);
                }
            }
        }
        return $return_value;
    }
}



if (!function_exists('ValuePresentThenSetForVariableBreach')) {
    function ValuePresentThenSetForVariableBreach($process_array, $process_value, $date_check, $process_value_2 = "")
    {
        $return_value                               = "";
        $date_time_now                              = CurrentDateOnFormat();
        $date_1                                     = $process_array[$process_value];
        if (isset($process_array[$process_value])) {
            if ($process_array[$process_value] != null) {
                if ($date_check == 0) {
                    $return_value                    = $process_array[$process_value];
                }
                if ($date_check == 1) {
                    if ($date_1 != '1900-01-01 00:00:00.000' && $date_1 != '1970-01-01 00:00:00.000') {
                        $return_value                    = PredefinedDateFormatChange($date_1);
                    }
                }
                if ($date_check == 2) {
                    if (isset($process_array[$process_value_2])) {
                        if ($process_array[$process_value_2] != null) {
                            $return_value            = TimeDifferenceInSeconds($date_1, $process_array[$process_value_2]);
                        }
                    }
                }
                if ($date_check == 3) {
                    $date_to                         = $date_time_now;
                    if (isset($process_array[$process_value_2])) {
                        if ($process_array[$process_value_2] != null) {
                            $date_to                 = $process_array[$process_value_2];
                        }
                    }
                    $return_value                    = TimeDifferenceInSeconds($date_1, $date_to);
                }
            }
        }
        return $return_value;
    }
}

if (!function_exists('NewHeatMapColourMakerFromMaxMin')) {
    function NewHeatMapColourMakerFromMaxMin($value_check, $min_colour, $max_colour)
    {
        $range                      = $max_colour - $min_colour;
        if ($range > 0) {
            $correctedStartValue    = $value_check -  $min_colour;
            $percent                = ($correctedStartValue * 100) / $range;
            $percent                = $percent / 100;
        } else {
            $percent                =  0;
        }


        if ($percent > 0.90) {
            return 'ed-activity-violet';
        } elseif ($percent > 0.70) {
            return 'ed-activity-maroon';
        } elseif ($percent > 0.50) {
            return 'ed-activity-dark-blue';
        } else {
            return 'ed-activity-light-blue';
        }
    }
}





if (!function_exists('HeatMapColourMakerFromMaxMin')) {
    function HeatMapColourMakerFromMaxMin($value_check, $min_colour, $max_colour)
    {
        $range                      = $max_colour - $min_colour;
        if ($range > 0) {
            $correctedStartValue    = $value_check -  $min_colour;
            $percent                = ($correctedStartValue * 100) / $range;
            $percent                = $percent / 100;
        } else {
            $percent                =  0;
        }

        $first_color                = 'e1ebf4';
        $last_color                 = 'ae125b';
        $first_red                  = hexdec(substr($first_color, 0, 2));
        $first_green                = hexdec(substr($first_color, 2, 2));
        $first_blue                 = hexdec(substr($first_color, 4, 2));
        $end_red                    = hexdec(substr($last_color, 0, 2));
        $end_green                  = hexdec(substr($last_color, 2, 2));
        $end_blue                   = hexdec(substr($last_color, 4, 2));
        $diff_red                   = $end_red - $first_red;
        $diff_green                 = $end_green - $first_green;
        $diff_blue                  = $end_blue - $first_blue;

        $diff_red                   = explode('.', dechex(($diff_red * $percent) + $first_red));
        $diff_red                   = substr($diff_red[0], 0, 2);
        $diff_green                 = explode('.', dechex(($diff_green * $percent) + $first_green));
        $diff_green                 = substr($diff_green[0], 0, 2);
        $diff_blue                  = explode('.', dechex(($diff_blue * $percent) + $first_blue));
        $diff_blue                  = substr($diff_blue[0], 0, 2);

        if (strlen($diff_red) == 1) {
            $diff_red = '0' .  $diff_red;
        }
        if (strlen($diff_green) == 1) {
            $diff_green = '0' .  $diff_green;
        }
        if (strlen($diff_blue) == 1) {
            $diff_blue = '0' .  $diff_blue;
        }
        return '#' . $diff_red . $diff_green . $diff_blue;
    }
}

if (!function_exists('PercentageCalculationOfValues')) {
    function PercentageCalculationOfValues($value_1, $value_2, $decimals = 0)
    {
        $performance_val    = 0;
        $performance_val    = ($value_2 != 0 && $value_1 != 0) ? ($value_1 / $value_2) * 100 : 0;
        $performance_val    = ($performance_val > 100) ? 100 : $performance_val;
        $performance_val    = ($performance_val < 0) ? 0 : $performance_val;
        $performance_val    = number_format($performance_val, $decimals, '.', '');
        return $performance_val;
    }
}


if (!function_exists('FindArrayWithKeyValuesFromParentArray')) {
    function FindArrayWithKeyValuesFromParentArray($process_array, $key_check, $value_ceck)
    {
        $return_array            = array();
        if (count($process_array) > 0) {
            foreach ($process_array as $row) {
                if ($row[$key_check] == $value_ceck) {
                    $return_array[] = $row;
                }
            }
        }
        return $return_array;
    }
}

if (!function_exists('FindArrayWithKeyArraysFromParentArray')) {
    function FindArrayWithKeyArraysFromParentArray($process_array, $key_check, $value_ceck)
    {
        $return_array            = array();
        if (count($process_array) > 0) {
            foreach ($process_array as $row) {
                if (in_array($row[$key_check], $value_ceck)) {
                    $return_array[] = $row;
                }
            }
        }
        return $return_array;
    }
}


if (!function_exists('CheckSpecificPermission')) {
    function CheckSpecificPermission($paramater)
    {
        // dd(session()->get('roles_permission'));

        if (session()->get('roles_permission') != null) {
            $permission_search = array_filter(session()->get('roles_permission'), function ($element) use ($paramater) {
                return strpos($element, $paramater) !== false;
            });

            if (!empty($permission_search)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
        //return (Sentinel::getUser() && Sentinel::getUser()->hasAccess($paramater));
    }
}

if (!function_exists('CheckDashboardPermission')) {
    function CheckDashboardPermission($parameter)
    {
        if (session()->get('roles_permission') != null) {
            $permission_search = array_filter(session()->get('roles_permission'), function ($element) use ($parameter) {
                return strpos($element, $parameter) !== false;
            });

            if (!empty($permission_search)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}
if (!function_exists('CheckAnyPermissionWildcard')) {
    function CheckAnyPermissionWildcard($permissions)
    {

        foreach ($permissions as $permission) {

            if (CheckDashboardPermission(rtrim($permission, '*'))) {
                return true;
            }
        }

        return false;
    }
}
if (!function_exists('DisabledButtonOnRolePermission')) {
    function DisabledButtonOnRolePermission($parameter)
    {
        if (!empty(session()->get('roles_permission')) && is_array(session()->get('roles_permission'))) {
            if ($parameter != null) {
                $permission_search = array_filter(session()->get('roles_permission'), function ($element) use ($parameter) {
                    return strpos($element, $parameter) !== false;
                });

                if (!empty($permission_search)) {
                    return '';
                }
                return 'permission_restricted permission_denied_div';
            }
        }
        return '';
    }
}
if (!function_exists('PermissionDeniedDiv')) {
    function PermissionDeniedDiv($parameter)
    {
        if (!empty(session()->get('roles_permission')) && is_array(session()->get('roles_permission'))) {
            if ($parameter != null) {
                $permission_search = array_filter(session()->get('roles_permission'), function ($element) use ($parameter) {
                    return strpos($element, $parameter) !== false;
                });

                if (!empty($permission_search)) {
                    return '';
                }
                return 'permission_denied_div';
            }
        }

        return '';
    }
}
if (!function_exists('CheckMultipleDashboardPermission')) {
    function CheckMultipleDashboardPermission($parameters)
    {
        if (session()->get('roles_permission') !== null) {
            $permission_search = array_filter(session()->get('roles_permission'), function ($element) use ($parameters) {

                foreach ($parameters as $param) {
                    if (strpos($element, $param) !== false) {
                        return true;
                    }
                }
                return false;
            });

            return !empty($permission_search);
        }

        return true;
    }
}
if (!function_exists('CheckAnyPermission')) {
    function CheckAnyPermission($permissions)
    {

        $intersection = array_intersect($permissions, session()->get('roles_permission'));

        return !empty($intersection);
    }
}
if (!function_exists('PermitedStatus')) {
    function PermitedStatus($parameter)
    {
        if ($parameter != null) {
            $permission_search = array_filter(session()->get('roles_permission'), function ($element) use ($parameter) {
                return strpos($element, $parameter) !== false;
            });

            if (!empty($permission_search)) {
                return true;
            }
            return false;
        }
        return '';
    }
}
if (!function_exists('AllthePermissionList')) {
    function AllthePermissionList()
    {
        $user = Sentinel::getUser();

        $dataArray = session()->get('roles_permission');
    }
}
if (!function_exists('DeniedDiv')) {
    function DeniedDiv()
    {
        return 'permission_denied_div';
    }
}
if (!function_exists('DisabledButtonOnRole')) {
    function DisabledButtonOnRole()
    {
        return 'permission_restricted';
    }
}
if (!function_exists('PermissionDenied')) {
    function PermissionDenied()
    {
        return "permission_denied";
    }
}
if (!function_exists('array_key_replace')) {
    function array_key_replace($item, $replace_with, array $array)
    {
        $updated_array = [];
        foreach ($array as $key => $value) {
            if (!is_array($value) && $key == $item) {
                $updated_array = array_merge($updated_array, [$replace_with => $value]);
                continue;
            }
            $updated_array = array_merge($updated_array, [$key => $value]);
        }
        return $updated_array;
    }
}
if (!function_exists('CalculatePercentage')) {
    function CalculatePercentage($total, $percentage_value)
    {
        if ($total > 0) {
            $percentage = number_format(($percentage_value / $total) * 100, 2);
        } else {
            $percentage = 0;
        }
        return $percentage;
    }
}
if (!function_exists('DecryptData')) {
    function DecryptData($encryptedData, $key = null)
    {
        if ($key == null) {
            $key = 'iboxv4';
        }

        $key = hash('sha256', $key, true);

        if (strpos($encryptedData, ':') === false) {
            throw new InvalidArgumentException('Invalid encrypted data format.');
        }

        list($ivHex, $encrypted) = explode(':', $encryptedData, 2);

        if (empty($ivHex) || empty($encrypted)) {
            throw new InvalidArgumentException('Invalid encrypted data parts.');
        }

        $iv = hex2bin($ivHex);
        if ($iv === false) {
            throw new InvalidArgumentException('Invalid IV format.');
        }

        $encrypted = base64_decode($encrypted);
        if ($encrypted === false) {
            throw new InvalidArgumentException('Invalid base64 encrypted data.');
        }

        $decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        if ($decrypted === false) {
            throw new RuntimeException('Decryption failed.');
        }

        return $decrypted;
    }
}
if (!function_exists('ArrayFilter')) {
    function ArrayFilter($array, $condition)
    {
        $filteredArray = [];
        foreach ($array as $key => $value) {
            if ($condition($value)) {
                $filteredArray[$key] = $value;
            }
        }
        return $filteredArray;
    }
}
if (!function_exists('TimeDefferInFormat')) {
    function TimeDefferInFormat($start_time, $end_time = null)
    {
        if (is_numeric($start_time)) {
            $start_date_time = Carbon::createFromTimestamp($start_time);
        } else {
            $start_date_time = Carbon::parse($start_time);
        }

        if ($end_time === null) {
            $end_date_time = Carbon::now();
        } else {
            if (is_numeric($end_time)) {
                $end_date_time = Carbon::createFromTimestamp($end_time);
            } else {
                $end_date_time = Carbon::parse($end_time);
            }
        }

        $total_minutes = $start_date_time->diffInMinutes($end_date_time);

        $days = floor($total_minutes / 1440);
        $hours = floor(($total_minutes % 1440) / 60);
        $minutes = $total_minutes % 60;

        $result = '';
        if ($days > 0) {
            $result .= $days . ' Days ';
        }
        if ($hours > 0 || $days > 0) {
            $result .= $hours . ' H ';
        }
        $result .= $minutes . ' M';

        return trim($result);
    }
}
if (!function_exists('getServerLoad')) {
    function getServerLoad()
    {
        $load = null;

        if (stristr(PHP_OS, "win")) {
            $cmd = "wmic cpu get loadpercentage /all";
            @exec($cmd, $output);

            if ($output) {
                foreach ($output as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $load = $line;
                        break;
                    }
                }
            }
        } else {
            if (is_readable("/proc/stat")) {

                $statData1 = _getServerLoadLinuxData();
                sleep(1);
                $statData2 = _getServerLoadLinuxData();

                if (
                    (!is_null($statData1)) &&
                    (!is_null($statData2))
                ) {
                    $statData2[0] -= $statData1[0];
                    $statData2[1] -= $statData1[1];
                    $statData2[2] -= $statData1[2];
                    $statData2[3] -= $statData1[3];

                    $cpuTime = $statData2[0] + $statData2[1] + $statData2[2] + $statData2[3];

                    $load = 100 - ($statData2[3] * 100 / $cpuTime);
                }
            }
        }

        return $load;
    }
}
if (!function_exists('getServerMemoryUsage')) {
    function getServerMemoryUsage($getPercentage = true)
    {
        $memoryTotal = null;
        $memoryFree = null;

        if (stristr(PHP_OS, "win")) {
            $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
            @exec($cmd, $outputTotalPhysicalMemory);

            $cmd = "wmic OS get FreePhysicalMemory";
            @exec($cmd, $outputFreePhysicalMemory);

            if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
                foreach ($outputTotalPhysicalMemory as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $memoryTotal = $line;
                        break;
                    }
                }

                foreach ($outputFreePhysicalMemory as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $memoryFree = $line;
                        $memoryFree *= 1024;
                        break;
                    }
                }
            }
        } else {
            if (is_readable("/proc/meminfo")) {
                $stats = @file_get_contents("/proc/meminfo");

                if ($stats !== false) {
                    $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                    $stats = explode("\n", $stats);

                    foreach ($stats as $statLine) {
                        $statLineData = explode(":", trim($statLine));

                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemTotal") {
                            $memoryTotal = trim($statLineData[1]);
                            $memoryTotal = explode(" ", $memoryTotal);
                            $memoryTotal = $memoryTotal[0];
                            $memoryTotal *= 1024;
                        }

                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                            $memoryFree = trim($statLineData[1]);
                            $memoryFree = explode(" ", $memoryFree);
                            $memoryFree = $memoryFree[0];
                            $memoryFree *= 1024;
                        }
                    }
                }
            }
        }

        if (is_null($memoryTotal) || is_null($memoryFree)) {
            return null;
        } else {
            if ($getPercentage) {
                return (100 - ($memoryFree * 100 / $memoryTotal));
            } else {
                return array(
                    "total" => $memoryTotal,
                    "free" => $memoryFree,
                );
            }
        }
    }
}
if (!function_exists('getNiceFileSize')) {
    function getNiceFileSize($bytes, $binaryPrefix = true)
    {
        if ($binaryPrefix) {
            $unit = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
            if ($bytes == 0) return '0 ' . $unit[0];
            return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . ' ' . (isset($unit[$i]) ? $unit[$i] : 'B');
        } else {
            $unit = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            if ($bytes == 0) return '0 ' . $unit[0];
            return @round($bytes / pow(1000, ($i = floor(log($bytes, 1000)))), 2) . ' ' . (isset($unit[$i]) ? $unit[$i] : 'B');
        }
    }
}
if (!function_exists('CalculatePercentageOfTwoValues')) {

    function CalculatePercentageOfTwoValues($total, $part)
    {
        if ($total == 0) {
            return 0;
        }
        $percentage = number_format(($part / $total) * 100, 2);
        return $percentage;
    }
}
if (!function_exists('PredefinedDateFormatWithoutYear')) {
    function PredefinedDateFormatWithoutYear($read_date)
    {
        if ($read_date != null) {
            $timestamp = strtotime($read_date);

            if ($timestamp === false) {
                return 'Invalid Date';
            }

            return date("D jS M", $timestamp);
        } else {
            return null;
        }
    }
}

if (!function_exists('timeago')) {

    function timeago($date)
    {
        $timestamp = strtotime($date);

        $strTime = array("second", "minute", "hour", "day", "month", "year");
        $length = array("60", "60", "24", "30", "12", "10");

        $currentTime = time();
        if ($currentTime >= $timestamp) {
            $diff     = time() - $timestamp;
            for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return $diff . " " . $strTime[$i] . "(s) ago ";
        }
    }
}
if (!function_exists('NumberToWards')) {
    function NumberToWards($number)
    {
        $words = [
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety'
        ];

        if (!is_numeric($number)) return false;

        if ($number < 0) return 'minus ' . number_to_words(abs($number));

        if ($number <= 20) return $words[$number];

        if ($number < 100) {
            $tens = intval($number / 10) * 10;
            $units = $number % 10;
            return $units ? $words[$tens] . '-' . $words[$units] : $words[$tens];
        }

        if ($number < 1000) {
            $hundreds = intval($number / 100);
            $remainder = $number % 100;
            return $words[$hundreds] . ' hundred' . ($remainder ? ' ' . number_to_words($remainder) : '');
        }

        if ($number < 1000000) {
            $thousands = intval($number / 1000);
            $remainder = $number % 1000;
            return number_to_words($thousands) . ' thousand' . ($remainder ? ' ' . number_to_words($remainder) : '');
        }

        if ($number < 1000000000) {
            $millions = intval($number / 1000000);
            $remainder = $number % 1000000;
            return number_to_words($millions) . ' million' . ($remainder ? ' ' . number_to_words($remainder) : '');
        }

        return 'Number too large';
    }
}
