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
    <form method="POST" action="{{ route('admin.update.category', $category->id) }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Categorie name <span style="color: red"><strong>*</strong></span></label>
          <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter category name" value="<?= $category->name ?>">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="description">Description <span style="color: red"><strong>*</strong></label>
        <textarea name="description" id="description" class="form-control  @error('description') is-invalid @enderror" cols="30" rows="10">{{ $category->description }}</textarea>
        @error('description') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="price">Vendor Plus Price<span style="color: red"><strong>*</strong></span></label>
          <input type="number" step="0.01"  class="form-control  @error('price') is-invalid @enderror" name="price" id="price" placeholder="Enter Vendor Plus Price" value="<?= $category->price ?>">
          @error('price') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="category_file">Category file</label>
          @if ($category->category_file)
            <div class="row">
              <p>Current image</p>
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow">
    
                  <div class="info-box-content">
                    <img src="{{ $category->category_file }}" alt="">
                    {{-- <img src="{{ Storage::disk('s3')->url($category->category_file) }}" alt=""> --}}
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
            </div>              
          @endif
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
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
      </div>
    </form>
  </div>
@endsection