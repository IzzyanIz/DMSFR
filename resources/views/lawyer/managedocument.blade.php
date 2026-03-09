@extends('template/dashboardLawyer')
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
                              <a href="{{ route('register.doc.lawyer')}}" class="btn btn-success">
                                 <i class="fa fa-plus-circle"></i> Add Document Information
                              </a> <br><br>
                                 <ul class="nav nav-tabs" id="documentTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                       <button class="nav-link active" id="agreement-tab" data-bs-toggle="tab" data-bs-target="#spa" type="button" role="tab">Sales Purchase Agreement (SPA)</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                       <button class="nav-link" id="handover-tab" data-bs-toggle="tab" data-bs-target="#loan" type="button" role="tab">Loan Agreement</button>
                                    </li>
                                   
                                 </ul>

                                    <div class="tab-content mt-3" id="documentTabsContent">
                                    <div class="tab-pane fade show active" id="spa" role="tabpanel">
                                       <div class="table-responsive-sm">
                                          <table class="table table-striped">
                                          <a href="{{ route('generate.doc.lawyer')}}"  class="btn btn-warning">
                                             <i class="fa fa-download"></i> Generate Document
                                          </a> <br><br>
                                          <thead>
                                             <tr>
                                                <th style="color:black; font-size:15px;">Version</th>
                                                <th style="color:black; font-size:15px;">Action</th>
                                             </tr> 
                                          </thead>
                                          <tbody>
                                          @foreach($documents['Sales and Purchase Agreement'] ?? [] as $doc)
                                             <tr>
                                                <td style="color:black; font-size:15px;"> {{ $doc->version }}</td>
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
                                    </div>

                                    <div class="tab-pane fade" id="loan" role="tabpanel">
                                       <div class="table-responsive-sm">
                                          <table class="table table-striped">
                                          <a href="{{ route('generate.loan.agreement')}}"  class="btn btn-warning">
                                             <i class="fa fa-download"></i> Generate Document
                                          </a> <br><br>
                                          <thead>
                                             <tr>
                                                <th style="color:black; font-size:15px;">Version</th>
                                                <th style="color:black; font-size:15px;">Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($documents['Loan Agreement'] ?? [] as $doc)
                                             <tr>
                                                <td style="color:black; font-size:15px;">{{ $doc->version }}</td>
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
