<?php

namespace App\Models\Iboards\Symphony\View;

use Illuminate\Database\Eloquent\Model;

class SymphonyDataClinicalSeen extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_symphony_data';
    protected $table        = 'v_symphony_data_clinician_seen';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names").".v_symphony_data_clinician_seen";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names");
    }
}
