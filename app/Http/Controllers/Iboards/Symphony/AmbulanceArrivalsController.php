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


class AmbulanceArrivalsController extends Controller
{
    public function Index()
    {
        $common_controller                  = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;
        $process_array                      = array();
        $success_array                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);
        $process_array["start_date"] = YesterdayDateOnFormat();
        CalculateStartEndDateAccordingSelection($process_array["start_date"],$process_array["end_date"],"day");
        $process_array["tab_filter_mode"]                   = 1;
        $success_array["tab_filter_mode"]                   = 1;
        $success_array["page_sub_title"]                = date('l jS F H:i');
        $this->ArrivalDataProcess($success_array,$process_array);
        $success_array['date_filter_tab_1_date_to_show']    = PredefinedDateFormatShowOnCalendarDashboard($process_array["start_date"]);
        $success_array["filter_value_selected"]             = PredefinedStandardDateFormatChangeDateAlone($process_array["start_date"]);
        return view('Dashboards.Symphony.AmbulanceArrivals.Index', compact('success_array'));
    }
    public function ContentDataLoad(Request $request)
    {

        $common_controller  = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;
        $process_array      = array();
        $success_array      = array();

        $tab_filter_mode    = $request->tab_filter_mode;
        $filter_value       = $request->filter_value;
        $process_array["tab_filter_mode"] = $tab_filter_mode;
        $success_array["tab_filter_mode"] = $tab_filter_mode;
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);


        if ($tab_filter_mode == 1 || $tab_filter_mode == 2 || $tab_filter_mode == 3 || $tab_filter_mode == 4)
        {
            if ($tab_filter_mode == 1)
            {
                if(CheckSpecificPermission('ambulance_dashboard_live_view')){
                    $process_array["start_date"]  = ($filter_value != "") ? $filter_value : CurrentDateOnFormat();
                    CalculateStartEndDateAccordingSelection($process_array["start_date"],$process_array["end_date"],"day");

                    $this->ArrivalDataProcess($success_array,$process_array);
                    $success_array['date_filter_tab_1_date_to_show'] = PredefinedDateFormatShowOnCalendarDashboard($process_array["start_date"]);
                    $success_array["filter_value_selected"]     = PredefinedStandardDateFormatChangeDateAlone($process_array["start_date"]);
                    $view = View::make('Dashboards.Symphony.AmbulanceArrivals.IndexDataLoadTabContent1', compact('success_array'));
                    $sections = $view->render();
                    return $sections;
                } else {
                    return PermissionDenied();
                }
            }
            elseif ($tab_filter_mode == 2)
            {
                if(CheckSpecificPermission('ambulance_dashboard_week_to_date_view')){
                    $process_array["start_date"]  = ($filter_value != "") ? $filter_value : CurrentDateOnFormat();
                    $success_array["week_filter_array"]                               = LastNumberOfWeeksArrayForDropdownOperation($process_array["date_time_now"],120);
                    CalculateStartEndDateAccordingSelection($process_array["start_date"],$process_array["end_date"],"week");
                    $this->ArrivalDataProcess($success_array,$process_array);
                    $success_array["filter_value_selected"]     = date("Y-m-d",strtotime($process_array["start_date"]));
                    $view = View::make('Dashboards.Symphony.AmbulanceArrivals.IndexDataLoadTabContent2', compact('success_array'));
                    $sections = $view->render();
                    return $sections;
                } else {
                    return PermissionDenied();
                }
            }
            elseif ($tab_filter_mode == 3)
            {
                if(CheckSpecificPermission('ambulance_dashboard_last_four_week_view')){
                    $process_array["start_date"]  = ($filter_value != "") ? $filter_value : CurrentDateOnFormat();
                    $success_array["month_filter_array"]                              = LastNumberOfMonthsArrayForDropdownOperation($process_array["date_time_now"],12);
                    CalculateStartEndDateAccordingSelection($process_array["start_date"],$process_array["end_date"],"month");
                    $this->ArrivalDataProcess($success_array,$process_array);
                    $success_array["filter_value_selected"]     = date("Y-m-d",strtotime($process_array["start_date"]));
                    $view = View::make('Dashboards.Symphony.AmbulanceArrivals.IndexDataLoadTabContent3', compact('success_array'));
                    $sections = $view->render();
                    return $sections;
                } else {
                    return PermissionDenied();
                }
            }
            elseif ($tab_filter_mode == 4)
            {
                if(CheckSpecificPermission('ambulance_dashboard_last_thousand_arrival_view')){
                    CalculateStartEndDateAccordingSelection($process_array["start_date"],$process_array["end_date"],"day");
                    $this->ArrivalDataProcess($success_array,$process_array);
                    $view = View::make('Dashboards.Symphony.AmbulanceArrivals.IndexDataLoadTabContent4', compact('success_array'));
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






    public function ArrivalDataProcess(&$success_array,&$process_array)
    {

        $common_controller  = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;
        if($success_array["tab_filter_mode"] == 1)
        {
            $process_array["start_date_last_week"]                  = $process_array["start_date"];
            CalculateStartEndDateAccordingSelection($process_array["start_date_last_week"],$process_array["end_date_last_week"],"week");
            $ambulance_patient_data                                 = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($process_array["start_date"], $process_array["end_date"]))->whereIn('symphony_atd_type', $process_array["ibox_symphony_main_patient_category"])->whereIn('symphony_arrival_mode', $process_array["ibox_symphony_ambulance_parameter"])->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
            $ambulance_patient_data_week_top                        = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($process_array["start_date_last_week"], $process_array["end_date_last_week"]))->whereIn('symphony_atd_type', $process_array["ibox_symphony_main_patient_category"])->whereIn('symphony_arrival_mode', $process_array["ibox_symphony_ambulance_parameter"])->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
        }
        elseif($success_array["tab_filter_mode"] == 2)
        {
            $ambulance_patient_data                                 = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($process_array["start_date"], $process_array["end_date"]))->whereIn('symphony_atd_type', $process_array["ibox_symphony_main_patient_category"])->whereIn('symphony_arrival_mode', $process_array["ibox_symphony_ambulance_parameter"])->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
            $ambulance_patient_data_week_top                        = $ambulance_patient_data;
        }
        elseif($success_array["tab_filter_mode"] == 3)
        {
            $ambulance_patient_data                                 = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($process_array["start_date"], $process_array["end_date"]))->whereIn('symphony_atd_type', $process_array["ibox_symphony_main_patient_category"])->whereIn('symphony_arrival_mode', $process_array["ibox_symphony_ambulance_parameter"])->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
            $ambulance_patient_data_week_top                        = $ambulance_patient_data;
            $first_day_of_month                                     = date("D",strtotime($process_array['start_date']));
            $number_of_days_month                                   = (int)date("t",strtotime($process_array["start_date"]));
            $process_array["week_counts"]                           = NumberOfWeekDaysInMonth($number_of_days_month, $first_day_of_month);

        }
        elseif($success_array["tab_filter_mode"] == 4)
        {
            $process_array["start_date_last_1000"]  = CurrentDateOnFormat();
            $process_array["end_date_last_1000"]    = "";
            CalculateStartEndDateAccordingSelection($process_array["start_date_last_1000"], $process_array["end_date_last_1000"], "last 1000");

            $ambulance_patient_data                                 = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($process_array["start_date_last_1000"], $process_array["end_date_last_1000"]))->whereIn('symphony_atd_type', $process_array["ibox_symphony_main_patient_category"])->whereIn('symphony_arrival_mode', $process_array["ibox_symphony_ambulance_parameter"])->orderBy('symphony_registration_date_time', 'ASC')->limit(1000)->get()->toArray();
            $ambulance_patient_data_week_top                        = array();
        }

        $success_array["ambulance_arrival_hour_hour_bar_graph"]     = array();
        $common_controller->CountOnEveryHourArrayConversionDirectHour($success_array["ambulance_arrival_hour_hour_bar_graph"],$ambulance_patient_data,"symphony_registration_date_time");
        $success_array["ambulance_arrival_hour_hour_bar_graph_associative_array"] = array_values($success_array['ambulance_arrival_hour_hour_bar_graph']);


        $process_array["predicted_start_date"]                      = date('Y-m-d 00:00:00', strtotime($process_array["start_date"] . '-56 day'));
        $process_array["predicted_end_date"]                        = $process_array["start_date"];
        $process_array["predicted_count_days"]                      = 56;
        $ambulance_patient_data_predicted                           = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($process_array["predicted_start_date"], $process_array["predicted_end_date"]))->whereIn('symphony_atd_type', $process_array["ibox_symphony_main_patient_category"])->whereIn('symphony_arrival_mode', $process_array["ibox_symphony_ambulance_parameter"])->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();



        $success_array["ambulance_arrival_hour_hour_line_graph"]    = array();
        $common_controller->CountOnEveryHourArrayConversionDirectHour($success_array["ambulance_arrival_hour_hour_line_graph"],$ambulance_patient_data_predicted,"symphony_registration_date_time");
        ArrayAverageConversionWithNumbers($success_array["ambulance_arrival_hour_hour_line_graph"],$process_array["predicted_count_days"],0);
        $success_array["ambulance_arrival_hour_hour_line_graph_associative_array"] = array_values($success_array['ambulance_arrival_hour_hour_line_graph']);



        $first_day_of_month                                         = date("D",strtotime($process_array['start_date']));
        $number_of_days_month                                       = (int)date("t",strtotime($process_array["start_date"]));
        $process_array["week_counts"]                               = NumberOfWeekDaysInMonth($number_of_days_month, $first_day_of_month);



        $success_array["ambulance_week_actual_value"]               = array();
        $success_array["ambulance_week_predicted_value"]            = array();
        $common_controller->CountOnEveryHourArrayConversionDirectWeek($success_array["ambulance_week_actual_value"],$ambulance_patient_data_week_top,"symphony_registration_date_time");
        $common_controller->CountOnEveryHourArrayConversionDirectWeek($success_array["ambulance_week_predicted_value"], $ambulance_patient_data_predicted, "symphony_registration_date_time");
        if($process_array["tab_filter_mode"] == 3 )
        {
            ArrayAverageConversionWithNumbers($success_array["ambulance_week_predicted_value"], 2, 0);
        }
        else
        {
            ArrayAverageConversionWithNumbers($success_array["ambulance_week_predicted_value"], 8, 0);
        }


        // Admitted & Non Admitted Section Of Ambulace Arrival starts
        $admitted_non_admitted_section                                          = array();
        $ambulance_admitted_discharged                                          = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($ambulance_patient_data,$process_array);


        $admitted_non_admitted_section["non_admitted_total"]                    = count($ambulance_admitted_discharged["discharged_patients"]);
        $admitted_non_admitted_section["admitted_total"]                        = count($ambulance_admitted_discharged["admitted_patients"]);
        $admitted_non_admitted_section["overall_total"]                         = count($ambulance_patient_data);
        $admitted_non_admitted_section["still_in_ed"]                           = abs($admitted_non_admitted_section["overall_total"]-($admitted_non_admitted_section["non_admitted_total"]+$admitted_non_admitted_section["admitted_total"]));
        $admitted_non_admitted_section["non_admitted_arrival_to_departure"]     = $common_symphony_controller->AmbulanceHourDifferenceCountTwelve($ambulance_admitted_discharged["discharged_patients"]);
        $admitted_non_admitted_section["admitted_arrival_to_departure"]         = $common_symphony_controller->AmbulanceHourDifferenceCountTwelve($ambulance_admitted_discharged["admitted_patients"]);

        $admitted_non_admitted_section["non_admitted_arrival_to_departure_associative_array"] = array_values($admitted_non_admitted_section["non_admitted_arrival_to_departure"]);
        $admitted_non_admitted_section["admitted_arrival_to_departure_associative_array"] = array_values($admitted_non_admitted_section["admitted_arrival_to_departure"]);
        //Box plot intial value set & assign value of Admitted, Discharged & Overall of Ambulance arrived Data
        $common_symphony_controller->BoxPlotValueSetFromArray( $admitted_non_admitted_section,$ambulance_admitted_discharged["admitted_patients"],"admitted","symphony_registration_date_time","symphony_discharge_date");
        $common_symphony_controller->BoxPlotValueSetFromArray( $admitted_non_admitted_section,$ambulance_admitted_discharged["discharged_patients"],"non_admitted","symphony_registration_date_time","symphony_discharge_date");
        $common_symphony_controller->BoxPlotValueSetFromArray( $admitted_non_admitted_section,$ambulance_patient_data,"overall","symphony_registration_date_time","symphony_discharge_date");

        // Assigning values to success array
        $success_array["admitted_non_admitted_section"]                        = $admitted_non_admitted_section;


        $admitted_non_admitted_breached_section                                         = array();
        $ambulance_breached_admitted_discharged                                         = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($ambulance_admitted_discharged['breached_patients'],$process_array);
        $admitted_non_admitted_breached_section["breached_non_admitted_total"]          = count($ambulance_breached_admitted_discharged["discharged_patients"]);
        $admitted_non_admitted_breached_section["breached_admitted_total"]              = count($ambulance_breached_admitted_discharged["admitted_patients"]);
        $admitted_non_admitted_breached_section["breached_total"]                       = count($ambulance_admitted_discharged['breached_patients']);
        $admitted_non_admitted_breached_section["admitted_donut"]["breach"]             = 0;
        $admitted_non_admitted_breached_section["admitted_donut"]["total"]              = 0;
        $admitted_non_admitted_breached_section["non_admitted_donut"]["breach"]         = 0;
        $admitted_non_admitted_breached_section["non_admitted_donut"]["total"]          = 0;

        if($admitted_non_admitted_breached_section["breached_total"] > 0)
        {
            $admitted_non_admitted_breached_section["admitted_donut"]["breach"]         = RoundNumberToZeroDecimalPoints(($admitted_non_admitted_breached_section["breached_admitted_total"]/$admitted_non_admitted_breached_section["breached_total"])*100);
            $admitted_non_admitted_breached_section["admitted_donut"]["total"]          = RoundNumberToZeroDecimalPoints(100-$admitted_non_admitted_breached_section["admitted_donut"]["breach"]);
            $admitted_non_admitted_breached_section["non_admitted_donut"]["breach"]     = RoundNumberToZeroDecimalPoints(($admitted_non_admitted_breached_section["breached_non_admitted_total"]/$admitted_non_admitted_breached_section["breached_total"])*100);
            $admitted_non_admitted_breached_section["non_admitted_donut"]["total"]      = RoundNumberToZeroDecimalPoints(100-$admitted_non_admitted_breached_section["non_admitted_donut"]["breach"]);
        }

        //Box plot intial value set & assign value of Admitted, Discharged & Overall of Ambulance arrived Breach Data
        $common_symphony_controller->BoxPlotValueSetFromArray( $admitted_non_admitted_breached_section,$ambulance_breached_admitted_discharged["admitted_patients"],"admitted","symphony_registration_date_time","symphony_discharge_date");
        $common_symphony_controller->BoxPlotValueSetFromArray( $admitted_non_admitted_breached_section,$ambulance_breached_admitted_discharged["discharged_patients"],"non_admitted","symphony_registration_date_time","symphony_discharge_date");
        $common_symphony_controller->BoxPlotValueSetFromArray( $admitted_non_admitted_breached_section,$ambulance_admitted_discharged['breached_patients'],"overall","symphony_registration_date_time","symphony_discharge_date");


        // Assigning values to success array
        $success_array["admitted_non_admitted_breached_section"]                        = $admitted_non_admitted_breached_section;
    }
}
