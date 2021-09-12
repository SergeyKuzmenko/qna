<div class="sidebar">

    @auth()
        <div class="user-panel mt-3 pb-3 mb-3 d-flex d-md-none d-lg-none">
            <div class="image">
                <img src="{{ auth()->user()->profile->avatar }}" class="img-circle elevation-2"
                     alt="{{ auth()->user()->profile->full_name }}">
            </div>
            <div class="info">
                <a href="{{ route('my.profile.show') }}" class="d-block">{{ auth()->user()->profile->full_name }}</a>
            </div>
        </div>
    @endauth

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @auth()
                <li class="nav-item">
                    <a href="{{ route('my.feed') }}"
                       class="nav-link {{ request()->routeIs('my.feed') ? 'active' : '' }}">
                        <i class="nav-icon far fa-list-alt"></i>
                        <p>Моя лента</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('my.questions') }}"
                       class="nav-link {{ request()->routeIs('my.questions') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Мои вопросы</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('my.answers') }}"
                       class="nav-link {{ request()->routeIs('my.answers') ? 'active' : '' }}">
                        <i class="nav-icon far fa-comment-dots"></i>
                        <p>Мои ответы</p>
                    </a>
                </li>
                <li class="nav-item" style="border-bottom: 1px solid #4b545c;">
                    <a href="{{ route('my.tags') }}"
                       class="nav-link {{ request()->routeIs('my.tags') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>Мои теги</p>
                    </a>
                </li>
            @endauth
            <li class="nav-item mt-1">
                <a href="{{ route('feed') }}" class="nav-link {{ request()->routeIs('feed') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-list-ul"></i>
                    <p>Все вопросы</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tags.all') }}" class="nav-link {{ request()->routeIs('tags.all') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tags"></i>
                    <p>Все теги</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.all') }}"
                   class="nav-link {{ request()->routeIs('users.all') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Пользователи</p>
                </a>
            </li>
        </ul>
    </nav>
</div>
