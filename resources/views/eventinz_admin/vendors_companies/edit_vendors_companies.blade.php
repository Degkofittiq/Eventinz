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
</style>

@section('content_admin') 
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Companies List</h3>
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
        <td>{{ $company->serviceType->name }}</td>
    </tr>
    <tr>
        <th>Plan d'abonnement</th>
        <td>{{ $company->subscriptionPlan->name }}</td>
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
                <div id="services-wrapper">
                    <div class="feature-group d-flex align-items-center mb-2">
                        <input type="text" name="servicename[]" class="form-control me-2"
                            placeholder="Service item">
                        <button type="button" class="btn btn-danger btn-remove-item">Remove</button>
                    </div>
                </div>
                <button type="button" class="btn btn-success mt-3" id="btn-add-feature">
                    <i class="fa fa-plus"> Add item</i>
                </button>
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
        const featuresWrapper = document.getElementById('services-wrapper');
        const addFeatureButton = document.getElementById('btn-add-feature');

        addFeatureButton.addEventListener('click', function() {
            const featureGroup = document.createElement('div');
            featureGroup.className = 'feature-group d-flex align-items-center mb-2';
            featureGroup.innerHTML = `
        <input type="text" name="servicename[]" class="form-control me-2" placeholder="Service item">
        <button type="button" class="btn btn-danger btn-remove-item">Remove</button>
    `;
            featuresWrapper.appendChild(featureGroup);

            featureGroup.querySelector('.btn-remove-item').addEventListener('click', function() {
                featureGroup.remove();
            });
        });

        // Attach the event listener to the existing remove button
        document.querySelectorAll('.btn-remove-item').forEach(button => {
            button.addEventListener('click', function() {
                button.closest('.feature-group').remove();
            });
        });
    });
</script>
@endsection