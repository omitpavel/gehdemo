<?php

namespace App\Models\Iboards\Camis\Master;

use Illuminate\Database\Eloquent\Model;

class DtocCurrentStatus extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_master';
    protected $table        = 'master_dtoc_current_status';

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }
    public static function ReturnTableName()
    {
        $connection = (new static)->getConnectionName();
        $database_name = config('database.connections.' . $connection . '.database');

        $table_name = (new static)->getTable();
        return $database_name . '.' . $table_name;
    }
}
