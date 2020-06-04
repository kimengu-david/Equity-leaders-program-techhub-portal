<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>techhub Dashboard</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="/css/app.css">


    <script type='text/javascript'>
    function opportunities() {
        Swal.fire("<b style='color:red' >Action not allowed!</b>",
            "Available only for registered members. pay your registration fee of ksh.500. Payments are made directly to the treasurer.",
            "warning");
    }
    </script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand bg-dark navbar-light border-bottom">
            <ul class="nav-bar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link ml-auto" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>

                </li>
            </ul>

            <!-- SEARCH FORM -->
            <!--<form action="#" class="form-inline ">-->

             @if($user->can('isAdmin')||$user->can('isMediaController')||$user->can('isTreasurer')||$user->can('isSecreatary')||$user->can('isProjectLead'))
            <div class="input-group input-group-sm col-5 ">
                <input class=" form-control form-control-navbar" @keyup="searchit" v-model='search' type="search"
                    placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" @click="searchit">
                        <i class="fa fa-search blue"></i>

                    </button>
                </div>
            </div>
            @endcan
            <!--</form>-->

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav ml-auto">


                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell fa-lg"></i>
                            <sup><span class="badge badge-warning"
                                    style="font-size:7px">{{$totalnotifications}}</span></sup>
                        </a>
                        <ul class="dropdown-menu">


                            <li class="header">You have {{$totalnotifications}} notifications</li>



                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    @if ($totalnotifications >0)
                                    @if ($projects >0)


                                    <li>


                                        <i class="fas fa-project-diagram blue"></i>
                                        There are currently <b style="color:red">{{$projects}} project(s) </b>under
                                        development.
                                        Be sure to join one of the developer teams
                                        under the news and opportunities section

                                    </li>
                                    @endif
                                    @if ($meetups >0)
                                    <li>

                                        <i class="fab fa-meetup green"></i>
                                        <b style="color:red"> {{$meetups}} New meetup(S)</b> have been posted
                                        Register today under the news and oppoturnities section.

                                    </li>
                                    @endif
                                    @else
                                    <li>

                                        <i class="fab fa-creative-commons-zero red"></i>
                                        <b>You don't have any notifications yet.</b>

                                    </li>
                                    @endif
                                </ul>
                            </li>

                        </ul>
                    </li>
                    <!-- Tasks: style can be found in dropdown.less -->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-flag fa-lg"></i>
                            <sup> <span class="badge badge-danger"
                                    style="font-size:7px">{{$mytotalprojects}}</span></sup>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have {{$mytotalprojects}} tasks to complete</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    @foreach($myprojects as $project)
                                    <li>
                                        <!-- Task item -->



                                        <b>
                                            Project {{$project->projects_id}} is still
                                            under development
                                            <p>You are part of this project developers team<p>

                                        </b>

                                        <i> Check my project section for more details</i>



                                    </li>
                                    @endforeach


                                </ul>
                            </li>

                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
            </div>



        </nav>

        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link pt-5">
                <img src="https://davikani.s3.eu-west-3.amazonaws.com/images/logo/logo.png" alt="techhub logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Techhub</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../images/profile/{{Auth()->user()->image}}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{Auth()->user()->username}}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <router-link to="/dashboard" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt blue"></i>
                                <p>
                                    Dashboard

                                </p>
                            </router-link>
                        </li>


                        <li class="nav-item">
                            @if(!empty($user->userledger->balance)and ($user->userledger->balance>=500))
                            <router-link to="/news" class="nav-link ">

                                <i class="nav icon fas fa-rss-square cyan"></i>

                                <p>
                                    News & opportunities

                                </p>
                            </router-link>
                            @else
                            <a href="#" onclick="opportunities()" class="nav-link">

                                <i class="nav icon fas fa-rss-square cyan"></i>

                                <p>
                                    News & opportunities

                                </p>
                            </a>
                            @endif
                        </li>
                    
-->
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-cog green"></i>
                                <p>
                                    Manage
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">


                                <li class="nav-item">
                                    <router-link to="/mytwallet" class="nav-link">
                                        <i class="nav icon fas fa-funnel-dollar yellow"></i>

                                        <p>
                                            My Twallet

                                        </p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/userProjects" class="nav-link">
                                        <i class="fas fa-project-diagram blue"></i>

                                        <p>
                                            Projects

                                        </p>
                                    </router-link>

                                </li>


                        </li>
                        @if($user->can('isAdmin')||$user->can('isMediaController')||$user->can('isTreasurer')||$user->can('isSecreatary')||$user->can('isProjectLead'))
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tools  blue"></i>
                                <p>
                                    Administration
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                @if($user->can('isAdmin')||$user->can('isMediaController')||$user->can('isTreasurer')||$user->can('isSecreatary')||$user->can('isProjectLead'))

                                <li class="nav-item">
                                    <router-link to="/users" class="nav-link ">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>Members</p>
                                    </router-link>
                                </li>
                                @endif
                                @if($user->can('isMediaController')||$user->can('isAdmin'))
                                <li class="nav-item">
                                    <router-link to="/post" class="nav-link">
                                        <i class="fas fa-camera nav-icon"></i>
                                        <p>Group posts</p>
                                        </a>
                                </li>
                                @endif
                                @if($user->can('isTreasurer')||$user->can('isAdmin'))
                                <li class="nav-item">
                                    <router-link to="/twallet" class="nav-link">
                                        <i class="nav icon fas fa-funnel-dollar"></i>

                                        <p>
                                            Techhub wallet

                                        </p>
                                    </router-link>
                                </li>
                                @endif

                                @if($user->can('isSecreatary')||$user->can('isAdmin'))
                                <li class="nav-item">
                                    <router-link to="/meetup" class="nav-link">
                                        <i class="nav icon fab fa-meetup"></i>

                                        <p>
                                            Meetups

                                        </p>
                                    </router-link>
                                    @endif
                                </li>
                                @if($user->can('isProjectLead')||$user->can('isAdmin'))
                                <li class="nav-item">
                                    <router-link to="/projects" class="nav-link">
                                        <i class="nav icon fab fa-meetup"></i>

                                        <p>
                                            Projects

                                        </p>
                                    </router-link>

                                </li>
                                @endif

                            </ul>

                        </li>
                        @endif

                        <li class="nav-item">
                            <router-link to="/profile" class="nav-link ">
                                <i class="nav-icon fas fa-user orange"></i>
                                <p>My Profile</p>
                            </router-link>
                        </li>
                        <li class="nav-item">

                            <a class="nav-link" href="{{'logout'}}">

                                <i class="nav-icon fas fa-power-off red"></i>
                                <p>
                                    Logout
                                </P>
                            </a>



                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">


            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <router-view></router-view>
                    <!--The vuejs progress bar-->
                    <vue-progress-bar></vue-progress-bar>
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->



            <!-- Main Footer -->

        </div>
        <!-- ./wrapper -->
    </div>
    <footer class="main-footer text-center blue ">
        <!-- To the right -->

        <!-- Default to the left -->

        <strong>Copyright &copy; 2020 david mutune</a>.</strong> All
        rights
        reserved.
    </footer>
    <script src="/js/app.js"></script>
</body>

</html>