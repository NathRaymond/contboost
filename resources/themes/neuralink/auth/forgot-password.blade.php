<x-canvas-guest-layout>
    <x-auth-card>
        <x-slot name="text">
            <h1>@lang('auth.dont_have_account')</h1>
            <p>@lang('auth.dont_have_account_desc')</p>
            <a href="{{ route('register') }}" class="btn btn-success">@lang('auth.register')</a>
        </x-slot>
        <x-application-logo class="mb-3" />
        <h1>@lang('auth.forgot_message')</h1>
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('auth.forgot_password_desc') }}
        </div>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="text-start mb-3">
                <x-text-input id="email" type="email" name="email" :value="old('email')" required
                    placeholder="{{ __('auth.email') }}" autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="d-grid gap-2">
                <x-primary-button>
                    {{ __('auth.email_reset_link') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-canvas-guest-layout>
