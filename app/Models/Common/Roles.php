<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use DB;

class Roles extends Model
{
    protected $guarded      = [];    
    protected $connection   = 'mysql';
    protected $table        = 'roles';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql","ibox_constant_database_names").".roles";
    }
    public function hierarchy()
    {
        return $this->hasOne('App\Models\Common\RoleHierarchy','role_id','id');
    }
}
