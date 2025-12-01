<?php

namespace App\Models\History;
use App\Models\Common\User;
use App\Models\Iboards\Camis\Master\Wards;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HistoryCamisIboxSiteOfficeText extends Model
{
    protected $guarded          = [];
    protected $connection       = 'mysql_data_history';
    protected $table            = 'history_camis_site_office_text';
    public $timestamps          = false;


}
