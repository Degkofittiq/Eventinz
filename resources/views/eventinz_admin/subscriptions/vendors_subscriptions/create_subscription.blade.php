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
    <form method="POST" action="{{ route('admin.store.subscriptionplan') }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name <span style="color: red"><strong>*</strong></span></label>
          <input name="name" id="name" class="form-control  @error('name') is-invalid @enderror">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="description">Description <span style="color: red"><strong>*</strong></span></label>
          <input name="description" id="description" class="form-control  @error('description') is-invalid @enderror">
          @error('description') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="vendor_service_types_id">Vendor Type(Single service / Multiple Services) <span style="color: red"><strong>*</strong></span></label>
          <select name="vendor_service_types_id" id="vendor_service_types_id" class="form-control  @error('vendor_service_types_id') is-invalid @enderror">
            @foreach ($vendorTypes as $vendorType)
              <option value="{{ $vendorType->id }}">{{ $vendorType->name }}</option>                
            @endforeach
          </select>
          @error('vendor_service_types_id') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="price">Price($) <span style="color: red"><strong>*</strong></span></label>
          <input name="price" type="number" step="0.01" min="0" id="price" class="form-control  @error('price') is-invalid @enderror">
          @error('price') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="duration">Duration <span style="color: red"><strong>*</strong></span></label>
          <input name="duration" type="number" max="12" min="1" id="duration" class="form-control  @error('duration') is-invalid @enderror">
          @error('duration') <p> {{ $message }} </p> @enderror
        </div>

        <!-- Dynamic Features Section -->
        {{-- <div class="form-group">
            <label for="features">Features</label>
            <div id="features-wrapper">
                <div class="feature-group d-flex align-items-center mb-2">
                    <input type="text"  id="features" name="features[]" class="form-control me-2  @error('features') is-invalid @enderror" placeholder="Feature">
                    <button type="button" class="btn btn-danger btn-remove-feature mx-1">Remove</button>
                </div>
                @error('features') <p> {{ $message }} </p> @enderror
            </div>
            <button type="button" class="btn btn-success mt-3" id="btn-add-feature">
                <i class="fa fa-plus"> Add Features</i>
            </button>
        </div> --}}

      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
{{--   
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const featuresWrapper = document.getElementById('features-wrapper');
            const addFeatureButton = document.getElementById('btn-add-feature');

            addFeatureButton.addEventListener('click', function() {
                const featureGroup = document.createElement('div');
                featureGroup.className = 'feature-group d-flex align-items-center mb-2';
                featureGroup.innerHTML = `
            <input type="text" name="features[]" class="form-control me-2" placeholder="Feature">
            <button type="button" class="btn btn-danger btn-remove-feature mx-1">Remove</button>
        `;
                featuresWrapper.appendChild(featureGroup);

                featureGroup.querySelector('.btn-remove-feature').addEventListener('click', function() {
                    featureGroup.remove();
                });
            });

            // Attach the event listener to the existing remove button
            document.querySelectorAll('.btn-remove-feature').forEach(button => {
                button.addEventListener('click', function() {
                    button.closest('.feature-group').remove();
                });
            });
        });
    </script> --}}
@endsection