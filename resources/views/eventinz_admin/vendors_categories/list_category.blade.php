@extends('eventinz_admin.layouts.app')

@section('content_admin') 
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Categories List</h3>
    </div>
    <!-- /.card-header -->
    <div class="card">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Categories Names</th>
            <th scope="col">Descriptions</th>
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
            <td>{{ $category->category_file }}</td>
            <td>
              <a href="{{ route('admin.edit.category', $category->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-pen"></i> Edit</a>
              <a href="{{ route('admin.delete.category', $category->id) }}"  class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
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