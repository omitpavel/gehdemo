<?php

namespace App\Models\Iboards\Apex\View;

use Illuminate\Database\Eloquent\Model;

class ApexIboxIPCovidContactTracing extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_apex_data';
    protected $table        = 'v_apex_ip_covid_contact_tracing';


    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_apex_data", "ibox_constant_database_names") . ".v_apex_ip_covid_contact_tracing";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_apex_data", "ibox_constant_database_names");
    }



}
