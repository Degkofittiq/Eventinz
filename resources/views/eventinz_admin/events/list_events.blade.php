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
      <h3 class="card-title">Categories List</h3>
      <div class="card-tools">
        {{-- <a href="{{ route('admin.add.event') }}" class="btn bg-default">
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
            <th scope="col">Generic Ids</th>
            <th scope="col">Owner</th>
            <th scope="col">Type</th>
            <th scope="col">Vendor(s)</th>
            <th scope="col">Aprx budget</th>
            <th scope="col">Pay Status</th>
            <th scope="col">Public/Private</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php  $count = 1;  ?>
          @forelse ($events as $event)
              
          <tr>
            <th scope="row">{{ $count++ }}</th>
            <td>{{ $event->generic_id ?? ""}}</td>
            <td>
              <a href="{{ $event->user_id ? route('admin.details.user', $event->user_id) : "#" }}" style="text-decoration: underline; color:black;">{{ $event->eventOwner->username ?? ""}}</a>
            </td>
            <td>{{ $event->eventType->name ?? ""}}</td>
            <td>
                @if (is_array(json_decode($event->vendor_type_id)))
                    @foreach (json_decode($event->vendor_type_id) as $vendorTypeId)
                        @php
                            // Récupérer le nom du type de fournisseur par son ID
                            $vendorType = \App\Models\VendorCategories::find($vendorTypeId);
                        @endphp
                        
                        @if ($vendorType)
                            {{ $vendorType->name ?? ""}},
                        @endif
                    @endforeach
                @else
                    "No Vendor "
                @endif
            </td>
            <td>{{ $event->aprx_budget ?? ""}}</td>
            <td>{{ $event->is_pay_done == 1 ? "Yes" : "Not yet" ?? ""}}</td>
            <td>{{ $event->public_or_private == 1 ? "Private" : "Public" ?? ""}}</td>
            <td>
              <a href="{{ route('admin.details.event', $event->id) ?? ""}}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Details</a>
              {{-- <a href="{{ route('admin.deleteform.event', $event->id) ?? ""}}"   class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a> --}}
            </td>
          </tr>
          @empty
              <div class="alert alert-warning">
                No event yet
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