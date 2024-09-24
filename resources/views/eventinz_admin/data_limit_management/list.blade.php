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
      <h3 class="card-title">Datas limit List</h3>
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
            <th scope="col">Value</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php  $count = 1;  ?>
          @forelse ($datalimits as $datalimit)
              
          <tr>
            <th scope="row">{{ $count++ }}</th>
            <td>{{ $datalimit->name ?? "" }}</td>
            <td>{{ $datalimit->value ?? "Not set Yet" }}</td>
            <td>
              <a href="{{ route('admin.edit.datalimit', $datalimit->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Details</a>
            </td>
          </tr>
          @empty
              <div class="alert alert-warning">
                No Data limit set yet
              </div>
          @endforelse
        </tbody>
      </table>
    </div>
</div>
@endsection