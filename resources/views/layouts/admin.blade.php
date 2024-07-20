<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
        }

        .dropdown-toggle:hover + .dropdown-menu,
        .dropdown-menu:hover {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-toggle:after {
            content: '>';
            float: right;
            margin-left: 10px;
            transition: transform 0.3s ease;
        }

        .dropdown-toggle:hover:after {
            transform: rotate(90deg);
        }

        #sidebar {
            height: 100vh;
            overflow-y: auto;
        }

        .main-content {
            height: 100vh;
            overflow-y: auto;
        }

        @media (min-width: 1024px) {
            #sidebar {
                width: 20rem;
            }
        }

        @media (min-width: 1280px) {
            #sidebar {
                width: 24rem;
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Sidebar -->
    <div class="flex flex-col md:flex-row h-screen">

        <!-- Sidebar -->
        <div id="sidebar" class="bg-teal-400 h-screen w-64 lg:w-80 xl:w-96 md:block hidden overflow-y-auto">
            <div class="p-6">
                <div class="text-white text-3xl font-bold font-Poppins">
                    TAMAN <span class="text-black text-3xl font-bold font-Poppins">PINTAR</span>
                </div>
                <ul class="mt-8">
                    <li class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-500' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="block text-white hover:bg-blue-500 px-6 py-4 text-lg text-poppins"><i class="fa-sharp fa-solid fa-gauge mr-2"></i>
                            Dashboard</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.users.index') ? 'bg-blue-500' : '' }}">
                        <a href="{{ route('admin.users.index') }}" class="block text-white hover:bg-blue-500 px-6 py-4 text-lg text-poppins"><i class="fa-solid fa-users mr-2"></i>Pengguna</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.ticket-categories.index') ? 'bg-blue-500' : '' }}">
                        <a href="{{ route('admin.ticket-categories.index') }}" class="block text-white hover:bg-blue-500 px-6 py-4 text-lg text-poppins"><i class="fa-solid fa-layer-group mr-2"></i>Kategori Tiket</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.tickets.index') ? 'bg-blue-500' : '' }}">
                        <a href="{{ route('admin.tickets.index') }}" class="block text-white hover:bg-blue-500 px-6 py-4 text-lg text-poppins"><i class="fa-solid fa-ticket mr-2"></i>Tiket</a>
                    </li>
                    <li class="md:hidden sm:hidden {{ request()->routeIs('admin.scan') ? 'bg-blue-500' : '' }}">
                        <a href="{{ route('admin.scan') }}" class="block text-white hover:bg-blue-500 px-6 py-4 text-lg text-poppins"><i class="fa-solid fa-qrcode mr-2"></i>Scan Tiket</a>
                    </li>
                    <li class="relative {{ request()->routeIs('admin.reports.*') ? 'bg-blue-500' : '' }}">
                        <a href="#" class="block text-white hover:bg-blue-500 px-6 py-4 text-lg text-poppins dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-chart-waterfall mr-2"></i>Laporan</a>
                        <div class="dropdown-menu absolute hidden bg-teal-400 mt-2 w-full rounded-lg">
                            <a href="{{ route('admin.reports.transactions') }}" class="block text-white hover:bg-blue-500 px-6 py-4 text-lg text-poppins">Laporan Transaksi</a>
                            <a href="{{ route('admin.reports.sales') }}" class="block text-white hover:bg-blue-500 px-6 py-4 text-lg text-poppins">Laporan Penjualan Tiket</a>
                            <a href="{{ route('admin.reports.revenue') }}" class="block text-white hover:bg-blue-500 px-6 py-4 text-lg text-poppins">Laporan Pendapatan</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full h-screen overflow-y-scroll">
            <!-- Navbar -->
            <nav class="bg-white p-4 flex justify-between items-center">
                <div class="flex items-center">
                   <button id="sidebarToggle" class="text-gray-800 mr-4 md:hidden">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h1 class="text-gray-800 text-2xl font-bold">Admin Dashboard</h1>
                </div>
                <!-- Dropdown menu -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48" class="mr-6">
                        <x-slot name="trigger">
                            <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil') }}
                            </x-dropdown-link>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                {{-- <i class="fa-regular fa-bell"></i> --}}
            </nav>

            <!-- Main Content -->
            <div class="container mx-auto mt-4 p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('hidden');
            });
        });
           document.addEventListener('DOMContentLoaded', function () {
            const dropdownToggle = document.querySelector('.dropdown-toggle');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            dropdownToggle.addEventListener('click', function () {
                dropdownMenu.classList.toggle('hidden');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>
