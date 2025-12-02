<?php

namespace App\Http\Controllers\Iboards\Symphony;

use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Governance\GovernanceController;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonSymphonyController;
use App\Http\Controllers\Common\HistoryController;
use App\Models\Iboards\Symphony\Data\SymphonyAttendance;
use App\Models\Iboards\Symphony\View\SymphonyAneAttendanceView;
use App\Models\Iboards\Symphony\View\SymphonyAttendanceView;
use App\Models\Iboards\Symphony\View\SymphonyBreachAttendanceView;
use App\Models\Iboards\Symphony\Data\SymphonyAttendanceCalculatedDailyEDSummary;
use App\Models\Iboards\Symphony\Data\SymphonyBreachReasonUserUpdate;
use App\Models\Iboards\Symphony\Data\AmbulanceArrivalOverMinutes;
use App\Models\Iboards\Symphony\Master\BreachReason;
use App\Models\Common\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;


class BreachValidationController extends Controller
{
    public function Index()
    {
        $common_controller                                  = new CommonController;
        $common_symphony_controller                         = new CommonSymphonyController;

        $process_array                                      = array();
        $success_array                                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);
        $success_array["page_sub_title"] = date('l jS F H:i');
        $process_array["start_date"]                        = CurrentDateOnFormat();
        //        $process_array["start_date"]                        = Carbon::parse('2023-11-27');
        CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "day");
        $this->BreachValidationBreachDataprocess($success_array, $process_array);
        $success_array['date_filter_tab_1_date_to_show']    = PredefinedDateFormatShowOnCalendarDashboard($process_array["start_date"]);
        $success_array["filter_value_selected"]             = PredefinedStandardDateFormatChangeDateAlone($process_array["start_date"]);
        return view('Dashboards.Symphony.BreachValidation.Index', compact('success_array'));
    }

    public function ContentDataLoad(Request $request)
    {
        $common_controller = new CommonController;
        $common_symphony_controller = new CommonSymphonyController;
        $process_array = array();
        $success_array = array();

        $filter_value       = $request->filter_value;
        $tab_filter_mode = $request->tab_filter_mode;
        $success_array["tab_filter_mode"] = $tab_filter_mode;
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);

        if ($tab_filter_mode == 1 || $tab_filter_mode == 2 || $tab_filter_mode == 3 || $tab_filter_mode == 4 || $tab_filter_mode == 5) {
            if ($tab_filter_mode == 1) {
                if (CheckSpecificPermission('breach_reason_view')) {
                    $process_array["start_date"]                        = ($filter_value != "") ? $filter_value : CurrentDateOnFormat();
                    CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "day");
                    $this->BreachValidationBreachDataprocess($success_array, $process_array);
                    $success_array['date_filter_tab_1_date_to_show']    = PredefinedDateFormatShowOnCalendarDashboard($process_array["start_date"]);
                    $success_array["filter_value_selected"]             = PredefinedStandardDateFormatChangeDateAlone($process_array["start_date"]);

                    $view = View::make('Dashboards.Symphony.BreachValidation.IndexDataLoadTabContent1', compact('success_array'));
                    $sections = $view->render();
                    return $sections;
                } else {
                    return PermissionDenied();
                }
            }
            if ($tab_filter_mode == 2) {
                if (CheckSpecificPermission('breach_dashboard_view')) {
                    $process_array["start_date"]                        = ($filter_value != "") ? $filter_value : CurrentDateOnFormat();
                    CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "day");
                    $this->BreachValidationBreachDaySummaryDataprocess($success_array, $process_array, $tab_filter_mode);
                    $success_array = json_decode(file_get_contents('demo_data/ane/breach1.txt'), true);
                    $success_array['date_filter_tab_2_date_to_show']    = PredefinedDateFormatShowOnCalendarDashboard($process_array["start_date"]);
                    $success_array["filter_value_selected"]             = PredefinedStandardDateFormatChangeDateAlone($process_array["start_date"]);

                    $view = View::make('Dashboards.Symphony.BreachValidation.IndexDataLoadTabContent2', compact('success_array'));
                    $sections = $view->render();
                    return $sections;
                } else {
                    return PermissionDenied();
                }
            }

            if ($tab_filter_mode == 3) {
                if (CheckSpecificPermission('breach_monthly_dashboard_view')) {
                    $process_array["start_date"]                        = ($filter_value != "") ? $filter_value : CurrentDateOnFormat();
                    CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "month");
                    $this->BreachValidationBreachDaySummaryDataprocess($success_array, $process_array, $tab_filter_mode);
                    $success_array = json_decode(file_get_contents('demo_data/ane/breach3.txt'), true);
                    $success_array["filter_value_selected"]             = date("Y-m-d", strtotime($process_array["start_date"]));
                    $success_array["month_filter_array"]                = LastNumberOfMonthsArrayForDropdownOperation($process_array["date_time_now"], 12);

                    $view = View::make('Dashboards.Symphony.BreachValidation.IndexDataLoadTabContent3', compact('success_array'));
                    $sections = $view->render();
                    return $sections;
                } else {
                    return PermissionDenied();
                }
            }

            if ($tab_filter_mode == 4) {
                if (CheckSpecificPermission('breach_monthly_report_view')) {
                    $process_array["start_date"]                        = ($filter_value != "") ? $filter_value : CurrentDateOnFormat();
                    CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "month");
                    $this->BreachValidationBreachMonthOverall($success_array, $process_array);
                    $success_array["filter_value_selected"]             = date("Y-m-d", strtotime($process_array["start_date"]));
                    $success_array["month_filter_array"]                = LastNumberOfMonthsArrayForDropdownOperation($process_array["date_time_now"], 12);

                    $view = View::make('Dashboards.Symphony.BreachValidation.IndexDataLoadTabContent5', compact('success_array'));
                    $sections = $view->render();
                    return $sections;
                } else {
                    return PermissionDenied();
                }
            }

            if ($tab_filter_mode == 5) {
                if (CheckSpecificPermission('breach_weekly_dashboard_view')) {
                    $process_array["start_date"]                = ($filter_value != "") ? $filter_value : CurrentDateOnFormat();
                    $success_array["week_filter_array"]         = LastNumberOfWeeksArrayForDropdownOperation($process_array["date_time_now"], 120);
                    CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "week");
                    $this->BreachValidationBreachDaySummaryDataprocess($success_array, $process_array, $tab_filter_mode);
                    $success_array = json_decode(file_get_contents('demo_data/ane/breach2.txt'), true);
                    $success_array["filter_value_selected"]     = date("Y-m-d", strtotime($process_array["start_date"]));
                    $view = View::make('Dashboards.Symphony.BreachValidation.IndexDataLoadTabContent4', compact('success_array'));
                    $sections = $view->render();
                    return $sections;
                } else {
                    return PermissionDenied();
                }
            }
        } else {
            return false;
        }
    }


    public function BreachValidationBreachDataprocess(&$success_array, &$process_array)
    {

        $common_symphony_controller         = new CommonSymphonyController;
        $total_attendance                   = SymphonyBreachAttendanceView::orderBy('symphony_discharge_date', 'ASC')->get()->toArray();

        $total_attendance_breached          = $common_symphony_controller->GetBreachedArrayProcessFrom240Minutes($total_attendance, $process_array);
        $breach_record_array                = array();
        $prev_attendance_number             = "";
        if (count($total_attendance_breached) > 0) {
            $x = 0;
            foreach ($total_attendance_breached as $row) {
                $breach_record_array[$x]["attendance_id"]                       = ValuePresentThenSetForVariable($row, "symphony_attendance_id", 0);
                $breach_record_array[$x]["pas_number"]                          = ValuePresentThenSetForVariable($row, "symphony_pas_number", 0);
                $breach_record_array[$x]["patient_sex"]                          = ValuePresentThenSetForVariable($row, "symphony_patient_sex", 0);
                $breach_record_array[$x]["patient_name"]                        = ucwords(strtolower(ValuePresentThenSetForVariable($row, "symphony_patient_name", 0)));
                $breach_record_array[$x]["attendance_type"]                     = ValuePresentThenSetForVariable($row, "symphony_atd_type", 0);
                $breach_record_array[$x]["attendance_number"]                   = ValuePresentThenSetForVariable($row, "symphony_attendance_number", 0);
                $breach_record_array[$x]["registration_date"]                   = ValuePresentThenSetForVariable($row, "symphony_registration_date_time", 1);
                $breach_record_array[$x]["triage_date"]                         = ValuePresentThenSetForVariable($row, "symphony_triage_date", 1);
                $breach_record_array[$x]["consultant_seen_time"]                =  ValuePresentThenSetForVariable($row, "symphony_seen_date", 1);
                $breach_record_array[$x]["left_department"]                     = ValuePresentThenSetForVariable($row, "symphony_discharge_date", 1);
                $breach_record_array[$x]["minutes_in_department"]               = ValuePresentThenSetForVariable($row, "symphony_registration_date_time", 3, "symphony_discharge_date");
                $breach_record_array[$x]["first_location"]                      = ValuePresentThenSetForVariable($row, "symphony_first_location", 0);
                $breach_record_array[$x]["discharge_outcome"]                   = ValuePresentThenSetForVariable($row, "symphony_discharge_outcome", 0);
                $breach_record_array[$x]["processing_complaint"]                = ValuePresentThenSetForVariable($row, "symphony_processing_complaint", 0);
                $breach_record_array[$x]["breach_reason_update_id"]             = ValuePresentThenSetForVariable($row, "breach_reason_update_id", 0);
                $breach_record_array[$x]["breach_reason_name"]                  = ValuePresentThenSetForVariable($row, "breach_reason_name", 0);
                $breach_record_array[$x]["breach_reason_updated_at"]            = ValuePresentThenSetForVariable($row, "breach_reason_updated_at", 1);
                $breach_record_array[$x]["prev_attendance_number"]              = $prev_attendance_number;
                $breach_record_array[$x]["breach_reason_updated_user_id"]       = ValuePresentThenSetForVariable($row, "breach_reason_updated_user_id", 0);
                $breach_record_array[$x]["breach_reason_updated_user_name"]     = ValuePresentThenSetForVariable($row, "breach_reason_updated_user_name", 0);
                $prev_attendance_number                                         = ValuePresentThenSetForVariable($row, "symphony_attendance_id", 0);
                $x++;
            }
        }
        if (count($breach_record_array) > 0) {
            $x = 0;
            foreach ($breach_record_array as $row) {
                $breach_record_array[$x]["next_attendance_number"]              = "";
                if (isset($breach_record_array[$x + 1]["attendance_id"])) {
                    $breach_record_array[$x]["next_attendance_number"]          = $breach_record_array[$x + 1]["attendance_id"];
                }
                $x++;
            }
        }
        $success_array["page_sub_title"]                = date('l jS F H:i');
        $success_array["breach_record_array"]                  = $breach_record_array;
    }


    public function BreachContentDataLoad(Request $request)
    {


        if (CheckSpecificPermission('add_breach_reason_popup_view')) {
            $common_controller                      = new CommonController;
            $common_symphony_controller             = new CommonSymphonyController;
            $process_array                          = array();
            $success_array                          = array();
            $attendace_id                           = $request->attendace_id ?? '';

            $common_controller->SetDefaultConstantsValue($process_array, $success_array);
            $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);
            $success_array['breach_reason']         = BreachReason::where("status", '=', 1)->orderBy('reason_name', 'ASC')->pluck('reason_name', 'id')->toArray();
            if ($attendace_id != "") {
                $breach_data_processed              = SymphonyAttendanceView::where('symphony_attendance_id', $attendace_id)->first()->toArray();
                if (count($breach_data_processed) > 0) {
                    $breach_record_array["attendance_id"]                                   = ValuePresentThenSetForVariable($breach_data_processed, "symphony_attendance_id", 0);
                    $breach_record_array["pas_number"]                                      = ValuePresentThenSetForVariable($breach_data_processed, "symphony_pas_number", 0);
                    $breach_record_array["patient_name"]                                    = ucwords(strtolower(ValuePresentThenSetForVariable($breach_data_processed, "symphony_patient_name", 0)));
                    $breach_record_array["attendence_type"]                                 = ValuePresentThenSetForVariable($breach_data_processed, "symphony_atd_type", 0);
                    $breach_record_array["registration_date"]                               = ValuePresentThenSetForVariable($breach_data_processed, "symphony_registration_date_time", 1);
                    $breach_record_array["arrival_mode"]                                    = ValuePresentThenSetForVariable($breach_data_processed, "symphony_arrival_mode", 0);
                    $breach_record_array["first_location"]                                  = ValuePresentThenSetForVariable($breach_data_processed, "symphony_first_location", 0);
                    $breach_record_array["triage_date_time"]                                = ValuePresentThenSetForVariable($breach_data_processed, "symphony_triage_date", 1);
                    $breach_record_array["time_from_reg_to_triage"]                         = ValuePresentThenSetForVariable($breach_data_processed, "symphony_registration_date_time", 2, "symphony_triage_date");
                    $breach_record_array["triage_category"]                                 = ValuePresentThenSetForVariable($breach_data_processed, "symphony_triage_category", 0);
                    $breach_record_array["time_from_reg_to_ed_doctor"]                      = ValuePresentThenSetForVariable($breach_data_processed, "symphony_registration_date_time", 2, "symphony_seen_date");
                    $breach_record_array["time_from_reg_to_ed_doctor_right"]                = $common_controller->ValuePresentThenSetForVariableCheckLarger($breach_record_array["time_from_reg_to_ed_doctor"], 60, "");
                    $breach_record_array["time_from_reg_to_ed_doctor_colour"]               = $common_controller->ValuePresentThenSetForVariableCheckColour($breach_record_array["time_from_reg_to_ed_doctor"], 60);
                    $breach_record_array["seen_by_ed_doctor"]                               = ValuePresentThenSetForVariable($breach_data_processed, "symphony_seen_by", 0);
                    $breach_record_array["seen_by_ed_doctor_date"]                          = ValuePresentThenSetForVariable($breach_data_processed, "symphony_seen_date", 1);
                    $breach_record_array["time_from_reg_to_referal"]                        = ValuePresentThenSetForVariable($breach_data_processed, "symphony_registration_date_time", 2, "symphony_refferal_date");
                    $breach_record_array["time_from_reg_to_referal_right"]                  = $common_controller->ValuePresentThenSetForVariableCheckLarger($breach_record_array["time_from_reg_to_referal"], 90, "");
                    $breach_record_array["time_from_reg_to_referal_colour"]                 = $common_controller->ValuePresentThenSetForVariableCheckColour($breach_record_array["time_from_reg_to_referal"], 90);
                    $breach_record_array["referal_date_time"]                               = ValuePresentThenSetForVariable($breach_data_processed, "symphony_refferal_date", 1);
                    $breach_record_array["time_from_referral_to_speciality_doctor"]         = ValuePresentThenSetForVariable($breach_data_processed, "symphony_refferal_date", 2, "symphony_seen_ae_date");
                    $breach_record_array["time_from_referral_to_speciality_doctor_right"]   = $common_controller->ValuePresentThenSetForVariableCheckLarger($breach_record_array["time_from_referral_to_speciality_doctor"], 30, "");
                    $breach_record_array["time_from_referral_to_speciality_doctor_colour"]  = $common_controller->ValuePresentThenSetForVariableCheckColour($breach_record_array["time_from_referral_to_speciality_doctor"], 30);
                    $breach_record_array["speciality_doctor_seen_date_time"]                = ValuePresentThenSetForVariable($breach_data_processed, "symphony_seen_ae_date", 1);
                    $breach_record_array["speciality_doctor_description"]                   = ValuePresentThenSetForVariable($breach_data_processed, "symphony_seen_ae_by", 0);
                    $breach_record_array["dta_speciality"]                                  = ValuePresentThenSetForVariable($breach_data_processed, "symphony_request_value", 0);
                    $breach_record_array["time_from_dta_to_admitted"]                       = ValuePresentThenSetForVariable($breach_data_processed, "symphony_request_date", 2, "symphony_discharge_date");
                    $breach_record_array["dta_date_time"]                                   = ValuePresentThenSetForVariable($breach_data_processed, "symphony_request_date", 1);
                    $breach_record_array["discharge_outcome"]                               = ucwords(strtolower(ValuePresentThenSetForVariable($breach_data_processed, "symphony_discharge_outcome", 0)));
                    $breach_record_array["time_in_department_over_four_hour"]               = ValuePresentThenSetForVariable($breach_data_processed, "symphony_registration_date_time", 3, "symphony_discharge_date");
                    $breach_record_array["time_in_department_over_four_hour"]               = $common_controller->ValuePresentThenSetForVariableCheckLarger($breach_record_array["time_in_department_over_four_hour"], $process_array['ed_breach_time_in_minutes'], 0);
                    $breach_record_array["time_in_department_over_four_hour_colour"]        = $common_controller->ValuePresentThenSetForVariableCheckColour($breach_record_array["time_in_department_over_four_hour"], 0);
                    $breach_record_array["departure_date"]                                  = ValuePresentThenSetForVariable($breach_data_processed, "symphony_discharge_date", 1);
                    $breach_record_array["time_in_department"]                              = ValuePresentThenSetForVariable($breach_data_processed, "symphony_registration_date_time", 3, "symphony_discharge_date");
                    $breach_record_array["ward"]                                            = ValuePresentThenSetForVariable($breach_data_processed, "symphony_discharge_ward", 0);
                    $breach_record_array["speciality"]                                      = ucwords(strtolower(ValuePresentThenSetForVariable($breach_data_processed, "symphony_specialty", 0)));
                    $breach_record_array["final_location"]                                  = ucwords(strtolower(ValuePresentThenSetForVariable($breach_data_processed, "symphony_final_location", 0)));

                    $breach_record_array["patients_ed_department"]                          = ValuePresentThenSetForVariable($breach_data_processed, "symphony_breach_count", 0);
                    $breach_record_array["patients_ed_department_right"]                    = $common_controller->ValuePresentThenSetForVariableCheckLarger($breach_record_array["patients_ed_department"], 45, "");
                    $breach_record_array["patients_ed_department_colour"]                   = $common_controller->ValuePresentThenSetForVariableCheckColour($breach_record_array["patients_ed_department"], 45);

                    $breach_record_array["patients_in_department"]                          = ValuePresentThenSetForVariable($breach_data_processed, "symphony_speciality_count", 0);
                    $breach_record_array["patients_in_department_right"]                    = $common_controller->ValuePresentThenSetForVariableCheckLarger($breach_record_array["patients_in_department"], 10, "");
                    $breach_record_array["patients_in_department_colour"]                   = $common_controller->ValuePresentThenSetForVariableCheckColour($breach_record_array["patients_in_department"], 10);
                    $breach_record_array["processing_complaint"]                            = ValuePresentThenSetForVariable($breach_data_processed, "symphony_processing_complaint", 0);
                    $breach_record_array["breach_reason_id"]                                = ValuePresentThenSetForVariable($breach_data_processed, "breach_reason_update_id", 0);
                    $breach_record_array["breach_reason_name"]                              = ValuePresentThenSetForVariable($breach_data_processed, "breach_reason_name", 0);
                    $breach_record_array["breach_reason_updated_user_id"]                   = ValuePresentThenSetForVariable($breach_data_processed, "breach_reason_updated_user_id", 0);
                    $breach_record_array["breach_reason_updated_user_name"]                 = ValuePresentThenSetForVariable($breach_data_processed, "breach_reason_updated_user_name", 0);
                    $breach_record_array["breach_reason_updated_at"]                        = ValuePresentThenSetForVariable($breach_data_processed, "breach_reason_updated_at", 1);

                    $breach_record_array["patients_waiting_bed"]                            = ValuePresentThenSetForVariable($breach_data_processed, "symphony_dta_count", 0);
                    $breach_record_array["patients_waiting_bed_right"]                    = $common_controller->ValuePresentThenSetForVariableCheckLarger($breach_record_array["patients_waiting_bed"], 6, "");
                    $breach_record_array["patients_waiting_bed_colour"]                   = $common_controller->ValuePresentThenSetForVariableCheckColour($breach_record_array["patients_waiting_bed"], 6);


                    $breach_record_array["time_from_reg_to_triage_colour"]                  = "";
                    if (intval($breach_record_array["time_in_department_over_four_hour"]) > 0 && $breach_record_array["dta_speciality"] != "" && strtolower($breach_record_array["discharge_outcome"]) != "discharge to home") {
                        $breach_record_array["time_in_department_over_four_hour_colour"] = "breach-popup-colour-b19cd9";
                    } else {
                        if ($breach_record_array["patients_ed_department_right"] != "" || $breach_record_array["patients_in_department_right"]  != "") {
                            if ($breach_record_array["patients_ed_department_right"] != "") {
                                $breach_record_array["patients_ed_department_colour"]               = "breach-popup-colour-b19cd9";
                            }
                            if ($breach_record_array["patients_in_department_right"] != "") {
                                $breach_record_array["patients_in_department_colour"]               = "breach-popup-colour-b19cd9";
                            }
                            if ($breach_record_array["time_from_reg_to_ed_doctor_right"] != "") {
                                $breach_record_array["time_from_reg_to_ed_doctor_colour"]           = "breach-popup-colour-b19cd9";
                            }
                        } else {
                            $top_val_range                          = "";
                            $top_val_range_index                    = "";
                            $time_to_triage_modal_val_check         = intval($breach_record_array["time_from_reg_to_triage"]) - 15;
                            $time_to_doctor_modal_val_check         = intval($breach_record_array["time_from_reg_to_ed_doctor"]) - 60;
                            $time_to_referral_modal_val_check       = intval($breach_record_array["time_from_reg_to_referal"]) - 90;
                            if ($time_to_triage_modal_val_check > 0 || $time_to_doctor_modal_val_check > 0 || $time_to_referral_modal_val_check > 0) {
                                $top_val_range                      = $time_to_triage_modal_val_check;
                                $top_val_range_index                = "Triage";
                                if ($time_to_doctor_modal_val_check > $top_val_range) {
                                    $top_val_range                  = $time_to_doctor_modal_val_check;
                                    $top_val_range_index            = "Assessment";
                                }
                                if ($time_to_referral_modal_val_check > $top_val_range) {
                                    $top_val_range                  = $time_to_referral_modal_val_check;
                                    $top_val_range_index            = "Late";
                                }
                                if ($top_val_range_index == "Late") {
                                    $breach_record_array["time_from_reg_to_referal_colour"]             = "breach-popup-colour-b19cd9";
                                }
                                if ($top_val_range_index == "Assessment") {
                                    $breach_record_array["time_from_reg_to_ed_doctor_colour"]           = "breach-popup-colour-b19cd9";
                                }
                                if ($top_val_range_index == "Triage") {
                                    $breach_record_array["time_from_reg_to_triage_colour"]              = "breach-popup-colour-b19cd9";
                                }
                            }
                        }
                    }
                }
                $success_array["breach_record_array"]                                   = $breach_record_array;
            }
            $view = View::make('Dashboards.Symphony.BreachValidation.ModalBreachReasonModalPopupContent', compact('success_array'));
            $sections = $view->render();
            return $sections;
        } else {
            return PermissionDenied();
        }
    }


    public function BreachReasonDataStore(Request $request)
    {
        if (CheckSpecificPermission('add_breach_reason_popup_update')) {
            $history_controller                                         = new HistoryController;
            $history_opel_status                                        = "App\Models\History\HistorySymphonyBreachReasonUserUpdate";
            $date_time_now                                              = CurrentDateOnFormat();
            $attendace_id                                               = $request->attendace_id;
            $breach_reason_id                                           = $request->breach_reason_update_id_to_store_field;
            $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
            $user_name                                                  = Session()->get('LOGGED_USER_NAME', '');
            $success_array["message"]                                   = ErrorOccuredMessage();
            $success_array["status"]                                    = 0;
            if ($breach_reason_id != "" && $user_id != "" && $attendace_id != "") {
                $gov_text_before_arr                                    = SymphonyBreachReasonUserUpdate::where('attendance_number', '=', $attendace_id)->first();
                $breach_reason_data                                     = SymphonyBreachReasonUserUpdate::updateOrCreate(['attendance_number' => $attendace_id], ['breach_reason_update_id' => $breach_reason_id, 'breach_reason_updated_user' => $user_id]);
                $history_controller->HistoryTableDataInsertFromUpdateCreate($breach_reason_data, $history_opel_status);
                $breach_data_stored_return                              = BreachReason::where('id', '=', $breach_reason_id)->first();

                if ($breach_reason_data->wasRecentlyCreated) {
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $breach_reason_data->getOriginal();
                    $gov_text_before                                    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $this->GovernanceBreachReasonUpdatePreCall($attendace_id, $updated_array["id"], $gov_text_before, $breach_data_stored_return->reason_name, 1);
                    }
                } else {
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($breach_reason_data->getChanges()) > 0) {
                        $updated_array                                  = $breach_reason_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $this->GovernanceBreachReasonUpdatePreCall($attendace_id, $updated_array["id"], $gov_text_before, $breach_data_stored_return->reason_name, 2);
                            }
                        }
                    }
                }
                $success_array["reason_name"]                           = $breach_data_stored_return->reason_name;
                $success_array["reason_id"]                             = $breach_data_stored_return->id;
                $success_array["user_id"]                               = $user_id;
                $success_array["user_name"]                             = $user_name;
                $success_array["status"]                                = 1;
                $success_array["show_message"]                          = $breach_data_stored_return->reason_name . '<br>' . $user_name . ' (' . PredefinedDateFormatChange($date_time_now) . ')';
            }
            return ReturnArrayAsJsonToScript($success_array);
        } else {
            return PermissionDenied();
        }
    }



    public function GovernanceBreachReasonUpdatePreCall($attendance_id, $id, $gov_text_before, $gov_desc, $operation)
    {
        $gov_data                                   = array();
        $gov_text_after_arr                         = SymphonyBreachReasonUserUpdate::where('id', '=', $id)->first();
        $functional_identity                        = RetriveSpecificConstantSettingValues("ibox_frontend_governance_symphony_ane_breach_reason", "ibox_governance_frontend_functional_names");
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
                $gov_data["gov_description"] = $gov_desc;
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
                $gov_data["gov_description"] = $gov_desc;
            }
        }
        if ($operation == 3) {
            if (isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"] = json_encode($gov_text_before);
                $gov_data["gov_text_after"] = "";
                $gov_data["gov_attendance_id"] = $attendance_id;
                $gov_data["gov_updation_status"] = $operation;
                $gov_data["gov_func_identity"] = $functional_identity;
                $gov_data["gov_description"] = $gov_desc;
            }
        }
        if (!empty($gov_data)) {
            if (count($gov_data) > 0) {
                $governance = new GovernanceController;
                $governance->GovernanceStoreSymphonyData($gov_data);
            }
        }
    }

    public function CalculatedEDSummaryAttendance($start_date, $end_date)
    {
        $common_controller              = new CommonController;
        $return_data_array              = SymphonyAttendanceCalculatedDailyEDSummary::whereBetween('ed_summary_date', array($start_date, $end_date))->orderBy('ed_summary_date', 'DESC')->get()->toArray();
        $return_data_array_ser          = $common_controller->SeriliseDataArrayToBeProcessed($return_data_array, 'ed_summary_date');
        return $return_data_array_ser;
    }
    public function CalculatedEDSummaryColumnSum($data_process, $index_name)
    {
        $return_val                     = 0;
        if (count($data_process) > 0) {
            $return_val                 = array_sum(array_column($data_process, $index_name));
        }
        return $return_val;
    }
    public function EDSummaryHistoryDataCalculationDetails(&$success_array, $process_array)
    {
        $common_controller              = new CommonController;
        $process_array["week_start_date_right"]                 = $process_array["start_date"];
        CalculateStartEndDateAccordingSelection($process_array["week_start_date_right"], $process_array["week_end_date_right"], "week");
        $attendence_data_processed_for_previous                 = $this->CalculatedEDSummaryAttendance($process_array["week_start_date_right"], $process_array["week_end_date_right"]);
        $week_attendance_total                                  = $this->CalculatedEDSummaryColumnSum($attendence_data_processed_for_previous, 'symphony_attendance');
        $week_breach_total                                      = $this->CalculatedEDSummaryColumnSum($attendence_data_processed_for_previous, 'symphony_breached');
        $week_discharge_total                                   = $this->CalculatedEDSummaryColumnSum($attendence_data_processed_for_previous, 'symphony_discharged');

        $process_array["month_start_date_right"]                = $process_array["start_date"];
        CalculateStartEndDateAccordingSelection($process_array["month_start_date_right"], $process_array["month_end_date_right"], "month");
        $attendence_data_processed_for_previous                 = $this->CalculatedEDSummaryAttendance($process_array["month_start_date_right"], $process_array["month_end_date_right"]);
        $month_attendance_total                                 = $this->CalculatedEDSummaryColumnSum($attendence_data_processed_for_previous, 'symphony_attendance');
        $month_breach_total                                     = $this->CalculatedEDSummaryColumnSum($attendence_data_processed_for_previous, 'symphony_breached');
        $month_discharge_total                                  = $this->CalculatedEDSummaryColumnSum($attendence_data_processed_for_previous, 'symphony_discharged');

        $process_array["current_quater_start_date"]             = $common_controller->CalculateQuaterFromMonthFinancialYearStartDate(date("Y-m-d", strtotime($process_array["start_date"])));
        $process_array["current_quater_end_date"]               = date("Y-m-t", strtotime($process_array["current_quater_start_date"] . " +2 month"));
        $attendence_data_processed_for_previous                 = $this->CalculatedEDSummaryAttendance($process_array["current_quater_start_date"], $process_array["current_quater_end_date"]);
        $quater_attendance_total                                = $this->CalculatedEDSummaryColumnSum($attendence_data_processed_for_previous, 'symphony_attendance');
        $quater_breach_total                                    = $this->CalculatedEDSummaryColumnSum($attendence_data_processed_for_previous, 'symphony_breached');
        $quater_discharge_total                                 = $this->CalculatedEDSummaryColumnSum($attendence_data_processed_for_previous, 'symphony_discharged');

        $process_array["current_financial_start_date"]          = $common_controller->CalculateFinancialFromMonthFinancialYearStartDate(date("Y-m-d", strtotime($process_array["start_date"])));
        $process_array["current_financial_end_date"]            = date("Y-03-t", strtotime($process_array["current_financial_start_date"] . " +1 year"));
        $attendence_data_processed_for_previous                 = $this->CalculatedEDSummaryAttendance($process_array["current_financial_start_date"], $process_array["current_financial_end_date"]);
        $year_attendance_total                                  = $this->CalculatedEDSummaryColumnSum($attendence_data_processed_for_previous, 'symphony_attendance');
        $year_breach_total                                      = $this->CalculatedEDSummaryColumnSum($attendence_data_processed_for_previous, 'symphony_breached');
        $year_discharge_total                                   = $this->CalculatedEDSummaryColumnSum($attendence_data_processed_for_previous, 'symphony_discharged');

        $ed_attendance_summary_show                             = array();
        $ed_attendance_summary_show[0]["name"]                  = "";
        $ed_attendance_summary_show[0]["week"]                  = "Week";
        $ed_attendance_summary_show[0]["month"]                 = date("M", strtotime($process_array["month_start_date_right"]));;
        $ed_attendance_summary_show[0]["quater"]                = $common_controller->CalculateQuaterFromMonthFinancialYear(date("m", strtotime($process_array["current_quater_start_date"])));
        $ed_attendance_summary_show[0]["year"]                  = date("y", strtotime($process_array["current_financial_start_date"])) . "/" . date("y", strtotime($process_array["current_financial_end_date"]));

        $ed_attendance_summary_show[1]["name"]                  = "Performance";
        $ed_attendance_summary_show[1]["week"]                  = "100";
        $ed_attendance_summary_show[1]["month"]                 = "100";
        $ed_attendance_summary_show[1]["quater"]                = "100";
        $ed_attendance_summary_show[1]["year"]                  = "100";

        $ed_attendance_summary_show[2]["name"]                  = "Breaches";
        $ed_attendance_summary_show[2]["week"]                  = $week_breach_total;
        $ed_attendance_summary_show[2]["month"]                 = $month_breach_total;
        $ed_attendance_summary_show[2]["quater"]                = $quater_breach_total;
        $ed_attendance_summary_show[2]["year"]                  = $year_breach_total;

        $ed_attendance_summary_show[3]["name"]                  = "Attendance";
        $ed_attendance_summary_show[3]["week"]                  = $week_attendance_total;
        $ed_attendance_summary_show[3]["month"]                 = $month_attendance_total;
        $ed_attendance_summary_show[3]["quater"]                = $quater_attendance_total;
        $ed_attendance_summary_show[3]["year"]                  = $year_attendance_total;

        $ed_attendance_summary_show[4]["name"]                  = "Discharges";
        $ed_attendance_summary_show[4]["week"]                  = $week_discharge_total;
        $ed_attendance_summary_show[4]["month"]                 = $month_discharge_total;
        $ed_attendance_summary_show[4]["quater"]                = $quater_discharge_total;
        $ed_attendance_summary_show[4]["year"]                  = $year_discharge_total;

        $ed_attendance_summary_show[1]["week"]                  = PerformanceCalculationAne($week_breach_total, $week_discharge_total, 0);
        $ed_attendance_summary_show[1]["month"]                 = PerformanceCalculationAne($month_breach_total, $month_discharge_total, 0);
        $ed_attendance_summary_show[1]["quater"]                = PerformanceCalculationAne($quater_breach_total, $quater_discharge_total, 0);
        $ed_attendance_summary_show[1]["year"]                  = PerformanceCalculationAne($year_breach_total, $year_discharge_total, 0);


        $ed_attendance_summary_show[5]["week"]                  = $this->PerformancePercentageTablebackgroundCalculation($ed_attendance_summary_show[1]["week"]);
        $ed_attendance_summary_show[5]["month"]                  = $this->PerformancePercentageTablebackgroundCalculation($ed_attendance_summary_show[1]["month"]);
        $ed_attendance_summary_show[5]["quater"]                  = $this->PerformancePercentageTablebackgroundCalculation($ed_attendance_summary_show[1]["quater"]);
        $ed_attendance_summary_show[5]["year"]                  = $this->PerformancePercentageTablebackgroundCalculation($ed_attendance_summary_show[1]["year"]);





        $success_array["ed_attendance_summary_show"]            = $ed_attendance_summary_show;
    }

    public function PerformancePercentageTablebackgroundCalculation($percentage)
    {
        $return_class = '';
        if ($percentage > 95) {
            $return_class = 'high';
        } else if ($percentage > 90) {
            $return_class = 'mid';
        } else if ($percentage > 80) {
            $return_class = 'avg';
        } else {
            $return_class = 'low';
        }

        return $return_class;
    }


    public function BreachValidationBreachDaySummaryDataprocess(&$success_array, &$process_array, $tab_filter_mode)
    {
        $common_symphony_controller                                                 = new CommonSymphonyController;
        $common_controller                                                          = new CommonController;
        $todays_attendence_all_category                                             = SymphonyAttendanceView::whereBetween('symphony_discharge_date', array($process_array["start_date"], $process_array["end_date"]))->orderBy('symphony_discharge_date', 'ASC')->get()->toArray();
        $todays_discharged_all_category                                             = SymphonyAttendanceView::whereBetween('symphony_discharge_date', array($process_array["start_date"], $process_array["end_date"]))->orderBy('symphony_discharge_date', 'ASC')->get()->toArray();

        $daily_key_value_data = SymphonyAttendanceCalculatedDailyEDSummary::where('ed_summary_key_value', 'LIKE', '%_speciality_%')->select('ed_summary_key_value', DB::raw('SUM(ed_summary_value) as total'))
            ->whereBetween('ed_summary_date', [Carbon::parse($process_array["start_date"])->toDateString(), Carbon::parse($process_array["end_date"])->toDateString()])
            ->groupBy('ed_summary_key_value')
            ->pluck('total', 'ed_summary_key_value')
            ->toArray();

        $speciality_name = ['ed' => 'ED', 'medicine' => 'Medicine', 'surgery' => 'Surgery', 'gynecology' => 'Gynecology', 'paediatrics' => 'Paediatrics', 'amhat' => 'AMHAT', 'trauma & orthopaedics' => 'Trauma & Orthopaedics'];


        $performance_by_speciality = [];


        $process_array['todays_attendence_all_category']                            = $todays_attendence_all_category;
        $process_array['todays_discharged_all_category']                            = $todays_discharged_all_category;
        $common_symphony_controller->GetAnePatientCategorySplitUpArrayWithAtdTypes($todays_attendence_all_category, $process_array);
        $todays_attendence_main_category                                            = $process_array['attendance_arr']['attendance_main'];

        $attendence_category                                                        = $common_controller->IndexCategoryFindSumDetailsProcessArray($todays_attendence_all_category, 'symphony_atd_type');

        $attendence_category_hour                                                   = $common_symphony_controller->countCasesByHourAndSpecialty($todays_attendence_all_category);


        $attendence_all_category_wise                                               = array();
        $replace_name                                                               = $common_symphony_controller->GetAneMainPatientCategoryReplace("ED", $process_array);
        $attendence_all_category_wise["ED"]["attendence_count"]                     = 0;
        $attendence_all_category_wise["ED"]["name_show_text"]                       = $replace_name;
        $replace_name                                                               = $common_symphony_controller->GetAneMainPatientCategoryReplace("UTC", $process_array);
        $attendence_all_category_wise["UTC"]["attendence_count"]                    = 0;
        $attendence_all_category_wise["UTC"]["name_show_text"]                      = $replace_name;
        if (!empty($attendence_category)) {
            foreach ($attendence_category as $key => $row) {

                $attendence_all_category_wise[$key]["attendence_count"]             = $row;
                $replace_name                                                       = $common_symphony_controller->GetAneMainPatientCategoryReplace($key, $process_array);
                $attendence_all_category_wise[$key]["name_show_text"]               = $replace_name;
            }
        }
        $success_array["all_attendence"]                                            = $attendence_all_category_wise;
        $success_array["all_attendence_hour"]                                       = $attendence_category_hour;


        $main_cat_admitted_discharged_breached                                      = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($todays_attendence_main_category, $process_array);
        $discharged_all_admitted_discharged_breached                                = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($process_array['todays_discharged_all_category'], $process_array);
        $attendence_category_breach_reason_index                                    = $common_controller->ArrayColumnCategoryWiseGrouping($discharged_all_admitted_discharged_breached['breached_patients'], 'breach_reason_name');
        $breach_reason_count_array                                                  = array();
        if (!empty($attendence_category_breach_reason_index)) {
            $x                                                                      = 0;
            foreach ($attendence_category_breach_reason_index as $key => $data) {
                $breach_reason_count_array[$x]["breach_name"]                       = $key;
                $breach_reason_count_array[$x]["admitted_count"]                    = 0;
                $breach_reason_count_array[$x]["discharged_count"]                  = 0;
                $breach_reason_count_array[$x]["breach_count"]                      = count($data);
                $breach_reason_count_array[$x]["total_count"]                       = count($data);

                if (!empty($data)) {
                    foreach ($data as $row) {
                        if (isset($row["symphony_discharge_date"])) {
                            if ($row["symphony_discharge_date"] != null) {
                                if (isset($row["symphony_discharge_outcome_val"])) {
                                    if ($row["symphony_discharge_outcome_val"] == 0) {
                                        $breach_reason_count_array[$x]["discharged_count"]++;
                                    }
                                    if ($row["symphony_discharge_outcome_val"] == 1) {
                                        $breach_reason_count_array[$x]["admitted_count"]++;
                                    }
                                }
                            }
                        }
                    }
                }
                $x++;
            }
        }
        if (count($breach_reason_count_array) > 1) {
            MultiArraySortCustom($breach_reason_count_array, "breach_count", "desc");
        }
        $success_array["breach_reason"]                                             = $breach_reason_count_array;

        if ($tab_filter_mode == 2) {
            $process_array["past_seven_days_date_start"]                    = $process_array["start_date"];
            CalculateStartEndDateAccordingSelection($process_array["past_seven_days_date_start"], $process_array["past_seven_days_date_end"], "last seven");
            $attendence_past_7_days_processed                               = $this->CalculatedEDSummaryAttendance($process_array["past_seven_days_date_start"], $process_array["past_seven_days_date_end"]);
            $attendence_days_7_arr                                          = array();
            $breach_days_7_arr                                              = array();
            $past_seven_days                                                = array();

            for ($x = 0; $x < 7; $x++) {
                $date_day_index_format                                      = date("Y-m-d", strtotime($process_array["past_seven_days_date_end"]));
                $date_day_index                                             = date("jS M Y", strtotime($date_day_index_format . " - $x days"));
                $date_day_index_array                                       = date("Y-m-d", strtotime($date_day_index_format . " - $x days"));
                $past_seven_days[$date_day_index_array]["date_val"]         = $date_day_index;
                $past_seven_days[$date_day_index_array]["date_val_org"]     = $date_day_index_array;
                $past_seven_days[$date_day_index_array]["type_1_2_3"]       = 0;
                $past_seven_days[$date_day_index_array]["discharges"]       = 0;
                $past_seven_days[$date_day_index_array]["breaches"]         = 0;
                $past_seven_days[$date_day_index_array]["performance"]      = 100;
                $attendence_days_7_arr[$date_day_index_array]               = array();
                $breach_days_7_arr[$date_day_index_array]                   = array();
            }

            if (count($attendence_past_7_days_processed) > 0) {
                foreach ($attendence_past_7_days_processed as $row) {
                    if (isset($past_seven_days[$row['ed_summary_date']])) {
                        if (isset($row['symphony_attendance']) && $row['symphony_attendance'] != '' && $row['symphony_attendance'] != 0) {
                            $past_seven_days[$row['ed_summary_date']]["type_1_2_3"]         = $row['symphony_attendance'];
                            $past_seven_days[$row['ed_summary_date']]["discharged"]         = $row['symphony_discharged'];
                            $past_seven_days[$row['ed_summary_date']]["breaches"]           = $row['symphony_breached'];
                            $past_seven_days[$row['ed_summary_date']]["left_ed"]            = $row['symphony_discharged'];
                            $past_seven_days[$row['ed_summary_date']]["performance"]        = PerformanceCalculationAne($row['symphony_breached'], $row['symphony_attendance'], 0);
                        }
                    }
                }
            }
            $success_array["past_seven_days"]                       = $past_seven_days;
        } elseif ($tab_filter_mode == 5) {
            $past_7_weeks_date_filter_start                                 = date("Y-m-d 00:00:00", strtotime($process_array["start_date"] . " -49 days"));
            $past_7_weeks_date_filter_end                                   = date("Y-m-d 23:59:59", strtotime($past_7_weeks_date_filter_start . " +48 days"));
            $attendence_past_7_weeks_processed                              = $this->CalculatedEDSummaryAttendance($past_7_weeks_date_filter_start, $past_7_weeks_date_filter_end);

            $attendence_weeks_7_arr                                         = array();
            $breach_weeks_7_arr                                             = array();
            $past_seven_weeks                                               = array();

            for ($x = 0; $x < 7; $x++) {
                $days_mul                                                   = $x * 7;
                $date_week_index_format                                     = date("Y-m-d", strtotime($past_7_weeks_date_filter_end . ' monday this week'));
                $date_week_index                                            = date("jS M", strtotime($date_week_index_format . " - $days_mul days"));
                $date_week_index_array                                      = date("Y-m-d", strtotime($date_week_index_format . " - $days_mul days"));

                $date_week_end                                              = date("jS M", strtotime($date_week_index_array  . ' sunday this week'));
                $past_seven_weeks[$x]["date_val"]                           = $date_week_index . ' To ' . $date_week_end;
                $past_seven_weeks[$x]["date_val_org"]                       = $date_week_index_array;
                $past_seven_weeks[$x]["type_1_2_3"]                         = 0;
                $past_seven_weeks[$x]["discharges"]                         = 0;
                $past_seven_weeks[$x]["breaches"]                           = 0;
                $past_seven_weeks[$x]["performance"]                        = 100;
                $attendence_weeks_7_arr[$date_week_index_array]            = array();
                $breach_weeks_7_arr[$date_week_index_array]                = array();
            }

            if (!empty($attendence_past_7_weeks_processed)) {
                foreach ($attendence_past_7_weeks_processed as $row) {
                    $date_format_for_index                                  = date("Y-m-d", strtotime($row["ed_summary_date"] . ' monday this week'));
                    $attendence_weeks_7_arr[$date_format_for_index][]       = $row;
                }
            }

            foreach ($past_seven_weeks as $key => $row) {
                if (isset($attendence_weeks_7_arr[$row["date_val_org"]])) {
                    if (is_array($attendence_weeks_7_arr[$row["date_val_org"]])) {
                        $past_seven_weeks[$key]["type_1_2_3"]               = array_sum(array_column($attendence_weeks_7_arr[$row["date_val_org"]], 'symphony_attendance'));
                        $past_seven_weeks[$key]["breaches"]                 = array_sum(array_column($attendence_weeks_7_arr[$row["date_val_org"]], 'symphony_breached'));
                        $past_seven_weeks[$key]["discharges"]               = array_sum(array_column($attendence_weeks_7_arr[$row["date_val_org"]], 'symphony_discharged'));
                        $past_seven_weeks[$key]["performance"]              = PerformanceCalculationAne($past_seven_weeks[$key]["breaches"], $past_seven_weeks[$key]["type_1_2_3"], 0);
                    }
                }
            }
            $success_array["past_seven_weeks"]                              = $past_seven_weeks;
        } else {
            $past_7_months_date_filter_start                                = date("Y-m-01", strtotime($process_array["start_date"] . " -5 month"));
            $past_7_months_date_filter_end                                  = date("Y-m-t", strtotime($past_7_months_date_filter_start . " +5 month"));
            $attendence_past_7_months_data_processed                        = $this->CalculatedEDSummaryAttendance($past_7_months_date_filter_start, $past_7_months_date_filter_end);

            $attendence_months_7_arr                                        = array();
            $breach_months_7_arr                                            = array();
            $past_seven_months                                              = array();

            for ($x = 0; $x < 6; $x++) {
                $date_month_index_format                                    = date("Y-m-01", strtotime($past_7_months_date_filter_end));
                $date_month_index                                           = date("M Y", strtotime($date_month_index_format . " - $x month"));
                $date_month_index_array                                     = date("Y-m-01", strtotime($date_month_index_format . " - $x month"));
                $past_seven_months[$x]["date_val"]                          = $date_month_index;
                $past_seven_months[$x]["date_val_org"]                      = $date_month_index_array;
                $past_seven_months[$x]["type_1_2_3"]                        = 0;
                $past_seven_months[$x]["discharges"]                        = 0;
                $past_seven_months[$x]["breaches"]                          = 0;
                $past_seven_months[$x]["performance"]                       = 100;
                $attendence_months_7_arr[$date_month_index_array]           = array();
                $breach_months_7_arr[$date_month_index_array]               = array();
            }
            if (!empty($attendence_past_7_months_data_processed)) {
                foreach ($attendence_past_7_months_data_processed as $row) {
                    $date_format_for_index                                  = date("Y-m-01", strtotime($row["ed_summary_date"]));
                    $attendence_months_7_arr[$date_format_for_index][]      = $row;
                }
            }
            foreach ($past_seven_months as $key => $row) {
                if (isset($attendence_months_7_arr[$row["date_val_org"]])) {
                    if (is_array($attendence_months_7_arr[$row["date_val_org"]])) {
                        $past_seven_months[$key]["type_1_2_3"]              = array_sum(array_column($attendence_months_7_arr[$row["date_val_org"]], 'symphony_attendance'));
                        $past_seven_months[$key]["discharges"]              = array_sum(array_column($attendence_months_7_arr[$row["date_val_org"]], 'symphony_discharged'));
                        $past_seven_months[$key]["breaches"]                = array_sum(array_column($attendence_months_7_arr[$row["date_val_org"]], 'symphony_breached'));
                        $past_seven_months[$key]["performance"]             = PerformanceCalculationAne($past_seven_months[$key]["breaches"], $past_seven_months[$key]["type_1_2_3"], 0);
                    }
                }
            }
            $success_array["past_seven_months"]                             = $past_seven_months;
        }
        $this->EDSummaryHistoryDataCalculationDetails($success_array, $process_array);

        /////////////////////////////////////////////////////////////////////////////////////////
        $ambulance_walkin_data_array                                    = $common_symphony_controller->AmbulanceWalkinArrayProcess($discharged_all_admitted_discharged_breached['breached_patients']);
        $breach_data_array                                              = array();
        $breach_data_array["ambulance"]["breach_perc"]                  = 0;
        $breach_data_array["walk_in"]["breach_perc"]                    = 0;
        $breach_data_array["total"]                                     = count($discharged_all_admitted_discharged_breached['breached_patients']);
        $breach_data_array["ambulance"]["breach_count"]                 = count($ambulance_walkin_data_array['ambulance_arrival']);
        $breach_data_array["walk_in"]["breach_count"]                   = count($ambulance_walkin_data_array['walkin_arrival']);
        $breach_data_array["ambulance"]["breach_perc"]                  = PercentageCalculationOfValues($breach_data_array["ambulance"]["breach_count"], $breach_data_array["total"], 0);
        if ($breach_data_array["walk_in"]["breach_count"] > 0) {
            $breach_data_array["walk_in"]["breach_perc"]                = number_format(100 - $breach_data_array["ambulance"]["breach_perc"]);
        }
        $success_array["breach_data"]                                   = $breach_data_array;




        foreach ($speciality_name as $speciality_key => $speciality_value) {
            $performance_by_speciality[$speciality_key]['name'] = $speciality_value;
            $performance_by_speciality[$speciality_key]['attendance'] = $daily_key_value_data['symphony_attendance_speciality_' . $speciality_key] ?? 0;
            $performance_by_speciality[$speciality_key]['breached'] = $daily_key_value_data['symphony_breached_speciality_' . $speciality_key] ?? 0;
            $performance_by_speciality[$speciality_key]['admitted'] = $daily_key_value_data['symphony_admitted_speciality_' . $speciality_key] ?? 0;
            $performance_by_speciality[$speciality_key]['discharged'] = $daily_key_value_data['symphony_discharged_speciality_' . $speciality_key] ?? 0;
            $performance_by_speciality[$speciality_key]['graph_perc'] = PerformanceCalculationAne($performance_by_speciality[$speciality_key]['breached'], $performance_by_speciality[$speciality_key]['attendance']);
            $performance_by_speciality[$speciality_key]['admitted_perc'] = PercentageCalculationOfValues($performance_by_speciality[$speciality_key]['admitted'], $performance_by_speciality[$speciality_key]['attendance']);
            $performance_by_speciality[$speciality_key]['breached_perc'] = PercentageCalculationOfValues($performance_by_speciality[$speciality_key]['breached'], $performance_by_speciality[$speciality_key]['attendance']);
        }
        $success_array['performance_by_speciality'] = $performance_by_speciality;



        $ambulance_walkin_data_array                                        =  $common_symphony_controller->AmbulanceWalkinArrayProcess($todays_attendence_main_category);
        $ambulance_arrival_arr                                              = array();
        $ambulance_admitted_discharged_patients_list_all                    = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($ambulance_walkin_data_array['ambulance_arrival'], $process_array);
        $ambulance_arrival                                                  = array();
        $ambulance_arrival_arr["total"]                                     = count($ambulance_walkin_data_array['ambulance_arrival']);
        $ambulance_arrival_arr["home_count"]                                = count($ambulance_admitted_discharged_patients_list_all['discharged_patients']);;
        $ambulance_arrival_arr["admitted_count"]                            = count($ambulance_admitted_discharged_patients_list_all['admitted_patients']);
        $ambulance_arrival_arr["home_perc"]                                 = PercentageCalculationOfValues($ambulance_arrival_arr["home_count"], $ambulance_arrival_arr["total"], 0);
        $ambulance_arrival_arr["admitted_perc"]                             = PercentageCalculationOfValues($ambulance_arrival_arr["admitted_count"], $ambulance_arrival_arr["total"], 0);

        $min_over_30                                                        = 0;
        $min_over_60                                                        = 0;
        if ($tab_filter_mode == 2) {
            $ambulance_arrival_updated_date                                 = date("Y-m-d", strtotime($process_array["start_date"]));
            $ambulance_arrival_data_over_minutes                            = AmbulanceArrivalOverMinutes::where('ambulance_arrival_updated_date', '=', $ambulance_arrival_updated_date)->first();
            if (isset($ambulance_arrival_data_over_minutes->min_30_count)) {
                $min_over_30 = $ambulance_arrival_data_over_minutes->min_30_count;
            }
            if (isset($ambulance_arrival_data_over_minutes->min_60_count)) {
                $min_over_60 = $ambulance_arrival_data_over_minutes->min_60_count;
            }
        } elseif ($tab_filter_mode == 5) {
            $process_array["week_start_date_ambulance"]                        = $process_array["start_date"];
            CalculateStartEndDateAccordingSelection($process_array["week_start_date_ambulance"], $process_array["week_end_date_ambulance"], "week");
            $ambulance_arrival_data_over_minutes_array                          = AmbulanceArrivalOverMinutes::whereBetween('ambulance_arrival_updated_date', [$process_array["week_start_date_ambulance"], $process_array["week_end_date_ambulance"]])->get();
            if (!empty($ambulance_arrival_data_over_minutes_array)) {
                if (count($ambulance_arrival_data_over_minutes_array) > 0) {
                    foreach ($ambulance_arrival_data_over_minutes_array as $row) {
                        $min_over_30    = $min_over_30 + $row->min_30_count;
                        $min_over_60    = $min_over_60 + $row->min_60_count;
                    }
                }
            }
        } else {
            $process_array["month_start_date_ambulance"]                    = $process_array["start_date"];
            CalculateStartEndDateAccordingSelection($process_array["month_start_date_ambulance"], $process_array["month_end_date_ambulance"], "month");
            $ambulance_arrival_data_over_minutes_array                      = AmbulanceArrivalOverMinutes::whereBetween('ambulance_arrival_updated_date', [$process_array["month_start_date_ambulance"], $process_array["month_end_date_ambulance"]])->get();

            if (!empty($ambulance_arrival_data_over_minutes_array)) {
                if (count($ambulance_arrival_data_over_minutes_array) > 0) {
                    foreach ($ambulance_arrival_data_over_minutes_array as $row) {
                        $min_over_30    = $min_over_30 + $row->min_30_count;
                        $min_over_60    = $min_over_60 + $row->min_60_count;
                    }
                }
            }
        }


        $ambulance_arrival_arr["min_over_30"]                   = $min_over_30;
        $ambulance_arrival_arr["min_over_60"]                   = $min_over_60;
        $success_array["ambulance_arrival"]                     = $ambulance_arrival_arr;


        $performance_array                                              = array();
        $performance_array_admitted                                     = $discharged_all_admitted_discharged_breached['admitted_patients'];
        $performance_array_discharged                                   = $discharged_all_admitted_discharged_breached['discharged_patients'];




        $performance_array["total"]                                     = count($todays_attendence_main_category);
        $performance_array["total_discharges"]                          = count($todays_discharged_all_category);


        $admitted_aa_breach_count_per                                   = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($performance_array_admitted, $process_array);
        $non_admitted_aa_breach_count_per                               = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($performance_array_discharged, $process_array);



        $performance_array["admitted_count"]                            = count($performance_array_admitted);
        $performance_array["non_admitted_count"]                        = count($performance_array_discharged);

        $performance_array["admitted_breached_patient_count"]           = count($admitted_aa_breach_count_per['breached_patients']);
        $performance_array["non_admitted_breached_patient_count"]       = count($non_admitted_aa_breach_count_per['breached_patients']);



        $performance_array["breach_total"]                              = count($discharged_all_admitted_discharged_breached['breached_patients']);
        $performance_array["admitted_perc"]                             = PerformanceCalculationAne($performance_array["admitted_breached_patient_count"], $performance_array["admitted_count"], 2) . '% (' . $performance_array["admitted_count"] . ')';
        $performance_array["non_admitted_perc"]                         = PerformanceCalculationAne($performance_array["non_admitted_breached_patient_count"], $performance_array["non_admitted_count"], 2) . '% (' . $performance_array["non_admitted_count"] . ')';
        $performance_array["performance"]                               = PerformanceCalculationAne($performance_array["breach_total"], $performance_array["total_discharges"], 2);
        $performance_array["performance_graph"]                         = PerformanceCalculationAne($performance_array["breach_total"], $performance_array["total_discharges"], 0);
        $success_array["performance"]                                   = $performance_array;

        $attendence_array                                               = array();
        $process_array["forecast_year_start_date"]                      = $process_array["date_time_now"];
        CalculateStartEndDateAccordingSelection($process_array["forecast_year_start_date"], $process_array["forecast_year_end_date"], "last_365");


        $attendence_data_processed_for_previous_arr                     = SymphonyAttendanceCalculatedDailyEDSummary::whereBetween('ed_summary_date', array($process_array["forecast_year_start_date"], $process_array["forecast_year_end_date"]))->orderBy('ed_summary_date', 'DESC')->get()->toArray();
        $attendence_data_processed_for_previous                         = $common_controller->SeriliseDataArrayToBeProcessed($attendence_data_processed_for_previous_arr, 'ed_summary_date');
        $forecast_year_attendance_total                                 = 0;
        $forecast_year_admitted_total                                   = 0;

        if (count($attendence_data_processed_for_previous) > 0) {
            $forecast_year_attendance_total                             = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_attendance'));
            $forecast_year_admitted_total                               = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_admitted_total_excluded_wards'));
        }
        $attendence_array["type_1_2_3"]                                 = count($todays_attendence_main_category);
        $attendence_array["admitted_total"]                             = count($main_cat_admitted_discharged_breached['admitted_patients']);
        $attendence_array["coversion_rate"]                             = PercentageCalculationOfValues($attendence_array["admitted_total"], $attendence_array["type_1_2_3"], 0);

        if ($tab_filter_mode == 2) {
            $process_array["forecast_date_section_start"]                     = $process_array["date_time_now"];
            CalculateStartEndDateAccordingSelection($process_array["forecast_date_section_start"], $process_array["forecast_date_section_end"], "last seven");

            $attendence_data_processed_for_previous_arr                     = SymphonyAttendanceCalculatedDailyEDSummary::whereBetween('ed_summary_date', array($process_array["forecast_date_section_start"], $process_array["forecast_date_section_end"]))->orderBy('ed_summary_date', 'DESC')->get()->toArray();
            $attendence_data_processed_for_previous                         = $common_controller->SeriliseDataArrayToBeProcessed($attendence_data_processed_for_previous_arr, 'ed_summary_date');
            $forecast_year_attendance_total                                 = 0;
            $forecast_year_admitted_total                                   = 0;

            if (count($attendence_data_processed_for_previous) > 0) {
                $forecast_year_attendance_total                             = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_attendance'));
                $forecast_year_admitted_total                               = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_admitted'));
            }
            $attendence_array["attendence_forcasted_count_first"]           = round($forecast_year_attendance_total / 7, 0);
            $attendence_array["attendence_admitted_forcasted_count_first"]  = round($forecast_year_admitted_total / 7, 0);

            $process_array["forecast_date_section_start"]                     = $process_array["date_time_now"];
            CalculateStartEndDateAccordingSelection($process_array["forecast_date_section_start"], $process_array["forecast_date_section_end"], "last 30 days");

            $attendence_data_processed_for_previous_arr                     = SymphonyAttendanceCalculatedDailyEDSummary::whereBetween('ed_summary_date', array($process_array["forecast_date_section_start"], $process_array["forecast_date_section_end"]))->orderBy('ed_summary_date', 'DESC')->get()->toArray();
            $attendence_data_processed_for_previous                         = $common_controller->SeriliseDataArrayToBeProcessed($attendence_data_processed_for_previous_arr, 'ed_summary_date');
            $forecast_year_attendance_total                                 = 0;
            $forecast_year_admitted_total                                   = 0;

            if (count($attendence_data_processed_for_previous) > 0) {
                $forecast_year_attendance_total                             = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_attendance'));
                $forecast_year_admitted_total                               = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_admitted'));
            }

            $attendence_array["attendence_forcasted_count_second"]              = round($forecast_year_attendance_total / 30, 0);
            $attendence_array["attendence_admitted_forcasted_count_second"]     = round($forecast_year_admitted_total / 30, 0);
        } elseif ($tab_filter_mode == 5) {
            $process_array["forecast_date_section_start"]                     = $process_array["date_time_now"];
            CalculateStartEndDateAccordingSelection($process_array["forecast_date_section_start"], $process_array["forecast_date_section_end"], "last 4 weeks");

            $attendence_data_processed_for_previous_arr                     = SymphonyAttendanceCalculatedDailyEDSummary::whereBetween('ed_summary_date', array($process_array["forecast_date_section_start"], $process_array["forecast_date_section_end"]))->orderBy('ed_summary_date', 'DESC')->get()->toArray();
            $attendence_data_processed_for_previous                         = $common_controller->SeriliseDataArrayToBeProcessed($attendence_data_processed_for_previous_arr, 'ed_summary_date');
            $forecast_year_attendance_total                                 = 0;
            $forecast_year_admitted_total                                   = 0;

            if (count($attendence_data_processed_for_previous) > 0) {
                $forecast_year_attendance_total                             = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_attendance'));
                $forecast_year_admitted_total                               = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_admitted'));
            }


            $attendence_array["attendence_forcasted_count_first"]           = round($forecast_year_attendance_total / 4, 0);
            $attendence_array["attendence_admitted_forcasted_count_first"]  = round($forecast_year_admitted_total / 4, 0);

            $process_array["forecast_date_section_start"]                     = $process_array["date_time_now"];
            CalculateStartEndDateAccordingSelection($process_array["forecast_date_section_start"], $process_array["forecast_date_section_end"], "last_84");

            $attendence_data_processed_for_previous_arr                     = SymphonyAttendanceCalculatedDailyEDSummary::whereBetween('ed_summary_date', array($process_array["forecast_date_section_start"], $process_array["forecast_date_section_end"]))->orderBy('ed_summary_date', 'DESC')->get()->toArray();
            $attendence_data_processed_for_previous                         = $common_controller->SeriliseDataArrayToBeProcessed($attendence_data_processed_for_previous_arr, 'ed_summary_date');
            $forecast_year_attendance_total                                 = 0;
            $forecast_year_admitted_total                                   = 0;

            if (count($attendence_data_processed_for_previous) > 0) {
                $forecast_year_attendance_total                             = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_attendance'));
                $forecast_year_admitted_total                               = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_admitted'));
            }

            $attendence_array["attendence_forcasted_count_second"]              = round($forecast_year_attendance_total / 12, 0);
            $attendence_array["attendence_admitted_forcasted_count_second"]     = round($forecast_year_admitted_total / 12, 0);
        } else {
            $process_array["forecast_date_section_start"]                     = $process_array["date_time_now"];
            CalculateStartEndDateAccordingSelection($process_array["forecast_date_section_start"], $process_array["forecast_date_section_end"], "last_90");

            $attendence_data_processed_for_previous_arr                     = SymphonyAttendanceCalculatedDailyEDSummary::whereBetween('ed_summary_date', array($process_array["forecast_date_section_start"], $process_array["forecast_date_section_end"]))->orderBy('ed_summary_date', 'DESC')->get()->toArray();
            $attendence_data_processed_for_previous                         = $common_controller->SeriliseDataArrayToBeProcessed($attendence_data_processed_for_previous_arr, 'ed_summary_date');
            $forecast_year_attendance_total                                 = 0;
            $forecast_year_admitted_total                                   = 0;

            if (count($attendence_data_processed_for_previous) > 0) {
                $forecast_year_attendance_total                             = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_attendance'));
                $forecast_year_admitted_total                               = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_admitted'));
            }

            if ($tab_filter_mode == 3) {
                $attendence_array["attendence_forcasted_count_first"]           = round($forecast_year_attendance_total / 3, 0);
                $attendence_array["attendence_admitted_forcasted_count_first"]  = round($forecast_year_admitted_total / 3, 0);
            } else {
                $attendence_array["attendence_forcasted_count_first"]           = round($forecast_year_attendance_total / 90, 0);
                $attendence_array["attendence_admitted_forcasted_count_first"]  = round($forecast_year_admitted_total / 90, 0);
            }

            $process_array["forecast_date_section_start"]                     = $process_array["date_time_now"];
            CalculateStartEndDateAccordingSelection($process_array["forecast_date_section_start"], $process_array["forecast_date_section_end"], "last_365");

            $attendence_data_processed_for_previous_arr                     = SymphonyAttendanceCalculatedDailyEDSummary::whereBetween('ed_summary_date', array($process_array["forecast_date_section_start"], $process_array["forecast_date_section_end"]))->orderBy('ed_summary_date', 'DESC')->get()->toArray();
            $attendence_data_processed_for_previous                         = $common_controller->SeriliseDataArrayToBeProcessed($attendence_data_processed_for_previous_arr, 'ed_summary_date');
            $forecast_year_attendance_total                                 = 0;
            $forecast_year_admitted_total                                   = 0;

            if (count($attendence_data_processed_for_previous) > 0) {
                $forecast_year_attendance_total                             = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_attendance'));
                $forecast_year_admitted_total                               = array_sum(array_column($attendence_data_processed_for_previous, 'symphony_admitted'));
            }

            if ($tab_filter_mode == 3) {
                $attendence_array["attendence_forcasted_count_second"]              = round($forecast_year_attendance_total / 12, 0);
                $attendence_array["attendence_admitted_forcasted_count_second"]     = round($forecast_year_admitted_total / 12, 0);
            } else {
                $attendence_array["attendence_forcasted_count_second"]              = round($forecast_year_attendance_total / 365, 0);
                $attendence_array["attendence_admitted_forcasted_count_second"]     = round($forecast_year_admitted_total / 365, 0);
            }
        }
        $attendence_array["attendence_forcast_conversion_rate_first"]           = PercentageCalculationOfValues($attendence_array["attendence_admitted_forcasted_count_first"], $attendence_array["attendence_forcasted_count_first"], 0);
        $attendence_array["attendence_forcast_conversion_rate_second"]          = PercentageCalculationOfValues($attendence_array["attendence_admitted_forcasted_count_second"], $attendence_array["attendence_forcasted_count_second"], 0);



        $attendence_array["attendence_forcasted_arrow_count_first"]             = "bi-caret-up-fill";
        $attendence_array["attendence_forcasted_arrow_count_second"]            = "bi-caret-up-fill";
        $attendence_array["attendence_forcasted_arrow_percentage_first"]        = "bi-caret-up-fill";
        $attendence_array["attendence_forcasted_arrow_percentage_second"]       = "bi-caret-up-fill";

        if ($attendence_array["type_1_2_3"] > $attendence_array["attendence_forcasted_count_first"]) {
            $attendence_array["attendence_forcasted_arrow_count_first"]         = "bi-caret-down-fill text-danger";
        }

        if ($attendence_array["type_1_2_3"] > $attendence_array["attendence_forcasted_count_second"]) {
            $attendence_array["attendence_forcasted_arrow_count_second"]         = "bi-caret-down-fill text-danger";
        }

        if ($attendence_array["coversion_rate"] > $attendence_array["attendence_forcast_conversion_rate_first"]) {
            $attendence_array["attendence_forcasted_arrow_percentage_first"]         = "bi-caret-down-fill text-danger";
        }

        if ($attendence_array["coversion_rate"] > $attendence_array["attendence_forcast_conversion_rate_second"]) {
            $attendence_array["attendence_forcasted_arrow_percentage_second"]         = "bi-caret-down-fill text-danger";
        }
        $success_array["attendence"]                                    = $attendence_array;
    }

































































    public function BreachValidationBreachMonthOverall(&$success_array, &$process_array)
    {
        $common_controller                              = new CommonController;
        $attendence_data_processed_month_data_arr       = SymphonyAttendanceCalculatedDailyEDSummary::whereBetween('ed_summary_date', array($process_array["start_date"], $process_array["end_date"]))->orderBy('ed_summary_date', 'DESC')->get()->toArray();
        $attendence_data_processed_month_data           = $common_controller->SeriliseDataArrayToBeProcessed($attendence_data_processed_month_data_arr, 'ed_summary_date');



        $number_of_days                                 = date('t', strtotime($process_array["start_date"]));
        $current_day_check                              = strtotime(date('Y-m-d'));
        $month_overall_summary_array                    = array();
        $month_overall_summary_array_total              = array();

        for ($xy = 0; $xy < $number_of_days; $xy++) {
            $arr_create_date = date("Y-m-d", strtotime($process_array["start_date"] . " + $xy days"));

            if (strtotime($arr_create_date) <= $current_day_check) {
                $month_overall_summary_array[$arr_create_date]['date'] = date('D jS M Y', strtotime($arr_create_date));

                // Random realistic numbers 1–99
                $month_overall_summary_array[$arr_create_date]['symphony_attendance_less_than_one_hour'] = rand(1, 99);
                $month_overall_summary_array[$arr_create_date]['symphony_attendance_one_to_two_hour']    = rand(1, 99);
                $month_overall_summary_array[$arr_create_date]['symphony_attendance_two_to_three_hour']  = rand(1, 99);
                $month_overall_summary_array[$arr_create_date]['symphony_attendance_three_to_four_hour'] = rand(1, 99);
                $month_overall_summary_array[$arr_create_date]['symphony_attendance_four_hours_plus']    = rand(1, 99);

                $month_overall_summary_array[$arr_create_date]['symphony_attendance']   = rand(1, 99);
                $month_overall_summary_array[$arr_create_date]['symphony_discharged']   = rand(1, 99);
                $month_overall_summary_array[$arr_create_date]['symphony_breached']     = rand(1, 99);

                // Keep performance as 100 unless you want random here too
                $month_overall_summary_array[$arr_create_date]['symphony_breached_performance'] = rand(1, 99);
            }
        }

        // TOTALS – if you also want these random, use rand(1,99).
        // If you want them to remain 0, leave them as they are.
        // Here I set them random as well (optional):
        $month_overall_summary_array_total['symphony_attendance_less_than_one_hour'] = rand(1, 99);
        $month_overall_summary_array_total['symphony_attendance_one_to_two_hour']    = rand(1, 99);
        $month_overall_summary_array_total['symphony_attendance_two_to_three_hour']  = rand(1, 99);
        $month_overall_summary_array_total['symphony_attendance_three_to_four_hour'] = rand(1, 99);
        $month_overall_summary_array_total['symphony_attendance_four_hours_plus']    = rand(1, 99);
        $month_overall_summary_array_total['symphony_attendance']                    = rand(1, 99);
        $month_overall_summary_array_total['symphony_discharged']                    = rand(1, 99);
        $month_overall_summary_array_total['symphony_breached']                      = rand(1, 99);
        $month_overall_summary_array_total['symphony_breached_performance']          = rand(1, 99);


        $yz                                                                                                     = 0;
        // if (count($attendence_data_processed_month_data) > 0)
        // {
        //     foreach ($attendence_data_processed_month_data as $row)
        //     {
        //         $date_to_check  = $row['ed_summary_date'];
        //         if (isset($month_overall_summary_array[$date_to_check]))
        //         {
        //             $month_overall_summary_array[$date_to_check]['symphony_attendance_less_than_one_hour']      = $row['symphony_attendance_less_than_one_hour'] ?? 0;
        //             $month_overall_summary_array[$date_to_check]['symphony_attendance_one_to_two_hour']         = $row['symphony_attendance_one_to_two_hour'] ?? 0;
        //             $month_overall_summary_array[$date_to_check]['symphony_attendance_two_to_three_hour']       = $row['symphony_attendance_two_to_three_hour'] ?? 0;
        //             $month_overall_summary_array[$date_to_check]['symphony_attendance_three_to_four_hour']      = $row['symphony_attendance_three_to_four_hour'] ?? 0;
        //             $month_overall_summary_array[$date_to_check]['symphony_attendance_four_hours_plus']         = $row['symphony_attendance_four_hours_plus'] ?? 0;
        //             $month_overall_summary_array[$date_to_check]['symphony_attendance']                         = $row['symphony_attendance'] ?? 0;
        //             $month_overall_summary_array[$date_to_check]['symphony_discharged']                         = $row['symphony_discharged'] ?? 0;
        //             $month_overall_summary_array[$date_to_check]['symphony_breached']                           = $row['symphony_breached'] ?? 0;
        //             if (isset($row['symphony_attendance']) && isset($row['symphony_breached']) && $row['symphony_attendance'] != 0 &&  $row['symphony_breached'] != 0)
        //             {
        //                 $month_overall_summary_array[$date_to_check]['symphony_breached_performance']           = PerformanceCalculationAne($row['symphony_breached'], $row['symphony_discharged'], 0);
        //                 $month_overall_summary_array_total['symphony_breached_performance']                     = $month_overall_summary_array_total['symphony_breached_performance'] + $month_overall_summary_array[$date_to_check]['symphony_breached_performance'];
        //                 $yz++;
        //             }
        //             $month_overall_summary_array_total['symphony_attendance_less_than_one_hour']                = ($month_overall_summary_array_total['symphony_attendance_less_than_one_hour'] ?? 0) + ($row['symphony_attendance_less_than_one_hour'] ?? 0);
        //             $month_overall_summary_array_total['symphony_attendance_one_to_two_hour']                   = ($month_overall_summary_array_total['symphony_attendance_one_to_two_hour'] ?? 0) + ($row['symphony_attendance_one_to_two_hour'] ?? 0);
        //             $month_overall_summary_array_total['symphony_attendance_two_to_three_hour']                 = ($month_overall_summary_array_total['symphony_attendance_two_to_three_hour'] ?? 0) + ($row['symphony_attendance_two_to_three_hour'] ?? 0);
        //             $month_overall_summary_array_total['symphony_attendance_three_to_four_hour']                = ($month_overall_summary_array_total['symphony_attendance_three_to_four_hour'] ?? 0) + ($row['symphony_attendance_three_to_four_hour'] ?? 0);
        //             $month_overall_summary_array_total['symphony_attendance_four_hours_plus']                   = ($month_overall_summary_array_total['symphony_attendance_four_hours_plus'] ?? 0) + ($row['symphony_attendance_four_hours_plus'] ?? 0);
        //             $month_overall_summary_array_total['symphony_attendance']                                   = ($month_overall_summary_array_total['symphony_attendance'] ?? 0) + ($row['symphony_attendance'] ?? 0);
        //             $month_overall_summary_array_total['symphony_discharged']                                   = ($month_overall_summary_array_total['symphony_discharged'] ?? 0) + ($row['symphony_discharged'] ?? 0);
        //             $month_overall_summary_array_total['symphony_breached']                                     = ($month_overall_summary_array_total['symphony_breached'] ?? 0) + ($row['symphony_breached'] ?? 0);
        //         }
        //     }
        // }
        if ($yz > 0) {
            $month_overall_summary_array_total['symphony_breached_performance']                                 = (int)($month_overall_summary_array_total['symphony_breached_performance'] / $yz);
        }
        $success_array['month_overall_summary_array']                                                           = $month_overall_summary_array;
        $success_array['month_overall_summary_array_total']                                                     = $month_overall_summary_array_total;
    }








































































    public function BreachAmbulanceDataStore(Request $request)
    {
        $history_controller = new HistoryController;
        $history_opel_status = "App\Models\History\HistorySymphonyAneAmbulanceCountMin";
        $date_time_now                                              = CurrentDateOnFormat();
        $CommonController                                           = new CommonController;
        $min_30_count                                               = $request->min_30_count;
        $min_60_count                                               = $request->min_60_count;
        $reg_date_selected                                               = $request->reg_date_selected;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $user_name                                                  = Session()->get('LOGGED_USER_NAME', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;


        if ($min_30_count != "" && $min_60_count != "" && $reg_date_selected != "") {
            $gov_text_before_arr                                    = AmbulanceArrivalOverMinutes::where('ambulance_arrival_updated_date', '=', $reg_date_selected)->first();
            $ambulance_count_data                                   = AmbulanceArrivalOverMinutes::updateOrCreate(['ambulance_arrival_updated_date' => $reg_date_selected], ['min_30_count' => $min_30_count, 'min_60_count' => $min_60_count, 'user_updated' => $user_id]);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($ambulance_count_data, $history_opel_status);
            $user_info_update                                       = 0;
            if ($ambulance_count_data->wasRecentlyCreated) {
                $user_info_update                                   = 1;
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $ambulance_count_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $this->GovernanceAmbulanceDataPreCall($updated_array["id"], $gov_text_before, 1);
                }
            } else {
                if (count($ambulance_count_data->getChanges()) > 0) {
                    $user_info_update = 1;
                    $updated_array = $ambulance_count_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before = $gov_text_before_arr->toArray();
                            $this->GovernanceAmbulanceDataPreCall($updated_array["id"], $gov_text_before, 2);
                        }
                    }
                }
                $success_array["message"] = DataUpdatedMessage();
            }
            $success_array["status"]                                = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }





    public function GovernanceAmbulanceDataPreCall($id, $gov_text_before, $operation)
    {

        $gov_data = array();
        $gov_text_after = array();

        $functional_identity = RetriveSpecificConstantSettingValues("ibox_frontend_governance_ibox_breach_ambulance_count", "ibox_governance_frontend_functional_names");
        if ($operation == 1) {
            if (isset($id) && $id != '') {
                $gov_text_after_arr = AmbulanceArrivalOverMinutes::where('id', '=', $id)->first();
                if ($gov_text_after_arr) {
                    $gov_text_after = $gov_text_after_arr->toArray();
                }
            }
            if (isset($gov_text_after["id"])) {
                $gov_data["gov_text_before"] = "";
                $gov_data["gov_text_after"] = json_encode($gov_text_after);
                $gov_data["gov_updation_status"] = $operation;
                $gov_data["gov_func_identity"] = $functional_identity;
                $gov_data["gov_description"] = 'Over 30 Min - ' . $gov_text_after["min_30_count"] . ', Over 60 Min - ' . $gov_text_after["min_60_count"] . ' For Date : ' . $gov_text_after["ambulance_arrival_updated_date"];
            }
        }
        if ($operation == 2) {
            if (isset($id) && $id != '') {
                $gov_text_after_arr = AmbulanceArrivalOverMinutes::where('id', '=', $id)->first();
                if ($gov_text_after_arr) {
                    $gov_text_after = $gov_text_after_arr->toArray();
                }
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"] = json_encode($gov_text_before);
                $gov_data["gov_text_after"] = json_encode($gov_text_after);
                $gov_data["gov_updation_status"] = $operation;
                $gov_data["gov_func_identity"] = $functional_identity;
                $gov_data["gov_description"] = 'Over 30 Min - ' . $gov_text_after["min_30_count"] . ', Over 60 Min - ' . $gov_text_after["min_60_count"] . ' For Date : ' . $gov_text_after["ambulance_arrival_updated_date"];
            }
        }
        if (!empty($gov_data)) {
            if (count($gov_data) > 0) {
                $governance = new GovernanceController;
                $governance->GovernanceStoreIboxData($gov_data);
            }
        }
    }
}
