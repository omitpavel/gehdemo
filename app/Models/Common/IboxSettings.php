<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class IboxSettings extends Model
{
    protected $guarded      = []; 
    protected $connection   = 'mysql_settings';
    protected $table        = 'ibox_settings';
    public $timestamps      = false;
    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_settings","ibox_constant_database_names").".ibox_settings";
    }
}
