@extends('template/dashboardHR')
@section('title', 'Document')

@section('section')
            <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Document Information</h2>
                                 </div>
                              </div>
                              <div class="table_section padding_infor_info">
                              <a href="{{ route('form.register.docs') }}" class="btn btn-success">
                                 <i class="fa fa-plus-circle"></i> Add Document Information
                              </a> &nbsp; <br><br>
                                 <ul class="nav nav-tabs" id="documentTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                       <button class="nav-link active" id="agreement-tab" data-bs-toggle="tab" data-bs-target="#agreement" type="button" role="tab">Letter of Agreement</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                       <button class="nav-link" id="handover-tab" data-bs-toggle="tab" data-bs-target="#handover" type="button" role="tab">Asset Hand Over Form</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                       <button class="nav-link" id="nda-tab" data-bs-toggle="tab" data-bs-target="#nda" type="button" role="tab">Non Disclosure Agreement</button>
                                    </li>
                                 </ul>

                                    <div class="tab-content mt-3" id="documentTabsContent">
                                    <div class="tab-pane fade show active" id="agreement" role="tabpanel">
                                       <div class="table-responsive-sm">
                                          <table class="table table-striped">
                                          <a href="{{ route('form.generate.docs.loa') }}" class="btn btn-warning">
                                             <i class="fa fa-pencil"></i> Generate Document
                                          </a> <br><br>
                                          <thead>
                                             <tr>
                                                <th style="color:black; font-size:15px;">Version</th>
                                                <th style="color:black; font-size:15px;">Document Created</th>
                                                <th style="color:black; font-size:15px;">Action</th>
                                             </tr> 
                                          </thead>
                                          <tbody>
                                             @foreach($documents['Letter of Agreement'] ?? [] as $doc)
                                             <tr>
                                                <td style="color:black; font-size:15px;">{{ $doc->version }}</td>
                                                <td style="color:black; font-size:15px;">
                                                   {{ \Carbon\Carbon::parse($doc->updated_at)->format('d M Y g:i a') }}
                                                </td>
                                                <td>
                                                   <a href="{{ asset('storage/' . $doc->file_path) }}" class="btn btn-outline-primary btn-sm" title="View" target="_blank">
                                                      <i class="fa fa-eye blue2_color"></i>
                                                   </a>
                                                   
                                                </td>
                                             </tr>
                                             @endforeach
                                          </tbody>

                                          </table>
                                       </div>
                                       <div class="mt-3">
                                          <span class="badge rounded-pill border border-primary text-primary px-3 py-2 fw-semibold">
                                             Total Documents: {{ $totalDocuments }}
                                          </span>
                                       </div>
                                    </div>

                                    <div class="tab-pane fade" id="handover" role="tabpanel">
                                       <div class="table-responsive-sm">
                                          <table class="table table-striped">
                                          <a href="{{ route('form.generate.docs') }}" class="btn btn-warning">
                                             <i class="fa fa-pencil"></i> Generate Document
                                          </a> <br><br>
                                          <thead>
                                             <tr>
                                                <th style="color:black; font-size:15px;">Version</th>
                                                 <th style="color:black; font-size:15px;">Document Created</th>
                                                <th style="color:black; font-size:15px;">Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @foreach($documents['Asset Hand Over Form'] ?? [] as $doc)
                                             <tr>
                                                <td style="color:black; font-size:15px;">{{ $doc->version }}</td>
                                                <td style="color:black; font-size:15px;">
                                                   {{ \Carbon\Carbon::parse($doc->updated_at)->format('d M Y g:i a') }}
                                                </td>
                                                <td>
                                                   <a href="{{ asset('storage/' . $doc->file_path) }}" class="btn btn-outline-primary btn-sm" title="View" target="_blank">
                                                      <i class="fa fa-eye blue2_color"></i>
                                                   </a>
                                                 
                                                </td>
                                             </tr>
                                             @endforeach
                                          </tbody>
                                          </table>
                                       </div>
                                        <div class="mt-3">
                                          <span class="badge rounded-pill border border-primary text-primary px-3 py-2 fw-semibold">
                                             Total Documents: {{ $totalAhof }}
                                          </span>
                                       </div>
                                    </div>

                                    <div class="tab-pane fade" id="nda" role="tabpanel">
                                       <div class="table-responsive-sm">
                                          <table class="table table-striped">
                                          <a href="{{ route('form.generate.docs.nda') }}" class="btn btn-warning">
                                             <i class="fa fa-pencil"></i> Generate Document
                                          </a> <br><br>
                                          <thead>
                                             <tr>
                                                <th style="color:black; font-size:15px;">Version</th>
                                                <th style="color:black; font-size:15px;">Document Created</th>
                                                <th style="color:black; font-size:15px;">Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @foreach($documents['Non Disclosure Agreement'] ?? [] as $doc)
                                             <tr>
                                                <td style="color:black; font-size:15px;">{{ $doc->version }}</td>
                                                <td style="color:black; font-size:15px;">
                                                   {{ \Carbon\Carbon::parse($doc->updated_at)->format('d M Y g:i a') }}
                                                </td>
                                                <td>
                                                   <a href="{{ asset('storage/' . $doc->file_path) }}" class="btn btn-outline-primary btn-sm" title="View" target="_blank">
                                                      <i class="fa fa-eye blue2_color"></i>
                                                   </a>
                                                 
                                                </td>
                                             </tr>
                                             @endforeach
                                          </tbody>
                                          </table>
                                       </div>
                                        <span class="badge rounded-pill border border-primary text-primary px-3 py-2 fw-semibold">
                                             Total Documents: {{ $totalNda }}
                                        </span> 
                                    </div>
                                 </div>

                              </div>
                           </div>
                        </div>





   <style>
  .nav-tabs .nav-link {
    color: black;
  }

  .nav-tabs .nav-link.active {
    color:rgb(0, 76, 239);
    font-weight: bold;
  }
</style>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection