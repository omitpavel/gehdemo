<?php

namespace App\Models\Iboards\Camis\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CamisIboxDoctorAtNightComment extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_virtual_ward_doctor_at_night_comments';

    public function PatientInformationWithBedDetails()
    {
        return $this->belongsTo(CamisIboxWardPatientInformationWithBedDetailsView::class, 'patient_id', 'camis_patient_id');
    }

    public function GetTableNameWithConnection()
    {
        $connection_name    = $this->getConnectionName();
        $table_name         = $this->getTableName();
        return $connection_name . '.' . $table_name;
    }
}
