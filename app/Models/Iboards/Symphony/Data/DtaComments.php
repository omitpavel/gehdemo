<?php

namespace App\Models\Iboards\Symphony\Data;

use Illuminate\Database\Eloquent\Model;

class DtaComments extends Model
{
    protected $guarded      = [];    
    protected $connection   = 'mysql_symphony_data';
    protected $table        = 'ane_dta_comments';
    
    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names").".ane_dta_comments";
    }
}
