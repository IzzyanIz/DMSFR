@extends('template/dashboardLawyer')

@section('title', 'Client')
@section('section')

        <div class="row">
                    <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Client Details</h2>
                                 </div>
                              </div>
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="msg_list_main">
                                          <ul class="msg_list">
                                             <li>
                                                <span>
                                                <span class="name_user">Name: {{$client->name}} </span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Email: {{$client->email}} </span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Phone Number: +6{{$client->phone}}</span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Address {{$client->address}}</span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user"> Number Identity Card (NRIC): {{$client->ic}} </span>
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

               <div class="row">
               <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="msg_list_main">
                                          <ul class="msg_list">
                                             <li>
                                                <span>
                                                <span class="name_user">Nationality: {{$client->nationality}}</span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Occupation: {{$client->occupation}} </span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user"> Income: RM {{$client->income}} </span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Marital Status: {{$client->marital_status}} </span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">Status: {{$client->status}}</span>
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