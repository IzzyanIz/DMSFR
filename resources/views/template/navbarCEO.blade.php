<div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="logo_section">
                        <p>SSDU Innovations Sdn Bhd</p>
                        </div>
                        <div class="right_topbar">
                           <div class="icon_info">
                              <ul class="user_profile_dd">
                                 <li>
                                    <a href="{{ route('ceo.see.profile') }}"
                                       class="dropdown-toggle d-flex align-items-center"
                                       title="View Profile">

                                       <img class="img-responsive rounded-circle me-2"
                                          src="{{ asset('storage/' . Auth::user()->face_image) }}"
                                          alt="Profile" />

                                       <span class="name_user">
                                          {{ session('username', 'Guest') }}
                                       </span>

                                    </a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
               </div>

               <style>
                  .dropdown-toggle::after {
                  display: none !important;
               }
               </style>
