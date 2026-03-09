@extends('template/dashboardLawyer')
@section('title', 'Lawyer')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Register Details Information</h5>
    <div class="card-body">

    <form action="{{ route('lawyer.edit.profile.process') }}" method="POST" enctype="multipart/form-data">
    @csrf 

       <input type="hidden" name="user_id" value="{{ $user->id }}">
        <div class="mb-4">
            <label class="form-label">Username:</label>
            <input type="text" class="form-control" value="{{ $user->username }}" readonly>
        </div>

        <div class="mb-4">
          <label class="form-label">Name:</label>
          <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Email:</label>
          <input type="email" class="form-control" id="email" name="email" >
        </div> 

       <div class="input-group">
          <input type="password" class="form-control" id="password" name="password" placeholder="Default Password is 123456">
          <button class="btn btn-secondary" type="button" id="togglePassword">
              <i class="fa fa-eye" id="toggleIcon"></i>
          </button>
      </div>


        <small id="passwordHelp" class="form-text text-muted">
        Must contain at least 8 characters, one uppercase letter, one number, and one symbol.
        </small>
        <ul id="password-checklist" class="text-muted small">
        <li id="capital">❌ At least one uppercase letter</li>
        <li id="number">❌ At least one number</li>
        <li id="symbol">❌ At least one symbol</li>
        <li id="length">❌ Minimum 8 characters</li>
        </ul>

        <br>

        <div class="mb-4">
          <label class="form-label">Profile Picture:</label>
          <input type="file" class="form-control" id="face_image" name="face_image" >
        </div> 


        <div class="text-end">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        
      </form>

    </div>
  </div>
</div>

<script>
document.getElementById('password').addEventListener('input', function () {
    const value = this.value;
    document.getElementById('capital').textContent = /[A-Z]/.test(value) ? '✅ At least one uppercase letter' : '❌ At least one uppercase letter';
    document.getElementById('number').textContent = /[0-9]/.test(value) ? '✅ At least one number' : '❌ At least one number';
    document.getElementById('symbol').textContent = /[!@#$%^&*(),.?":{}|<>]/.test(value) ? '✅ At least one symbol' : '❌ At least one symbol';
    document.getElementById('length').textContent = value.length >= 8 ? '✅ Minimum 8 characters' : '❌ Minimum 8 characters';
});
</script>

<script>
document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
});
</script>


@endsection