{{-- 'eventTypes','vendorCategories','privateOrPublic','status','canceledEvents' --}}
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
      <h3 class="card-title">Event Found Details</h3>
    </div>
    <!-- /.card-header -->
    <form action="{{ route('admin.update.event',$event->id) }}" method="post">
        @csrf
        <table class="table">
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
                <td>
                    <select name="xxxxxx" id="xxxxxxx" class="form-control">
                        @foreach ($eventTypes as $eventType)
                            <option value="{{ $eventType->id }}" {{ $event->event_type_id == $eventType->id ? "selected" : ""}}>{{ $eventType->name }}</option>                            
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th>Vendor(s) Type</th>
                <td>
                    @if (is_array(json_decode($event->vendor_type_id)))
                        {{--
                            @foreach (json_decode($event->vendor_type_id) as $vendorTypeId)
                                @php
                                    // Récupérer le nom du type de fournisseur par son ID
                                    $vendorType = \App\Models\VendorCategories::find($vendorTypeId);
                                @endphp
                                
                                @if ($vendorType)
                                    {{ $vendorType->name }},
                                @endif
                            @endforeach 
                        --}}
                        <select name="cccccccccccc" id="cccccccccccc" class="form-control">
                            @foreach ($vendorCategories as $vendorCategorie)
                                <option value="{{ $vendorCategorie->id }}" {{ in_array($vendorCategorie->id, json_decode($event->vendor_type_id)) ? "selected" : ""}}>{{ $vendorCategorie->name }}</option>
                            @endforeach
                        </select>
                    @else
                        "No Vendor "
                    @endif            
                </td>
            </tr>
            <tr>
                <th>Duration</th>
                <td>{{ $event->duration ?? ""}}</td>
            </tr>
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
                <th>Country</th>
                <td>{{ $event->country ?? ""}}</td>
            </tr>
            <tr>
                <th>State</th>
                <td>{{ $event->state ?? ""}}</td>
            </tr>
            <tr>
                <th>City</th>
                <td>{{ $event->city ?? ""}}</td>
            </tr>
            <tr>
                <th>Subcategory</th>
                <td>{{ $event->subcategory ?? ""}}</td>
            </tr>
            <tr>
                <th>Private or Public</th>
                <td>{{ $event->public_or_private == 0 ? "Public" : "Private"}}</td>
            </tr>
            <tr>
                <th>Additional</th>
                <td>
                    <textarea name="description" id="" cols="30" rows="5" class="form-control">{{ $event->description ?? ""}}</textarea>
                </td>
            </tr>
            <tr>
            @if ($event->public_or_private == 1 && $event->vendor_poke)
                <tr>
                    <th>Vendor Poke</th>
                    <td>
                        @if (is_array(json_decode($event->vendor_poke)))
                            @foreach (json_decode($event->vendor_poke) as $vendorPokeId)
                                @php
                                    // Récupérer le nom du type de fournisseur par son ID
                                    $vendorPoke = \App\Models\VendorCategories::find($vendorPokeId);
                                @endphp
                                
                                @if ($vendorPoke)
                                    {{ $vendorPoke->name }},
                                @endif
                            @endforeach
                        @else
                            No Vendor Found
                        @endif                         
                    </td>
                </tr>                
            @endif 
            <tr>
                <th>Status</th>
                <td>{{ $event->status == "Yes" ? "Active" : "Not Active yet"}}</td>
            </tr>
            <tr>
                <th>Canceled or Completed</th>
                <td>{{ $event->cancelstatus == "no" ? "No yet" : $event->cancelstatus}}</td>
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
            <tr>
                <th>Action</th>
                <td>
                    <button type="submit" class="btn btn-info btn-sm">
                        Update
                    </button>
                </td>
            </tr>
        </table>
    </form>
</div>

@endsection