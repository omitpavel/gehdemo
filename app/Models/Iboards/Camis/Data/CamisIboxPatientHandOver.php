<?php

namespace App\Models\Iboards\Camis\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CamisIboxPatientHandOver extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_patient_hand_over';

    public function GetTableNameWithConnection()
    {
        $connection_name    = $this->getConnectionName();
        $table_name         = $this->getTableName();
        return $connection_name . '.' . $table_name;
    }
}
