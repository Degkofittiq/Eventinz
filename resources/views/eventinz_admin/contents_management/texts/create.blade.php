@extends('eventinz_admin.layouts.app')

@section('content_admin')
    
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
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
      <h3 class="card-title">Add new text content</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.add.contenttext') }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Content Name<span style="color: red"><strong>*</strong></span></label>
          <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter content name" value="">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
            <label for="page">Page<span style="color: red"><strong>*</strong></span></label>
            <input type="text" class="form-control  @error('page') is-invalid @enderror" name="page" id="page" placeholder="Enter content page" value="">
            @error('page') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
            <label for="content_fr">French Content<span style="color: red"><strong>*</strong></span></label>
            <textarea name="content_fr" id="content_fr" class="form-control  @error('content_fr') is-invalid @enderror" cols="30" rows="10"></textarea>            
            @error('content_fr') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
            <label for="content_en">English Content<span style="color: red"><strong>*</strong></span></label>
                    <textarea name="content_en" id="content_en" class="form-control  @error('content_en') is-invalid @enderror" cols="30" rows="10"></textarea>
            @error('content_en') <p> {{ $message }} </p> @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
  
  <script>
    // $('#content_fr').summernote({
    //   placeholder: 'Put the French content',
    //   tabsize: 2,
    //   height: 200
    // });

    // $('#content_en').summernote({
    //   placeholder: 'Put the English content',
    //   tabsize: 2,
    //   height: 200
    // });
  </script>
@endsection