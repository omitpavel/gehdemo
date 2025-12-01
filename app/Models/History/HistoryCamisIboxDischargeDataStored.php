<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryCamisIboxDischargeDataStored extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_data_history';
    protected $table        = 'history_camis_ibox_dischlounge_pat_data_stored';
    public $timestamps      = false;

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }
}
