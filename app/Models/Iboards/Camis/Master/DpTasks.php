<?php

namespace App\Models\Iboards\Camis\Master;

use Illuminate\Database\Eloquent\Model;

class DpTasks extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_master';
    protected $table        = 'master_dp_tasks';

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function TaskUserGroup()
    {
        return $this->belongsTo(TaskGroup::class, 'user_task_group', 'id');
    }
}
