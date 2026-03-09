@extends('template/dashboardCEO')
@section('title', 'Client')

@section('section')
            <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Client information</h2>
                                 </div>
                              </div>

                              <div class="table_section padding_infor_info">
                            

                                 <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                       <thead>
                                          <tr>
                                             <th style="color:black; font-size:15px;">Name</th>
                                             <th style="color:black; font-size:15px;">Email</th>
                                             <th style="color:black; font-size:15px;">Number Phone</th>
                                             <th style="color:black; font-size:15px;">Action</th>

                                          </tr>
                                       </thead>
                                       <tbody>
                                            @foreach($clients as $client)
                                                <tr>
                                                    <td style="color:black; font-size:15px;">{{ $client->name }}</td>
                                                    <td style="color:black; font-size:15px;">{{ $client->email }}</td>
                                                    <td style="color:black; font-size:15px;">{{ $client->phone }}</td>
                                                    <td style="font-size: 20px;">
                                                        
                                                        <a href="{{ route('ceo.details.client', $client->idClient)}}" class="btn btn-outline-primary btn-sm me-1" title="View">
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
@endsection