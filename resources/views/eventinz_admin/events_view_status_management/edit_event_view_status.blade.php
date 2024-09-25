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
      <h3 class="card-title">Add new Event view status</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.update.eventtype',$eventViewStatusFound->id) }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name <span style="color: red"><strong>*</strong></span></label>
          <input value="{{ old('name') ?? $eventViewStatusFound->name }}" name="name" id="name" class="form-control  @error('name') is-invalid @enderror">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="description">Description<span style="color: red"><strong>*</strong></span></label>
          <input value="{{ old('description') ?? $eventViewStatusFound->description }}" name="description" id="description" type="text" class="form-control  @error('description') is-invalid @enderror">
          @error('description') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="price">Price ($)<span style="color: red"><strong>*</strong></span></label>
          <input name="price" id="price" type="number" step="0.01" class="form-control  @error('price') is-invalid @enderror"  value="{{ old('price') ?? $eventViewStatusFound->price }}">
          @error('price') <p> {{ $message }} </p> @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
@endsection