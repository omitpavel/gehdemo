<?php

namespace App\Models\Common;
use Illuminate\Database\Eloquent\Model;

class Activations extends Model
{
    protected $guarded      = [];   
    protected $connection   = 'mysql';
    protected $table        = 'activations';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql","ibox_constant_database_names").".activations";
    }
}
