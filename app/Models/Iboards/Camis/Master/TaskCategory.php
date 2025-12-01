<?php

namespace App\Models\Iboards\Camis\Master;

use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_master';
    protected $table        = 'master_task_category';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_master", "ibox_constant_database_names") . ".master_task_category";
    }

    public static function ReturnConnectionTableName()
    {
        return 'mysql_camis_master.master_task_category';
    }
}
