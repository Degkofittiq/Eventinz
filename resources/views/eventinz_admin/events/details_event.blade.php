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
      <h3 class="card-title">Payment Found Details</h3>
    </div>
    <!-- /.card-header --><table class="table">
    <tr>
        <th>Id</th>
        <td>{{ $event->generic_id ?? ""}}</td>
    </tr>
    <tr>
        <th>User Name</th>
        <td>{{ $event->eventOwner->username ?? ""}}</td>
    </tr>
    <tr>
        <th>Event type </th>
        <td>{{ $event->eventType->name ?? ""}}</td>
    </tr>
    <tr>
        <th>Vendor(s) Type</th>
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
    </tr>
    <tr>
        <th>Duration</th>
        <td>{{ $event->duration ?? ""}}</td>
    </tr>
    @if (!empty($vendor_type_id))            
        <tr>
            <th>Vendor(s) Pke</th>
            <td>{{ $event->vendor_type_id ?? ""}}</td>
        </tr>
    @endif
    <tr>
        <th>Date</th>
        <td>{{ $event->start_date ?? ""}}</td>
    </tr>
    <tr>
        <th>Approximate Budget</th>
        <td>{{ $event->aprx_budget ?? ""}} $</td>
    </tr>
    <tr>
        <th>Guests Number</th>
        <td>{{ $event->guest_number ?? ""}}</td>
    </tr>
    <tr>
        <th>Is paid</th>
        {{--  pending  --}}
        @if ($event->is_pay_done == 0)
            <td class="text-warning">
                <strong>
                    Not Yet
                </strong>
            </td>
        @else
            <strong>
                <td class="text-success">
                    Yes
                </td>              
            </strong>          
        @endif
    </tr>
</table>
</div>

@endsection