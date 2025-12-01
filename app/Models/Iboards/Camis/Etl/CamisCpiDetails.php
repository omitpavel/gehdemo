<?php

namespace App\Models\Iboards\Camis\Etl;

use Illuminate\Database\Eloquent\Model;

class CamisCpiDetails extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_etl';
    protected $table        = 'camis_pmi_cpidetails';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_etl","ibox_constant_database_names").".camis_pmi_cpidetails";
    }

    public static function ReturnConnectionTableName()
    {
        return 'mysql_camis_etl.camis_pmi_cpidetails';
    }
}
