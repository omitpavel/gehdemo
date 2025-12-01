<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class LogFilesNamesToRead extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_settings';
    protected $table        = 'ibox_log_file_names_to_read';
    public $timestamps      = false;
    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_settings","ibox_constant_database_names").".ibox_log_file_names_to_read";
    }
}
