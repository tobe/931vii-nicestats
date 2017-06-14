@extends('index.main')
@section('content')
<h2 class="page-header">SNR Margin</h2>
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
                data: {{ $data[$i] }},
            },
        @endfor
    ]
};
line_options = {bezierCurve: false,scaleShowGridLines: true}
// Chartyyyyyyyyyyyyyy
var ctx = document.getElementById("charty").getContext("2d");
new Chart(ctx).Line(data, line_options);
</script>
@stop