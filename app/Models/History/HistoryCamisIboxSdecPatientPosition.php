<?php

namespace App\Models\History;
use App\Models\Common\User;
use App\Models\Iboards\Camis\Data\CamisIboxSdecPosition;
use App\Models\Iboards\Camis\Master\Wards;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HistoryCamisIboxSdecPatientPosition extends Model
{
    protected $guarded          = [];
    protected $connection       = 'mysql_data_history';
    protected $table            = 'history_camis_ibox_patient_sdec_postion';
    public $timestamps          = false;

    public function PatientPosition()
    {
        return $this->hasOne(CamisIboxSdecPosition::class,'camis_patient_id','camis_patient_id');
    }
}
