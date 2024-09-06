<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                 aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                               placeholder="Search for..." aria-label="Search"
                               aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>



        @if(Session::get('user_type') == "admin")
            <li><span class="badge badge-danger" style="margin-top: 25px">Admin</span></li>
        @elseif(Session::get('user_type') == "librarian")
            <li><span class="badge badge-warning" style="margin-top: 25px">Librarian</span></li>
        @elseif(Session::get('user_type') == "student")
            <li><span class="badge badge-success" style="margin-top: 25px">Student</span></li>
        @endif
        {{--                        <li><span class="badge badge-success" style="margin-top: 25px">{{ Session::get('user_type') }}</span></li>--}}
        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">{{$notifCount}}</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Notifications
                </h6>
                <div class="notifications-container" style="max-height: 500px; overflow-y: auto;">
                    {{--OVERDUE NOTIFICATIONS --}}
                    @if($penalty > 0)
                        <a class="dropdown-item d-flex align-items-center bg-danger text-white" href="">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
{{--                                <div class="small text-gray-500">{{$showOverdueNotifications}}</div>--}}
                                <span class="font-weight-bold"> You have 15 pesos penalty please pay it immediately</span>
                            </div>
                        </a>
                    @endif
                    {{--END OF OVERDUE NOTIFICATIONS --}}
    {{--                //USER NOTIFICATIONS--}}
                    @foreach($allUserNotificationInfos as $allUserNotifInfo)
                        <a class="dropdown-item d-flex align-items-center" href="{{$allUserNotifInfo->notif_redirect}}">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{$allUserNotifInfo->date_created}}</div>
                                <span class="font-weight-bold">{{$allUserNotifInfo->notif_title}}</span>
                            </div>
                        </a>
                    @endforeach
    {{--                //ALL NOTIFICATIONS--}}
                    @foreach($allNotificationInfos as $allNotifInfo)
                        <label class="dropdown-item d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{$allNotifInfo->date_created}}</div>
                                <span class="font-weight-bold">{{$allNotifInfo->notif_title}}</span><br>
                                <span>{{$allNotifInfo->notif_message}}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
{{--                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>--}}
            </div>
        </li>



        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Session::get('name') }}</span>
                <img class="img-profile rounded-circle"
                     src="img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
{{--                @include('components/logout')--}}

            </div>
        </li>

    </ul>

</nav>

<!-- End of Topbar -->

