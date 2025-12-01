<?php

namespace App\Models\Iboards\Camis\View;

use Illuminate\Database\Eloquent\Model;


class CamisIboxPatientInfoVitalpacView extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'v_ibox_patient_info_vitalpac';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names").".v_ibox_patient_info_vitalpac";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names");
    }

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->ReturnDatabaseName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

}

