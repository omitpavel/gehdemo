<?php

namespace App\Models\Iboards\Camis\Data;

use App\Models\Iboards\Camis\Master\DtocPathway;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
class CamisIboxBoardRoundDischargeLoungeHandover extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_board_round_discharge_lounge_handover';

    public function PathwayGroup()
    {
        return $this->hasOne(DtocPathway::class, 'id', 'ibox_board_round_discharge_lounge_handover');
    }

    public function PatientInformationWithBedDetails()
    {
        return $this->belongsTo(CamisIboxWardPatientInformationWithBedDetailsView::class, 'patient_id', 'camis_patient_id');
    }

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }
}
