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
      <h3 class="card-title">View Details</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.update.subscriptionplan', $subscriptionFound->id) }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name <span style="color: red"><strong>*</strong></span></label>
          <input value="{{ $subscriptionFound->name ?? " " }}" name="name" id="name" class="form-control  @error('name') is-invalid @enderror">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="description">Description <span style="color: red"><strong>*</strong></span></label>
          <input value="{{ $subscriptionFound->description ?? " " }}" name="description" id="description" class="form-control  @error('description') is-invalid @enderror">
          @error('description') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="vendor_service_types_id">Vendor Type(Single service / Multiple Services) <span style="color: red"><strong>*</strong></span></label>
          <select name="vendor_service_types_id" id="vendor_service_types_id" class="form-control  @error('vendor_service_types_id') is-invalid @enderror">
            @foreach ($vendorTypes as $vendorType)
              @if ($vendorType->id == $subscriptionFound->vendor_service_types_id)
                <option value="{{ $vendorType->id }}" selected>{{ $vendorType->name }}</option>   
              @else
                <option value="{{ $vendorType->id }}">{{ $vendorType->name }}</option>  
              @endif              
            @endforeach
          </select>
          @error('vendor_service_types_id') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="price">Price($) <span style="color: red"><strong>*</strong></span></label>
          <input value="{{ $subscriptionFound->price ?? " " }}"  type="number" step="0.01" min="0"  name="price" id="price" class="form-control  @error('price') is-invalid @enderror">
          @error('price') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="duration">Duration <span style="color: red"><strong>*</strong></span></label>
          <input value="{{ $subscriptionFound->duration ?? " " }}"  type="number" max="12" min="1" name="duration" id="duration" class="form-control  @error('duration') is-invalid @enderror">
          @error('duration') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="credits">credits <span style="color: red"><strong>*</strong></span></label>
          <input value="{{ $subscriptionFound->credits }}" name="credits" type="number" min="1" id="credits" class="form-control  @error('credits') is-invalid @enderror">
          @error('credits') <p> {{ $message }} </p> @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"> Update Plan</i>
        </button>
      </div>
    </form>
  </div>
@endsection