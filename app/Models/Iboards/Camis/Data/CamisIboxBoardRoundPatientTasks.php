<?php

namespace App\Models\Iboards\Camis\Data;

use App\Models\Iboards\Camis\Master\TaskCategory;
use App\Models\Iboards\Camis\Master\TaskGroup;
use App\Models\Iboards\Camis\Master\Wards;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
class CamisIboxBoardRoundPatientTasks extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_board_round_patient_tasks';



    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function PatientInformationWithBedDetails()
    {
        return $this->belongsTo(CamisIboxWardPatientInformationWithBedDetailsView::class, 'patient_id', 'camis_patient_id');
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names") . ".ibox_board_round_patient_tasks";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names");
    }

    public function GroupName()
    {
        return $this->belongsTo(TaskGroup::class,'task_group');
    }

    public function PatientTaskGroup()
    {
        return $this->hasOne(TaskGroup::class, 'id', 'task_group');
    }


    public function PatientTaskCategory()
    {
        return $this->belongsTo(TaskCategory::class, 'task_category', 'task_category_index_value');

    }



    public function WardDetail()
    {
        return $this->belongsTo(Wards::class, 'task_created_ward', 'id');
    }
}
