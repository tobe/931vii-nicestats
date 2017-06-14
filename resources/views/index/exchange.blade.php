@extends('index.main')
@section('content')

<h2 class="page-header">Local Exchange</h2>
<p><span class="label label-info">Vendor ID</span>&nbsp;{{ $id }}</p>
<p><span class="label label-success">Vendor version number</span>&nbsp;{{ $version_number }}</p>
<p><span class="label label-danger">Make</span>&nbsp;{{ $make }}</p>
@stop