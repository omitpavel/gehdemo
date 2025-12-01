<?php

namespace App\Models\Iboards\Camis\Data;

use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Illuminate\Support\Facades\DB;
class CamisIboxDischargePatientDataStored extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_dischlounge_pat_data_stored';

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function PatientInformationWithBedDetails()
    {
        return $this->belongsTo(CamisIboxWardPatientInformationWithBedDetailsView::class, 'patient_id', 'camis_patient_id');
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names").".ibox_dischlounge_pat_data_stored";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names");
    }

    public static function SearchPatient($value)
    {
        $results = DB::connection('mysql_camis_data')->select('CALL sp_patient_list_search_discl(?)', [$value]);

        return $results;
    }

    public static function MonthSummary($value)
    {
        $results = DB::connection('mysql_camis_data')->select('CALL sp_discl_patient_details_monthly(?)', [$value]);

        return $results;
    }
}
