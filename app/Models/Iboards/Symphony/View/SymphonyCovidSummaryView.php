<?php

namespace App\Models\Iboards\Symphony\View;

use Illuminate\Database\Eloquent\Model;

class SymphonyCovidSummaryView extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_symphony_etl_data';
    protected $table        = 'v_aande_covid_summary';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_etl_data","ibox_constant_database_names").".v_symphony_attendance_one_year_data";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_etl_data","ibox_constant_database_names");
    }
}
