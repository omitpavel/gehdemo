<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryCamisIboxPatientHandOver extends Model
{
    protected $guarded          = [];    
    protected $connection       = 'mysql_data_history';
    protected $table            = 'history_camis_ibox_patient_hand_over';
    public $timestamps          = false;

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_data_history","ibox_constant_database_names").".history_camis_ibox_patient_hand_over";
    }
}
