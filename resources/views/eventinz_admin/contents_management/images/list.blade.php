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
      <h3 class="card-title">Image Contents List</h3>
      <div class="card-tools">
        <a href="{{ route('admin.add.contentimageform') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New Iamge / Icon
        </a>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Pages</th>
            <th scope="col">Names</th>
            <th scope="col">Types</th>
            <th scope="col">Images</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php  $count = 1;  ?>
          @forelse ($imageContents as $imageContent)
              
          <tr>
            <th scope="row">{{ $count++ }}</th>
            <td>{{ $imageContent->page }}</td>
            <td>{{ $imageContent->name }}</td>
            <td>{{ $imageContent->type }}</td>
            <td>
              {{-- <img src="{{ Storage::disk('s3')->url($imageContent->path) }}" alt="" height="100px" width="100px" class="shadow mx-2 my-2"> --}}
              <img src="{{ $imageContent->path }}" alt="" height="100px" width="100px" class="shadow mx-2 my-2">
            </td>
            <td>
              <a href="{{ route('admin.show.contentimage', $imageContent->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-pen"></i> Edit</a>
            </td>
          </tr>
          @empty
              <div class="alert alert-warning">
                No imageContent yet
              </div>
          @endforelse
        </tbody>
      </table>
    </div>
</div>
@endsection