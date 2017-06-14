@extends('index.main')
@section('content')

<h2 class="page-header">Raw output</h2>
<p><span class="label label-info">Info</span>&nbsp;Showing the raw output for id {{ $id }}.</p>
<pre style="width: 100%;">
    {{ $data }}
</pre>
@stop