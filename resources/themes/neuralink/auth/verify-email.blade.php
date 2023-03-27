<x-front-layout>
      <x-auth-card>
    <div class="row">
        <div class="col-md-12 g-0">
            <div class="form-container">
                <p>{{ __('auth.verifyEmailFirst') }}</p>
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 bold">
                        {{ __('auth.newCodeSent') }}
                    </div>
                @endif
                <div class="mt-4 d-flex flex-items-center justify-content-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <div class="d-grid">
                            <x-primary-button>
                                {{ __('auth.resendEmail') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            {{ __('auth.signout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-auth-card>
</x-front-layout>
