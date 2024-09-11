@extends('eventinz_admin.layouts.app')

@section('content_admin')
    
<div class="card card-primary">

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

    <div class="card-header">
      <h3 class="card-title">View Details</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.update.paymenttaxe', $taxeFound->id) }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name <span style="color: red"><strong>*</strong></span></label>
          <input value="{{ $taxeFound->name ?? " " }}" name="name" id="name" class="form-control  @error('name') is-invalid @enderror">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="value">value <span style="color: red"><strong>*</strong></span></label>
          <input value="{{ $taxeFound->value ?? " " }}" step="0.01" type="number" name="value" id="value" class="form-control  @error('value') is-invalid @enderror">
          @error('value') <p> {{ $message }} </p> @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"> Update Taxe</i>
        </button>
      </div>
    </form>
  </div>
@endsection