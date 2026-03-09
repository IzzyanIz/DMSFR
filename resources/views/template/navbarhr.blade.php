<!-- topbar -->
<div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="logo_section">
                        <a href="index.html">SSDU Innovations Sdn Bhd</a>
                        </div>
                        <div class="right_topbar">
                           <div class="icon_info">
                             
                              <a class="dropdown-toggle"
                                 data-toggle="dropdown"
                                 href="#">

                                 <img ...>
                                 <span class="name_user">{{ session('username', 'Guest') }}</span>
                              </a>

                              <ul class="dropdown-menu">
                                 <li>
                                    <a href="{{ route('view.profile.hr') }}">My Profile</a>
                                 </li>
                                 <li>
                                    <a href="{{ route('logout') }}">Logout</a>
                                 </li>
                              </ul>


                           </div>
                        </div>
                     </div>
                  </nav>
               </div>
               <!-- end topbar -->