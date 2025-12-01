<?php

namespace App\Models\Iboards\Camis\View;
use Illuminate\Database\Eloquent\Model;


class DischargeLoungePatientDetailsWeekly extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'v_discl_patient_details_weekly';


    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }


    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names") . ".v_discl_patient_details_weekly";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names");
    }



}
