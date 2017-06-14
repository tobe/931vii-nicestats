<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title>nicestats 1.0.0-purplehaze</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ url() }}/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ url() }}/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{ url() }}/dist/js/Chart3.min.js"></script>
    <script>
        Chart.defaults.global.responsive = true;
        Chart.defaults.global.showXLabels = 5;
        Chart.defaults.global.multiTooltipTemplate = "<%= datasetLabel %>\t\t-\t<%= value %>";
        Chart.defaults.global.animation  = false;
    </script>
</head>

<body>

<nav class="navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        <span class="navbar-brand" href="#">ZXDSL 931VII</span>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <img src="dist/t-logo-desktop.png" class="img-responsive" style="margin: 10px 5px 10px 5px;">
                <li class="showhide"><a href="#">Dashboard</a></li>
                <li class="showhide"><a href="#">Settings</a></li>
                <li class="showhide"><a href="#">Profile</a></li>
                <li class="showhide"><a href="#">Help</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="{{ Request::is('/') ? 'active' : ''}}"><a href="{{ url('/') }}">Status</a></li>
                <li class="{{ Request::is('attenuation') ? 'active' : '' }}"><a href="{{ url('attenuation') }}">Attenuation</a></li>
                <ul class="under">
                    <li class="under_li"><a href="{{ url('attenuation') }}#upstream_line_attenuation">Upstream Line</a></li>
                    <li class="under_li"><a href="{{ url('attenuation') }}#upstream_signal_attenuation">Upstream Signal</a></li>
                    <li class="under_li"><a href="{{ url('attenuation') }}#downstream_line_attenuation">Downstream Line</a></li>
                    <li class="under_li"><a href="{{ url('attenuation') }}#downstream_signal_attenuation">Downstream Signal</a></li>
                </ul>
                <li class="{{ Request::is('snr') ? 'active' : '' }}"><a href="{{ url('snr') }}">SNR Margin</a></li>
                <li class="{{ Request::is('sync') ? 'active' : '' }}"><a href="{{ url('sync') }}">Sync Rates</a></li>
                <li class="{{ Request::is('power') ? 'active' : '' }}"><a href="{{ url('power') }}">Output Power</a></li>
                <li class="{{ Request::is('status') ? 'active' : '' }}"><a href="{{ url('status') }}">Miscellaneous</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li class="{{ Request::is('errors') ? 'active' : '' }}"><a href="{{ url('errors') }}">Errors</a></li>
                <li class="{{ Request::is('exchange') ? 'active' : '' }}"><a href="{{ url('exchange') }}">Local Exchange</a></li>
                <li class="{{ Request::is('subnet') ? 'active' : '' }}"><a href="{{ url('subnet') }}">Subnet Tracking</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li class="{{ Request::is('system') ? 'active' : '' }}"><a href="{{ url('system') }}">System</a></li>
                <li class="{{ Request::is('cron') ? 'active' : '' }}"><a href="{{ url('cron') }}">CRON Jobs</a></li>
            </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        @yield('content')
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="dist/js/j.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>
