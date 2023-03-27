<x-front-layout>
    <x-auth-card>
        <div class="text-center mb-4">
            <h3>@lang('auth.registerAccount')</h3>
            <p class="text-muted">@lang('auth.registerAccountDesc')</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <x-input-label>@lang('auth.name')</x-input-label>
                <x-text-input id="name" type="text" name="name"
                    placeholder="{{ __('auth.name') }}" required autofocus />
                <x-input-error :messages="$errors->get('name')" />
            </div>
            <div class="mb-3">
                <x-input-label>@lang('auth.username')</x-input-label>
                <x-text-input id="username" type="text" name="username" placeholder="{{ __('auth.username') }}"
                     required />
                <x-input-error :messages="$errors->get('username')" />
            </div>
            <div class="mb-3">
                <x-input-label>@lang('auth.email')</x-input-label>
                <x-text-input id="email" type="email" name="email" placeholder="{{ __('auth.email') }}"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" />
            </div>
            <div class="mb-3">
                <x-input-label>@lang('auth.password')</x-input-label>
                <x-text-input id="password" type="password" name="password" placeholder="{{ __('auth.password') }}"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" />
            </div>
            <div class="mb-3">
                <x-input-label>@lang('auth.confirmPassword')</x-input-label>
                <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                    placeholder="{{ __('auth.confirmPassword') }}" required />
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-check">
                <label class="form-check-label" for="remember-check">{{ __('Remember me') }}</label>
                <!-- forgot password -->
                <div class="float-end">
                    <a href="{{ route('password.request') }}" class="text-muted">{{ __('Forgot your password?') }}</a>
                </div>
            </div>
            <div class="text-center mt-4">
                <x-primary-button>
                    {{ __('auth.register') }}
                </x-primary-button>
            </div>
            <x-application-social-auth />
        </form>
        <div class="mt-5 text-center text-muted">
            <p>@lang('auth.alreadyAccount') <a href="{{ route('login') }}" class="fw-medium text-decoration-underline"> @lang('auth.login')</a>
            </p>
        </div>
    </x-auth-card>

</x-front-layout>
