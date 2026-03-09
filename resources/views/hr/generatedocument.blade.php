@section('section')
@extends('template/dashboardHR')
@section('title', 'Document')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Generate Document</h5>
    <div class="card-body">

     <form action="{{ route('generate.document.process') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="form-label">SELECT DOCUMENT NAME:</label>
            <select class="form-control" name="DocumentName">
                @foreach($documents as $doc)
                    <option value="{{ $doc->DocumentName }}">{{ $doc->DocumentName }} (version{{ $doc->version }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label">Username:</label>
            <select class="form-control" id="username" name="username">
                <option disabled selected>Select Username</option>
                @foreach($users as $user)
                    <option value="{{ $user->username }}"
                            data-name="{{ $user->name }}"
                            data-noIC="{{ $user->noIC }}">
                        {{ $user->username }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" readonly>
        </div>


        <div class="mb-4">
            <label class="form-label">IC Number:</label>
            <input type="text" class="form-control" id="noIC" name="noIC" readonly>
        </div>

        <div id="assetRows">
            <div class="row g-2 mb-2 asset-row">
                <div class="col">
                <input type="text" name="asset[]" class="form-control" placeholder="Asset">
                </div>
                <div class="col">
                <input type="text" name="serialNo[]" class="form-control" placeholder="Serial No">
                </div>
                <div class="col">
                <input type="number" name="qty[]" class="form-control" placeholder="Qty" min="1" value="1">
                </div>
                <div class="col">
                <input type="date" name="dateStart[]" class="form-control">
                </div>
                <div class="col">
                <input type="text" name="remarksItem[]" class="form-control" placeholder="Remarks">
                </div>
                <div class="col-auto">
                <button type="button" class="btn btn-danger removeRowBtn">X</button>
                </div>
            </div>
            </div>

            <button type="button" id="addRowBtn" class="btn btn-outline-primary btn-sm mb-3">
            + Add Asset
            </button>

        <div class="mb-4">
            <label class="form-label">Other Remarks:</label>
            <input type="text" class="form-control" id="otherRemarks" name="otherRemarks">
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Generate Document</button>
        </div>
    </form>


    </div>
  </div>
</div>


<script>
    document.getElementById('username').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        document.getElementById('name').value = selected.getAttribute('data-name');
        document.getElementById('noIC').value = selected.getAttribute('data-noIC');
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const assetRows = document.getElementById("assetRows");
  const addRowBtn = document.getElementById("addRowBtn");

  addRowBtn.addEventListener("click", function () {
    const firstRow = assetRows.querySelector(".asset-row");
    const clone = firstRow.cloneNode(true);

    // clear values
    clone.querySelectorAll("input").forEach(inp => {
      if (inp.type === "number") inp.value = 1;
      else inp.value = "";
    });

    assetRows.appendChild(clone);
  });

  assetRows.addEventListener("click", function (e) {
    if (e.target.classList.contains("removeRowBtn")) {
      const rows = assetRows.querySelectorAll(".asset-row");
      if (rows.length > 1) {
        e.target.closest(".asset-row").remove();
      }
    }
  });
});
</script>



@endsection