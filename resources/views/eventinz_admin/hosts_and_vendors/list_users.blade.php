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
      <h3 class="card-title">Categories List</h3>
      <div class="card-tools">
        {{-- <a href="{{ route('admin.add.users') }}" class="btn bg-default">
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
            <th scope="col">Generic Ids</th>
            <th scope="col">Names</th>
            <th scope="col">Usernames</th>
            <th scope="col">Emails</th>
            <th scope="col">Credits</th>
            <th scope="col">User Type</th>
            <th scope="col">Profile Image</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php  $count = 1;  ?>
          @forelse ($users as $users)
              
          <tr>
            <th scope="row">{{ $count++ }}</th>
            <td>{{ $users->generic_id }}</td>
            <td>{{ $users->name }}</td>
            <td>{{ $users->username }}</td>
            <td>{{ $users->email }}</td>
            <td>{{ $users->credit }}</td>
            <td>{{ $users->role_id == 1 ? "Host" : "Vendor" }}</td>
            <td>
                @if ($users->profile_image == "")
                    <img src="{{ asset('AdminTemplate/dist/img/user2-160x160.jpg') }}" alt="Product 1" class="img-circle img-size-32 mr-2" style="border: 1px solid black">
                @else
                    <img src="{{ asset('storage/'. $users->profile_image) }}" alt="Product 1" class="img-circle img-size-32 mr-2" style="border: 1px solid black">
                @endif
            </td>
            <td>
              <a href="#"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
              {{-- <a href="{{ route('admin.deleteform.users', $users->id) }}"  class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a> --}}
            </td>
          </tr>
          @empty
              <div class="alert alert-warning">
                No users yet
              </div>
          @endforelse
        </tbody>
      </table>
    </div>
</div>
@endsection