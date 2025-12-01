<?php

namespace App\Models\History;

use App\Models\Common\User;
use Illuminate\Database\Eloquent\Model;

class HistoryCamisIboxBoardDtocComment extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_data_history';
    protected $table        = 'history_camis_ibox_board_round_dtoc_comments_sec';
    public $timestamps      = false;

    public function GetTableNameWithConnection()
    {
        $connectionName     = $this->getConnectionName();
        $tableName          = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }


}
