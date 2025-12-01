<?php

namespace App\Http\Controllers\DataAutoLoad\Camis;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonSymphonyController;
use App\Http\Controllers\Common\HistoryController;
use App\Http\Controllers\Governance\GovernanceController;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPotentialDefinite;
use App\Models\Governance\LogReplicationAutomatedJobLogStatus;
use App\Models\Common\User;
use Carbon\Carbon;

class PDDateDataAutoController extends Controller
{
    public function PDDataUpdate()
    {
        $common_controller                                  = new CommonController;
        $common_symphony_controller                         = new CommonSymphonyController;
        $history_controller                                 = new HistoryController;
        $history_modal                                      = "App\Models\History\HistoryCamisIboxBoardRoundPotentialDefinite";
        $auto_user_id                                       = 0;
        $process_array                                      = array();
        $success_array                                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $functional_identity                                = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_potential_definite", "ibox_governance_frontend_functional_names");

        $automated_job_log                                  = array('replication_job_name'   => 'Automated Potential Definite Date Updates', 'replication_job_start_time' => $process_array['date_time_now']);
        $automated_job_log_id                               = LogReplicationAutomatedJobLogStatus::insertGetId($automated_job_log);
        $records                                            = CamisIboxBoardRoundPotentialDefinite::whereDate('potential_definite_date', '>=', Carbon::today())->get()->toArray();
        $type = 0;
        $update_bed_status = '';
        foreach($records as $record){
            $camis_patient_id                               = $record['patient_id'];

            $current_date = Carbon::parse($record['potential_definite_date']);


            if ($current_date->isSameDay(Carbon::now()) || $current_date->isPast()) {
                if ($record['id'] != "" && $auto_user_id != "")
                    {
                        $gov_text_before_arr                                      = CamisIboxBoardRoundPotentialDefinite::where('patient_id', '=', $camis_patient_id)->first();
                        CamisIboxBoardRoundPotentialDefinite::where('id', '=', $record['id'])->delete();
                        $updated_data                                             = $gov_text_before_arr;
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
                        $functional_identity                                      = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_potential_definite", "ibox_governance_frontend_functional_names");
                        $gov_text_before                                          = $gov_text_before_arr->toArray();
                        $gov_text_after_arr                                       = array();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                    }
                    continue;
            }
            elseif ($current_date->isTomorrow()) {
                if($record['type'] == 'definite'){
                    $type = 2;
                    $update_bed_status = 'Definite Discharge Today';
                    $patient_potential_definite_status = 3;
                } else {
                    $type = 1;
                    $update_bed_status = 'Potential Discharge Today';
                    $patient_potential_definite_status = 1;
                }

            }
            elseif ($current_date->isSameDay(Carbon::tomorrow()->addDay())) {
                if($record['type'] == 'definite'){
                    $type = 2;
                    $update_bed_status = 'Definite Discharge Tomorrow';
                    $patient_potential_definite_status = 4;
                } else {
                    $type = 1;
                    $update_bed_status = 'Potential Discharge Tomorrow';
                    $patient_potential_definite_status = 2;
                }
            }
            $gov_text_before_arr                                      = CamisIboxBoardRoundPotentialDefinite::where('id', '=', $record['id'])->first();
            $updated_data                                             = CamisIboxBoardRoundPotentialDefinite::updateOrCreate(['id' => $record['id']], ['type' => $type,'potential_definite_date'=>$current_date, 'updated_by' => $auto_user_id]);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
            $success_array["message"]                             = DataUpdatedMessage();

            if (count($updated_data->getChanges()) > 0)
            {
                $updated_array                                    = $updated_data->getOriginal();
                if (count($updated_array) > 0 && isset($updated_array["id"]))
                {
                    if ($gov_text_before_arr)
                    {
                        $gov_text_before                          = $gov_text_before_arr->toArray();
                        $gov_text_after_arr                       = CamisIboxBoardRoundPotentialDefinite::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 2);
                    }
                }
            }

        }

        $replication_job_end_time                           = date('Y-m-d H:i:s');
        $automated_job_log                                  = array('replication_job_end_time'   => $replication_job_end_time, 'replication_job_log_status' => 1);
        LogReplicationAutomatedJobLogStatus::where('id', $automated_job_log_id)->update($automated_job_log);

    }

    public function GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_desc, $gov_text_after_arr, $functional_identity, $operation)
    {
        $gov_data                                   = array();
        if ($operation == 1)
        {
            if ($gov_text_after_arr)
            {
                $gov_text_after                     = $gov_text_after_arr->toArray();
            }

            if (isset($gov_text_after["id"]))
            {
                $gov_data["gov_text_before"]        = "";
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
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

                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;

            }
        }

        if ($operation == 4)
        {
            if ($gov_text_after_arr)
            {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"]))
            {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 5)
        {
            if ($gov_text_after_arr)
            {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"]))
            {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 3)
        {
            if (isset($gov_text_before["id"]))
            {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = "";
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if (!empty($gov_data))
        {
            if (count($gov_data) > 0)
            {

                $governance = new GovernanceController;
                $governance->GovernanceStoreCamisData($gov_data);
            }
        }
    }
}
