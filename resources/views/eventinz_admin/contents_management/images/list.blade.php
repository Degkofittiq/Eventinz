@extends('eventinz_admin.layouts.app')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
<style>
  #dt-length-0{
    margin: 5px !important;
  }
  .dt-length label{
    text-transform: uppercase;
  }
  #padding{
    padding: 5px !important;
    width: 100%;
  }
    #responsive {
      max-width: 100%;
      overflow-x: auto; /* Permet le défilement horizontal */
      -webkit-overflow-scrolling: touch; /* Pour un défilement fluide sur mobile */
    }
  @media (max-width: 768px) {
    #responsive {
      max-width: 100%;
      overflow-x: auto; /* Permet le défilement horizontal */
      -webkit-overflow-scrolling: touch; /* Pour un défilement fluide sur mobile */
    }
    #responsive .dt-layout-row{
      width: 100% !important;
    }
    
    table {
      width: 100%; /* S'assure que le tableau occupe tout l'espace disponible */
      table-layout: auto; /* Ajuste automatiquement la largeur des colonnes */
    }
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
      <h3 class="card-title">Image Contents List</h3>
      <div class="card-tools">
        <a href="{{ route('admin.add.contentimageform') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New Iamge / Icon
        </a>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card" id="responsive">
      <table class="table" id="myTable">
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


<script>
  let table = new DataTable('#myTable', {
    responsive: true, // Ajoute la réactivité
    columnDefs: [
      { orderable: false, targets: [6] } // 7 est l'index de la colonne 'Actions', car les index commencent à 0
    ]
  }
  );
</script>
@endsection