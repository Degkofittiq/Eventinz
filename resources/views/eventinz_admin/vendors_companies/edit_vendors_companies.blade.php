@extends('eventinz_admin.layouts.app')
<style>
    .feature-group {
        display: flex;
        align-items: center;
    }

    .feature-group .form-control {
        flex: 1;
    }

    .feature-group .btn-remove-item {
        margin-left: 10px;
    }

    #btn-add-feature i {
        font-size: 0.8em;
    }
    .service-group > *{
        margin: 2px 3px;
    }
    /* .myscroll{
        max-height: 100%;
        overflow-x: scroll;
    } */
</style>

@section('content_admin') 
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Company Details</h3>
      <div class="card-tools">
        {{-- <a href="{{ route('admin.add.company') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New
        </a> --}}
      </div>
    </div>
    <!-- /.card-header --><table class="table">
    <tr>
        <th>Nom de la compagnie</th>
        <td>{{ $company->name }}</td>
    </tr>
    <tr>
        <th>Nom d'utilisateur</th>
        <td>{{ $company->user->username }}</td>
    </tr>
    <tr>
        <th>Pays</th>
        <td>{{ $company->country }}</td>
    </tr>
    <tr>
        <th>Catégories</th>
        <td>
            @if ($company->vendorCategories->isNotEmpty())
                {{ $company->vendorCategories->pluck('name')->implode(', ') }}
            @else
                "Aucune catégorie"
            @endif
        </td>
    </tr>
    <tr>
        <th>Type de service</th>
        <td>{{ $company->serviceType->name ?? ""}}</td>
    </tr>
    <tr>
        <th>Plan d'abonnement</th>
        <td>{{ $company->subscriptionPlan->name ?? ""}}</td>
    </tr>
    <tr>
        <th colspan="2">
            <center>
                Service(s) List
            </center>
        </th>
    </tr>
    <tr>
        <th colspan="2">
            <!-- Dynamic Features Section -->
            <div class="form-group">
                <label>Services Items</label>
                @if (count($companyServices) > 0)
                    <form action="{{ route('admin.update.companyservices', $company->id ) }}" method="post" enctype="multipart/form-data">  
                        @csrf
                        <div id="services-wrapper">                         
                                @forelse ($companyServices as $companyService) 
                                    <div class="service-group d-flex align-items-center mb-2">
                                        <select name="servicename[]" class="form-control">
                                            <option value="{{ $companyService->servicename }}">{{ $companyService->servicename }}</option>
                                            <option value="Videography">Videography</option>
                                            <option value="Editing">Editing</option>
                                            <!-- Ajoutez d'autres options selon vos besoins -->
                                        </select>
                                        <select name="type[]" class="form-control">
                                            <option value="{{ $companyService->type }}">{{ $companyService->type }}</option>
                                            <option value="{{ $companyService->type }}">{{ $companyService->type }}</option>
                                            <!-- Ajoutez d'autres options selon vos besoins -->
                                        </select>
                                        <input type="text" name="rate[]" class="form-control" placeholder="Rate" value="{{ $companyService->rate }}">
                                        <input type="text" name="duration[]" class="form-control" placeholder="Duration" value="{{ $companyService->duration }}">
                                        <input type="number" step="0.01" name="service_price[]" class="form-control" placeholder="Service Price" value="{{ $companyService->service_price }}">
                                        <select name="is_pay_by_hour[]" class="form-control">
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        {{-- <button type="button" class="btn btn-danger btn-remove-service">Remove</button> --}}
                                    </div>
                                @empty
                                    {{ "No service(s) yet !" }}
                                @endforelse  
                        </div>
                        <div class="form-group">
                            <label>Subdetails</label>
                            <textarea class="form-control" rows="3" placeholder="Enter subdetails..." style="height: 100px;" name="subdetails"></textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="travel" name="travel" value="yes">
                            <label class="form-check-label" for="travel">Travel</label>
                        </div>
                        <div class="btn-group">  
                            <button type="submit" class="btn btn-info mt-3 mx-2">
                                <i class="fa fa-save"></i> 
                                Update Services
                            </button>
                            <button type="button" class="btn btn-success mt-3 mx-2" id="btn-add-feature">
                                <i class="fa fa-plus"> Add item</i>
                            </button>
                        </div>
                    </form> 
                @else
                    {{ "No service(s) for this company yet" }}
                @endif 
            </div>
        </th>
    </tr>
    {{-- <tr>
        <th>Actions</th>
        <td>
            <a href="{{ route('admin.edit.company', $company->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pen"></i> Modifier</a>
        </td>
    </tr> --}}
</table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const servicesWrapper = document.getElementById('services-wrapper');
        const addServiceButton = document.getElementById('btn-add-feature');

        addServiceButton.addEventListener('click', function() {
            const serviceGroup = document.createElement('div');
            serviceGroup.className = 'service-group d-flex align-items-center mb-2';

            serviceGroup.innerHTML = `
                <select name="servicename[]" class="form-control">
                    <option value="Photoshoot">Photoshoot</option>
                    <option value="Videography">Videography</option>
                    <option value="Editing">Editing</option>
                    <!-- Ajoutez d'autres options selon vos besoins -->
                </select>
                <select name="type[]" class="form-control">
                    <option value="T&M">T&M</option>
                    <option value="Fixed">Fixed</option>
                    <!-- Ajoutez d'autres options selon vos besoins -->
                </select>
                <input type="text" name="rate[]" class="form-control" placeholder="Rate">
                <input type="text" name="duration[]" class="form-control" placeholder="Duration">
                <input type="text" name="service_price[]" class="form-control" placeholder="Service Price">
                <select name="is_pay_by_hour[]" class="form-control">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                <button type="button" class="btn btn-danger btn-remove-service">Remove</button>
            `;

            servicesWrapper.appendChild(serviceGroup);

            serviceGroup.querySelector('.btn-remove-service').addEventListener('click', function() {
                serviceGroup.remove();
            });
        });

        // Attach the event listener to the existing remove button
        document.querySelectorAll('.btn-remove-service').forEach(button => {
            button.addEventListener('click', function() {
                button.closest('.service-group').remove();
            });
        });
    });
</script>
@endsection