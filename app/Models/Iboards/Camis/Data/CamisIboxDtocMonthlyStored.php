<?php

namespace App\Models\Iboards\Camis\Data;


use Illuminate\Database\Eloquent\Model;

class CamisIboxDtocMonthlyStored extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_dtoc_month_tab_store';

    public static function ReturnTableName()
    {
        $connection = (new static)->getConnectionName();
        $database_name = config('database.connections.' . $connection . '.database');

        $table_name = (new static)->getTable();
        return $database_name . '.' . $table_name;
    }




}
