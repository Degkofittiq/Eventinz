@extends('eventinz_admin.layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    .after-display-block{
        display: flex;
        justify-content: flex-end;
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
      <h3 class="card-title">Admin User Creation</h3>
        <div class="card-tools">
      </div>
    </div>
    <!-- /.card-header -->
    <form action="{{ route('admin.add.adminuser') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <table class="table">
            <tr>
                <th>
                    <label for="name">Name</label>
                </th>
                <td>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invallid @enderror" placeholder="Put the new Admin/Master Name">
                    <p class="text-red">@error('name') {{ $message }} @enderror</p>
                </td>
            </tr>

            <tr>
                <th>
                    <label for="username">Username</label>
                </th>
                <td>
                    <input type="text" name="username" id="username" class="form-control @error('username') is-invallid @enderror" placeholder="Put the new Admin/Master Username">
                    <p class="text-red">@error('username') {{ $message }} @enderror</p>
                </td>
            </tr>

            <tr>
                <th>
                    <label for="email">Email</label>
                </th>
                <td>
                    <input type="text" name="email" id="email" class="form-control @error('email') is-invallid @enderror" placeholder="Put the new Admin/Master Email">
                    <p class="text-red">@error('email') {{ $message }} @enderror</p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="password">Password</label>                    
                </th>
                <td>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Put the new Admin/Master Password">
                        <div class="input-group-append">
                            <span class="input-group-text" onclick="togglePassword()">
                                <i class="fa fa-eye" id="togglePasswordIcon"></i>
                            </span>
                        </div>
                    </div>
                    <p class="text-red">@error('password') {{ $message }} @enderror</p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="password_confirmation">Confirm Password</label>                    
                </th>
                <td>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Put the new Admin/Master Password">
                        <div class="input-group-append">
                            <span class="input-group-text" onclick="togglePasswordConfirmation()">
                                <i class="fa fa-eye" id="togglePassword_confirmationIcon"></i>
                            </span>
                        </div>
                    </div>
                    <p class="text-red">@error('password_confirmation') {{ $message }} @enderror</p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="role_id">Roles</label>                    
                </th>
                <td>
                    <select name="role_id" id="role_id" class="form-control @error('role_id') is-invallid @enderror" placeholder="Put ">
                        <option value="">-- Select the new Admin/Master Roles --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>                            
                        @endforeach
                    </select>
                    <p class="text-red">@error('role_id') {{ $message }} @enderror</p>
                </td>
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
                    <label for="rights">Right <span class="required">*</span> </label><br>
                    @error('rights')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror  
                    <p type="button" class="btn btn-info" id="toggleButton" onclick="toggleCheckboxes()">Select All</p> <br>
                    <div class="row">
                        
                        @php
                            //  id="toggleButton" onclick="toggleCheckboxes()"
                            $id = 1;
                        @endphp
                        @foreach($rightTypes as $rightType)
                            <div class="col-md-12">
                                <div class="card collapsed-card" style="border-top: 3px solid rgb({{ rand(0,255) }},{{ rand(0,255) }},{{ rand(0,255) }})">
                                    <div class="card-header" data-card-widget="collapse">
                                        <h3 class="card-title">
                                            <strong>{{ $rightType->name }}</strong> <!-- Nom du type de droit -->
                                        </h3>
                            
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" ><i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                        
                                    @php
                                        $rightsChunks = $rightType->rights->chunk(1); // Divise les droits en groupes de 3 pour les colonnes
                                    @endphp

                                    <div class="card-body after-display-block">
                                        <div class="row">
                                            <span style="border: 1px solid" class="btn btn-sm checkAllButton {{ 'class_'.$id++ }}" data-type-id="{{ $rightType->id }}" id="checkAllButton" onclick="checkAllboxes({{ $rightType->id }})">Check all</span>
                                        </div>
                                        <div class="row">
                                            @foreach($rightsChunks as $chunk)
                                                    <div class="col-md-4">
                                                        @foreach($chunk as $right)
                                                            <span>
                                                                <input 
                                                                    type="checkbox" 
                                                                    name="rights[]" 
                                                                    id="rights_{{ $right->name }}" 
                                                                    value="{{ $right->name }}"
                                                                    style="margin-left: 20px" 
                                                                    class="right-checkbox type-{{ $rightType->id }} @error('rights') is-invalid @enderror" 
                                                                    placeholder="Put the new Admin/Master Rights">
                                                                <!-- Right Name -->
                                                                <label for="rights_{{ $right->name }}"> {{ $right->description }} </label>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                            @endforeach
                                        </div>
                                    </div>
                                        <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->          
                        @endforeach
                    </div>
                </td>        
            </tr>
            <tr>
                <th>
                    <label for="action">Action</label>
                </th>
                <td>
                    <button class="btn btn-sm btn-info">
                        <i class="fa fa-save"></i>
                        Create
                    </button>
                </td>
            </tr>
        </table>
    </form>
</div>

<script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        var toggleIcon = document.getElementById("togglePasswordIcon");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>

<script>
    function togglePasswordConfirmation() {
        var passwordField = document.getElementById("password_confirmation");
        var toggleIcon = document.getElementById("togglePassword_confirmationIcon");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>

<script>

    function toggleCheckboxes() {
        const checkboxes = document.querySelectorAll('input[name="rights[]"]');
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        const button = document.getElementById('toggleButton');
        
        checkboxes.forEach(checkbox => {
            checkbox.checked = !allChecked;
        });

        button.textContent = allChecked ? 'Select All' : 'Deselect All';
    }

    function handleRoleChange() {
        const roleSelect = document.getElementById('role_id');
        const checkboxes = document.querySelectorAll('input[name="rights[]"]');
        
        if (roleSelect.value === '4') {
            toggleCheckboxes();
        } else {
            checkboxes.forEach(checkbox => checkbox.checked = false);
            document.getElementById('toggleButton').textContent = 'Select All';
        }
    }

    document.getElementById('role_id').addEventListener('change', handleRoleChange);
</script>

<script>
    function checkAllboxes(id) {
        const checkboxes = document.querySelectorAll(`.right-checkbox.type-${id}`); // Sélectionne toutes les cases à cocher ayant une classe spécifique
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked); // Vérifie si toutes les cases sont cochées
    
        // Inverse l'état de sélection des cases à cocher
        checkboxes.forEach(checkbox => {
            checkbox.checked = !allChecked;
        });
    
        // Met à jour le texte du bouton en fonction de l'état des cases
        const button = document.querySelector(`.btn[data-type-id='${id}']`);
        button.textContent = allChecked ? 'Check all' : 'Uncheck all';
    }
    
    // Appel direct de la fonction pour le type de droit approprié
    checkAllboxes({{ $rightType->id }});

</script>
@endsection