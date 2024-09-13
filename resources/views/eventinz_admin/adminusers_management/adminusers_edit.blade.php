@extends('eventinz_admin.layouts.app')
@section('content_admin') 
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">User's  Details</h3>
        <div class="card-tools">
            <div style="position: relative; display: inline-block;">
                @if ($adminUserFound->profile_image == "")
                    <img src="{{ asset('AdminTemplate/dist/img/user-avatars-thumbnail_2.png') }}" alt="Product 1" class="img-circle img-size-32 mr-2 bg-white" style="border: none">
                @else
                    <img src="{{ $adminUserFound->profile_image }}" alt="Product 1" class="img-circle img-size-50 mr-2" style="border:none; min-width:40px;min-height:40px; border-radius:50%;">
                @endif
                <span style="position: absolute; bottom: 1px; right: 5px; background-color: {{ $adminUserFound->is_user_online == 'yes' ? '#00ff00' : '#ffc107' }}; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;"></span>
            </div>
      </div>
    </div>
    <!-- /.card-header -->
    <table class="table">
    <tr>
        <th>Generic Id</th>
        <td>{{ $adminUserFound->generic_id }}</td>
    </tr>  

    <tr>
        <th>Name</th>
        <td>{{ $adminUserFound->name }}</td>
    </tr>

    <tr>
        <th>Username</th>
        <td>{{ $adminUserFound->username }}</td>
    </tr>

    <tr>
        <th>Email</th>
        <td>{{ $adminUserFound->email }}</td>
    </tr>

    <tr>
        <th>Gender</th>
        <td>{{ $adminUserFound->user_genders_id ?? "Not set yet"}}</td>
    </tr>    

    <tr>
        <th>Occupation</th>
        <td>{{ $adminUserFound->occupation ?? "Not set yet"}}</td>
    </tr>

    <tr>
        <th>Location</th>
        <td>{{ $adminUserFound->location ?? "Not set yet"}}</td>
    </tr>

    <tr>
        <th>Age</th>
        <td>
            @if ($adminUserFound->age)
            @php
                $age = json_decode($adminUserFound->age);
            @endphp
                <strong>Age: </strong>{{ $age->age }}
                <strong>Status: </strong>{{ $age->status }}
            @else
                Not Set Yet
            @endif
        </td>
    </tr>

    <tr>
        <th>Last time online</th>
        <td>{{ $adminUserFound->last_time_user_online }} ({{ str_replace('after', 'Ago',\Carbon\Carbon::now()->diffForHumans($adminUserFound->last_time_user_online)) }})</td>
    </tr>

    <tr>
        <th colspan="2">
            <center>
                Right(s)
            </center>
        </th>
    </tr>
    <tr>
        <td colspan="2">
            @if ($adminUserFound->admin_rights)
                @php
                    $adminUserFoundRights = json_decode($adminUserFound->admin_rights);
                @endphp
                @foreach ($adminRights as $right)
                    <span class="badge badge-success">{{$right->name}}</span>
                @endforeach
            @else
                <center>
                    No Right(s) set yet.
                </center>
            @endif
        </td>            
    </tr>
</table>
</div>

@endsection