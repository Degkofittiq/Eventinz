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
      <h3 class="card-title">Add new Service Category</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.store.servicescategory') }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="vendor_categories_id">Vendor Categories</label>
          <select name="vendor_categories_id" id="vendor_categories_id" class="form-control  @error('vendor_categories_id') is-invalid @enderror">
            @forelse ($VendorCategories as $VendorCategorie)  
              <option value="{{ $VendorCategorie->id }}">{{ $VendorCategorie->name }}</option>
            @empty
              {{ "No data yet " }}          
            @endforelse
          </select>
          @error('vendor_categories_id') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="name">Service Category name <span style="color: red"><strong>*</strong></span></label>
          <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter category name">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="description">Description <span style="color: red"><strong>*</strong></label>
        <textarea name="description" id="description" class="form-control  @error('description') is-invalid @enderror" cols="30" rows="10"></textarea>
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