@extends('template/dashboardLawyer')
@section('title', 'Lawyer')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Register Your Information</h5>
    <div class="card-body">

    <form action="{{ route('lawyer.profile.process') }}" method="POST">
    @csrf 

       <input type="hidden" name="user_id" value="{{ $user->id }}">
        <div class="mb-4">
            <label class="form-label">Username:</label>
            <input type="text" class="form-control" value="{{ $user->username }}" readonly>
        </div>

        <div class="mb-4">
          <label class="form-label">Name:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Mohd Ali bin Abu ">
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
          <input type="text" class="form-control" id="address" name="address" placeholder="">
        </div> 

        <div class="mb-4">
          <label class="form-label">Start Date:</label>
          <input type="date" class="form-control" id="startdate" name="startdate">
        </div>  

        <p><strong>Emergency Contact</strong></p>

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
          <select class="form-select" id="relationship" name="relationship">
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


@endsection