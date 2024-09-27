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
          <label for="user_id">Review Author <span style="color: red"><strong>*</strong></span></label>
          <input readonly type="text" class="form-control  @error('user_id') is-invalid @enderror" name="user_id" id="user_id" placeholder="Enter author" value="{{ $reviewFound->user->username ?? ""}}">
          @error('user_id') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="review_cible">Review cible <span style="color: red"><strong>*</strong></span></label>
          <input readonly type="text" class="form-control  @error('review_cible') is-invalid @enderror" name="review_cible" id="review_cible" placeholder="Enter cible" value="{{ $reviewFound->cibleUser->username ?? ""}}">
          @error('review_cible') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="review_content">Review content <span style="color: red"><strong>*</strong></span></label>
          <input readonly type="text" class="form-control  @error('review_content') is-invalid @enderror" name="review_content" id="review_content" placeholder="Enter date" value="{{ $reviewFound->review_content ?? ""}}">
          @error('review_content') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="date_review">Review Date <span style="color: red"><strong>*</strong></span></label>
          <input readonly type="text" class="form-control  @error('date_review') is-invalid @enderror" name="date_review" id="date_review" placeholder="Enter xxxxxxxxxxxxxxxx" value="{{ $reviewFound->date_review ?? ""}}">
          @error('date_review') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="start_for_cibe">Review Starts <span style="color: red"><strong>*</strong></span></label>
          <input readonly type="number" step="1" class="form-control  @error('start_for_cibe') is-invalid @enderror" name="start_for_cibe" id="start_for_cibe" placeholder="Enter xxxxxxxxxxxxxxxx" value="{{ $reviewFound->start_for_cibe ?? ""}}">
          @error('start_for_cibe') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="status">Review Status <span style="color: red"><strong>*</strong></span></label>
          <select name="status" id="status" class="custom-select">
            <option value="show" {{ $reviewFound->status == null ? "selected" : "" }}>--Select one status--</option>
            <option value="show" {{ $reviewFound->status == "show" ? "selected" : "" }}>Show</option>
            <option value="hide" {{ $reviewFound->status == "hide" ? "selected" : "" }}>Hide</option>
          </select>
          @error('status') <p> {{ $message }} </p> @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
@endsection