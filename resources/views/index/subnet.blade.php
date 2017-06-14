@extends('index.main')
@section('content')

<h2 class="page-header">Subnet tracking</h2>
<p><span class="label label-info">Info</span>&nbsp;Showing last {{ $range }} records.</p>
<form action="{{ url('status') }}" method="get">
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1"><span class="label label-success">Show last: </span></span>
        <input class="form-control" type="text" name="range" placeholder="Enter a numerical value and hit enter">
    </div>
</form>
<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>IP</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
    @foreach($data as $ip)
        <tr>
            <th scope="row">{{ $i }}</th>
            <td>{{ $ip->ppp0_ip }}</td>
            <td>{{ $ip->created_at }}</td>
        </tr>
    <?php $i++; ?>
    @endforeach
    </tbody>
</table>
{!! $data->render() !!}
<div class="otpusti"></div>
<div class="row"><canvas id="status"></canvas></div>

<script>

var data = [
    <?php $i = 0; ?>
    @foreach($prefixes as $k => $v)
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