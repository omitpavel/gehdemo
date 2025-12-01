<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class RoleUsers extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql';
	public $primaryKey      = 'user_id';
    protected $table        = 'role_users';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql","ibox_constant_database_names").".role_users";
    }

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }
}
