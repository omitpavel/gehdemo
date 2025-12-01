<?php

namespace App\Models\Iboards\Camis\Data;

use App\Models\Iboards\Camis\Master\DtocPathway;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CamisIboxBoardRoundCareRequirement extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_board_round_care_requirements';

    public function PathwayGroup()
    {
        return $this->hasOne(DtocPathway::class, 'id', 'care_requirements_pdna_pathway_id');
    }

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }
}
