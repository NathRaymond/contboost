<x-guest-layout>
    <div class="row">
        <div class="col-md-12 g-0">
            <div class="form-container">
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div>
                        <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)"
                            placeholder="{{ __('auth.email') }}" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-text-input id="password" type="password" name="password"
                            placeholder="{{ __('auth.password') }}" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                            placeholder="{{ __('auth.confirmPassword') }}" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <div class="d-grid">
                        <x-primary-button>
                            {{ __('auth.resetPassword') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
