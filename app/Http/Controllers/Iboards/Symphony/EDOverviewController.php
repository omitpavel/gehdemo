<?php

namespace App\Http\Controllers\Iboards\Symphony;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Governance\GovernanceController;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonSymphonyController;
use Illuminate\Support\Facades\View;
use App\Models\Iboards\Symphony\Data\SymphonyAttendance;
use App\Models\Iboards\Symphony\View\SymphonyAttendanceView;
use Illuminate\Support\Facades\DB;
use Session;
use Sentinel;
class EDOverviewController extends Controller
{
    public function Index()
    {
        $common_controller                  = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;
        $process_array                      = array();
        $success_array                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);
        $process_array["referral_type"]     = 'ED';
        $process_array["start_date"]        = CurrentDateOnFormat();
        $process_array["tab_filter_mode"]   = 1;
        $success_array["page_sub_title"]    = date('l jS F H:i');
        CalculateStartEndDateAccordingSelection($process_array["start_date"],$process_array["end_date"],"day");
        $this->EdOverviewAttendanceDataProcess($success_array,$process_array);
        $this->EdOverviewReferalPlotingDataSummary($success_array,$process_array);


        return view('Dashboards.Symphony.EDOverview.Index', compact('success_array'));
    }



    public function ContentDataLoad(Request $request)
    {
        $common_controller  = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;
        $process_array      = array();
        $success_array      = array();

        $tab_filter_mode    = $request->tab_filter_mode;

        $process_array["tab_filter_mode"] = $tab_filter_mode;
        $success_array["tab_filter_mode"] = $tab_filter_mode;
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);


        if ($tab_filter_mode == 1 || $tab_filter_mode == 2)
        {
            if ($tab_filter_mode == 1)
            {
                if(CheckSpecificPermission('ed_live_summary_view')){
                    $process_array["referral_type"] = 'ED';
                    $process_array["start_date"]    = CurrentDateOnFormat();
                    CalculateStartEndDateAccordingSelection($process_array["start_date"],$process_array["end_date"],"day");
                    $this->EdOverviewAttendanceDataProcess($success_array,$process_array);
                    $this->EdOverviewReferalPlotingDataSummary($success_array,$process_array);
                    $view = View::make('Dashboards.Symphony.EDOverview.IndexDataLoadTabContent1', compact('success_array'));
                    $sections = $view->render();
                    return $sections;
                } else {
                    return PermissionDenied();
                }

            }
            elseif ($tab_filter_mode == 2)
            {
                if(CheckSpecificPermission('ed_day_summary_view')){
                    $filter_value                   = $request->filter_value;
                    $process_array["referral_type"] = 'ED';
                    $process_array["start_date"]    = ($filter_value != "") ? $filter_value : CurrentDateOnFormat();
                    CalculateStartEndDateAccordingSelection($process_array["start_date"],$process_array["end_date"],"day");
                    $this->EdOverviewAttendanceDataProcess($success_array,$process_array);
                    $this->EdOverviewReferalPlotingDataSummary($success_array,$process_array);
                    $success_array['date_filter_tab_2_date_to_show'] = PredefinedDateFormatShowOnCalendarDashboardSecond($process_array["start_date"]);
                    $success_array["filter_value_selected"]     = PredefinedStandardDateFormatChangeDateAlone($process_array["start_date"]);
                    $view = View::make('Dashboards.Symphony.EDOverview.IndexDataLoadTabContent2', compact('success_array'));
                    $sections = $view->render();
                    return $sections;
                } else {
                    return PermissionDenied();
                }
            }
        }
        else
        {
            return false;
        }
    }




    public function EdOverviewAttendanceDataProcess(&$success_array, &$process_array)
    {
        $common_symphony_controller = new CommonSymphonyController;
        $common_controller  = new CommonController;
        $process_array["patient_type_all_ed_overview_single"]               = array();
        $process_array["ibox_symphony_ed_overview_main_patient_category_with_index"] = [
            "ED"  => "",
            "UTC" => "",
            "COA" => "",
            "FAU" => "",
            "SDEC" => "",
            "SAU" => ""
        ];
        $process_array["ibox_symphony_ed_overview_ward_main_patient_category_with_index"] = ['COA', 'FAU', 'SDEC', 'SAU'];
        if (CheckCountArrayToProcess($process_array["ibox_symphony_ed_overview_main_patient_category_with_index"]))
        {
            foreach ($process_array["ibox_symphony_ed_overview_main_patient_category_with_index"] as $key=>$val)
            {
                if(!in_array($key,$process_array["ibox_symphony_ed_overview_ward_main_patient_category_with_index"])) {
                    $process_array["patient_type_all_ed_overview_single"][] = $key;
                }
            }
        }



        $all_attendance_query   = SymphonyAttendanceView::where('id','<>','');
        if($process_array["tab_filter_mode"] == 1)
        {
            $all_attendance_query->where('symphony_still_in_ae','=',1);
        }
        else
        {
            $all_attendance_query->whereBetween('symphony_registration_date_time', array($process_array["start_date"], $process_array["end_date"]));
        }

        $all_attendance_query->orderBy('symphony_registration_date_time', 'ASC');
        $attendance_data_processed         = $all_attendance_query->get()->toArray();

        $process_array["start_date_last_1000"]  = CurrentDateOnFormat();
        $process_array["end_date_last_1000"]    = "";
        CalculateStartEndDateAccordingSelection($process_array["start_date_last_1000"], $process_array["end_date_last_1000"], "last 1000");

        $all_attendance_discharged_query                = SymphonyAttendanceView::where('id','<>','');
        $all_attendance_discharged_query->where('symphony_discharge_outcome_val','=',0);
        $all_attendance_discharged_query->whereBetween('symphony_registration_date_time', array($process_array["start_date_last_1000"], $process_array["end_date_last_1000"]));
        $all_attendance_discharged_query->orderBy('symphony_registration_date_time', 'ASC')->limit(2000);
        $attendance_discharged_data_processed           = $all_attendance_discharged_query->get()->toArray();


        $array_with_attendance_type_processed                                       = $this->GetArrayWithattendanceTypeOfAttendance($attendance_data_processed,$process_array["patient_type_all_ed_overview_single"],$process_array["ibox_symphony_ed_overview_ward_main_patient_category_with_index"]);

        $array_with_discharged_attendance_type_processed                            = $this->GetArrayWithattendanceTypeOfAttendance($attendance_discharged_data_processed,$process_array["patient_type_all_ed_overview_single"],$process_array["ibox_symphony_ed_overview_ward_main_patient_category_with_index"]);
        $ed_overview_speciality_row_data                                            = array();

        $text_inside_type                                                           = $process_array["ibox_symphony_ed_overview_main_patient_category_with_index"];


        if (CheckCountArrayToProcess($array_with_attendance_type_processed))
        {
            $x                                                          = 1;
            foreach ($array_with_attendance_type_processed as $key=>$val)
            {
                $difference_in_minutes_array                                        = array();
                if(isset($text_inside_type[$key]))
                {
                    $text_show_inside                                               = $text_inside_type[$key];
                }
                else
                {
                    $text_show_inside                                               = $key;
                }
                $ed_overview_speciality_row_data[$key]["speciality"]                = $key;
                $ed_overview_speciality_row_data[$key]["speciality_bottom_text"]    = $text_show_inside;
                $common_symphony_controller->AneEdOverviewTimeSeriesDataProcess($val,$ed_overview_speciality_row_data[$key]["time_series"],$process_array);

                $common_controller->DifferenceBetweenTwoTimesFromArray($val,$difference_in_minutes_array,"symphony_registration_date_time","symphony_discharge_date");
                $ed_overview_speciality_row_data[$key]["arrival"]["average_time"]   = "--";
                $ed_overview_speciality_row_data[$key]["arrival"]["longest_wait"]   = "--";
                if(count($difference_in_minutes_array) > 0)
                {
                    $ed_overview_speciality_row_data[$key]["arrival"]["average_time"]               = ConvertMinutesToHourMinutesWithTextFormated(round(array_sum($difference_in_minutes_array) / count($difference_in_minutes_array)));
                    $ed_overview_speciality_row_data[$key]["arrival"]["longest_wait"]               = ConvertMinutesToHourMinutesWithTextFormated(max($difference_in_minutes_array));
                }

                if(!isset($array_with_discharged_attendance_type_processed[$key]))
                {
                    $array_with_discharged_attendance_type_processed[$key]          = array();
                }
                $common_symphony_controller->BoxPlotValueSetFromArray($ed_overview_speciality_row_data[$key], $array_with_discharged_attendance_type_processed[$key], "last_discharge", "symphony_registration_date_time", "symphony_discharge_date");
            }
        }
        unset($ed_overview_speciality_row_data['A&E']);
        $success_array["ed_overview_speciality_row_data"]['admission_type'][]       =   $ed_overview_speciality_row_data['ED'];
        $success_array["ed_overview_speciality_row_data"]['admission_type'][]       =   $ed_overview_speciality_row_data['UTC'];
        $success_array["ed_overview_speciality_row_data"]['discharge_type'][]       =   $ed_overview_speciality_row_data['FAU'];
        $success_array["ed_overview_speciality_row_data"]['discharge_type'][]       =   $ed_overview_speciality_row_data['SDEC'];
        $success_array["ed_overview_speciality_row_data"]['discharge_type'][]       =   $ed_overview_speciality_row_data['SAU'];
        $success_array["ed_overview_speciality_row_data"]['discharge_type'][]       =   $ed_overview_speciality_row_data['COA'];

    }

    public function GetArrayWithattendanceTypeOfAttendance($process_array,$attendance_type_arr,$discharge_ward)
    {

        $return_array                                                               = array();
        $return_array["A&E"]                                                        = array();


        if (CheckCountArrayToProcess($attendance_type_arr))
        {
            foreach ($attendance_type_arr as $row)
            {
                $return_array[$row]                                                 = array();
            }
        }

        if (CheckCountArrayToProcess($discharge_ward))
        {
            foreach ($discharge_ward as $row)
            {
                $return_array[$row]                                                 = array();
            }
        }

        if (CheckCountArrayToProcess($process_array))
        {
            foreach ($process_array as $row)
            {
                if(isset($row["symphony_atd_type"]))
                {
                    if($row["symphony_atd_type"] != "")
                    {

                        if (in_array($row["symphony_atd_type"], ['ED', 'UTC']))
                        {

                            $return_array[$row["symphony_atd_type"]][]                       = $row;
                            $return_array["A&E"][]                                  = $row;
                            if(isset($row["symphony_discharge_ward"]))
                            {
                                if($row["symphony_discharge_ward"] != "")
                                {

                                    $wardMap = [
                                        'COA'  => [
                                            'Clinical Observations Area'
                                        ],
                                        'SDEC' => [
                                            'SDEC (Same Day Emergency Care)',
                                            'SDEC Planned Admissions Ward'
                                        ],
                                        'FAU'  => [
                                            'Frailty Assessment Unit'
                                        ],
                                        'SAU'  => [
                                            'SAU Inpatient'
                                        ]
                                    ];

                                    foreach ($discharge_ward as $ward) {
                                        if (!empty($wardMap[$ward])) {

                                            foreach ($wardMap[$ward] as $searchTerm) {

                                                if (stripos($row["symphony_discharge_ward"], $searchTerm) !== false) {
                                                    $return_array[$ward][] = $row;
                                                    break;
                                                }

                                            }
                                        }
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







    public function EdOverviewReferalPlotingDataSummary(&$success_array, &$process_array)
    {

        $process_array["patient_type_all_ed_overview_single"]               = array();
        $process_array["ibox_symphony_ed_overview_main_patient_category_with_index"] = [
            "ED"  => "",
            "UTC" => "",
            "COA" => "",
            "FAU" => "",
            "SDEC" => "",
            "SAU" => ""
        ];
        $process_array["ibox_symphony_ed_overview_ward_main_patient_category_with_index"] = ['COA', 'FAU', 'SDEC', 'SAU'];
        if (count($process_array["ibox_symphony_ed_overview_main_patient_category_with_index"]) > 0)
        {
            foreach ($process_array["ibox_symphony_ed_overview_main_patient_category_with_index"] as $key=>$val)
            {
                if(!in_array($key,$process_array["ibox_symphony_ed_overview_ward_main_patient_category_with_index"])) {
                    $process_array["patient_type_all_ed_overview_single"][] = $key;
                }
            }
        }

        if(isset($process_array['referral_type']))
        {
            if($process_array['referral_type'] != 'A&E')
            {
                $process_array["patient_type_all_ed_overview_single"]               = array();
                $process_array["patient_type_all_ed_overview_single"][]             = $process_array['referral_type'];
            }
        }

        $process_array["start_date_week"]                                   = $process_array["start_date"];
        CalculateStartEndDateAccordingSelection($process_array["start_date_week"],$process_array["end_date_week"],"week");

        $process_array["start_date_last_four_week"]                         = $process_array["start_date"];
        CalculateStartEndDateAccordingSelection($process_array["start_date_last_four_week"],$process_array["end_date_last_four_week"],"last 4 weeks");

        $process_array["start_date_last_year_same_week"]                    = date("Y-m-d 00:00:00",strtotime($process_array["start_date"].' - 180 days'));
        // $current_week_number                                                = date("W",strtotime($process_array["start_date"]));
        // $process_array["start_date_last_year_same_week"]                    = date("Y-m-d 00:00:00", strtotime($last_year.'W'.str_pad($current_week_number, 2, 0, STR_PAD_LEFT)));
        CalculateStartEndDateAccordingSelection($process_array["start_date_last_year_same_week"],$process_array["end_date_last_year_same_week"],"week");



        $attendance_data_processed_week_query                           = SymphonyAttendanceView::where('id','<>','');
        if($process_array["tab_filter_mode"] == 1)
        {
            $attendance_data_processed_week_query->where('symphony_still_in_ae','=',1);
        }
        else
        {
            $attendance_data_processed_week_query->whereBetween('symphony_registration_date_time', array($process_array["start_date_week"], $process_array["end_date_week"]));
        }
        $attendance_data_processed_week_query->orderBy('symphony_registration_date_time', 'ASC');
        $attendance_data_processed_week                                 = $attendance_data_processed_week_query->get()->toArray();

        $attendance_data_processed_last_four_weeks_query                = SymphonyAttendanceView::where('id','<>','');
        $attendance_data_processed_last_four_weeks_query->whereBetween('symphony_registration_date_time', array($process_array["start_date_last_four_week"], $process_array["end_date_last_four_week"]));
        $attendance_data_processed_last_four_weeks_query->orderBy('symphony_registration_date_time', 'ASC');
        $attendance_data_processed_last_four_weeks                      = $attendance_data_processed_last_four_weeks_query->get()->toArray();


        $attendance_data_processed_last_year_week_query                 = SymphonyAttendanceView::where('id','<>','');
        $attendance_data_processed_last_year_week_query->whereBetween('symphony_registration_date_time', array($process_array["start_date_last_year_same_week"], $process_array["end_date_last_year_same_week"]));
        $attendance_data_processed_last_year_week_query->orderBy('symphony_registration_date_time', 'ASC');
        $attendance_data_processed_last_year_week                       = $attendance_data_processed_last_year_week_query->get()->toArray();

        $green_data_array                                                   = $this->WeekwiseDataBoxPlotArrayProcessEdOverview($attendance_data_processed_week,$process_array,"green");
        $blue_data_array                                                    = $this->WeekwiseDataBoxPlotArrayProcessEdOverview($attendance_data_processed_last_four_weeks,$process_array,"blue");
        $red_data_array                                                     = $this->WeekwiseDataBoxPlotArrayProcessEdOverview($attendance_data_processed_last_year_week,$process_array,"red");

        $current_week_box_plot_data                                         = array();
        $days_week_arr                                                      = array();
        $days_last_four_weeks_arr                                           = array();
        $days_last_year_week_arr                                            = array();
        for($x=0;$x<7;$x++)
        {
            $week_days_arr                                                          = $process_array["week_days_full"];
            $check_date_format                                                      = strtotime($process_array["start_date_week"]  . " + $x days");
            $check_current_date                                                     = strtotime(date("Y-m-d 00:00:00",strtotime($process_array["date_time_now"])));
            if($check_date_format == $check_current_date)
            {
                $current_week_box_plot_data[$week_days_arr[$x]]["current_day"]      = "live";
            }
            else
            {
                $current_week_box_plot_data[$week_days_arr[$x]]["current_day"]      = "";
            }
            if($check_date_format > $check_current_date)
            {
                $current_week_box_plot_data[$week_days_arr[$x]]["red"]              = $red_data_array[$week_days_arr[$x]]["red"];
                $days_last_year_week_arr[]                                          = ucfirst($week_days_arr[$x]);
            }
            else
            {
                $current_week_box_plot_data[$week_days_arr[$x]]["green"]            = $green_data_array[$week_days_arr[$x]]["green"];
                $days_week_arr[]                                                    = ucfirst($week_days_arr[$x]);
            }
            $current_week_box_plot_data[$week_days_arr[$x]]["blue"]                 = $blue_data_array[$week_days_arr[$x]]["blue"];
            $days_last_four_weeks_arr[]                                             = ucfirst($week_days_arr[$x]);
        }
        $current_week_days_text_green                                               = "";
        $last_year_current_week_days_text_red                                       = "";
        $last_four_week_days_text_blue                                              = "";
        if(count($days_last_year_week_arr) > 0)
        {
            $last_year_current_week_days_text_red                                   = implode(", ",$days_last_year_week_arr)." - Last Year Same Day";
        }
        if(count($days_week_arr) > 0)
        {
            $current_week_days_text_green                                           = implode(", ",$days_week_arr)." - Current Week";
        }
        if(count($days_last_four_weeks_arr) > 0)
        {
            $last_four_week_days_text_blue                                          = implode(", ",$days_last_four_weeks_arr)." - Last 4 Weeks";
        }



        $success_array["current_week_days_text_green"]                              = $current_week_days_text_green;
        $success_array["last_year_current_week_days_text_red"]                      = $last_year_current_week_days_text_red;
        $success_array["last_four_week_days_text_blue"]                             = $last_four_week_days_text_blue;
        $success_array["current_week_box_plot_data"]                                = $current_week_box_plot_data;
        $success_array["section_head"]                                              = $process_array["referral_type"];


        $green_colour_data                                                          = array();
        $red_colour_data                                                            = array();
        $blue_colour_data                                                           = array();

        foreach($success_array["current_week_box_plot_data"] as $key=>$row)
        {
            if(isset($row['blue']))
            {
                $blue_colour_data[]                                                 = $row['blue']['box_plot_minimum'];
                $blue_colour_data[]                                                 = $row['blue']['box_plot_lower_quartile'];
                $blue_colour_data[]                                                 = $row['blue']['box_plot_median'];
                $blue_colour_data[]                                                 = $row['blue']['box_plot_upper_quartile'];
                $blue_colour_data[]                                                 = $row['blue']['box_plot_maximum'];
            }
            else
            {
                $blue_colour_data[]                                                 = null;
                $blue_colour_data[]                                                 = null;
                $blue_colour_data[]                                                 = null;
                $blue_colour_data[]                                                 = null;
                $blue_colour_data[]                                                 = null;
            }

            if(isset($row['green']))
            {
                $green_colour_data[]                                                 = $row['green']['box_plot_minimum'];
                $green_colour_data[]                                                 = $row['green']['box_plot_lower_quartile'];
                $green_colour_data[]                                                 = $row['green']['box_plot_median'];
                $green_colour_data[]                                                 = $row['green']['box_plot_upper_quartile'];
                $green_colour_data[]                                                 = $row['green']['box_plot_maximum'];
            }
            else
            {
                $green_colour_data[]                                                 = null;
                $green_colour_data[]                                                 = null;
                $green_colour_data[]                                                 = null;
                $green_colour_data[]                                                 = null;
                $green_colour_data[]                                                 = null;
            }

            if(isset($row['red']))
            {
                $red_colour_data[]                                                 = $row['red']['box_plot_minimum'];
                $red_colour_data[]                                                 = $row['red']['box_plot_lower_quartile'];
                $red_colour_data[]                                                 = $row['red']['box_plot_median'];
                $red_colour_data[]                                                 = $row['red']['box_plot_upper_quartile'];
                $red_colour_data[]                                                 = $row['red']['box_plot_maximum'];
            }
            else
            {
                $red_colour_data[]                                                 = null;
                $red_colour_data[]                                                 = null;
                $red_colour_data[]                                                 = null;
                $red_colour_data[]                                                 = null;
                $red_colour_data[]                                                 = null;
            }
        }



        $green_colour_data_text                                                     = "[]";
        $red_colour_data_text                                                       = "[]";
        $blue_colour_data_text                                                      = "[]";

        if(count($blue_colour_data) > 0)
        {
            $blue_colour_data_text                                                  = "[".implode(", ", $blue_colour_data)."]";
        }
        if(count($green_colour_data) > 0)
        {
            $green_colour_data_text                                                 = "[".implode(", ", $green_colour_data)."]";
        }
        if(count($red_colour_data) > 0)
        {
            $red_colour_data_text                                                   = "[".implode(", ", $red_colour_data)."]";
        }
        $success_array["box_plot_graph_green_data"]                                 = $green_colour_data_text;
        $success_array["box_plot_graph_red_data"]                                   = $red_colour_data_text;
        $success_array["box_plot_graph_blue_data"]                                  = $blue_colour_data_text;


    }



    public function WeekwiseDataBoxPlotArrayProcessEdOverview($array_processed,$process_array,$colour)
    {
        $common_symphony_controller = new CommonSymphonyController;
        $common_controller  = new CommonController;
        $week_days                                              = $process_array["week_days_full"];
        $return_array                                           = array();
        $attendance_temp_storage                                = array();
        foreach ($week_days as $week_name)
        {
            $return_array[$week_name][$colour]["colour"]                                            = $colour;
            $return_array[$week_name][$colour]["box_plot_maximum"]                                  = 0;
            $return_array[$week_name][$colour]["box_plot_minimum"]                                  = 0;
            $return_array[$week_name][$colour]["box_plot_median"]                                   = 0;
            $return_array[$week_name][$colour]["box_plot_upper_quartile"]                           = 0;
            $return_array[$week_name][$colour]["box_plot_lower_quartile"]                           = 0;
            $return_array[$week_name][$colour]["box_plot_average_time"]                             = 0;
            $return_array[$week_name][$colour]["box_plot_average_attendence"]                       = 0;
            $return_array[$week_name][$colour]["box_plot_average_attendence_day"]                   = 0;
            $return_array[$week_name][$colour]["box_plot_average_attendence_day_in_minutes"]        = 0;
            $return_array[$week_name][$colour]["box_plot_average_admissions_day"]                   = 0;
            $return_array[$week_name][$colour]["box_plot_average_admissions_day_in_minutes"]        = 0;
            $return_array[$week_name][$colour]["box_plot_average_ambulance_day"]                    = 0;
            $return_array[$week_name][$colour]["box_plot_average_ambulance_day_in_minutes"]         = 0;
            $return_array[$week_name][$colour]["box_plot_average_walkin_day"]                       = 0;
            $return_array[$week_name][$colour]["box_plot_average_walkin_day_in_minutes"]            = 0;
        }
        $array_with_attendance_type_processed                                                       = $this->GetArrayWithattendanceTypeOfattendance($array_processed,$process_array["patient_type_all_ed_overview_single"],$process_array["ibox_symphony_ed_overview_ward_main_patient_category_with_index"]);
        $data_need_process                                                                          = array();
        $search_referral                                                                            = $process_array["referral_type"];

        if(isset($array_with_attendance_type_processed[$search_referral]))
        {
            $data_need_process                                                                      = $array_with_attendance_type_processed[$search_referral];
        }


        if (count($data_need_process) > 0)
        {
            foreach ($data_need_process as $row)
            {
                if(isset($row["symphony_registration_date_time"]))
                {
                    if($row["symphony_registration_date_time"] != "")
                    {
                        $day_name                                                                   = strtolower(date("l",strtotime($row["symphony_registration_date_time"])));
                        $attendance_temp_storage[$day_name][]                                       = $row;
                    }
                }
            }
        }

        $average_count                                                                             =  1;
        if($colour == "blue")
        {
            $average_count                                                                          = 4;
        }

        foreach ($return_array as $key=>$val)
        {
            if(isset($attendance_temp_storage[$key]))
            {
                $overall_attendance                                                                 = $attendance_temp_storage[$key];
                $admitted_discharge_array                                                           = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($overall_attendance,$process_array);
                $ambulance_walkin_arrival_array                                                     = $common_symphony_controller->AmbulanceWalkinArrayProcess($overall_attendance);
                $admissions_data_values                                                             = $admitted_discharge_array["admitted_patients"];
                $ambulance_data_values                                                              = $ambulance_walkin_arrival_array["ambulance_arrival"];
                $walkin_data_values                                                                 = $ambulance_walkin_arrival_array["walkin_arrival"];
                $difference_in_minutes_array                                                        = array();
                $common_controller->DifferenceBetweenTwoTimesFromArray($overall_attendance,$difference_in_minutes_array,"symphony_registration_date_time","symphony_discharge_date");
                if(count($difference_in_minutes_array) > 0)
                {
                    $return_array[$key][$colour]["box_plot_maximum"]                                = NumberFormatCustom(max($difference_in_minutes_array),0);
                    $return_array[$key][$colour]["box_plot_minimum"]                                = NumberFormatCustom(min($difference_in_minutes_array),0);
                    $return_array[$key][$colour]["box_plot_median"]                                 = NumberFormatCustom(round(array_sum($difference_in_minutes_array) / count($difference_in_minutes_array)),0);
                    $return_array[$key][$colour]["box_plot_upper_quartile"]                         = NumberFormatCustom(round(($return_array[$key][$colour]["box_plot_maximum"] + $return_array[$key][$colour]["box_plot_median"]) / 2),0);
                    $return_array[$key][$colour]["box_plot_lower_quartile"]                         = NumberFormatCustom(round(($return_array[$key][$colour]["box_plot_minimum"] + $return_array[$key][$colour]["box_plot_median"]) / 2),0);
                    $return_array[$key][$colour]["box_plot_average_time"]                           = ConvertMinutesToHourMinutesWithTextFormated($return_array[$key][$colour]["box_plot_median"]);
                    $return_array[$key][$colour]["box_plot_average_attendence"]                     = RoundNumberToZeroDecimalPoints(count($difference_in_minutes_array));
                    $return_array[$key][$colour]["box_plot_average_attendence_day"]                 = RoundNumberToZeroDecimalPoints(count($difference_in_minutes_array)/$average_count);
                    $return_array[$key][$colour]["box_plot_average_attendence_day_in_minutes"]      = RoundNumberToZeroDecimalPoints(array_sum($difference_in_minutes_array) / count($difference_in_minutes_array));
                }
                $difference_in_minutes_array                                                        = array();
                $common_controller->DifferenceBetweenTwoTimesFromArray($admissions_data_values,$difference_in_minutes_array,"symphony_registration_date_time","symphony_discharge_date");
                if(count($difference_in_minutes_array) > 0)
                {
                    $return_array[$key][$colour]["box_plot_average_admissions_day"]                  = RoundNumberToZeroDecimalPoints(count($difference_in_minutes_array)/$average_count);
                    $return_array[$key][$colour]["box_plot_average_admissions_day_in_minutes"]       = RoundNumberToZeroDecimalPoints(array_sum($difference_in_minutes_array) / count($difference_in_minutes_array));
                }
                $difference_in_minutes_array                                                        = array();
                $common_controller->DifferenceBetweenTwoTimesFromArray($ambulance_data_values,$difference_in_minutes_array,"symphony_registration_date_time","symphony_discharge_date");
                if(count($difference_in_minutes_array) > 0)
                {
                    $return_array[$key][$colour]["box_plot_average_ambulance_day"]                  = RoundNumberToZeroDecimalPoints(count($difference_in_minutes_array)/$average_count);
                    $return_array[$key][$colour]["box_plot_average_ambulance_day_in_minutes"]       = RoundNumberToZeroDecimalPoints(array_sum($difference_in_minutes_array) / count($difference_in_minutes_array));
                }

                $difference_in_minutes_array                                                        = array();
                $common_controller->DifferenceBetweenTwoTimesFromArray($walkin_data_values,$difference_in_minutes_array,"symphony_registration_date_time","symphony_discharge_date");
                if(count($difference_in_minutes_array) > 0)
                {
                    $return_array[$key][$colour]["box_plot_average_walkin_day"]                     = RoundNumberToZeroDecimalPoints(count($difference_in_minutes_array)/$average_count);
                    $return_array[$key][$colour]["box_plot_average_walkin_day_in_minutes"]          = RoundNumberToZeroDecimalPoints(array_sum($difference_in_minutes_array) / count($difference_in_minutes_array));
                }
            }
        }
        return $return_array;
    }


    public function SummarySpecialitySpecificData(Request $request)
    {
        $common_controller  = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;
        $process_array      = array();
        $success_array      = array();

        $tab_filter_mode    = $request->tab_filter_mode;

        $process_array["tab_filter_mode"] = $tab_filter_mode;
        $success_array["tab_filter_mode"] = $tab_filter_mode;
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);


        if ($tab_filter_mode == 1 || $tab_filter_mode == 2)
        {
            if ($tab_filter_mode == 1)
            {
                $referral_type                  = $request->referral_type;
                $process_array["referral_type"] = ($referral_type != "") ? $referral_type : 'ED';
                $process_array["start_date"]    = CurrentDateOnFormat();
                CalculateStartEndDateAccordingSelection($process_array["start_date"],$process_array["end_date"],"day");
                $this->EdOverviewReferalPlotingDataSummary($success_array,$process_array);
                $view = View::make('Dashboards.Symphony.EDOverview.IndexDataLoadBxPlotRightCommonTab1', compact('success_array'));
                $sections = $view->render();
                return $sections;

            }
            elseif ($tab_filter_mode == 2)
            {
                $filter_value                   = $request->filter_value;
                $referral_type                  = $request->referral_type;
                $process_array["start_date"]    = ($filter_value != "") ? $filter_value : CurrentDateOnFormat();
                $process_array["referral_type"] = ($referral_type != "") ? $referral_type : 'ED';
                CalculateStartEndDateAccordingSelection($process_array["start_date"],$process_array["end_date"],"day");

                $this->EdOverviewReferalPlotingDataSummary($success_array,$process_array);

                $view = View::make('Dashboards.Symphony.EDOverview.IndexDataLoadBxPlotRightCommonTab2', compact('success_array'));
                $sections = $view->render();
                return $sections;
            }
        }
        else
        {
            return false;
        }
    }


}
