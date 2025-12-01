<?php

namespace App\Http\Controllers\DataAutoLoad\Camis;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\HistoryController;
use App\Http\Controllers\Governance\GovernanceController;
use App\Models\Governance\LogReplicationAutomatedJobLogStatus;
use App\Models\Iboards\Camis\Data\CamisIboxDPTaskDailySummary;
use App\Models\Iboards\Camis\Data\CamisIboxDPTaskMonthlySummary;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientTasks;
use App\Models\Iboards\Camis\Master\Wards;
use Carbon\Carbon;

class DPTaskSummaryDataAutoController extends Controller
{
    public function MonthlyTaskSummaryAutoInsert()
    {
        $common_controller                                  = new CommonController;
        $history_controller                                 = new HistoryController;
        $history_modal                                      = "App\Models\History\HistoryCamisIboxDPTaskMonthlySummary";
        $auto_user_id                                       = 0;
        $process_array                                      = array();
        $success_array                                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);

        $automated_job_log                                  = array('replication_job_name'   => 'Automated Daily DP Task Summary Insert', 'replication_job_start_time' => $process_array['date_time_now']);

        $automated_job_log_id                               = LogReplicationAutomatedJobLogStatus::insertGetId($automated_job_log);

        $all_wards = Wards::where('status', 1)->pluck('ward_url_name', 'id')->toArray();

        foreach ($all_wards as $ward_id => $ward) {
            $records = CamisIboxBoardRoundPatientTasks::where('task_created_ward', $ward_id)
                ->where('task_category', 6)
                ->whereYear('created_at', '=', Carbon::now()->year)
                ->whereMonth('created_at', '=', Carbon::now()->month)
                ->select('patient_id', 'task_dp_status_order_value', 'task_completed_status', 'task_not_applicable_status')
                ->get()
                ->toArray();

            $number_of_task_created = count($records);

            if ($number_of_task_created > 0) {

                $series_of_task = array_reduce($records, function ($carry, $item) {
                    $patient_id = $item['patient_id'];
                    $dp_status_order_value = $item['task_dp_status_order_value'];

                    if (!isset($carry[$patient_id])) {
                        $carry[$patient_id] = [];
                    }

                    if (!isset($carry[$patient_id][$dp_status_order_value])) {
                        $carry[$patient_id][$dp_status_order_value] = true;
                    }

                    return $carry;
                }, []);

                $series_of_task = array_sum(array_map('count', $series_of_task));

                $completed_task = count(array_filter($records, function ($item)
                {
                    return ($item['task_completed_status'] == 1);
                }));

                $not_applicable_count = count(array_filter($records, function ($item)
                {
                    return ($item['task_not_applicable_status'] == 1);
                }));

                $gov_text_before_arr                                    = CamisIboxDPTaskMonthlySummary::where('ward_id', $ward)->where('year', Carbon::now()->year)->where('month', Carbon::now()->month)->first();
                $updated_data = CamisIboxDPTaskMonthlySummary::updateOrCreate([
                    'ward_id' => $ward_id,
                    'month' => Carbon::now()->format('m'),
                    'year' => Carbon::now()->year,
                ], ['dp_task_list_count' => $series_of_task, 'dp_task_list_task_count' => $number_of_task_created, 'dp_task_list_task_completed_count' => $completed_task, 'dp_task_list_task_not_applicable_count' => $not_applicable_count, 'updated_by' => $auto_user_id]);

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);

                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"]))
                    {
                        $gov_text_after_arr                             = CamisIboxDPTaskMonthlySummary::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceIboxDataPreCall($gov_text_before, 'DP Task Summary Monthly Task Insert For Month '.Carbon::now()->format('m').' Of '.Carbon::now()->year, $gov_text_after_arr, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0)
                    {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"]))
                        {
                            if ($gov_text_before_arr)
                            {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxDPTaskMonthlySummary::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceIboxDataPreCall($gov_text_before, 'DP Task Summary Monthly Task Updated  For Month '.Carbon::now()->format('m').' Of '.Carbon::now()->year, $gov_text_after_arr, 2);
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

    public function DailyTaskSummaryAutoInsert()
    {
        $common_controller                                  = new CommonController;
        $history_controller                                 = new HistoryController;
        $history_modal                                      = "App\Models\History\HistoryCamisIboxDPTaskDailySummary";
        $auto_user_id                                       = 0;
        $process_array                                      = array();
        $success_array                                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);

        $automated_job_log                                  = array('replication_job_name'   => 'Automated Daily DP Task Summary Insert', 'replication_job_start_time' => $process_array['date_time_now']);

        $automated_job_log_id                               = LogReplicationAutomatedJobLogStatus::insertGetId($automated_job_log);

        $all_wards = Wards::where('status', 1)->pluck('ward_url_name', 'id')->toArray();

        foreach($all_wards as $ward_id => $ward){
            $records                                            = CamisIboxBoardRoundPatientTasks::where('task_created_ward', $ward_id)->where('task_category', 6)->whereDate('created_at', '>=', Carbon::today())->select('patient_id', 'task_dp_status_order_value', 'task_completed_status', 'task_extra_data', 'task_description', 'task_estimated_date_for_completion', 'task_not_applicable_status')->get()->toArray();

            if(count($records) > 0){
                dd($records);
            }

            $number_of_task_created = count($records);
            if($number_of_task_created > 0){
                $series_of_task = array_reduce($records, function ($carry, $item) {
                    $patient_id = $item['patient_id'];
                    $dp_status_order_value = $item['task_dp_status_order_value'];

                    if (!isset($carry[$patient_id])) {
                        $carry[$patient_id] = [];
                    }

                    if (!isset($carry[$patient_id][$dp_status_order_value])) {
                        $carry[$patient_id][$dp_status_order_value] = true;
                    }

                    return $carry;
                }, []);

                $series_of_task = array_sum(array_map('count', $series_of_task));

                $escalation_yes_count = count(array_filter($records, function($item) {
                    if (
                        isset($item['task_extra_data'], $item['task_description'], $item['task_estimated_date_for_completion'])
                        && !empty($item['task_extra_data'])
                    ) {
                        $escalation_json = json_decode($item['task_extra_data'], true);

                        if (
                            isset($escalation_json['escalation_status'])
                            && $escalation_json['escalation_status'] == 'Yes'
                            && isset($item['task_description']) && $item['task_description'] == 'Escalation Status'
                            && isset($item['task_estimated_date_for_completion'])
                        ) {
                            return true;
                        }
                    }

                    return false;
                }));


                $completed_task = count(array_filter($records, function ($item)
                {
                    return ($item['task_completed_status'] == 1);
                }));

                $not_applicable_count = count(array_filter($records, function ($item)
                {
                    return ($item['task_not_applicable_status'] == 1);
                }));


                $gov_text_before_arr                                    = CamisIboxDPTaskDailySummary::where('ward_id', $ward)->whereDate('date', Carbon::today()->format('Y-m-d'))->first();
                $updated_data                                           = CamisIboxDPTaskDailySummary::updateOrCreate(['ward_id' => $ward, 'date' => Carbon::today()->format('Y-m-d')], ['dp_task_list_count' => $series_of_task,'dp_task_list_completed_count' => $escalation_yes_count,  'dp_task_list_task_count' => $number_of_task_created, 'dp_task_list_task_completed_count' => $completed_task, 'dp_task_list_task_not_applicable_count' => $not_applicable_count, 'updated_by' => $auto_user_id]);
                if ($updated_data->wasRecentlyCreated)
                {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"]))
                    {
                        $gov_text_after_arr                             = CamisIboxDPTaskDailySummary::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceIboxDataPreCall($gov_text_before, 'DP Task Summary Daily Task Insert For '.Carbon::today()->format('Y-m-d'), $gov_text_after_arr, 1);
                    }
                }
                else
                {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0)
                    {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"]))
                        {
                            if ($gov_text_before_arr)
                            {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxDPTaskDailySummary::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceIboxDataPreCall($gov_text_before, 'DP Task Summary Daily Task Updated For '.Carbon::today()->format('Y-m-d'), $gov_text_after_arr, 2);
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



    public function GovernanceIboxDataPreCall($gov_text_before, $functional_identity, $gov_text_after_arr, $operation)
    {
        $gov_data               = array();
        $gov_text_after         = array();

        if ($operation == 1)
        {
            if (isset($id) && $id != '')
            {

                if ($gov_text_after_arr)
                {
                    $gov_text_after = $gov_text_after_arr->toArray();
                }
            }
            if (isset($gov_text_after["id"]))
            {
                $gov_data["gov_text_before"]        = "";
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = 'CCU Ward Changes';
            }
        }
        if ($operation == 2)
        {
            if (isset($id) && $id != '')
            {


                if ($gov_text_after_arr)
                {
                    $gov_text_after                 = $gov_text_after_arr->toArray();
                }
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"]))
            {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = 'CCU Ward Changes';
            }
        }

        if (!empty($gov_data))
        {

            if (count($gov_data) > 0)
            {

                $governance = new GovernanceController;
                $governance->GovernanceStoreIboxData($gov_data);
            }
        }
    }
}
