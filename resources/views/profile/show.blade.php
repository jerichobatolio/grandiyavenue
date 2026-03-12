<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div id="profile-top">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div id="profile-info">
                    @livewire('profile.update-profile-information-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0" id="profile-password">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0" id="profile-security">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0" id="profile-sessions">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0" id="profile-danger">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hash = window.location.hash || '';
            if (hash === '#edit') {
                const el = document.getElementById('edit-profile-section');
                if (el) { el.scrollIntoView({ behavior: 'smooth' }); }
            }
            if (hash === '#profile-photo') {
                const el = document.getElementById('edit-profile-section');
                if (el) { el.scrollIntoView({ behavior: 'smooth' }); }
                const btn = document.getElementById('profile-photo-trigger');
                if (btn) { setTimeout(() => btn.click(), 350); }
            }
        });
    </script>
</x-app-layout>
