@extends('eventinz_admin.layouts.app')

@section('content_admin')
    
<div class="card card-danger">
    <div class="card-header">
      <h3 class="card-title">Delete category</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.delete.category', $category->id) }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="alert alert-warning">
            <input type="number" hidden value="{{ $category->id }}" name="id">
            Confirm to delete this categogy: <strong>{{ $category->name }}</strong>
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="{{ route('admin.list.category') }}" class="btn btn-default"><i class="fas fa-times"></i>No</a>
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>Submit</button>
      </div>
    </form>
  </div>
@endsection