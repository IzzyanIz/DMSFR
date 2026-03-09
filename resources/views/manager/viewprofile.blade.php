@extends('template/DashboardManager')

@section('title', 'Manager')
@section('section')

        <div class="row">
                    <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Account Information</h2>
                                 </div>
                                 &nbsp; &nbsp; 
                                 <a href="{{ route('register.profile.manager') }}"  class="btn btn-warning">
                                 <i class="fa fa-pencil"></i> Edit Information 
                              </a>   &nbsp; &nbsp; 
                              <a href="{{ route('edit.account.manager') }}"  class="btn btn-warning">
                                 <i class="fa fa-pencil"></i> Edit Account 
                              </a> 
                              </div>
                              
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="msg_list_main">
                                          <ul class="msg_list">
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

                           </div>
                        </div>
                        
                    </div>

            
@endsection