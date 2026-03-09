@extends('template/dashboardAdmin')
@section('title', 'Manage Users')
@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Update Staff Information</h5>
    <div class="card-body">

    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf 

            <div class="mb-4">
            <label class="form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
            </div> 

            <div class="mb-4">
            <label class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
            </div> 

            <div class="mb-4">
            <label class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
            </div> 

            <div class="mb-4">
            <label class="form-label">Position:</label>
            <select class="form-control" id="roles" name="roles">
                <option value="">Please select position</option>
                <option value="Human Resource" {{ $user->roles == 'Human Resource' ? 'selected' : '' }}>Human Resource</option>
                <option value="Admin" {{ $user->roles == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="CEO" {{ $user->roles == 'CEO' ? 'selected' : '' }}>Head of Department</option>
            </select>           
            </div> 

            <div class="mb-4">
            <label class="form-label">Face Image:</label>
            <input type="file" class="form-control" name="face_image" accept="image/*">
            @if($user->face_image)
                <div class="mt-2">
                    <img src="{{ asset('storage/face_images/'.$user->face_image) }}" alt="Face Image" width="100" class="rounded shadow-sm">
                </div>
            @endif

            </div> 

            <div class="text-end">
            <button type="submit" class="btn btn-primary">Update Account</button>
            </div>
        </form>


    </div>
  </div>
</div>

@endsection