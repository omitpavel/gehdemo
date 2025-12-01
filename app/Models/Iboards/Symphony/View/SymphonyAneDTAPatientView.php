<?php

namespace App\Models\Iboards\Symphony\View;

use Illuminate\Database\Eloquent\Model;

class SymphonyAneDTAPatientView extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_symphony_data';
    protected $table        = 'v_ibox_ed_dta_patient_details';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names").".v_ibox_ed_dta_patient_details";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names");
    }
}
