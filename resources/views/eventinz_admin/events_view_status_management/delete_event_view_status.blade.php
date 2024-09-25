@extends('eventinz_admin.layouts.app')

@section('content_admin')
    
<div class="card card-danger">
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
      <h3 class="card-title">Delete Event view status</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.delete.eventviewstatus', $eventViewStatusFound->id) }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="alert alert-warning">
            <input type="number" hidden value="{{ $eventViewStatusFound->id }}" name="id">
            Confirm to delete this Event Type: <strong>{{ $eventViewStatusFound->name }}</strong>
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="{{ route('admin.list.eventviewstatus') }}" class="btn btn-default"><i class="fas fa-times"></i>No</a>
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>Submit</button>
      </div>
    </form>
  </div>
@endsection