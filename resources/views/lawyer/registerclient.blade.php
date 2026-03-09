@extends('template/dashboardLawyer')
@section('title', 'Client')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Register Client Information</h5>
    <div class="card-body">

      <form action="{{ route('client.store.lawyer')}}" method="POST">
        @csrf 

        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

 
        <div class="mb-4">
          <label class="form-label">Client Name:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Mohd Ali bin Abu ">
        </div> 

        <div class="mb-4">
          <label class="form-label">Client Email:</label>
          <input type="text" class="form-control" id="email" name="email" placeholder="name@example.com">
        </div> 

        <div class="mb-4">
          <label class="form-label">Identity Card Number(NRIC):</label>
          <input type="text" class="form-control" id="ic" name="ic" placeholder="eg: 901020101982 (without '-') ">
        </div> 

        <div class="mb-4">
          <label class="form-label">Phone Number:</label>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="eg: 0139928192">
        </div> 

        <div class="mb-4">
          <label class="form-label">Address:</label>
          <input type="text" class="form-control" id="address" name="address" >
        </div>  

        <div class="mb-4">
          <label class="form-label">Nationality:</label>
          <select class="form-control" id="nationalitySelect" name="nationality" onchange="toggleOtherNationality()">
            <option value="">-- Select Nationality --</option>
            <option value="Warganegara">Warganegara</option>
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
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Divorced">Divorced</option>
            <option value="Widowed">Widowed</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="form-label">Occupation:</label>
          <input type="text" class="form-control" id="occupation" name="occupation" >
        </div> 
        
        <div class="mb-4">
          <label class="form-label">Income:</label>
          <input type="number" step="any" class="form-control" id="income" name="income">
        </div> 

        


        <div class="text-end">
          <button type="submit" class="btn btn-primary">Register Client</button>
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