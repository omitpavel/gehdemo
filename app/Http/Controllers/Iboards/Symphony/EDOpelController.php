<?php


namespace App\Http\Controllers\Iboards\Symphony;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Iboards\Symphony\Data\SymphonyEDThermometer;

class EDOpelController extends Controller
{
    public function Index()
    {

        return view('Dashboards.Symphony.EDOpel.Index');
    }
    public function IndexRefreshDataLoad(Request $request)
    {
        if($request->filled('date')){
            $date = $request->date;
        } else {
            $date = date('Y-m-d');
        }

        $time_wise_date = json_decode(file_get_contents('demo_data/ane/ed_opel_data.json'), true);

        $all_times = array_unique(array_keys($time_wise_date));

        $hours = [];

        for ($i = 0; $i < 24; $i++) {
            $hours[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
        }


        $custom_drop_down = ['' => '', 1 => 'YES', 2 => 'NO', 3 => 'N/A'];
        $opel_drop_down = ['' => '', 1 => 'EMS 1', 2 => 'EMS 2', 3 => 'EMS 3', 4 => 'EMS 4'];

        $view = View::make('Dashboards.Symphony.EDOpel.IndexDataLoad', compact('all_times', 'time_wise_date', 'date', 'hours', 'custom_drop_down', 'opel_drop_down'));
        $sections = $view->render();
        return $sections;
    }

}

