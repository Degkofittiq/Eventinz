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
      <h3 class="card-title">Vendor class List</h3>
      <div class="card-tools">
        <a href="{{ route('admin.add.vendorclassform') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New
        </a>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card" id="responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Names</th>
            <th scope="col">Description</th>
            <th scope="col">Service Number</th>
            <th scope="col">Creation Date</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php  $count = 1;  ?>
          @forelse ($vendorClasses as $vendorClasse)
              
          <tr>
            <th scope="row">{{ $count++ }}</th>
            <td>{{ $vendorClasse->name ?? "" }}</td>
            <td>{{ $vendorClasse->description ?? "" }}</td>
            <td>{{ $vendorClasse->service_number ?? "" }}</td>
            <td>{{ \Carbon\Carbon::parse($vendorClasse->created_at)->format('d-m-y') ?? ""}}</td>
            <td>
              <a href="{{ route('admin.show.vendorclass', $vendorClasse->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Details</a>
            </td>
          </tr>
          @empty
              <div class="alert alert-warning">
                No Subscription Plan yet
              </div>
          @endforelse
        </tbody>
      </table>
    </div>
</div>
@endsection