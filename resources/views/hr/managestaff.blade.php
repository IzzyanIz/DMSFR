@extends('template/dashboardHR')
@section('title', 'Staff')
@section('section')
            <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Staff information</h2>
                                 </div>
                              </div>

                              <div class="table_section padding_infor_info">
                              <a href="{{ route('form.register.staff') }}" class="btn btn-success">
                                 <i class="fa fa-plus-circle"></i> Add Staff Information
                              </a> <br><br>

                                 <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                       <thead>
                                          <tr>
                                             <th style="color:black; font-size:13px;">Name</th>
                                             <th style="color:black; font-size:13px;">Email</th>
                                             <th style="color:black; font-size:13px;">Number Phone</th>
                                             <th style="color:black; font-size:13px;">Status</th>
                                             <th style="color:black; font-size:13px;">Action</th>

                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($staffs as $staff)
                                             <tr>
                                                <td style="color:black; font-size:13px;">{{ $staff->name }}</td>
                                                <td style="color:black; font-size:13px;">{{ $staff->email }}</td>
                                                <td style="color:black; font-size:13px;">+60-{{ $staff->phone }}</td>
                                                <td>
                                                   @if($staff->status == 'pending')
                                                      <span class="badge rounded-circle" style="background-color: #ffc107; color: #000;">{{ $staff->status }}</span>
                                                   @elseif($staff->status == 'active')
                                                      <span class="badge rounded-circle" style="background-color: #28a745; color: #fff;">{{ $staff->status }}</span>
                                                   @elseif($staff->status == 'inactive')
                                                      <span class="badge rounded-circle" style="background-color: #dc3545; color: #fff;">{{ $staff->status }}</span>
                                                   @endif
                                                </td>
                                                <td style="font-size: 13px;">
                                                
                                                   <a href="{{ route('details.staff', $staff->idStaff)}}" class="btn btn-outline-primary btn-sm me-1" title="View">
                                                      <i class="fa fa-eye blue2_color"></i>
                                                   </a>

                                                   <a href="{{ route('form.update.staff', $staff->idStaff)}}" class="btn btn-outline-warning btn-sm me-1" title="Edit">
                                                      <i class="fa fa-pencil yellow_color"></i>
                                                   </a>

                                                   <form action="{{ route('delete.staff', $staff->idStaff) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this staff information?');">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                            <i class="fa fa-trash red_color"></i>
                                                      </button>
                                                   </form>
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