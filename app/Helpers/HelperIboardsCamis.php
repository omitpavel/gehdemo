<?php

use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundAllotingBedNurse;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\Master\TaskGroup;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundBayStatus;
use App\Models\Iboards\Symphony\Data\SymphonyEDThermometer;
use Carbon\Carbon;
function WardBedShowPatientCharacter($str)
{
    $alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X ', 'Y', 'Z');
    $newName = '';
    do {
        $str--;
        $limit = floor($str / 26);
        $reminder = $str % 26;
        $newName = $alpha[$reminder] . $newName;
        $str = $limit;
    } while ($str > 0);
    return $newName;
}


function TimeDeferInFormat($admit_time, $discharge_time = null)
{
    if ($admit_time == '') {
        return '--';
    }

    if (is_numeric($admit_time)) {
        $admit_date_time = Carbon::createFromTimestamp($admit_time);
    } else {
        $admit_date_time = Carbon::parse($admit_time);
    }

    if ($discharge_time === null) {
        $discharge_date_time = Carbon::now();
    } else {
        if (is_numeric($discharge_time)) {
            $discharge_date_time = Carbon::createFromTimestamp($discharge_time);
        } else {
            $discharge_date_time = Carbon::parse($discharge_time);
        }
    }

    $difference_in_days = $admit_date_time->diffInDays($discharge_date_time);
    $difference_in_hours = $admit_date_time->diffInHours($discharge_date_time) % 24;
    $difference_in_minutes = $admit_date_time->diffInMinutes($discharge_date_time) % 60;
    $difference_in_seconds = $admit_date_time->diffInSeconds($discharge_date_time) % 60;

    if ($difference_in_days >= 1) {
        return $difference_in_days . ' Days ' . $difference_in_hours . ' Hours';
    } elseif ($difference_in_hours >= 1) {
        return $difference_in_hours . ' Hours ' . $difference_in_minutes . ' Minutes';
    } elseif ($difference_in_minutes >= 1) {
        return $difference_in_minutes . ' Minutes ' . $difference_in_seconds . ' Seconds';
    } else {
        return $difference_in_seconds . ' Seconds';
    }
}

function VitalPacTemperatureFormat($value = null)
{
    if ($value != null)
    {
        return  number_format(($value), 1);
    }
    return '0.0';
}




function IboxEstimatedDischargeDateShowBoardround($date_cal)
{
    $calulated_date = strtotime(date('Y-m-d', strtotime($date_cal)));
    $now = strtotime(date('Y-m-d'));
    $datediff = $now - $calulated_date;
    $diff = round($datediff / (60 * 60 * 24));
    $date_text = "";
    if ($diff < 0) {
        if (abs($diff) <= 1) {
            $date_text = "(" . abs($diff) . " Day To)";
        } else {
            $date_text = "(" . abs($diff) . " Days To)";
        }
    } elseif ($diff > 0) {
        if (abs($diff) <= 1) {
            $date_text = "(" . abs($diff) . " Day Over)";
        } else {
            $date_text = "(" . abs($diff) . " Days Over)";
        }
    } else {
        $date_text = "(Today)";
    }
    return date('D d M', strtotime($date_cal)).' '.$date_text;
}

if (!function_exists('GetBedFlagImages'))
{
    function GetBedFlagImages($image_name, $size = 25)
    {

        return '<img src="'.asset('asset_v2/Template/icons/ward_icons/'.str_replace('ibox_patient_flag_', '', $image_name).'.png').'" alt=""  data-bs-toggle="tooltip"
        data-bs-placement="bottom" title="'.ucwords(str_replace('_', ' ', str_replace('ibox_patient_flag_', '', $image_name))).'" width="'.$size.'">';

    }
}


if (!function_exists('GetPotentialDefiniteDischarge')) {
    function GetPotentialDefiniteDischarge($type,$date,$patient_id)
    {
        $pd_data = \App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPotentialDefinite::where('type',$type)->where('patient_id',$patient_id)->whereDate('potential_definite_date',$date)->first();
        if($pd_data!= null)
        {
            return true;
        }else{
            return false;
        }

    }
}
if (!function_exists('GetPotentialDefiniteDischargeType')) {
    function GetPotentialDefiniteDischargeType($type,$date)
    {
        if (!$date) {
            return 'Invalid date';
        }

        // Get today's date, tomorrow's date, and the day after tomorrow's date
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $dayAfterTomorrow = date('Y-m-d', strtotime('+2 days'));

        // Convert the input date to 'Y-m-d' format
        $inputDate = date('Y-m-d', strtotime($date));

        // Define the base message based on type
        $baseMessage = ($type == 1) ? 'Potential' : (($type == 2) ? 'Definite' : 'Invalid type');

        // Return early if type is not 1 or 2
        if ($baseMessage === 'Invalid type') {
            return $baseMessage;
        }

        // Determine the specific message based on the date
        if ($inputDate === $today) {
            return $baseMessage . ' today';
        } elseif ($inputDate === $tomorrow) {
            return $baseMessage . ' tomorrow';
        } elseif ($inputDate === $dayAfterTomorrow) {
            return $baseMessage . ' day after tomorrow';
        } else {
            return 'Date is out of expected range';
        }

    }
}

if (!function_exists('GetPotentialDefiniteDischargeTypeStatus')) {
    function GetPotentialDefiniteDischargeTypeStatus($type,$date)
    {
        if (!$date) {
            return 'Invalid date';
        }

        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $dayAfterTomorrow = date('Y-m-d', strtotime('+2 days'));

        $inputDate = date('Y-m-d', strtotime($date));
        $status = 0;
        if($type == 1){
            if ($inputDate === $today) {
                $status = 1;
            } elseif ($inputDate === $tomorrow) {
                $status = 2;
            } elseif ($inputDate === $dayAfterTomorrow) {
                $status = 3;
            }
        }
        elseif ($type == 2){
            if ($inputDate === $today) {
                $status = 4;
            } elseif ($inputDate === $tomorrow) {
                $status = 5;
            } elseif ($inputDate === $dayAfterTomorrow) {
                $status = 6;
            }
        }
        return $status;


    }
}


if (!function_exists('MatchNumber')) {
    function MatchNumber($text)
    {
        if (preg_match('/\d+/', $text, $matches)) {
            $number = $matches[0];
            return $number;
        } else {
           return null;
        }
    }
}

if (!function_exists('ActionRestrcited'))
{
    function ActionRestrcited()
    {
        return "Sorry Action Restricted!";
    }
}

if (!function_exists('WardList'))
{
    function WardList()
    {
        $permitted_ward = [];
        if (count($permitted_ward) > 0){
            $wards = Wards::where('status',1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->whereIn('ward_url_name',$permitted_ward)->get();
        }else{
            $wards = Wards::where('status',1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->orderBy('ward_name', 'ASC')->get();
        }
        return $wards;
    }
}


if (!function_exists('WardListAsc'))
{
    function WardListAsc()
    {
        $wards = Wards::select('ward_name', 'ward_short_name','id')->where('status', 1)->orderBy('ward_name', 'ASC')->get();
        return $wards;
    }
}


if (!function_exists('GetBedFlagImagesByName'))
{
    function GetBedFlagImagesByName($image_name)
    {
        return str_replace('ibox_patient_flag_', '', $image_name);
    }
}

if(!function_exists('GetFlagName')){
    function GetFlagName($name)
    {
        $result = BoardRoundFlagList::where('patient_flag_stored_name', $name)->first();
        return $result ? $result->patient_flag_name : null;
    }
}

if (!function_exists('CheckSpecificBedFlagsExits'))
{
    function CheckSpecificBedFlagsExitsOnArray($array, $parameter) {
        foreach ($array as $item) {
            if ($item['patient_flag_name'] === $parameter) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('GetSpecificBedFlagsExtraDetailsFromArray'))
{
    function GetSpecificBedFlagsExtraDetailsFromArray($array, $parameter) {
        $result = '';
        foreach ($array as $item) {
            if ($item['patient_flag_name'] === $parameter) {
                $result = json_decode($item['patient_flag_extra_details'], true);
            }
        }
        return $result;
    }
}










function CleanString($string) {
    $string = str_replace(' ', '-', $string);
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    return preg_replace('/-+/', '-', $string);
 }



function GetWardInfectionStatus($status){
    if($status == 1){
        return '<span class="ward-status">Outbreak</span> ';
    } elseif($status == 2){
        return '<span class="ward-status">Red Zone</span> ';
    } elseif($status == 3){
        return '<span class="yellow-zone">Yellow Zone</span> ';
    } elseif($status == 4){
        return '<span class="green-zone">Green Zone</span> ';
    } elseif($status == 5){
        return '<span class="blue-zone">Blue Zone</span> ';
    } else {
        return '';
    }

}



function GetWardInfectionBoxBorder($status,$type){
    if($status == 1){
        return 'color-red';
    } elseif($status == 2){
        return 'color-red';
    } elseif($status == 3){
        return 'color-yellow';
    } elseif($status == 4){
        return 'color-green';
    } elseif($status == 5){
        return 'color-blue';
    } else {
        if($type == 13){
            return 'color-blue';
        }elseif($type == 14){
            return 'color-red';
        }elseif ($type == 16){
            return 'color-green';
        }

    }

}

function GetWardInfectionBadge($status){
    $data = array();
    if($status == 1){
         $data['bg-outbreak'] = 'Outbreak';
    } elseif($status == 2){
        $data['bg-red-zone'] = 'Red Zone';
    } elseif($status == 3){
        $data['bg-yellow-zone'] = 'Yellow Zone';
    } elseif($status == 4){
        $data['bg-green-zone'] = 'Green Zone';
    } elseif($status == 5){
        $data['bg-blue-zone'] = 'Blue Zone';
    }
    return $data;
}


function GetWardOpelStatus(){
    $opel = \App\Models\Iboards\Symphony\Data\OpelCurrentStatus::where('ane_opel_status_data_type', 2)->where('ane_opel_status_data', '!=', 0)->where('ane_opel_status_data_show_status', 1)->first();
    if($opel != null){
        if($opel->ane_opel_status_data == 5){
            return 'Internal 4';
        } else {
            return $opel->ane_opel_status_data;
        }
    } else {
        return 0;
    }
}

function GetWardOpelStatusClass(){
    $opel = \App\Models\Iboards\Symphony\Data\OpelCurrentStatus::where('ane_opel_status_data_type', 2)->where('ane_opel_status_data', '!=', 0)->where('ane_opel_status_data_show_status', 1)->first();
    if($opel != null){

        return $opel->ane_opel_status_data;

    } else {
        return 0;
    }
}


if (!function_exists('PredefinedDobDateAlone'))
{
    function PredefinedDobDateAlone($read_date)
    {
        return date("d-m-Y", strtotime($read_date));
    }
}

if (!function_exists('PredefinedDateAloneFormatChange'))
{
    function PredefinedDateAloneFormatChange($read_date)
    {
        return date("d M, Y", strtotime($read_date));
    }
}


function limitText($text, $limit) {
    if($text != null){
        $text = trim($text);
        if (strlen($text) > $limit) {

            $text = substr($text, 0, $limit);
            $text .= '..';
        }
        return $text;
    }else{
        return '';
    }

}





if (!function_exists('GetCamisOutstandingTaskByGroup'))
{
    function GetCamisOutstandingTaskByGroup($camis_patient_task, $edit_category = 0, $task_group = null, $permision = null)
    {

        if ($task_group != null)
        {
            $task_list = array_values(array_filter($camis_patient_task, function ($item) use ($task_group)
            {
                return $item['task_group'] == $task_group;
            }));

            return \Illuminate\Support\Facades\View::make('Common.View.CamisOutstandingTaskByGroup', compact('task_list', 'edit_category', 'permision'));
        }
        else
        {
            $task_list = $camis_patient_task;
        }
        return \Illuminate\Support\Facades\View::make('Common.View.CamisOutstandingTaskByGroup', compact('task_list', 'edit_category', 'permision'));
    }
}



function GetCamisOutstandingTask($camis_patient_task, $edit_category = 0, $task_category = null, $permision = null)
{

    if ($task_category != null)
    {
        $task_list = array_values(array_filter($camis_patient_task, function ($item) use ($task_category)
        {
            return $item['task_category'] == $task_category;
        }));

        if ($task_category == 6)
        {
            return \Illuminate\Support\Facades\View::make('Common.View.CamisDpOutstandingTask', compact('task_list', 'edit_category', 'permision'));
        }
    }
    else
    {
        $task_list = $camis_patient_task;
    }

    return \Illuminate\Support\Facades\View::make('Common.View.CamisOutstandingTask', compact('task_list', 'edit_category', 'permision'));
}


function GetAllOutstandingTask($camis_patient_task, $edit_category = 0, $task_category = null, $permision = null)
{
    if ($task_category != null)
    {
        $task_list = array_values(array_filter($camis_patient_task, function ($item) use ($task_category)
        {
            return $item['task_category'] == $task_category;
        }));
    }
    else
    {
        $task_list = $camis_patient_task;
    }
    return \Illuminate\Support\Facades\View::make('Common.View.CamisAllOutstandingTask', compact('task_list', 'edit_category', 'permision'));
}

if (!function_exists('GetEwsData')) {
    function GetEwsData($ews, $size, $ews_text = null) {
        $html = '';
        $data = $ews ?? '--';
        if ($ews >= 5) {
            $html = '<div class="ews-wrapper">
                        <span class="ews-text">'.$data.'</span>';
            if ($ews_text !== null) {
                $html .= '<span class="ews-header">EWS</span>';
            }
            $html .= '</div>';
        } else {
            $html = '<div class="ews-wrapper ews-low-value">
                        <span class="ews-text">'.$data.'</span>';
            if ($ews_text !== null) {
                $html .= '<span class="ews-header">EWS</span>';
            }
            $html .= '</div>';
        }
        return $html;
    }
}

if (!function_exists('PatientLos')) {
    function PatientLos($admit_time, $discharge_time = null)
    {
        if (is_numeric($admit_time)) {
            $admit_date_time = Carbon::createFromTimestamp($admit_time);
        } else {
            $admit_date_time = Carbon::parse($admit_time);
        }

        if ($discharge_time === null) {
            $discharge_date_time = Carbon::now();
        } else {
            if (is_numeric($discharge_time)) {
                $discharge_date_time = Carbon::createFromTimestamp($discharge_time);
            } else {
                $discharge_date_time = Carbon::parse($discharge_time);
            }
        }

        $difference_in_days = $admit_date_time->diffInDays($discharge_date_time);
        $difference_in_hours = $admit_date_time->diffInHours($discharge_date_time);
        $difference_in_minutes = $admit_date_time->diffInMinutes($discharge_date_time);

        if ($difference_in_days >= 1) {
            return $difference_in_days . ' Days';
        } elseif ($difference_in_hours >= 1) {
            return $difference_in_hours . ' Hours';
        } else {
            return $difference_in_minutes . ' Minutes';
        }
    }
}



if(!function_exists('CompareDates')) {
    function CompareDates($date1, $date2)
    {
        $timestamp1 = strtotime(str_replace('/', '-', $date1));
        $timestamp2 = strtotime(str_replace('/', '-', $date2));

        if ($timestamp1 == $timestamp2) {
            return 0;
        }

        return ($timestamp1 < $timestamp2) ? -1 : 1;
    }
}


if(!function_exists('GetEwsDataHandover')) {
    function GetEwsDataHandover($ews, $size) {
        $html = '';


        $data = $ews !=''? $ews : '--';

        if($ews >= 5) {
            $html = '<img src="'.asset('asset_v2/Template/icons/ward-summary-triangle.svg').'"
                         alt="" width="'.$size.'" height="'.$size.'">
                    <span class="pac-triangle-text"> '.$data.' </span>';

        } else {

            $html = '<img class="bed_ews" src="'.asset('asset_v2/Template/icons/ward-summary-triangle-grey.svg').'"
                         alt="" width="'.$size.'" height="'.$size.'">
                    <span class="pac-triangle-text"> '.$data.' </span>';
        }


        return $html;
    }
}

if(!function_exists('GetCamisInfoHelp')) {
    function GetCamisInfoHelp()
    {
        $camis_help_section = \App\Models\Common\HelpSection::all();
        $get_img = [];
        foreach($camis_help_section as $help) {
            $get_img[$help->type] = $help->value;
            $get_img[$help->type] = $help->value;
        }
        return $get_img;
    }
}

function SepsistTitle($sep_val)
{
    $retstaus = "";
    if($sep_val == 1)
    {
        $retstaus = "Low";
    }
    elseif($sep_val == 2)
    {
        $retstaus = "Moderate";
    }
    elseif($sep_val == 3)
    {
        $retstaus = "High";
    }
    elseif($sep_val == 4)
    {
        $retstaus = "High";
    }
    else{
        $retstaus = "";
    }
        return $retstaus;
}


function SumCategoriesForWardPerformance($discharge_by_week) {
    return array_reduce($discharge_by_week, function($acc, $item) {
        return $acc + $item;
    }, 0);
}

function SumWeekForWardPerformance($week_data) {
    return [
        'midnight_midday' => SumCategoriesForWardPerformance(array_column($week_data, 'midnight_midday')),
        'midday_4pm' => SumCategoriesForWardPerformance(array_column($week_data, 'midday_4pm')),
        '4pm_midnight' => SumCategoriesForWardPerformance(array_column($week_data, '4pm_midnight'))
    ];
}
if (!function_exists('PredefinedDateFormatShowOnCalendarWithoutDay'))
{
    function PredefinedDateFormatShowOnCalendarWithoutDay($read_date)
    {
        return !empty($read_date) ? date("d M Y", strtotime($read_date)) : '--';
    }
}
function GetANEOpelStatus(){

    return SymphonyEDThermometer::orderBy('date', 'desc')
        ->orderBy('time', 'desc')
        ->where('ed_key', 'current_opel_status')
        ->first()->ed_value ?? 0;
}
if (!function_exists('PredefinedDateFormatForEDD'))
{
    function PredefinedDateFormatForEDD($read_date)
    {
        return !empty($read_date) ? date("D d M y", strtotime($read_date)) : '--';
    }
}

if (!function_exists('PredefinedDateFormatForPD'))
{
    function PredefinedDateFormatForPD($read_date)
    {
        return !empty($read_date) ? date("D jS M Y", strtotime($read_date)) : '--';
    }
}
if (!function_exists('AllTaskGroup'))
{
    function AllTaskGroup()
    {
        return TaskGroup::where('status', 1)->get();
    }
}


if (!function_exists('GetOutstandingTask'))
{
    function GetOutstandingTask($camis_patient_id, $edit_category = 0, $task_category = null)
    {
        $task_list = \App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientTasks::with('PatientTaskCategory', 'PatientTaskGroup')
            ->where('patient_id', $camis_patient_id)
            ->where('task_completed_status', 0)
            ->where('task_not_applicable_status', 0);
        if ($task_category != null)
        {
            $task_list = $task_list->whereIn('task_category', $task_category);
        }
        $task_list = $task_list->latest()->get();
        return \Illuminate\Support\Facades\View::make('Common.View.CamisOutstandingTask', compact('task_list', 'camis_patient_id', 'edit_category'));
    }
}


if (!function_exists('WardType'))
{
    function WardType($id)
    {

        $ward_type_id = optional(\App\Models\Iboards\Camis\Master\Wards::where('ward_name', $id)->first())->ward_type_primary;
        return optional(\App\Models\Iboards\Camis\Master\WardType::find($ward_type_id))->ward_type;
    }
}



if (!function_exists('WardTypeFromShortName'))
{
    function WardTypeFromShortName($id)
    {

        $ward_type_id = optional(\App\Models\Iboards\Camis\Master\Wards::where('ward_short_name', $id)->first())->ward_type_primary;
        return optional(\App\Models\Iboards\Camis\Master\WardType::find($ward_type_id))->ward_type;
    }
}
if (!function_exists('PredefinedDateFormatFor24Hour'))
{
    function PredefinedDateFormatFor24Hour($read_date)
    {
        if ($read_date != null)
        {
            $timestamp = strtotime($read_date);

            if ($timestamp === false) {
                return 'Invalid Date';
            }

            return date("D jS M Y, H:i", $timestamp);
        }
        else
        {
            return null;
        }
    }
}

if (!function_exists('PredefinedDateFormatWithoutDayName'))
{
    function PredefinedDateFormatWithoutDayName($read_date)
    {
        if ($read_date != null)
        {
            $timestamp = strtotime($read_date);

            if ($timestamp === false) {
                return 'Invalid Date';
            }

            return date("jS M Y, H:i", $timestamp);
        }
        else
        {
            return null;
        }
    }
}

if (!function_exists('PredefinedDateFormatForJust24Hour'))
{
    function PredefinedDateFormatForJust24Hour($read_date)
    {
        return date("H:i", strtotime($read_date));
    }
}
if (!function_exists('PredefinedDateFormatOnTask'))
{
    function PredefinedDateFormatOnTask($read_date)
    {
        return date("D d M", strtotime($read_date));
    }
}
if (!function_exists('PredefinedDateFormatMedFitDate'))
{
    function PredefinedDateFormatMedFitDate($read_date)
    {
        return date("d M", strtotime($read_date));
    }
}
if (!function_exists('PredefinedDateFormatBoardRoundTaskToBeCompleted'))
{
    function PredefinedDateFormatBoardRoundTaskToBeCompleted($read_date)
    {
        $carbon_date = Carbon::parse($read_date);

        if ($carbon_date->isToday()) {
            return 'Today ' . $carbon_date->format("H:i");
        } else {
            return $carbon_date->format("D d M Y H:i");
        }
    }


}
if (!function_exists('PredefinedDateFormatDtocCommentDate'))
{
    function PredefinedDateFormatDtocCommentDate($read_date)
    {
        return date("d M y H:i", strtotime($read_date));
    }
}

if (!function_exists('PredefinedStandardDateFormatChangeDateAlone'))
{
    function PredefinedStandardDateFormatChangeDateAlone($read_date)
    {
        return date("Y-m-d", strtotime($read_date));
    }
}

if (!function_exists('CheckSpecificBedFlagsExitsOnArrayWithData')) {
    function CheckSpecificBedFlagsExitsOnArrayWithData($flags, $flagName, $keyname)
    {
        foreach ($flags as $flag) {
            if ($flag['patient_flag_name'] === $flagName) {
                return json_decode($flag['patient_flag_extra_details'], true)[$keyname] ?? null;
            }
        }
        return null;
    }
}

function GetActualBedName($ibox_bed_group_name, $ibox_bed_no, $ibox_bed_group_id = 0)
{
    if ($ibox_bed_group_id != 0) {
        return "{$ibox_bed_group_name} {$ibox_bed_group_id} {$ibox_bed_no}";
    } else {
        return "{$ibox_bed_group_name} {$ibox_bed_no}";
    }
}




function GetBayStatus($ward_id, $bed_group_number, $bed_group_id){

    if($ward_id != '' && $bed_group_number != '' && $bed_group_id != ''){

        return CamisIboxBoardRoundBayStatus::where('ward_id', $ward_id)->where('ibox_bed_group_id', $bed_group_id)->where('ibox_bed_group_number', $bed_group_number)->first()->status ?? 0;
    }
    return 0;
}

function CamisDailySummaryArrayRearrange(array $data)
{
    return array_reduce($data, function ($carry, $item)
    {
        $carry[$item['date']][$item['summary_key']] = $item['summary_value'];
        return $carry;
    }, []);
}
function PatientWiseFlagsUrlForWardSummaryGetAllFlags($flags, $show_on_ward_summary_status_check, $max_array_count)
{
    $show_flags                     = array();
    $return_array                   = array();
    $array_increment                = 0;
    $show_flags_list                = array();
    if (count($show_on_ward_summary_status_check) > 0)
    {
        foreach ($show_on_ward_summary_status_check as $keyss => $rowss)
        {
            $show_flags_list[] =  $keyss;
        }
    }
    if (count($flags) > 0)
    {
        foreach ($flags as $row)
        {
            if ($row['patient_flag_name'] == 'ibox_patient_flag_off_the_ward')
            {
                if (in_array('ibox_patient_flag_off_the_ward', $show_flags_list))
                {
                    $extra_det                                                    = json_decode($row['patient_flag_extra_details'], true);
                    $return_array[$row['patient_flag_name']]['flag_name']         = $row['patient_flag_name'];
                    $return_array[$row['patient_flag_name']]['flag_title']        = $show_on_ward_summary_status_check[$row['patient_flag_name']];
                    $return_array[$row['patient_flag_name']]['flag_status']       = 1;
                    $return_array[$row['patient_flag_name']]['extra_det']         = $extra_det;
                    return $return_array;
                }
            }
        }
    }
    if (count($flags) > 0)
    {
        foreach ($flags as $row)
        {
            if ($row['patient_flag_status_value'] == 1)
            {
                if (in_array($row['patient_flag_name'], $show_flags_list))
                {
                    $extra_det                                                    = json_decode($row['patient_flag_extra_details'], true);
                    $return_array[$row['patient_flag_name']]['flag_name']         = $row['patient_flag_name'];
                    $return_array[$row['patient_flag_name']]['flag_title']        = $show_on_ward_summary_status_check[$row['patient_flag_name']];
                    $return_array[$row['patient_flag_name']]['flag_status']       = 1;
                    $return_array[$row['patient_flag_name']]['extra_det']         = $extra_det;
                    $array_increment++;
                    if ($array_increment >= $max_array_count)
                    {
                        break;
                    }
                }
            }
        }
    }
    return $return_array;
}
if (!function_exists('GetWardSummaryBedFlagImages'))
{
    function GetWardSummaryBedFlagImages($flag_details, $size = 25)
    {
        if(stripos($flag_details['flag_name'], 'aki_flag_') !== false){
            return '<img src="' . asset('asset_v2/Template/icons/ward_icons/' . str_replace('aki_flag_', '', $flag_details['flag_name']) . '.png') . '" alt=""  data-bs-toggle="tooltip" data-bs-placement="bottom" title="AKI" width="' . $size . '">';
        }
        return '<img src="' . asset('asset_v2/Template/icons/ward_icons/' . str_replace('ibox_patient_flag_', '', $flag_details['flag_name']) . '.png') . '" alt=""  data-bs-toggle="tooltip" data-bs-placement="bottom" title="' . $flag_details['flag_title'] . '" width="' . $size . '">';

    }
}

if (!function_exists('GetWardSummaryBedFlagImagesIPC'))
{
    function GetWardSummaryBedFlagImagesIPC($flag_details)
    {
        if(stripos($flag_details['flag_name'], 'aki_flag_') !== false){
            return '<img src="' . asset('asset_v2/Template/icons/ward_icons/' . str_replace('aki_flag_', '', $flag_details['flag_name']) . '.png') . '" alt=""  data-bs-toggle="tooltip" data-bs-placement="bottom" title="AKI" class="icon-ipc">';
        }
        return '<img src="' . asset('asset_v2/Template/icons/ward_icons/' . str_replace('ibox_patient_flag_', '', $flag_details['flag_name']) . '.png') . '" alt=""  data-bs-toggle="tooltip" data-bs-placement="bottom" title="' . $flag_details['flag_title'] . '" class="icon-ipc">';

    }
}
function AllWardListDropdown($id = 'ward_id', $label = 'All Wards', $exclude = array())
{
    $ward_list = Wards::with('PrimaryWardType')->where('status', 1)

    ->where('disabled_on_all_dashboard_except_ward_summary', 0)
    ->orderBy('ward_name', 'asc')
    ->get()->toArray();

    $medical_wards = [];
    $surgical_wards = [];
    $other_wards = [];
    foreach($ward_list as $item){
        if(isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'medical'){
            $medical_wards[] = $item;
        } elseif(isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'surgical'){
            $surgical_wards[] = $item;
        } elseif(isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'others'){
            $other_wards[] = $item;
        }
    }
    return view('Common.View.WardDropdwon', compact('medical_wards', 'surgical_wards', 'other_wards', 'id', 'label'));
}

function AllWardListDropdownShortName($id = 'ward_id', $label = 'All Wards', $exclude = array())
{
    $ward_list = Wards::with('PrimaryWardType')->where('status', 1)

    ->where('disabled_on_all_dashboard_except_ward_summary', 0)
    ->orderBy('ward_name', 'asc')
    ->get()->toArray();

    $medical_wards = [];
    $surgical_wards = [];
    $other_wards = [];
    foreach($ward_list as $item){
        if(isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'medical'){
            $medical_wards[] = $item;
        } elseif(isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'surgical'){
            $surgical_wards[] = $item;
        } elseif(isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'others'){
            $other_wards[] = $item;
        }
    }
    return view('Common.View.WardDropdwonShortName', compact('medical_wards', 'surgical_wards', 'other_wards', 'id', 'label'));
}
function AllWardToIDArray(){
    $wards = Wards::where('status', 1)
        ->where('disabled_on_all_dashboard_except_ward_summary', 0)
        ->pluck('id')->toArray();
        return $wards;
}

function AllWardToShortNameArray(){
    $wards = Wards::where('status', 1)
        ->where('disabled_on_all_dashboard_except_ward_summary', 0)
        ->pluck('ward_short_name')->toArray();
    $wards = array_map('strtolower', $wards);
    return $wards;
}
function WardToIDArray($id){
    $wards = Wards::when($id == 'medical_wards', function ($q)  {
            return $q->where('ward_type_primary', 13);
        })->when($id == 'surgical_wards', function ($q)  {
            return $q->where('ward_type_primary', 14);
        })->when($id == 'others_wards', function ($q)  {
            return $q->where('ward_type_primary', 16);
        })->when(is_numeric($id), function ($q)  use($id){
            return $q->where('id', $id);
        })
        ->where('status', 1)
        ->where('disabled_on_all_dashboard_except_ward_summary', 0)
        ->pluck('id')->toArray();
        return $id;
}
function WardToIDArraySeondary($id){
    $wards = Wards::when($id == 'medical_wards', function ($q)  {
            return $q->where('ward_type_secondary', 13);
        })->when($id == 'women_wards', function ($q)  {
            return $q->where('ward_type_secondary', 17);
        })->when($id == 'surgical_wards', function ($q)  {
            return $q->where('ward_type_secondary', 14);
        })->when($id == 'others_wards', function ($q)  {
            return $q->where('ward_type_secondary', 16);
        })->when(is_numeric($id), function ($q)  use($id){
            return $q->where('id', $id);
        })
        ->where('status', 1)
        ->where('disabled_on_all_dashboard_except_ward_summary', 0)
        ->pluck('id')->toArray();
        return $wards;
}


function ContainsNumberInAmStatus($data, $type, $number){
    $types_string = $type.'_status';

    $array_data = $data[$types_string];
    if(in_array($number, $array_data)){
        return true;
    }
    return false;

}


function CamisPatientGender($gender, $name){
    if(strtolower($gender) == 'male'){
        return '<div class="patient-gender"><img src="'.asset('asset_v2/Template/icons/gender-male.svg') .'" alt=""  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Male"></div><span class="name-span">'.$name.'</span>';
    } elseif(strtolower($gender) == 'female'){
        return '<div class="patient-gender"><img src="'.asset('asset_v2/Template/icons/gender-female.svg') .'" alt=""  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Female"></div><span class="name-span">'.$name.'</span>';
    } else {
        return '<span class="name-span">'.$name.'</span>';
    }
}


if (!function_exists('PredefinedDateFormatShowOnCriticalcareDashboard'))
{
    function PredefinedDateFormatShowOnCriticalcareDashboard($read_date)
    {
        return date("D jS M Y", strtotime($read_date));
    }
}


function PatientCDTStatus($cdt_action_status, $cdt_action_time, $equip_status, $equip_time, $discharge_today_status, $discharge_today_time){
    $cdt_buttons = array();

    if ($cdt_action_status == 1) {
        $cdt_buttons['3'] = $cdt_action_time;
    }
    if ($equip_status == 1) {
        $cdt_buttons['2'] = $equip_time;
    }
    if ($discharge_today_status == 1) {
        $cdt_buttons['1'] = $discharge_today_time;
    }

    if (empty($cdt_buttons)) {
        return ['type' => '', 'html' => ''];
    }

    $max_time = max($cdt_buttons);

    $filtered = array_keys(array_filter($cdt_buttons, function($v) use ($max_time) {
        return $v === $max_time;
    }));

    $keys = max($filtered);

    if($keys == '3'){
        return ['type' => 'border-cdt-actions', 'html' => '<tr class="marked-wrapper">
        <td>
          <div class="header-marked bg-cdt-actions">CDT Actions</div>
        </td>
      </tr>'];
    } else if($keys == '2'){
        return ['type' => 'border-equipment', 'html' => '<tr class="marked-wrapper">
        <td>
          <div class="header-marked bg-equipment">Equipment</div>
        </td>
      </tr>'];
    } else if($keys == '1'){
        return ['type' => 'border-discharge-today', 'html' => '<tr class="marked-wrapper">
        <td>
          <div class="header-marked bg-discharge-today">Discharge For Today</div>
        </td>
      </tr>'];
    }
}

function is_waiting_area(string $area): bool {
    return preg_match('/\bwaiting\b/i', $area) === 1;
}
function isDischargeLoungelWard($row) {
    return (
        (isset($row['ibox_ward_short_name']) && $row['ibox_ward_short_name'] == 'RLTDISCHARGE') ||
        (isset($row['camis_patient_ward']) && $row['camis_patient_ward'] == 'RLTDISCHARGE')
    );
}


function AllowedToMoveModifyPermission(){
    if(session()->get('AD_LOGIN') == 1){
        return true;
    }
    return false;
}
function GetDaysBetween($start_date, $end_date)
{
    $start = Carbon::parse($start_date);
    $end = Carbon::parse($end_date);

    return $start->diffInDays($end);
}
