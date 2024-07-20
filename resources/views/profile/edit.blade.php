<!-- resources/views/profile/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 shadow sm:rounded-lg lg:col-span-1 order-2 lg:order-1">
                <nav class="flex flex-col space-y-4">
                    <a href="{{ route('profile.edit') }}"
                        class="text-gray-700 font-bold text-lg hover:text-teal-500 {{ request()->routeIs('profile.edit') ? 'text-teal-400' : '' }}">{{ __('Akun Saya') }}</a>
                    <a href="{{ route('profile.pesanan') }}"
                        class="text-gray-700 font-bold text-lg hover:text-teal-500 {{ request()->routeIs('profile.pesanan') ? 'text-teal-400' : '' }}">{{ __('Pesanan Saya') }}</a>
                </nav>
            </div>

            <!-- Main Content -->
             <div class="space-y-6 lg:col-span-3 order-1 lg:order-2">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>
