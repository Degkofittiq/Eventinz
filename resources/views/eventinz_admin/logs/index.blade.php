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
      <h3 class="card-title">Logs List</h3>
      {{-- <div class="card-tools">
        <a href="{{ route('admin.add.paymenttaxeForm') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New
        </a>
      </div> --}}
    </div>
    <!-- /.card-header -->
    <div class="card" id="responsive">

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Route</th>
                    <th>Input</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs->makeHidden(['email','password','_token']) as $log)
                    <tr>
                        <td>
                            <a href="{{ $log->user ? route('admin.edit.adminuserform',$log->user_id) : '#' }}" style="{{ $log->user ? 'color: black; text-decoration:underline' : 'color: black; text-decoration:underline' }}">{{ $log->user->username ?? 'Guest' }}</a>
                        </td>
                        <td>{{ $log->action }}</td>
                        <td>{{ str_replace('admin/', "",  preg_replace('/\/\d+/', '/*****', $log->path) ) }}</td>
                        <td>
                            @php
                                // Décoder l'input JSON
                                $inputData = json_decode($log->input, true);
                            @endphp
                            
                            @if (is_array($inputData))
                                <ul>
                                    @foreach ($inputData as $key => $value)
                                        <li> 
                                            @if (ucfirst($key) == "Password")
                                                <strong>{{ ucfirst($key) }}:</strong> 
                                                @if (is_array($value))
                                                    {{ implode(', ', $value) }}
                                                @else
                                                    {{ "*************"  }}
                                                @endif 
                                            @else
                                                <strong>{{ ucfirst($key) }}:</strong> 
                                                @if (is_array($value))
                                                    {{ implode(' | ', $value) }}
                                                @else
                                                    {{ $value }}
                                                @endif    
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                {{ $log->input }}
                            @endif
                        </td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>            
        </table>
        {{-- {{ $logs->links() }} --}}
      </div>

</div>


<script>
    let table = new DataTable('#myTable', {
      responsive: true, // Ajoute la réactivité
    //   columnDefs: [
    //     { orderable: false, targets: [7] } // 7 est l'index de la colonne 'Actions', car les index commencent à 0
    //   ]
    }
    );
  </script>
@endsection