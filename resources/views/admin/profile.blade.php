@extends('template/dashboardAdmin')

@section('title', 'Admin')
@section('section')

        <div class="row">
                    <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Account Information</h2>
                                 </div>
                                 &nbsp; &nbsp; 
                                 <a href="{{ route('admin.edit.profile') }}"  class="btn btn-warning">
                                 <i class="fa fa-pencil"></i> Edit Profile 
                              </a>  
                        
                              </div>
                              
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="msg_list_main">
                                          <ul class="msg_list">
                                             <li>
                                                <span>
                                                    <span class="name_user">Username: {{ Auth::user()->username }}</span>
                                                </span>
                                            </li>
                                            <li>
                                                <span>
                                                    <span class="name_user">Name: {{ Auth::user()->name }}</span>
                                                </span>
                                            </li>
                                            <li>
                                                <span>
                                                    <span class="name_user">Email: {{ Auth::user()->email }}</span>
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