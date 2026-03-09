@extends('template/dashboardLawyer')

@section('title', 'Lawyer')
@section('section')

        <div class="row">
                    <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Account Information</h2>
                                 </div>
                                 &nbsp; &nbsp; 
                                 <a href="{{ route('view.profile.lawyer') }}"  class="btn btn-warning">
                                 <i class="fa fa-pencil"></i> Edit Information 
                              </a>   &nbsp; &nbsp; 
                              <a href="{{ route('edit.account.lawyer') }}"  class="btn btn-warning">
                                 <i class="fa fa-pencil"></i> Edit Account 
                              </a> 
                              </div>
                              
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="msg_list_main">
                                          <ul class="msg_list">
                                        @if ($userData && $userData->noIC)
                                             <li>
                                                <span>
                                                    <span class="name_user">Username: {{ $userData->username }}</span>
                                                </span>
                                            </li>
                                            <li>
                                                <span>
                                                    <span class="name_user">Name: {{ $userData->name }}</span>
                                                </span>
                                            </li>
                                            <li>
                                                <span>
                                                    <span class="name_user">noIC: {{ $userData->noIC }}</span>
                                                </span>
                                            </li>
                                            <li>
                                                <span>
                                                    <span class="name_user">Phone: {{ $userData->phone }}</span>
                                                </span>
                                            </li>
                                             <li>
                                                <span>
                                                    <span class="name_user">Address: {{ $userData->address }}</span>
                                                </span>
                                            </li>
                                           
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="msg_list_main">
                                          <ul class="msg_list">
                                             <li>
                                                <span class="name_user">Letter of Agreement:</span>
                                                @if ($userData->loa)
                                                   <a href="{{ asset('storage/' . $userData->loa) }}" class="btn btn-outline-primary btn-sm me-1" target="_blank">
                                                         <i class="fa fa-eye blue2_color" aria-hidden="true"></i>
                                                   </a>
                                                @else
                                                   <span class="text-muted">No file</span>
                                                @endif
                                             </li>
                                             <li>
                                                <span class="name_user">Non Disclosure Agreement:</span>
                                                @if ($userData->nda)
                                                   <a href="{{ asset('storage/' . $userData->nda) }}" class="btn btn-outline-primary btn-sm me-1" target="_blank">
                                                         <i class="fa fa-eye blue2_color" aria-hidden="true"></i>
                                                   </a>
                                                @else
                                                   <span class="text-muted">No file</span>
                                                @endif
                                             </li>
                                             <li>
                                                <span class="name_user">Asset Hand Over Form:</span>
                                                @if ($userData->assetform)
                                                   <a href="{{ asset('storage/' . $userData->assetform) }}" class="btn btn-outline-primary btn-sm me-1" target="_blank">
                                                         <i class="fa fa-eye blue2_color" aria-hidden="true"></i>
                                                   </a>
                                                @else
                                                   <span class="text-muted">No file</span>
                                                @endif
                                             </li>
                                            
                                             @else
                                                <li>
                                                    <span class="text-danger">Please register your information. Click on button "Edit Information"</span>
                                                </li>
                                            @endif
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                           </div>
                        </div>
                        
                    </div>

            
@endsection