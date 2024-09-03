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
      <h3 class="card-title">Subscription Plan List</h3>
      <div class="card-tools">
        <a href="{{ route('admin.add.subscriptionplan') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New
        </a>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Names</th>
            <th scope="col">Vendors Types</th>
            <th scope="col">Prices</th>
            <th scope="col">Durations</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php  $count = 1;  ?>
          @forelse ($subscriptionPlans as $subscriptionPlan)
              
          <tr>
            <th scope="row">{{ $count++ }}</th>
            <td>{{ $subscriptionPlan->name ?? "" }}</td>
            {{-- <td>{{ $subscriptionPlan->vendor_service_types_id ?? "" }}</td> --}}
            <td>{{ $subscriptionPlan->vendorType->name ?? "" }}</td>
            <td>{{ $subscriptionPlan->price ?? "" }}</td>
            <td>{{ ($subscriptionPlan->duration == 3 ||  $subscriptionPlan->duration == 6) ?  $subscriptionPlan->duration . " Months" :  "1 Year" }}</td>
            <td>
              <a href="{{ route('admin.details.subscriptionplan', $subscriptionPlan->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Details</a>
              {{-- <a href="{{ route('admin.edit.subscriptionplan', $subscriptionPlan->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-pen"></i> Edit</a> --}}
              <a href="{{ route('admin.deleteform.subscriptionplan', $subscriptionPlan->id) }}"  class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
            </td>
          </tr>
          @empty
              <div class="alert alert-warning">
                No Subscription Plan yet
              </div>
          @endforelse
        </tbody>
      </table>
    </div>
</div>
@endsection