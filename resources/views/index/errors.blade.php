@extends('index.main')
@section('content')

<h2 class="page-header">RX errors</h2>
@if($specific)
    <p><span class="label label-info">Info</span>&nbsp;Showing error stats for ID {{ $specific }}.</p>
@else
    <p><span class="label label-info">Info</span>&nbsp;Showing last {{ $range }} errors.</p>
@endif
<div class="row"><canvas id="down_data"></canvas></div>
<div class="otpusti"></div>
<h2 class="page-header">TX errors</h2>
@if($specific)
    <p><span class="label label-info">Info</span>&nbsp;Showing error stats for ID {{ $specific }}.</p>
@else
    <p><span class="label label-info">Info</span>&nbsp;Showing last {{ $range }} errors.</p>
@endif
<div class="row"><canvas id="up_data"></canvas></div>

<script>
var down_data = {
    labels: {!! $labels !!},

    datasets: [
        <?php $i = 0; ?>
        @foreach ($down_data as $down_errors)
            {
                label: <?php echo '"' . $label_names[$i] . '",' . PHP_EOL; ?>
                fillColor: "<?php echo $fillColor[$i]; ?>",
                strokeColor: "<?php echo $fillColor[$i]; ?>",
                pointColor: "<?php echo $fillColor[$i]; ?>",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "<?php echo $fillColor[$i]; ?>",
                data: {{ $down_errors }},
                <?php $i++; ?>
            },
        @endforeach
    ]
};
var up_data = {
    labels: {!! $labels !!},

    datasets: [
        <?php $i = 0; ?>
        @foreach ($up_data as $up_errors)
            {
                label: <?php echo '"' . $label_names[$i] . '",' . PHP_EOL; ?>
                fillColor: "<?php echo $fillColor[7-$i]; ?>",
                strokeColor: "<?php echo $fillColor[7-$i]; ?>",
                pointColor: "<?php echo $fillColor[7-$i]; ?>",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "<?php echo $fillColor[7-$i]; ?>",
                data: {{ $up_errors }},
                <?php $i++; ?>
            },
        @endforeach
    ]
};
line_options = {
        bezierCurve: false,
        scaleShowGridLines: false,
}
var ctx = document.getElementById("down_data").getContext("2d");
var myLineChart1 = new Chart(ctx).Line(down_data, line_options);
var ctx = document.getElementById("up_data").getContext("2d");
var myLineChart2 = new Chart(ctx).Line(up_data, line_options);
@if(isset($_specific))
myLineChart1.datasets[0].points[{{ $_specific }}].fillColor =   "rgba(000,000,000,1)" ;
myLineChart1.update();
@endif
</script>
@stop