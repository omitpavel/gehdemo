<?php

namespace App\Models\Iboards\Camis\View;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\Data\CamisRebedDischargeComment;

class DischargeLoungePatientWardDetails extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'v_patient_discl_ward_details';


    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }


    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names") . ".v_patient_discl_ward_details";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names");
    }

    public function CamisPatientDetails()
    {
        return $this->belongsTo(CamisIboxWardInPatientInformationDetailsView::class, 'ipe_epinumber', 'camis_patient_id');
    }

    public function RebedDischargeComment()
    {
        return $this->hasOne(CamisRebedDischargeComment::class, 'patient_id', 'ipe_epinumber');
    }
}
