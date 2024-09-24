<aside class="side__menu">
    <ul class="metismenu" id="masterMenu" style="display:none;">
        <li class="">
            <a href="javascript:void(0);" aria-expanded="false">
            <span>
                <img src="{{ asset('images/icons/mortarboard.png')}}" alt="">
                Settings
            </span>
            <i class="las la-angle-down"></i></a>
            <ul aria-expanded="false">
                    <li><a href="{{route('users.profile-settings')}}" class="{{ request()->is('profile-settings') ? 'active' : '' }}">Profile Setting</a></li>
                @can('email setting.view')
                    <li><a href="{{route('emailSetting.index')}}" class="{{ request()->is('email-setting') ? 'active' : '' }}">Email Setting</a></li>
                @endcan
                @can('language setting.view')
                    <li><a href="{{route('language-setting.index')}}" class="{{ request()->is('language-setting') ? 'active' : '' }}">Language Setting</a></li>
                @endcan
            </ul>
        </li>
        @if (!empty(Gate::any(['industries.view', 'sectors.view', 'phase.view', 'keyword.view'])))
        <li class="">
            <a href="javascript:void(0);" aria-expanded="false">

            <span>
                <img src="{{ asset('images/analysis.png')}}" alt="">
                core sectors
            </span>
            <i class="las la-angle-down"></i>
            </a>
            <ul aria-expanded="false">
                @can('industries.view')
                    <li><a href="{{ route('industry.index')}}" class="{{ request()->is('industry') ? 'active' : '' }}">Industries</a></li>
                @endcan
                @can('sectors.view')
                    <li><a href="{{ route('sector.index')}}" class="{{ request()->is('sector') ? 'active' : '' }}">Sectors</a></li>
                @endcan
                @can('phase.view')
                    <li><a href="{{ route('phase.index')}}" class="{{ request()->is('phase') ? 'active' : '' }}">Phase</a></li>
                @endcan
                @can('keyword.view')
                    <li><a href="{{ route('keyword.index') }}" class="{{ request()->is('keyword') ? 'active' : '' }}">Keyword</a></li>
                @endcan
            </ul>
        </li>
        @endif
        @if (!empty(Gate::any(['category.view', 'sub category.view', 'job type.view'])))
        <li class="">
            <a href="javascript:void(0);" aria-expanded="false">
            <span>
                <img src="{{ asset('images/icons/mortarboard.png')}}" alt="">
                Job Post
            </span>
            <i class="las la-angle-down"></i></a>
            <ul aria-expanded="false">
            @can('category.view')
                <li><a href="{{route('category.index')}}" class="{{ request()->is('category') ? 'active' : '' }}">Category</a></li>
            @endcan
            @can('sub category.view')
                <li><a href="{{route('sub-category.index')}}" class="{{ request()->is('sub-category') ? 'active' : '' }}">SubCategory</a></li>
            @endcan
            @can('job type.view')
                <li><a href="{{ route('job-type.index') }}" class="{{ request()->is('job-type') ? 'active' : '' }}">Job Type</a></li>
            @endcan
            </ul>
        </li>
        @endif
        @if (!empty(Gate::any(['funded agency.view', 'terrains.view', 'pavement.view'])))
        <li class="">
            <a href="javascript:void(0);" aria-expanded="false">
            <span>
                <img src="{{ asset('images/icons/mortarboard.png')}}" alt="">
                Funded Project
            </span>
            <i class="las la-angle-down"></i></a>
            <ul aria-expanded="false">
            @can('funded agency.view')
                <li><a href="{{route('funding-agency.index')}}" class="{{ request()->is('funding-agency') ? 'active' : '' }}">Funded Agency</a></li>
            @endcan
            @can('terrains.view')
                <li><a href="{{route('terrains.index')}}" class="{{ request()->is('terrains') ? 'active' : '' }}">Terrains</a></li>
            @endcan
            @can('pavement.view')
                <li><a href="{{route('pavement.index')}}" class="{{ request()->is('pavement') ? 'active' : '' }}">Pavement</a></li>
            @endcan
            </ul>
        </li>
        @endif
        @hasrole(['system-admin', 'super-admin'])
            <li class="">
                <a href="javascript:void(0);" aria-expanded="false">
                <span>
                    <img src="{{ asset('images/icons/mortarboard.png')}}" alt="">
                    Company
                </span>
                <i class="las la-angle-down"></i></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('company-setting.index') }}" class="{{ request()->is('company-setting') ? 'active' : '' }}">prefix Setting</a></li>
                    <li><a href="{{ route('company-perk.index') }}" class="{{ request()->is('company-perk') ? 'active' : '' }}">Company Perk</a></li>
                </ul>
            </li>
        @endhasrole
        @if (!empty(Gate::any(['education mode.view', 'university.view', 'subject.view', 'skill.view', 'education.view'])))
        <li class="">
            <a href="javascript:void(0);" aria-expanded="false">
            <span>
                <img src="{{ asset('images/icons/mortarboard.png')}}" alt="">
                Education
            </span>
            <i class="las la-angle-down"></i></a>
            <ul aria-expanded="false">
                @can('education mode.view')
                    <li><a href="{{ route('education-mode.index') }}" class="{{ request()->is('education-mode') ? 'active' : '' }}">Education Mode</a></li>
                @endcan
                @can('university.view')
                    <li><a href="{{ route('university.index') }}" class="{{ request()->is('university') ? 'active' : '' }}">University</a></li>
                @endcan
                @can('subject.view')
                    <li><a href="{{ route('subject.index') }}" class="{{ request()->is('subject') ? 'active' : '' }}">Subject</a></li>
                @endcan
                @can('skill.view')
                    <li><a href="{{ route('skill.index') }}" class="{{ request()->is('skill') ? 'active' : '' }}">Skill</a></li>
                @endcan
                @can('education level.view')
                    <li><a href="{{ route('education.index') }}" class="{{ request()->is('education') ? 'active' : '' }}">Education Level</a></li>
                @endcan
            </ul>
        </li>
        @endif
        @if (!empty(Gate::any(['currency.view', 'designation.view', 'department.view', 'employee type.view'])))
        <li class="">
            <a href="javascript:void(0);" aria-expanded="false">
            <span>
                <img src="{{ asset('images/icons/mortarboard.png')}}" alt="">
                GENERAL
            </span>
            <i class="las la-angle-down"></i></a>
            <ul aria-expanded="false">
            @can('currency.view')
                <li><a href="{{ route('currency.index') }}" class="{{ request()->is('currency') ? 'active' : '' }}">Currency</a></li>
            @endcan
            @can('designation.view')
                <li><a href="{{ route('designation.index') }}" class="{{ request()->is('designation') ? 'active' : '' }}">Designation</a></li>
            @endcan
            @can('department.view')
                <li><a href="{{ route('department.index') }}" class="{{ request()->is('department') ? 'active' : '' }}">Department</a></li>
            @endcan
            @can('employee type.view')
                <li><a href="{{ route('employee-type.index') }}" class="{{ request()->is('employee-type') ? 'active' : '' }}">Employee Type</a></li>
            @endcan
            </ul>
        </li>
        <li class="">
            <a href="javascript:void(0);" aria-expanded="false">
            <span>
                <img src="{{ asset('images/icons/mortarboard.png')}}" alt="">
                Candidate
            </span>
            <i class="las la-angle-down"></i></a>
            <ul aria-expanded="false">
                <li><a href="{{ route('interview-round.index') }}" class="{{ request()->is('interview-round') ? 'active' : '' }}">Interview Round</a></li>
            </ul>
        </li>
        @endif
    </ul>
</aside>

<!-- ./side__menu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    $(".side__menu .metismenu > li").each(function() {
      var $parent = $(this);
      var $activeChild = $parent.find("ul li a.active");
      if ($activeChild.length > 0) {
        var $grandparent = $activeChild.parents().eq(1);
        $grandparent.removeClass('collapse');
        $grandparent.addClass('collapse in');
      }
    });
  });
</script>



