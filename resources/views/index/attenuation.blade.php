@extends('index.main')
@section('content')

<h2 class="page-header">Upstream attenuation</h2>
<h3 class="page-header"><a name="upstream_line_attenuation">Line attenuation</a></h3>
<p><span class="label label-info">Info</span>&nbsp;Showing last {{ $range }} meterings.</p>
<div class="row"><canvas id="upstream_attenuation"></canvas></div>
<div class="otpusti"></div>
<h3 class="page-header"><a name="upstream_signal_attenuation">Signal attenuation</a></h3>
<p><span class="label label-info">Info</span>&nbsp;Showing last {{ $range }} meterings.</p>
<div class="row"><canvas id="upstream_attenuation2"></canvas></div>

<div class="otpusti"></div>

<h2 class="page-header">Downstream attenuation</h2>
<h3 class="page-header"><a name="downstream_line_attenuation">Line attenuation</a></h3>
<p><span class="label label-info">Info</span>&nbsp;Showing last {{ $range }} meterings.</p>
<div class="otpusti"></div>
<div class="row"><canvas id="downstream_attenuation"></canvas></div>
<div class="otpusti"></div>
<h3 class="page-header"><a name="downstream_signal_attenuation">Signal attenuation</a></h3>
<p><span class="label label-info">Info</span>&nbsp;Showing last {{ $range }} meterings.</p>
<div class="row"><canvas id="downstream_attenuation2"></canvas></div>
<script>
var up_line_attenuation = {
    labels: {!! $labels !!},

    datasets: [
        @for ($i = 0; $i < 3; $i++)
            {
                label: <?php echo '"' . $label_names[$i] . '",' . PHP_EOL; ?>
                //fillColor: "<?php echo $fillColor[$i]; ?>",
                fillColor: "rgba(255, 255, 255, 0)",
                strokeColor: "<?php echo $fillColor[$i]; ?>",
                pointColor: "<?php echo $fillColor[$i]; ?>",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "<?php echo $fillColor[$i]; ?>",
                data: {{ $line_attenuation[$i] }},
            },
        @endfor
    ]
};
var up_signal_attenuation = {
    labels: {!! $labels !!},

    datasets: [
        @for ($i = 0; $i < 3; $i++)
            {
                label: <?php echo '"' . $label_names[$i] . '",' . PHP_EOL; ?>
                fillColor: "rgba(255, 255, 255, 0)",
                strokeColor: "<?php echo $fillColor[$i]; ?>",
                pointColor: "<?php echo $fillColor[$i]; ?>",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "<?php echo $fillColor[$i]; ?>",
                data: {{ $signal_attenuation[$i] }},
            },
        @endfor
    ]
};
var down_line_attenuation = {
    labels: {!! $labels !!},

    datasets: [
        @for ($i = 3; $i < 6; $i++)
            {
                label: <?php echo '"' . $label_names[$i] . '",' . PHP_EOL; ?>
                fillColor: "rgba(255, 255, 255, 0)",
                strokeColor: "<?php echo $fillColor[$i]; ?>",
                pointColor: "<?php echo $fillColor[$i]; ?>",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "<?php echo $fillColor[$i]; ?>",
                data: {{ $line_attenuation[$i] }},
            },
        @endfor
    ]
};
var down_signal_attenuation = {
    labels: {!! $labels !!},

    datasets: [
        @for ($i = 3; $i < 6; $i++)
            {
                label: <?php echo '"' . $label_names[$i] . '",' . PHP_EOL; ?>
                fillColor: "rgba(255, 255, 255, 0)",
                strokeColor: "<?php echo $fillColor[$i]; ?>",
                pointColor: "<?php echo $fillColor[$i]; ?>",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "<?php echo $fillColor[$i]; ?>",
                data: {{ $signal_attenuation[$i] }},
            },
        @endfor
    ]
};
line_options = {bezierCurve: false,scaleShowGridLines: true}
// Upstream line att
var ctx = document.getElementById("upstream_attenuation").getContext("2d");
new Chart(ctx).Line(up_line_attenuation, line_options);
// Upstream signal att
var ctx = document.getElementById("upstream_attenuation2").getContext("2d");
new Chart(ctx).Line(up_signal_attenuation, line_options);
// Downstream line att
var ctx = document.getElementById("downstream_attenuation").getContext("2d");
new Chart(ctx).Line(down_line_attenuation, line_options);
// Downstream signal att
var ctx = document.getElementById("downstream_attenuation2").getContext("2d");
new Chart(ctx).Line(down_signal_attenuation, line_options);
</script>
@stop