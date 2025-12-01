<?php
if (!function_exists('PerformanceCalculationAne'))
{
    function PerformanceCalculationAne($value_1, $value_2,$decimals=0)
    {
        $performance_val                    = 100;
        $performance_val                    = ($value_2 != 0 && $value_1 != 0) ? (1 - ($value_1 / $value_2)) * 100 : (($value_1 != 0) ? 0 : 100);
        $performance_val                    = ($performance_val > 100) ? 100 : $performance_val;
        $performance_val                    = ($performance_val < 0) ? 0 : $performance_val;
        $performance_val                    = number_format(abs($performance_val),$decimals, '.', '');
        return $performance_val;
    }
}

if (!function_exists('CategoryWiseFillter')) {

    function CategoryWiseFillter($process_array, $ed_data)
    {
        if ($process_array['type'] == 'Majors') {
          return $ed_data["Majors"];
        } elseif ($process_array['type'] == 'Resus') {
            return  $ed_data["Resus"];
        } elseif ($process_array['type'] == 'Paeds') {
            return  $ed_data["Paeds"];
        } elseif ($process_array['type'] == 'UTC') {
            return  $ed_data["UTC"];
        } elseif ($process_array['type'] == 'Others') {
            return  $ed_data["Others"];
        } else {
            return  array_merge($ed_data["Majors"], $ed_data["Resus"], $ed_data["Paeds"], $ed_data["UTC"], $ed_data["Others"]);
        }

    }
}


if (!function_exists('AneLiveStatusBarChartColour'))
{
    function AneLiveStatusBarChartColour($minutes)
    {
        $return_string          =    "2fb07d";
        if($minutes >= 300)
        {
            $return_string      =    "9450c2";
        }
        else if ($minutes >=210)
        {
            $return_string      =    "ff695d";
        }
        else if ($minutes >= 180)
        {
            $return_string      =    "fc8432";
        }
        else if ($minutes >= 90)
        {
            $return_string      =    "ffe44a";
        }
        return $return_string;
    }
}
if (!function_exists('PerformanceShowTextColourSetting'))
{
    function PerformanceShowTextColourSetting($performance_value)
    {
        $return_colour_value            = "#000000";
        switch ($performance_value)
        {
            case ($performance_value >= 85):
                $return_colour_value    = "#129c4a";
                break;
            case ($performance_value >= 80):
                $return_colour_value    = "#f49929";
                break;
            case ($performance_value >= 76):
                $return_colour_value    = "#e42627";
                break;
        }
        return $return_colour_value;
    }
}
if (!function_exists('PerformanceShowGuageColourSetting'))
{
    function PerformanceShowGuageColourSetting($performance_value)
    {
        if ($performance_value >= 80) {
            return "bars-green";
        } elseif ($performance_value >= 76) {
            return "bars-orange";
        } elseif ($performance_value >= 73) {
            return "bars-red";
        } else {
            return "bars-black";
        }
    }

}

if (!function_exists('PerformanceShowGuageBorderColourSetting'))
{
    function PerformanceShowGuageBorderColourSetting($performance_value)
    {
        if ($performance_value >= 80) {
            return "bars-border-green";
        } elseif ($performance_value >= 76) {
            return "bars-border-orange";
        } elseif ($performance_value >= 73) {
            return "bars-border-red";
        } else {
            return "bars-border-black";
        }
    }
}
if (!function_exists('AneFloorMappingCategoryShorten'))
{
    function AneFloorMappingCategoryShorten($string)
    {
        $return_string              = "";
        switch ($string)
         {
            case 'Majors':
                $return_string      = 'Majors';
                break;
            case 'Paed Eds':
                $return_string      = 'Paeds';
                break;
            case 'UTC':
                $return_string      = 'UTC';
                break;
            case 'Resus':
                $return_string      = 'Resus';
                break;
            case 'Others':
                $return_string      = 'Others';
                break;
        }
        return $return_string;
    }
}
if (!function_exists('AneFloorMappingCategory'))
{
    function AneFloorMappingCategory($string)
    {
        $return_string              = "Others";
        switch (true)
        {
            case stristr($string, 'Resus'):
                $return_string      = "Resus";
                break;
            case stristr($string, 'Majors'):
                $return_string      = "Majors";
                break;
            case stristr($string, 'UTC'):
                $return_string      = "UTC";
                break;
            case stristr($string, 'Paed Eds'):
                $return_string      = "Paed Eds";
                break;
        }
        return $return_string;
    }
}


function CalculateHourlyBreachPerformancePerformance($item) {
    $performance = PerformanceCalculationAne($item['breaches'], $item['left_ed'],  0);
    $item['performance'] = $performance;
    return $item;
}

function CalculateHourlyBreachPerformancePerformanceHourly($item) {
    $performance = PerformanceCalculationAne($item['ane_attendance_breaches'], $item['ane_attendance_left_ed'],  0);
    $item['ane_attendance_performance'] = $performance;
    return $item;
}

function EDDailySummaryArrayRearrange(array $data) {
    return array_reduce($data, function($carry, $item) {
        $carry[$item['ed_summary_date']][$item['ed_summary_key_value']] = $item['ed_summary_value'];
        return $carry;
    }, []);
}


function SumSymphonyDailySUmmary(array $transformedData, $key) {
    $allAttendances = array_map(function($dateSummary) use($key){
        return $dateSummary[$key] ?? 0;
    }, $transformedData);

    return array_sum($allAttendances);
}
function SymphonyPatientGender($gender, $name){
    if(strtolower($gender) == 'male'){
        return '<div class="patient-gender"><img src="'.asset('asset_v2/Template/icons/gender-male.svg') .'" alt=""  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Male"></div><span>'.$name.'</span>';
    } elseif(strtolower($gender) == 'female'){
        return '<div class="patient-gender"><img src="'.asset('asset_v2/Template/icons/gender-female.svg') .'" alt=""  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Female"></div><span>'.$name.'</span>';
    } else {
        return '<span>'.$name.'</span>';
    }
}