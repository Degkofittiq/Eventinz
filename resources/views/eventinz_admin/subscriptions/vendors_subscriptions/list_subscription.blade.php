@extends('eventinz_admin.layouts.app')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
<style>
  #dt-length-0{
    margin: 5px !important;
  }
  .dt-length label{
    text-transform: uppercase;
  }
  .padding{
    padding: 5px !important;
    width: 100%;
  }
</style>
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
    <div class="card padding" id="responsive">
      <table class="table" id="myTable">
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

<script>
  let table = new DataTable('#myTable', {
    columnDefs: [
      { orderable: false, targets: [7] } // 7 est l'index de la colonne 'Actions', car les index commencent à 0
    ]
  }
  );
</script>
@endsection