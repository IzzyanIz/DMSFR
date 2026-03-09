@extends('template/DashboardManager')
@section('title', 'Task')

@section('section')
        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Task information</h2>
                                 </div>
                              </div>

                              <div class="table_section padding_infor_info">
                           

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
                                             <th style="color:black; font-size:15px;">Status</th>
                                             <th style="color:black; font-size:15px;">Action</th>

                                          </tr>
                                       </thead>
                                       <tbody>
                                            @foreach ($tasks as $task)
                                                <tr>
                                                    <td style="color:black; font-size:15px;">{{ $task->lawyer_name }}</td>
                                                    <td style="color:black; font-size:15px;">{{ $task->client_name }}</td>
                                                    <td style="color:black; font-size:15px;">{{ $task->case_title }}</td>
                                                    <td style="color:black; font-size:15px;">{{ $task->title }}</td>
                                                    <td style="color:black; font-size:15px;">{{ $task->description }}</td>
                                                    <td style="color:black; font-size:15px;">{{ $task->duedate }}</td>
                                                    <td style="color:black; font-size:15px;">
                                                        <span class="badge 
                                                            {{ $task->status == 'completed' ? 'bg-success' : ($task->status == 'pending' ? 'bg-warning' : 'bg-secondary') }}">
                                                            {{ ucfirst($task->status ?? 'Pending') }}
                                                        </span>
                                                    </td>
                                                    <td style="font-size: 20px;">
                                                        <a href="{{ route('manager.update.task', $task->idTask) }}" class="btn btn-outline-warning btn-sm me-1" title="Update">
                                                            <i class="fa fa-pencil yellow_color"></i>
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