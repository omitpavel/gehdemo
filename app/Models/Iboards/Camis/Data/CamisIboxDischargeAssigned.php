<?php

namespace App\Models\Iboards\Camis\Data;

use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
class CamisIboxDischargeAssigned extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_discharge_tracker_discharge_patients_assigned';

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function PatientInformationWithBedDetails()
    {
        return $this->belongsTo(CamisIboxWardPatientInformationWithBedDetailsView::class, 'camis_patient_id', 'camis_patient_id');
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names").".ibox_discharge_tracker_discharge_patients_assigned";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names");
    }
}
