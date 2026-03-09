@extends('template/dashboardHR')

@section('title', 'HR')
@section('section')

        <div class="row">
                    <div class="col-md-6">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Staff Details</h2>
                                 </div>
                              </div>
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="msg_list_main">
                                          <ul class="msg_list">
                                             <li>
                                                <span>
                                                <span class="name_user">Name: {{ $staff->name }}</span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Email: {{ $staff->email }} </span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Phone Number: +60{{ $staff->phone }}</span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Address {{ $staff->address }}</span>
                                                </span>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Staff Details</h2>
                                 </div>
                              </div>
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="msg_list_main">
                                          <ul class="msg_list">
                                             <li>
                                                <span>
                                                <span class="name_user">IC number: {{ $staff->noIC }}  </span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">position: {{ $staff->roles }} </span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Start Date: {{ $staff->startdate }} </span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Status: {{ $staff->status }} </span>
                                                </span>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                    </div>

                <div class ="row">
                        <div class="col-md-6">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Emergency Contact</h2>
                                 </div>
                              </div>
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="msg_list_main">
                                          <ul class="msg_list">
                                             <li>
                                                <span>
                                                <span class="name_user">Contact Name: {{ $staff->ContactName }}</span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Contact Address: {{ $staff->ContactAddress }}</span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Contact Phone: +60{{ $staff->ContactPhone }}</span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Relationship: {{ $staff->Relationship }}</span>
                                                </span>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Documents</h2>
                                 </div>
                              </div>
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="msg_list_main">
                                          <ul class="msg_list">
                                             <li>
                                                <span class="name_user">Offer Letter:</span>
                                                @if ($staff->loa)
                                                   <a href="{{ asset('storage/' . $staff->loa) }}" class="btn btn-outline-primary btn-sm me-1" target="_blank">
                                                         <i class="fa fa-eye blue2_color" aria-hidden="true"></i>
                                                   </a>
                                                @else
                                                   <span class="text-muted">No file</span>
                                                @endif
                                             </li>
                                             <li>
                                                <span class="name_user">Non Disclosure Agreement:</span>
                                                @if ($staff->nda)
                                                   <a href="{{ asset('storage/' . $staff->nda) }}" class="btn btn-outline-primary btn-sm me-1" target="_blank">
                                                         <i class="fa fa-eye blue2_color" aria-hidden="true"></i>
                                                   </a>
                                                @else
                                                   <span class="text-muted">No file</span>
                                                @endif
                                             </li>
                                             <li>
                                                <span class="name_user">Asset Hand Over Form:</span>
                                                @if ($staff->assetform)
                                                   <a href="{{ asset('storage/' . $staff->assetform) }}" class="btn btn-outline-primary btn-sm me-1" target="_blank">
                                                         <i class="fa fa-eye blue2_color" aria-hidden="true"></i>
                                                   </a>
                                                @else
                                                   <span class="text-muted">No file</span>
                                                @endif
                                             </li>

                                             
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
</div>
@endsection