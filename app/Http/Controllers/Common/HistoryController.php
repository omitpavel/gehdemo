<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;
use File;
use DB;

use App\Models\Common\IboxSettings;
use App\Models\Common\FlashMessage;
use App\Models\Common\User;
use App\Models\Iboards\Symphony\Master\BreachReason;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Symfony\Component\HttpFoundation\Session\Session;

class HistoryController extends Controller
{

    public function HistoryTableDataInsertFromUpdateCreate($process_array, $modal_name, $history_reason = 1)
    {
        $updated_array                                      = $process_array->getOriginal();
        $insert_array                                       = array();
        if (CheckCountArrayToProcess($updated_array))
        {
            foreach ($updated_array as $key => $row)
            {
                $insert_array[$key]                     = $row;
            }
            $insert_array['history_status']          = $history_reason;
            if (count($insert_array) > 1)
            {
                $modal_name::insert($insert_array);
            }
        }
    }
    public function HistoryTableDataInsertFromUpdate($process_array, $modal_name, $history_reason = 2)
    {
        $updated_array                                      = $process_array;
        $insert_array                                       = array();
        if (CheckCountArrayToProcess($updated_array))
        {
            foreach ($updated_array as $key => $row)
            {
                $insert_array[$key]                     = $row;
            }
            $insert_array['history_status']          = $history_reason;
            if (count($insert_array) > 1)
            {
                $modal_name::insert($insert_array);
            }
        }
    }

    public function HistoryTableDataInsertFromInsert($process_array, $modal_name, $history_reason = 1)
    {
        $updated_array                                      = $process_array;
        $insert_array                                       = array();
        if (CheckCountArrayToProcess($updated_array))
        {
            foreach ($updated_array as $key => $row)
            {
                $insert_array[$key]                     = $row;
            }
            $insert_array['history_status']          = $history_reason;
            if (count($insert_array) > 1)
            {
                $modal_name::insert($insert_array);
            }
        }
    }

    public function HistoryTableDataInsertFromDelete($process_array, $modal_name, $history_reason = 3)
    {
        $updated_array                                      = $process_array;
        $insert_array                                       = array();
        if (CheckCountArrayToProcess($updated_array))
        {
            foreach ($updated_array as $key => $row)
            {
                if ($key == 'created_at') {

                    $insert_array[$key]                     = date('Y-m-d H:i:s', strtotime($row));
                } else {
                    $insert_array[$key]                     = $row;
                }
            }
            $insert_array['history_status']          = $history_reason;
            if (count($insert_array) > 1)
            {
                $insert_array['updated_at'] = now()->format('Y-m-d H:i:s');
                $modal_name::insert($insert_array);
            }
        }
    }
}
