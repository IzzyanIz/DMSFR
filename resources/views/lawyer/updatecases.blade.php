@extends('template/dashboardLawyer')
@section('title', 'Cases')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Update Cases Information</h5>
    <div class="card-body">

    <form action="{{ route('cases.update.lawyer', $case->idCases) }}" method="POST" enctype="multipart/form-data">
    @csrf 
    @method('PUT')
        <div class="mb-4">
        <label class="form-label">Username Lawyer in charge:</label>
        <select class="form-control" name="lawyer_id">
            <option value="">Please select username</option>
            @foreach($lawyers as $lawyer)
                <option value="{{ $lawyer->id }}" 
                    {{ old('lawyer_id', $case->lawyer_id) == $lawyer->id ? 'selected' : '' }}>
                    {{ $lawyer->username }}
                </option>
            @endforeach
        </select>
        </div>

        <div class="mb-4">
            <label class="form-label">Client:</label>
            <select class="form-control" name="client_id">
                <option value="">Please select client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->idClient }}"
                        {{ old('client_id', $case->client_id) == $client->idClient ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="mb-4">
          <label class="form-label">Cases Title:</label>
          <input type="text" class="form-control" id="case_title" name="case_title"  value="{{ old('case_title', $case->case_title) }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Property Address:</label>
          <input type="text" class="form-control" id="property_address" name="property_address" value="{{ old('property_address', $case->property_address) }}">
        </div>
        
        <div class="mb-4">
        <label class="form-label">Property Type:</label>
        <select class="form-control" id="propertyTypeSelect" name="property_type_select" onchange="toggleOtherPropertyType()">
            <option value="">-- Select Property Type --</option>
            <option value="Terrace" {{ old('property_type', $case->property_type) == 'Terrace' ? 'selected' : '' }}>Terrace</option>
            <option value="Bungalow" {{ old('property_type', $case->property_type) == 'Bungalow' ? 'selected' : '' }}>Bungalow</option>
            <option value="Condominium" {{ old('property_type', $case->property_type) == 'Condominium' ? 'selected' : '' }}>Condominium</option>
            <option value="Others" {{ !in_array(old('property_type', $case->property_type), ['Terrace', 'Bungalow', 'Condominium']) ? 'selected' : '' }}>Others</option>
        </select>

        <div id="otherPropertyTypeDiv" style="display: none; margin-top: 10px;">
            <input 
            type="text" 
            class="form-control" 
            id="otherPropertyType" 
            name="property_type" 
            value="{{ !in_array(old('property_type', $case->property_type), ['Terrace', 'Bungalow', 'Condominium']) ? old('property_type', $case->property_type) : '' }}">
        </div>
        </div>


        <div class="mb-4">
          <label class="form-label">Land Size:</label>
          <input type="text" class="form-control" id="land_size" name="land_size" value="{{ old('land_size', $case->land_size) }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Purchase Price:</label>
          <input type="text" class="form-control" id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $case->purchase_price) }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">Deposit (RM):</label>
          <input type="text" class="form-control" id="deposit_paid" name="deposit_paid" value="{{ old('deposit_paid', $case->deposit_paid) }}" >
        </div> 

        <div class="mb-4">
          <label class="form-label">Payment Method:</label>
          <select class="form-control" id="payment_method" name="payment_method">
            <option value="">-- Select Payment Method --</option>
            <option value="Cash" {{ old('payment_method', $case->payment_method) == 'Cash' ? 'selected' : '' }}>Cash</option>
            <option value="Loan" {{ old('payment_method', $case->payment_method) == 'Loan' ? 'selected' : '' }}>Loan</option>
          </select>
        </div>


        <div class="mb-4">
          <label class="form-label">Start Date:</label>
          <input type="date" class="form-control" id="startdate" name="startdate" value="{{ old('startdate', $case->startdate) }}">
        </div> 

        <div class="mb-4">
          <label class="form-label">End Date:</label>
          <input type="date" class="form-control" id="enddate" name="enddate">
        </div> 


        <div class="mb-4">
          <label class="form-label">Documents:</label>
          <div id="document-container">
            <input type="file" class="form-control mb-2" name="document_path[]">
          </div>
          <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addDocument()">+ Add another document</button>
        </div>


        <div class="mb-4">
          <label class="form-label">Notes:</label>
          <input type="text" class="form-control" id="notes" name="notes" value="{{ old('notes', $case->notes) }}">
        </div> 

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Update Cases</button>
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

<script>
  let documentCount = 1;

  function addDocument() {
    if (documentCount < 3) {
      documentCount++;
      const container = document.getElementById('document-container');
      const input = document.createElement('input');
      input.type = 'file';
      input.name = 'document_path[]';
      input.className = 'form-control mb-2';
      container.appendChild(input);
    } else {
      alert('You can only upload a maximum of 3 documents.');
    }
  }
</script>

@endsection