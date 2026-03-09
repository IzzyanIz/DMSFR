@extends('template/dashboardHR')
@section('title', 'Document Approval Request ')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Insert Document Request</h5>
    <div class="card-body">

      <form action="{{ route('document.submitrequest.hr')}}" method="POST" enctype="multipart/form-data">
        @csrf 

        <div class="mb-4">
          <label class="form-label">Document Name:</label>
          <input type="text" class="form-control" id="document_name" name="document_name" placeholder="eg: Asset Hand Over Form">
        </div> 

        <div class="mb-4">
          <label class="form-label">File:</label>
          <input type="file" class="form-control" id="document_path" name="document_path">
        </div> 

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Submit Document</button>
        </div>
        
      </form>

    </div>
  </div>
</div>
@endsection