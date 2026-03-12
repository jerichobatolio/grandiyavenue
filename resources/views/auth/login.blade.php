<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <div class="mt-1" style="position: relative; width: 100%;">
                    <x-input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="block w-full pr-10"
                    />
                    <button
                        type="button"
                        onclick="togglePasswordVisibility()"
                        aria-label="Toggle password visibility"
                        style="position: absolute; top: 50%; right: 0.75rem; transform: translateY(-50%); background: transparent; border: 0; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer;"
                    >
                        {{-- Eye (show) icon --}}
                        <svg id="password-eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        {{-- Eye off (hide) icon --}}
                        <svg id="password-eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3l18 18M10.477 10.49A3 3 0 0115 12m-3 3a3 3 0 01-2.51-4.523M7.362 7.387C5.403 8.295 3.87 9.82 2.458 12 3.732 16.057 7.523 19 12 19c1.337 0 2.614-.26 3.788-.732M17.94 17.94C19.86 16.948 21.42 15.4 22.542 13.5 21.268 9.443 17.478 6.5 13 6.5c-.69 0-1.366.07-2.02.204" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>

        <script>
            function togglePasswordVisibility() {
                const input = document.getElementById('password');
                const eyeOpen = document.getElementById('password-eye-open');
                const eyeClosed = document.getElementById('password-eye-closed');

                if (!input || !eyeOpen || !eyeClosed) return;

                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';

                if (isPassword) {
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                } else {
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                }
            }
        </script>
    </x-authentication-card>
</x-guest-layout>
