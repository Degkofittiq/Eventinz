@extends('eventinz_admin.layouts.app')
@section('content_admin') 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2.select2-container.select2-container--default{
        height: 40px !important;
    }
</style>
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
                    <select name="" id="emailselect" class="form-control">
                        <option value="desacled">--Select the email address--</option>
                        
                        @foreach ($allusers as $eachuser)
                            <option value="{{ $eachuser->email }}">
                                {{ $eachuser->email }}
                            </option>
                        @endforeach
                    </select>
                    <input type="email" name="email" id="email" class="form-control" style="height: 50px; max-witdh:100% !important;" hidden>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- <script>
    $(document).ready(function() {
    $('#emailselect').select2();
    });
</script>
<script>
    $(document).ready(function(){
        $('span.select2-selection.select2-selection--single').css('height', '35px');
    });
</script> --}}

<script>
    $(document).ready(function() {
        // Initialiser Select2
        $('#emailselect').select2();

        // Mettre à jour la valeur de l'input email lors de la sélection dans le select2
        $('#emailselect').on('change', function() {
            var selectedEmail = $(this).val();  // Récupérer la valeur sélectionnée
            $('#email').val(selectedEmail);     // Mettre à jour le champ email
        });

        // Ajustement de la hauteur pour Select2
        $('span.select2-selection.select2-selection--single').css('height', '35px');
    });
</script>


@endsection