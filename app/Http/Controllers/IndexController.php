<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URI;
use \App\Stats;
use \App\PbStats;

class IndexController extends BaseController {
    public function index() {
        $stats = Stats::orderBy('id', 'DESC')->paginate(5);

        return view('index.status', ['stats' => $stats]);
    }

    public function status(Request $request) {
        $range = $request->get('range', 10);
        if(!is_numeric($range)) abort(404);
        $keys  = ['mode', 'vdsl2_profile', 'tps_tc', 'trellis', 'line_status', 'training_status'];
        $stats = Stats::orderBy('id', 'DESC')->get($keys)->take($range);

        // Shove this into the view.
        $_stats = [];
        foreach($stats as $a_stat) {
            foreach($keys as $key) {
                if(!array_key_exists($a_stat->$key, $_stats)) $_stats[$a_stat->$key] = 0;
                $_stats[$a_stat->$key]++;
            }
        }

        return view('index._status', [
            'range'  => $range,
            'data'   => $_stats,
            'colors' => ['#1abc9c', '#2980b9', '#8e44ad', '#e74c3c', '#34495e', '#f39c12', '#7f8c8d']
        ]);
    }

    public function raw($id, Request $request) {
        $raw_data = Stats::where('id', '=', $id)->firstOrFail()->get(['raw']);

        return view('index.raw', [
            'id'    =>  $id,
            'data'  =>  $raw_data[0]->raw
        ]);
    }
}