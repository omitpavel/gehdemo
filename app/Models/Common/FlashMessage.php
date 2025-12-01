<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class FlashMessage extends Model
{
    protected $guarded      = [];    
    protected $connection   = 'mysql_settings';
    protected $table        = 'ibox_settings_flash_message';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_settings","ibox_constant_database_names").".ibox_settings_flash_message";
    }
}
