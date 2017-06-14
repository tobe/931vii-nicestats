@extends('index.main')
@section('content')
<h2 class="page-header">System information</h2>
<p><span class="label label-default">Last IP</span>&nbsp;{{ $last_ip }}</p>
<p><span class="label label-primary">Uptime</span>&nbsp;{{ round($last_uptime/86400, 3) }} days</p>
<p><span class="label label-success">Load average</span>&nbsp;{{ $last_loadavg }}</p>
<p><span class="label label-info">RAM Used</span>&nbsp;{{ $last_ram_used/1000 }} MB</p>
<p><span class="label label-warning">RAM Free</span>&nbsp;{{ $last_ram_free/1000 }} MB</p>
<p><span class="label label-danger">Info</span>&nbsp;Showing last {{ $range }} RAM usage graphs.</p>
<div class="row"><canvas id="charty"></canvas></div>

<script>
var data = {
    labels: {!! $labels !!},

    datasets: [
        {
            label: "Used",
            fillColor: "rgba(255, 255, 255, 0)",
            strokeColor: "rgba(226, 0, 116, 1.0)",
            pointColor: "rgba(226, 0, 116, 1.0)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(226, 0, 116, 1.0)",
            data: {{ $ram_used }},
        },
        {
            label: "Free",
            fillColor: "rgba(255, 255, 255, 0)",
            strokeColor: "rgba(52, 152, 219,1.0)",
            pointColor: "rgba(52, 152, 219,1.0)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(52, 152, 219,1.0)",
            data: {{ $ram_free }},
        }
    ]
};
line_options = {bezierCurve: false,scaleShowGridLines: true}
// Chartyyyyyyyyyyyyyy
var ctx = document.getElementById("charty").getContext("2d");
new Chart(ctx).Line(data, line_options);
</script>
@stop