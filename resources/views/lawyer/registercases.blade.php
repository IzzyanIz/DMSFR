@extends('template/dashboardLawyer')
@section('title', 'Cases')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Register Cases Information</h5>
    <div class="card-body">

      <form action="{{ route('submit.cases.lawyer') }}" method="POST">
        @csrf 
        <div class="mb-4">
            <label class="form-label">Username Lawyer in charge:</label>
            <select class="form-control" id="username" name="lawyer_id">
              <option value="">Please select username</option>
              @foreach ($lawyers as $lawyer)
                  <option value="{{ $lawyer->id }}">{{ $lawyer->username }}</option>
              @endforeach
          </select>
        </div>
 
        <div class="mb-4">
            <label class="form-label">client:</label>
            <select class="form-control" id="username" name="client_id">
                <option value="">Please select client</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->idClient }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
          <label class="form-label">Cases Title:</label>
          <input type="text" class="form-control" id="case_title" name="case_title" >
        </div> 

        <div class="mb-4">
          <label class="form-label">Property Address:</label>
          <input type="text" class="form-control" id="property_address" name="property_address" >
        </div>
        
        <div class="mb-4">
          <label class="form-label">Property Type:</label>
          <select class="form-control" id="propertyTypeSelect" name="property_type" onchange="toggleOtherPropertyType()">
            <option value="">-- Select Property Type --</option>
            <option value="Terrace">Terrace</option>
            <option value="Bungalow">Bungalow</option>
            <option value="Condominium">Condominium</option>
            <option value="Others">Others</option>
          </select>

          <div id="otherPropertyTypeDiv" style="display: none; margin-top: 10px;">
            <input type="text" class="form-control" id="otherPropertyType" name="property_type" placeholder="Please specify property type">
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label">Land Size:</label>
          <input type="text" class="form-control" id="land_size" name="land_size" placeholder="80sqft">
        </div> 

        <div class="mb-4">
          <label class="form-label">Purchase Price:</label>
          <input type="text" class="form-control" id="purchase_price" name="purchase_price" placeholder="RM 160,000">
        </div> 

        <div class="mb-4">
          <label class="form-label">Deposit (RM):</label>
          <input type="text" class="form-control" id="deposit_paid" name="deposit_paid" placeholder="RM 30,000">
        </div> 

        <div class="mb-4">
          <label class="form-label">Payment Method:</label>
          <select class="form-control" id="payment_method" name="payment_method">
            <option value="">-- Select Payment Method --</option>
            <option value="Cash">Cash</option>
            <option value="Loan">Loan</option>
          </select>
        </div>


        <div class="mb-4">
          <label class="form-label">Start Date:</label>
          <input type="date" class="form-control" id="startdate" name="startdate" placeholder="eg: 0139928192">
        </div> 

        <div class="mb-4">
          <label class="form-label">Notes:</label>
          <input type="text" class="form-control" id="notes" name="notes">
        </div> 

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Submit Cases</button>
        </div>
        
      </form>

    </div>
  </div>
</div>

<script>
  function toggleOtherPropertyType() {
    var select = document.getElementById("propertyTypeSelect");
    var otherDiv = document.getElementById("otherPropertyTypeDiv");
    var otherInput = document.getElementById("otherPropertyType");

    if (select.value === "Others") {
      otherDiv.style.display = "block";
      otherInput.name = "property_type"; // will be submitted
      select.name = ""; // remove name to avoid duplicate submission
    } else {
      otherDiv.style.display = "none";
      otherInput.name = ""; // prevent submission
      select.name = "property_type"; // use selected value
    }
  }
</script>
@endsection