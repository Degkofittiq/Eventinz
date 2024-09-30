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
    <form action="{{ route('admin.update.event', $event->id) }}" method="post">
        @csrf
        <table class="table">
            <tr>
                <th>Id</th>
                <td>{{ $event->generic_id ?? ""}}</td>
            </tr>
            <tr>
                <th>User Name</th>
                <td>
                    <a href="{{ $event->user_id ? route('admin.details.user', $event->user_id) : "#" }}" style="text-decoration: underline; color:black">
                        {{ $event->eventOwner->username ?? ""}}
                    </a>
                </td>
            </tr>
            <tr>
                <th>Event type </th>
                <td>
                    <select name="event_type_id" id="event_type_id" class="form-control @error('event_type_id') is-invalid @enderror">
                        @foreach ($eventTypes as $eventType)
                            <option value="{{ $eventType->id }}" {{ $event->event_type_id == $eventType->id ? "selected" : ""}}>{{ $eventType->name }}</option>                            
                        @endforeach
                    </select>
                    @error('event_type_id') <p> {{ $message }} </p> @enderror
                </td>
            </tr>
            <tr>
                <th>Vendor(s) Type</th>
                <td>
                    @if (is_array(json_decode($event->vendor_type_id)))
                        <strong>Current choice: </strong>
                            @foreach (json_decode($event->vendor_type_id) as $vendorTypeId)
                                @php
                                    // Récupérer le nom du type de fournisseur par son ID de category
                                    $vendorType = \App\Models\VendorCategories::find($vendorTypeId);
                                @endphp
                                
                                @if ($vendorType)
                                    {{ $vendorType->name }},
                                @endif
                            @endforeach 
                       
                        <select name="vendor_type_id[]" id="vendor_type_id" class="form-control  @error('vendor_type_id') is-invalid @enderror" multiple >
                            @foreach ($vendorCategories as $vendorCategorie)
                                <option value="{{ $vendorCategorie->id }}" {{ in_array($vendorCategorie->id, json_decode($event->vendor_type_id)) ? "selected" : ""}}>{{ $vendorCategorie->name }}</option>
                            @endforeach
                        </select>
                        @error('vendor_type_id') <p> {{ $message }} </p> @enderror
                    @else
                        "No Vendor "
                    @endif            
                </td>
            </tr>
            <tr>
                <th>Duration</th>
                <td>
                    <input type="text" name="duration" id="duration" value="{{ $event->duration ?? ""}}" class="form-control  @error('duration') is-invalid @enderror">
                    @error('duration') <p> {{ $message }} </p> @enderror
                </td>
            </tr>
            <tr>
                <th>Date</th>
                <td>
                    <input type="date" name="start_date" id="start_date" value="{{ $event->start_date ?? ""}}" class="form-control  @error('start_date') is-invalid @enderror">
                    @error('start_date') <p> {{ $message }} </p> @enderror
                </td>
            </tr>
            <tr>
                <th>Approximate Budget <strong>($)</strong> </th>
                <td>
                    <input class="form-control  @error('aprx_budget') is-invalid @enderror" type="number" name="aprx_budget" id="aprx_budget" step="0.01" value="{{ $event->aprx_budget ?? ""}}">
                    @error('total_amount') <p> {{ $message }} </p> @enderror
                </td>
            </tr>
            <tr>
                <th>Total Amount <strong>($)</strong> </th>
                {{-- If select more vendors than 1 --}}
                <td>
                    <input class="form-control  @error('total_amount') is-invalid @enderror" type="number" name="total_amount" id="total_amount" step="0.01" value="{{ $event->total_amount ?? ""}}">
                    @error('total_amount') <p> {{ $message }} </p> @enderror
                </td>
            </tr>
            <tr>
                <th>Guests Number</th>
                <td>
                    <input class="form-control  @error('guest_number') is-invalid @enderror" type="number" name="guest_number" id="guest_number" value="{{ $event->guest_number ?? ""}}">
                    @error('guest_number') <p> {{ $message }} </p> @enderror
                </td>
            </tr>
            <tr>
                <th>Country</th>
                <td>
                    <input class="form-control  @error('country') is-invalid @enderror" type="text" name="country" id="country" value="{{ $event->country ?? ""}}">
                    @error('country') <p> {{ $message }} </p> @enderror                    
                </td>
            </tr>
            <tr>
                <th>State</th>
                <td>
                    <input class="form-control  @error('state') is-invalid @enderror" type="text" name="state" id="state" value="{{ $event->state ?? ""}}">
                    @error('state') <p> {{ $message }} </p> @enderror                    
                </td>
            </tr>
            <tr>
                <th>City</th>
                <td>
                    <input class="form-control  @error('city') is-invalid @enderror" type="text" name="city" id="city" value="{{ $event->city ?? ""}}">
                    @error('city') <p> {{ $message }} </p> @enderror                                        
                </td>
            </tr>
            <tr>
                <th>Subcategory</th>
                <td>
                    <input class="form-control  @error('subcategory') is-invalid @enderror" type="text" name="subcategory" id="subcategory" value="{{ $event->subcategory ?? ""}}">
                    @error('subcategory') <p> {{ $message }} </p> @enderror                    
                </td>
            </tr>
            <tr>
                <th>Private or Public</th>
                <td>
                    <select class="form-control  @error('public_or_private') is-invalid @enderror" name="public_or_private" id="public_or_private">
                        @foreach ($privateOrPublic as $item)
                            <option value="{{ $item->id }}" {{ $event->public_or_private == $item->id ? "selected" : ""}}>{{ $item->name}}</option>
                        @endforeach
                    </select>
                    @error('public_or_private') <p> {{ $message }} </p> @enderror                    
                </td>
            </tr>
            <tr>
                <th>Additional</th>
                <td>
                    <textarea name="description" id="" cols="30" rows="5" class="form-control  @error('description') is-invalid @enderror">{{ $event->description ?? ""}}</textarea>
                    @error('description') <p> {{ $message }} </p> @enderror 
                </td>
            </tr>
            <tr>
                @if ($event->vendor_poke)
                    <tr>
                        <th>Vendor Poke</th>
                        <td>
                            @if (is_array(json_decode($event->vendor_poke)))
                                @foreach (json_decode($event->vendor_poke) as $vendorPokeId)
                                    @php
                                        // Récupérer le nom du type de fournisseur par son ID
                                        // $vendorPoke = \App\Models\VendorCategories::find($vendorPokeId);
                                        $vendorPoke = \App\Models\Company::find($vendorPokeId);
                                    @endphp
                                    
                                    @if ($vendorPoke)
                                        {{ $vendorPoke->name }},
                                    @endif
                                @endforeach
                                <strong>No vendor poke yet</strong>
                                <select name="vendor_poke[]" id="vendor_poke[]" class="form-control  @error('vendor_poke') is-invalid @enderror" multiple >
                                    <option value="">-- No choice --</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}" {{ in_array($company->id, json_decode($event->vendor_poke)) ? "selected" : ""}}>{{ $company->user->generic_id }}</option>
                                    @endforeach
                                </select>
                                @error('vendor_poke') <p> {{ $message }} , If the event Private, You must poke Vendor</p> @enderror
                            @else
                                No Vendor Found
                            @endif                         
                        </td>
                    </tr>                
                @else
                
                <tr>
                    <th>Vendor Poke</th>
                    <td>
                        <select name="vendor_poke[]" id="vendor_poke[]" class="form-control  @error('vendor_poke') is-invalid @enderror" multiple >
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->user->generic_id }}</option>
                            @endforeach
                        </select>                       
                    </td>
                </tr>   
                @endif
            <tr>
                <th>Status</th>
                <td>
                    <strong>
                        {{  $event->status == "Yes" ? "Active" : "Not Active yet"}} <br>
                    </strong>
                    <select name="status" id="status" class="form-control  @error('status') is-invalid @enderror">
                        @foreach ($status as $item)
                            <option value="{{ $item }}" {{ $event->status == $item ? "selected" : ""}}>{{  $item == "Yes" ? "Active" : "Not Active yet"}}</option>
                        @endforeach
                    </select>
                    @error('status') <p> {{ $message }} </p> @enderror
                </td>
            </tr>
            <tr>
                <th>Canceled or Completed</th>
                <td>
                    <select name="cancelstatus" id="cancelstatus" class="form-control  @error('cancelstatus') is-invalid @enderror">
                        <option value="no" {{ $event->cancelstatus == "no" ? "selected" : "" }}>Not chage value this</option>
                        @foreach ($canceledEvents as $item)                                                                                
                            <option value="{{ $item }}" {{ $event->cancelstatus == $item ? "selected" : "" }}>
                                    {{ $item }}
                            </option>
                        @endforeach
                    </select>
                    @error('cancelstatus') <p> {{ $message }} </p> @enderror
                </td>
            </tr>
            <tr>
                <th>Is paid</th>
                <td>
                    <select name="is_pay_done" id="is_pay_done" class="form-control  @error('is_pay_done') is-invalid @enderror">
                        @foreach ($is_pay_dones as $item)
                            <option value="{{ $item }}" {{ $event->is_pay_done == $item ? "selected" : "" }}> {{ $item == 0 ? "Not yet" : "Yes" }}</option>
                        @endforeach
                    </select>
                    @error('is_pay_done') <p> {{ $message }} </p> @enderror
                </td>
            </tr>
            <tr>
                <th>Travel</th>
                <td>
                    <input type="checkbox" value="Yes"  {{ $event->travel == "Yes" ? "checked" : "" }} name="travel" id="travel" class=" @error('travel') is-invalid @enderror">
                    @error('travel') <p> {{ $message }} </p> @enderror
                </td>
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