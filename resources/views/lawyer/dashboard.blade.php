@extends('template/dashboardLawyer')
@section('title', 'Dashboard')

@section('section')
<div class="row column1">
                        <div class="col-md-6 col-lg-6">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-briefcase yellow_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                 <p class="head_couter" style="color:black; font-size:11;">Ongoing Cases</p>                                    
                                 <p class="total_no">{{ $totalCases }}</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-6">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-clock-o green_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                 <p class="head_couter" style="color:black; font-size:11;">Upcoming Deadline</p>                                    
                                 <p class="total_no">{{ $totalDeadline }}</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                     </div>
                     
                     <div class="row column2">
                        <!-- Task Card -->
                        <div class="col-md-6">
                           <div class="dash_blog_inner">
                                 <div class="dash_head">
                                    <h3><span><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::now()->format('d F Y') }} </span></h3>
                                 </div>
                                 <div class="list_cont">
                                    <p><b>Pending Tasks</b></p>
                                 </div>
                                 <div class="task_list_main">
                                    <ul class="task_list">
                                       @forelse ($pendingTasks as $task)
                                          <li>
                                                <strong>{{ $task->title }}</strong><br>
                                                <span>{{ $task->description }}</span>
                                          </li>
                                       @empty
                                          <li>No pending tasks.</li>
                                       @endforelse
                                    </ul>
                                    
                                 </div>
                           </div>
                        </div>

                        <!-- Progress Bar Card -->
                        <div class="col-md-6">
                           <div class="white_shd full margin_bottom_30">
                                 <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                       <h2>Progress for client</h2>
                                    </div>
                                 </div>
                                 <div class="full progress_bar_inner">
                                    <div class="progress_bar">
                                       @forelse($clients as $client)
                                             @php
                                                $status = strtolower($client->status);
                                                $colorText = $status === 'completed' ? 'text-success' : ($status === 'discontinue' ? 'text-danger' : 'text-warning');
                                                $barColor = $status === 'completed' ? 'bg-success' : ($status === 'discontinue' ? 'bg-danger' : 'bg-warning');
                                             @endphp

                                             <span class="skill">{{ $client->name }} 
                                                <span class="info_valume {{ $colorText }}">&nbsp; {{ ucfirst($status) }}</span>
                                             </span>
                                             <div class="progress skill-bar">
                                                <div class="progress-bar {{ $barColor }}" role="progressbar" style="width: 100%;"></div>
                                             </div>
                                       @empty
                                             <p>No client data available.</p>
                                       @endforelse
                                    </div>
                                 </div>

                           </div>
                        </div>
                     </div>


                     
@endsection