@extends('index.main')
@section('content')
<h2 class="page-header">Output Power</h2>
<p><span class="label label-info">Info</span>&nbsp;Showing last {{ $range }} meterings.</p>
<div class="row"><canvas id="charty"></canvas></div>

<script>
var data = {
    labels: {!! $labels !!},

    datasets: [
        @for ($i = 0; $i < 6; $i++)
            {
                label: <?php echo '"' . $label_names[$i] . '",' . PHP_EOL; ?>
                //fillColor: "<?php echo $fillColor[$i]; ?>",
                fillColor: "rgba(255, 255, 255, 0)",
                strokeColor: "<?php echo $fillColor[$i]; ?>",
                pointColor: "<?php echo $fillColor[$i]; ?>",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "<?php echo $fillColor[$i]; ?>",
                data: {{ $tx_power[$i] }},
            },
        @endfor
        @for ($i = 0; $i < 2; $i++)
            {
                label: <?php echo '"' . $actual_labels[$i] . '",' . PHP_EOL; ?>
                //fillColor: "<?php echo $fillColor[$i]; ?>",
                fillColor: "rgba(255, 255, 255, 0)",
                strokeColor: "<?php echo $actual_fillColor[$i]; ?>",
                pointColor: "<?php echo $actual_fillColor[$i]; ?>",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "<?php echo $actual_fillColor[$i]; ?>",
                data: {{ $actual_tx[$i] }},
            },
        @endfor
    ]
};
line_options = {bezierCurve: false,scaleShowGridLines: true,scaleGridLineColor : "rgba(0,0,0,0.1)",}
// Chartyyyyyyyyyyyyyy
var ctx = document.getElementById("charty").getContext("2d");
new Chart(ctx).Line(data, line_options);
</script>
@stop