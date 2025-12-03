<?php

namespace App\Http\Controllers\DataAutoLoad\Camis;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\HistoryController;
use App\Models\History\HistoryCamisIboxBoardInfectionRisk;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundInfectionRisk;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundMissedPotentialDefinite;
use App\Models\Iboards\Camis\Data\CamisIboxHourlyBedManagement;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\Master\WardType;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsFullList;
use App\Http\Controllers\Iboards\Camis\WardSummaryController;
use App\Models\Governance\GovernanceFrontendUserLoginStatus;
use App\Models\Governance\LogReplicationAutomatedJobLogStatus;
use App\Models\History\HistoryCamisIboxBoardWardRound;
use App\Models\History\HistorySymphonyAneOpenStatus;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundBedStatus;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundCDT;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundDtocComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundMedFit;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPathwayRequirement;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientTasks;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPotentialDefinite;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundReasonToReside;
use App\Models\Iboards\Camis\Data\CamisIboxCalculatedDailySummary;
use App\Models\Iboards\Camis\Data\CamisIboxDPTaskDailySummary;
use App\Models\Iboards\Camis\Data\CamisIboxDPVirtualWardPatientStatus;
use App\Models\Iboards\Camis\Data\CamisIboxDtocMonthlyStored;
use App\Models\Iboards\Camis\Master\BedDetails;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use App\Models\Iboards\Camis\Master\DpTasks;
use App\Models\Iboards\Camis\Master\ReasonToResideGroup;
use App\Models\Iboards\Camis\View\CamisIboxInpatientFlagAlertDetails;
use App\Models\Iboards\Camis\View\CamisIboxNyeBevanAdmissionCount;
use App\Models\Iboards\Camis\View\CamisIboxWardHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CamisDailySummaryController extends Controller
{

    public function AutoLoadCamisDailySummary()
    {

        $common_controller                                  = new CommonController;
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $automated_job_log                                  = array('replication_job_name'   => 'Automated Daily Camis Summary Insert', 'replication_job_start_time' => $process_array['date_time_now']);
        $automated_job_log_id                               = LogReplicationAutomatedJobLogStatus::insertGetId($automated_job_log);
        $this->CamisWardDailySummaryFunction(); // Camis Summary Data Creation
        $this->ReasonToResideDailySummaryData(); //Reason To Reside Data
        $this->MedFitPathwaySummary(); //Dtoc Pathway Summary
        $this->AssignReasonToResideOnAdmissionType(); // Assign R2R on Admission Type
        $replication_job_end_time                           = date('Y-m-d H:i:s');
        $automated_job_log                                  = array('replication_job_end_time'   => $replication_job_end_time, 'replication_job_log_status' => 1);
        LogReplicationAutomatedJobLogStatus::where('id', $automated_job_log_id)->update($automated_job_log);
    }

    public function AssignReasonToResideOnAdmissionType()
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundReasonToReside";
        $medfit_history_modal                                       = "App\Models\History\HistoryCamisIboxBoardRoundMedFit";
        $ward_controller                                            = new WardSummaryController;
        $reason_to_reside = ReasonToResideGroup::whereRaw(
            'LOWER(reason_to_reside_text_value) = ?',
            [strtolower('treatment - therapy - i.v. medication > b.d.')]
        )->first();



        $patient_reason_to_reside_status                            = $reason_to_reside->id;
        $med_fit_set_as_no                                          = 0;
        $patient_reason_to_reside_status                            = ($patient_reason_to_reside_status == '') ? 0 : $patient_reason_to_reside_status;
        $patient_medically_fit_status                               = $med_fit_set_as_no;
        $patient_medically_fit_status_comment                       = '';
        $reason_to_reside_text_value                                = $reason_to_reside->reason_to_reside_text_value;

        $all_patients = CamisIboxWardPatientInformationWithBedDetailsView::query()
            ->whereNotNull('camis_patient_id')
            ->whereDoesntHave('BoardRoundReasonToReside')
            ->with('BoardRoundMedicallyFitData')
            ->whereRaw('LOWER(camis_patient_admission_type_description) = ?', ['emergency - local a&e'])
            ->where('camis_patient_admission_date_time', '>=', now()->subHours(12))
            ->get()->toArray();

        foreach($all_patients as $patient_row){
            $camis_patient_id                                       = $patient_row['camis_patient_id'];
            $updated_data                                           = CamisIboxBoardRoundReasonToReside::create(['patient_id' => $camis_patient_id, 'patient_reason_to_reside_status' => $patient_reason_to_reside_status, 'updated_by' => 102, 'reason_to_reside_start_date' => CurrentDateOnFormat()]);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);

            $updated_array                                      = $updated_data->getOriginal();
            $gov_text_before                                    = array();

            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                $gov_text_after_arr                             = CamisIboxBoardRoundReasonToReside::where('id', '=', $updated_array["id"])->first();
                $functional_identity                            = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_reason_to_reside", "ibox_governance_frontend_functional_names");
                $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $reason_to_reside_text_value, $gov_text_after_arr, $functional_identity, 1);
            }




            $gov_text_before_arr                                    = CamisIboxBoardRoundMedFit::where('patient_id', '=', $camis_patient_id)->first();
            if ((!isset($gov_text_before_arr->patient_medically_fit_status) || (isset($gov_text_before_arr->patient_medically_fit_status) && ($gov_text_before_arr->patient_medically_fit_status != $patient_medically_fit_status)))) {

                $updated_data                                           = CamisIboxBoardRoundMedFit::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_medically_fit_status' => $patient_medically_fit_status, 'patient_medically_fit_status_comment' => $patient_medically_fit_status_comment, 'updated_by' => 102, 'patient_med_fit_consultant_name' => $patient_row['camis_consultant_name'] ?? '', 'medfit_status_update_date' => CurrentDateOnFormat()]);
                if ($med_fit_set_as_no == 0) {
                    $medfit_governance_description                          = 'Medfit As No';
                } else {
                    $medfit_governance_description                          = 'Medfit As Yes';
                }

                $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_medfit_discharge", "ibox_governance_frontend_functional_names");
                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $medfit_history_modal, 1);

                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundMedFit::where('id', '=', $updated_array["id"])->first();
                        $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $medfit_governance_description, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $medfit_history_modal, 2);

                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundMedFit::where('id', '=', $updated_array["id"])->first();
                                $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $medfit_governance_description, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            } elseif (isset($gov_text_before_arr->patient_medically_fit_status) && ($gov_text_before_arr->patient_medically_fit_status == $patient_medically_fit_status &&  $patient_medically_fit_status_comment != $gov_text_before_arr->patient_medically_fit_status_comment)) {

                $gov_text_before_arr                                    = CamisIboxBoardRoundMedFit::where('patient_id', '=', $camis_patient_id)->first();
                $updated_data                                           = CamisIboxBoardRoundMedFit::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_medically_fit_status' => $patient_medically_fit_status, 'patient_medically_fit_status_comment' => $patient_medically_fit_status_comment, 'updated_by' => 102, 'patient_med_fit_consultant_name' => $patient_row['camis_consultant_name'] ?? '']);

                $medfit_governance_description                          = $patient_medically_fit_status_comment;


                $functional_identity                                    = 'MedFit Comment';
                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $medfit_history_modal, 1);

                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundMedFit::where('id', '=', $updated_array["id"])->first();
                        $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $medfit_governance_description, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $medfit_history_modal, 2);

                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundMedFit::where('id', '=', $updated_array["id"])->first();
                                $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $medfit_governance_description, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            }
        }


    }


    public function SecondaryAutoLoadCamisDailySummary()
    {

        $common_controller                                  = new CommonController;
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $automated_job_log                                  = array('replication_job_name'   => 'Automated Daily Camis Summary Insert (Secondary)', 'replication_job_start_time' => $process_array['date_time_now']);
        $automated_job_log_id                               = LogReplicationAutomatedJobLogStatus::insertGetId($automated_job_log);
        $this->RemoveOldPotentialDefiniteData();
        $this->RemoveOldPotentialDefiniteDataOutPatient();
        $this->UpdateDischargeDateOnMissedPatient();
        $this->ClearAllowedToMove();
        $this->RemoveIboxBedStatus(); // Remove Outdated Bed Status
        $this->AssignedFlagAlert(); //Assign Auto Flag
        $replication_job_end_time                           = date('Y-m-d H:i:s');
        $automated_job_log                                  = array('replication_job_end_time'   => $replication_job_end_time, 'replication_job_log_status' => 1);
        LogReplicationAutomatedJobLogStatus::where('id', $automated_job_log_id)->update($automated_job_log);
    }


    public function CamisHourlyBedStatusData()
    {

        $common_controller                                  = new CommonController;
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $automated_job_log                                  = array('replication_job_name'   => 'Camis Hourly Bed Status Data', 'replication_job_start_time' => $process_array['date_time_now']);
        $automated_job_log_id                               = LogReplicationAutomatedJobLogStatus::insertGetId($automated_job_log);
        $this->HourlyBedStatusData();
        $replication_job_end_time                           = date('Y-m-d H:i:s');
        $automated_job_log                                  = array('replication_job_end_time'   => $replication_job_end_time, 'replication_job_log_status' => 1);
        LogReplicationAutomatedJobLogStatus::where('id', $automated_job_log_id)->update($automated_job_log);
    }
    public function HourlyBedStatusData()
    {
        $current_hour = Carbon::now('Europe/London')->hour;
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();
        $patient_list                       = CamisIboxWardPatientInformationWithBedDetailsView::with('IboxBedStatus')->whereIn('ibox_ward_id', $wards_ids)->whereIn('ibox_ward_id', $wards_ids)->where('ibox_bed_type', '=', 'Bed')->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();
        $ward_data = array();
        $wards = Wards::whereIn('ward_type_primary', [13, 16, 14])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->orderBy('ward_name', 'asc')->get();
        $wards_to_excludes = Wards::where('ward_bed_matrix_status', 0)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();

        $other_ward = Wards::where('ward_type_primary', 16)->pluck('ward_short_name')->toArray();
        $wards_to_exclude = array_merge($wards_to_excludes, $other_ward);
        foreach ($wards as $ward) {
            $ward_data[$ward->id]['total_bed'] = 0;
            $ward_data[$ward->id]['restricted_bed'] = 0;
            $ward_data[$ward->id]['occupied_bed'] = 0;
            $ward_data[$ward->id]['male_empty_bed'] = 0;
            $ward_data[$ward->id]['female_empty_bed'] = 0;
            $ward_data[$ward->id]['sideroom_empty_bed'] = 0;
            $ward_data[$ward->id]['escalation_empty_bed'] = 0;
        }

        foreach ($patient_list as $patient) {
            $ward_id = $patient['ibox_ward_id'];

            if (!isset($ward_data[$ward_id])) {
                continue;
            }
            if (isset($patient['ward']['status']) && isset($patient['ward']['status']) != 1) {
                continue;
            }

            if (empty($patient['camis_patient_id'])  && !in_array($patient['ibox_ward_short_name'], $wards_to_exclude) && (isset($patient['ibox_bed_status']['status']) && $patient['ibox_bed_status']['status'] == 1)) {
                continue;
            }
            $ward_data[$ward_id]['total_bed']++;

            if (!empty($patient['camis_patient_id'])) {
                $ward_data[$ward_id]['occupied_bed']++;
            }

            if (
                (empty($patient['camis_patient_id']) && isset($patient['ibox_bed_status']['status']) && $patient['ibox_bed_status']['status'] == 2)
            ) {
                $ward_data[$ward_id]['restricted_bed']++;
            }
            if (empty($patient['camis_patient_id']) && $patient['ibox_bed_status_camis'] == 'open' && (strtolower($patient['bay_gender_value']) == strtolower('Male') || empty($patient['bay_gender_value']))) {
                $ward_data[$ward_id]['male_empty_bed']++;
            }

            if (empty($patient['camis_patient_id']) && $patient['ibox_bed_status_camis'] == 'open' && strtolower($patient['bay_gender_value']) == strtolower('Female')) {
                $ward_data[$ward_id]['female_empty_bed']++;
            }

            if (empty($patient['camis_patient_id']) && $patient['ibox_bed_status_camis'] == 'open' && strtolower($patient['bay_gender_value']) == strtolower('Side Room')) {
                $ward_data[$ward_id]['sideroom_empty_bed']++;
            }

            if (empty($patient['camis_patient_id']) && $patient['ibox_bed_status_camis'] == 'open' && $patient['ibox_bed_escalation_status'] == 1) {
                $ward_data[$ward_id]['escalation_empty_bed']++;
            }
        }
        foreach ($ward_data as $ward_id => $value) {
            CamisIboxHourlyBedManagement::updateOrCreate(['ward_id' => $ward_id, 'hour_number' => $current_hour, 'date' => date('Y-m-d')], $value);
        }
    }
    public function CheckWardTypeFunction(&$cron_data, $set_variable, $ward_type_id, $ward_type_ids)
    {
        if (isset($ward_type_ids[$ward_type_id]) && $ward_type_ids[$ward_type_id] != '') {
            $cron_data[$ward_type_ids[$ward_type_id] . $set_variable]++;
        }
    }

    public function CamisWardDailySummaryFunction()
    {
        $date                                   = date('Y-m-d');
        $cron_data                              = array();
        $ward_type                              = array_change_key_case(WardType::whereIn('ward_type', ['Medical', 'Surgical', 'Others', 'Assessment'])->pluck('id', 'ward_type')->toArray(), CASE_LOWER);
        $all_wards                              = Wards::whereIn('ward_type_primary', array_values($ward_type))->select('ward_name', 'ward_shown_name', 'ward_short_name', 'id', 'ward_type_primary', 'ward_nye_bevan_status')->orderBy('ward_short_name', 'ASC')->where('status', '=', 1)->get()->toArray();
        $all_ward_type                          = WardType::get()->toArray();
        $all_inpatient_list                     = CamisIboxWardPatientInformationWithBedDetailsView::with(['BoardRoundEstimatedDischargeDate', 'Ward'])->whereIn('ibox_ward_id', array_column($all_wards, 'id'))->where('ibox_bed_type', '=', 'Bed')->orderBy('camis_patient_ward', 'ASC')->get()->toArray();
        $patient_admission_today_list           = CamisIboxWardPatientInformationWithBedDetailsFullList::with(['Ward'])->whereDate('camis_patient_admission_date', $date)->whereIn('camis_patient_ward_id', array_column($all_wards, 'id'))->orderBy('camis_patient_ward', 'ASC')->get()->toArray();
        $patient_discharge_today_list           = CamisIboxWardPatientInformationWithBedDetailsFullList::with(['Ward'])->whereDate('camis_patient_discharge_date', $date)->whereIn('camis_patient_ward_id', array_column($all_wards, 'id'))->orderBy('camis_patient_ward', 'ASC')->get()->toArray();
        $all_wards_array                        = array_column($all_wards, 'ward_short_name');
        $primary_ward_types                     = ['medical', 'surgical', 'others'];
        $ward_type_ids                          = array();

        if (isset($all_ward_type) && count($all_ward_type) > 0) {
            foreach ($all_ward_type  as $row) {
                if (in_array(strtolower($row['ward_type']), $primary_ward_types)) {
                    $ward_type_ids[$row['id']] = strtolower($row['ward_type']);
                }
            }
        }

        $cron_data['all_ward_inpatients']                         = 0;
        $cron_data['all_ward_admissions']                         = 0;
        $cron_data['all_ward_admission_00_12']                    = 0;
        $cron_data['all_ward_admission_12_16']                    = 0;
        $cron_data['all_ward_admission_16_24']                    = 0;
        $cron_data['all_ward_discharges']                         = 0;
        $cron_data['all_ward_discharge_00_12']                    = 0;
        $cron_data['all_ward_discharge_12_16']                    = 0;
        $cron_data['all_ward_discharge_16_24']                    = 0;
        $cron_data['all_ward_empty']                              = 0;
        $cron_data['all_ward_male_empty']                         = 0;
        $cron_data['all_ward_female_empty']                       = 0;
        $cron_data['all_ward_sr_empty']                           = 0;
        $cron_data['all_ward_los_below_6']                        = 0;
        $cron_data['all_ward_los_7_20']                           = 0;
        $cron_data['all_ward_los_7_13']                           = 0;
        $cron_data['all_ward_los_14_20']                          = 0;
        $cron_data['all_ward_los_over_20']                        = 0;
        $cron_data['all_ward_edd']                                = 0;
        $cron_data['all_ward_edd_1_3']                            = 0;
        $cron_data['all_ward_edd_4_7']                            = 0;
        $cron_data['all_ward_edd_over_8']                         = 0;

        foreach ($primary_ward_types as $ward_type) {
            $cron_data[$ward_type . '_ward_inpatients']                         = 0;
            $cron_data[$ward_type . '_ward_admissions']                         = 0;
            $cron_data[$ward_type . '_ward_admission_00_12']                    = 0;
            $cron_data[$ward_type . '_ward_admission_12_16']                    = 0;
            $cron_data[$ward_type . '_ward_admission_16_24']                    = 0;
            $cron_data[$ward_type . '_ward_discharges']                         = 0;
            $cron_data[$ward_type . '_ward_discharge_00_12']                    = 0;
            $cron_data[$ward_type . '_ward_discharge_12_16']                    = 0;
            $cron_data[$ward_type . '_ward_discharge_16_24']                    = 0;
            $cron_data[$ward_type . '_ward_empty']                              = 0;
            $cron_data[$ward_type . '_ward_male_empty']                         = 0;
            $cron_data[$ward_type . '_ward_female_empty']                       = 0;
            $cron_data[$ward_type . '_ward_sr_empty']                           = 0;
            $cron_data[$ward_type . '_ward_los_below_6']                        = 0;
            $cron_data[$ward_type . '_ward_los_7_20']                           = 0;
            $cron_data[$ward_type . '_ward_los_7_13']                           = 0;
            $cron_data[$ward_type . '_ward_los_14_20']                          = 0;
            $cron_data[$ward_type . '_ward_los_over_20']                        = 0;
            $cron_data[$ward_type . '_ward_edd']                                = 0;
            $cron_data[$ward_type . '_ward_edd_1_3']                            = 0;
            $cron_data[$ward_type . '_ward_edd_4_7']                            = 0;
            $cron_data[$ward_type . '_ward_edd_over_8']                         = 0;
        }


        foreach ($all_wards_array as $ward_name) {
            $cron_data[$ward_name . '_ward_inpatients']                         = 0;
            $cron_data[$ward_name . '_ward_admissions']                         = 0;
            $cron_data[$ward_name . '_ward_admission_00_12']                    = 0;
            $cron_data[$ward_name . '_ward_admission_12_16']                    = 0;
            $cron_data[$ward_name . '_ward_admission_16_24']                    = 0;
            $cron_data[$ward_name . '_ward_discharges']                         = 0;
            $cron_data[$ward_name . '_ward_discharge_00_12']                    = 0;
            $cron_data[$ward_name . '_ward_discharge_12_16']                    = 0;
            $cron_data[$ward_name . '_ward_discharge_16_24']                    = 0;
            $cron_data[$ward_name . '_ward_empty']                              = 0;
            $cron_data[$ward_name . '_ward_male_empty']                         = 0;
            $cron_data[$ward_name . '_ward_female_empty']                       = 0;
            $cron_data[$ward_name . '_ward_sr_empty']                           = 0;
            $cron_data[$ward_name . '_ward_los_below_6']                        = 0;
            $cron_data[$ward_name . '_ward_los_7_20']                           = 0;
            $cron_data[$ward_name . '_ward_los_7_13']                           = 0;
            $cron_data[$ward_name . '_ward_los_14_20']                          = 0;
            $cron_data[$ward_name . '_ward_los_over_20']                        = 0;
            $cron_data[$ward_name . '_ward_edd']                                = 0;
            $cron_data[$ward_name . '_ward_edd_1_3']                            = 0;
            $cron_data[$ward_name . '_ward_edd_4_7']                            = 0;
            $cron_data[$ward_name . '_ward_edd_over_8']                         = 0;
        }

        if (isset($patient_admission_today_list) && count($patient_admission_today_list) > 0) {
            foreach ($patient_admission_today_list  as $row) {
                if (isset($row['camis_patient_id']) && $row['camis_patient_id'] != '') {
                    $cron_data['all_ward_admissions']++;
                    $cron_data[$row['camis_patient_ward'] . '_ward_admissions']++;
                    if (isset($row['ward']['ward_type_primary']) && $row['ward']['ward_type_primary'] != '') {
                        $this->CheckWardTypeFunction($cron_data, '_ward_admissions', $row['ward']['ward_type_primary'], $ward_type_ids);
                    }

                    $admission_date_time                                            = strtotime($row['camis_patient_admission_date_time']);
                    $start_time                                                     = strtotime($date . ' 00:00:00');
                    $end_time                                                       = strtotime($date . ' 11:59:59');

                    if ($admission_date_time >= $start_time && $admission_date_time <= $end_time) {
                        $cron_data['all_ward_admission_00_12']++;
                        $cron_data[$row['camis_patient_ward'] . '_ward_admission_00_12']++;
                        $this->CheckWardTypeFunction($cron_data, '_ward_admission_00_12', $row['ward']['ward_type_primary'], $ward_type_ids);
                    }

                    $start_time                                                     = strtotime($date . ' 12:00:00');
                    $end_time                                                       = strtotime($date . ' 15:59:59');
                    if ($admission_date_time >= $start_time && $admission_date_time <= $end_time) {
                        $cron_data['all_ward_admission_12_16']++;
                        $cron_data[$row['camis_patient_ward'] . '_ward_admission_12_16']++;
                        $this->CheckWardTypeFunction($cron_data, '_ward_admission_12_16', $row['ward']['ward_type_primary'], $ward_type_ids);
                    }

                    $start_time                                                     = strtotime($date . ' 16:00:00');
                    $end_time                                                       = strtotime($date . ' 23:59:59');
                    if ($admission_date_time >= $start_time && $admission_date_time <= $end_time) {
                        $cron_data['all_ward_admission_16_24']++;
                        $cron_data[$row['camis_patient_ward'] . '_ward_admission_16_24']++;
                        $this->CheckWardTypeFunction($cron_data, '_ward_admission_16_24', $row['ward']['ward_type_primary'], $ward_type_ids);
                    }
                }
            }
        }
        if (isset($patient_discharge_today_list) && count($patient_discharge_today_list) > 0) {
            foreach ($patient_discharge_today_list  as $row) {
                if (isset($row['camis_patient_id']) && $row['camis_patient_id'] != '') {
                    $cron_data['all_ward_discharges']++;
                    $cron_data[$row['camis_patient_ward'] . '_ward_discharges']++;
                    if (isset($row['ward']['ward_type_primary']) && $row['ward']['ward_type_primary'] != '') {
                        $this->CheckWardTypeFunction($cron_data, '_ward_discharges', $row['ward']['ward_type_primary'], $ward_type_ids);
                    }

                    $discharge_date_time                                            = strtotime($row['camis_patient_discharge_date_time']);
                    $start_time                                                     = strtotime($date . ' 00:00:00');
                    $end_time                                                       = strtotime($date . ' 11:59:59');
                    if ($discharge_date_time >= $start_time && $discharge_date_time <= $end_time) {
                        $cron_data['all_ward_discharge_00_12']++;
                        $cron_data[$row['camis_patient_ward'] . '_ward_discharge_00_12']++;
                        $this->CheckWardTypeFunction($cron_data, '_ward_discharge_00_12', $row['ward']['ward_type_primary'], $ward_type_ids);
                    }

                    $start_time                                                     = strtotime($date . ' 12:00:00');
                    $end_time                                                       = strtotime($date . ' 15:59:59');
                    if ($discharge_date_time >= $start_time && $discharge_date_time <= $end_time) {
                        $cron_data['all_ward_discharge_12_16']++;
                        $cron_data[$row['camis_patient_ward'] . '_ward_discharge_12_16']++;
                        $this->CheckWardTypeFunction($cron_data, '_ward_discharge_12_16', $row['ward']['ward_type_primary'], $ward_type_ids);
                    }

                    $start_time                                                     = strtotime($date . ' 16:00:00');
                    $end_time                                                       = strtotime($date . ' 23:59:59');
                    if ($discharge_date_time >= $start_time && $discharge_date_time <= $end_time) {
                        $cron_data['all_ward_discharge_16_24']++;
                        $cron_data[$row['camis_patient_ward'] . '_ward_discharge_16_24']++;
                        $this->CheckWardTypeFunction($cron_data, '_ward_discharge_16_24', $row['ward']['ward_type_primary'], $ward_type_ids);
                    }
                }
            }
        }


        if (isset($all_inpatient_list) && count($all_inpatient_list) > 0) {
            foreach ($all_inpatient_list  as $row) {
                if (strtolower($row['ibox_bed_type']) == 'bed') {
                    if (empty($row['camis_patient_id']) && strtolower($row['ibox_bed_status_camis']) == 'open') {
                        $cron_data['all_ward_empty']++;
                        $cron_data[$row['ibox_ward_short_name'] . '_ward_empty']++;
                        $this->CheckWardTypeFunction($cron_data, '_ward_empty', $row['ward']['ward_type_primary'], $ward_type_ids);

                        if (strtolower($row['bay_gender_value']) == 'male') {
                            $cron_data['all_ward_male_empty']++;
                            $cron_data[$row['ibox_ward_short_name'] . '_ward_male_empty']++;
                            $this->CheckWardTypeFunction($cron_data, '_ward_male_empty', $row['ward']['ward_type_primary'], $ward_type_ids);
                        }
                        if (strtolower($row['bay_gender_value']) == 'female') {
                            $cron_data['all_ward_female_empty']++;
                            $cron_data[$row['ibox_ward_short_name'] . '_ward_female_empty']++;
                            $this->CheckWardTypeFunction($cron_data, '_ward_female_empty', $row['ward']['ward_type_primary'], $ward_type_ids);
                        }
                        if (strtolower($row['bay_gender_value']) == 'side room') {
                            $cron_data['all_ward_sr_empty']++;
                            $cron_data[$row['ibox_ward_short_name'] . '_ward_sr_empty']++;
                            $this->CheckWardTypeFunction($cron_data, '_ward_sr_empty', $row['ward']['ward_type_primary'], $ward_type_ids);
                        }
                    } else if (!empty($row['camis_patient_id']) && $row['camis_patient_id'] != '') {
                        $start_time                     = strtotime($row['camis_patient_admission_date']);
                        $end_time                       = time();
                        $length_of_stay                 = (int) abs(round(($end_time - $start_time) / (60 * 60 * 24)));
                        if ($length_of_stay >= 0 && $length_of_stay <= 6) {
                            $cron_data['all_ward_los_below_6']++;
                            $cron_data[$row['ibox_ward_short_name'] . '_ward_los_below_6']++;
                            $this->CheckWardTypeFunction($cron_data, '_ward_los_below_6', $row['ward']['ward_type_primary'], $ward_type_ids);
                        }

                        if ($length_of_stay >= 7 && $length_of_stay <= 20) {
                            $cron_data['all_ward_los_7_20']++;
                            $cron_data[$row['ibox_ward_short_name'] . '_ward_los_7_20']++;
                            $this->CheckWardTypeFunction($cron_data, '_ward_los_7_20', $row['ward']['ward_type_primary'], $ward_type_ids);
                        }


                        if ($length_of_stay >= 7 && $length_of_stay <= 13) {
                            $cron_data['all_ward_los_7_13']++;
                            $cron_data[$row['ibox_ward_short_name'] . '_ward_los_7_13']++;
                            $this->CheckWardTypeFunction($cron_data, '_ward_los_7_13', $row['ward']['ward_type_primary'], $ward_type_ids);
                        }

                        if ($length_of_stay >= 14 && $length_of_stay <= 20) {
                            $cron_data['all_ward_los_14_20']++;
                            $cron_data[$row['ibox_ward_short_name'] . '_ward_los_14_20']++;
                            $this->CheckWardTypeFunction($cron_data, '_ward_los_14_20', $row['ward']['ward_type_primary'], $ward_type_ids);
                        }



                        if ($length_of_stay >= 21) {
                            $cron_data['all_ward_los_over_20']++;
                            $cron_data[$row['ibox_ward_short_name'] . '_ward_los_over_20']++;
                            $this->CheckWardTypeFunction($cron_data, '_ward_los_over_20', $row['ward']['ward_type_primary'], $ward_type_ids);
                        }


                        $cron_data['all_ward_inpatients']++;
                        $cron_data[$row['ibox_ward_short_name'] . '_ward_inpatients']++;
                        $this->CheckWardTypeFunction($cron_data, '_ward_inpatients', $row['ward']['ward_type_primary'], $ward_type_ids);


                        if (isset($row['board_round_estimated_discharge_date']['patient_estimated_discharge_date']) && $row['board_round_estimated_discharge_date']['patient_estimated_discharge_date'] != '') {
                            $edd_date                                   = $row['board_round_estimated_discharge_date']['patient_estimated_discharge_date'];

                            $cron_data['all_ward_edd']++;
                            $cron_data[$row['ibox_ward_short_name'] . '_ward_edd']++;
                            $this->CheckWardTypeFunction($cron_data, '_ward_edd', $row['ward']['ward_type_primary'], $ward_type_ids);



                            $start_time                     = time();
                            $end_time                       = strtotime($edd_date);
                            $edd_over_passed                = (int)round(($start_time - $end_time) / (60 * 60 * 24));
                            if ($edd_over_passed >= 1 && $edd_over_passed <= 3) {
                                $cron_data['all_ward_edd_1_3']++;
                                $cron_data[$row['ibox_ward_short_name'] . '_ward_edd_1_3']++;
                                $this->CheckWardTypeFunction($cron_data, '_ward_edd_1_3', $row['ward']['ward_type_primary'], $ward_type_ids);
                            }
                            if ($edd_over_passed >= 4 && $edd_over_passed <= 7) {
                                $cron_data['all_ward_edd_4_7']++;
                                $cron_data[$row['ibox_ward_short_name'] . '_ward_edd_4_7']++;
                                $this->CheckWardTypeFunction($cron_data, '_ward_edd_4_7', $row['ward']['ward_type_primary'], $ward_type_ids);
                            }
                            if ($edd_over_passed >= 8) {
                                $cron_data['all_ward_edd_over_8']++;
                                $cron_data[$row['ibox_ward_short_name'] . '_ward_edd_over_8']++;
                                $this->CheckWardTypeFunction($cron_data, '_ward_edd_over_8', $row['ward']['ward_type_primary'], $ward_type_ids);
                            }
                        }
                    }
                }
            }
        }
        $admission_count = CamisIboxNyeBevanAdmissionCount::pluck('val', 'keyvalue')->map(function ($value) {
            return (int) $value;
        })->toArray();
        $all_data = array_merge($admission_count, $cron_data);

        $all_data['number_of_tasks_created_in_ibox'] = CamisIboxBoardRoundPatientTasks::select('id')->whereDate('task_estimated_date_for_completion', $date)->count();
        $all_data['number_of_tasks_completed_in_ibox'] = CamisIboxBoardRoundPatientTasks::select('id')->whereDate('task_completed_at', $date)->count();
        $all_data['number_of_patients_seen_via_the_discharge_tracker'] = CamisIboxBoardRoundCDT::select('id')->whereDate('cdt_status', 1)->whereDate('accepted_date', $date)->count();
        $all_data['number_of_comments_added_in_discharge_tracker'] = CamisIboxBoardRoundDtocComment::select('id')->whereDate('date', $date)->count();
        $all_data['how_many_times_the_opel_status_has_changed'] = HistorySymphonyAneOpenStatus::select('history_id')->where('ane_opel_status_data_type', 1)->whereDate('ane_opel_status_data_updated_date_time', $date)->count();
        $all_data['number_of_board_rounds_completed'] = HistoryCamisIboxBoardWardRound::select('history_id')->where('status', 1)->whereDate('updated_at', $date)->count();
        $all_data['number_of_patients_discharged'] = $all_data['all_ward_discharges'];

        $average_discharges_los = 0;
        foreach ($patient_discharge_today_list as $los_total_time) {
            $admission_date = Carbon::parse($los_total_time['camis_patient_admission_date_time']);
            $discharge_date = Carbon::parse($los_total_time['camis_patient_discharge_date_time']);

            $los_days = $discharge_date->diffInDays($admission_date);

            $average_discharges_los += $los_days;
        }

        if (count($patient_discharge_today_list) > 0) {
            $total_avg_outpatient_los = intval($average_discharges_los / count($patient_discharge_today_list));
        } else {
            $total_avg_outpatient_los = 0;
        }
        $all_data['average_los_of_discharged_patients'] = $total_avg_outpatient_los;
        $all_data['number_of_user_logins_per_day'] = GovernanceFrontendUserLoginStatus::whereDate('signin_datetime', $date)->where('login_status', 1)->groupBy('username')->count();
        $all_data['number_of_patient_transfers_internally_between_wards'] = CamisIboxWardHistory::where('admit_dt', '>=', Carbon::now()->subYear())
            ->count();;

        foreach ($all_data as $summary_key => $summary_value) {
            CamisIboxCalculatedDailySummary::updateOrCreate(['date' => $date, 'summary_key' => $summary_key], ['summary_value' => $summary_value, 'updated_by' => 102]);
        }
    }


    public function ReasonToResideDailySummaryData()
    {
        $all_inpatients                                                 = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('camis_patient_id')->toArray();

        $all_reason_to_reside = CamisIboxBoardRoundReasonToReside::with(['ReasonToResideCategory', 'PatientInformationWithBedDetails'])->whereIn('patient_id', $all_inpatients)->get()->toArray();

        $ward_list = Wards::with('PrimaryWardType')->where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->pluck('ward_short_name')->toArray();
        foreach ($ward_list as $ward) {
            $reason_counts[$ward . '_R2R_Function'] = 0;
            $reason_counts[$ward . '_R2R_Physiology'] = 0;
            $reason_counts[$ward . '_R2R_Recovery'] = 0;
            $reason_counts[$ward . '_R2R_Treatment'] = 0;
            $reason_counts[$ward . '_R2R_Primary_Reason_-_Criteria_to_Reside'] = 0;
            $reason_counts[$ward . '_R2R_Rehabilitation._Reablement_And_Recovery_Stage'] = 0;
        }
        $reason_counts['All_Wards_R2R_Function'] = 0;
        $reason_counts['All_Wards_R2R_Physiology'] = 0;
        $reason_counts['All_Wards_R2R_Recovery'] = 0;
        $reason_counts['All_Wards_R2R_Treatment'] = 0;
        $reason_counts['All_Wards_R2R_Primary_Reason_-_Criteria_to_Reside'] = 0;
        $reason_counts['All_Wards_R2R_Rehabilitation._Reablement_And_Recovery_Stage'] = 0;



        foreach ($all_reason_to_reside as $reason_reside) {
            $patient_ward = $reason_reside['patient_information_with_bed_details']['ibox_ward_short_name'];
            if (strtolower($reason_reside['reason_to_reside_category']['reason_to_reside_text_value_category']) == 'function') {
                $reason_counts['All_Wards_R2R_Function']++;
                if (isset($reason_counts[$patient_ward . '_R2R_Function'])) {
                    $reason_counts[$patient_ward . '_R2R_Function']++;
                }
            } elseif (strtolower($reason_reside['reason_to_reside_category']['reason_to_reside_text_value_category']) == 'physiology') {
                $reason_counts['All_Wards_R2R_Physiology']++;
                if (isset($reason_counts[$patient_ward . '_R2R_Physiology'])) {
                    $reason_counts[$patient_ward . '_R2R_Physiology']++;
                }
            } elseif (strtolower($reason_reside['reason_to_reside_category']['reason_to_reside_text_value_category']) == 'recovery') {
                $reason_counts['All_Wards_R2R_Recovery']++;
                if (isset($reason_counts[$patient_ward . '_R2R_Recovery'])) {
                    $reason_counts[$patient_ward . '_R2R_Recovery']++;
                }
            } elseif (strtolower($reason_reside['reason_to_reside_category']['reason_to_reside_text_value_category']) == 'treatment') {
                $reason_counts['All_Wards_R2R_Treatment']++;
                if (isset($reason_counts[$patient_ward . '_R2R_Treatment'])) {
                    $reason_counts[$patient_ward . '_R2R_Treatment']++;
                }
            } elseif (strtolower($reason_reside['reason_to_reside_category']['reason_to_reside_text_value_category']) == strtolower('Primary_Reason_-_Criteria_to_Reside')) {
                $reason_counts['All_Wards_R2R_Primary_Reason_-_Criteria_to_Reside']++;
                if (isset($reason_counts[$patient_ward . '_R2R_Primary_Reason_-_Criteria_to_Reside'])) {
                    $reason_counts[$patient_ward . '_R2R_Primary_Reason_-_Criteria_to_Reside']++;
                }
            } elseif (strtolower($reason_reside['reason_to_reside_category']['reason_to_reside_text_value_category']) == strtolower('Rehabilitation._Reablement_And_Recovery_Stage')) {
                $reason_counts['All_Wards_R2R_Rehabilitation._Reablement_And_Recovery_Stage']++;
                if (isset($reason_counts[$patient_ward . '_R2R_Rehabilitation._Reablement_And_Recovery_Stage'])) {
                    $reason_counts[$patient_ward . '_R2R_Rehabilitation._Reablement_And_Recovery_Stage']++;
                }
            }
        }

        foreach ($reason_counts as $summary_key => $summary_value) {
            CamisIboxCalculatedDailySummary::updateOrCreate(['date' => date('Y-m-d'), 'summary_key' => $summary_key], ['summary_value' => $summary_value, 'updated_by' => 102]);
        }
    }

    public function ClearAllowedToMove()
    {
        $patients      = CamisIboxWardPatientInformationWithBedDetailsView::select('camis_patient_id', 'camis_patient_ward')->with('AllowedToMove')->get()->toArray();
        $ward_controller       = new WardSummaryController;
        foreach ($patients as $patient) {
            if (isset($patient['allowed_to_move']['patient_allowed_to_be_moved_to']) && strtolower($patient['allowed_to_move']['patient_allowed_to_be_moved_to']) == strtolower($patient['camis_patient_ward'])) {

                $ward_controller->RemoveAllowedToBeMovedByPatient($patient['camis_patient_id']);
            }
        }
    }

    public function BedActualName()
    {
        $bed_details = BedDetails::with('bedGroup')->get();

        if (count($bed_details) > 0) {
            foreach ($bed_details as $bed) {
                $bed_data = BedDetails::find($bed->id);
                $actual_bed_full_name = $bed->full_bed_name;

                $bed_data->actual_bed_full_name = $actual_bed_full_name;
                $bed_data->save();
            }

            echo "Bed Actual Name Updated";
        } else {
            echo "Bed Actual Name Already  Updated";
        }
    }

    public function RemoveOldPotentialDefiniteData()
    {
        $yesterday                                      = Carbon::yesterday();
        $rows                                           = CamisIboxBoardRoundPotentialDefinite::with('PatientInformationWithBedDetails')->whereDate('potential_definite_date', '<=', $yesterday)->whereHas('PatientInformationWithBedDetails')->get();
        $pd_history_modal                               = "App\Models\History\HistoryCamisIboxBoardRoundPotentialDefinite";

        $history_modal                                  = "App\Models\History\HistoryCamisIboxBoardRoundMissedPotentialDefinite";


        $pd_functional_identity                            = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_potential_definite", "ibox_governance_frontend_functional_names");
        $functional_identity                               = 'Missed Date Potential/Definite Status';

        $ward_summary                                   = new WardSummaryController();
        $history_controller                             = new HistoryController;
        foreach ($rows as $row) {
            $pd_gov_text_before_arr                                      = $row;

            $history_controller->HistoryTableDataInsertFromUpdateCreate($pd_gov_text_before_arr, $pd_history_modal, 3);
            $pd_gov_text_before                    = $pd_gov_text_before_arr->toArray();


            $ward_summary->GovernanceBoardRoundUpdatePreCall($row->patient_id, $pd_gov_text_before, 'Removed Outdated Potential/Discharge Status', [], $pd_functional_identity, 3);

            unset($pd_gov_text_before['patient_id']);
            unset($pd_gov_text_before['created_at']);
            unset($pd_gov_text_before['updated_at']);
            $pd_gov_text_before['updated_by'] = 102;
            $pd_gov_text_before['name'] = $pd_gov_text_before_arr->PatientInformationWithBedDetails->camis_patient_name ?? '';
            $pd_gov_text_before['ward_id'] = $pd_gov_text_before_arr->PatientInformationWithBedDetails->camis_patient_ward_id ?? 0;
            $pd_gov_text_before['bed'] = $pd_gov_text_before_arr->PatientInformationWithBedDetails->ibox_actual_bed_full_name ?? '';
            $pd_gov_text_before['pas_number'] = $pd_gov_text_before_arr->PatientInformationWithBedDetails->camis_patient_pas_number ?? '';
            if (isset($pd_gov_text_before_arr->PatientInformationWithBedDetails->camis_patient_discharge_date_time) && !empty($pd_gov_text_before_arr->PatientInformationWithBedDetails->camis_patient_discharge_date_time)) {
                $pd_gov_text_before['discharge_date'] = $pd_gov_text_before_arr->PatientInformationWithBedDetails->camis_patient_discharge_date_time;
            }
            unset($pd_gov_text_before['patient_information_with_bed_details']);
            $gov_text_before_arr                                    = CamisIboxBoardRoundMissedPotentialDefinite::where('patient_id', '=', $row->patient_id)->first();

            $updated_data                                           = CamisIboxBoardRoundMissedPotentialDefinite::updateOrCreate(['patient_id' => $row->patient_id], $pd_gov_text_before);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);


            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundMissedPotentialDefinite::where('id', '=', $updated_array["id"])->first();
                    $ward_summary->GovernanceBoardRoundUpdatePreCall($row->patient_id, $gov_text_before, 'Added As Missed PD', $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundMissedPotentialDefinite::where('id', '=', $updated_array["id"])->first();
                            $ward_summary->GovernanceBoardRoundUpdatePreCall($row->patient_id, $gov_text_before, 'Added As Missed PD', $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }


        }
    }

    public function RemoveOldPotentialDefiniteDataOutPatient()
    {
        $yesterday                                      = Carbon::yesterday();
        $rows                                           = CamisIboxBoardRoundPotentialDefinite::whereDate('potential_definite_date', '<=', $yesterday)->whereDoesntHave('PatientInformationWithBedDetails')->get();
        $pd_history_modal                               = "App\Models\History\HistoryCamisIboxBoardRoundPotentialDefinite";



        $pd_functional_identity                            = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_potential_definite", "ibox_governance_frontend_functional_names");

        $ward_summary                                   = new WardSummaryController();
        $history_controller                             = new HistoryController;
        foreach ($rows as $row) {
            $pd_gov_text_before_arr                                      = $row;

            $history_controller->HistoryTableDataInsertFromUpdateCreate($pd_gov_text_before_arr, $pd_history_modal, 3);
            $pd_gov_text_before                    = $pd_gov_text_before_arr->toArray();


            $ward_summary->GovernanceBoardRoundUpdatePreCall($row->patient_id, $pd_gov_text_before, 'Removed Outdated Potential/Discharge Status', [], $pd_functional_identity, 3);




        }
    }

    public function UpdateDischargeDateOnMissedPatient()
    {
        $rows                                           = CamisIboxBoardRoundMissedPotentialDefinite::with('PatientInformation')->whereNull('discharge_date')->get();

        $history_modal                                  = "App\Models\History\HistoryCamisIboxBoardRoundMissedPotentialDefinite";


        $functional_identity                               = 'Missed Date Potential/Definite Status';

        $ward_summary                                   = new WardSummaryController();
        $history_controller                             = new HistoryController;
        foreach ($rows as $row) {


            if (!isset($row->PatientInformation->camis_patient_discharge_date_time) || empty($row->PatientInformation->camis_patient_discharge_date_time)) {

                continue;
            }

            $pd_gov_text_before_arr                                      = $row;


            if (Carbon::parse($row->PatientInformation->camis_patient_discharge_date_time)
                ->isSameDay(Carbon::parse($row->potential_definite_date))
            ) {
                $gov_text_before_arr                                      = $row;
                $history_controller->HistoryTableDataInsertFromUpdateCreate($gov_text_before_arr, $history_modal, 3);
                $gov_text_before                    = $gov_text_before_arr->toArray();
                $gov_text_after_arr                 = [];
                $ward_summary->GovernanceIboxDataPreCall($gov_text_after_arr, 'Bed Status Update', $gov_text_before, 3);
                $gov_text_before_arr->delete();
            } else {
                $gov_text_before_arr                                    = CamisIboxBoardRoundMissedPotentialDefinite::where('patient_id', '=', $row->patient_id)->first();

                $updated_data                                           = CamisIboxBoardRoundMissedPotentialDefinite::updateOrCreate(['patient_id' => $row->patient_id], ['discharge_date' => $row->PatientInformation->camis_patient_discharge_date_time, 'ward_id' => $row->PatientInformation->camis_patient_ward_id ?? 0, 'updated_by' => 102]);
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);


                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);

                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundMissedPotentialDefinite::where('id', '=', $updated_array["id"])->first();
                        $ward_summary->GovernanceBoardRoundUpdatePreCall($row->patient_id, $gov_text_before, 'Discharge Dated Added On Failed PD', $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {

                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundMissedPotentialDefinite::where('id', '=', $updated_array["id"])->first();
                                $ward_summary->GovernanceBoardRoundUpdatePreCall($row->patient_id, $gov_text_before, 'Added As Missed PD', $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            }
        }
    }

    public function RemoveIboxBedStatus()
    {
        $all_bed = CamisIboxBoardRoundBedStatus::with('PatientInformationWithBedDetails')->get()->toArray();
        $history_modal = "App\Models\History\HistoryCamisIboxBoardRoundBedStatus";
        $history_controller                                 = new HistoryController;
        $ward_summary                       = new WardSummaryController();
        foreach ($all_bed as $row) {
            if (isset($bed['patient_information_with_bed_details']['camis_patient_id']) && !empty($bed['patient_information_with_bed_details']['camis_patient_id'])) {

                $gov_text_before_arr                                      = $row;
                $history_controller->HistoryTableDataInsertFromUpdateCreate($gov_text_before_arr, $history_modal, 3);
                $gov_text_before                    = $gov_text_before_arr->toArray();
                $gov_text_after_arr                 = [];
                $ward_summary->GovernanceIboxDataPreCall($gov_text_after_arr, 'Bed Status Update', $gov_text_before, 3);
                $gov_text_before_arr->delete();
            }
        }
    }


    public function MedFitPathwaySummary()
    {
        $cdt_patients = CamisIboxBoardRoundCDT::where('cdt_status', 1)->pluck('patient_id')->toArray();
        $base_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $cdt_patients)->where('disabled_on_all_dashboard_except_ward_summary', 0)->whereNull('camis_patient_discharge_date_time')
            ->select('camis_patient_id')
            ->where('ibox_bed_type', 'Bed')
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->whereNull('camis_patient_discharge_date_time')
            ->with([
                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment', 'updated_at');
                },

            ])


            ->get()->toArray();

        $medfit_yes_patients = array_filter($base_query, function ($patient) {
            return !empty($patient['board_round_medically_fit_data']) &&
                $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1;
        });

        $camis_patient_ids = array_column(array_filter($medfit_yes_patients, function ($item) {
            return isset($item['camis_patient_id']);
        }), 'camis_patient_id');

        $query = CamisIboxBoardRoundPathwayRequirement::selectRaw('dtoc_service_text,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 0%" THEN 1 ELSE 0 END) as p0,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 1%" THEN 1 ELSE 0 END) as p1,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 2%" THEN 1 ELSE 0 END) as p2,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 3%" THEN 1 ELSE 0 END) as p3,
            COUNT(*) as total')
            ->whereIn('patient_id', $camis_patient_ids)
            ->groupBy('dtoc_service_text');

        $results = $query->get();
        $results_data = [];
        foreach ($results as $result) {
            $service = !empty($result->dtoc_service_text) ? $result->dtoc_service_text : 'No Authority Assigned';
            $results_data[$service]['pathway_0'] = $result->p0;
            $results_data[$service]['pathway_1'] = $result->p1;
            $results_data[$service]['pathway_2'] = $result->p2;
            $results_data[$service]['pathway_3'] = $result->p3;
        }
        $all_inpatients                                                 = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('camis_patient_id')->toArray();
        $cdt_count = CamisIboxBoardRoundCDT::whereIn('cdt_status', [0])->whereIn('patient_id', $all_inpatients)->get()->toArray();
        $results_data['cdt']['cdt_patients'] = count($cdt_count);
        foreach ($results_data as $authority => $value) {
            CamisIboxDtocMonthlyStored::updateOrCreate(['date' => date('Y-m-d'), 'authority' => $authority], $value);
        }
    }


    public function AssignedFlagAlert()
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPatientFlag";
        $ward_summary                                               = new WardSummaryController();
        $flag_short_name = [1 => 'ibox_patient_flag_dementia', 2 => 'ibox_patient_flag_diabetic', 3 => 'ibox_patient_flag_end_of_life', 4 => 'ibox_patient_flag_palliative_care'];

        $patients = CamisIboxInpatientFlagAlertDetails::get()->toArray();
        $all_patients = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->pluck('camis_patient_ward_id', 'camis_patient_id')->toArray();
        $current_patient_id = array_column($patients, 'camis_patient_id');

        $current_patient_flag = CamisIboxBoardRoundPatientFlag::whereIn('patient_id', $current_patient_id)->whereIn('patient_flag_name', array_values($flag_short_name))->where('patient_flag_status_value', 1)->select('patient_id', 'patient_flag_name')->get()->toArray();

        $patient_flags = collect($current_patient_flag)
            ->groupBy('patient_id')
            ->map(fn($items) => $items->pluck('patient_flag_name')->values())
            ->toArray();
        foreach ($patients as $patient) {
            $camis_patient_id = $patient['camis_patient_id'];
            $patient_flag_name = $flag_short_name[$patient['alert_status']];

            if (isset($patient_flags[$camis_patient_id]) && in_array($patient_flag_name, $patient_flags[$camis_patient_id])) {
                continue;
            }

            $patient_flag_status_value                                  = 1;
            $user_id                                                    = 102;


            if ($camis_patient_id != "" && $user_id != "") {
                $updated_data                                           = CamisIboxBoardRoundPatientFlag::updateOrCreate(['patient_id' => $camis_patient_id, 'patient_flag_name' => $patient_flag_name], ['patient_flag_status_value' => $patient_flag_status_value, 'patient_flag_extra_details' => json_encode(array()), 'flag_created_by' => $user_id, 'flag_created_ward' => $all_patients[$camis_patient_id] ?? 0, 'flag_updated_ward' => $all_patients[$camis_patient_id] ?? 0, 'updated_by' => $user_id]);

                $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_patient_flag", "ibox_governance_frontend_functional_names");
                $flag_set_name                                          = '';
                $master_flag_data                                       = BoardRoundFlagList::where('patient_flag_stored_name', '=', $patient_flag_name)->first();

                if (isset($master_flag_data->id) && $master_flag_data->id != '') {
                    $flag_set_name                                      = $master_flag_data->patient_flag_name;
                }


                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();

                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundPatientFlag::where('id', '=', $updated_array["id"])->first();
                    $ward_summary->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $flag_set_name, $gov_text_after_arr, $functional_identity, 1);
                }
            }
        }
    }

    public function TaskSummaryAutoInsert()
    {
        $common_controller                                  = new CommonController;
        $history_controller                                 = new HistoryController;
        $ward_summary                                       = new WardSummaryController();
        $history_modal                                      = "App\Models\History\HistoryCamisIboxDPTaskDailySummary";
        $auto_user_id                                       = 0;
        $process_array                                      = array();
        $success_array                                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $date = date('Y-m-d');

        $last_job_run_details                               = LogReplicationAutomatedJobLogStatus::where('replication_job_name', '=', 'Automated Daily DP Task Summary Insert')->orderBy('id', 'desc')->first();
        $last_job_time_diff                                 = 10;
        if (isset($last_job_run_details['replication_job_start_time']) && $last_job_run_details['replication_job_start_time'] != '') {
            $start_time                                     = strtotime($last_job_run_details['replication_job_start_time']);
            $end_time                                       = strtotime(date('Y-m-d H:i:s'));
            $last_job_time_diff                             = ($end_time - $start_time) / 60;
        }
        if ($last_job_time_diff > 3) {


            $automated_job_log                                  = array('replication_job_name'   => 'Automated Daily DP Task Summary Insert', 'replication_job_start_time' => $process_array['date_time_now']);
            $automated_job_log_id                               = LogReplicationAutomatedJobLogStatus::insertGetId($automated_job_log);
            $all_wards = Wards::where('status', 1)->pluck('ward_url_name', 'id')->toArray();

            foreach ($all_wards as $ward_id => $ward) {
                $records                                        = CamisIboxBoardRoundPatientTasks::where('task_created_ward', $ward_id)->where('task_category', 6)->whereDate('task_created_at', $date)->select('id', 'patient_id', 'task_dp_status_order_value', 'task_completed_status', 'task_extra_data', 'task_description', 'task_estimated_date_for_completion', 'task_not_applicable_status', 'task_created_at', 'task_completed_at')->get()->toArray();



                $records_complete                                        = CamisIboxBoardRoundPatientTasks::where('task_created_ward', $ward_id)->whereIn('task_category', [6, 7, 8])->where('task_completed_status', 1)->whereDate('task_completed_at', $date)->select('patient_id', 'task_dp_status_order_value', 'task_completed_status', 'task_extra_data', 'task_description', 'task_estimated_date_for_completion', 'task_not_applicable_status', 'task_created_at', 'task_completed_at')->get()->toArray();

                $not_applicable_count                                       = CamisIboxBoardRoundPatientTasks::where('task_created_ward', $ward_id)->where('task_category', 6)->where('task_not_applicable_status', 1)->whereDate('task_not_applicable_at', $date)->select('patient_id', 'task_dp_status_order_value', 'task_completed_status', 'task_extra_data', 'task_description', 'task_estimated_date_for_completion', 'task_not_applicable_status', 'task_created_at', 'task_completed_at')->get()->toArray();




                $number_of_task_created = count($records);

                $series_of_task_list = [];
                if (count($records) > 0) {
                    foreach ($records as $all_task) {
                        $dp_order = $all_task['task_dp_status_order_value'] ?? 0;
                        $series_of_task_list[$all_task['patient_id']][$dp_order][] = $all_task;
                    }
                }

                $series_of_task_created = 0;

                foreach ($series_of_task_list as $patient_id => $task_data) {
                    $series_of_task_created += count($task_data);
                }

                $total_series_complete = 0;
                $total_series_complete_12_hr = 0;
                $completed_task_series = [];
                foreach ($records_complete as $complete) {
                    $dp_order = $complete['task_dp_status_order_value'] ?? 0;
                    $patient_id = $complete['patient_id'];
                    $created_at = Carbon::parse($complete['task_created_at']);
                    $completed_at = Carbon::parse($complete['task_completed_at']);
                    if (
                        isset($complete['task_extra_data'], $complete['task_description'], $complete['task_created_at'])
                        && !empty($complete['task_extra_data'])
                    ) {
                        $escalation_json = json_decode($complete['task_extra_data'], true);

                        if (
                            isset($escalation_json['escalation_status'])
                            && strtolower($escalation_json['escalation_status']) == 'no'
                            && isset($complete['task_description']) && strtolower($complete['task_description']) == 'escalation status'
                            && isset($complete['task_created_at'])
                        ) {
                            $total_series_complete++;

                            if ($created_at->diffInHours($completed_at) <= 12) {
                                $total_series_complete_12_hr++;
                            }
                            continue;
                        }
                    }


                    $completed_task_series[$patient_id][] = $dp_order;
                }
                $firstKeys = [];
                $secondKeys = [];
                if (count($completed_task_series) > 0) {

                    foreach ($completed_task_series as $patient_id => $task_data) {
                        array_push($firstKeys, $patient_id);
                        foreach ($task_data as $key => $value) {
                            array_push($secondKeys, $value);
                        }
                    }
                }


                if (count($firstKeys) > 0) {
                    $query = CamisIboxBoardRoundPatientTasks::where('task_created_ward', $ward_id)
                        ->where('task_not_applicable_status', '!=', 1)
                        ->whereIn('patient_id', $firstKeys)
                        ->whereIn('task_dp_status_order_value', $secondKeys)
                        ->whereIn('task_category', [6, 7, 8])->select('id', 'patient_id', 'task_dp_status_order_value', 'task_completed_status', 'task_extra_data', 'task_description', 'task_estimated_date_for_completion', 'task_not_applicable_status', 'task_created_at', 'task_completed_at')->get()->toArray();



                    $all_completed_dp_task = [];
                    if (count($query) > 0) {
                        foreach ($query as $task_query) {
                            $dp_order = $task_query['task_dp_status_order_value'] ?? 0;
                            $patient_id = $task_query['patient_id'];


                            if (
                                isset($task_query['task_extra_data'], $task_query['task_description'], $task_query['task_created_at'])
                                && !empty($task_query['task_extra_data'])
                            ) {
                                $escalation_json = json_decode($task_query['task_extra_data'], true);

                                if (
                                    isset($escalation_json['escalation_status'])
                                    && strtolower($escalation_json['escalation_status']) == 'no'
                                    && isset($task_query['task_description']) && strtolower($task_query['task_description']) == 'escalation status'
                                    && isset($task_query['task_created_at'])
                                ) {

                                    continue;
                                }
                            }




                            $all_completed_dp_task[$patient_id][$dp_order][] = $task_query;
                        }
                    }



                    if (count($all_completed_dp_task) > 0) {
                        foreach ($all_completed_dp_task as $patientId => $sets) {
                            foreach ($sets as $setNo => $tasks) {
                                $hasIncomplete = false;

                                foreach ($tasks as $task) {
                                    if (isset($task['task_completed_status']) && (int)$task['task_completed_status'] === 0) {
                                        $hasIncomplete = true;
                                        break;
                                    }
                                }

                                if ($hasIncomplete) {
                                    unset($all_completed_dp_task[$patientId][$setNo]);
                                }
                            }

                            if (empty($all_completed_dp_task[$patientId])) {
                                unset($all_completed_dp_task[$patientId]);
                            }
                        }
                    }
                    if (count($all_completed_dp_task) > 0) {
                        foreach ($all_completed_dp_task as $dp_task_key => $dp_task_value) {

                            if (isset($all_completed_dp_task[$dp_task_key]) && count($all_completed_dp_task[$dp_task_key]) > 0) {
                                $total_series_complete += count($all_completed_dp_task[$dp_task_key]);

                                $task_set = $all_completed_dp_task[$dp_task_key] ?? [];
                                foreach ($task_set as $task_entry) {
                                    if (count($task_entry) > 0) {
                                        usort($task_entry, function ($a, $b) {
                                            return strtotime($b['task_completed_at']) <=> strtotime($a['task_completed_at']);
                                        });
                                    }
                                    if (isset($task_entry[0]['task_created_at']) && isset($task_entry[0]['task_completed_at'])) {
                                        $created_at = Carbon::parse($task_entry[0]['task_created_at']);
                                        $completed_at = Carbon::parse($task_entry[0]['task_completed_at']);
                                        if ($created_at->diffInHours($completed_at) <= 12) {
                                            $total_series_complete_12_hr++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }




                $gov_text_before_arr                                    = CamisIboxDPTaskDailySummary::where('ward_id', $ward)->whereDate('date', $date)->first();
                $updated_data                                           = CamisIboxDPTaskDailySummary::updateOrCreate(['ward_id' => $ward, 'date' => $date], ['dp_task_list_count' => $series_of_task_created, 'dp_task_list_completed_count' => $total_series_complete, 'completed_in_tweleve_hr' => $total_series_complete_12_hr,  'dp_task_list_task_count' => $number_of_task_created, 'dp_task_list_task_completed_count' => count($records_complete), 'dp_task_list_task_not_applicable_count' => count($not_applicable_count), 'updated_by' => $auto_user_id]);
                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxDPTaskDailySummary::where('id', '=', $updated_array["id"])->first();
                        $ward_summary->GovernanceIboxDataPreCall($gov_text_before, 'DP Task Summary Daily Task Insert For ' . $date, $gov_text_after_arr, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxDPTaskDailySummary::where('id', '=', $updated_array["id"])->first();
                                $ward_summary->GovernanceIboxDataPreCall($gov_text_before, 'DP Task Summary Daily Task Updated For ' . $date, $gov_text_after_arr, 2);
                            }
                        }
                    }
                }
            }
            $replication_job_end_time                           = date('Y-m-d H:i:s');
            $automated_job_log                                  = array('replication_job_end_time'   => $replication_job_end_time, 'replication_job_log_status' => 1);
            LogReplicationAutomatedJobLogStatus::where('id', $automated_job_log_id)->update($automated_job_log);
        }
    }

    public function RemoveNurseConcernFlagsForSAU()
    {
        $user_id = 102;
        $ward_controller       = new WardSummaryController;
        $patients              = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_ward', 'rltsauip')->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('camis_patient_id')->toArray();
        $ccu_dp_tasks          = CamisIboxBoardRoundPatientTasks::whereIn('patient_id', $patients)->where('task_category', 6)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->get()->toArray();
        $ccu_dp_flags          = CamisIboxBoardRoundPatientFlag::whereIn('patient_id', $patients)->where('patient_flag_name', 'ibox_patient_flag_nurse_concern')->pluck('patient_id')->toArray();

        foreach ($patients as $patient) {
            $task_to_remove = array_filter($ccu_dp_tasks, function ($item) use ($patient) {
                return ($item['patient_id'] == $patient);
            });


            $z = 1;
            if (count($task_to_remove) > 0) {
                foreach ($task_to_remove as $remove_task) {
                    $task_remove_arr[$z]['task_id']                                 = $remove_task['id'];
                    $task_remove_arr[$z]['task_not_applicable_status']              = 1;
                    $task_remove_arr[$z]['task_not_applicable_by']                  = $user_id;
                    $task_remove_arr[$z]['task_not_applicable_ward']                = 42;
                    $task_remove_arr[$z]['task_not_applicable_at']                  = CurrentDateOnFormat();
                    $z++;
                }


                $ward_controller->WardSummaryPatientTaskInsert($task_remove_arr, $patient);
            }

            if (in_array($patient, $ccu_dp_flags)) {
                $ward_controller->RemoveNurseConcernFlagAction($patient);
            }
        }
    }

    public function AutoLoadCamisPatientFlagAssign()
    {
        $common_controller                                  = new CommonController;
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);

        $last_job_run_details                               = LogReplicationAutomatedJobLogStatus::where('replication_job_name', '=', 'Automated Patient Flag Assign')->orderBy('id', 'desc')->first();
        $last_job_time_diff                                 = 10;
        if (isset($last_job_run_details['replication_job_start_time']) && $last_job_run_details['replication_job_start_time'] != '') {
            $start_time                                     = strtotime($last_job_run_details['replication_job_start_time']);
            $end_time                                       = strtotime(date('Y-m-d H:i:s'));
            $last_job_time_diff                             = ($end_time - $start_time) / 60;
        }
        if ($last_job_time_diff > 3) {
            $automated_job_log                                  = array('replication_job_name'   => 'Automated Patient Flag Assign', 'replication_job_start_time' => $process_array['date_time_now']);
            $automated_job_log_id                               = LogReplicationAutomatedJobLogStatus::insertGetId($automated_job_log);
            $in_patient_list                                    = CamisIboxWardPatientInformationWithBedDetailsView::with(['Ward', 'PatientVitalPacInfo', 'PatientWiseFlags', 'PatientWiseFlags.PatientFlagList', 'BoardRoundPatientTasks', 'BoardRoundPatientTasks.PatientTaskGroup', 'BoardRoundPatientTasks.PatientTaskCategory'])->where('camis_patient_id', '<>', null)->where('ibox_bed_type', '=', 'Bed')->where('camis_patient_ward_id', '<>', null)->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();
            if (count($in_patient_list) > 0) {
                foreach ($in_patient_list as $patient) {
                    if ($patient['camis_patient_id'] != '' && $patient['ibox_bed_type'] == 'Bed') {
                        if (isset($patient['ward']['status']) && $patient['ward']['status'] == 1) {
                            $this->CodeRedFlagAssign($patient);
                        }
                    }
                }
            }
            $replication_job_end_time                           = date('Y-m-d H:i:s');
            $automated_job_log                                  = array('replication_job_end_time'   => $replication_job_end_time, 'replication_job_log_status' => 1);
            LogReplicationAutomatedJobLogStatus::where('id', $automated_job_log_id)->update($automated_job_log);
        }
    }

    public function CodeRedFlagAssign($patient)
    {
        if (isset($patient['patient_vital_pac_info']['totalews']) && $patient['patient_vital_pac_info']['totalews'] >= 5) {

            if (isset($patient['patient_vital_pac_info']['time_started_obs']) && !empty($patient['patient_vital_pac_info']['time_started_obs'])) {
                $vital_pac_time_of_reading          = strtotime($patient['patient_vital_pac_info']['time_started_obs']);
                if (isset($patient['camis_patient_ward']) && strtolower($patient['camis_patient_ward']) != 'critc') {

                    $pending_dp_task = ArrayFilter($patient['board_round_patient_tasks'], function ($task) {
                        return (in_array($task['task_category'], [6, 7, 8]) && $task['task_completed_status'] == 0 && $task['task_not_applicable_status'] == 0);
                    });

                    $complete_or_na_dp_task = ArrayFilter($patient['board_round_patient_tasks'], function ($task) {
                        return (in_array($task['task_category'], [6, 7, 8]) && ($task['task_completed_status'] == 1 || $task['task_not_applicable_status'] == 1));
                    });
                    if (count($complete_or_na_dp_task) > 0) {
                        usort($complete_or_na_dp_task, function ($a, $b) {
                            return strtotime($b['updated_at']) <=> strtotime($a['updated_at']);
                        });

                        $latest_task = strtotime($complete_or_na_dp_task[0]['updated_at']);
                    } else {
                        $latest_task = '';
                    }

                    $each_patient_assigned_flag_title_array = array();
                    if (isset($patient['patient_wise_flags']) && count($patient['patient_wise_flags']) > 0) {
                        foreach ($patient['patient_wise_flags'] as $row_flags_title) {
                            if (isset($row_flags_title['patient_flag_name']) && $row_flags_title['patient_flag_name']) {
                                $each_patient_assigned_flag_title_array[] = $row_flags_title['patient_flag_name'];
                            }
                        }
                    }

                    if (!in_array('ibox_patient_flag_covid_dp', $each_patient_assigned_flag_title_array)) {


                        $check_patient_dp_status = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $patient['camis_patient_id'])->first();
                        if (isset($check_patient_dp_status['patient_id']) && $check_patient_dp_status['patient_id'] != '') {

                            if (isset($check_patient_dp_status['type']) && $check_patient_dp_status['type'] == 4 && isset($check_patient_dp_status['updated_at']) && $check_patient_dp_status['updated_at'] != '') {

                                $discharge_to_ward_timing          = strtotime($check_patient_dp_status['updated_at']);
                                if (($vital_pac_time_of_reading - $discharge_to_ward_timing) >= 0) {
                                    $this->AssignCodeRedFlag($patient['camis_patient_id'], 102, $patient['camis_patient_ward_id']);
                                    $each_patient_assigned_flag_title_array[] = 'ibox_patient_flag_covid_dp';
                                }
                            }
                        } else {
                            $this->AssignCodeRedFlag($patient['camis_patient_id'], 102, $patient['camis_patient_ward_id']);
                            $each_patient_assigned_flag_title_array[] = 'ibox_patient_flag_covid_dp';
                        }
                    }
                    if (in_array('ibox_patient_flag_covid_dp', $each_patient_assigned_flag_title_array) && count($pending_dp_task) == 0 && (empty($latest_task) || ($vital_pac_time_of_reading - $latest_task) >= 24 * 60 * 60)) {
                        $this->AssignDPTaskList($patient['camis_patient_id'], 102);
                    }
                }
            }
        }
    }


    function AssignCodeRedFlag($camis_patient_id, $user_id = 102, $ward_id)
    {
        $ward_controller                                            = new WardSummaryController;
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPatientFlag";
        $date_time_now                                              = CurrentDateOnFormat();
        $patient_flag_name                                          = 'ibox_patient_flag_covid_dp';
        $patient_flag_status_value                                  = 1;
        if ($camis_patient_id != "" && $user_id != "") {

            $gov_text_before_arr                                    = CamisIboxBoardRoundPatientFlag::where('patient_id', '=', $camis_patient_id)->where('patient_flag_name', $patient_flag_name)->first();
            $updated_data                                           = CamisIboxBoardRoundPatientFlag::updateOrCreate(['patient_id' => $camis_patient_id, 'patient_flag_name' => $patient_flag_name], ['patient_flag_status_value' => $patient_flag_status_value, 'patient_flag_extra_details' => json_encode(array()), 'flag_created_by' => $user_id, 'flag_created_ward' => $ward_id, 'flag_updated_ward' => $ward_id, 'updated_by' => $user_id]);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_patient_flag", "ibox_governance_frontend_functional_names");
            $flag_set_name                                          = '';
            $master_flag_data                                       = BoardRoundFlagList::where('patient_flag_stored_name', '=', $patient_flag_name)->first();
            if (isset($master_flag_data->id) && $master_flag_data->id != '') {
                $flag_set_name                                      = $master_flag_data->patient_flag_name;
            }

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();

                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundPatientFlag::where('id', '=', $updated_array["id"])->first();
                    $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $flag_set_name, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundPatientFlag::where('id', '=', $updated_array["id"])->first();
                            $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $flag_set_name, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $sd_flags   = CamisIboxBoardRoundPatientFlag::where('patient_id', $camis_patient_id)->where('patient_flag_name', 'ibox_patient_flag_stepdown')->first();
            if ($sd_flags != null) {
                $sd_flags->delete();
            }
            $check_patient_dp_status = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $camis_patient_id)->first();

            $history_controller                                         = new HistoryController;
            $history_modal                                              = "App\Models\History\HistoryCamisDPVirtualPatientData";
            $date_time_now                                              = CurrentDateOnFormat();
            $type                                                       = 1;

            if (isset($check_patient_dp_status->type) && $check_patient_dp_status->type != '' && $check_patient_dp_status->type != 0) {
                $type = $check_patient_dp_status->type;
            }
            if ($type == 4 || $type == 5) {
                $type = 1;
            }

            if ($camis_patient_id != "" && $user_id != "") {
                $gov_text_before_arr                                    = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $camis_patient_id)->first();
                $updated_data                                           = CamisIboxDPVirtualWardPatientStatus::updateOrCreate(['patient_id' => $camis_patient_id], ['type' => $type, 'updated_by' => $user_id, 'entry_type' => 3, 'dp_virtual_ward_entry_time' => $date_time_now]);
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
                $functional_identity                                    = 'DP Virtual Ward Data';

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {

                        $gov_text_after_arr                             = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                        $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Admitted To Deteriorating Patients', $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                                $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Admitted To Deteriorating Patients', $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            }
        }
    }


    function AssignDPTaskList($camis_patient_id, $user_id = 102)
    {
        $ward_controller                                        = new WardSummaryController;
        $dp_task_list                                           = DpTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->orderBy('id', 'asc')->get()->toArray();
        $task_create_arr                                        = array();
        $x                                                      = 1;
        $patient_details                                        = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $camis_patient_id)->first();
        $last_dp_flag                                           = CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->where('task_category', 6)->orderBy('task_dp_status_order_value', 'desc')->first();
        if ($last_dp_flag) {
            $dp_value = $last_dp_flag->task_dp_status_order_value + 1;
        } else {
            $dp_value = 1;
        }
        foreach ($dp_task_list as $patient_task) {
            $task_create_arr[$x]['task_id']                                 = '';
            $task_create_arr[$x]['patient_id']                              = $camis_patient_id;
            $task_create_arr[$x]['task_group']                              = $patient_task['user_task_group'];
            $task_create_arr[$x]['task_comment']                            = '';
            $task_create_arr[$x]['task_priority']                           = 0;
            $task_create_arr[$x]['task_daily']                              = 0;
            $task_create_arr[$x]['task_category']                           = 6;
            $task_create_arr[$x]['task_dp_status_order_value']              = $dp_value;
            $task_create_arr[$x]['task_description']                        = $patient_task['auto_populate_task_name'];
            $task_create_arr[$x]['task_estimated_date_for_completion']      = CurrentDateOnFormat();
            $task_create_arr[$x]['task_updated_by']                         = $user_id;
            $task_create_arr[$x]['task_updated_ward']                       = $patient_details->ibox_ward_id;
            $task_create_arr[$x]['task_updated_at']                         = CurrentDateOnFormat();
            $task_create_arr[$x]['task_created_by']                         = $user_id;
            $task_create_arr[$x]['task_created_ward']                       = $patient_details->ibox_ward_id;
            $task_create_arr[$x]['task_created_at']                         = CurrentDateOnFormat();
            $task_create_arr[$x]['created_at']                              = CurrentDateOnFormat();
            $task_create_arr[$x]['updated_at']                              = CurrentDateOnFormat();
            $x++;
        }

        $ward_controller->WardSummaryPatientTaskInsert($task_create_arr, $camis_patient_id);
    }

    public function UpdateInfectionControlRisk()
    {
        $processed = 0;
        $inserted = 0;
        $skipped = 0;
        $errors = [];

        CamisIboxBoardRoundPatientFlag::where('patient_flag_name', 'ibox_patient_flag_infection_risk')
            ->orderBy('id')
            ->chunk(200, function ($flags) use (&$processed, &$inserted, &$skipped, &$errors) {

                foreach ($flags as $flag) {
                    $processed++;
                    $patientId = (string) $flag->patient_id;

                    if (CamisIboxBoardRoundInfectionRisk::where('patient_id', $patientId)->exists()) {
                        $skipped++;
                        continue;
                    }

                    $items = [];

                    if (!empty($flag->patient_flag_extra_details)) {
                        $decoded = @json_decode($flag->patient_flag_extra_details, true);

                        if (is_array($decoded)) {
                            $isIndexed = array_keys($decoded) === range(0, count($decoded) - 1);
                            if ($isIndexed) {
                                foreach ($decoded as $entry) {
                                    $entryArr = is_string($entry) ? @json_decode($entry, true) : $entry;
                                    if (is_array($entryArr)) $items[] = $entryArr;
                                }
                            } elseif (isset($decoded['patient_flag_infection_data']) && is_array($decoded['patient_flag_infection_data'])) {
                                foreach ($decoded['patient_flag_infection_data'] as $entry) {
                                    $entryArr = is_string($entry) ? @json_decode($entry, true) : $entry;
                                    if (is_array($entryArr)) $items[] = $entryArr;
                                }
                            } else {
                                foreach ($decoded as $child) {
                                    if (is_string($child)) {
                                        $c = @json_decode($child, true);
                                        if (is_array($c)) $items[] = $c;
                                    } elseif (is_array($child)) {
                                        $items[] = $child;
                                    }
                                }
                            }
                        }
                    }



                    if (empty($items)) {
                        $skipped++;
                        continue;
                    }

                    $seen = [];
                    $toInsert = [];

                    $foundPrimary = false;
                    foreach ($items as $it) {
                        $infection_id = $it['infection_id'] ?? $it['ic_id'] ?? null;
                        $infection_name = $it['infection_name'] ?? $it['infection_text'] ?? null;
                        $infection_type = strtoupper($it['infection_type'] ?? $it['type'] ?? 'QUERY');
                        $next_review = $it['next_review_date'] ?? $it['ic_date'] ?? null;
                        try {
                            $next_review = $next_review ? Carbon::parse($next_review)->format('Y-m-d') : null;
                        } catch (\Throwable $e) {
                            $next_review = null;
                        }



                        if ($it['is_primary'] == 'false' || $it['is_primary'] === false || $it['is_primary'] == 0) {
                            $is_primary = 0;
                        } else {
                            $is_primary = 1;
                        }
                        if (empty($infection_id) && (empty($infection_name) || trim($infection_name) === '')) {
                            continue;
                        }

                        $key = sprintf('%s|%s|%s', $infection_id ?? '', $infection_type, $next_review ?? '');
                        if (isset($seen[$key])) continue;
                        $seen[$key] = true;

                        $toInsert[] = [
                            'patient_id' => $patientId,
                            'ward_id' => $flag->flag_updated_ward ?? null,
                            'infection_id' => $infection_id,
                            'infection_name' => $infection_name ? trim($infection_name) : null,
                            'infection_type' => in_array($infection_type, ['QUERY', 'CONFIRMED', 'RESOLVED', 'CANSTAYINBAY']) ? $infection_type : 'QUERY',
                            'next_review_date' => $next_review,
                            'is_primary' => $is_primary,
                            'updated_by' => $flag->updated_by ?? 0,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    if (empty($toInsert)) {
                        $skipped++;
                        continue;
                    }

                    try {
                        DB::transaction(function () use ($toInsert) {
                            CamisIboxBoardRoundInfectionRisk::insert($toInsert);
                            HistoryCamisIboxBoardInfectionRisk::insert($toInsert);
                        });
                        $inserted++;
                    } catch (\Throwable $e) {
                        $errors[] = "patient {$patientId}: " . $e->getMessage();
                    }
                }
            });

        return response()->json([
            'processed_flags' => $processed,
            'inserted_patients_count' => $inserted,
            'skipped_count' => $skipped,
            'errors' => $errors,
        ]);
    }
}
