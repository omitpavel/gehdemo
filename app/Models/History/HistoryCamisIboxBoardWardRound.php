<?php

namespace App\Models\History;
use App\Models\Common\User;
use App\Models\Iboards\Camis\Master\Wards;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HistoryCamisIboxBoardWardRound extends Model
{
    protected $guarded          = [];
    protected $connection       = 'mysql_data_history';
    protected $table            = 'history_camis_ibox_ward_round';
    public $timestamps          = false;

    public function User()
    {
        return $this->belongsTo(User::class,'id','user_id');
    }
    public function Ward()
    {
        return $this->belongsTo(Wards::class,'ward_id');
    }

    public static function AttendanceHistory($date)
    {
        $output =  "CALL ngh_ibox_camis_data.sp_board_round_attendance('".$date."')";
        return DB::select($output);
    }

    public static function BoardRoundSummery($start_date,$end_date)
    {
        $output =  "CALL ngh_ibox_camis_data.sp_aande2_board_round_summary('$start_date','$end_date')";
        return DB::select($output);
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_data_history","ibox_constant_database_names").".history_camis_ibox_ward_round";
    }

    public function getAmPercentageAttribute()
    {
        return $this->am == 0 ? 0 : 20;
    }

    public function getPmPercentageAttribute()
    {
        return $this->pm == 0 ? 0 : 20;
    }

    public function getTotalAttribute()
    {
        return ($this->am_percentage + $this->pm_percentage) / 2;
    }

    public function getWeekAttribute()
    {
        $currentDate = now()->startOfWeek();
        $diffInWeeks = $this->day->diffInWeeks($currentDate);

        switch ($diffInWeeks) {
            case 0:
                return 'Current';
            case 1:
                return 'Week-1';
            case 2:
                return 'Week-2';
            case 3:
                return 'Week-3';
            default:
                return 'Unknown';
        }
    }
}
