<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <x-application-auth-logo />
        </x-slot>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <p class="text-medium-emphasis">Sign In to your account</p>
            <div class="input-group mb-3"><span class="input-group-text">
                    <i class="lni lni-envelope"></i>
                </span>
                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')"
                    placeholder="mail@someone.com" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="input-group mb-4"><span class="input-group-text">
                    <i class="lni lni-lock-alt"></i></span>
                <x-text-input id="password" class="form-control" type="password" name="password" required
                    placeholder="password" autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="row">
                <div class="col-6">
                    <x-primary-button class="btn btn-primary px-4">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
                <div class="col-6 text-end">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link px-0" href="{{ route('admin.password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
            </div>

        </form>
    </x-auth-card>
</x-guest-layout>
