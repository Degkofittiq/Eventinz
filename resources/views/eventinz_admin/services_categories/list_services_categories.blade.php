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
      <h3 class="card-title">Company Service Categories</h3>
      <div class="card-tools">
        <a href="{{ route('admin.add.servicescategory') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New
        </a>
      </div>
    </div>
    <!-- /.card-header -->
    {{-- {{ $servicesCategories }} --}}
    <div class="card"  id="responsive">

        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Categories Names</th>
              <th scope="col">Descriptions</th>
              <th scope="col">vendor Category</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php  $count = 1;  ?>
            @forelse ($servicesCategories as $servicesCategorie)
                
                <tr>
                <th scope="row">{{ $count++ }}</th>
                <td>{{ $servicesCategorie->name }}</td>
                <td>{{ $servicesCategorie->description }}</td>
                <td>{{ $servicesCategorie->vendorCategory->name ?? "" }}</td>
                <td>
                    <a href="{{ route('admin.edit.servicescategory', $servicesCategorie->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-pen"></i> Edit</a>
                    {{-- <a href="{{ route('admin.deleteform.servicescategory', $servicesCategorie->id) }}"  class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a> --}}
                </td>
                </tr>
            @empty
                <div class="alert alert-warning">
                  No category yet
                </div>
            @endforelse
          </tbody>
        </table>
      </div>

</div>

@endsection