<nav class="main-header navbar navbar-expand navbar-light {{ (session('dark_mode')) ? 'navbar-dark' : '' }}" @click="toggleSidebar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <span class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></span>
        </li>
    </ul>
    <a href="{{ url('/') }}" class="navbar-brand d-flex d-md-none d-lg-none">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Поиск..."
                               aria-label="Поиск">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link dark-mode-toggle"
               href="{{ route('dark-side') }}"
               role="button" data-toggle="tooltip" data-placement="bottom" title="Тёмная тема">
                <i class="far fa-moon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('question.new') }}" role="button" data-toggle="tooltip"
               data-placement="bottom" title="Новый вопрос">
                <i class="fas fa-plus"></i>
            </a>
        </li>
        @auth()
{{--            <li class="nav-item dropdown">--}}
{{--                <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                    <i class="far fa-comments"></i>--}}
{{--                    <span class="badge badge-danger navbar-badge">3</span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <!-- Message Start -->--}}
{{--                        <div class="media">--}}
{{--                            <img src="{{ asset('img/default.jpg') }}" alt="User Avatar"--}}
{{--                                 class="img-size-50 mr-3 img-circle">--}}
{{--                            <div class="media-body">--}}
{{--                                <h3 class="dropdown-item-title">--}}
{{--                                    Brad Diesel--}}
{{--                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>--}}
{{--                                </h3>--}}
{{--                                <p class="text-sm">Call me whenever you can...</p>--}}
{{--                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- Message End -->--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <!-- Message Start -->--}}
{{--                        <div class="media">--}}
{{--                            <img src="{{ asset('img/user8-128x128.jpg') }}" alt="User Avatar"--}}
{{--                                 class="img-size-50 img-circle mr-3">--}}
{{--                            <div class="media-body">--}}
{{--                                <h3 class="dropdown-item-title">--}}
{{--                                    John Pierce--}}
{{--                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>--}}
{{--                                </h3>--}}
{{--                                <p class="text-sm">I got your message bro</p>--}}
{{--                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- Message End -->--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <!-- Message Start -->--}}
{{--                        <div class="media">--}}
{{--                            <img src="{{ asset('img/user3-128x128.jpg') }}" alt="User Avatar"--}}
{{--                                 class="img-size-50 img-circle mr-3">--}}
{{--                            <div class="media-body">--}}
{{--                                <h3 class="dropdown-item-title">--}}
{{--                                    Nora Silvester--}}
{{--                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>--}}
{{--                                </h3>--}}
{{--                                <p class="text-sm">The subject goes here</p>--}}
{{--                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- Message End -->--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>--}}
{{--                </div>--}}
{{--            </li>--}}
{{--            <!-- Notifications Dropdown Menu -->--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                    <i class="far fa-bell"></i>--}}
{{--                    <span class="badge badge-warning navbar-badge">15</span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
{{--                    <span class="dropdown-item dropdown-header">15 Notifications</span>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-envelope mr-2"></i> 4 new messages--}}
{{--                        <span class="float-right text-muted text-sm">3 mins</span>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-users mr-2"></i> 8 friend requests--}}
{{--                        <span class="float-right text-muted text-sm">12 hours</span>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-file mr-2"></i> 3 new reports--}}
{{--                        <span class="float-right text-muted text-sm">2 days</span>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
{{--                </div>--}}
{{--            </li>--}}

            <li class="nav-item dropdown user-menu d-none d-md-inline">
                <a href="{{ Auth::user()->profile->link }}" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ Auth::user()->profile->avatar }}" class="user-image img-circle elevation-2"
                         alt="User Image">
                    <span class="d-none d-md-inline">{{ Auth::user()->profile->full_name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-gradient-primary">
                        <img src="{{ Auth::user()->profile->avatar }}" class="img-circle elevation-2"
                             alt="{{ Auth::user()->profile->username }}">

                        <p>
                            {{ Auth::user()->profile->full_name }}
                            <small>{{ Auth::user()->email }}</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="{{ route('my.profile.show') }}" class="btn btn-primary btn-flat">Профиль</a>
                        <a href="{{ route('logout') }}" class="btn btn-danger btn-flat float-right">Выход</a>
                    </li>
                </ul>
            </li>
        @endauth
    <!-- / Messages Dropdown Menu -->

        @guest()
            <li class="nav-item user-menu d-none d-md-inline">
                <a href="{{ route('login') }}" class="nav-link dropdown-toggle">
                    <img src="{{ asset('img/guest-avatar.svg') }}" class="user-image img-circle elevation-2"
                         alt="User Image">
                    <span class="d-none d-md-inline">Войти</span>
                </a>
            </li>
        @endguest
    </ul>
</nav>
