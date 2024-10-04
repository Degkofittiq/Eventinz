@extends('eventinz_admin.layouts.app')
<style>
    .direct-chat-primary .right>.direct-chat-text {
        background-color: white  !important;
        color: #000 !important;
        border: 1px solid !important;
    }

    .direct-chat-primary .right>.direct-chat-text::after, .direct-chat-primary .right>.direct-chat-text::before {
        border-left-color: #000 !important;
    }
</style>
@section('content_admin')
    
<div class="card card-primary container col-md-8 py-2 " style="padding-bottom: 2px" >

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
{{-- 'messages','conversationUser' --}}
    <div class="card-header"  style="background-color: rgb(220,53,220)">
      <h3 class="card-title">Chat with  
        
        {{ $conversationUser->user_one_id == Auth::user()->id ? $conversationUser->userTwo->role->name : $conversationUser->userOne->role->name }}
        {{ $conversationUser->user_one_id == Auth::user()->id ? $conversationUser->userTwo->username : $conversationUser->userOne->username }}
    </h3>
    </div>
    <!-- /.card-header -->
    <div class="card direct-chat direct-chat-primary" style="padding-bottom: 0px !important;">
        <div class="card-body">
          <!-- Conversations are loaded here -->
          <div class="direct-chat-messages">
            <!-- Message. Default to the left -->
            @forelse ($messages as $message)                    
                <div class="direct-chat-msg {{ $message->sender_id == Auth::user()->id ? "right" : "" }}">
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="{{ ($conversationUser->user_one_id == Auth::user()->id ? $conversationUser->userTwo->profile_image : $conversationUser->userOne->profile_image) ??  asset('AdminTemplate/dist/img/user-avatars-thumbnail_2.png') }}" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        {{ $message->body }} 
                    </div>
                    <!-- /.direct-chat-text -->
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name {{ $message->sender_id == Auth::user()->id ? "float-left" : "float-right" }}">{{ $message->sender_id != Auth::user()->id ? $conversationUser->userOne->username : $conversationUser->userTwo->username }}</span>
                        <span class="direct-chat-timestamp {{ $message->sender_id == Auth::user()->id ? "float-right" : "float-left" }}"> {{ " " .\Carbon\Carbon::parse($message->created_at)->format('d M g:i A') }}</span>
                    </div>
                </div>
                <!-- /.direct-chat-msg -->
            @empty
                
                <div class="alert alert-warning">
                    No message yet
                </div>
            @endforelse
          </div>
          <!--/.direct-chat-messages-->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <form action="{{ route('send.message') }}" method="post">
            @csrf
            <div class="input-group">
              <input type="text" name="conversation_id" value="{{ $conversationUser->user_one_id }}" hidden>
              <input type="text" name="body" placeholder="Type Message ..." class="form-control">
              <span class="input-group-append">
                <button type="submit" class="btn"  style="color:white;background-color: rgb(220,53,220)">Send</button>
              </span>
            </div>
          </form>
        </div>
        <!-- /.card-footer-->
      </div>
    </div>
@endsection