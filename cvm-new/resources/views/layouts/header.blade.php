<header>
    <div class="container-fluid">
        <div class="menu__item">
            <div class="logo">
                <a href="#"><img src="{{ asset('images/logo.png') }}" alt="" width="150"></a>
            </div>
            <!-- ./logo -->
            <div class="nav--menu">
                <a href="{{ route('home')}}">Dashboard</a>
                @can('candidate.view')
                    <a href="{{ route('candidate.index')}}">Candidates</a>
                @endcan
                @can('job post.view')
                    <a href="{{ route('job.index') }}">Job Post</a>
                @endcan
                @can('search resumes.view')
                <a href="{{ route('search.index') }}">Search Resumes</a>
                @endcan
                @can('company.view')
                <a href="{{ route('company.index')}}">Company</a>
                @endcan
                <a href="{{ route('business.index')}}">Business Unit</a>
            </div>
            <!-- ./nav--menu -->
            <div class="action--menu">
                <div class="notification">
                    <a href="{{route('notification.index')}}">
                        <img src="{{ asset('images/icons/bell.png')}}" alt="" />
                        <span class="bell-noti"></span>
                    </a>
                </div>
                <div class="dropdown profile_wrap">
                    <button class="dropdown-toggle drawerOpen" type="button">
                        <div class="profile_img">
                            @if (!empty($logo))
                            <img src="{{asset('images/employee')}}/{{$logo}}" alt="" />
                            @else
                            <img src="{{asset('images/userr.png')}}" alt="" />
                            @endif
                        </div>
                        <div class="profile--con">
                            <div class="name">{{ ucwords(Auth::user()->name) }} ({{ ucwords(str_replace('-', ' ', Auth::user()->getRoleNames()->first())) }})
                            </div>
                            <div class="emp">{{ Auth::user()->email}}</div>
                        </div>
                        <!-- ./profile--con -->
                        <svg width="20" class="openmenu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                            <path class="top" d="M0 9h30v2H0z" data-svg-origin="15 10" transform="matrix(1,0,0,1,0,0)"
                                style="translate: none;rotate: none;scale: none;transform-origin: 0px 0px;"></path>
                            <path class="bot" d="M0 19h30v2H0z" data-svg-origin="15 20" transform="matrix(1,0,0,1,0,0)"
                                style="translate: none;rotate: none;scale: none;transform-origin: 0px 0px;"></path>
                        </svg>
                    </button>
                    <!-- ./dropdown-menu -->
                </div>
            </div>
            <!-- ./action--menu -->
        </div>
    </div>
    <!-- ./container -->
</header>

<div class="sidebar-overlay"></div>
<div class="dropSide_menu" id="drawerMenu">
    <div class="btn__close" id="drawerClose">close</div>
    <!-- ./btn__close -->
    <div class="menu__warpper">
        <div class="menu--item">
            @can('reports.view')
            <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel">
                    <div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"
                        data-parent="#accordion" href="#collapseOneSide" aria-expanded="true" aria-controls="collapseOne">
                        <h4 class="panel-title">
                            <img src="{{asset('images/icons/report.png')}}" alt="" />
                            <a role="button">Reports</a>
                        </h4>
                        <img src="{{ asset('images/icons/select-drop.png')}}" class="arrow-drop-sign">
                    </div>
                    <div id="collapseOneSide" class="panel-collapse collapse in" role="tabpanel"
                        aria-labelledby="headingOne">
                        <div class="panel-body">
                            <a class="submenu-items" href="{{ route('report.index')}}">Candidate</a>
                            <a class="submenu-items" href="{{ route('report.candidate-project')}}">Candidate Project</a>
                            {{-- <a class="submenu-items" href="{{ route('employee.report')}}">Employee Project</a> --}}
                        </div>
                    </div>
                </div>
                <!-- end of panel -->
            </div>
            @endcan
        </div>
        @can('employee.view')
        <a class="menu--item" href="{{ route('users.index')}}"><img src="{{ asset('images/icons/report.png')}}"
                alt="" />Employee</a>
        @endcan
        <a class="menu--item" href="{{ route('interview-schedule.index')}}"><img src="{{ asset('images/icons/report.png')}}"
            alt="" />Interviews</a>
        @hasrole(['system-admin', 'super-admin'])
          <a class="menu--item" href="{{ route('role.index')}}"><img src="{{ asset('images/icons/workforce.png')}}" alt="" />Roles & Permission</a>
        @endhasrole
        <a class="menu--item" href="{{ route('users.profile-settings')}}"><img src="{{ asset('images/icons/settings.png')}}" alt="" />Setting</a>
        {{-- <a class="menu--item" href="#"><img src="{{ asset('images/icons/ticket.png')}}" alt="" />Raise Tickets</a> --}}
        <a class="menu--item" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>
</div>


@push('scripts')
<script>
$(function() {
    $("a").on("click", function() {
        $("a.active").removeClass("active");
        $(this).addClass("active");
    });
});
</script>
@endpush
