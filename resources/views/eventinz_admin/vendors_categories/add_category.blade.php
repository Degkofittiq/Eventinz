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
      <h3 class="card-title">Add new category</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.store.category') }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Category name <span style="color: red"><strong>*</strong></span></label>
          <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter category name">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="description">Description <span style="color: red"><strong>*</strong></label>
        <textarea name="description" id="description" class="form-control  @error('description') is-invalid @enderror" cols="30" rows="10"></textarea>
        @error('description') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="price">Vendor Plus Price <span style="color: red"><strong>*</strong></span></label>
          <input type="number" step="0.01" class="form-control  @error('price') is-invalid @enderror" name="price" id="price" placeholder="Enter category price">
          @error('price') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="category_file">Category file</label>
          <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input  @error('category_file') is-invalid @enderror" id="category_file" name="category_file" accept=".png, .jpeg, .jpg, .gift, .peg">
              <label class="custom-file-label" for="category_file">Choose file</label>
              @error('category_file') <p> {{ $message }} </p> @enderror
            </div>
            <div class="input-group-append">
              <span class="input-group-text">Upload</span>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
@endsection