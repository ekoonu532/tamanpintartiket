<!-- resources/views/harga-tiket.blade.php -->
<x-app-layout>
    <x-slot name="title">
        Harga Tiket
    </x-slot>
    <div class="min-h-screen py-16 flex items-center justify-center bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8 mt-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-3xl text-center font-bold mb-8">Daftar Harga Tiket per Kategori</h1>
                <div class="flex flex-wrap -mx-4">
                    <!-- Kolom Kategori Wahana -->
                    <div class="w-full md:w-1/2 px-4 mb-6">
                        <h2 class="text-2xl font-semibold mb-4">Wahana</h2>
                        <div class="bg-teal-50 p-6 rounded-lg transition duration-300 ease-in-out hover:shadow-lg">
                            @if ($kategoriWahana && $kategoriWahana->tikets)
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="border-b border-gray-200">
                                            <th class="pb-2">Nama</th>
                                            <th class="pb-2">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kategoriWahana->tikets as $tiket)
                                            <tr class="border-b border-gray-200">
                                                <td class="py-2 font-medium">{{ $tiket->nama }}</td>
                                                <td class="py-2">
                                                    @if ($tiket->harga_anak > 0 && $tiket->harga_dewasa > 0)
                                                        Tiket Anak: Rp {{ number_format($tiket->harga_anak, 0, ',', '.') }}<br>
                                                        Tiket Dewasa: Rp {{ number_format($tiket->harga_dewasa, 0, ',', '.') }}
                                                    @elseif ($tiket->harga_anak > 0)
                                                        Harga: Rp {{ number_format($tiket->harga_anak, 0, ',', '.') }}
                                                    @elseif ($tiket->harga_dewasa > 0)
                                                        Harga: Rp {{ number_format($tiket->harga_dewasa, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-gray-700">Tidak ada tiket untuk kategori ini.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Kolom Kategori Program Kreativitas -->
                    <div class="w-full md:w-1/2 px-4 mb-6">
                        <h2 class="text-2xl font-semibold mb-4">Program Kreativitas</h2>
                        <div class="bg-teal-50 p-6 rounded-lg transition duration-300 ease-in-out hover:shadow-lg">
                            @if ($kategoriKreativitas && $kategoriKreativitas->tikets)
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="border-b border-gray-200">
                                            <th class="pb-2">Nama</th>
                                            <th class="pb-2">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kategoriKreativitas->tikets as $tiket)
                                            <tr class="border-b border-gray-200">
                                                <td class="py-2 font-medium">{{ $tiket->nama }}</td>
                                                <td class="py-2">
                                                    @if ($tiket->harga_anak > 0 && $tiket->harga_dewasa > 0)
                                                        Tiket Anak: Rp {{ number_format($tiket->harga_anak, 0, ',', '.') }}<br>
                                                        Tiket Dewasa: Rp {{ number_format($tiket->harga_dewasa, 0, ',', '.') }}
                                                    @elseif ($tiket->harga_anak > 0)
                                                        Harga: Rp {{ number_format($tiket->harga_anak, 0, ',', '.') }}
                                                    @elseif ($tiket->harga_dewasa > 0)
                                                        Harga: Rp {{ number_format($tiket->harga_dewasa, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-gray-700">Tidak ada tiket untuk kategori ini.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
