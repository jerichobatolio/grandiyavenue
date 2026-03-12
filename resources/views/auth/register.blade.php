<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-label for="name" value="{{ __('First Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="given-name" />
                </div>
                <div>
                    <x-label for="last_name" value="{{ __('Last Name') }}" />
                    <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" autocomplete="family-name" />
                </div>
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="phone" value="{{ __('Phone') }}" />
                <x-input
                    id="phone"
                    class="block mt-1 w-full"
                    type="tel"
                    name="phone"
                    :value="old('phone')"
                    required
                    autocomplete="tel"
                    maxlength="11"
                    pattern="\d{11}"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);"
                />
            </div>

            <div class="mt-4">
                <x-label for="address" value="{{ __('Address') }}" />
                <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autocomplete="address" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <div class="mt-1" style="position: relative; width: 100%;">
                    <x-input
                        id="password"
                        class="block w-full"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        style="padding-right: 2.5rem;"
                    />
                    <button
                        type="button"
                        onclick="toggleRegisterPasswordVisibility('password', 'register-password-eye-open', 'register-password-eye-closed')"
                        aria-label="Toggle password visibility"
                        style="position: absolute; top: 50%; right: 0.75rem; transform: translateY(-50%); background: transparent; border: 0; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer;"
                    >
                        {{-- Eye (show) icon --}}
                        <svg id="register-password-eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        {{-- Eye off (hide) icon --}}
                        <svg id="register-password-eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3l18 18M10.477 10.49A3 3 0 0115 12m-3 3a3 3 0 01-2.51-4.523M7.362 7.387C5.403 8.295 3.87 9.82 2.458 12 3.732 16.057 7.523 19 12 19c1.337 0 2.614-.26 3.788-.732M17.94 17.94C19.86 16.948 21.42 15.4 22.542 13.5 21.268 9.443 17.478 6.5 13 6.5c-.69 0-1.366.07-2.02.204" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <div class="mt-1" style="position: relative; width: 100%;">
                    <x-input
                        id="password_confirmation"
                        class="block w-full"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        style="padding-right: 2.5rem;"
                    />
                    <button
                        type="button"
                        onclick="toggleRegisterPasswordVisibility('password_confirmation', 'register-confirm-eye-open', 'register-confirm-eye-closed')"
                        aria-label="Toggle confirm password visibility"
                        style="position: absolute; top: 50%; right: 0.75rem; transform: translateY(-50%); background: transparent; border: 0; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer;"
                    >
                        {{-- Eye (show) icon --}}
                        <svg id="register-confirm-eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        {{-- Eye off (hide) icon --}}
                        <svg id="register-confirm-eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3l18 18M10.477 10.49A3 3 0 0115 12m-3 3a3 3 0 01-2.51-4.523M7.362 7.387C5.403 8.295 3.87 9.82 2.458 12 3.732 16.057 7.523 19 12 19c1.337 0 2.614-.26 3.788-.732M17.94 17.94C19.86 16.948 21.42 15.4 22.542 13.5 21.268 9.443 17.478 6.5 13 6.5c-.69 0-1.366.07-2.02.204" />
                        </svg>
                    </button>
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>

        <script>
            function toggleRegisterPasswordVisibility(inputId, eyeOpenId, eyeClosedId) {
                const input = document.getElementById(inputId);
                const eyeOpen = document.getElementById(eyeOpenId);
                const eyeClosed = document.getElementById(eyeClosedId);

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
