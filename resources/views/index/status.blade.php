@extends('index.main')
@section('content')

<h2 class="page-header">Status</h2>
    <p><span class="label label-info">IP</span>&nbsp;<code><?php echo $_SERVER['REMOTE_ADDR']; ?></code></p>
    <p><span class="label label-success">Version</span>&nbsp;<code>nicestats 1.0.0-purplehaze</code></p>
    <form action="{{ url('errors') }}" method="get">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1"><span class="label label-default">Go to</span></span>
            <select class="form-control form-inline">
                @if(count($stats) != 0)
                    @foreach ($stats as $stat)
                        <option value="{{ $stat->id }}" name="specific" onclick="window.location.href = '{{ url('raw') }}/{{ $stat->id }}';">{{ $stat->created_at }}</option>
                    @endforeach
                @else
                    <option value="#" disabled>There is nothing here.</option>
                @endif
            </select>
        </div>
    </form>
<div class="otpusti"></div>
<h2 class="page-header">Previous meterings</h2>
   <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Time and date</th>
                <th>Defects?</th>
            </tr>
        </thead>
        <tbody>
            @if(count($stats) != 0)
                @foreach ($stats as $stat)
                    <tr onclick="window.location.href = '{{ url('raw') }}/{{ $stat->id }}';">
                        <th scope="row" class="col-md-2">{{ $stat->id }}</th>
                        <td class="col-md-6">{{ $stat->created_at }}</td>
                        <td class="col-md-5">{{ $stat->line_status }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th scope="row" class="col-md-2">There is nothing here.</th>
                    <td class="col-md-6">&nbsp;</td>
                    <td class="col-md-5">&nbsp;</td>
                </tr>
            @endif
        </tbody>
    </table>
    {!! $stats->render() !!}

@stop