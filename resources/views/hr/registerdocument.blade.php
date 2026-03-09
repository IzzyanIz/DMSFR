@extends('template/dashboardHR')
@section('title', 'Document')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Insert Document Information</h5>
    <div class="card-body">
    <p>Example of Document</p>
    <div class="text-center mb-4">
      <img src="{{ asset('CONTOH_DOKUMEN.png') }}" alt="Asset Hand Over Form" class="img-fluid" style="max-height: 400px;">
    </div>


      <form action="{{ route('register.docs.process') }}" method="POST" enctype="multipart/form-data">
        @csrf 

        <div class="mb-4">
          <label class="form-label">Document Name:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="eg: Asset Hand Over Form">
        </div> 

        <div class="mb-4">
          <label class="form-label">File:</label>
          <input type="file" class="form-control" id="file_path" name="file_path">
        </div> 

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Submit Document</button>
        </div>
        
      </form>

    </div>
  </div>
</div>
@endsection