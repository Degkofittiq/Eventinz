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
      <h3 class="card-title">Event Type List</h3>
      <div class="card-tools">
        <a href="{{ route('admin.add.eventtypeform') }}" class="btn bg-default">
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
              <th scope="col"  style="width: 40%">Name</th>
              <th scope="col"  style="width: 30%">Description</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php  $count = 1;  ?>
            @forelse ($eventTypes as $eventType)
                
                <tr>
                <th scope="row">{{ $count++ }}</th>
                <td>{{ $eventType->name  ?? "" }}</td>
                <td>{{ $eventType->description  ?? "" }}</td>
                <td>
                    <a href="{{ route('admin.edit.eventtypeform', $eventType->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Details</a>
                    <a href="{{ route('admin.deleteform.eventtype', $eventType->id) }}"  class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                </td>
                </tr>
            @empty
                <div class="alert alert-warning">
                  No Payment yet
                </div>
            @endforelse
          </tbody>
        </table>
      </div>

</div>

@endsection