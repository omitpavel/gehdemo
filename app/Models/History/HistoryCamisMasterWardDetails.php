<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class HistoryCamisMasterWardDetails extends Model
{    
    protected $guarded          = [];    
    protected $connection       = 'mysql_data_history';
    protected $table            = 'history_camis_master_ward_details';
    public $timestamps          = false;

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_data_history","ibox_constant_database_names").".history_camis_master_ward_details";
    }
}
