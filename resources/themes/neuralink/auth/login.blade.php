<x-front-layout>
    <x-auth-card>
        <div class="text-center mb-4">
            <h3>@lang('auth.welcome_back')</h3>
            <p class="text-muted">@lang('auth.welcome_back_desc')</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <x-input-label>@lang('auth.email')</x-input-label>
                <x-text-input id="email" type="email" name="email" :value="old('email')" required
                    placeholder="{{ __('auth.email') }}" autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="mb-3">
                <x-input-label>@lang('auth.password')</x-input-label>
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="{{ __('auth.password') }}" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
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
                    {{ __('auth.login') }}
                </x-primary-button>
            </div>
            <x-application-social-auth />
        </form>
        <div class="mt-5 text-center text-muted">
            <p>@lang('auth.regsterNotAcount') <a href="{{ route('register') }}" class="fw-medium text-decoration-underline"> @lang('auth.register')</a>
            </p>
        </div>
    </x-auth-card>

</x-front-layout>
