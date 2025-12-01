<?php

namespace App\Models\Iboards\Camis\View;

use App\Models\Iboards\Camis\Master\Wards;
use Illuminate\Database\Eloquent\Model;


class CamisIboxInpatientFlagAlertDetails extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'v_ibox_inpatient_flag_alert_details';


    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }


    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names") . ".v_ibox_inpatient_flag_alert_details";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names");
    }



}
