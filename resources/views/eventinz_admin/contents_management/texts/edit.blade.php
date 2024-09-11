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
      <h3 class="card-title">Edit Text content</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.update.contenttext', $contentTextFound->id) }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Content Name<span style="color: red"><strong>*</strong></span></label>
          <input readonly type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter content name" value="{{ $contentTextFound->name }}">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
            <label for="page">Page<span style="color: red"><strong>*</strong></span></label>
            <input type="text" class="form-control  @error('page') is-invalid @enderror" name="page" id="page" placeholder="Enter content page" value="{{ $contentTextFound->page }}">
            @error('page') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
            <label for="content_fr">French Content<span style="color: red"><strong>*</strong></span></label>
            <textarea name="content_fr" id="content_fr" class="form-control  @error('content_fr') is-invalid @enderror" cols="30" rows="10">{{ $contentTextFound->content_fr }}</textarea>            
            @error('content_fr') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
            <label for="content_en">English Content<span style="color: red"><strong>*</strong></span></label>
                    <textarea name="content_en" id="content_en" class="form-control  @error('content_en') is-invalid @enderror" cols="30" rows="10">{{ $contentTextFound->content_en }}</textarea>
            @error('content_en') <p> {{ $message }} </p> @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
@endsection