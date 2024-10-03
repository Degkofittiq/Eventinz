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
      <h3 class="card-title">Events 
        <a href="{{ route('admin.details.event', $quoteEpicsDetails->event->id) }}" style="text-decoration:underline">
          {{ $quoteEpicsDetails->event->generic_id }}
        </a> 
        quote list by 
        <a href="{{ route('admin.edit.company', $quoteEpicsDetails->company_id) }}" style="text-decoration:underline">
          {{ $quoteEpicsDetails->company->name }}
        </a>'s company
      </h3>
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
            {{-- <th scope="col">Event</th> --}}
            {{-- <th scope="col">Company</th> --}}
            <th scope="col">Service</th>
            <th scope="col">Subdetails</th>
            <th scope="col">Type</th>
            <th scope="col">Duration</th>
            <th scope="col">Rate</th>
            <th scope="col">Amount</th>
            <th scope="col">Is obligatory</th>
            <th scope="col">Status</th>
            <th scope="col">Creation</th>
          </tr>
        </thead>
        <tbody>
          <?php  $count = 1;  ?>
          @forelse ($eventQuotes as $eventQuote)
              
          <tr>
            <th scope="row">{{ $count++ }}</th>
            {{-- <td>{{ $eventQuote->event->generic_id ?? ""}}</td> --}}
            {{-- <td>{{ $eventQuote->company->name ?? ""}}</td> --}}
            <td>{{ $eventQuote->servicename ?? ""}}</td>
            <td>{{ $eventQuote->subdetails ?? ""}}</td>
            <td>{{ $eventQuote->type ?? ""}}</td>
            <td>{{ $eventQuote->duration ?? ""}}</td>
            <td>{{ $eventQuote->rate ?? ""}}</td>
            <td>{{ $eventQuote->total ?? ""}}</td>
            <td>{{ $eventQuote->obligatory ?? ""}}</td>
            <td>{{ $eventQuote->status ?? "Pending Validation"}}</td>
            <td>{{ \Carbon\Carbon::parse($eventQuote->created_at)->format('d-m-y') ?? ""}}</td>
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
      { orderable: false, targets: [9] } // 7 est l'index de la colonne 'Actions', car les index commencent à 0
    ]
  }
  );
</script>
@endsection