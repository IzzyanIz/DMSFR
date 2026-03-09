@extends('template/dashboardHR')
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
                              <a href="{{ route('document.request.hr') }}" class="btn btn-success">
                                 <i class="fa fa-plus-circle"></i> Add Document Request
                              </a> <br><br>

                                 <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                       <thead>
                                          <tr>
                                             <th style="color:black; font-size:15px;">#</th>
                                             <th style="color:black; font-size:15px;">Document Name</th>
                                             <th style="color:black; font-size:15px;">Date Uploaded</th>
                                             <th style="color:black; font-size:15px;">Date Updated</th>
                                             <th style="color:black; font-size:15px;">Status</th>
                                             <th style="color:black; font-size:15px;">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       @forelse ($documents as $index => $document)
                                          <tr>
                                                <td style="color:black; font-size:15px;">{{ $index + 1 }}</td>
                                                <td style="color:black; font-size:15px;">{{ $document->document_name }}</td>
                                                <td style="color:black; font-size:15px;">
                                                   {{ \Carbon\Carbon::parse($document->created_at)->format('d M Y g:i a') }}
                                                </td>
                                                <td style="color:black; font-size:15px;">
                                                   {{ \Carbon\Carbon::parse($document->updated_at)->format('d M Y g:i a')}}
                                                </td>
                                                <td>
                                                   @if ($document->status == 'pending')
                                                      <span class="badge rounded-pill bg-warning text-dark">Pending</span>
                                                   @elseif ($document->status == 'accepted')
                                                      <span class="badge rounded-pill bg-success text-white">Accepted</span>
                                                   @elseif ($document->status == 'rejected')
                                                      <span class="badge rounded-pill bg-danger text-white">Rejected</span>
                                                   @else
                                                      <span class="badge rounded-pill bg-secondary">Unknown</span>
                                                   @endif
                                                </td>
                                                <td style="font-size: 18px; white-space: nowrap;">
                                                   {{-- VIEW DOCUMENT --}}
                                                   @if($document->document_path)
                                                      <a href="{{ asset('storage/' . $document->document_path) }}" 
                                                         target="_blank"
                                                         class="btn btn-primary btn-sm me-1"
                                                         title="View Document">
                                                         <i class="fa fa-eye"></i>
                                                      </a>
                                                   @endif

                                                   {{-- DELETE DOCUMENT --}}
                                                   <form action="{{ route('delete.document.approval.hr', $document->id) }}" 
                                                         method="POST" 
                                                         style="display:inline-block;" 
                                                         onsubmit="return confirm('Are you sure you want to delete this document request?');">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                         <i class="fa fa-trash"></i>
                                                      </button>
                                                   </form>
                                                </td>
                                          </tr>
                                       @empty
                                          <tr>
                                                <td colspan="5" class="text-center" style="color:black; font-size:15px;">
                                                   No documents request.
                                                </td>
                                          </tr>
                                       @endforelse
                                    </tbody>
                                    </table>
                                 </div>
                                 <div class="mt-3 d-flex flex-wrap gap-2">
                                    <span class="badge rounded-pill border border-success text-success px-3 py-2">
                                       Accepted Document: {{ $totalAccepted }}
                                    </span> &nbsp;&nbsp;

                                    <span class="badge rounded-pill border border-warning text-warning px-3 py-2">
                                       Pending Document: {{ $totalPending }}
                                    </span> &nbsp;&nbsp;

                                    <span class="badge rounded-pill border border-danger text-danger px-3 py-2">
                                       Rejected Document: {{ $totalRejected }}
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>



@endsection