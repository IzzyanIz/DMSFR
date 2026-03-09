@extends('template/dashboardLawyer')
@section('title', 'Client')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Update Client Information</h5>
    <div class="card-body">

      <form action="{{ route('update.client.lawyer', $client->idClient) }}" method="POST" enctype="multipart/form-data">
        @csrf 
        @method('PUT')
        
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">


        <div class="mb-4">
          <label class="form-label">Client Name:</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}">
          </div> 

        <div class="mb-4">
          <label class="form-label">Client Email:</label>
          <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $client->email) }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Identity Card Number(NRIC):</label>
          <input type="text" class="form-control" id="ic" name="ic" value="{{ old('ic', $client->ic) }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Phone Number:</label>
          <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $client->phone) }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Address:</label>
          <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $client->address) }}" >
        </div> 
        <div class="mb-4">
          <label class="form-label">Nationality:</label>
          <select class="form-control" id="nationalitySelect" name="nationality" onchange="toggleOtherNationality()">
            <option value="">-- Select Nationality --</option>
            <option value="Warganegara" {{ $client->nationality == 'Warganegara' ? 'selected' : '' }}>Warganegara</option>
            <option value="Bukan Warganegara">Bukan Warganegara</option>
          </select>

          <div id="otherNationalityDiv" style="display: none; margin-top: 10px;">
            <input type="text" class="form-control" id="otherNationality" name="nationality" placeholder="Please specify nationality">
          </div>
        </div> 

        <div class="mb-4">
          <label class="form-label">Marital Status:</label>
          <select class="form-control" id="marital_status" name="marital_status">
            <option value="">-- Select Marital Status --</option>
            <option value="Single" {{ $client->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
            <option value="Married" {{ $client->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
            <option value="Divorced" {{ $client->marital_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
            <option value="Widowed" {{ $client->marital_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="form-label">Occupation:</label>
          <input type="text" class="form-control" id="occupation" name="occupation" value="{{ old('occupation', $client->occupation) }}" >
        </div> 
        
        <div class="mb-4">
          <label class="form-label">Income:</label>
          <input type="number" step="any" class="form-control" id="income" name="income" value="{{ old('income', $client->income) }}" >
        </div> 

        

        <div class="mb-4">
          <label class="form-label">Client Status:</label>
          <select class="form-control" id="status" name="status">
            <option value="">-- Please select status --</option>
            <option value="ongoing" {{ $client->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
            <option value="completed" {{ $client->status == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="discontinue" {{ $client->status == 'discontinue' ? 'selected' : '' }}>Discontinue</option>
          </select>
        </div>

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Update Client</button>
        </div>
        
      </form>

    </div>
  </div>
</div>
<script>
  function toggleOtherNationality() {
    var select = document.getElementById("nationalitySelect");
    var otherDiv = document.getElementById("otherNationalityDiv");
    var otherInput = document.getElementById("otherNationality");

    if (select.value === "Bukan Warganegara") {
      otherDiv.style.display = "block";
      otherInput.name = "nationality"; 
      select.name = ""; 
    } else {
      otherDiv.style.display = "none";
      otherInput.name = ""; 
      select.name = "nationality"; 
    }
  }
</script>

@endsection