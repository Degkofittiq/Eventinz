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

        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Method</th>
                    <th>Input</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs->makeHidden(['email','password','_token']) as $log)
                    <tr>
                        <td>{{ $log->user->name ?? 'Guest' }}</td>
                        <td>{{ str_replace('admin/', "",  $log->path ) }}</td>
                        <td>{{ $log->method }}</td>
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

@endsection