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
      <table class="table" id="myTable">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Categories Names</th>
            <th scope="col">Descriptions</th>
            <th scope="col">Vendor Plus Price</th>
            <th scope="col">Images</th>
            <th scope="col">Creation Date</th>
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
              @if ($category->category_file)
                <img src="{{ $category->category_file }}" alt="" height="100px" width="100px" class="shadow mx-2 my-2">
              @else
                <img src="https://s3-alpha-sig.figma.com/img/bb05/5e25/ab3f70a77d9f42e72dc88584b1f9f868?Expires=1728259200&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=MUl1HkcYg51eBkujNzXp6lw80xuZFzMgrLkmQvc875EadHJq88HeTk0kgF5RhfIAyf07TdMPpGFwo5Y12aeOg69yLAQs5W8B6YUQMfGiWMm2jBLFDyhyLxiKGOW8ALFneU5lDEpPuH76es~rQCM3JH6dFuSTNsrQc3MqXkVjlu22QPnAsb-VD-BNmNqMPy10LmM7K5YogC-3OOb3ZBGl1TBb~p1z~vhl7Ii4f6xhoKI9SlQzfP2Ge03rzaZ7SLnlqy4kx7W8cknLLZVFfsIrMcRlpqh2rFmUKgIyGrl8kb3u3YjddWgAZ2-TtGfpjv3C8Wl5418rszXg~F4zVa34-g__" alt="" height="100px" width="100px" class="shadow mx-2 my-2">
              @endif
            </td>
            <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d-m-y') ?? ""}}</td>
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


<script>
  let table = new DataTable('#myTable', {
    responsive: true, // Ajoute la réactivité
    columnDefs: [
      { orderable: false, targets: [5] } // 7 est l'index de la colonne 'Actions', car les index commencent à 0
    ]
  });
</script>
@endsection