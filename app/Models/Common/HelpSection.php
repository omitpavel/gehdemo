<?php


namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use DB;

class HelpSection extends Model
{
    protected $connection   = 'mysql_settings';
    protected $table        = 'ibox_help_sections';

    public static function ReturnTableName()
    {
        return RetriveCamisDbNameForModalOperations().".ibox_help_sections";
    }

    public static function ReturnConnectionTableName()
    {
        return 'mysql_settings.ibox_help_sections';
    }
}
