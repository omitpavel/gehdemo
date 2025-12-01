<?php

namespace App\Models\Iboards\Camis\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WardType extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_master';
    protected $table        = 'master_ward_ward_type';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_master","ibox_constant_database_names").".master_ward_ward_type";
    }


    public static function ReturnConnectionTableName()
    {
        return 'mysql_camis_master.master_ward_ward_type';
    }

//    public function PrimaryWardType()
//    {
//        return $this->belongsTo('App\Models\Iboards\Camis\WardType','ward_type_primary','id');
//    }
//    public function SecondaryWardType()
//    {
//        return $this->belongsTo('App\Models\Iboards\Camis\WardType','ward_type_secondary','id');
//    }
//
//    public function GetWardSummary()
//    {
//        $results = DB::connection('mysql_camis_data')->select('CALL sp_ward_data_summary(?)', [$this->id]);
//
//        return $results;
//    }

}
