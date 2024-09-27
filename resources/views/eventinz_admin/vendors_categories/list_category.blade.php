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
        <a href="{{ route('admin.add.category') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New
        </a>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card"  id="responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Categories Names</th>
            <th scope="col">Descriptions</th>
            <th scope="col">Vendor Plus Price</th>
            <th scope="col">Images</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php  $count = 1;  ?>
          @forelse ($categories as $category)
              
          <tr>
            <th scope="row">{{ $count++ }}</th>
            <td>{{ $category->name }}</td>
            <td>{{ $category->description }}</td>
            <td>{{ $category->price ?? "Free" }}</td>
            <td>
              {{-- <img src="{{ Storage::disk('s3')->url($category->category_file) }}" alt="" height="100px" width="100px" class="shadow mx-2 my-2"> --}}
              <img src="{{ $category->category_file }}" alt="" height="100px" width="100px" class="shadow mx-2 my-2">
            </td>
            <td>
              <a href="{{ route('admin.edit.category', $category->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-pen"></i> Edit</a>
              <a href="{{ route('admin.deleteform.category', $category->id) }}"  class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
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