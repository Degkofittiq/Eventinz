@extends('eventinz_admin.layouts.app')
<style>
  
  .limited-text2{
      white-space: nowrap; 
      width: 50px !important;
      overflow: hidden;
      text-overflow: ellipsis;
    }
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
      <h3 class="card-title">Event view status List</h3>
      <div class="card-tools">
        <a href="{{ route('admin.add.eventviewstatusform') }}" class="btn bg-default">
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
              <th scope="col" >Name</th>
              <th scope="col" class="limited-text2"  data-limit="5">Description</th>
              <th scope="col">Price</th>
              <th scope="col" >Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php  $count = 1;  ?>
            @forelse ($eventViewStatuses as $eventViewStatus)
                
                <tr>
                <th scope="row">{{ $count++ }}</th>
                <td>{{ $eventViewStatus->name  ?? "" }}</td>
                <td class="limited-text2"  data-limit="5">{{ $eventViewStatus->description  ?? "" }}</td>
                <td>{{ $eventViewStatus->price  ?? "" }}</td>
                <td>
                    <a href="{{ route('admin.edit.eventviewstatusform', $eventViewStatus->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Details</a>
                    <a href="{{ route('admin.deleteform.eventviewstatus', $eventViewStatus->id) }}"  class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                </td>
                </tr>
            @empty
                <div class="alert alert-warning">
                  No Types yet
                </div>
            @endforelse
          </tbody>
        </table>
      </div>

</div>

@endsection