{{-- {{ $userFound }} --}}
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
      <h3 class="card-title">User's Support Details</h3>
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
    <form action="{{ route('admin.addlog.supporthelp', $userFound->id) }}" method="post">
        @csrf
        <table class="table">
            <tr>
                <th>Generic Id</th>
                <td>{{ $userFound->generic_id }}</td>
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
                <th>Comment Subject</th>
                <td>
                        <input type="text" name="support_subject" class="form-control @error('support_subject') is-invalid @enderror" placeholder="Write a comment support about">
                        @error('support_subject')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                </td>
            </tr>
            <tr>
                <th>Comment For Support</th>
                <td>
                        <textarea name="support_description" rows="5" class="form-control @error('support_description') is-invalid @enderror" placeholder="Write a comment support about"></textarea><br>
                        @error('support_description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        
                        <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Submit</button>
                </td>
            </tr>
        </table>
    </form>
</div>

@endsection