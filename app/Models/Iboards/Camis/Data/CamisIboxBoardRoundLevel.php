<?php

namespace App\Models\Iboards\Camis\Data;

use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
class CamisIboxBoardRoundLevel extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_board_round_level';

    public function GetTableNameWithConnection()
    {
        $database_name = config('database.connections.' . $this->getConnectionName() . '.database');

        $table_name = $this->getTable();

        return $database_name . '.' . $table_name;
    }

    public function PatientInformationWithBedDetails()
    {
        return $this->belongsTo(CamisIboxWardPatientInformationWithBedDetailsView::class, 'patient_id', 'camis_patient_id');
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names").".ibox_board_round_ccu_level";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names");
    }
}
