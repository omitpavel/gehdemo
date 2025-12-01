<?php

namespace App\Models\Iboards\Camis\Data;

use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
class CamisIboxDPTaskMonthlySummary extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_dp_task_list_monthly_summary';

    public function GetTableNameWithConnection()
    {
        $database_name = config('database.connections.' . $this->getConnectionName() . '.database');

        $table_name = $this->getTable();

        return $database_name . '.' . $table_name;
    }


}
