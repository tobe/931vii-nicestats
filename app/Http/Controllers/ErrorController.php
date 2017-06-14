<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Stats;

class ErrorController extends BaseController {

    public function errors(Request $request) {
        $range    = $request->get('range', 10);
        $specific = $request->get('specific', NULL);
        if(!is_numeric($range)) abort(404);
        if(isset($specific) && !is_numeric($specific)) abort(404); // optional

        if(isset($specific)) {
            $errors = Stats::whereBetween('id', array($specific-1, $specific+1))->orderBy('id', 'DESC')->get(['errors', 'created_at', 'id']);
        }else {
            $errors = Stats::orderBy('id', 'DESC')->get(['errors', 'created_at', 'id'])->take($range);
        }

        $_errors        = [];
        $up_errors      = [];
        $down_errors    = [];
        $link_time      = [];
        $j = 0;
        foreach($errors as $error) {
            $json = json_decode($error->errors, true);
            if($specific == $error->id) { $_specific = $j; }
            $i = 0;
            $link_time[] = $error->created_at->toDateTimeString();
            for($i = 1; $i < count($json[0]); $i++) {
                preg_match('#([0-9]*)\s*([0-9]*)#', trim($json[0][$i]), $res);
                $down_errors[$i][] = $res[1];
                $up_errors[$i][]   = $res[2];
            }
            $j++;
        }

        $link_time   = array_reverse($link_time);

        $down_data      = [];
        $up_data        = [];
        $labels         = '["' . implode('", "', $link_time) . '"]';
        $label_names    = ['FEC', 'CRC', 'ES', 'SES', 'UAS', 'LOS', 'LOF', 'LOM'];
        $fillColor      = ['rgba(226, 0, 116, 0.8)', 'rgba(52, 152, 219,1.0)', 'rgba(155, 89, 182,1.0)', 'rgba(52, 73, 94,1.0)', 'rgba(230, 126, 34,1.0)', 'rgba(230, 126, 34,1.0)', 'rgba(189, 195, 199,1.0)', 'rgba(44, 62, 80,1.0)'];
        foreach($down_errors as $an_error) {
            $an_error = array_reverse($an_error);
            $down_data[] = '[' . implode(',', $an_error) . ']';
        }
        foreach($up_errors as $an_error) {
            $an_error = array_reverse($an_error);
            $up_data[]   = '[' . implode(',', $an_error) . ']';
        }

        // This fixes if we query for the last specific result because our chart doesn't have three values, there isn't last+1 in the database!
        if(($errors[count($errors)-1]->id+1) == (int)$specific) $_specific = 1;

        return view('index.errors', [
            'down_data'     => $down_data,
            'up_data'       => $up_data,
            'range'         => $range,
            'labels'        => $labels,
            'label_names'   => $label_names,
            'fillColor'     => $fillColor,
            '_specific'     => (isset($_specific) ? $_specific : NULL),
            'specific'      => (isset($specific) ? $specific : NULL),
        ]);
    }
}