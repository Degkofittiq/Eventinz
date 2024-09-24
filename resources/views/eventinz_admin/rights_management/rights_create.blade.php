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
      <h3 class="card-title">Add new Right</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.add.right') }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="rights_types_id">Value <span style="color: red"><strong>*</strong></span></label>
          <select name="rights_types_id" id="rights_types_id" class="form-control  @error('rights_types_id') is-invalid @enderror">
            <option value="">-- Select Right Type --</option>
            @foreach($rightsTypes as $rightType)
                <option value="{{ $rightType->id }}">{{ $rightType->name }}</option>
            @endforeach
          </select>
          @error('rights_types_id') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="name">Name <span style="color: red"><strong>*</strong></span></label>
          <input name="name" id="name" class="form-control  @error('name') is-invalid @enderror">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="description">Description <span style="color: red"><strong>*</strong></span></label>
          <input name="description" id="description" class="form-control  @error('description') is-invalid @enderror">
          @error('description') <p> {{ $message }} </p> @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"> Save</i>
        </button>
      </div>
    </form>
  </div>
@endsection