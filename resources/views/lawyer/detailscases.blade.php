@extends('template/dashboardLawyer')

@section('title', 'Cases')
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
                                                    <span><span class="name_user">Lawyer: {{ $case->lawyer_name }}</span></span>
                                                </li>
                                                <li>
                                                    <span><span class="name_user">Client: {{ $case->client_name }}</span></span>
                                                </li>
                                                <li>
                                                    <span><span class="name_user">Case Title: {{ $case->case_title }}</span></span>
                                                </li>
                                                <li>
                                                    <span><span class="name_user">Property Address: {{ $case->property_address }}</span></span>
                                                </li>
                                                <li>
                                                    <span><span class="name_user">Land Size: {{ $case->land_size }}</span></span>
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
                                                <span><span class="name_user">Purchase Price: RM {{ $case->purchase_price }}</span></span>
                                            </li>
                                            <li>
                                                <span><span class="name_user">Deposit: RM {{ $case->deposit_paid }}</span></span>
                                            </li>
                                            <li>
                                                <span><span class="name_user">Payment Method: {{ $case->payment_method }}</span></span>
                                            </li>
                                            <li>
                                                <span><span class="name_user">Start Date: {{ \Carbon\Carbon::parse($case->startdate)->format('d M Y') }}</span></span>
                                            </li>
                                            <li>
                                                <span><span class="name_user">Notes: {{ $case->notes }}</span></span>
                                            </li>
                                            <li>
                                                <span><span class="name_user">Documents:</span></span>
                                                <ul>
                                                    @php
                                                        $documents = json_decode($case->document_paths, true);
                                                    @endphp
                                                    @if($documents && count($documents) > 0)
                                                        @foreach($documents as $index => $doc)
                                                            <li>
                                                                <a href="{{ asset('storage/' . $doc) }}" target="_blank">
                                                                    <i class="fa fa-download"></i> {{ $index + 1 }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li>No documents uploaded.</li>
                                                    @endif
                                                </ul>
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