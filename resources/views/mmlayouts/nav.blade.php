            <div class="top-nav">
                <button type="button" id="sidebarCollapse" class="navbar-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="logo">
                    <img src="/images/mps-logo.svg">
                </div>
                <div class="title">
                    @if (isCompanyUser())
                        <h1>{{ session('company')->name }}</h1>
                    @else
                        <h1>My Possible Self</h1>
                    @endif
                </div>
                <div class="icons">
                    <ul>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fas fa-user" title="{{ Auth::user()->email }}"></i>
                            </a>
                            <ul class="dropdown-menu">
                            @guest
                                <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            @else
                            <a class="dropdown-item" href="{{ route('changePassword') }}">{{ __('Change Password') }}</a>
                        @if (isCompanyUser())
                            <a class="dropdown-item" href="{{ route('company-account-admins', [session('company')->stub]) }}">{{ __('Account admins') }}</a>
                        @endif
                                @if (! isCompanyUser())
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout').submit();">
                                            {{ __('Logout') }}
                                    </a>
                                    <form id="logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <a class="dropdown-item" href="{{ route('company-logout', [session('company')->stub]) }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout').submit();">
                                            {{ __('Logout') }}
                                    </a>
                                    <form id="logout" action="{{ route('company-logout', [session('company')->stub]) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @endif

                            </ul>
                        </li>
                         @endguest
                    </ul>
                </div>
            </div>