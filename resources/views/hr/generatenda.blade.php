@section('section')
@extends('template/dashboardHR')
@section('title', 'Document')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Generate Document Letter of Agreement</h5>
    <div class="card-body">

     <form action="{{ route('generate.nda.process') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="form-label">SELECT DOCUMENT NAME:</label>
            <select class="form-control" name="DocumentName">
                @foreach($documents as $doc)
                    <option value="{{ $doc->DocumentName }}">{{ $doc->DocumentName }} (version {{ $doc->version }})</option>
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

        <div class="mb-4">
            <label class="form-label">Started Date:</label>
            <input type="date" class="form-control" id="dateStart" name="dateStart">
        </div>

        <div class="mb-4">
            <label class="form-label">Remarks:</label>
            <input type="text" class="form-control" id="remarks" name="remarks">
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


@endsection