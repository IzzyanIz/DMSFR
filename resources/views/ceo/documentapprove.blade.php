@extends('template/dashboardCEO')
@section('title', 'Document Approval Status')
@section('section')
            <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Document information</h2>
                                 </div>
                              </div>

                              <div class="table_section padding_infor_info">
                                 <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                       <thead>
                                          <tr>
                                             <th style="color:black; font-size:15px;">#</th>
                                             <th style="color:black; font-size:15px;">Document Name</th>
                                             <th>Document Created</th>
                                             <th>Document Updated</th>
                                             <th style="color:black; font-size:15px;">Status</th>
                                             <th style="color:black; font-size:15px;">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                        @foreach($docsapproval as $docs)
                                        <tr>
                                            <td style="color:black; font-size:15px;">{{ $loop->iteration }}</td>
                                            <td style="color:black; font-size:15px;">
                                                {{ $docs->document_name }}
                                            </td>
                                             <td style="color:black; font-size:15px;">
                                                {{ \Carbon\Carbon::parse($docs->created_at)->format('d M Y g:i a') }}
                                            </td>
                                            <td style="color:black; font-size:15px;">
                                                {{ \Carbon\Carbon::parse($docs->updated_at)->format('d M Y g:i a') }}
                                            </td>
                                            
                                            <td>
                                                @if($docs->status == 'accepted' || $docs->status == 'approved')
                                                    <span class="badge" style="background-color: #28a745; color: #fff;">Accepted</span>
                                                @elseif($docs->status == 'pending')
                                                    <span class="badge" style="background-color: #ffc107; color: #000;">Pending</span>
                                                @elseif($docs->status == 'rejected')
                                                    <span class="badge" style="background-color: #dc3545; color: #fff;">Rejected</span>
                                                @else
                                                    <span class="badge" style="background-color: #6c757d; color: #fff;">Unknown</span>
                                                @endif
                                            </td>
                                            <td style="font-size: 18px; white-space: nowrap;">
                                            {{-- VIEW DOCUMENT --}}
                                            @if($docs->document_path)
                                                <a href="{{ asset('storage/' . $docs->document_path) }}"
                                                    target="_blank"
                                                    class="btn btn-outline-primary btn-sm me-1"
                                                    title="View Document">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endif
                                            {{-- UPDATE DOCUMENT --}}
                                            <a href="{{ route('ceo.update.document', $docs->id) }}"
                                                class="btn btn-outline-warning btn-sm"
                                                title="Update">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                    </table>
                                 </div>
                                 <div class="mt-3 d-flex flex-wrap gap-2">
                                    <span class="badge rounded-pill border border-success text-success px-3 py-2 fw-semibold">
                                        Accepted Document: {{ $totalAccepted }} 
                                    </span> &nbsp; &nbsp;

                                    <span class="badge rounded-pill border border-warning text-warning px-3 py-2 fw-semibold">
                                        Pending Document: {{ $totalPending }}
                                    </span>  &nbsp; &nbsp;

                                    <span class="badge rounded-pill border border-danger text-danger px-3 py-2 fw-semibold">
                                        Rejected Document: {{ $totalRejected }}
                                    </span>
                                    </div>
                                     <div class="mt-3">
                                          <span class="badge rounded-pill border border-primary text-primary px-3 py-2 fw-semibold">
                                             Total Documents: {{ $totalDocuments }}
                                          </span>
                                    </div>
                              </div>
                           </div>
                        </div>



@endsection