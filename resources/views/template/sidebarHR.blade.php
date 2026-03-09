<!-- Sidebar  -->
<nav id="sidebar">
               <div class="sidebar_blog_1">
                  <div class="sidebar-header">
                     <div class="logo_section">
                     <a href="index.html"><img class="logo_icon img-responsive" src="{{ asset('template/images/logo/logo_icon.png') }}" alt="#" /></a>
                     </div>
                  </div>
                  <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                     <div class="user_img"><img class="img-responsive" src="{{ asset('storage/' . Auth::user()->face_image) }}" alt="#" /></div>
                     <div class="user_info">
                           <h6>{{ session('username', 'Guest') }}</h6>
                           <p><span class="online_animation"></span> Online</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sidebar_blog_2">
                  <ul class="list-unstyled components">
                     <li>
                        <a href="{{ route('view.dashboard.hr') }}"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a>
                     </li> 
                           
                      <li><a href="{{ route('view.list.staff') }}"><i class="fa fa-group orange_color"></i> <span>Staff management</span></a></li>
                      <li><a href="{{ route('view.list.docs') }}"><i class="fa fa-file purple_color"></i> <span>Document management</span></a></li>
                      <li><a href="{{ route('document.status.hr') }}"><i class="fa fa-file yellow_color"></i> <span>Approval Request</span></a></li>                                                              
                      <li><a href="{{ route('view.profile.list.hr') }}"><i class="fa fa-user blue1_color"></i> <span>Profile</span></a></li>
                      <li> 
                           <form method="POST" action="{{ route('logout') }}">
                              @csrf
                              <button type="submit" class="btn" style="background: none; border: none; padding: 60; color: inherit; display: flex; align-items: center; width: 100%;">
                                    <i class="fa fa-sign-out green_color"></i> 
                                    <span style="margin-left: 5px;">Log Out</span>
                              </button>
                           </form>
                        </li>
                      </ul>
               </div>
            </nav>
            <!-- end sidebar -->