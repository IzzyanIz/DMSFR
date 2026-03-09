@extends('template/dashboardHR')
@section('title', 'Staff')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Register Staff Information</h5>
    <div class="card-body">

      <form action="{{ route('register.staff.process') }}" method="POST">
        @csrf 

        <div class="mb-4">
        <label for="username" class="form-label">Username</label>
        <select class="form-control" id="username" name="user_id" onchange="setRole(this)">
            <option value="" selected disabled>Please select username</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" data-role="{{ $user->roles }}">
                    {{ $user->username }}
                </option>
            @endforeach
        </select>
        </div>

        <div class="mb-4">
          <label class="form-label">Position:</label>
          <input type="text" class="form-control" id="position" name="roles" readonly>          
        </div> 

        <div class="mb-4">
          <label class="form-label">Name:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Please enter full name">
        </div> 

        <div class="mb-4">
          <label class="form-label">Email:</label>
          <input type="text" class="form-control" id="email" name="email" placeholder="name@example.com">
        </div> 

        <div class="mb-4">
          <label class="form-label">Identity Card Number(NRIC):</label>
          <input type="text" class="form-control" id="noIC" name="noIC" placeholder="eg: 901020101982 (without '-') ">
        </div> 

        <div class="mb-4">
          <label class="form-label">Phone Number:</label>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="eg: 0139928192">
        </div> 

        <div class="mb-4">
          <label class="form-label">Address:</label>
          <input type="text" class="form-control" id="address" name="address" placeholder="No. 111 Jalan Cemara 1, Saujana Utama 2, 47000 Sungai Buloh, Selangor">
        </div> 

        <div class="mb-4">
          <label class="form-label">Start Date:</label>
          <input type="date" class="form-control" id="startdate" name="startdate">
        </div>  

        <b><strong>Emergency Contact</strong></b> <br><br>

        <div class="mb-4">
          <label class="form-label">Contact Name:</label>
          <input type="text" class="form-control" id="ContactName" name="ContactName" placeholder="Mohd Ali bin Abu">
        </div> 

        <div class="mb-4">
          <label class="form-label">Contact Address:</label>
          <input type="text" class="form-control" id="ContactAddress" name="ContactAddress" placeholder="">
        </div> 

        <div class="mb-4">
          <label class="form-label">Contact Phone:</label>
          <input type="text" class="form-control" id="ContactPhone" name="ContactPhone" placeholder="0192817729">
        </div> 

        <div class="mb-4">
          <label class="form-label">Relationship:</label>
          <select class="form-control" id="relationship" name="relationship">
            <option selected="">Please select relationship</option>
            <option value="Father">Father</option>
            <option value="Mother">Mother</option>
            <option value="Daughter">Daughter</option>
            <option value="Son">Son</option>
            <option value="Sister">Sister</option>
            <option value="Brother">Brother</option>
            <option value="Aunt">Aunt</option>
            <option value="Uncle">Uncle</option>
            <option value="Neighbour">Neighbour</option>
            <option value="Friend">Friend</option>
            <option value="Other">Other</option>
          </select>         
        </div> 

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Register Staff</button>
        </div>
        
      </form>

    </div>
  </div>
</div>

<script>
  function setRole(select) {
    const selectedOption = select.options[select.selectedIndex];
    const role = selectedOption.getAttribute('data-role');
    document.getElementById('position').value = role;
  }
</script>

@endsection