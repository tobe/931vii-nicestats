<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URI;
use \App\PbStats;

class AttenuationController extends BaseController {

    public $label_names = ['U0', 'U1', 'U2', 'D0', 'D1', 'D2'];
    public $fillColor   = ['rgba(226, 0, 116, 1.0)', 'rgba(52, 152, 219,1.0)', 'rgba(155, 89, 182,1.0)', 'rgba(52, 73, 94,1.0)', 'rgba(230, 126, 34,1.0)', 'rgba(39, 174, 96,1.0)', 'rgba(189, 195, 199,1.0)', 'rgba(44, 62, 80,1.0)'];
    public $range;

    public function __construct(Request $request) {
        $this->range = $request->get('range', 10);
    }

    private function processArray($data, $query, $loops = 6) {
        $arr        = array_fill(0, $loops, NULL);
        $link_time  = [];

        $i = 0;
        foreach($data as $d) {
            $q           = explode(',', $d->{$query});
            $link_time[] = $d->created_at->toDateTimeString();
            for($j = 0; $j < count($q); $j++) {
                //$arr[$j] .= $q[$j] . ',';
                //$arr[$j] .= $q[count($q)-($j+1)] . ',';
                $arr[$j][] = $q[$j];
            }
            $i++;
        }

        $out = [];
        for($i = 0; $i < count($arr); $i++) {
            $arr[$i] = array_reverse($arr[$i]);
            $out[] = '[' . implode(',', $arr[$i]) . ']';
        }

        return array($out, array_reverse($link_time));
    }


    public function index(Request $request) {
        $data = PbStats::orderBy('id', 'DESC')->get(['line_attenuation', 'signal_attenuation', 'created_at'])->take($this->range);

        $line_attenuation   = array_fill(0, 6, NULL);
        $signal_attenuation = array_fill(0, 6, NULL);
        $link_time          = [];

        $i = 0;
        foreach($data as $d) {
            $line_attn   = explode(',', $d->line_attenuation);
            $signal_attn = explode(',', $d->signal_attenuation);
            $link_time[] = $d->created_at->toDateTimeString();
            for($j = 0; $j < count($line_attn); $j++) {
                $line_attenuation[$j][]     = $line_attn[$j];
                $signal_attenuation[$j][]   = $signal_attn[$j];
            }
            $i++;
        }

        // Make it an actual JS array and reverse the crap so it goes in the right way.
        $out_line   = [];
        $out_signal = [];
        for($i = 0; $i < count($line_attenuation); $i++) {
            $line_attenuation[$i]   = array_reverse($line_attenuation[$i]);
            $signal_attenuation[$i] = array_reverse($signal_attenuation[$i]);
            $out_line[]             = '[' . implode(',', $line_attenuation[$i]) . ']';
            $out_signal[]           = '[' . implode(',', $signal_attenuation[$i]) . ']';
        }

        // Reverse the link time array so it goes in the right directionnnnnnnnn (8)
        $link_time = array_reverse($link_time);

        // Pass onto view.
        return view('index.attenuation', [
            'line_attenuation'   => $out_line,
            'signal_attenuation' => $out_signal,
            'data'               => $data,
            'range'              => $this->range,
            'labels'             => '["' . implode('", "', $link_time) . '"]',
            'label_names'        => $this->label_names,
            'fillColor'          => $this->fillColor
        ]);
    }

    public function snr() {
        $data = PbStats::orderBy('id', 'DESC')->get(['snr_margin', 'created_at'])->take($this->range);

        $snr_data = $this->processArray($data, 'snr_margin');

        return view('index.snr', [
            'range'         =>  $this->range,
            'label_names'   =>  $this->label_names,
            'fillColor'     =>  $this->fillColor,
            'data'          =>  $snr_data[0],
            'labels'        =>  '["' . implode('", "', $snr_data[1]) . '"]',
        ]);
    }

    public function sync() {
        $data = PbStats::orderBy('id', 'DESC')->get(['attainable_rate', 'actual_rate', 'created_at'])->take($this->range);

        $attainable_rate = $this->processArray($data, 'attainable_rate', 2);
        $actual_rate    = $this->processArray($data, 'actual_rate', 2);

        return view('index.sync', [
            'range'             =>  $this->range,
            'label_names'       =>  ['TX Attainable', 'RX Attainable', 'TX Actual', 'RX Actual'],
            'fillColor'         =>  $this->fillColor,
            'attainable_data'   =>  $attainable_rate[0],
            'actual_data'       =>  $actual_rate[0],
            'labels'            =>  '["' . implode('", "', $attainable_rate[1]) . '"]', // doesn't matter as they are same
        ]);
    }

    public function power() {
        $data = PbStats::orderBy('id', 'DESC')->get(['tx_power', 'actual_tx', 'created_at'])->take($this->range);

        $tx_power   = $this->processArray($data, 'tx_power');
        $actual_tx  = $this->processArray($data, 'actual_tx', 2);

        return view('index.power', [
            'range'             =>  $this->range,
            'label_names'       =>  $this->label_names,
            'actual_labels'     =>  ['Downstream', 'Upstream'],
            'fillColor'         =>  $this->fillColor,
            'actual_fillColor'  =>  ['rgba(255, 0, 0, 1)', 'rgba(0, 255, 0, 1)'],
            'tx_power'          =>  $tx_power[0],
            'actual_tx'         =>  $actual_tx[0],
            'labels'            =>  '["' . implode('", "', $actual_tx[1]) . '"]', // doesn't matter as they are same
        ]);
    }
}