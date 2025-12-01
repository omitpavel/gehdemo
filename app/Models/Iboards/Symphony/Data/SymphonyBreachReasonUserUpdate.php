<?php

namespace App\Models\Iboards\Symphony\Data;

use Illuminate\Database\Eloquent\Model;

class SymphonyBreachReasonUserUpdate extends Model
{
    protected $guarded      = [];   
    protected $connection   = 'mysql_symphony_data';
    protected $table        = 'symphony_breach_reason_user_update';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names").".symphony_breach_reason_user_update";
    }
}
