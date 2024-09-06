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
      <h3 class="card-title">Edit Review</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.update.review', $reviewFound->id) }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Review Author <span style="color: red"><strong>*</strong></span></label>
          <input readonly type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter author" value="{{ $reviewFound->user->username }}">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="name">Review cible <span style="color: red"><strong>*</strong></span></label>
          <input readonly type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter cible" value="{{ $reviewFound->cibleUser->username }}">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="name">Review content <span style="color: red"><strong>*</strong></span></label>
          <input readonly type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter date" value="{{ $reviewFound->review_content }}">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="name">Review Date <span style="color: red"><strong>*</strong></span></label>
          <input readonly type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter xxxxxxxxxxxxxxxx" value="{{ $reviewFound->date_review }}">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="name">Review Starts <span style="color: red"><strong>*</strong></span></label>
          <input readonly type="number" step="1" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter xxxxxxxxxxxxxxxx" value="{{ $reviewFound->start_for_cibe }}">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="name">Review Status <span style="color: red"><strong>*</strong></span></label>
          <select name="" id="" class="custom-select">
            <option value="{{ $eachReview->status  ?? "show" }}">Show</option>
            <option value="hide">Hide</option>
          </select>
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
@endsection