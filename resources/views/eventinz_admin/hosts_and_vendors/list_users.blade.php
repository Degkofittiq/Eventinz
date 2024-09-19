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
      <h3 class="card-title">Hosts & Vendors List</h3>
      <div class="card-tools">
        {{-- <a href="{{ route('admin.add.users') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New
        </a> --}}
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card" id="responsive">
      <table class="table" id="myTable">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Generic</th>
            <th scope="col">Usernames</th>
            <th scope="col">Emails</th>
            {{-- <th scope="col">Credits</th> --}}
            <th scope="col">Type</th>
            <th scope="col">Created at</th>
            <th scope="col">Last time Online</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php  $count = 1;  ?>
          @forelse ($users as $user)
              
          <tr>
            <th scope="row">{{ $count++ }}</th>
            <td>{{ $user->generic_id }}</td>
            {{-- <td>{{ $user->name }}</td> --}}
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            {{-- <td>{{ $user->credit }}</td> --}}
            <td>{{ $user->role->name ?? "" }}</td>
            <td>
              {{ $user->created_at ?? "" }}
                {{-- @if ($user->profile_image == "")
                    <img src="{{ asset('AdminTemplate/dist/img/user-avatars-thumbnail_2.png') }}" alt="Product 1" class="img-circle img-size-32 mr-2" style="border: 1px solid black; min-width:50px;min-height:50px;">
                @else
                    <img src="{{ $user->profile_image }}" alt="Product 1" class="img-circle img-size-32 mr-2" style="border: 1px solid black; min-width:50px;min-height:50px;">
                @endif --}}
            </td>
            <td>
              @if ($user->last_time_user_online == null || $user->last_time_user_online == "yes")
                  <span>N/A</span>
              @else
                {{ \Carbon\Carbon::now()->diffForHumans($user->last_time_user_online) }}
              @endif
            </td>
            <td>
              <a href="{{ route('admin.details.user',$user->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
              {{-- <a href="{{ route('admin.deleteform.user', $user->id) }}"  class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a> --}}
            </td>
          </tr>
          @empty
              <div class="alert alert-warning">
                No user yet
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
      { orderable: false, targets: [7] } // 7 est l'index de la colonne 'Actions', car les index commencent à 0
    ]
  }
  );
</script>
@endsection 