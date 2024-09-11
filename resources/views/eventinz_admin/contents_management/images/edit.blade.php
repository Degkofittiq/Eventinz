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
      <h3 class="card-title">Edit new content Image</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.update.contentimage', $imageContentFound->id) }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name <span style="color: red"><strong>*</strong></span></label>
          <input readonly type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter category name" value="{{ $imageContentFound->name }}">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="type">Type <span style="color: red"><strong>*</strong></span></label>
          <input type="text" class="form-control  @error('type') is-invalid @enderror" name="type" id="type" placeholder="Enter image type" value="{{ $imageContentFound->type }}">
          @error('type') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="page">Page <span style="color: red"><strong>*</strong></label>
          <input  name="page" id="page" class="form-control  @error('page') is-invalid @enderror" placeholder="Enter the image page" value="{{ $imageContentFound->page }}">
        @error('page') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="path">File</label>
          @if ($imageContentFound->path)
            <div class="row">
              <p>Current image</p>
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow">
    
                  <div class="info-box-content">
                    <img src="{{ Storage::disk('s3')->url($imageContentFound->path) }}" alt="">
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
              <input type="file" class="custom-file-input  @error('path') is-invalid @enderror" id="path" name="path" accept=".png, .jpeg, .jpg, .gift, .peg">
              <label class="custom-file-label" for="path">Choose file</label>
              @error('path') <p> {{ $message }} </p> @enderror
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