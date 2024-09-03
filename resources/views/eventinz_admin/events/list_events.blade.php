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
      <h3 class="card-title">Categories List</h3>
      <div class="card-tools">
        {{-- <a href="{{ route('admin.add.event') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New
        </a> --}}
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Generic Ids</th>
            <th scope="col">Event owner</th>
            <th scope="col">Event type</th>
            <th scope="col">Vendor type</th>
            <th scope="col">Approximate budget</th>
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
            <td>{{ $event->generic_id }}</td>
            <td>{{ $event->eventOwner->username }}</td>
            <td>{{ $event->eventType->name }}</td>
            <td>
                @if (is_array(json_decode($event->vendor_type_id)))
                    @foreach (json_decode($event->vendor_type_id) as $vendorTypeId)
                        @php
                            // Récupérer le nom du type de fournisseur par son ID
                            $vendorType = \App\Models\VendorCategories::find($vendorTypeId);
                        @endphp
                        
                        @if ($vendorType)
                            {{ $vendorType->name }},
                        @endif
                    @endforeach
                @else
                    "No Vendor "
                @endif
            </td>
            <td>{{ $event->aprx_budget }}</td>
            <td>{{ $event->is_pay_done == 1 ? "Yes" : "Not yet" }}</td>
            <td>{{ $event->public_or_private == 1 ? "Private" : "Public" }}</td>
            <td>
              <a href="{{ route('admin.details.event', $event->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Details</a>
              {{-- <a href="{{ route('admin.deleteform.event', $event->id) }}"  class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a> --}}
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
@endsection