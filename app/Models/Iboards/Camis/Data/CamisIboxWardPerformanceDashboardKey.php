<?php

namespace App\Models\Iboards\Camis\Data;

use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
class CamisIboxWardPerformanceDashboardKey extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_etl';
    protected $table        = 'ibox_ward_performance_dashboard_key_inner';

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function WardPerformanceDashboard()
    {
        return $this->hasMany(CamisIboxWardPerformanceDashboard::class, 'Keyvalue', 'Keyvalue');
    }

}
