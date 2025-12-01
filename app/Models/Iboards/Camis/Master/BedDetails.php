<?php

namespace App\Models\Iboards\Camis\Master;

use App\Models\Iboards\Camis\Data\CamisIboxDischargeLoungePosition;
use Illuminate\Database\Eloquent\Model;

class BedDetails extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_master';
    protected $table        = 'master_ward_bed_details';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_master","ibox_constant_database_names").".master_ward_bed_details";
    }


    public static function ReturnConnectionTableName()
    {
        return 'mysql_camis_master.master_ward_bed_details';
    }

    public function BedGroupData()
    {
        return $this->belongsTo('App\Models\Iboards\Camis\BedGroup','bed_group_id','id');
    }


    public function DischargeLoungeBedDetails()
    {
        return $this->hasOne(CamisIboxDischargeLoungePosition::class, 'dischagre_lounge_bed_id', 'id');
    }


    public function WardPriorityTab()
    {
        return $this->belongsTo('App\Models\Iboards\Camis\WardTabPriority',['ward_id', 'bed_group_id', 'bed_group_number'], ['priority_ward_id', 'priority_bed_group_id', 'priority_bed_group_number']);
    }

    public function bedGroup()
    {
        return $this->belongsTo(BedGroup::class, 'bed_group_id', 'id');
    }

    public function getFullBedNameAttribute()
    {
        $bedGroupName = $this->bedGroup ? $this->bedGroup->bed_group_name : '';
        $bedGroupNumber = (!empty($this->bed_group_number) && $this->bed_group_number != 0) ? ' ' . $this->bed_group_number : '';
        $bedText = (!empty($this->bed_group_number) && $this->bed_group_number != 0) ? ' Bed ' : ' ';
        $bedNo = $this->bed_no;

        if ($this->bed_group_id != 5) {
            return $bedGroupName . $bedGroupNumber . $bedText . $bedNo;
        } else {
            return $bedGroupName . $bedGroupNumber . ' ' . $bedNo;
        }
    }
}
