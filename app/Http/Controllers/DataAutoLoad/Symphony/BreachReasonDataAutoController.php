<?php

namespace App\Http\Controllers\DataAutoLoad\Symphony;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonSymphonyController;
use App\Http\Controllers\Common\HistoryController;
use App\Http\Controllers\Governance\GovernanceController;

use App\Models\Iboards\Symphony\Data\SymphonyAttendance;
use App\Models\Iboards\Symphony\View\SymphonyAttendanceView;
use App\Models\Iboards\Symphony\View\SymphonyBreachAttendanceView;
use App\Models\Iboards\Symphony\Data\SymphonyBreachReasonUserUpdate;
use App\Models\Governance\LogReplicationAutomatedJobLogStatus;
use App\Models\Common\User;
use App\Models\Iboards\Symphony\Master\BreachReason;

class BreachReasonDataAutoController extends Controller
{
    public function BreachReasonDataAutoInsert()
    {
        $common_controller                                  = new CommonController;
        $common_symphony_controller                         = new CommonSymphonyController;
        $history_controller                                 = new HistoryController;
        $history_breach_reason                              = "App\Models\History\HistorySymphonyBreachReasonUserUpdate";
        $auto_user_id                                       = 0;
        $process_array                                      = array();
        $success_array                                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);

        $automated_job_log                                  = array('replication_job_name'   => 'Automated Breach Reason', 'replication_job_start_time' => $process_array['date_time_now']);
        $automated_job_log_id                               = LogReplicationAutomatedJobLogStatus::insertGetId($automated_job_log);

        $process_array["start_date"]                        = CurrentDateOnFormat();
        CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "last 30 days");
        $total_attendance_breached                          = SymphonyAttendanceView::whereBetween('symphony_discharge_date', array($process_array["start_date"], $process_array["end_date"]))->orderBy('symphony_sync_at', 'DESC')->get()->toArray();



        if ($process_array['ibox_auto_set_admin_id'] != '')
        {
            $auto_user_id                                   = $process_array['ibox_auto_set_admin_id'];
        }
        $breach_auto_set_user_credentials                   = User::where('id', '=', $auto_user_id)->first();
        if (isset($breach_auto_set_user_credentials->id))
        {
            if ($breach_auto_set_user_credentials->id != '')
            {
                $user_id                                                = $breach_auto_set_user_credentials->id;
                $loop_count                                             = 0;
                if (count($total_attendance_breached) > 0)
                {
                    foreach ($total_attendance_breached  as $breach_data_processed)
                    {
                        $time_in_department                                         = ValuePresentThenSetForVariableBreach($breach_data_processed, "symphony_registration_date_time", 3, "symphony_discharge_date");
                        if ($time_in_department < 14401 && isset($breach_data_processed['breach_reason_update_id']) && $breach_data_processed['breach_reason_update_id'] != null && $breach_data_processed['breach_reason_update_id'] != '')
                        {
                            if ($breach_data_processed['breach_reason_name'] != 'No Breach')
                            {
                                $breach_reason                                      = BreachReason::where("reason_name", '=', 'No Breach')->first();
                                if (!isset($breach_reason->id) || $breach_reason->id == '')
                                {
                                    $breachreason                                   =   array('reason_name'   => 'No Breach');
                                    $breach_reason_update_id_to_store_field         =   BreachReason::insertGetId($breachreason);
                                }
                                else
                                {
                                    $breach_reason_update_id_to_store_field         =   $breach_reason->id;
                                }
                                $attendace_id                                       = $breach_data_processed['symphony_attendance_id'];
                                $breach_reason_id                                   = $breach_reason_update_id_to_store_field;
                                if ($breach_reason_id != "" && $user_id != "" && $attendace_id != "")
                                {
                                    $breach_reason_data                             = SymphonyBreachReasonUserUpdate::updateOrCreate(['attendance_number' => $attendace_id], ['breach_reason_update_id' => $breach_reason_id, 'breach_reason_updated_user' => $user_id]);
                                    $history_controller->HistoryTableDataInsertFromUpdateCreate($breach_reason_data, $history_breach_reason);
                                    $breach_data_stored_return                      = BreachReason::where('id', '=', $breach_reason_id)->first();
                                    $updated_array                                  = $breach_reason_data->getOriginal();
                                    $gov_text_before                                = array();
                                    if (count($updated_array) > 0 && isset($updated_array["id"]))
                                    {
                                        $this->GovernanceBreachReasonUpdatePreCall($attendace_id, $updated_array["id"], $gov_text_before, $breach_data_stored_return->reason_name, 1);
                                    }
                                }
                            }
                        }
                        elseif ($time_in_department >= 14401)
                        {
                            if ($breach_data_processed['breach_reason_update_id'] == null || $breach_data_processed['breach_reason_update_id'] == '')
                            {
                                $breach_reason_to_update                        = '';
                                $time_in_department                             = ValuePresentThenSetForVariable($breach_data_processed, "symphony_registration_date_time", 3, "symphony_discharge_date");
                                $time_from_reg_to_ed_doctor                     = ValuePresentThenSetForVariable($breach_data_processed, "symphony_registration_date_time", 2, "symphony_seen_date");
                                $time_from_reg_to_triage                        = ValuePresentThenSetForVariable($breach_data_processed, "symphony_registration_date_time", 2, "symphony_triage_date");
                                $time_from_reg_to_referal                       = ValuePresentThenSetForVariable($breach_data_processed, "symphony_registration_date_time", 2, "symphony_refferal_date");
                                $time_from_referral_to_speciality_doctor        = ValuePresentThenSetForVariable($breach_data_processed, "symphony_refferal_date", 2, "symphony_seen_ae_date");
                                $time_from_dta_to_bed_allocate                  = ValuePresentThenSetForVariable($breach_data_processed, "symphony_request_date", 3, "symphony_discharge_date");


                                $speciality                                                                 = $breach_data_processed['symphony_specialty'];
                                $symphony_final_location                                                    = $breach_data_processed['symphony_final_location'];
                                $discharge_outcome                                                          = strtolower($breach_data_processed['symphony_discharge_outcome']);
                                $patients_in_ed_count                                                       = (int)$breach_data_processed['symphony_breach_count'];
                                $patients_waiting_with_dta_count                                            = (int)$breach_data_processed['symphony_dta_count'];



                                $breach_reason_percentage_arr                                               = array();
                                $breach_reason_percentage_arr['ed_first_assessment_percentage']             = 0;
                                $breach_reason_percentage_arr['ed_capacity_percentage']                     = 0;
                                $breach_reason_percentage_arr['ed_late_referral_percentage']                = 0;
                                $breach_reason_percentage_arr['ed_bed_speciality_percentage']               = 0;
                                $breach_reason_percentage_arr['ed_speciality_review_percentage']            = 0;

                                if ($time_from_reg_to_ed_doctor > 60 && $patients_in_ed_count < 45 && $patients_waiting_with_dta_count < 6)
                                {
                                    $breach_reason_percentage_arr['ed_first_assessment_percentage'] = ($time_from_reg_to_ed_doctor / 60) * 100;
                                }
                                if ($time_from_reg_to_ed_doctor > 60 && ($patients_in_ed_count >= 45 || $patients_waiting_with_dta_count >= 6))
                                {
                                    $breach_reason_percentage_arr['ed_capacity_percentage'] = ($time_from_reg_to_ed_doctor / 60) * 100;
                                }
                                if ($time_from_reg_to_referal > 120)
                                {
                                    $breach_reason_percentage_arr['ed_late_referral_percentage'] = ($time_from_reg_to_referal / 120) * 100;
                                }
                                if ($time_from_dta_to_bed_allocate > 30 && $discharge_outcome == ''  && $speciality != '')
                                {
                                    $breach_reason_percentage_arr['ed_bed_speciality_percentage'] = ($time_from_dta_to_bed_allocate / 30) * 100;
                                }
                                if ($time_from_referral_to_speciality_doctor > 30)
                                {
                                    $breach_reason_percentage_arr['ed_speciality_review_percentage']    = ($time_from_referral_to_speciality_doctor / 30) * 100;
                                }

                                arsort($breach_reason_percentage_arr);
                                $key_of_max                         = key($breach_reason_percentage_arr);
                                if (isset($breach_reason_percentage_arr[$key_of_max]) && $breach_reason_percentage_arr[$key_of_max] > 0)
                                {
                                    if (strtolower($symphony_final_location) == 'paed eds')
                                    {
                                        $breach_reason_to_update = 'Paediatrics';
                                    }
                                    elseif ($key_of_max == 'ed_first_assessment_percentage')
                                    {
                                        $breach_reason_to_update = 'ED First Assessment';
                                    }
                                    else if ($key_of_max == 'ed_capacity_percentage')
                                    {
                                        $breach_reason_to_update = 'ED Capacity';
                                    }
                                    else if ($key_of_max == 'ed_late_referral_percentage')
                                    {
                                        $breach_reason_to_update = 'ED Late Referral';
                                    }
                                    else if ($key_of_max == 'ed_bed_speciality_percentage')
                                    {
                                        $breach_reason_to_update = 'Bed ' . $speciality;
                                    }
                                    else if ($key_of_max == 'ed_speciality_review_percentage')
                                    {
                                        $breach_reason_to_update = 'Speciality Review ';
                                    }
                                }
                                if ($breach_reason_to_update != '')
                                {
                                    $breach_reason                                      = BreachReason::where("reason_name", '=', $breach_reason_to_update)->first();
                                    if (!isset($breach_reason->id) || $breach_reason->id == '')
                                    {
                                        $breachreason                                   =   array('reason_name'   => $breach_reason_to_update);
                                        $breach_reason_update_id_to_store_field         =   BreachReason::insertGetId($breachreason);
                                    }
                                    else
                                    {
                                        $breach_reason_update_id_to_store_field         =   $breach_reason->id;
                                    }
                                    $attendace_id                                       = $breach_data_processed['symphony_attendance_id'];
                                    $breach_reason_id                                   = $breach_reason_update_id_to_store_field;
                                    if ($breach_reason_id != "" && $user_id != "" && $attendace_id != "")
                                    {
                                        $breach_reason_data                             = SymphonyBreachReasonUserUpdate::updateOrCreate(['attendance_number' => $attendace_id], ['breach_reason_update_id' => $breach_reason_id, 'breach_reason_updated_user' => $user_id]);
                                        $history_controller->HistoryTableDataInsertFromUpdateCreate($breach_reason_data, $history_breach_reason);
                                        $breach_data_stored_return                      = BreachReason::where('id', '=', $breach_reason_id)->first();
                                        $updated_array                                  = $breach_reason_data->getOriginal();
                                        $gov_text_before                                = array();
                                        if (count($updated_array) > 0 && isset($updated_array["id"]))
                                        {
                                            $this->GovernanceBreachReasonUpdatePreCall($attendace_id, $updated_array["id"], $gov_text_before, $breach_data_stored_return->reason_name, 1);
                                        }
                                    }
                                    $loop_count++;
                                    if ($loop_count > 100)
                                    {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $replication_job_end_time                           = date('Y-m-d H:i:s');
        $automated_job_log                                  = array('replication_job_end_time'   => $replication_job_end_time, 'replication_job_log_status' => 1);
        LogReplicationAutomatedJobLogStatus::where('id', $automated_job_log_id)->update($automated_job_log);
    }

    public function GovernanceBreachReasonUpdatePreCall($attendance_id, $id, $gov_text_before, $gov_desc, $operation)
    {
        $gov_data                                   = array();
        $gov_text_after_arr                         = SymphonyBreachReasonUserUpdate::where('id', '=', $id)->first();
        $functional_identity                        = RetriveSpecificConstantSettingValues("ibox_frontend_governance_symphony_ane_breach_reason", "ibox_governance_frontend_functional_names");
        if ($operation == 1)
        {
            if ($gov_text_after_arr)
            {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]))
            {
                $gov_data["gov_text_before"] = "";
                $gov_data["gov_text_after"] = json_encode($gov_text_after);
                $gov_data["gov_attendance_id"] = $attendance_id;
                $gov_data["gov_updation_status"] = $operation;
                $gov_data["gov_func_identity"] = $functional_identity;
                $gov_data["gov_description"] = $gov_desc;
            }
        }
        if ($operation == 2)
        {
            if ($gov_text_after_arr)
            {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"]))
            {
                $gov_data["gov_text_before"] = json_encode($gov_text_before);
                $gov_data["gov_text_after"] = json_encode($gov_text_after);
                $gov_data["gov_attendance_id"] = $attendance_id;
                $gov_data["gov_updation_status"] = $operation;
                $gov_data["gov_func_identity"] = $functional_identity;
                $gov_data["gov_description"] = $gov_desc;
            }
        }
        if ($operation == 3)
        {
            if (isset($gov_text_before["id"]))
            {
                $gov_data["gov_text_before"] = json_encode($gov_text_before);
                $gov_data["gov_text_after"] = "";
                $gov_data["gov_attendance_id"] = $attendance_id;
                $gov_data["gov_updation_status"] = $operation;
                $gov_data["gov_func_identity"] = $functional_identity;
                $gov_data["gov_description"] = $gov_desc;
            }
        }
        if (!empty($gov_data))
        {
            if (count($gov_data) > 0)
            {
                $governance = new GovernanceController;
                $governance->GovernanceStoreSymphonyDataAutoUpdate($gov_data);
            }
        }
    }
}
