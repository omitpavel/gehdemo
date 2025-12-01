<?php

namespace App\Models\Iboards\Camis\View;

use App\Models\Iboards\Camis\Master\Wards;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CamisIboxPatientAlertDetails extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'v_ibox_inpatient_alert_details';


    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }


    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names") . ".v_ibox_inpatient_alert_details";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names");
    }

    public function PatientInformationWithBedDetails()
    {
        return $this->hasMany(CamisIboxWardPatientInformationWithBedDetailsView::class,'camis_patient_id','camis_patient_id');
    }
    public function ContactTracing()
    {
        $results = DB::connection('mysql_camis_data')->select('CALL sp_ibox_inpatient_contact_tracing(?)', [$this->camis_patient_id]);

        return $results;
    }

}
