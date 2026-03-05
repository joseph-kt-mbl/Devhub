<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img class="w-[160px]" src="/img/DevhubLogo.png" alt="Devhub Logo">
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <!-- Role Selection -->
            <div class="mt-4">
                <x-label for="role" value="{{ __('Register as') }}" />
                <select id="role" name="role" required class="block mt-1 w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
                    <option value="" disabled selected>{{ __('Select Role') }}</option>
                    <option value="developer" {{ old('role') == 'developer' ? 'selected' : '' }}>Developer</option>
                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                </select>
            </div>

            <!-- Developer Fields -->
            <div id="developer-fields" class="mt-4 space-y-4" style="display:none;">
                <x-label for="title" value="{{ __('Developer Title') }}" />
                <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" placeholder="Full Stack Developer" />

                <x-label for="skills" value="{{ __('Skills (comma separated)') }}" />
                <x-input id="skills" class="block mt-1 w-full" type="text" name="skills" :value="old('skills')" placeholder="Laravel, React, MySQL" />

                <x-label for="hourly_rate" value="{{ __('Hourly Rate ($)') }}" />
                <x-input id="hourly_rate" class="block mt-1 w-full" type="number" step="0.01" name="hourly_rate" :value="old('hourly_rate')" placeholder="25.00" />
                
                <x-label for="bio" value="{{ __('Bio') }}" />
                <x-input id="bio" class="block mt-1 w-full" type="text" name="bio" :value="old('bio')" placeholder="I am a Developer...." />

                <x-label for="experience_years" value="{{ __('experience_years') }}" />
                <x-input id="experience_years" class="block mt-1 w-full" type="number" step="1" name="experience_years" :value="old('experience_years')" placeholder="1" />
                
            </div>

            <!-- Client Fields -->
            <div id="client-fields" class="mt-4 space-y-4" style="display:none;">
                <x-label for="company_name" value="{{ __('Company Name') }}" />
                <x-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" placeholder="My Company" />

                <x-label for="website" value="{{ __('Website') }}" />
                <x-input id="website" class="block mt-1 w-full" type="url" name="website" :value="old('website')" placeholder="https://example.com" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2 text-sm text-gray-600">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline hover:text-gray-900">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>

        <!-- Conditional Rendering Script -->
        <script>
            const roleSelect = document.getElementById('role');
            const devFields = document.getElementById('developer-fields');
            const clientFields = document.getElementById('client-fields');

            function toggleFields() {
                if (roleSelect.value === 'developer') {
                    devFields.style.display = 'block';
                    clientFields.style.display = 'none';
                } else if (roleSelect.value === 'client') {
                    devFields.style.display = 'none';
                    clientFields.style.display = 'block';
                } else {
                    devFields.style.display = 'none';
                    clientFields.style.display = 'none';
                }
            }

            roleSelect.addEventListener('change', toggleFields);

            // Show fields if form is reloaded with old input
            window.addEventListener('load', () => {
                toggleFields();
            });
        </script>
    </x-authentication-card>
</x-guest-layout>