@extends('template/dashboardLawyer')
@section('title', 'Task')

@section('section')
        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>History of task information</h2>
                                 </div>
                              </div>

                              <div class="table_section padding_infor_info">
                              <a href="{{ route('view.task.lawyer') }}" class="btn btn-success">
                                <i class="fa fa-arrow-left"></i> Back
                            </a> <br><br>

                                 <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                       <thead>
                                          <tr>
                                            <th style="color:black; font-size:15px;">Lawyer</th>
                                            <th style="color:black; font-size:15px;">Client</th>
                                            <th style="color:black; font-size:15px;">Cases</th>
                                             <th style="color:black; font-size:15px;">Title</th>
                                             <th style="color:black; font-size:15px;">Description</th>
                                             <th style="color:black; font-size:15px;">Due date</th>
                                             <th style="color:black; font-size:15px;">Updated</th>

                                          </tr>
                                       </thead>
                                       <tbody>
                                            @foreach($tasks as $task)
                                                <tr>
                                                    <td style="color:black; font-size:15px;">{{ $task->lawyer_name }}</td>
                                                    <td style="color:black; font-size:15px;">{{ $task->client_name }}</td>
                                                    <td style="color:black; font-size:15px;">{{ $task->case_title }}</td>
                                                    <td style="color:black; font-size:15px;">{{ $task->title }}</td>
                                                    <td style="color:black; font-size:15px;">{{ $task->description }}</td>
                                                    <td style="color:black; font-size:15px;">{{ \Carbon\Carbon::parse($task->duedate)->format('d M Y') }}</td>
                                                    <td style="color:black; font-size:15px;">{{ \Carbon\Carbon::parse($task->updated_at)->format('d M Y H:i') }}</td>  
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
@endsection