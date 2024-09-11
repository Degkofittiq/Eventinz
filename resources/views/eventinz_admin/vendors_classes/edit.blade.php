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
    <form method="POST" action="{{ route('admin.update.vendorclass', $vendorClassFound->id) }}" enctype="multipart/form-data">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name <span style="color: red"><strong>*</strong></span></label>
          <input value="{{ $vendorClassFound->name ?? " " }}" name="name" id="name" class="form-control  @error('name') is-invalid @enderror">
          @error('name') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="description">Description <span style="color: red"><strong>*</strong></span></label>
          <input value="{{ $vendorClassFound->description ?? " " }}" name="description" id="description" class="form-control  @error('description') is-invalid @enderror">
          @error('description') <p> {{ $message }} </p> @enderror
        </div>
        <div class="form-group">
          <label for="service_number">Number of services <span style="color: red"><strong>*</strong></span></label>
          <input name="service_number" type="number" min="1" id="service_number" class="form-control  @error('service_number') is-invalid @enderror" value="{{ $vendorClassFound->service_number ?? " " }}" >
          @error('service_number') <p> {{ $message }} </p> @enderror
        </div>
        <!-- Dynamic Features Section -->
        <div class="form-group">
            <label for="features">Features</label>
            <div id="features-wrapper">
                
                @php
                $features = [];
                    if ($vendorClassFound->features) {
                        $features = json_decode($vendorClassFound->features, true);
                    }
                @endphp

                @foreach ($features as $feature)
                    <div class="feature-group d-flex align-items-center mb-2">
                        <input value="{{ $feature ?? " " }}" type="text"  id="features" name="features[]" class="form-control me-2  @error('features') is-invalid @enderror" placeholder="Feature">
                        <button type="button" class="btn btn-danger btn-remove-feature mx-1">Remove</button>
                    </div>
                @endforeach
                @error('features') <p> {{ $message }} </p> @enderror
            </div>
            <button type="button" class="btn btn-success mt-3" id="btn-add-feature">
                <i class="fa fa-plus"> Add Features</i>
            </button>
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
  
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const featuresWrapper = document.getElementById('features-wrapper');
            const addFeatureButton = document.getElementById('btn-add-feature');

            addFeatureButton.addEventListener('click', function() {
                const featureGroup = document.createElement('div');
                featureGroup.className = 'feature-group d-flex align-items-center mb-2';
                featureGroup.innerHTML = `
            <input value="" type="text" name="features[]" class="form-control me-2" placeholder="Feature">
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
    </script>
@endsection