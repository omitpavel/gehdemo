<?php

namespace App\Models\Iboards\Camis\Data;

use App\Models\Iboards\Camis\Master\DtocAuthority;
use App\Models\Iboards\Camis\Master\DtocCurrentStatus;
use App\Models\Iboards\Camis\Master\DtocPathway;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Illuminate\Database\Eloquent\Model;

class CamisIboxBoardRoundPathwayRequirement extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_board_round_pathway_requirements';
    protected $casts = [

        'planned_discharge_date' => 'datetime',
    ];

    public static function ReturnTableName()
    {
        $connection = (new static)->getConnectionName();
        $database_name = config('database.connections.' . $connection . '.database');

        $table_name = (new static)->getTable();
        return $database_name . '.' . $table_name;
    }
    public function DtocPathway()
    {
        return $this->belongsTo(DtocPathway::class,'dtoc_pathway_id','id');
    }

    public function DtocAuthority()
    {
        return $this->belongsTo(DtocAuthority::class,'dtoc_authority_id','id');
    }

    public function DtocStatus()
    {
        return $this->belongsTo(DtocCurrentStatus::class,'dtoc_current_status_id','id');
    }

    public function BoardRoundMedicallyFitData()
    {
        return $this->hasOne(CamisIboxBoardRoundMedFit::class, 'patient_id', 'patient_id');

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
