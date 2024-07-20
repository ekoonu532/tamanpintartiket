<x-app-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">





        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h1 class="text-xl font-bold item-center leading-tight tracking-tight text-gray-900 md:text-2xl mb-2">
                Masuk ke Akun Anda
            </h1>
            <div class="w-full flex justify-center mt-4 mx-2">

                <a href="/auth/google/redirect"
                    class="text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2">
                    <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 18 19">
                        <path fill-rule="evenodd"
                            d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z"
                            clip-rule="evenodd" />
                    </svg>
                    Sign in with Google
                </a>
            </div>
            <div class="my-4 flex items-center">
                <div class="border-t border-gray-300 flex-grow"></div>
                <span class="mx-4 text-gray-500">atau</span>
                <div class="border-t border-gray-300 flex-grow"></div>
            </div>
            <form method="POST" class="" action="{{ route('login') }}">

                @csrf

                <!-- Email/Username -->
                <div>
                    <x-input-label for="input_type" :value="__('Email/Username')" />
                    <x-text-input id="input_type" class="block mt-1 w-full" type="text" name="input_type"
                        :value="old('input_type')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Kata Sandi')" />

                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>





                <div class="block mt-4 flex flex-col">
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-blue-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('password.request') }}">
                                {{ __('lupa Kata Sandi?') }}
                            </a>
                        @endif
                    </div>
                </div>

                <x-primary-button
                    class="block w-full mt-2 mb-3 text-center rounded bg-teal-400 p-4 text-md font-medium text-white transition hover:scale-105">
                    {{ __('Log in') }}
                </x-primary-button>
                <p class="text-sm font-light mt-2 text-gray-500 dark:text-gray-400">
                    Belum punya akun?
                    <a href="{{ route('register') }}"
                        class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                        :active="request() - > routeIs('register')">
                        daftar
                    </a>
                </p>

            </form>
        </div>
    </div>

</x-app-layout>
