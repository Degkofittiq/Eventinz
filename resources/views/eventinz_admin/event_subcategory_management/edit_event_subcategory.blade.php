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
      <h3 class="card-title">Add new Event Subcategory</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.update.eventsubcategory',$eventSubcategoryFound->id) }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="event_types_id">Event Type<span style="color: red"><strong>*</strong></span></label>
          <select name="event_types_id" id="event_types_id" type="number" class="form-control  @error('event_types_id') is-invalid @enderror">  
            @foreach ($eventTypes as $eventType)
              <option value="{{ $eventType->id }}" {{ $eventSubcategoryFound->event_types_id == $eventType->id ? "selected" : "" }}>{{ $eventType->name }}</option>
            @endforeach
          </select>
          @error('event_types_id') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="name">Name <span style="color: red"><strong>*</strong></span></label>
          <input value="{{ $eventSubcategoryFound->name }}" name="name" id="name" class="form-control  @error('name') is-invalid @enderror">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="description">Description<span style="color: red"><strong>*</strong></span></label>
          <input value="{{ $eventSubcategoryFound->description }}" name="description" id="description" type="text" class="form-control  @error('description') is-invalid @enderror">
          @error('description') <p> {{ $message }} </p> @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
@endsection