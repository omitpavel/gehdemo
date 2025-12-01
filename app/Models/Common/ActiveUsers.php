<?php

namespace App\Models\Common;
use Illuminate\Database\Eloquent\Model;

class ActiveUsers extends Model
{
    protected $guarded      = [];    
    protected $connection   = 'mysql';
    protected $table        = 'users_active_users';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql","ibox_constant_database_names").".users_active_users";
    }
}
