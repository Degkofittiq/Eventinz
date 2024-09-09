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
      <h3 class="card-title">Resend OTP to user</h3>
    </div>
    <!-- /.card-header -->
    <div class="box box-primary mx-2 p-2">
        <div class="box-header with-border">
        </div>
        <form role="form" action="{{ route('admin.resend.otp') }}" method="POST">
            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label for="emailselect">Email address <span style="color:red">*</span></label>
                    <select name="emailselect" id="emailselect" class="form-control">
                        <option value="desacled">--Select the email address--</option>
                        
                        @foreach ($allusers as $eachuser)
                            <option value="{{ $eachuser->email }}">
                                {{ $eachuser->email }}
                            </option>
                        @endforeach
                    </select>
                    <input type="email" name="email" id="email" class="form-control" hidden>

                    <script>
                        document.getElementById('emailselect').addEventListener('change', function() {
                            var selectedEmail = this.value;
                            document.getElementById('email').value = selectedEmail;
                        });
                    </script>
                </div>
            </div>
            
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection