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

        <div class="mb-4 text-sm text-gray-600">
            Enter the 6-digit OTP sent to your email to activate your account before login.
        </div>

        <form method="POST" action="{{ route('otp.verify.submit') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$email" required />
            </div>

            <div class="mt-4">
                <x-label for="otp" value="{{ __('OTP Code') }}" />
                <x-input id="otp" class="block mt-1 w-full" type="text" name="otp" maxlength="6" pattern="\d{6}" required />
            </div>

            <div class="flex items-center justify-between mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('login') }}">
                    {{ __('Back to login') }}
                </a>

                <x-button>
                    {{ __('Verify OTP') }}
                </x-button>
            </div>
        </form>

        <form method="POST" action="{{ route('otp.verify.resend') }}" class="mt-4">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <x-button type="submit" class="w-full justify-center">
                {{ __('Resend OTP') }}
            </x-button>
        </form>
    </x-authentication-card>
</x-guest-layout>
