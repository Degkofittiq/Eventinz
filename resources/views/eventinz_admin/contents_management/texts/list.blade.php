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
      <h3 class="card-title">Content Text List</h3>
      <div class="card-tools">
        <a href="{{ route('admin.add.contenttext') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New Text Content
        </a>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card">

        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Content Name</th>
              <th scope="col">Page</th>
              <th scope="col">French Content</th>
              <th scope="col">English Content</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php  $count = 1;  ?>
            @forelse ($textContents as $textContent)
                
                <tr>
                    <th scope="row">{{ $count++ }}</th>
                    <td>{{ $textContent->name  ?? "" }}</td>
                    <td>{{ $textContent->page }}</td>
                    <td>{{ $textContent->content_fr }}</td>
                    <td>{{ $textContent->content_en }}</td>
                    <td>
                        <a href="{{ route('admin.show.contenttext', $textContent->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Edit</a>
                    </td>
                </tr>
            @empty
                <div class="alert alert-warning">
                  No Content yet
                </div>
            @endforelse
          </tbody>
        </table>
      </div>

</div>

@endsection