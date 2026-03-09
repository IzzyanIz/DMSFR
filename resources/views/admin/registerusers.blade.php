@extends('template/dashboardAdmin')
@section('title', 'Manage Users')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Register Staff Information</h5>
    <div class="card-body">

      <form action="{{ route('register.face')}}" method="POST" enctype="multipart/form-data">
        @csrf 

        <div class="mb-4">
          <label class="form-label">Username:</label>
          <input type="text" class="form-control" id="username" name="username" >
        </div> 

        <div class="mb-4">
          <label class="form-label">Email:</label>
          <input type="email" class="form-control" id="email" name="email" >
        </div> 

        <div class="mb-4">
          <label class="form-label">Name:</label>
          <input type="text" class="form-control" id="name" name="name" >
        </div> 

        <div class="mb-4">
          <label class="form-label">Position:</label>
          <select class="form-control" id="roles" name="roles">
            <option selected="">Please select position</option>
            <option value="Human Resource">Human Resource</option>
            <option value="Admin">Admin</option>
            <option value="CEO">Head of Department (HOD)</option>

          </select>           
        </div> 

        <div class="mb-4">
          <label class="form-label">Profile Picture:</label>
          <input type="file" class="form-control" name="face_image" accept="image/*" capture="user" class="form-control mb-3" required >
        </div> 

        <div class="mb-4">
          <label class="form-label">Default Password: 123456</label>
        </div> 

       

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Register Account</button>
        </div>
        
      </form>

    </div>
  </div>
</div>

@endsection