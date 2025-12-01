<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;
class HistoryCamisIboxDPTaskDailySummary extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_data_history';
    protected $table        = 'history_camis_ibox_dp_task_list_daily_summary';

    public function GetTableNameWithConnection()
    {
        $database_name = config('database.connections.' . $this->getConnectionName() . '.database');

        $table_name = $this->getTable();

        return $database_name . '.' . $table_name;
    }


}
