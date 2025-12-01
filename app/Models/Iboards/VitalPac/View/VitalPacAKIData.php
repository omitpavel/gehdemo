<?php
namespace App\Models\Iboards\VitalPac\View;
use Illuminate\Database\Eloquent\Model;


class VitalPacAKIData extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_vialpac';
    protected $table        = 'vitalpac_aki_data';


    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }


    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names") . ".vitalpac_aki_data";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names");
    }

}
