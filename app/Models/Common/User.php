<?php

namespace App\Models\Common;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

class User extends SentinelUser
{
    protected $guarded      = [];
    protected $fillable     = ['username', 'password', 'last_name', 'first_name'];
    protected $connection   = 'mysql';
    protected $loginNames   = ['email', 'username'];

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql","ibox_constant_database_names").".users";
    }

    public function FavouritesDashboard(){
        return $this->hasOne(IboxUserFavouriteDashboard::class,'user_id','id');
    }
}
