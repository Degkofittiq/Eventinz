{{-- {{ $userFound }} --}}
@extends('eventinz_admin.layouts.app')
@section('content_admin') 
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">User's  Details</h3>
        <div class="card-tools">
            <div style="position: relative; display: inline-block;">
                @if ($userFound->profile_image == "")
                    <img src="{{ asset('AdminTemplate/dist/img/user-avatars-thumbnail_2.png') }}" alt="Product 1" class="img-circle img-size-32 mr-2 bg-white" style="border: none">
                @else
                    <img src="{{ $userFound->profile_image }}" alt="Product 1" class="img-circle img-size-50 mr-2" style="border:none; min-width:40px;min-height:40px; border-radius:50%;">
                @endif
                <span style="position: absolute; bottom: 1px; right: 5px; background-color: {{ $userFound->is_user_online == 'yes' ? '#00ff00' : '#ffc107' }}; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;"></span>
            </div>
      </div>
    </div>
    <!-- /.card-header -->
    <table class="table">
        <tr>
            <th>Generic Id</th>
            <td>{{ $userFound->generic_id }}</td>
        </tr>    
        <tr>
            <th>Name</th>
            <td>{{ $userFound->name }}</td>
        </tr>
        <tr>
            <th>Username</th>
            <td>{{ $userFound->username }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $userFound->email }}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>
                @if ($userFound->user_genders_id)
                @php
                    $gender = json_decode($userFound->user_genders_id);
                @endphp
                    <strong>Gender: </strong>{{ $gender->gender }}
                    <strong>Status: </strong>{{ $gender->status }}
                @else
                    Not Set Yet
                @endif
            </td>
        </tr>    
        <tr>
            <th>Occupation</th>
            <td>{{ $userFound->occupation ?? "Not set yet"}}</td>
        </tr>
        <tr>
            <th>Location</th>
            <td>{{ $userFound->location ?? "Not set yet"}}</td>
        </tr>
        <tr>
            <th>Age</th>
            <td>
                @if ($userFound->age)
                @php
                    $age = json_decode($userFound->age);
                @endphp
                    <strong>Age: </strong>{{ $age->age }}
                    <strong>Status: </strong>{{ $age->status }}
                @else
                    Not Set Yet
                @endif
            </td>
        </tr>
        <tr>
            <th>Credit</th>
            <td>{{ $userFound->credit }}</td>
        </tr>
        <tr>
            <th>Last time online</th>
            <td>{{ $userFound->last_time_user_online }} ({{ str_replace('after', 'Ago',\Carbon\Carbon::now()->diffForHumans($userFound->last_time_user_online)) }})</td>
        </tr>
        <tr>
            <th colspan="2">
                <center>
                    Events Statistics
                </center>
            </th>
        </tr>

        <tr>
            <th>Total events</th>
            <td>
                ({{ count($eventStatistics['All Events']) > 0 ? $eventStatistics['All Events']->count() : 0 }})
                <strong>
                    List:
                </strong> 
                @foreach ($eventStatistics['All Events'] as $item)
                    <a href="{{ route('admin.details.event', $item->id) }}">{{ $item->generic_id }}</a> , 
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Active events</th>
            <td>
                ({{ count($eventStatistics['Active Events']) > 0 ? $eventStatistics['Active Events']->count() : 0 }})
                <strong>
                    List:
                </strong> 
                @foreach ($eventStatistics['Active Events'] as $item)
                    <a href="{{ route('admin.details.event', $item->id) }}">{{ $item->generic_id }}</a> , 
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Completed events</th>
            <td>
                ({{ count($eventStatistics['Completed Events']) > 0 ? $eventStatistics['Completed Events']->count() : 0 }})
                <strong>
                    List:
                </strong> 
                @foreach ($eventStatistics['Completed Events'] as $item)
                    <a href="{{ route('admin.details.event', $item->id) }}">{{ $item->generic_id }}</a> , 
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Upcomming events</th>
            <td>
                ({{ count($eventStatistics['Future Events']) > 0 ? $eventStatistics['Future Events']->count() : 0 }})
                <strong>
                    List:
                </strong> 
                @foreach ($eventStatistics['Future Events'] as $item)
                    <a href="{{ route('admin.details.event', $item->id) }}">{{ $item->generic_id }}</a> , 
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Canceled events</th>
            <td>
                ({{ count($eventStatistics['Canceled Events']) > 0 ? $eventStatistics['Canceled Events']->count() : 0 }})
                <strong>
                    List:
                </strong> 
                @foreach ($eventStatistics['Canceled Events'] as $item)
                    <a href="{{ route('admin.details.event', $item->id) }}">{{ $item->generic_id }}</a> , 
                @endforeach
            </td>
        </tr>
    </table>
</div>

@endsection