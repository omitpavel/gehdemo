<?php

namespace App\Models\Iboards\Camis\Master;

use Illuminate\Database\Eloquent\Model;
class WardBayGender extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_master';
    protected $table        = 'master_ward_bay_gender';

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->ReturnTableName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_master","ibox_constant_database_names").".master_ward_bay_gender";
    }

    public static function ReturnConnectionTableName()
    {
        return 'mysql_camis_master.master_ward_bay_gender';
    }


}
