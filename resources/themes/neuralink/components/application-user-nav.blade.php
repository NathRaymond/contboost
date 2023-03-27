@props([
    'user' => auth()->user(),
])
@auth
    <div class="header-right-option dropdown profile-nav-item pt-0 pb-0">
        <a class="dropdown-item dropdown-toggle avatar d-flex align-items-center" href="#" id="navbarDropdown-4"
            role="button" data-bs-toggle="dropdown" aria-expanded="false">
            @if (Auth::user()->getFirstMediaUrl('avatar'))
                <img src="{{ Auth::user()->getFirstMediaUrl('avatar') }}" alt="{{ $user->name }}">
            @else
                <img src="{{ setting('default_user_image') }}" alt="{{ $user->name }}">
            @endif
            <div class="d-none d-lg-block d-md-block">
                <h3>{{ $user->name }}</h3>
                <span>{{ $user->roles->first()->name ?? '' }}</span>
            </div>
        </a>
        <div class="dropdown-menu"
            style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 50px);"
            data-popper-placement="bottom-end">
            <div class="dropdown-header d-flex flex-column align-items-center">
                <div class="figure mb-3">
                    @if (Auth::user()->getFirstMediaUrl('avatar'))
                        <img src="{{ Auth::user()->getFirstMediaUrl('avatar') }}" class="rounded-circle"
                            alt="{{ $user->name }}">
                    @else
                        <img src="{{ setting('default_user_image') }}" class="rounded-circle" alt="{{ $user->name }}">
                    @endif
                </div>
                <div class="info text-center">
                    <span class="name text-primary">{{ $user->name }}</span>
                    <p class="mb-3 email">
                        {{ $user->email }}
                    </p>
                </div>
            </div>
            <div class="dropdown-wrap">
                <ul class="profile-nav p-0 pt-3">
                    <li class="nav-item">
                        <a class="nav-link" role="button" href="{{ route('document.index') }}">
                            <i class="an an-files-alt"></i>
                            <span>{{ __('document.documents') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="button" href="{{ route('user.profile') }}">
                            <i class="an an-user"></i>
                            <span>{{ __('profile.profile') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="button" href="{{ route('user.password') }}">
                            <i class="an an-write"></i>
                            <span>{{ __('common.changePassword') }}</span>
                        </a>
                    </li>
                    <li class="nav-item {{ active(['user.twofactor'], 'active-link', 'user-profile') }}">
                        <a class="nav-link" href="{{ route('user.twofactor') }}">
                            <i class="an an-cog-alt"></i>
                            <span>@lang('profile.2faDescription')</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="dropdown-footer">
                <form id="logout-form" class="d-none" action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                </form>
                <ul class="profile-nav">
                    <li class="nav-item">
                        <a class="nav-link signoutBtn" role="button" href="{{ route('admin.logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="an an-lock"></i>
                            <span>{{ __('auth.signout') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endauth
