<nav id="sidebar">
    <ul>
        @if (Auth::user())
            @if (isCompanyUser())
                <li class="active"><a href="/{{ Request::route('company')->stub }}"><i class="fas fa-home"></i><span>{{ __('Home') }}</span></a></li>
                <li class="active"><a href="{{ route('company-manage-users', [ Request::route('company')->stub]) }}"><i class="fas fa-users"></i><span>{{ __('Manage users') }}</span></a></li>
                <li class="active"><a href="{{ route('company-credentials', [ Request::route('company')->stub]) }}"><i class="fas fa-key"></i><span>Manage credentials</span></a></li>
            @else
                <li class="active"><a href="/companies"><i class="fas fa-building"></i><span>Organisations</span></a></li>
                @can('register-user')
                    <li class="active"><a href="/sales-admins"><i class="fas fa-users"></i><span>Sales admin users</span></a></li>
                @endcan
            @endif
        @endif
    </ul>
</nav>