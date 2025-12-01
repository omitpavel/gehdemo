<?php

namespace App\Models\Iboards\Camis\Master;

use Illuminate\Database\Eloquent\Model;

class BoardRoundUserTaskNofTasks extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_master';
    protected $table        = 'master_board_round_user_task_nof_tasks';

    public function TaskUserGroup()
    {
        return $this->belongsTo(TaskGroup::class, 'user_task_group', 'id');
    }

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }
}
