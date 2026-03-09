@extends('template/dashboardLawyer')
@section('title', 'Cases')

@section('section')

<div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Cases information</h2>
                                 </div>
                              </div>

                              <div class="table_section padding_infor_info">
                              <a href="{{ route('register.cases.form')}}"  class="btn btn-success">
                                 <i class="fa fa-plus-circle"></i> Add Cases 
                              </a> <br><br>

                                 <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                       <thead>
                                          <tr>
                                             <th style="color:black; font-size:15px;">Cases Name</th>
                                             <th style="color:black; font-size:15px;">Cases Type</th>
                                             <th style="color:black; font-size:15px;">Cases Status</th>
                                             <th style="color:black; font-size:15px;">Action</th>

                                          </tr>
                                       </thead>
                                       <tbody>
                                             @foreach ($cases as $case)
                                             <tr>
                                                <td style="color:black; font-size:15px;">{{ $case->case_title }}</td>
                                                <td style="color:black; font-size:15px;">{{ $case->case_type }}</td>
                                                <td style="color:black; font-size:15px;">
                                                   {{ $case->case_status ?? 'Pending' }}
                                                </td>
                                                <td style="font-size: 20px;">
                                                <a href="{{ route('details.cases.lawyer', $case->idCases) }}" class="btn btn-outline-primary btn-sm me-1" title="View">
                                                   <i class="fa fa-eye blue2_color"></i>
                                                </a>


                                                   <a href="{{ route('form.update.cases.lawyer', $case->idCases)}}" class="btn btn-outline-warning btn-sm me-1" title="Edit">
                                                         <i class="fa fa-pencil yellow_color"></i>
                                                   </a>

                                                   <form action="{{ route('lawyer.delete.cases', $case->idCases) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this case information?');">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                         <i class="fa fa-trash red_color"></i>
                                                      </button>
                                                   </form>

                                                   <a href="{{ route('add.task.lawyer', $case->idCases)}}" class="btn btn-outline-success btn-sm me-1" title="Add Task">
                                                         <i class="fa fa-plus-circle green_color"></i> Add Task
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