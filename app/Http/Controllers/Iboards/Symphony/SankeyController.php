<?php

namespace App\Http\Controllers\Iboards\Symphony;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonSymphonyController;
use App\Models\Iboards\Symphony\View\SymphonyAttendanceView;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class SankeyController extends Controller
{
    public function Index(Request $request)
    {
        if(!CheckDashboardPermission('ane_sankey_dashboard_main_view')){
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
        return view('Dashboards.Symphony.Sankey.Index', compact('success_array'));
    }
    public function ContentDataLoad(Request $request)
    {
        $process_array                      = array();
        $success_array                      = array();
        $filter_value                       = $request->filter_value;

        $filter_value_start                     = $request->start_date;
        $filter_value_end                       = $request->end_date;



        $process_array["start_date"]            = ($filter_value_start != "") ? $filter_value_start : CurrentDateOnFormat();
        $process_array["end_date"]              = ($filter_value_end != "") ? $filter_value_end : date('Y-m-d', strtotime('+1 days'));

        $process_array["start_date"]            = date('Y-m-d 00:00:00', strtotime($process_array["start_date"]));
        $process_array["end_date"]              = date('Y-m-d 23:59:59', strtotime($process_array["end_date"]));

        $success_array['date_filter_start_date_date_to_show']     = PredefinedDateFormatShowOnCalendarDashboard($process_array["start_date"]);
        $success_array["filter_value_selected_start_date"]        = PredefinedStandardDateFormatChangeDateAlone($process_array["start_date"]);

        $success_array['date_filter_end_date_date_to_show']       = PredefinedDateFormatShowOnCalendarDashboard($process_array["end_date"]);
        $success_array["filter_value_selected_end_date"]          = PredefinedStandardDateFormatChangeDateAlone($process_array["end_date"]);


        $this->PageDataLoad($process_array, $success_array);
        $view                               = View::make('Dashboards.Symphony.Sankey.IndexDataLoad', compact('success_array'));
        $sections                           = $view->render();
        return $sections;
    }

    public function PageDataLoad(&$process_array, &$success_array)
    {
        $common_controller                                                  = new CommonController;
        $common_controller                                                  = new CommonController;
        $common_symphony_controller                                         = new CommonSymphonyController;
        $query = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', [$process_array["start_date"], $process_array["end_date"]])->get()->toArray();
        $left_ed_data_processed                                                     = $common_controller->ArrayFindInBetweenDateTimeOfFields($query, $process_array["start_date"], $process_array["end_date"], 'symphony_discharge_date');



        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);
        $success_array['sankey_link']                                       = array();
        $nodes                                                              = array();
        $links                                                              = array();
        $x                                                                  = 0;
        $y                                                                  = 0;

        $success_array['attendence_total'] = count($query);
        $success_array['breaches'] = count(array_filter($query, function ($item)
        {
            return (empty($item['breach_reason_name']) || strpos(strtolower($item['breach_reason_name']), 'not set') !== false);
        }));




        $success_array["performance_overall"]              = PerformanceCalculationAne($success_array["breaches"], count($left_ed_data_processed), 0);
        $success_array["admissions"]                       = count(array_filter($query, function ($item)
        {
            return ($item['symphony_discharge_outcome_val'] == 1);
        }));
        $success_array["dta_12_more"]                      = count(array_filter($query, function ($item)
        {
            $request_date = strtotime($item['symphony_request_date']) ?? time();
            $more_than_12_hours = ($request_date - strtotime($item['symphony_arrival_date'])) > (12 * 3600);
            return $more_than_12_hours;
        }));
        $ambulance_arrival = count(array_filter($query, function ($item)
        {
            $arrival_mode = strtolower($item['symphony_arrival_mode']);
            return (strpos($arrival_mode, 'ambulance') !== false);
        }));
        $walk_arrival = count(array_filter($query, function ($item)
        {
            $arrival_mode = strtolower($item['symphony_arrival_mode']);
            return (strpos($arrival_mode, 'ambulance') === false);
        }));
        $all_triage        = array_unique(array_column($query, 'symphony_triage_category'));
        $all_speciality    = array_unique(array_column($query, 'symphony_specialty'));
        $all_breaches      = array_unique(array_column($query, 'breach_reason_name'));
        array_walk($all_triage, function (&$value, $key) {
            if ($value === null) {
                $value = "Triage_Not_Set";
            }
        });


        $old_order     = array_unique(array_column($query, 'symphony_final_location'));
        $desired_order = $process_array['ibox_symphony_final_location_category_main'];
        $all_location = [];
        foreach ($desired_order as $node_name)
        {
            if (in_array($node_name, $old_order))
            {
                $all_location[] = $node_name;
            }
        }
        foreach ($old_order as $node_name)
        {
            if (!in_array($node_name, $all_location))
            {
                $all_location[] = $node_name;
            }
        }
        if ($ambulance_arrival > 0)
        {
            foreach ($all_triage as $triage)
            {

                if (!IsNodeExists('arrival_Ambulance', $nodes))
                {
                    $nodes[$x]['node']                                              = 'arrival_Ambulance';
                    $nodes[$x]['name']                                              = 'arrival_Ambulance';
                    $x++;
                }

                if (!IsNodeExists('triage_'.$triage, $nodes))
                {
                    $nodes[$x]['node']                                              = 'triage_'.$triage;
                    $nodes[$x]['name']                                              = 'triage_'.$triage;
                    $x++;
                }

                if (!IsLinkExists('arrival_Ambulance', 'triage_'.$triage, $links))
                {
                    $links[$y]['source']                                        = 'arrival_Ambulance';
                    $links[$y]['target']                                        = 'triage_'.$triage;
                    $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($triage)
                    {
                        $arrival_mode = strtolower($item['symphony_arrival_mode']);
                        if($triage == 'Triage_Not_Set'){
                            return ($item['symphony_triage_category'] == null && strpos($arrival_mode, 'ambulance') !== false);
                        } else {
                            return ($item['symphony_triage_category'] == $triage && strpos($arrival_mode, 'ambulance') !== false);
                        }

                    }));
                    $y++;
                }
            }
        }
        if ($walk_arrival > 0)
        {
            foreach ($all_triage as $triage)
            {
                if (!IsNodeExists('arrival_Walk_In', $nodes))
                {
                    $nodes[$x]['node']                                              = 'arrival_Walk_In';
                    $nodes[$x]['name']                                              = 'arrival_Walk_In';
                    $x++;
                }

                if (!IsNodeExists('triage_'.$triage, $nodes))
                {
                    $nodes[$x]['node']                                              = 'triage_'.$triage;
                    $nodes[$x]['name']                                              = 'triage_'.$triage;
                    $x++;
                }
                if (!IsLinkExists('arrival_Walk_In', 'triage_'.$triage, $links))
                {
                    $links[$y]['source']                                        = 'arrival_Walk_In';
                    $links[$y]['target']                                        = 'triage_'.$triage;
                    $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($triage)
                    {
                        $arrival_mode = strtolower($item['symphony_arrival_mode']);
                        if($triage == 'Triage_Not_Set'){
                            return ($item['symphony_triage_category'] == null && strpos($arrival_mode, 'ambulance') === false);
                        } else {
                            return ($item['symphony_triage_category'] == $triage && strpos($arrival_mode, 'ambulance') === false);
                        }
                    }));
                    $y++;
                }
            }
        }
        foreach ($all_location as $location)
        {
            foreach ($all_triage as $triage)
            {
                if (!IsNodeExists('location_'.$location, $nodes))
                {
                    $nodes[$x]['node']                                          = 'location_'.$location;
                    $nodes[$x]['name']                                          = 'location_'.$location;
                    $x++;
                }
                if (!IsNodeExists('triage_'.$triage, $nodes))
                {
                    $nodes[$x]['node']                                          = 'triage_'.$triage;
                    $nodes[$x]['name']                                          = 'triage_'.$triage;
                    $x++;
                }
                if (!IsLinkExists('triage_'.$triage, 'location_'.$location, $links))
                {
                    $links[$y]['source']                                        = 'triage_'.$triage;
                    $links[$y]['target']                                        = 'location_'.$location;
                    $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($triage, $location)
                    {
                        if($triage == 'Triage_Not_Set'){
                            return ($item['symphony_triage_category'] == null && $item['symphony_final_location'] == $location);
                        } else {
                            return ($item['symphony_triage_category'] == $triage && $item['symphony_final_location'] == $location);
                        }
                    }));
                    $y++;
                }
            }








            if (!IsNodeExists('time_0_to_1_hours', $nodes))
            {
                $nodes[$x]['node']                                              = 'time_0_to_1_hours';
                $nodes[$x]['name']                                              = 'time_0_to_1_hours';
                $x++;
            }
            if (!IsNodeExists('location_'.$location, $nodes))
            {
                $nodes[$x]['node']                                              = 'location_'.$location;
                $nodes[$x]['name']                                              = 'location_'.$location;
                $x++;
            }
            if (!IsLinkExists('location_'.$location, 'time_0_to_1_hours', $links))
            {
                $links[$y]['source']                                        = 'location_'.$location;
                $links[$y]['target']                                        = 'time_0_to_1_hours';
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($location)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;

                        return ($item['symphony_final_location'] == $location && ($time_difference >= 0 && $time_difference <= 3600));

                }));

                $y++;
            }
            if (!IsNodeExists('time_1_to_2_hours', $nodes))
            {
                $nodes[$x]['node']                                              = 'time_1_to_2_hours';
                $nodes[$x]['name']                                              = 'time_1_to_2_hours';
                $x++;
            }
            if (!IsNodeExists('location_'.$location, $nodes))
            {
                $nodes[$x]['node']                                              = 'location_'.$location;
                $nodes[$x]['name']                                              = 'location_'.$location;
                $x++;
            }
            if (!IsLinkExists('location_'.$location, 'time_1_to_2_hours', $links))
            {
                $links[$y]['source']                                        = 'location_'.$location;
                $links[$y]['target']                                        = 'time_1_to_2_hours';
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($location)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;

                    return ($item['symphony_final_location'] == $location && ($time_difference > 3600 && $time_difference <= 7200));

                }));
                $y++;
            }
            if (!IsNodeExists('time_2_to_4_hours', $nodes))
            {
                $nodes[$x]['node']                                              = 'time_2_to_4_hours';
                $nodes[$x]['name']                                              = 'time_2_to_4_hours';
                $x++;
            }
            if (!IsNodeExists('location_'.$location, $nodes))
            {
                $nodes[$x]['node']                                              = 'location_'.$location;
                $nodes[$x]['name']                                              = 'location_'.$location;
                $x++;
            }
            if (!IsLinkExists('location_'.$location, 'time_2_to_4_hours', $links))
            {
                $links[$y]['source']                                        = 'location_'.$location;
                $links[$y]['target']                                        = 'time_2_to_4_hours';
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($location)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;


                    return ($item['symphony_final_location'] == $location && ($time_difference > 7200 && $time_difference <= 14400));

                }));
                $y++;
            }

            if (!IsNodeExists('time_4_to_8_hours', $nodes))
            {
                $nodes[$x]['node']                                              = 'time_4_to_8_hours';
                $nodes[$x]['name']                                              = 'time_4_to_8_hours';
                $x++;
            }
            if (!IsNodeExists('location_'.$location, $nodes))
            {
                $nodes[$x]['node']                                              = 'location_'.$location;
                $nodes[$x]['name']                                              = 'location_'.$location;
                $x++;
            }
            if (!IsLinkExists('location_'.$location, 'time_4_to_8_hours', $links))
            {
                $links[$y]['source']                                        = 'location_'.$location;
                $links[$y]['target']                                        = 'time_4_to_8_hours';
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($location)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;


                    return ($item['symphony_final_location'] == $location && ($time_difference > 14400 && $time_difference <= 28800));

                }));
                $y++;
            }
            if (!IsNodeExists('time_8_to_12_hours', $nodes))
            {
                $nodes[$x]['node']                                              = 'time_8_to_12_hours';
                $nodes[$x]['name']                                              = 'time_8_to_12_hours';
                $x++;
            }
            if (!IsNodeExists('location_'.$location, $nodes))
            {
                $nodes[$x]['node']                                              = 'location_'.$location;
                $nodes[$x]['name']                                              = 'location_'.$location;
                $x++;
            }
            if (!IsLinkExists('location_'.$location, 'time_8_to_12_hours', $links))
            {
                $links[$y]['source']                                        = 'location_'.$location;
                $links[$y]['target']                                        = 'time_8_to_12_hours';
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($location)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;

                    return $item['symphony_final_location'] == $location && ($time_difference > 28800 && $time_difference <= 43200);

                }));
                $y++;
            }
            if (!IsNodeExists('time_12+_hours', $nodes))
            {
                $nodes[$x]['node']                                              = 'time_12+_hours';
                $nodes[$x]['name']                                              = 'time_12+_hours';
                $x++;
            }
            if (!IsNodeExists('location_'.$location, $nodes))
            {
                $nodes[$x]['node']                                              = 'location_'.$location;
                $nodes[$x]['name']                                              = 'location_'.$location;
                $x++;
            }
            if (!IsLinkExists('location_'.$location, 'time_12+_hours', $links))
            {
                $links[$y]['source']                                        = 'location_'.$location;
                $links[$y]['target']                                        = 'time_12+_hours';
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($location)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;


                    return ($item['symphony_final_location'] == $location && $time_difference > 43200);

                }));
                $y++;
            }






        }

        foreach ($all_breaches as $breach)
        {
            if(empty($breach) || strtolower($breach) == 'not set')
            {
                $breach = 'Breach_Not_Set';
            }


            if (!IsNodeExists('breach_'.$breach, $nodes))
            {
                $nodes[$x]['node']                                              = 'breach_'.$breach;
                $nodes[$x]['name']                                              = 'breach_'.$breach;
                $x++;
            }
            if (!IsNodeExists('time_0_to_1_hours', $nodes))
            {
                $nodes[$x]['node']                                              = 'time_0_to_1_hours';
                $nodes[$x]['name']                                              = 'time_0_to_1_hours';
                $x++;
            }
            if (!IsLinkExists('time_0_to_1_hours', 'breach_'.$breach, $links))
            {
                $links[$y]['source']                                        = 'time_0_to_1_hours';
                $links[$y]['target']                                        = 'breach_'.$breach;
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($breach)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;

                    if(in_array(strtolower($breach), ['breach_not_set', 'not set'])){

                        return ((empty($item['breach_reason_name']) || strtolower($item['breach_reason_name']) == 'not set') && ($time_difference >= 0 && $time_difference <= 3600));
                    }
                    else
                    {
                        return (strtolower($item['breach_reason_name']) == strtolower($breach) && ($time_difference >= 0 && $time_difference <= 3600));
                    }
                }));
                $y++;
            }

            if (!IsNodeExists('breach_'.$breach, $nodes))
            {
                $nodes[$x]['node']                                              = 'breach_'.$breach;
                $nodes[$x]['name']                                              = 'breach_'.$breach;
                $x++;
            }
            if (!IsNodeExists('time_1_to_2_hours', $nodes))
            {
                $nodes[$x]['node']                                              = 'time_1_to_2_hours';
                $nodes[$x]['name']                                              = 'time_1_to_2_hours';
                $x++;
            }
            if (!IsLinkExists('time_1_to_2_hours', 'breach_'.$breach, $links))
            {
                $links[$y]['source']                                        = 'time_1_to_2_hours';
                $links[$y]['target']                                        = 'breach_'.$breach;
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($breach)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    if(in_array(strtolower($breach), ['breach_not_set', 'not set']))
                    {
                        return ((empty($item['breach_reason_name']) || strtolower($item['breach_reason_name']) == 'not set') && ($time_difference > 3600 && $time_difference <= 7200));
                    }
                    else
                    {
                        return (strtolower($item['breach_reason_name']) == strtolower($breach) && ($time_difference > 3600 && $time_difference <= 7200));
                    }
                }));
                $y++;
            }

            if (!IsNodeExists('breach_'.$breach, $nodes))
            {
                $nodes[$x]['node']                                              = 'breach_'.$breach;
                $nodes[$x]['name']                                              = 'breach_'.$breach;
                $x++;
            }
            if (!IsNodeExists('time_2_to_4_hours', $nodes))
            {
                $nodes[$x]['node']                                              = 'time_2_to_4_hours';
                $nodes[$x]['name']                                              = 'time_2_to_4_hours';
                $x++;
            }
            if (!IsLinkExists('time_2_to_4_hours', 'breach_'.$breach, $links))
            {
                $links[$y]['source']                                        = 'time_2_to_4_hours';
                $links[$y]['target']                                        = 'breach_'.$breach;
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($breach)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    if(in_array(strtolower($breach), ['breach_not_set', 'not set']))
                    {
                        return ((empty($item['breach_reason_name']) || strtolower($item['breach_reason_name']) == 'not set') && ($time_difference > 7200 && $time_difference <= 14400));
                    }
                    else
                    {
                        return (strtolower($item['breach_reason_name']) == strtolower($breach) && ($time_difference > 7200 && $time_difference <= 14400));
                    }
                }));
                $y++;
            }

            if (!IsNodeExists('breach_'.$breach, $nodes))
            {
                $nodes[$x]['node']                                              = 'breach_'.$breach;
                $nodes[$x]['name']                                              = 'breach_'.$breach;
                $x++;
            }
            if (!IsNodeExists('time_4_to_8_hours', $nodes))
            {
                $nodes[$x]['node']                                              = 'time_4_to_8_hours';
                $nodes[$x]['name']                                              = 'time_4_to_8_hours';
                $x++;
            }
            if (!IsLinkExists('time_4_to_8_hours', 'breach_'.$breach, $links))
            {
                $links[$y]['source']                                        = 'time_4_to_8_hours';
                $links[$y]['target']                                        = 'breach_'.$breach;
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($breach)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    if(in_array(strtolower($breach), ['breach_not_set', 'not set']))
                    {
                        return ((empty($item['breach_reason_name']) || strtolower($item['breach_reason_name']) == 'not set') && ($time_difference > 14400 && $time_difference <= 28800));
                    }
                    else
                    {

                        return (strtolower($item['breach_reason_name']) == strtolower($breach) && ($time_difference > 14400 && $time_difference <= 28800));
                    }
                }));
                $y++;
            }

            if (!IsNodeExists('breach_'.$breach, $nodes))
            {
                $nodes[$x]['node']                                              = 'breach_'.$breach;
                $nodes[$x]['name']                                              = 'breach_'.$breach;
                $x++;
            }
            if (!IsNodeExists('time_8_to_12_hours', $nodes))
            {
                $nodes[$x]['node']                                              = 'time_8_to_12_hours';
                $nodes[$x]['name']                                              = 'time_8_to_12_hours';
                $x++;
            }
            if (!IsLinkExists('time_8_to_12_hours', 'breach_'.$breach, $links))
            {
                $links[$y]['source']                                        = 'time_8_to_12_hours';
                $links[$y]['target']                                        = 'breach_'.$breach;
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($breach)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    if(in_array(strtolower($breach), ['breach_not_set', 'not set']))
                    {
                        return ((empty($item['breach_reason_name']) || strtolower($item['breach_reason_name']) == 'not set') && ($time_difference > 28800 && $time_difference <= 43200));
                    }
                    else
                    {
                        return (strtolower($item['breach_reason_name']) == strtolower($breach) && ($time_difference > 28800 && $time_difference <= 43200));
                    }
                }));
                $y++;
            }

            if (!IsNodeExists('breach_'.$breach, $nodes))
            {
                $nodes[$x]['node']                                              = 'breach_'.$breach;
                $nodes[$x]['name']                                              = 'breach_'.$breach;
                $x++;
            }
            if (!IsNodeExists('time_12+_hours', $nodes))
            {
                $nodes[$x]['node']                                              = 'time_12+_hours';
                $nodes[$x]['name']                                              = 'time_12+_hours';
                $x++;
            }
            if (!IsLinkExists('time_12+_hours', 'breach_'.$breach, $links))
            {
                $links[$y]['source']                                        = 'time_12+_hours';
                $links[$y]['target']                                        = 'breach_'.$breach;
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($breach)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    if(in_array(strtolower($breach), ['breach_not_set', 'not set']))
                    {
                        return ((empty($item['breach_reason_name']) || strtolower($item['breach_reason_name']) == 'not set') && ($time_difference > 43200));
                    }
                    else
                    {

                        return (strtolower($item['breach_reason_name']) == strtolower($breach) && ($time_difference > 43200));
                    }
                }));
                $y++;
            }
        }

        foreach ($all_breaches as $breach)
        {
            if (empty($breach) || strtolower($breach) == 'not set')
            {
                $breach = 'Breach_Not_Set';
            }
            if (!IsNodeExists('outcome_Admitted', $nodes))
            {
                $nodes[$x]['node']                                              = 'outcome_Admitted';
                $nodes[$x]['name']                                              = 'outcome_Admitted';
                $x++;
            }
            if (!IsNodeExists('breach_'.$breach, $nodes))
            {
                $nodes[$x]['node']                                              = 'breach_'.$breach;
                $nodes[$x]['name']                                              = 'breach_'.$breach;
                $x++;
            }
            if (!IsLinkExists('breach_'.$breach, 'outcome_Admitted', $links))
            {
                $links[$y]['source']                                        = 'breach_'.$breach;
                $links[$y]['target']                                        = 'outcome_Admitted';
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($breach)
                {
                    if(in_array(strtolower($breach), ['breach_not_set', 'not set']))
                    {
                        return (empty($item['breach_reason_name']) || strtolower($item['breach_reason_name']) == 'not set') && ($item['symphony_discharge_outcome_val'] == 1);
                    }
                    else
                    {
                        return (strtolower($item['breach_reason_name']) == strtolower($breach) && $item['symphony_discharge_outcome_val'] == 1);
                    }
                }));
                $y++;
            }
            if (!IsNodeExists('breach_'.$breach, $nodes))
            {
                $nodes[$x]['node']                                              = 'breach_'.$breach;
                $nodes[$x]['name']                                              = 'breach_'.$breach;
                $x++;
            }

            if (!IsNodeExists('outcome_Not-Admitted', $nodes))
            {
                $nodes[$x]['node']                                              = 'outcome_Not-Admitted';
                $nodes[$x]['name']                                              = 'outcome_Not-Admitted';
                $x++;
            }
            if (!IsLinkExists('breach_'.$breach, 'outcome_Not-Admitted', $links))
            {
                $links[$y]['source']                                        = 'breach_'.$breach;
                $links[$y]['target']                                        = 'outcome_Not-Admitted';
                $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($breach)
                {
                    if(in_array(strtolower($breach), ['breach_not_set', 'not set']))
                    {
                        return (empty($item['breach_reason_name']) || strtolower($item['breach_reason_name']) == 'not set') && ($item['symphony_discharge_outcome_val'] == 0);
                    }
                    else
                    {
                        return (strtolower($item['breach_reason_name']) == strtolower($breach) && $item['symphony_discharge_outcome_val'] == 0);
                    }
                }));
                $y++;
            }
            foreach ($all_speciality as $speciality)
            {
                if (empty($speciality))
                {
                    $speciality_value = 'Speciality_Not_Set';
                }
                else
                {
                    $speciality_value = $speciality;
                }
                if (!IsNodeExists('outcome_Admitted', $nodes))
                {
                    $nodes[$x]['node']                                          = 'outcome_Admitted';
                    $nodes[$x]['name']                                          = 'outcome_Admitted';
                    $x++;
                }
                if (!IsNodeExists('sp_'.$speciality_value, $nodes))
                {
                    $nodes[$x]['node']                                          = 'sp_'.$speciality_value;
                    $nodes[$x]['name']                                          = 'sp_'.$speciality_value;
                    $x++;
                }
                if (!IsLinkExists('outcome_Admitted', 'sp_'.$speciality_value, $links))
                {

                    $links[$y]['source']                                        = 'outcome_Admitted';
                    $links[$y]['target']                                        = 'sp_'.$speciality_value;
                    $links[$y]['value']                                         = count(array_filter($query, function ($item) use ($location, $speciality)
                    {
                        if (empty($speciality))
                        {
                            return empty($item['symphony_specialty']) && $item['symphony_discharge_outcome_val'] == 1;
                        }
                        else
                        {
                            return $item['symphony_specialty'] == $speciality && $item['symphony_discharge_outcome_val'] == 1;
                        }
                    }));
                    $y++;
                }
            }
        }
        $success_array['sankey']['nodes']                                   = $nodes;
        $success_array['sankey']['links']                                   = $links;
        $success_array['sankey']['column']                                  = array('Arrival Mode', 'Triage', 'Location', 'Time', 'Breach', 'Speciality');
        $success_array['sankey_link']['total_patients']                     = SymphonyAttendanceView::whereBetween('symphony_arrival_date', [$process_array["start_date"], $process_array["end_date"]])->count();

        if(session()->has('list_array')){
            session()->forget('list_array');
            session()->put('list_array', $success_array['sankey']['links']);
        }else{
            session()->put('list_array', $success_array['sankey']['links']);
        }
    }


    public function NodeDataLoad(Request $request)
    {

        $common_controller                                                  = new CommonController;
        $common_controller                                                  = new CommonController;
        $common_symphony_controller                                         = new CommonSymphonyController;


        $node_name = strtolower(strstr($request->samkey_data, '_', true));
        $node_value = substr(strstr($request->samkey_data, '_'), 1);
        $success_array['source']  = $request->samkey_data;
        $process_array["start_date"]            = $request->start_date;
        $process_array["end_date"]              = $request->end_date;

        $process_array["start_date"]            = date('Y-m-d 00:00:00', strtotime($process_array["start_date"]));
        $process_array["end_date"]              = date('Y-m-d 23:59:59', strtotime($process_array["end_date"]));
        $query = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', [ $process_array["start_date"] , $process_array["end_date"]]);

        if ($node_name == 'arrival') {
            if (strtolower($node_value) == 'ambulance') {
                $query = $query->whereRaw('LOCATE("ambulance", LOWER(`symphony_arrival_mode`)) > 0');
            } else {
                $query = $query->where(function ($query) {
                    $query->whereRaw('LOCATE("ambulance", LOWER(`symphony_arrival_mode`)) = 0')
                          ->orWhereNull('symphony_arrival_mode');
                });
            }
        } elseif ($node_name == 'triage'){

            if(strtolower($node_value) != 'triage_not_set'){
                $query = $query->whereRaw('LOWER(`symphony_triage_category`) = ?', [str_replace('_', ' ', strtolower($node_value))]);
            } else {
                $query = $query->whereNull('symphony_triage_category');
            }
        } elseif ($node_name == 'location'){
            $query = $query->whereRaw('LOWER(`symphony_final_location`) = ?', [str_replace('_', ' ', strtolower($node_value))]);
        } elseif ($node_name == 'time'){
            if(strtolower($node_value) == '0_to_1_hours'){

                $query = $query->where(function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) >= ?', [0])
                          ->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) <= ?', [3600]);
                });
            } else if(strtolower($node_value) == '1_to_2_hours'){
                $query = $query->where(function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) > ?', [3600])
                          ->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) <= ?', [7200]);
                });
            } else if(strtolower($node_value) == '2_to_4_hours'){
                $query = $query->where(function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) > ?', [7200])
                          ->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) <= ?', [14400]);
                });
            } else if(strtolower($node_value) == '4_to_8_hours'){
                $query = $query->where(function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) > ?', [14400])
                          ->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) <= ?', [28800]);
                });
            } else if(strtolower($node_value) == '8_to_12_hours'){
                $query = $query->where(function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) > ?', [28800])
                          ->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) <= ?', [43200]);
                });
            } else if(strtolower($node_value) == '12__hours'){

                $query = $query->where(function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) > ?', [43200]);
                });
            }

        } elseif ($node_name == 'breach'){

            if(!in_array(strtolower($node_value), ['breach_not_set', 'not set'])){


                $value = str_replace('_', ' ', strtolower($node_value));
                $query = $query->whereRaw('LOWER(`breach_reason_name`) = ?', [$value]);
            } else {
                $query = $query->where(function ($query) {
                    $query->where('breach_reason_name', 'not set')
                          ->orWhereNull('breach_reason_name');
                });

            }
        } elseif ($node_name == 'outcome'){
            if(strtolower($node_value) == 'admitted'){

                $query = $query->where('symphony_discharge_outcome_val', 1);
            } else {
                $query = $query->where('symphony_discharge_outcome_val', 0);
            }

        } elseif ($node_name == 'sp'){
            if(strtolower($node_value) != 'speciality_not_set'){
                $query = $query->whereRaw('LOWER(`symphony_specialty`) = ?', [str_replace('_', ' ', strtolower($node_value))])->where('symphony_discharge_outcome_val', 1);
            } else {
                $query = $query->whereNull('symphony_specialty')->where('symphony_discharge_outcome_val', 1);
            }
        }

        $query = $query->get()->toArray();
        $success_array['arrival']['ambulance'] = count(array_filter($query, function ($item) {
                                                $arrival_mode = strtolower($item['symphony_arrival_mode']);
                                                return (strpos($arrival_mode, 'ambulance') !== false);


                                            }));
        $success_array['arrival']['walk_in']  = count(array_filter($query, function ($item) {
                                                $arrival_mode = strtolower($item['symphony_arrival_mode']);
                                                return (strpos($arrival_mode, 'ambulance') === false);


                                            }));


        $all_triage        = array_unique(array_column($query, 'symphony_triage_category'));
        $all_speciality    = array_unique(array_column($query, 'symphony_specialty'));
        $all_breaches      = array_unique(array_column($query, 'breach_reason_name'));
        array_walk($all_triage, function (&$value, $key) {
            if ($value === null) {
                $value = "Triage_Not_Set";
            }
        });

        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);
        $old_order     = array_unique(array_column($query, 'symphony_final_location'));
        $desired_order = $process_array['ibox_symphony_final_location_category_main'];
        $all_location = [];
        foreach ($desired_order as $node_name)
        {
            if (in_array($node_name, $old_order))
            {
                $all_location[] = $node_name;
            }
        }
        foreach ($old_order as $node_name)
        {
            if (!in_array($node_name, $all_location))
            {
                $all_location[] = $node_name;
            }
        }
        foreach($all_triage as $triage){
            if($triage == 'Triage_Not_Set'){
                $success_array['triage']['Triage_Not_Set']  = count(array_filter($query, function ($item)
                {
                    return ($item['symphony_triage_category'] == null);
                }));

            } else {
                $success_array['triage'][$triage]  = count(array_filter($query, function ($item) use ($triage)
                {
                    return ($item['symphony_triage_category'] == $triage);
                }));
            }
        }

        foreach ($all_location as $location)
        {
            $success_array['location'][$location]  = count(array_filter($query, function ($item) use ($location)
            {
                return (strtolower($item['symphony_final_location']) == strtolower($location));
            }));
        }

        $success_array['time']['0_to_1_hr']  = count(array_filter($query, function ($item)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    return ($time_difference >= 0 && $time_difference <= 3600);
                }));
        $success_array['time']['1_to_2_hr']  = count(array_filter($query, function ($item)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    return ($time_difference > 3600 && $time_difference <= 7200);
                }));

        $success_array['time']['2_to_4_hr']  = count(array_filter($query, function ($item)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    return ($time_difference > 7200 && $time_difference <= 14400);
                }));
        $success_array['time']['4_to_8_hr']  = count(array_filter($query, function ($item)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    return ($time_difference > 14400 && $time_difference <= 28800);
                }));

            $success_array['time']['8_to_12_hr']  = count(array_filter($query, function ($item)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    return ($time_difference > 28800 && $time_difference <= 43200);

                }));
            $success_array['time']['12_+_hr']  = count(array_filter($query, function ($item)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    return ($time_difference > 43200);

                }));


        foreach ($all_breaches as $breach)
        {

            if(empty($breach)){
                $breach = 'breach_not_set';
            }
            if(in_array(strtolower($breach), ['breach_not_set', 'not set']))
            {
                $success_array['breach']['Breach_Not_Set']  = count(array_filter($query, function ($item) use ($breach){
                    return (empty($item['breach_reason_name']) || strtolower($item['breach_reason_name']) == 'not set');
                }));

            } else {
                $success_array['breach'][$breach]  = count(array_filter($query, function ($item) use ($breach){
                    return (strtolower($item['breach_reason_name']) == strtolower($breach));
                }));
            }

        }

        $success_array['outcome']['admitted']  = count(array_filter($query, function ($item)
            {
                return ($item['symphony_discharge_outcome_val'] == 1);
            }));
        $success_array['outcome']['non_admitted']  = count(array_filter($query, function ($item)
            {
                return ($item['symphony_discharge_outcome_val'] == 0);
            }));

        foreach ($all_speciality as $speciality)
        {
            if (empty($speciality))
            {
                $success_array['speciality']['Specciality_Not_Set']  = count(array_filter($query, function ($item) use ($speciality){
                    return (empty($item['symphony_specialty']) && $item['symphony_discharge_outcome_val'] == 1);
                }));

            } else {
                $success_array['speciality'][$speciality]  = count(array_filter($query, function ($item) use ($speciality){
                    return (strtolower($item['symphony_specialty']) == strtolower($speciality) && $item['symphony_discharge_outcome_val'] == 1);
                }));
            }

        }
        return view('Dashboards.Symphony.Sankey.Datalist',compact('success_array'));
    }

    public function CategoryWiseDataLoad(Request $request)
    {
        $node_name = strtolower(strstr($request->source, '_', true));
        $node_value = substr(strstr($request->source, '_'), 1);
        $target_node_name = strtolower(strstr($request->target, '_', true));
        $target_node_value = substr(strstr($request->target, '_'), 1);

        $process_array["start_date"]            = $request->start_date;
        $process_array["end_date"]              = $request->end_date;

        $process_array["start_date"]            = date('Y-m-d 00:00:00', strtotime($process_array["start_date"]));
        $process_array["end_date"]              = date('Y-m-d 23:59:59', strtotime($process_array["end_date"]));
        $query = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', [$process_array["start_date"], $process_array["end_date"]]);

        if ($node_name == 'arrival') {
            if (strtolower($node_value) == 'ambulance') {
                $query = $query->whereRaw('LOCATE("ambulance", LOWER(`symphony_arrival_mode`)) > 0');
            } else {
                $query = $query->where(function ($query) {
                    $query->whereRaw('LOCATE("ambulance", LOWER(`symphony_arrival_mode`)) = 0')
                          ->orWhereNull('symphony_arrival_mode');
                });
            }
        } elseif ($node_name == 'triage'){

            if(strtolower($node_value) != 'triage_not_set'){
                $query = $query->whereRaw('LOWER(`symphony_triage_category`) = ?', [str_replace('_', ' ', strtolower($node_value))]);
            } else {
                $query = $query->whereNull('symphony_triage_category');
            }
        } elseif ($node_name == 'location'){
            $query = $query->whereRaw('LOWER(`symphony_final_location`) = ?', [str_replace('_', ' ', strtolower($node_value))]);
        } elseif ($node_name == 'time'){
            if(strtolower($node_value) == '0_to_1_hours'){

                $query = $query->where(function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) >= ?', [0])
                          ->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) <= ?', [3600]);
                });
            } else if(strtolower($node_value) == '1_to_2_hours'){
                $query = $query->where(function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) > ?', [3600])
                          ->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) <= ?', [7200]);
                });
            } else if(strtolower($node_value) == '2_to_4_hours'){
                $query = $query->where(function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) > ?', [7200])
                          ->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) <= ?', [14400]);
                });
            } else if(strtolower($node_value) == '4_to_8_hours'){
                $query = $query->where(function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) > ?', [14400])
                          ->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) <= ?', [28800]);
                });
            } else if(strtolower($node_value) == '8_to_12_hours'){
                $query = $query->where(function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) > ?', [28800])
                          ->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) <= ?', [43200]);
                });
            } else if(strtolower($node_value) == '12__hours'){

                $query = $query->where(function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(SECOND, symphony_arrival_date, IFNULL(symphony_discharge_date, NOW())) > ?', [43200]);
                });
            }

        } elseif ($node_name == 'breach'){
            if(!in_array(strtolower($node_value), ['breach_not_set', 'not set'])){


                $value = str_replace('_', ' ', strtolower($node_value));
                $query = $query->whereRaw('LOWER(`breach_reason_name`) = ?', [$value]);
            } else {
                $query->where(function ($query) {
                    $query->where('breach_reason_name', 'not set')
                          ->orWhereNull('breach_reason_name');
                });

            }
        } elseif ($node_name == 'outcome'){
            if(strtolower($node_value) == 'admitted'){

                $query = $query->where('symphony_discharge_outcome_val', 1);
            } else {
                $query = $query->where('symphony_discharge_outcome_val', 0);
            }

        } elseif ($node_name == 'sp'){
            if(strtolower($node_value) != 'speciality_not_set'){
                $query = $query->whereRaw('LOWER(`symphony_specialty`) = ?', [str_replace('_', ' ', strtolower($node_value))])->where('symphony_discharge_outcome_val', 1);
            } else {
                $query = $query->whereNull('symphony_specialty')->where('symphony_discharge_outcome_val', 1);
            }
        }

        $query = $query->get()->toArray();
        $patients = array();;

        if ($target_node_name == 'arrival') {
            if (strtolower($target_node_value) == 'ambulance') {
                $patients = array_filter($query, function ($item) {
                    $arrival_mode = strtolower($item['symphony_arrival_mode']);
                    return (strpos($arrival_mode, 'ambulance') !== false);
                });
            } else {
                $patients = array_filter($query, function ($item) {
                    $arrival_mode = strtolower($item['symphony_arrival_mode']);
                    return (strpos($arrival_mode, 'ambulance') === false);
                });
            }
        } elseif ($target_node_name == 'triage'){

            if(strtolower($target_node_value) != 'triage_not_set'){
                $patients = array_filter($query, function ($item) use($target_node_value) {
                    return strtolower($item['symphony_triage_category']) == strtolower($target_node_value);
                });
            } else {
                $patients = array_filter($query, function ($item) {
                    return $item['symphony_triage_category'] == null;
                });
            }

        } elseif ($target_node_name == 'location'){
            $patients = array_filter($query, function ($item) use ($target_node_value)
            {
                return (strtolower($item['symphony_final_location']) == strtolower($target_node_value));
            });
        } elseif ($target_node_name == 'time'){
            if(strtolower($target_node_value) == '0_to_1_hr'){

                $patients = array_filter($query, function ($item)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    return ($time_difference >= 0 && $time_difference <= 3600);
                });
            } else if(strtolower($target_node_value) == '1_to_2_hr'){
                $patients = array_filter($query, function ($item)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    return ($time_difference > 3600 && $time_difference <= 7200);
                });
            } else if(strtolower($target_node_value) == '2_to_4_hr'){
                $patients = array_filter($query, function ($item)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    return ($time_difference > 7200 && $time_difference <= 14400);
                });
            } else if(strtolower($target_node_value) == '4_to_8_hr'){
                $patients = array_filter($query, function ($item)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    return ($time_difference > 14400 && $time_difference <= 28800);
                });
            } else if(strtolower($target_node_value) == '8_to_12_hr'){
                $patients = array_filter($query, function ($item)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    return ($time_difference > 28800 && $time_difference <= 43200);

                });
            } else if(strtolower($target_node_value) == '12_+_hr'){

                $patients = array_filter($query, function ($item)
                {
                    $discharge_timestamp = $item['symphony_discharge_date'] ? strtotime($item['symphony_discharge_date']) : time();
                    $registration_timestamp = strtotime($item['symphony_arrival_date']);
                    $time_difference = $discharge_timestamp - $registration_timestamp;
                    return ($time_difference > 43200);
                });
            }
        } elseif ($target_node_name == 'breach'){

            if (strtolower($target_node_value) === 'breach_not_set')
            {
                $patients = array_filter($query, function ($item) use ($target_node_value){
                    return (empty($item['breach_reason_name']) || strtolower($item['breach_reason_name']) == 'not set');
                });
            } else {
                $patients = array_filter($query, function ($item) use ($target_node_value){
                    return (strtolower($item['breach_reason_name']) == strtolower($target_node_value));
                });
            }

        } elseif ($target_node_name == 'outcome'){
            if(strtolower($target_node_value) == 'admitted'){

                $patients  = array_filter($query, function ($item)
                {
                    return ($item['symphony_discharge_outcome_val'] == 1);
                });
            } else {
                $patients  = array_filter($query, function ($item)
                {
                    return ($item['symphony_discharge_outcome_val'] == 0);
                });
            }

        } elseif ($target_node_name == 'sp'){

            if(strtolower($target_node_value) != 'speciality_not_set'){
                $patients = array_filter($query, function ($item) use ($target_node_value){
                    return (strtolower($item['symphony_specialty']) == strtolower($target_node_value) && $item['symphony_discharge_outcome_val'] == 1);
                });

            } else {
                $patients =array_filter($query, function ($item) {
                    return (empty($item['symphony_specialty']) && $item['symphony_discharge_outcome_val'] == 1);
                });
            }
        }
        $time_for_discharge = function($item) {
            $arrival_timestamp = strtotime($item['symphony_arrival_date']);
            $discharge_timestamp = !empty($item['symphony_discharge_date']) ? strtotime($item['symphony_discharge_date']) : time();

            $time_differenceHours = ($discharge_timestamp - $arrival_timestamp) / 60;

            $item['time_difference_hours'] = ConvertMinutesToHourMinutesWithText($time_differenceHours);
            return $item;
        };

        $patients = array_map($time_for_discharge, $patients);

        return view('Dashboards.Symphony.Sankey.CategoryWiseData', compact('patients'));
    }
}
