@extends('eventinz_admin.layouts.app')

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
    <!-- /.card-header -->
    <div class="card">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Names</th>
            <th scope="col">Vendors</th>
            <th scope="col">Countries	</th>
            <th scope="col">Category(ies)</th>
            <th scope="col">Service Type</th>
            <th scope="col">Subscriptions</th>
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
            <td>{{ $company->serviceType->name }}</td>
            <td>{{ $company->subscriptionPlan->name }}</td>
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
@endsection