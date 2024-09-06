{{-- {{ $userFound }} --}}
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
                        <?php                   
                            // $servicenames = [
                            //     "Photoshoot",
                            //     "Videography",
                            //     "Editing",
                            //     "Branding",
                            //     "Graphic Design",
                            //     "Logo Design",
                            // ];    
                        ?>  
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($companyServices as $companyService) 
                                    <tr class="service-group">
                                        <td>
                                            <select name="servicename[]" class="form-control">
                                                @foreach ($servicenames as $servicename)
                                                    @if ($servicename == $companyService->servicename)
                                                        <option value="{{ $servicename }}" selected>{{ $servicename }}</option>
                                                    @else                                                    
                                                        <option value="{{ $servicename }}">{{ $servicename }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="type[]" class="form-control">
                                                <option value="{{ $companyService->type }}">{{ $companyService->type }}</option>
                                                <!-- Ajoutez d'autres options selon vos besoins -->
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="rate[]" class="form-control" placeholder="Rate" value="{{ $companyService->rate }}">
                                        </td>
                                        <td><button type="button" class="btn btn-danger btn-remove-service">Remove</button></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No service(s) yet!</td>
                                    </tr>
                                @endforelse  
                            </tbody>
                        </table>
                    </div>
                
                    <div class="form-group mt-3">
                        <label>Subdetails</label>
                        <textarea class="form-control" rows="3" placeholder="Enter subdetails..." style="height: 100px;" name="subdetails">{{ $companyService->subdetails }}</textarea>
                    </div>
{{--                 
                    <div class="form-check mt-3">
                        <input type="checkbox" class="form-check-input" id="travel" name="travel" value="yes" @if ($companyService->travel == "yes") checked @endif>
                        <label class="form-check-label" for="travel">Travel</label>
                    </div> --}}
                
                    <div class="btn-group mt-3">  
                        <button type="submit" class="btn btn-info mx-2">
                            <i class="fa fa-save"></i> 
                            Update Services
                        </button>
                        <button type="button" class="btn btn-success mx-2" id="btn-add-feature">
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
</table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const servicesWrapper = document.getElementById('services-wrapper');
        const addServiceButton = document.getElementById('btn-add-feature');

        addServiceButton.addEventListener('click', function() {
            const serviceGroup = document.createElement('tr');
            serviceGroup.className = 'service-group';

            serviceGroup.innerHTML = `
                <td>
                    <select name="servicename[]" class="form-control">
                        <option value="">Select Service Name</option>
                        @foreach ($servicenames as $servicename)
                            <option value="{{ $servicename }}">{{ $servicename }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="type[]" class="form-control">
                        <option value="T&M">T&M</option>
                        <option value="Fixed">Fixed</option>
                        <!-- Ajoutez d'autres options selon vos besoins -->
                    </select>
                </td>
                <td>
                    <input type="number" name="rate[]" class="form-control" placeholder="Rate">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-remove-service">Remove</button>
                </td>
            `;

            servicesWrapper.querySelector('tbody').appendChild(serviceGroup);

            // Attach the remove functionality to the new remove button
            serviceGroup.querySelector('.btn-remove-service').addEventListener('click', function() {
                serviceGroup.remove();
            });
        });

        // Attach the event listener to the existing remove buttons
        document.querySelectorAll('.btn-remove-service').forEach(button => {
            button.addEventListener('click', function() {
                button.closest('.service-group').remove();
            });
        });
    });
</script>

@endsection