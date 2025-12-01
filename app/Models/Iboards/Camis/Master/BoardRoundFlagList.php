<?php

namespace App\Models\Iboards\Camis\Master;

use Illuminate\Database\Eloquent\Model;

class BoardRoundFlagList extends Model
{
    protected $guarded      = [];   
    protected $connection   = 'mysql_camis_master';
    protected $table        = 'master_board_round_patient_flags_list';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_master","ibox_constant_database_names").".master_board_round_patient_flags_list";
    }
    public static function ReturnConnectionTableName()
    {
        return 'mysql_camis_master.master_board_round_patient_flags_list';
    }
}
