@section('section')
@extends('template/dashboardHR')
@section('title', 'Document')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Generate Document Letter of Agreement</h5>
    <div class="card-body">

     <form action="{{ route('generate.loa.process') }}" method="POST" enctype="multipart/form-data">
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
                            data-noIC="{{ $user->noIC }}"
                            data-address="{{ $user->address }}"
                            data-roles="{{ $user->roles }}">
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
            <label class="form-label">Address:</label>
            <input type="text" class="form-control" id="address" name="address" readonly>
        </div>

        <div class="mb-4">
            <label for="department" class="form-label">Department</label>
            <select class="form-control" id="department" name="department"   >
                <option value="">-- Select Department --</option>
                <option value="Product Management and Support">Product Management and Support</option>
                <option value="Corporate Communications">Corporate Communications</option>
                <option value="Business Develop and Marketing">Business Develop and Marketing</option>
                <option value="Digital Solutions">Digital Solutions</option>
                <option value="Delivery Management Office">Delivery Management Office</option>
                <option value="Development, Security and Operations">Development, Security and Operations</option>
                <option value="Strategic Planning">Strategic Planning</option>
                <option value="Finance">Finance</option>
                <option value="Human Resource and Administration">Human Resource and Administration</option>
                <option value="Corporate Governance">Corporate Governance</option>
            </select>
        </div>


        <div class="mb-4">
            <label class="form-label">Start of Internship:</label>
            <input type="date" class="form-control" id="startDate" name="startDate">
        </div>

        <div class="mb-4">
            <label class="form-label">End of Internship:</label>
            <input type="date" class="form-control" id="endDate" name="endDate">
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
        document.getElementById('address').value = selected.getAttribute('data-address');
        document.getElementById('roles').value = selected.getAttribute('data-roles');

    });
</script>


@endsection