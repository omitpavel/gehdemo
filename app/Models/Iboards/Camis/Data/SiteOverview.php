<?php

namespace App\Models\Iboards\Camis\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteOverview extends Model
{
    use HasFactory;


    protected $connection   = 'mysql_camis_data';
    protected $table        = 'sp_ibox_patient_flow_dashboard';

    public static function DashboardWeek($date)
    {
       $output =  "CALL ngh_ibox_camis_data.sp_ibox_patient_flow_dashboard_week('".$date."')";
        return DB::select($output);
    }
    public static function Dashboard($date)
    {
        $output =  "CALL ngh_ibox_camis_data.sp_ibox_patient_flow_dashboard('".$date."')";
        return DB::select($output);
    }
}
