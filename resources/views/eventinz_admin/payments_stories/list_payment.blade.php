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
      <h3 class="card-title">Payments List</h3>
      {{-- <div class="card-tools">
        <a href="{{ route('admin.add.servicescategory') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New
        </a>
      </div> --}}
    </div>
    <!-- /.card-header -->
    <div class="card padding" id="responsive">

        <table class="table" id="myTable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Users Generic Ids</th>
              <th scope="col">Types</th>
              <th scope="col">Dates</th>
              <th scope="col">Amounts</th>
              <th scope="col">Methods</th>
              <th scope="col">Currencies</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php  $count = 1;  ?>
            @forelse ($paymentsStories as $paymentsstorie)
                
                <tr>
                <th scope="row">{{ $count++ }}</th>
                <td>{{ $paymentsstorie->user->generic_id  ?? "" }}</td>
                <td>{{ $paymentsstorie->payment_type }}</td>
                <td>{{ $paymentsstorie->payment_date }}</td>
                <td>{{ $paymentsstorie->amount }}</td>
                <td>{{ $paymentsstorie->paymentmethod }}</td>
                <td>{{ $paymentsstorie->currency }}</td>
                <td>
                    <a href="{{ route('admin.show.payment', $paymentsstorie->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Details</a>
                </td>
                </tr>
            @empty
                <div class="alert alert-warning">
                  No Payment yet
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