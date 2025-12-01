<?php

namespace App\Models\Iboards\Camis\View;
use Illuminate\Database\Eloquent\Model;


class CamisIboxOutstandingTasks extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'v_inpatient_pending_results';


    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }


    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names") . ".v_inpatient_pending_results";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names");
    }

    public function PatientInformationWithBedDetails()
    {
        return $this->belongsTo(CamisIboxWardPatientInformationWithBedDetailsView::class, 'patient_id', 'camis_patient_pmi_link');
    }
}
