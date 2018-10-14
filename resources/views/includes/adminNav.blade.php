<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile" style="background: url({{asset('assets/images/background/user-info.jpg') }}) no-repeat;">
            <!-- User profile image -->
            <div class="profile-img"> <img src="{{asset('assets/images/users/profile.png') }}" alt="user" /> </div>
            <!-- User profile text-->
            <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{Auth::user()->name}}</a>
            <div class="dropdown-menu animated flipInY"> <a href="#" class="dropdown-item"><i class="ti-user"></i> My Profile</a> <a href="#" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a> <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
            <div class="dropdown-divider"></div> <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a> </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                {{--/////Second Start--}}
                <li class="nav-small-cap">PERSONAL</li>
                <li> <a class="" href="{{route('admin.dashboard')}}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-laptop-windows"></i><span class="hide-menu">Hiring</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('applicants')}}">Application</a></li>
                        <li><a href="{{route('jobs')}}">Jobs</a></li>
                    </ul>
                </li>
                {{--<li> <a class="" href="{{route('users')}}" aria-expanded="false"><i class="mdi mdi-account-circle"></i><span class="hide-menu">Users</span></a>--}}
                {{--</li>--}}
                <li> <a class="" href="{{ route('documents.upload') }}" aria-expanded="false"><i class="mdi mdi-file"></i><span class="hide-menu">Documents</span></a>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">People Managemenr</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('employees')}}">Employees</a></li>
                        <li><a href="">Organisation Hierarchy</a></li>

                    </ul>
                </li>

                <li> <a class=" waves-effect waves-dark" href="{{route('timeline')}}" aria-expanded="false"  ><i class="mdi mdi-trending-up"></i><span class="hide-menu">TimeLine</span></a>
                </li>


                <li> <a class="has-arrow waves-effect waves-dark" href="{{route('attendance')}}"><i class="mdi mdi-alarm-check"></i><span class="hide-menu">Attendance</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('leaves')}}">Leave</a></li>
                        <li><a href="{{route('salary.show')}}">Salary</a></li>
                        <?php
                        $month = date('m');
                        $monthee= "2018_".$month;
                        ?>
                        <li><a href="{{route('attendance.sheet',['id'=>$monthee])}}">Sheet</a></li>
                    </ul>
                </li>
                <li> <a class="" href="#" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">Settings</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('offices')}}">Offices</a></li>
                    </ul>
                </li>

                <li> <a class="" href="#" aria-expanded="false"><i class="mdi mdi-apps"></i><span class="hide-menu">Manage Roles</span></a>
                </li>
                <li> <a class="" href="#" aria-expanded="false"><i class="mdi mdi-help-circle"></i><span class="hide-menu">Help</span></a>
                </li>

                {{--///////// Second End--}}

                {{--/////--}}
                {{--<li class="nav-small-cap">PERSONAL</li>--}}
                {{--<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a>--}}
                    {{--<ul aria-expanded="false" class="collapse">--}}
                        {{--<li><a href="index.html"></a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-laptop-windows"></i><span class="hide-menu">Template Demos</span></a>--}}
                    {{--<ul aria-expanded="false" class="collapse">--}}
                        {{--<li><a href="../minisidebar/index.html">Minisidebar</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Apps</span></a>--}}
                    {{--<ul aria-expanded="false" class="collapse">--}}
                        {{--<li><a href="app-calendar.html">Calendar</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-email"></i><span class="hide-menu">Inbox</span></a>--}}
                    {{--<ul aria-expanded="false" class="collapse">--}}
                        {{--<li><a href="app-email.html">Mailbox</a></li>--}}

                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu">Ui Elements</span></a>--}}
                    {{--<ul aria-expanded="false" class="collapse">--}}
                        {{--<li><a href="ui-cards.html">Cards</a></li>--}}

                    {{--</ul>--}}
                {{--</li>--}}

                {{--First Part End--}}


                {{--<li class="nav-devider"></li>--}}
                {{--<li class="nav-small-cap">FORMS, TABLE &amp; WIDGETS</li>--}}
                {{--<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-file"></i><span class="hide-menu">Forms</span></a>--}}
                    {{--<ul aria-expanded="false" class="collapse">--}}
                        {{--<li><a href="form-basic.html">Basic Forms</a></li>--}}


                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-table"></i><span class="hide-menu">Tables</span></a>--}}
                    {{--<ul aria-expanded="false" class="collapse">--}}
                        {{--<li><a href="table-basic.html">Basic Tables</a></li>--}}


                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-widgets"></i><span class="hide-menu">Widgets</span></a>--}}
                    {{--<ul aria-expanded="false" class="collapse">--}}
                        {{--<li><a href="widget-apps.html">Widget Apps</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li class="nav-devider"></li>--}}
                {{--<li class="nav-small-cap">EXTRA COMPONENTS</li>--}}
                {{--<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-book-multiple"></i><span class="hide-menu">Page Layout</span></a>--}}
                    {{--<ul aria-expanded="false" class="collapse">--}}
                        {{--<li><a href="layout-single-column.html">1 Column</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-arrange-send-backward"></i><span class="hide-menu">Multi level dd</span></a>--}}
                    {{--<ul aria-expanded="false" class="collapse">--}}
                        {{--<li><a href="#">item 1.1</a></li>--}}
                        {{--<li><a href="#">item 1.2</a></li>--}}
                        {{--<li> <a class="has-arrow" href="#" aria-expanded="false">Menu 1.3</a>--}}
                            {{--<ul aria-expanded="false" class="collapse">--}}
                                {{--<li><a href="#">item 1.3.1</a></li>--}}
                                {{--<li><a href="#">item 1.3.2</a></li>--}}
                                {{--<li><a href="#">item 1.3.3</a></li>--}}
                                {{--<li><a href="#">item 1.3.4</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li><a href="#">item 1.4</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <!-- item--><a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
        <!-- item--><a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
        <!-- item--><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a> </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
    <!-- End Bottom points-->
</aside>