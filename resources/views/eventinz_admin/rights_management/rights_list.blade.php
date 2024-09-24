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
      <h3 class="card-title">Rights List</h3>
      {{-- <div class="card-tools">
        <a href="{{ route('admin.addform.right') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New
        </a>
      </div> --}}
    </div>
    <!-- /.card-header -->
    <div class="card" id="responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Names</th>
            <th scope="col">Functionnality parent</th>
            <th scope="col">description</th>
            {{-- <th scope="col">Actions</th> --}}
          </tr>
        </thead>
        <tbody>
          <?php  $count = 1;  ?>
          @forelse ($rights as $right)
              
          <tr>
            <th scope="row">{{ $count++ }}</th>
            <td>{{ $right->name ?? "" }}</td>
            <td>{{ $right->rights_types->name ?? "Not set Yet" }}</td>
            <td>{{ $right->description ?? "Not set Yet" }}</td>
            {{-- <td>
              <a href="{{ '#' }}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Details</a>
            </td> --}}
          </tr>
          @empty
              <div class="alert alert-warning">
                No Data yet
              </div>
          @endforelse
        </tbody>
      </table>
    </div>
</div>
@endsection