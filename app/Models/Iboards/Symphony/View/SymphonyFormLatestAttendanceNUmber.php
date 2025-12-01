<?php

namespace App\Models\Iboards\Symphony\View;

use Illuminate\Database\Eloquent\Model;

class SymphonyFormLatestAttendanceNUmber extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_symphony_data';
    protected $table        = 'v_symphony_form_latest_atd_num';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names").".v_symphony_form_latest_atd_num";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names");
    }
}
