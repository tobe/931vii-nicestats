@extends('index.main')
@section('content')

<h2 class="page-header">Miscellaneous information</h2>
<p><span class="label label-info">Info</span>&nbsp;Showing last {{ $range }} line anomalies.</p>
<form action="{{ url('status') }}" method="get">
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1"><span class="label label-success">Show last: </span></span>
        <input class="form-control" type="text" name="range" placeholder="Enter a numerical value and hit enter">
    </div>
</form>
<div class="otpusti"></div>
<div class="row"><canvas id="status"></canvas></div>

<script>

var data = [
    <?php $i = 0; ?>
    @foreach($data as $k => $v)
    {
        value: {{ $v }},
        label: "{{ $k }}",
        color: "{{ $colors[$i] }}",
        <?php $i++; ?>
    },
    @endforeach
];
var ctx = document.getElementById("status").getContext("2d");
new Chart(ctx).PolarArea(data);
</script>
@stop