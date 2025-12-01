<?php

namespace App\Models\Iboards\Camis\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wards extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_master';
    protected $table        = 'master_ward_details';

    protected $casts        = [
                                'created_at' => 'datetime:Y-m-d H:i:s',
                                'updated_at' => 'datetime:Y-m-d H:i:s',
                              ];
    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }
    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_master","ibox_constant_database_names").".master_ward_details";
    }


    public static function ReturnConnectionTableName()
    {
        return 'mysql_camis_master.master_ward_details';
    }

    public function PrimaryWardType()
    {
        return $this->belongsTo('App\Models\Iboards\Camis\Master\WardType','ward_type_primary','id');
    }

    public function SecondaryWardType()
    {
        return $this->belongsTo('App\Models\Iboards\Camis\Master\WardType','ward_type_secondary','id');
    }

    public function GetWardSummary()
    {
        $results = DB::connection('mysql_camis_data')->select('CALL sp_ward_data_summary(?)', [$this->id]);

        return $results;
    }

    public function BoardRoundHistory()
    {
        $results = DB::connection('mysql_camis_data')->select('CALL sp_aande2_ward_board_round_summary(?)', [$this->ward_url_name]);

        return $results;
    }

}
