<?php

namespace App\Models\Iboards\Camis\View;
use Illuminate\Database\Eloquent\Model;


class DischargeLoungePatientListBelowDischarge extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'v_patient_list_below_discl';


    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }


    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names") . ".v_patient_list_below_discl";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names");
    }

}
