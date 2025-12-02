<?php

namespace App\Http\Controllers\Iboards\Symphony;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonSymphonyController;
use App\Http\Controllers\Common\HistoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Governance\GovernanceController;
use App\Models\Common\IboxSettings;
use App\Models\Common\User;
use App\Models\Iboards\Symphony\Data\DtaComments;
use App\Models\Iboards\Symphony\Data\OpelCurrentStatus;
use App\Models\Iboards\Symphony\Data\SymphonyEDThermometer;
use App\Models\Iboards\Symphony\View\SymphonyAttendanceView;
use App\Models\Iboards\Symphony\View\SymphonyAneAttendanceView;
use App\Models\Iboards\Symphony\View\SymphonyAneThermometerView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AneController extends Controller
{
    public function Index()
    {
        if (!CheckDashboardPermission('live_status_view')) {
            Toastr::error('Permission Denied');
            return back();
        }
        $process_array                      = array();
        $success_array                      = array();
        $process_array["start_date"]        = CurrentDateOnFormat();

        $process_array["end_date"]          = "";
        CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "day");

         $this->PageDataLoad($process_array, $success_array);
        $success_array = json_decode(file_get_contents('demo_data/ane/ane_live_status.txt'), true);
        $opel_data = OpelCurrentStatus::first();

        $success_array["main_graph"]["ane_opel_status_data"]                                        = 0;
        $success_array["main_graph"]["ane_opel_status_data_show_status"]                            = 0;
        $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]            = 'opel_0';

        if (isset($opel_data->id)) {
            $success_array["main_graph"]["ane_opel_status_data"]                                    = $opel_data->ane_opel_status_data;
            $success_array["main_graph"]["ane_opel_status_data_show_status"]                        = $opel_data->ane_opel_status_data_show_status;
            if ($opel_data->ane_opel_status_data_show_status == 0) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_0';
            } elseif ($opel_data->ane_opel_status_data == 1) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_1';
            } elseif ($opel_data->ane_opel_status_data == 2) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_2';
            } elseif ($opel_data->ane_opel_status_data == 3) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_3';
            } elseif ($opel_data->ane_opel_status_data == 4) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_4';
            } else {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_0';
            }
        }

        $last_ed_key = SymphonyEDThermometer::orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->where('ed_key', 'current_opel_status')
            ->first()->ed_value ?? 0;
        $success_array["opel_status"]            = $last_ed_key;
        $success_array["opel_image"]            = 'opel_' . $last_ed_key;

        return view('Dashboards.Symphony.Ane.Index', compact('success_array'));
    }

    public function IndexRefreshDataLoad()
    {
        $process_array                      = array();
        $success_array                      = array();
        $process_array["start_date"]        = CurrentDateOnFormat();

        $process_array["end_date"]          = "";
        CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "day");
        $this->PageDataLoad($process_array, $success_array);
        //$success_array = $this->buildDummySuccessArray();
        $success_array = json_decode(file_get_contents('demo_data/ane/ane_live_status.txt'), true);
        $opel_data = OpelCurrentStatus::first();

        $success_array["main_graph"]["ane_opel_status_data"]                                        = 0;
        $success_array["main_graph"]["ane_opel_status_data_show_status"]                            = 0;
        $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]            = 'opel_0';

        if (isset($opel_data->id)) {
            $success_array["main_graph"]["ane_opel_status_data"]                                    = $opel_data->ane_opel_status_data;
            $success_array["main_graph"]["ane_opel_status_data_show_status"]                        = $opel_data->ane_opel_status_data_show_status;
            if ($opel_data->ane_opel_status_data_show_status == 0) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_0';
            } elseif ($opel_data->ane_opel_status_data == 1) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_1';
            } elseif ($opel_data->ane_opel_status_data == 2) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_2';
            } elseif ($opel_data->ane_opel_status_data == 3) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_3';
            } elseif ($opel_data->ane_opel_status_data == 4) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_4';
            } else {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_0';
            }
        }

        $last_ed_key = SymphonyEDThermometer::orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->where('ed_key', 'current_opel_status')
            ->first()->ed_value ?? 0;
        $success_array["opel_status"]            = $last_ed_key;
        $success_array["opel_image"]            = 'opel_' . $last_ed_key;
        $view = View::make('Dashboards.Symphony.Ane.IndexDataLoad', compact('success_array'));

        $sections = $view->render();
        return $sections;
    }


    public function PageDataLoad(&$process_array, &$success_array)
    {
        $common_controller = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;

        /*******************************Default Contsant Value Setting************************/
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);

        $process_array["date_last_hour"]                = date('Y-m-d H:i:s', strtotime($process_array["date_time_now"] . '-1 hour'));
        $process_array["ane_today_date_check"]          = date('Y-m-d', strtotime($process_array["date_time_now"]));

        /*******************************Setting Table Name With DB Name For Joins ************************/

        $category_breach_details                        = array();

        $process_array["still_in_ae_patients_list"]     = SymphonyAttendanceView::where('symphony_still_in_ae', '=', 1)->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
        $process_array["attendence_today_all"]          = SymphonyAneAttendanceView::orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();

        $attendance_category_specific_today             = $common_controller->ArrayColumnCategoryWiseGrouping($process_array["attendence_today_all"], 'symphony_atd_type');
        $process_array["attendance_today_category_ed"]  = $attendance_category_specific_today["ED"] ?? array();

        $all_admitted_discharge_today                   = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($process_array["attendence_today_all"], $process_array);
        $all_breached_today                             = $common_symphony_controller->GetBreachedArrayProcessFrom240Minutes($process_array["attendence_today_all"], $process_array);
        $all_admitted_breached_today                    = $common_symphony_controller->GetBreachedArrayProcessFrom240Minutes($all_admitted_discharge_today["admitted_patients"], $process_array);
        $all_non_admitted_breached_today                = $common_symphony_controller->GetBreachedArrayProcessFrom240Minutes($all_admitted_discharge_today["discharged_patients"], $process_array);
        $all_arrival_patients_today                     = $common_symphony_controller->PatientsOnSpecificDateArrayProcess($process_array["attendence_today_all"], $process_array, 'symphony_registration_date_time');

        $process_array["all_admitted_discharge_today"]  = $all_admitted_discharge_today;
        $success_array["page_sub_title"]                = date('l jS F H:i');





        // All Patient Category Admitted & Non Admitted Performance Section.
        $success_array["top_matrix"]["performance"]["admitted_value"]                       = PerformanceCalculationAne(count($all_admitted_breached_today), count($all_admitted_discharge_today["admitted_patients"]), $process_array["ibox_decimal_places_precise"]);
        $success_array["top_matrix"]["performance"]["nonadmitted_value"]                    = PerformanceCalculationAne(count($all_non_admitted_breached_today), count($all_admitted_discharge_today["discharged_patients"]), $process_array["ibox_decimal_places_precise"]);
        $success_array["top_matrix"]["performance"]["admitted_performance_text_colour"]     = PerformanceShowTextColourSetting($success_array["top_matrix"]["performance"]["admitted_value"]);
        $success_array["top_matrix"]["performance"]["nonadmitted_performance_text_colour"]  = PerformanceShowTextColourSetting($success_array["top_matrix"]["performance"]["nonadmitted_value"]);

        // All Patient Category Arrival, breach & Performance Section.
        $common_symphony_controller->CategorywiseAttendanceDetailsProcessArray($attendance_category_specific_today, $category_breach_details, $process_array);
        $success_array["top_matrix"]["category_breach_details"]                             = $category_breach_details;



        $success_array["top_sub_matrix"]["since_midnight"]["arrived_value"]                 = count($all_arrival_patients_today);
        $success_array["top_sub_matrix"]["since_midnight"]["left_value"]                    = count($all_admitted_discharge_today["discharged_patients"]);
        $success_array["top_sub_matrix"]["since_midnight"]["admitted_value"]                = count($all_admitted_discharge_today["admitted_patients"]);




        // All Patient Category Conversion & Breach Section.
        $success_array["top_matrix"]["conversion_rate"]                                     = PercentageCalculationOfValues(count($all_admitted_discharge_today["admitted_patients"]), count($process_array["attendence_today_all"]), $process_array["ibox_decimal_places_precise"]);
        $success_array["top_matrix"]["breaches_value"]                                      = count($all_breached_today);
        $success_array["top_matrix"]["performance_value"]                                   = PerformanceCalculationAne(count($all_breached_today), count($all_admitted_discharge_today["discharged_patients"]), $process_array["ibox_decimal_places_precise"]);
        $success_array["top_matrix"]["performance_text_colour"]                             = PerformanceShowTextColourSetting($success_array["top_matrix"]["performance_value"]);

        $success_array["top_matrix"]["performance_value_guage_colour"]                      = PerformanceShowGuageColourSetting($success_array["top_matrix"]["performance_value"]);;
        $success_array["top_matrix"]["performance_value_guage_border_colour"]               = PerformanceShowGuageBorderColourSetting($success_array["top_matrix"]["performance_value"]);;







        // Top Matrix Sub Section Last One Hour.
        $attendance_last_hour_data                                                          = $common_symphony_controller->AttendanceSinceDateTimeDataProcess($process_array["attendence_today_all"], $process_array["date_last_hour"], 'symphony_registration_date_time');
        $admitted_discharged_last_hour_data                                                 = $common_symphony_controller->AttendanceSinceDateTimeDataProcess($process_array["attendence_today_all"], $process_array["date_last_hour"], 'symphony_discharge_date');
        $admitted_discharge_last_hour_data_discharge_date                                   = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($admitted_discharged_last_hour_data, $process_array);

        $success_array["top_sub_matrix"]["last_hour"]["arrived_value"]                      = count($attendance_last_hour_data);
        $success_array["top_sub_matrix"]["last_hour"]["left_value"]                         = count($admitted_discharge_last_hour_data_discharge_date["discharged_patients"]);
        $success_array["top_sub_matrix"]["last_hour"]["admitted_value"]                     = count($admitted_discharge_last_hour_data_discharge_date["admitted_patients"]);

        $this->PatientsSpecialityRetrieveArray($process_array, $success_array);
        arsort($success_array["content"]["speciality_counts"]);
        $success_array["content"]["speciality_counts_total"]                    = array_sum($success_array["content"]["speciality_counts"]);
        $sdec_wards = ['SDEC Planned Admissions Ward', 'SDEC (Same Day Emergency Care)'];
        $success_array['content']["todays_discharged_sdec_patients"]            = FindArrayWithKeyArraysFromParentArray($process_array["attendence_today_all"], "symphony_discharge_ward", $sdec_wards);
        $success_array['content']["todays_discharged_sdec_patients_count"]      = count($success_array['content']["todays_discharged_sdec_patients"]);


        $this->DtaPatientsRetrieveArray($process_array, $success_array);
        $this->TriageWaitingPatientsRetrieveArray($process_array, $success_array);
        $this->ConsultantSeenPatientsRetrieveArray($process_array, $success_array);

        $this->MainBarGraph($success_array, $process_array);
        $this->MainGraph($success_array, $process_array);
    }

    public function PatientsSpecialityRetrieveArray($process_array, &$success_array)
    /*****************   Admission Patient List With Details Excluded COA Ward    *****************/
    {
        $speciality_count_array        = array();
        if (count($process_array["still_in_ae_patients_list"]) > 0) {
            foreach ($process_array["still_in_ae_patients_list"] as $row) {
                if ($row['symphony_specialty'] != '') {
                    if (!isset($speciality_count_array[$row['symphony_specialty']])) {
                        $speciality_count_array[$row['symphony_specialty']]   =   0;
                    }
                    $speciality_count_array[$row['symphony_specialty']]++;
                }
            }
        }
        $success_array["content"]["speciality_counts"] = $speciality_count_array;
    }

    public function DtaPatientsRetrieveArray(&$process_array, &$success_array)
    /*****************   DTA Patients List with Details   *****************/
    {
        $data_array_process                 = $process_array["still_in_ae_patients_list"];
        $dta_list                           = array();
        $dta_longest_array                  = array();
        $dta_attendance_ids                 = array();
        $dta_comments_stored                = array();
        $dta_patient_data                   = array();
        $top_matrix_longest_arry            = array();
        $longest_dta_wait_time              = "";

        if (count($data_array_process) > 0) {
            foreach ($data_array_process as $row) {
                $request_date               = 0;
                $still_in_ae                = (isset($row["symphony_still_in_ae"]) && $row["symphony_still_in_ae"] == 1) ? 1 : 0;
                $request_date               = (isset($row["symphony_request_date"]) && $row["symphony_request_date"] != "" && $row["symphony_request_date"] != null) ? 1 : 0;
                if ($still_in_ae == 1 && $request_date == 1) {
                    $dta_attendance_ids[]   = $row["symphony_attendance_id"];
                    $dta_patient_data[]     = $row;
                }
            }
        }

        $dta_comments                                           = DtaComments::whereIn('attendance_id', $dta_attendance_ids)->get();
        if (count($dta_comments) > 0) {
            foreach ($dta_comments as $row) {
                $dta_comments_stored[$row->attendance_id] = $row->ane_dta_user_comments;
                if (strlen($dta_comments_stored[$row->attendance_id]) > 20) {
                    $dta_comments_stored[$row->attendance_id] = substr($dta_comments_stored[$row->attendance_id], 0, 20);
                    $dta_comments_stored[$row->attendance_id] .= '...';
                }
            }
        }

        if (count($dta_patient_data) > 0) {
            $x = 0;
            foreach ($dta_patient_data as $row) {
                $dta_list[$x]["symphony_patient_name"] = ucwords(strtolower($row["symphony_patient_name"])) ?? "";
                $dta_list[$x]["symphony_patient_sex"] = strtolower($row["symphony_patient_sex"]) ?? "";
                $dta_list[$x]["symphony_specialty"] = $row["symphony_specialty"] ?? "";
                $dta_list[$x]["symphony_registration_date_time"] = $row["symphony_registration_date_time"] ?? "";
                $dta_list[$x]["symphony_attendance_id"] = $row["symphony_attendance_id"] ?? "";
                $dta_list[$x]["symphony_attendance_number"] = $row["symphony_attendance_number"] ?? "";
                $dta_list[$x]["symphony_request_date"] = $row["symphony_request_date"] ?? "";
                $dta_list[$x]["symphony_dta_ward"] = $row["symphony_dta_ward"] ?? "";
                $dta_list[$x]["ane_dta_user_comments"] = $dta_comments_stored[$dta_list[$x]["symphony_attendance_id"]] ?? "";
                $dta_list[$x]["request_date_show"] = date('H:i', strtotime($row["symphony_request_date"]));
                $dta_list[$x]["wait_time_minutes"] = TimeDifferenceInMinutes($row["symphony_request_date"], $process_array["date_time_now"]);
                $top_matrix_longest_arry[] = TimeDifferenceInMinutes($row["symphony_request_date"], $process_array["date_time_now"]);
                $dta_list[$x]["wait_time_hour_minutes"] = ConvertMinutesToHourMinutesWithTextFormated($dta_list[$x]["wait_time_minutes"]);
                $dta_longest_array[] = $dta_list[$x]["wait_time_minutes"];
                $dta_list[$x]["wait_time_minutes_colour"] = ($dta_list[$x]["wait_time_minutes"] > 600) ? "#FF0000" : (($dta_list[$x]["wait_time_minutes"] > 480) ? "#ffe44a" : "#2fb07d");
                $x++;
            }
            MultiArraySortCustom($dta_list, "symphony_request_date", "asc");
        }
        if (count($top_matrix_longest_arry) > 0) {
            $longest_dta_wait_time_minutes = max($top_matrix_longest_arry);
            $longest_dta_wait_time = ConvertMinutesToHourMinutesWithTextFormatedShort($longest_dta_wait_time_minutes);
        }
        $success_array["content"]["dta_list"] = $dta_list;
        $success_array["top_sub_matrix"]["longest_wait_time"]["dta_wait"] = $longest_dta_wait_time;
    }

    public function TriageWaitingPatientsRetrieveArray(&$process_array, &$success_array)
    /************   Triage Waiting Patients List with Details    ************/
    {
        $data_array_process = $process_array["still_in_ae_patients_list"];
        $triage_waiting_list = array();
        $triage_waiting_longest_array = array();
        $longest_triage_waiting_wait_time = "";
        $x = 0;
        if (count($data_array_process) > 0) {
            foreach ($data_array_process as $row) {
                $symphony_triage_date = $row["symphony_triage_date"] ?? "";
                $still_in_ae = (isset($row["symphony_still_in_ae"]) && $row["symphony_still_in_ae"] == 1) ? 1 : 0;
                $triage_wait = ($symphony_triage_date == "" || $symphony_triage_date == null) ? 1 : 0;

                if ($still_in_ae == 1 && $triage_wait == 1) {
                    $triage_waiting_list[$x]["symphony_patient_name"]           = ucwords(strtolower($row["symphony_patient_name"])) ?? "";
                    $triage_waiting_list[$x]["symphony_patient_sex"]            = strtolower($row["symphony_patient_sex"]) ?? "";
                    $triage_waiting_list[$x]["symphony_final_location"]         = $row["symphony_final_location"] ?? "";

                    $triage_waiting_list[$x]["symphony_registration_date_time"] = $row["symphony_registration_date_time"] ?? "";
                    $triage_waiting_list[$x]["reg_date_show"]                   = PredefinedDateFormatChange($row["symphony_registration_date_time"]);
                    $date_from                                                  = $row["symphony_registration_date_time"];
                    $date_to                                                    = $process_array["date_time_now"];
                    $triage_waiting_list[$x]["wait_time_minutes"]               = TimeDifferenceInMinutes($date_from, $date_to);
                    $triage_waiting_list[$x]["wait_time_hour_minutes"]          = ConvertMinutesToHourMinutesWithTextFormatedShort($triage_waiting_list[$x]["wait_time_minutes"]);
                    $triage_waiting_longest_array[]                             = $triage_waiting_list[$x]["wait_time_minutes"];
                    $x++;
                }
            }
        }
        if (count($triage_waiting_longest_array) > 0) {
            $longest_triage_waiting_wait_time_minutes = max($triage_waiting_longest_array);
            $longest_triage_waiting_wait_time = ConvertMinutesToHourMinutesWithTextFormatedShort($longest_triage_waiting_wait_time_minutes);
        }
        $success_array["top_sub_matrix"]["longest_wait_time"]["triage_wait"] = $longest_triage_waiting_wait_time;
        $success_array["content"]["triage_waiting_list"] = $triage_waiting_list;
    }
    public function ConsultantSeenPatientsRetrieveArray(&$process_array, &$success_array)
    /***********   Patients Wait To See Consultant List with Details    ***************/
    {
        $data_array_process = $process_array["still_in_ae_patients_list"];
        $patient_wait_to_see_consultant_list = array();
        $patient_wait_to_see_consultant_longest_array = array();
        $longest_patient_wait_to_see_consultant_wait_time = "";
        $x = 0;
        if (count($data_array_process) > 0) {
            foreach ($data_array_process as $row) {
                $symphony_seen_date = $row["symphony_seen_date"] ?? "";
                $still_in_ae = (isset($row["symphony_still_in_ae"]) && $row["symphony_still_in_ae"] == 1) ? 1 : 0;
                $seen_date = ($symphony_seen_date == "" || $symphony_seen_date == null) ? 1 : 0;

                if ($still_in_ae == 1 && $seen_date == 1) {

                    $patient_wait_to_see_consultant_list[$x]["symphony_patient_name"]           = ucwords(strtolower($row["symphony_patient_name"])) ?? "";
                    $patient_wait_to_see_consultant_list[$x]["symphony_patient_sex"]            = strtolower($row["symphony_patient_sex"]) ?? "";
                    $patient_wait_to_see_consultant_list[$x]["symphony_registration_date_time"] = $row["symphony_registration_date_time"] ?? "";
                    $patient_wait_to_see_consultant_list[$x]["symphony_final_location"]         = $row["symphony_final_location"] ?? "";
                    $patient_wait_to_see_consultant_list[$x]["reg_date_show"]                   = PredefinedDateFormatChange($row["symphony_registration_date_time"]);
                    $date_from                                                                  = $row["symphony_registration_date_time"];
                    $date_to                                                                    = $process_array["date_time_now"];
                    $patient_wait_to_see_consultant_list[$x]["wait_time_minutes"]               = TimeDifferenceInMinutes($date_from, $date_to);
                    $patient_wait_to_see_consultant_list[$x]["wait_time_hour_minutes"]          = ConvertMinutesToHourMinutesWithTextFormatedShort($patient_wait_to_see_consultant_list[$x]["wait_time_minutes"]);
                    $patient_wait_to_see_consultant_longest_array[]                             = $patient_wait_to_see_consultant_list[$x]["wait_time_minutes"];
                    $x++;
                }
            }
        }

        if (count($patient_wait_to_see_consultant_longest_array) > 0) {
            $longest_patient_wait_to_see_consultant_wait_time_minutes   = max($patient_wait_to_see_consultant_longest_array);
            $longest_patient_wait_to_see_consultant_wait_time           = ConvertMinutesToHourMinutesWithTextFormatedShort($longest_patient_wait_to_see_consultant_wait_time_minutes);
        }
        $success_array["top_sub_matrix"]["longest_wait_time"]["consultant_wait"] = $longest_patient_wait_to_see_consultant_wait_time;
        $success_array["content"]["patient_wait_to_see_consultant_list"] = $patient_wait_to_see_consultant_list;
    }

    public function MainBarGraph(&$success_array, &$process_array)
    {
        $common_symphony_controller             = new CommonSymphonyController;
        $patient_assigned_no_patient_reception  = 0;
        $main_bar_chart                         = array();
        if (count($process_array["still_in_ae_patients_list"]) > 0) {
            foreach ($process_array["still_in_ae_patients_list"] as $row) {
                $symphony_final_location        = $row["symphony_final_location"] ?? "";
                $still_in_ae                    = (isset($row["symphony_still_in_ae"]) && $row["symphony_still_in_ae"] == 1) ? 1 : 0;
                $final_location                 = (strtolower($symphony_final_location) != "nil" && strtolower($symphony_final_location) != "" && strtolower($symphony_final_location) != null) ? 1 : 0;
                if ($still_in_ae == 1 && $final_location == 1) {
                    $main_bar_chart[]                       = $row;
                }
            }
        }
        if (count($process_array["attendence_today_all"]) > 0) {
            foreach ($process_array["attendence_today_all"] as $row) {
                if (isset($row['symphony_discharge_ward']) && $row['symphony_discharge_ward'] != '' && strtolower($row['symphony_discharge_ward']) == 'sau inpatient') {
                    $patient_assigned_no_patient_reception = $patient_assigned_no_patient_reception + 1;
                }
            }
        }


        $ane_bar_graph_data_arr                             = array();
        $patient_assigned_no_category                       = 0;
        $refferal_val_array                                 = array();

        if (count($main_bar_chart) > 0) {
            $x = 0;
            foreach ($main_bar_chart as $row) {
                $ane_bar_graph_data_arr[$x]["symphony_attendance_id"]           = $row["symphony_attendance_id"] ?? 0;
                $ane_bar_graph_data_arr[$x]["symphony_breach_flag"]             = $row["symphony_breach_flag"] ?? 0;
                $ane_bar_graph_data_arr[$x]["symphony_refferal_value"]          = $row["symphony_refferal_value"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_specialty"]               = $row["symphony_specialty"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_arrival_date"]            = $row["symphony_arrival_date"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_arrival_date"]            = ($ane_bar_graph_data_arr[$x]["symphony_arrival_date"] != "") ? PredefinedStandardDateFormatChange($ane_bar_graph_data_arr[$x]["symphony_arrival_date"]) : "";
                $ane_bar_graph_data_arr[$x]["symphony_registration_date_time"]  = $row["symphony_registration_date_time"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_registration_date_time"]  = ($ane_bar_graph_data_arr[$x]["symphony_registration_date_time"] != "") ? PredefinedStandardDateFormatChange($ane_bar_graph_data_arr[$x]["symphony_registration_date_time"]) : "";
                $ane_bar_graph_data_arr[$x]["symphony_triage_date"]             = $row["symphony_triage_date"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_triage_date"]             = ($ane_bar_graph_data_arr[$x]["symphony_triage_date"] != "") ? PredefinedStandardDateFormatChange($ane_bar_graph_data_arr[$x]["symphony_triage_date"]) : "";
                $ane_bar_graph_data_arr[$x]["symphony_seen_date"]               = $row["symphony_seen_date"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_seen_date"]               = ($ane_bar_graph_data_arr[$x]["symphony_seen_date"] != "") ? PredefinedStandardDateFormatChange($ane_bar_graph_data_arr[$x]["symphony_seen_date"]) : "";
                $ane_bar_graph_data_arr[$x]["symphony_final_location"]          = $row["symphony_final_location"] ?? "";
                $patient_assigned_no_category                                   = (strtolower($ane_bar_graph_data_arr[$x]["symphony_final_location"]) == "others") ? $patient_assigned_no_category + 1 : $patient_assigned_no_category;
                $ane_bar_graph_data_arr[$x]["symphony_seen_ae_by"]              = $row["symphony_seen_ae_by"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_seen_by_st4"]             = $row["symphony_seen_by_st4"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_seen_by"]                 = $row["symphony_seen_by"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_still_in_ae"]             = $row["symphony_still_in_ae"] ?? 0;
                $ane_bar_graph_data_arr[$x]["symphony_seen_ae_date"]            = $row["symphony_seen_ae_date"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_seen_ae_date"]            = ($ane_bar_graph_data_arr[$x]["symphony_seen_ae_date"] != "") ? PredefinedStandardDateFormatChange($ane_bar_graph_data_arr[$x]["symphony_seen_ae_date"]) : "";
                $ane_bar_graph_data_arr[$x]["symphony_request_date"]            = $row["symphony_request_date"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_request_date"]            = ($ane_bar_graph_data_arr[$x]["symphony_request_date"] != "") ? PredefinedStandardDateFormatChange($ane_bar_graph_data_arr[$x]["symphony_request_date"]) : "";
                $ane_bar_graph_data_arr[$x]["symphony_discharge_date"]          = $row["symphony_discharge_date"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_discharge_date"]          = ($ane_bar_graph_data_arr[$x]["symphony_discharge_date"] != "") ? PredefinedStandardDateFormatChange($ane_bar_graph_data_arr[$x]["symphony_discharge_date"]) : "";
                $ane_bar_graph_data_arr[$x]["clock_stop_dttm"]                  = ($ane_bar_graph_data_arr[$x]["symphony_discharge_date"] != "") ? PredefinedStandardDateFormatChange($ane_bar_graph_data_arr[$x]["symphony_discharge_date"]) : $process_array["date_time_now"];
                $ane_bar_graph_data_arr[$x]["symphony_refferal_date"]           = $row["symphony_refferal_date"] ?? "";
                $ane_bar_graph_data_arr[$x]["symphony_refferal_date"]           = ($ane_bar_graph_data_arr[$x]["symphony_refferal_date"] != "") ? PredefinedStandardDateFormatChange($ane_bar_graph_data_arr[$x]["symphony_refferal_date"]) : "";
                $ane_bar_graph_data_arr[$x]["symphony_discharge_ward"]          = $row["symphony_discharge_ward"] ?? "";
                $ane_bar_graph_data_arr[$x]["location_group"]                   = AneFloorMappingCategory($ane_bar_graph_data_arr[$x]["symphony_final_location"]);
                $ane_bar_graph_data_arr[$x]["minutes"]                          = ($ane_bar_graph_data_arr[$x]["symphony_discharge_date"] != "") ? TimeDifferenceInMinutes($ane_bar_graph_data_arr[$x]["symphony_registration_date_time"], $ane_bar_graph_data_arr[$x]["symphony_discharge_date"]) : TimeDifferenceInMinutes($ane_bar_graph_data_arr[$x]["symphony_registration_date_time"], $process_array["date_time_now"]);
                $ane_bar_graph_data_arr[$x]["triage_minute"]                    = ($ane_bar_graph_data_arr[$x]["symphony_arrival_date"] != "" && $ane_bar_graph_data_arr[$x]["symphony_triage_date"] != "") ? TimeDifferenceInMinutes($ane_bar_graph_data_arr[$x]["symphony_arrival_date"], $ane_bar_graph_data_arr[$x]["symphony_triage_date"]) : "";
                $ane_bar_graph_data_arr[$x]["seen_minute"]                      = ($ane_bar_graph_data_arr[$x]["symphony_triage_date"] != "" && $ane_bar_graph_data_arr[$x]["symphony_seen_date"] != "") ? TimeDifferenceInMinutes($ane_bar_graph_data_arr[$x]["symphony_triage_date"], $ane_bar_graph_data_arr[$x]["symphony_seen_date"]) : "";
                $ane_bar_graph_data_arr[$x]["disp_minute"]                      = ($ane_bar_graph_data_arr[$x]["symphony_seen_date"] != "" && $ane_bar_graph_data_arr[$x]["symphony_discharge_date"] != "") ? TimeDifferenceInMinutes($ane_bar_graph_data_arr[$x]["symphony_seen_date"], $ane_bar_graph_data_arr[$x]["symphony_discharge_date"]) : "";
                $ane_bar_graph_data_arr[$x]["check_grey"]                       = ($ane_bar_graph_data_arr[$x]["symphony_seen_ae_by"] == "" && $ane_bar_graph_data_arr[$x]["symphony_still_in_ae"] == 1 && strtolower($ane_bar_graph_data_arr[$x]["location_group"]) != "others" && strtolower($ane_bar_graph_data_arr[$x]["location_group"]) != "nil" && $ane_bar_graph_data_arr[$x]["symphony_specialty"] == "" && $ane_bar_graph_data_arr[$x]["symphony_seen_by"] == "" && $ane_bar_graph_data_arr[$x]["symphony_seen_by_st4"] == "") ? 1 : 0;
                $ane_bar_graph_data_arr[$x]["specialicy_check_circle"]          = ($ane_bar_graph_data_arr[$x]["symphony_specialty"] == "") ? 0 : 1;
                $ane_bar_graph_data_arr[$x]["not_seen"]                         = (($ane_bar_graph_data_arr[$x]["symphony_seen_date"] == "" && $ane_bar_graph_data_arr[$x]["symphony_specialty"] != "") || ($ane_bar_graph_data_arr[$x]["symphony_seen_ae_date"] == "" && $ane_bar_graph_data_arr[$x]["symphony_specialty"] == "")) ? 1 : 0;
                $ane_bar_graph_data_arr[$x]["check_blue"]                       = ($ane_bar_graph_data_arr[$x]["symphony_seen_date"] == "" && $ane_bar_graph_data_arr[$x]["symphony_still_in_ae"] == 1 && strtolower($ane_bar_graph_data_arr[$x]["location_group"]) != "others" && strtolower($ane_bar_graph_data_arr[$x]["location_group"]) != "nil" && $ane_bar_graph_data_arr[$x]["symphony_specialty"] != "" && $ane_bar_graph_data_arr[$x]["symphony_request_date"] == "") ? 1 : 0;
                $ane_bar_graph_data_arr[$x]["show_location_group"]              = AneFloorMappingCategoryShorten($ane_bar_graph_data_arr[$x]["location_group"]);
                $ane_bar_graph_data_arr[$x]["chart_bar_colour"]                 = AneLiveStatusBarChartColour($ane_bar_graph_data_arr[$x]["minutes"]);
                $ane_bar_graph_data_arr[$x]["show_minutes_at_end"]              = ConvertMinutesToHourMinutes($ane_bar_graph_data_arr[$x]["minutes"]);
                $ane_bar_graph_data_arr[$x]["show_text_bar_right_end"]          = ($ane_bar_graph_data_arr[$x]["symphony_refferal_value"] != "") ? $ane_bar_graph_data_arr[$x]["show_minutes_at_end"] . " (" . ucwords(strtolower($ane_bar_graph_data_arr[$x]["symphony_refferal_value"])) . ") " : $ane_bar_graph_data_arr[$x]["show_minutes_at_end"];
                $ane_bar_graph_data_arr[$x]["show_text_bar_left_end"]           = ($ane_bar_graph_data_arr[$x]["symphony_discharge_ward"] != "") ? $ane_bar_graph_data_arr[$x]["symphony_discharge_ward"] . " " : "";
                if ($ane_bar_graph_data_arr[$x]["symphony_request_date"] != "") {
                    $ane_bar_graph_data_arr[$x]["show_text_bar_left_end"]       = $ane_bar_graph_data_arr[$x]["show_text_bar_left_end"] . "(DTA) ";
                    $ane_bar_graph_data_arr[$x]["show_text_bar_left_end"]       = (date("d", strtotime($ane_bar_graph_data_arr[$x]["symphony_arrival_date"])) != date("d", strtotime($process_array["date_time_now"]))) ? $ane_bar_graph_data_arr[$x]["show_text_bar_left_end"] . "Y " : $ane_bar_graph_data_arr[$x]["show_text_bar_left_end"];
                    $ane_bar_graph_data_arr[$x]["show_text_bar_left_end"]       = $ane_bar_graph_data_arr[$x]["show_text_bar_left_end"] . date("H:i", strtotime($ane_bar_graph_data_arr[$x]["symphony_request_date"]));
                }
                if ($ane_bar_graph_data_arr[$x]["symphony_still_in_ae"] == 1 && $ane_bar_graph_data_arr[$x]["symphony_refferal_value"] != "") {
                    $refferal_val_array[] = $ane_bar_graph_data_arr[$x]["symphony_refferal_value"];
                }

                //To Temporarily Hide Grey & Blue Dots In Barchart
                $ane_bar_graph_data_arr[$x]["check_grey"]                       = 0;
                $ane_bar_graph_data_arr[$x]["check_blue"]                       = 0;
                $x++;
            }
        }

        $total_refferal_val_count       = count($refferal_val_array);
        $refferal_val_array_details     = array_count_values($refferal_val_array);
        MultiArraySortCustom($ane_bar_graph_data_arr, "minutes", "desc");

        $sorted_ref_array               = $ane_bar_graph_data_arr;
        $ane_bar_graph_data_arr         = array();
        if (count($sorted_ref_array) > 0) {
            foreach ($sorted_ref_array as $row) {
                $ane_bar_graph_data_arr[] = $row;
            }
        }

        ksort($refferal_val_array_details);

        $referral_val_text_show         = "";
        $referral_val_text_show_array   = array();
        $referral_val_text_show_total   = 0;
        if (isset($refferal_val_array_details)) {
            if (count($refferal_val_array_details) > 0) {
                foreach ($refferal_val_array_details as $key => $row) {
                    $referral_val_text_show_array[] = $key . " : " . $row;
                    $referral_val_text_show_total = $referral_val_text_show_total + $row;
                }
            }
        }
        $referral_val_text_show         = implode(", ", $referral_val_text_show_array);
        $still_in_ane_val               = 0;

        if (CheckCountArrayToProcess($main_bar_chart)) {
            $still_in_ane_val = count($process_array["still_in_ae_patients_list"]);
        }

        $aande_time_serious = array();
        $common_symphony_controller->AneTimeSeriesDataProcess($ane_bar_graph_data_arr, $aande_time_serious, $process_array);

        $success_array["bar_graph"]["colour_band_graph"] = $aande_time_serious;
        $success_array["bar_graph"]["graph_data"] = $ane_bar_graph_data_arr;
        $success_array["bar_graph"]["total_refferal_val_count"] = $total_refferal_val_count;
        $success_array["bar_graph"]["refferal_val_array_details"] = $refferal_val_array_details;
        $success_array["bar_graph"]["referral_val_text_show"] = $referral_val_text_show;
        $success_array["bar_graph"]["referral_val_text_show_total"] = $referral_val_text_show_total;
        $success_array["bar_graph"]["in_ed_now"] = $still_in_ane_val;
        $success_array["bar_graph"]["patient_assigned_no_patient_reception"] = $patient_assigned_no_patient_reception;
        $success_array["bar_graph"]["patient_assigned_no_category"] = $patient_assigned_no_category;
    }

    public function MainGraph(&$success_array, &$process_array)
    {
        $still_in_ane_patients_list      = $process_array["still_in_ae_patients_list"];
        $dta_patients_array              = array();
        $dta_without_allocated_bed_patients_array = array();
        $without_allocated_bed_count_text = "";
        if (CheckCountArrayToProcess($still_in_ane_patients_list)) {
            foreach ($still_in_ane_patients_list as $row) {
                if (isset($row["symphony_request_date"])) {
                    if ($row["symphony_request_date"] != "") {
                        $dta_patients_array[] = $row;
                        if (isset($row["symphony_dta_ward"])) {
                            if ($row["symphony_dta_ward"] == "") {
                                $dta_without_allocated_bed_patients_array[] = $row;
                            }
                        } else {
                            $dta_without_allocated_bed_patients_array[] = $row;
                        }
                    }
                }
            }
        }
        $total_dta_patients = count($dta_patients_array);
        $without_allocated_bed_count = count($dta_without_allocated_bed_patients_array);
        if ($without_allocated_bed_count != 0 && $total_dta_patients != 0) {
            $without_allocated_bed_count_text = $total_dta_patients . " patients with a DTA but " . $without_allocated_bed_count . " without an allocated bed.";
        } else {
            $without_allocated_bed_count_text = "All patients with a DTA have been allocated a bed.";
        }

        $triage_longest_waiter_text = "";
        $triage_longest_array = array();
        $triage_greater_15_min_patients_array = array();
        $trige_side_text = "";
        if (CheckCountArrayToProcess($still_in_ane_patients_list)) {
            foreach ($still_in_ane_patients_list as $row) {
                $triage_date_set = 0;
                $minute_difference_check = 0;
                if (isset($row["symphony_triage_date"])) {
                    if ($row["symphony_triage_date"] == "") {
                        $triage_date_set = 1;
                    }
                } else {
                    $triage_date_set = 1;
                }
                if (isset($row["symphony_registration_date_time"])) {
                    $date_from = $row["symphony_registration_date_time"];
                    $date_to = $process_array["date_time_now"];
                    $minutes_difference = TimeDifferenceInMinutes($date_from, $date_to);
                    if ($minutes_difference > 15) {
                        $minute_difference_check = 1;
                    }
                }
                if ($triage_date_set == 1 && $minute_difference_check == 1) {
                    $triage_greater_15_min_patients_array[] = $row;
                    $final_location_array = $process_array['ibox_symphony_final_location_category_main'];
                    if (isset($row["symphony_final_location"])) {
                        $key_to_check = AneFloorMappingCategoryShorten($row["symphony_final_location"]);
                        if (in_array($key_to_check, $final_location_array)) {
                            $triage_longest_array[] = $minutes_difference;
                        }
                    }
                }
            }
        }
        if (count($triage_longest_array) > 0) {
            $longest_dta_wait_time_minutes_triage = max($triage_longest_array);
            $triage_longest_waiter_text = ConvertMinutesToHourMinutesWithText($longest_dta_wait_time_minutes_triage);
        }
        $triage_patient_waiting = count($triage_longest_array);
        $total_triage_patients = count($triage_greater_15_min_patients_array);
        if ($triage_patient_waiting > 0) {
            $trige_side_text = $triage_patient_waiting . " patients waiting longer than 15 mins for Triage Assessment. ";
            if ($triage_longest_waiter_text != "") {
                $trige_side_text .= "(Longest Waiter : $triage_longest_waiter_text)";
            }
        }

        $main_graph_data_details = array();
        $this->AneMainGraphCategorySplitWithFinalLocation($dta_patients_array, $main_graph_data_details, "with_dta", $process_array);
        $this->AneMainGraphCategorySplitWithFinalLocation($still_in_ane_patients_list, $main_graph_data_details, "in_ed_now", $process_array);
        $this->AneMainGraphCategorySplitWithFinalLocation($triage_greater_15_min_patients_array, $main_graph_data_details, "triage", $process_array);

        if (count($main_graph_data_details) > 0) {
            foreach ($main_graph_data_details as $key => $cl_val) {
                $main_graph_data_details[$key]["category_total"] = 0;
                foreach ($cl_val as $key1 => $cl_val1) {
                    if ($key == "triage") {
                        $main_graph_data_details[$key]["category_total"] = $main_graph_data_details[$key]["category_total"] + $cl_val1["value"];
                    } else {
                        $main_graph_data_details[$key]["category_total"] = $main_graph_data_details[$key]["category_total"] + $cl_val1["value"];
                    }
                }
            }
        }
        $this->AneMainGraphCategorySplitWithFinalLocationColours($main_graph_data_details);


        $success_array["main_graph"]["graph_data"] = $main_graph_data_details;
        $success_array["main_graph"]["trige_side_text"] = $trige_side_text;
        $success_array["main_graph"]["without_allocated_bed_count_text"] = $without_allocated_bed_count_text;


        $success_array["main_graph"]["with_dta"] = $total_dta_patients;
        $success_array["main_graph"]["last_15min_triage"] = $triage_greater_15_min_patients_array;
        $success_array["main_graph"]["last_15_min_triage_count"] = count($triage_greater_15_min_patients_array);
        $opel_data = OpelCurrentStatus::first();

        $success_array["main_graph"]["ane_opel_status_data"]                                        = 0;
        $success_array["main_graph"]["ane_opel_status_data_show_status"]                            = 0;
        $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]            = 'opel_0';

        if (isset($opel_data->id)) {
            $success_array["main_graph"]["ane_opel_status_data"]                                    = $opel_data->ane_opel_status_data;
            $success_array["main_graph"]["ane_opel_status_data_show_status"]                        = $opel_data->ane_opel_status_data_show_status;
            if ($opel_data->ane_opel_status_data_show_status == 0) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_0';
            } elseif ($opel_data->ane_opel_status_data == 1) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_1';
            } elseif ($opel_data->ane_opel_status_data == 2) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_2';
            } elseif ($opel_data->ane_opel_status_data == 3) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_3';
            } elseif ($opel_data->ane_opel_status_data == 4) {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_4';
            } else {
                $success_array["main_graph"]["ane_opel_status_data_show_status_text_show_image"]    = 'opel_0';
            }
        }

        $last_ed_key = SymphonyEDThermometer::orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->where('ed_key', 'current_opel_status')
            ->first()->ed_value ?? 0;
        $success_array["opel_status"]            = $last_ed_key;
        $success_array["opel_image"]            = 'opel_' . $last_ed_key;
        return ReturnArrayAsJsonToScript($success_array);
    }
    public function   AneMainGraphCategorySplitWithFinalLocation($patient_array_to_process, &$return_array, $array_index, $process_array)
    {
        $final_location_array = $process_array['ibox_symphony_final_location_category_main'];

        $temp_storage_array = array();
        foreach ($final_location_array as $row) {
            $return_array[$array_index][$row]["key"] = $row;
            $return_array[$array_index][$row]["value"] = 0;
            $return_array[$array_index][$row]["colour"] = "green";
            $temp_storage_array[$row] = array();
        }


        if (CheckCountArrayToProcess($patient_array_to_process)) {
            foreach ($patient_array_to_process as $row) {
                if (isset($row["symphony_final_location"])) {
                    $key = AneFloorMappingCategoryShorten($row["symphony_final_location"]);
                    if (in_array($key, $final_location_array)) {
                        $temp_storage_array[$key][] = $row;
                    } else {
                        $temp_storage_array['Others'][] = $row;
                    }
                }
            }
        }





        foreach ($final_location_array as $row) {
            if (isset($temp_storage_array[$row])) {
                $return_array[$array_index][$row]["key"] = $row;
                $return_array[$array_index][$row]["value"] = count($temp_storage_array[$row]);
            }
        }
    }

    public function   AneMainGraphCategorySplitWithFinalLocationData($patient_array_to_process, &$return_array, $array_index, $process_array)
    {
        $final_location_array = $process_array['ibox_symphony_final_location_category_main'];

        $temp_storage_array = array();
        foreach ($final_location_array as $row) {
            $return_array[$array_index][$row]["key"] = $row;
            $return_array[$array_index][$row]["value"] = 0;
            $return_array[$array_index][$row]["colour"] = "green";
            $temp_storage_array[$row] = array();
        }


        if (CheckCountArrayToProcess($patient_array_to_process)) {
            foreach ($patient_array_to_process as $row) {
                if (isset($row["symphony_final_location"])) {
                    $key = AneFloorMappingCategoryShorten($row["symphony_final_location"]);
                    if (in_array($key, $final_location_array)) {
                        $temp_storage_array[$key][] = $row;
                    } else {
                        $temp_storage_array['Others'][] = $row;
                    }
                }
            }
        }





        foreach ($final_location_array as $row) {
            if (isset($temp_storage_array[$row])) {
                $return_array[$array_index][$row]["key"] = $row;
                $return_array[$array_index][$row]["value"] = count($temp_storage_array[$row]);
            }
        }

        return $temp_storage_array;
    }

    public function AneMainGraphCategorySplitWithFinalLocationColours(&$return_array)
    {
        if (count($return_array) > 0) {
            foreach ($return_array as $key => $row) {
                $check_total_value = 0;
                $category_colour_set = "#00B050";
                if (isset($row["category_total"])) {
                    $check_total_value = $row["category_total"];
                }

                if ($key == "with_dta") {
                    $category_colour_set = ($check_total_value >= 12) ? "#000000" : (($check_total_value >= 7) ? "#FF0000" : (($check_total_value >= 3) ? "#FFC000" : "#00B050"));
                }
                if ($key == "in_ed_now") {
                    $category_colour_set = ($check_total_value >= 27) ? "#000000" : (($check_total_value >= 24) ? "#FF0000" : (($check_total_value >= 21) ? "#FFC000" : "#00B050"));
                }
                if ($key == "triage") {
                    $category_colour_set = ($check_total_value >= 12) ? "#000000" : (($check_total_value >= 9) ? "#FF0000" : (($check_total_value >= 3) ? "#FFC000" : "#00B050"));
                }
                $return_array[$key]["colour_value_set"] = $category_colour_set;
            }
        }
    }

    public function GetAneDtaCommentsDetails(Request $request)
    {
        if (CheckSpecificPermission('dta_comment_view')) {
            $return_array = array();
            $ane_dta_attendance_id = $request->ane_dta_attendance_id;
            if ($ane_dta_attendance_id != "") {
                $return_array = DtaComments::where('attendance_id', '=', $ane_dta_attendance_id)->first();
            }
            return ReturnArrayAsJsonToScript($return_array);
        } else {
            return PermissionDenied();
        }
    }

    public function AneDtaCommentsSave(Request $request)
    {
        if (CheckSpecificPermission('dta_comment_add')) {
            $history_controller = new HistoryController;
            $history_opel_status = "App\Models\History\HistorySymphonyAneDtaComments";
            $success_array = array();
            $ane_dta_attendance_id = $request->ane_dta_attendance_id;
            $ane_dta_user_comments = $request->ane_dta_user_comments;
            $user_id = Session()->get('LOGGED_USER_ID', '');
            $success_array["message"] = ErrorOccuredMessage();
            if ($ane_dta_attendance_id != "" && $user_id != "") {
                $gov_text_before_arr = DtaComments::where('attendance_id', '=', $ane_dta_attendance_id)->first();
                $dta_comments_data = DtaComments::updateOrCreate(['attendance_id' => $ane_dta_attendance_id], ['ane_dta_user_comments' => $ane_dta_user_comments, 'updated_by' => $user_id]);
                $history_controller->HistoryTableDataInsertFromUpdateCreate($dta_comments_data, $history_opel_status);
                if ($dta_comments_data->wasRecentlyCreated) {
                    $success_array["message"] = DataAddedMessage();
                    $updated_array = $dta_comments_data->getOriginal();
                    $gov_text_before = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $this->GovernanceDtaCommentPreCall($ane_dta_attendance_id, $updated_array["id"], $gov_text_before, 1);
                    }
                } else {
                    $success_array["message"]                   = DataUpdatedMessage();
                    if (count($dta_comments_data->getChanges()) > 0) {
                        $updated_array = $dta_comments_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before = $gov_text_before_arr->toArray();
                                $this->GovernanceDtaCommentPreCall($ane_dta_attendance_id, $updated_array["id"], $gov_text_before, 2);
                            }
                        }
                    }
                }
                $success_array["ane_dta_user_comments"] = $ane_dta_user_comments;
                if (strlen($success_array["ane_dta_user_comments"]) > 20) {
                    $success_array["ane_dta_user_comments"]     = substr($success_array["ane_dta_user_comments"], 0, 20);
                    $success_array["ane_dta_user_comments"]    .= '...';
                }
            }
            return ReturnArrayAsJsonToScript($success_array);
        } else {
            return PermissionDenied();
        }
    }

    public function AneDtaCommentsDelete(Request $request)
    {
        if (CheckSpecificPermission('dta_comment_delete')) {
            $success_array = array();
            $ane_dta_attendance_id = $request->ane_dta_attendance_id;
            $user_id = Session()->get('LOGGED_USER_ID', '');
            $success_array["message"] = ErrorOccuredMessage();
            if ($ane_dta_attendance_id != "" && $user_id != "") {
                $gov_text_before_arr = DtaComments::where('attendance_id', '=', $ane_dta_attendance_id)->first();
                $success_array = DtaComments::where('attendance_id', '=', $ane_dta_attendance_id)->first();
                if ($success_array) {
                    DtaComments::where('attendance_id', $ane_dta_attendance_id)->delete();
                    $success_array["message"] = DataRemovalMessage();
                    if ($gov_text_before_arr) {
                        $gov_text_before = $gov_text_before_arr->toArray();
                        $this->GovernanceDtaCommentPreCall($ane_dta_attendance_id, $gov_text_before["id"], $gov_text_before, 3);
                    }
                }
            }
            return ReturnArrayAsJsonToScript($success_array);
        } else {
            return PermissionDenied();
        }
    }

    public function GovernanceDtaCommentPreCall($attendance_id, $id, $gov_text_before, $operation)
    {
        $gov_data = array();
        $gov_text_after_arr = DtaComments::where('id', '=', $id)->first();

        $default_governance_field = "ane_dta_user_comments";
        $functional_identity = RetriveSpecificConstantSettingValues("ibox_frontend_governance_symphony_ane_dta_comments", "ibox_governance_frontend_functional_names");
        if ($operation == 1) {
            if ($gov_text_after_arr) {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"])) {
                $gov_data["gov_text_before"] = "";
                $gov_data["gov_text_after"] = json_encode($gov_text_after);
                $gov_data["gov_attendance_id"] = $attendance_id;
                $gov_data["gov_updation_status"] = $operation;
                $gov_data["gov_func_identity"] = $functional_identity;
                $gov_data["gov_description"] = $gov_text_after[$default_governance_field];
            }
        }
        if ($operation == 2) {
            if ($gov_text_after_arr) {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"] = json_encode($gov_text_before);
                $gov_data["gov_text_after"] = json_encode($gov_text_after);
                $gov_data["gov_attendance_id"] = $attendance_id;
                $gov_data["gov_updation_status"] = $operation;
                $gov_data["gov_func_identity"] = $functional_identity;
                $gov_data["gov_description"] = $gov_text_after[$default_governance_field];
            }
        }
        if ($operation == 3) {
            if (isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"] = json_encode($gov_text_before);
                $gov_data["gov_text_after"] = "";
                $gov_data["gov_attendance_id"] = $attendance_id;
                $gov_data["gov_updation_status"] = $operation;
                $gov_data["gov_func_identity"] = $functional_identity;
                $gov_data["gov_description"] = $gov_text_before[$default_governance_field];
            }
        }
        if (!empty($gov_data)) {
            if (count($gov_data) > 0) {
                $governance = new GovernanceController;
                $governance->GovernanceStoreSymphonyData($gov_data);
            }
        }
    }

    public function GetAneOpelDataDetails(Request $request)
    {
        if (CheckSpecificPermission('opel_modal_view')) {

            $success_array          = array();
            $table_ane_opel_status  = OpelCurrentStatus::ReturnTableName();
            $table_user             = User::ReturnTableName();
            $process_array          = OpelCurrentStatus::leftJoin("$table_user", function ($join) use ($table_user, $table_ane_opel_status) {
                $join->on($table_user . ".id", "=", $table_ane_opel_status . ".ane_opel_status_data_user_updated");
            })->whereIn('ane_opel_status_data_type', [1, 2])->select("$table_ane_opel_status.*", "$table_user.username")->get();

            if (count($process_array) > 0) {
                foreach ($process_array as $row) {
                    if ($row->ane_opel_status_data_type == 1) {
                        $success_array["ane_ed_opel_status_data_type"]                  = $row->ane_opel_status_data_type;
                        $success_array["ane_ed_opel_status_data"]                       = $row->ane_opel_status_data;
                        $success_array["ane_ed_opel_status_data_comment"]               = $row->ane_opel_status_data_comment;
                        $success_array["ane_ed_opel_status_data_show_status"]           = $row->ane_opel_status_data_show_status;
                        $success_array["ane_ed_opel_status_data_user_updated"]          = $row->ane_opel_status_data_user_updated;
                        $success_array["ane_ed_opel_status_data_updated_date_time"]     = $row->ane_opel_status_data_updated_date_time;
                        $success_array["ane_ed_opel_status_username"]                   = $row->username;
                        $success_array["ane_ed_opel_status_data_updated_date_time_update_show"] = "";
                        if ($row->ane_opel_status_data_updated_date_time != "" && $success_array["ane_ed_opel_status_username"] != "") {
                            $success_array["ane_ed_opel_status_data_updated_date_time_update_show"] = "Updated At " . PredefinedDateFormatFor24Hour($row->ane_opel_status_data_updated_date_time) . " By " . ucfirst($row->username);
                        }
                    }
                    if ($row->ane_opel_status_data_type == 2) {
                        $success_array["ane_ward_opel_status_data_type"]                = $row->ane_opel_status_data_type;
                        $success_array["ane_ward_opel_status_data"]                     = $row->ane_opel_status_data;
                        $success_array["ane_ward_opel_status_data_comment"]             = $row->ane_opel_status_data_comment;
                        $success_array["ane_ward_opel_status_data_show_status"]         = $row->ane_opel_status_data_show_status;
                        $success_array["ane_ward_opel_status_data_user_updated"]        = $row->ane_opel_status_data_user_updated;
                        $success_array["ane_ward_opel_status_data_updated_date_time"]   = $row->ane_opel_status_data_updated_date_time;
                        $success_array["ane_ward_opel_status_username"] = $row->username;
                        $success_array["ane_ward_opel_status_data_updated_date_time_update_show"] = "";
                        if ($row->ane_opel_status_data_updated_date_time != "" && $row->username != "") {
                            $success_array["ane_ward_opel_status_data_updated_date_time_update_show"] = "Updated At " . PredefinedDateFormatFor24Hour($row->ane_opel_status_data_updated_date_time) . " By " . ucfirst($row->username);
                        }
                    }
                }
            }
            return ReturnArrayAsJsonToScript($success_array);
        } else {
            return PermissionDenied();
        }
    }



    public function GetAneOpelDataDetailsSave(Request $request)
    {
        if (CheckSpecificPermission('opel_modal_update')) {
            $history_controller                     = new HistoryController;
            $history_opel_status                    = "App\Models\History\HistorySymphonyAneOpenStatus";
            $success_array                          = array();
            $updated_date_time                      = CurrentDateOnFormat();
            $ane_ward_opel_status_data              = $request->ane_ward_opel_status_data;
            $ane_ward_opel_status_comment           = $request->ane_ward_opel_status_comment;
            $ane_ward_opel_status_data_show_status  = $request->ane_ward_opel_status_data_show_status;
            $user_id = Session()->get('LOGGED_USER_ID', '');
            $success_array["message"] = ErrorOccuredMessage();

            if ($user_id != "") {

                if ($ane_ward_opel_status_data != "" && $ane_ward_opel_status_data != 0) {
                    $user_info_update               = 0;
                    $gov_text_before_arr            = OpelCurrentStatus::where('ane_opel_status_data_type', '=', 2)->first();
                    $ward_opel_update_details       = OpelCurrentStatus::updateOrCreate(['ane_opel_status_data_type' => 2], ['ane_opel_status_data' => $ane_ward_opel_status_data, 'ane_opel_status_data_comment' => $ane_ward_opel_status_comment, 'ane_opel_status_data_show_status' => $ane_ward_opel_status_data_show_status]);
                    if ($ward_opel_update_details->wasRecentlyCreated) {
                        $user_info_update          = 1;
                        $success_array["message"]  = SystemDataAddedMessage();
                        $updated_array             = $gov_text_before_arr->getOriginal();
                        $gov_text_before = array();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            $this->GovernanceOpelDataPreCall($updated_array["id"], $gov_text_before, 1);
                        }
                    } else {
                        if (count($ward_opel_update_details->getChanges()) > 0) {
                            $user_info_update   = 1;
                            $updated_array      = $gov_text_before_arr->getOriginal();
                            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                if ($gov_text_before_arr) {
                                    $gov_text_before = $gov_text_before_arr->toArray();
                                    $this->GovernanceOpelDataPreCall($updated_array["id"], $gov_text_before, 2);
                                }
                            }
                        }
                        $success_array["message"]   = SystemDataUpdatedMessage();
                    }
                    if ($user_info_update == 1) {
                        $ward_opel_update_details   = OpelCurrentStatus::updateOrCreate(['ane_opel_status_data_type' => 2], ['ane_opel_status_data_user_updated' => $user_id, 'ane_opel_status_data_updated_date_time' => $updated_date_time]);
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($ward_opel_update_details, $history_opel_status);
                    }
                }
            }
            return ReturnArrayAsJsonToScript($success_array);
        } else {
            return PermissionDenied();
        }
    }



    public function GovernanceOpelDataPreCall($id, $gov_text_before, $operation)
    {

        $gov_data = array();
        $gov_text_after = array();

        $functional_identity = RetriveSpecificConstantSettingValues("ibox_frontend_governance_ibox_ane_opel", "ibox_governance_frontend_functional_names");
        if ($operation == 1) {
            if (isset($id) && $id != '') {
                $gov_text_after_arr = OpelCurrentStatus::where('id', '=', $id)->first();
                if ($gov_text_after_arr) {
                    $gov_text_after = $gov_text_after_arr->toArray();
                }
            }
            if (isset($gov_text_after["id"])) {
                $gov_data["gov_text_before"] = "";
                $gov_data["gov_text_after"] = json_encode($gov_text_after);
                $gov_data["gov_updation_status"] = $operation;
                $gov_data["gov_func_identity"] = $functional_identity;
                $gov_data["gov_description"] = 'OPEL Status';
            }
        }
        if ($operation == 2) {
            if (isset($id) && $id != '') {
                $gov_text_after_arr = OpelCurrentStatus::where('id', '=', $id)->first();
                if ($gov_text_after_arr) {
                    $gov_text_after = $gov_text_after_arr->toArray();
                }
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"] = json_encode($gov_text_before);
                $gov_data["gov_text_after"] = json_encode($gov_text_after);
                $gov_data["gov_updation_status"] = $operation;
                $gov_data["gov_func_identity"] = $functional_identity;
                $gov_data["gov_description"] = 'OPEL Status';
            }
        }
        if (!empty($gov_data)) {
            if (count($gov_data) > 0) {
                $governance = new GovernanceController;
                $governance->GovernanceStoreIboxData($gov_data);
            }
        }
    }
    public function GovernanceIboxDataPreCall($gov_text_after_arr, $gov_text_before, $operation)
    {
        $gov_data               = array();
        $gov_text_after         = array();
        $functional_identity = 'ED Thermometer';
        if ($operation == 1) {
            if (isset($id) && $id != '') {

                if ($gov_text_after_arr) {
                    $gov_text_after = $gov_text_after_arr->toArray();
                }
            }
            if (isset($gov_text_after["id"])) {
                $gov_data["gov_text_before"]        = "";
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = 'ED Thermometer Data Changes';
            }
        }
        if ($operation == 2) {
            if (isset($id) && $id != '') {


                if ($gov_text_after_arr) {
                    $gov_text_after                 = $gov_text_after_arr->toArray();
                }
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = 'ED Thermometer Data Changes';
            }
        }

        if (!empty($gov_data)) {

            if (count($gov_data) > 0) {

                $governance = new GovernanceController;
                $governance->GovernanceStoreIboxData($gov_data);
            }
        }
    }

    public function GetSauPatient(Request $request)
    {
        $success_array = array();
        $process_array = array();
        $process_array["attendance_data"]  = SymphonyAneAttendanceView::query()->
        // when($request->filled('type'), function ($q) use ($request) {
        //     if ($request->type == 'sau') {
        //         return $q->where('symphony_discharge_ward', 'sau inpatient');
        //     } else {
        //         return $q->where('symphony_discharge_ward', 'SDEC (Same Day Emergency Care)');
        //     }
        // })
        orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();


        if ($process_array["attendance_data"] != null) {
            $success_array["attendance_data"] =  $process_array["attendance_data"];
        } else {
            $success_array["attendance_data"] = [];
        }
        return view('Dashboards.Symphony.Ane.Partial.SauPatientList', compact('success_array'));
    }

    public function GetPatientByIdFromBarChart(Request $request)
    {

        $success_array = array();
        $process_array = array();
        $process_array["attendance_data"]     = SymphonyAttendanceView::where('symphony_attendance_id', $request->attendance_id)->where('symphony_still_in_ae', '=', 1)->first()->toArray();

        if ($process_array["attendance_data"] != null) {
            $success_array["attendance_data"] =  $process_array["attendance_data"];
        } else {
            $success_array["attendance_data"] = [];
        }
        return view('Dashboards.Symphony.Ane.Partial.AttendanceDetailsView', compact('success_array'));
    }

    public function TriageData($still_in_ane_patients_list)
    {
        $triage_greater_15_min_patients_array = array();
        if (CheckCountArrayToProcess($still_in_ane_patients_list)) {
            foreach ($still_in_ane_patients_list as $row) {
                $triage_date_set = 0;
                $minute_difference_check = 0;
                if (isset($row["symphony_triage_date"])) {
                    if ($row["symphony_triage_date"] == "") {
                        $triage_date_set = 1;
                    }
                } else {
                    $triage_date_set = 1;
                }
                if (isset($row["symphony_registration_date_time"])) {
                    $date_from = $row["symphony_registration_date_time"];
                    $date_to = now();
                    $minutes_difference = TimeDifferenceInMinutes($date_from, $date_to);
                    if ($minutes_difference > 15) {
                        $minute_difference_check = 1;
                    }
                }
                if ($triage_date_set == 1 && $minute_difference_check == 1) {
                    $triage_greater_15_min_patients_array[] = $row;
                }
            }
        }
        return $triage_greater_15_min_patients_array;
    }


    public function GetDetailsBySpeciality(Request $request)
    {

        //        dd($request->all());
        $success_array = array();
        $process_array = array();

        $main_graph_data_details = array();

        $common_controller = new CommonController;

        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        if ($request->type == 'speciality') {
            $process_array["assigned_specialities"]     = SymphonyAttendanceView::where('symphony_still_in_ae', '=', 1)->get()->toArray();
        }

        if ($request->key == 'dta') {
            $process_array['type'] = $request->type;
            $still_in_ane_patients_list     = SymphonyAttendanceView::where('symphony_still_in_ae', '=', 1)->whereNotNull('symphony_request_date')->get()->toArray();
            $ed_data                        =       $this->AneMainGraphCategorySplitWithFinalLocationData($still_in_ane_patients_list, $main_graph_data_details, "with_dta", $process_array);

            $process_array["assigned_specialities"] = CategoryWiseFillter($process_array, $ed_data);
        }

        if ($request->key == 'in_ed') {
            $process_array['type'] = $request->type;
            $still_in_ane_patients_list     = SymphonyAttendanceView::where('symphony_still_in_ae', '=', 1)->get()->toArray();
            $ed_data              =       $this->AneMainGraphCategorySplitWithFinalLocationData($still_in_ane_patients_list, $main_graph_data_details, "in_ed_now", $process_array);

            $process_array["assigned_specialities"] =  CategoryWiseFillter($process_array, $ed_data);
        }
        if ($request->key == 'triage') {
            $process_array['type'] = $request->type;
            $still_in_ane_patients_list     = SymphonyAttendanceView::where('symphony_still_in_ae', '=', 1)
                ->whereNull('symphony_triage_date')

                ->get()->toArray();

            $still_in_ane_patients_list = $this->TriageData($still_in_ane_patients_list);


            $ed_data                        =       $this->AneMainGraphCategorySplitWithFinalLocationData($still_in_ane_patients_list, $main_graph_data_details, "triage", $process_array);

            $process_array["assigned_specialities"] = CategoryWiseFillter($process_array, $ed_data);
        }


        if ($process_array["assigned_specialities"] != null) {
            $success_array["assigned_specialities"] =  $process_array["assigned_specialities"];
        } else {
            $success_array["assigned_specialities"] = [];
        }

        return view('Dashboards.Symphony.Ane.Partial.SpecialityDetailsView', compact('success_array'));
    }

    public function AneOpelStatusModalLoadOne(Request $request)
    {
        $success_array                      = array();
        $current_date_set_time              = date('Y-m-d 00:00');

        $current_date_set_time_cr           = (int)date('H');
        for ($x = 0; $x <= $current_date_set_time_cr; $x++) {
            $hour_time                      = date('H:i', strtotime($current_date_set_time . "+$x hour"));
            $time_options[$hour_time]       = $hour_time;
        }
        $success_array['set_date_format']          = date('Y-m-d');
        $success_array['set_date']          = date('jS M Y');
        $success_array['set_time']          = date('H:00');
        $success_array['time_options']      = $time_options;

        $in_ed_now          = SymphonyAttendanceView::where('symphony_still_in_ae', '=', 1)->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();

        if (CheckCountArrayToProcess($in_ed_now)) {
            foreach ($in_ed_now as $row) {
                if (isset($row["symphony_request_date"])) {
                    if ($row["symphony_request_date"] != "") {
                        $dta_patients_array[] = $row;
                        if (isset($row["symphony_dta_ward"])) {
                            if ($row["symphony_dta_ward"] == "") {
                                $dta_without_allocated_bed_patients_array[] = $row;
                            }
                        } else {
                            $dta_without_allocated_bed_patients_array[] = $row;
                        }
                    }
                }
            }
        }
        $success_array['total_without_bed'] = count($dta_without_allocated_bed_patients_array);
        $success_array['in_ed_now'] = count($in_ed_now);
        $safety_thermometer_view = SymphonyAneThermometerView::pluck('metric_value', 'metric_key')
            ->map(function ($value) {
                return $value !== null ? (int) $value : null;
            })
            ->toArray();

        $view                               = View::make('Dashboards.Symphony.Ane.OpelModal.DataLoadStageOne', compact('safety_thermometer_view', 'success_array'));
        $sections                           = $view->render();
        return                              $sections;
    }

    public function AneOpelStatusModalLoadTwo(Request $request)
    {
        $success_array                      = array();
        $current_date_set_time              = date('Y-m-d 00:00');

        $current_date_set_time_cr           = (int)date('H');
        for ($x = 0; $x <= $current_date_set_time_cr; $x++) {
            $hour_time                      = date('H:i', strtotime($current_date_set_time . "+$x hour"));
            $time_options[$hour_time]       = $hour_time;
        }
        $success_array['set_date_format']          = date('Y-m-d');
        $success_array['set_date']          = date('jS M Y');
        $success_array['set_time']          = date('H:00');
        $success_array['time_options']      = $time_options;
        $safety_thermometer_view = SymphonyAneThermometerView::pluck('metric_value', 'metric_key')
            ->map(function ($value) {
                return $value !== null ? (int) $value : null;
            })
            ->toArray();


        $view                               = View::make('Dashboards.Symphony.Ane.OpelModal.DataLoadStageTwo', compact('success_array', 'safety_thermometer_view'));
        $sections                           = $view->render();
        return                              $sections;
    }

    public function AneOpelStatusModalLoadThree(Request $request)
    {
        $success_array                      = array();
        $current_date_set_time              = date('Y-m-d 00:00');

        $current_date_set_time_cr           = (int)date('H');
        for ($x = 0; $x <= $current_date_set_time_cr; $x++) {
            $hour_time                      = date('H:i', strtotime($current_date_set_time . "+$x hour"));
            $time_options[$hour_time]       = $hour_time;
        }
        $success_array['set_date_format']          = date('Y-m-d');
        $success_array['set_date']          = date('jS M Y');
        $success_array['set_time']          = date('H:00');
        $success_array['time_options']      = $time_options;
        $view                               = View::make('Dashboards.Symphony.Ane.OpelModal.DataLoadStageThree', compact('success_array'));
        $sections                           = $view->render();
        return                              $sections;
    }

    public function AneOpelStatusModalLoadFour(Request $request)
    {
        $success_array                      = array();


        $safety_thermometer_view = SymphonyAneThermometerView::pluck('metric_value', 'metric_key')
            ->map(function ($value) {
                return $value !== null ? (int) $value : null;
            })
            ->toArray();



        $view                               = View::make('Dashboards.Symphony.Ane.OpelModal.DataLoadStageFour', compact('safety_thermometer_view'));
        $sections                           = $view->render();
        return                              $sections;
    }

    public function AneOpelStatusModalLoadFive(Request $request)
    {
        $success_array                      = array();
        $safety_thermometer_view = SymphonyAneThermometerView::pluck('metric_value', 'metric_key')
            ->map(function ($value) {
                return $value !== null ? (int) $value : null;
            })
            ->toArray();


        $view                               = View::make('Dashboards.Symphony.Ane.OpelModal.DataLoadStageFive', compact('safety_thermometer_view'));
        $sections                           = $view->render();
        return                              $sections;
    }

    public function AneOpelStatusModalLoadSix(Request $request)
    {
        $success_array                      = array();
        $safety_thermometer_view = SymphonyAneThermometerView::pluck('metric_value', 'metric_key')
            ->map(function ($value) {
                return $value !== null ? (int) $value : null;
            })
            ->toArray();


        $view                               = View::make('Dashboards.Symphony.Ane.OpelModal.DataLoadStageSix', compact('safety_thermometer_view'));
        $sections                           = $view->render();
        return                              $sections;
    }

    public function AneOpelStatusModalLoadSeven(Request $request)
    {
        $success_array                      = array();
        $current_date_set_time              = date('Y-m-d 00:00');

        $current_date_set_time_cr           = (int)date('H');
        for ($x = 0; $x <= $current_date_set_time_cr; $x++) {
            $hour_time                      = date('H:i', strtotime($current_date_set_time . "+$x hour"));
            $time_options[$hour_time]       = $hour_time;
        }
        $success_array['set_date_format']          = date('Y-m-d');
        $success_array['set_date']          = date('jS M Y');
        $success_array['set_time']          = date('H:00');
        $success_array['time_options']      = $time_options;
        $view                               = View::make('Dashboards.Symphony.Ane.OpelModal.DataLoadStageSeven', compact('success_array'));
        $sections                           = $view->render();
        return                              $sections;
    }

    public function AneOpelModalSaveEDThermometer(Request $request)
    {

        $final_array = [];


        if ($request->filled('staff_absent') && is_array($request->staff_absent)) {
            foreach ($request->input('staff_absent') as $key => $value) {
                $final_array[$key] = $value;
            }
        }
        if ($request->filled('final_inflow_data') && is_array($request->final_inflow_data)) {
            foreach ($request->input('final_inflow_data') as $key => $value) {
                $final_array[$key] = $value;
            }
        }
        if ($request->filled('final_acuity_data') && is_array($request->final_acuity_data)) {
            foreach ($request->input('final_acuity_data') as $key => $value) {
                $final_array[$key] = $value;
            }
        }
        if ($request->filled('final_outflow_data') && is_array($request->final_outflow_data)) {
            foreach ($request->input('final_outflow_data') as $key => $value) {
                $final_array[$key] = $value;
            }
        }
        if ($request->filled('final_total_data') && is_array($request->final_total_data)) {
            foreach ($request->input('final_total_data') as $key => $value) {
                $final_array[$key] = $value;
            }
        }
        if ($request->filled('ed_thermo_meter_patients') && is_array($request->ed_thermo_meter_patients)) {
            foreach ($request->input('ed_thermo_meter_patients') as $key => $value) {
                $final_array[$key] = $value;
            }
        }
        $other_value = $request->only('ed_thermo_meter_patient_awaiting_bed', 'ed_thermo_meter_patient_in_ed', 'ed_thermo_meter_completed_by', 'current_opel_status', 'current_number_of_breaches', 'four_hour_performance_of_the_day', 'ed_thermometer_notes');
        foreach ($other_value as $key => $value) {
            $final_array[$key] = $value;
        }
        $date = $request->date;
        $time = $request->hour;
        $history_controller = new HistoryController;
        $history_opel_status = "App\Models\History\HistorySymphonyEDThermometer";
        $success_array = array();
        $user_id = Session()->get('LOGGED_USER_ID', '');
        foreach ($final_array as $ed_key => $ed_value) {
            if ($ed_key != "" && $user_id != "") {
                $gov_text_before_arr = SymphonyEDThermometer::where('date', $date)->where('time', $time)->where('ed_key', $ed_key)->first();
                $ed_data = SymphonyEDThermometer::updateOrCreate(['date' => $date, 'time' => $time, 'ed_key' => $ed_key], ['ed_value' => $ed_value, 'updated_by' => $user_id]);
                $history_controller->HistoryTableDataInsertFromUpdateCreate($ed_data, $history_opel_status);
                if ($ed_data->wasRecentlyCreated) {
                    $success_array["message"] = DataAddedMessage();
                    $updated_array = $ed_data->getOriginal();
                    $gov_text_before = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $this->GovernanceIboxDataPreCall($ed_data, $gov_text_before, 1);
                    }
                } else {
                    $success_array["message"]                   = DataUpdatedMessage();
                    if (count($ed_data->getChanges()) > 0) {
                        $updated_array = $ed_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before = $gov_text_before_arr->toArray();
                                $this->GovernanceIboxDataPreCall($ed_data, $gov_text_before, 2);
                            }
                        }
                    }
                }
            }
        }

        $last_ed_key = SymphonyEDThermometer::orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->where('ed_key', 'current_opel_status')
            ->first()->ed_value ?? 0;
        $success_array["opel_status"]            = $last_ed_key;
        $success_array["opel_image"]            = 'opel_' . $last_ed_key;
        return ReturnArrayAsJsonToScript($success_array);
    }
}
