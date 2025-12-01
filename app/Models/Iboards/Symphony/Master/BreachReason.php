<?php

namespace App\Models\Iboards\Symphony\Master;

use Illuminate\Database\Eloquent\Model;

class BreachReason extends Model
{
    protected $guarded      = [];   
    protected $connection   = 'mysql_symphony_master';
    protected $table        = 'master_breach_reason';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_master","ibox_constant_database_names").".master_breach_reason";
    }
}
