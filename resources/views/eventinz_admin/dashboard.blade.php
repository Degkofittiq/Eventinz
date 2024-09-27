@extends('eventinz_admin.layouts.app')

@section('content_admin')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Welcome to the Admin Area</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Starter Page</li>
      </ol>
    </div><!-- /.col -->
  </div>
@endsection