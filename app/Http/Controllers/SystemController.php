<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\System;

class SystemController extends BaseController {
    public $range;

    public function __construct(Request $request) {
        $this->range = $request->get('range', 10);
    }

    public function exchange() {
        $data = System::orderBy('id', 'DESC')->get(['vendor'])->last();

        $vendor = explode(':', $data->vendor);

        switch($vendor[0]) {
            default:
                $make = 'Unknown';
            break;
            case 'BDCM':
                $make = 'Broadcom: Ericsson 8b / Huawei 17a';
            break;
            case 'IFTN':
                $make = 'Siemens ADSL';
            break;
        }

        return view('index.exchange', [
            'id'               =>  $vendor[0],
            'version_number'   =>  $vendor[1],
            'make'             =>  $make
        ]);
    }

    public function subnet() {
        $data = System::orderBy('id', 'DESC')->paginate($this->range);

        $prefixes = [];
        foreach($data as $ips) {
            // Get the prefix
            $prefix = explode('.', $ips->ppp0_ip)[0];
            if(!array_key_exists($prefix, $prefixes)) {
                $prefixes[$prefix] = 1;
            }else {
                $prefixes[$prefix]++;
            }
        }

        return view('index.subnet', [
            'range'     => $this->range,
            'data'      => $data,
            'prefixes'  => $prefixes,
            'colors'    => ['#1abc9c', '#2980b9', '#8e44ad', '#e74c3c', '#34495e', '#f39c12', '#7f8c8d']
        ]);
    }

    public function system() {
        // Get the data
        $data = System::orderBy('id', 'DESC')->get()->take($this->range);

        $link_time = [];

        $ram_used = '[';
        $ram_free = '[';
        foreach($data as $item) {
            $ram_used    .= $item->ram_used . ',';
            $ram_free    .= $item->ram_free . ',';
            $link_time[]  = '"' . $item->created_at->toDateTimeString() . '"';
        }
        $ram_used = substr($ram_used, 0, -1) . ']';
        $ram_free = substr($ram_free, 0, -1) . ']';

        return view('index.system', [
            'last_ip'       =>  $data[count($data)-1]->ppp0_ip,
            'last_uptime'   =>  $data[count($data)-1]->uptime,
            'last_loadavg'  =>  $data[count($data)-1]->loadavg,
            'last_ram_used' =>  $data[count($data)-1]->ram_used,
            'last_ram_free' =>  $data[count($data)-1]->ram_free,
            'ram_used'      =>  $ram_used,
            'ram_free'      =>  $ram_free,
            'label_names'   =>  ['Used', 'Free'],
            'labels'        =>  '[' . implode(',', array_reverse($link_time)) . ']',
            'fillColor'     =>  ['rgba(226, 0, 116, 1.0)', 'rgba(52, 152, 219,1.0)'],
            'range'         =>  $this->range,
        ]);
    }
}