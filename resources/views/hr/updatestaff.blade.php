@extends('template/dashboardHR')
@section('title', 'Staff Information')

@section('section')
<div class="col-md-12">  
  <div class="card">
    <h5 class="card-header">Update Staff Information</h5>
    <div class="card-body">

      <form action="{{ route('update.staff.process', $staff->idStaff) }}" method="POST" enctype="multipart/form-data">
        @csrf 
        @method('PUT')
        <div class="mb-4">
          <label class="form-label">Name:</label>
          <input type="text" class="form-control" name="name" value="{{ $staff->name }}" required><br>
        </div> 

        <div class="mb-4">
          <label class="form-label">Email:</label>
          <input type="text" class="form-control" id="email" name="email" value="{{ $staff->email }}">
        </div> 
        
        <div class="mb-4">
          <label class="form-label">Identity Card Number(NRIC):</label>
          <input type="text" class="form-control" id="noIC" name="noIC" value="{{ $staff->noIC }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Phone Number:</label>
          <input type="text" class="form-control" id="phone" name="phone" value="{{ $staff->phone }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Address:</label>
          <input type="text" class="form-control" id="address" name="address" value="{{ $staff->address }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Start Date:</label>
          <input type="date" class="form-control" id="startdate" name="startdate" value="{{ $staff->startdate }}">
        </div>  

        <p><strong>Emergency Contact</strong></p>

        <div class="mb-4">
          <label class="form-label">Contact Name:</label>
          <input type="text" class="form-control" id="ContactName" name="ContactName" value="{{ $staff->ContactName }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Contact Address:</label>
          <input type="text" class="form-control" id="ContactAddress" name="ContactAddress" value="{{ $staff->ContactAddress }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Contact Phone:</label>
          <input type="text" class="form-control" id="ContactPhone" name="ContactPhone" value="{{ $staff->ContactPhone }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Relationship:</label>
          <select  class="form-control" id="relationship" name="relationship">
            <option disabled {{ $staff->Relationship == null ? 'selected' : '' }}>Please select relationship</option>
            <option value="Father" {{ $staff->Relationship == 'Father' ? 'selected' : '' }}>Father</option>
            <option value="Mother" {{ $staff->Relationship == 'Mother' ? 'selected' : '' }}>Mother</option>
            <option value="Daughter" {{ $staff->Relationship == 'Daughter' ? 'selected' : '' }}>Daughter</option>
            <option value="Son" {{ $staff->Relationship == 'Son' ? 'selected' : '' }}>Son</option>
            <option value="Sister" {{ $staff->Relationship == 'Sister' ? 'selected' : '' }}>Sister</option>
            <option value="Brother" {{ $staff->Relationship == 'Brother' ? 'selected' : '' }}>Brother</option>
            <option value="Aunt" {{ $staff->Relationship == 'Aunt' ? 'selected' : '' }}>Aunt</option>
            <option value="Uncle" {{ $staff->Relationship == 'Uncle' ? 'selected' : '' }}>Uncle</option>
            <option value="Neighbour" {{ $staff->Relationship == 'Neighbour' ? 'selected' : '' }}>Neighbour</option>
            <option value="Friend" {{ $staff->Relationship == 'Friend' ? 'selected' : '' }}>Friend</option>
            <option value="Other" {{ $staff->Relationship == 'Other' ? 'selected' : '' }}>Other</option>
          </select>         
        </div>

        <div class="mb-4">
          <label class="form-label">Status:</label>
          <select class="form-control" id="status" name="status">
            <option selected="">Please select status</option>
            <option value="pending" {{ $staff->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="active" {{ $staff->status == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $staff->status == 'inactive' ? 'selected' : '' }}>Inactive</option>

          </select>
        </div>

        <div class="mb-4">
          <label class="form-label">Letter of Agreement:</label>
          <input type="file" class="form-control" id="loa" name="loa" >
        </div> 

        <div class="mb-4">
          <label class="form-label">Non Disclosure Form:</label>
          <input type="file" class="form-control" id="nda" name="nda" >
        </div> 

        <div class="mb-4">
          <label class="form-label">Asset Hand Over Form:</label>
          <input type="file" class="form-control" id="assetform" name="assetform" >
        </div> 

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Update Staff</button>
        </div>
        
      </form>

    </div>
  </div>
</div>
@endsection