<!-- resources/views/auth/register.blade.php -->
<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <form method="POST" class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
            action="{{ route('register') }}" id="registerForm">
            @csrf
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nama')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Username -->
            <div class="mt-4">
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div>
                <input type="hidden" name="g_recaptcha_response" id="g_recaptcha-response">
                <x-input-error :messages="$errors->get('g_recaptcha_response')" class="mt-2" />
            </div>
            <div class="mt-4">
                <a class="underline text-sm text-gray-600 mt-4 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Sudah Mendaftar?') }}
                </a>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="block" type="submit">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.getElementById('registerForm').addEventListener('submit', function (e) {
                        e.preventDefault();
                        grecaptcha.ready(function() {
                            grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {
                                action: 'register'
                            }).then(function(token) {
                                document.getElementById('g_recaptcha-response').value = token;
                                document.getElementById('registerForm').submit();
                            });
                        });
                    });
                });
            </script>
        @endpush
    </div>
</x-app-layout>
