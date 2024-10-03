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
      <h3 class="card-title">Companies List</h3>
      <div class="card-tools">
        {{-- <a href="{{ route('admin.add.company') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New
        </a> --}}
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card padding" id="responsive">
      <table class="table" id="myTable">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Names</th>
            <th scope="col">Vendors</th>
            <th scope="col">Countries	</th>
            <th scope="col">Category(ies)</th>
            <th scope="col">Subscriptions</th>
            <th scope="col">Creation Date</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php  $count = 1;  ?>
          @forelse ($companies as $company)
              
          <tr>
            <th scope="row">{{ $count++ }}</th>
            <td>{{ $company->name }}</td>
            <td>{{ $company->user->username }}</td>
            <td>{{ $company->country	 }}</td>
            <td>
                @if ($company->vendorCategories->isNotEmpty())
                    {{ $company->vendorCategories->pluck('name')->implode(', ') }}
                @else
                    "Aucune catégorie"
                @endif
            </td> 
            <td>{{ $company->subscriptionPlan->name ?? "No Subscribed yet"}}</td>
            <td>{{ \Carbon\Carbon::parse($company->created_at)->format('d-m-y') ?? ""}}</td>
            <td>
              <a href="{{ route('admin.edit.company', $company->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-pen"></i> Edit</a>
              {{-- <a href="{{ route('admin.delete.company', $company->id) }}"  class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a> --}}
            </td>
          </tr>
          @empty
          @endforelse
        </tbody>
      </table>
      @if (count($companies) <= 0)
        <div class="alert alert-warning">
          No company yet
        </div>
      @endif
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