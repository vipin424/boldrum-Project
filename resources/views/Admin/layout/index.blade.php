@extends('admin.layout.master')
@section('content')
<div id="wrapper">
<!-- MAIN -->
<div class="main">
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">
<!-- OVERVIEW -->
<div class="panel panel-headline">
<div class="panel-heading">
<h3 class="panel-title">Dashboard</h3>
<!--  <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p> -->
</div>
<div class="panel-body">
<div class="row">
<div class="col-md-3">
<div class="metric">
<span class="icon"><i class="fa fa-download"></i></span>
<p>
<span class="number">0</span>
<span class="title">Ballrooms</span>
</p>
</div>
</div>
<div class="col-md-3">
<div class="metric">
<span class="icon"><i class="fa fa-shopping-bag"></i></span>
<p>
<span class="number">0</span>
<span class="title">Orders</span>
</p>
</div>
</div>
<div class="col-md-3">
<div class="metric">
<span class="icon"><i class="fa fa-eye"></i></span>
<p>
<span class="number">0</span>
<span class="title">Visits</span>
</p>
</div>
</div>
<div class="col-md-3">
<div class="metric">
<span class="icon"><i class="fa fa-bar-chart"></i></span>
<p>
<span class="number">0</span>
<span class="title">Materials</span>
</p>
</div>
</div>
</div>
<!-- END REALTIME CHART -->
</div>
</div>
</div>
</div>
<!-- END MAIN CONTENT -->
</div>
</div>
@endsection