<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>
    <div class="min-h-screen bg-gray-100">
        <!-- Navbar -->


        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-teal-400 to-blue-500 py-20">
            <!-- Hero Content -->
            <div class="bg-gradient-to-r from-teal-400 to-blue-500 h-screen flex flex-col justify-center items-center">
                <h1 class="text-4xl font-bold text-white">Selamat Datang di Taman Pintar!</h1>
                <p class="mt-4 text-lg text-white">Temukan petualangan seru dan belajar di wahana-wahana kami.</p>
                <!-- Pencarian atau Pemilihan Tiket -->
                <div class="mt-8 max-w-lg mx-auto">
                    <!-- Pencarian -->

                    <!-- Pencarian -->
                    <div class="bg-white py-12">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <form action="#" method="GET">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Dropdown Jenis Wahana -->
                                    <div>
                                        <label for="jenis_wahana" class="block text-sm font-medium text-gray-700">Jenis
                                            Wahana</label>
                                        <select id="jenis_wahana" name="jenis_wahana"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="wahana">Wahana</option>
                                            <option value="program_kreativitas">Program Kreativitas</option>
                                            <option value="event">Event</option>
                                        </select>
                                    </div>
                                    <!-- Dropdown Wahana -->
                                    <div>
                                        <label for="wahana"
                                            class="block text-sm font-medium text-gray-700">Wahana</label>
                                        <select id="wahana" name="wahana"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <!-- Isi dropdown wahana sesuai pilihan -->
                                        </select>
                                    </div>
                                    <!-- Dropdown Hari Kunjungan -->
                                    <div>
                                        <label for="hari_kunjungan" class="block text-sm font-medium text-gray-700">Hari
                                            Kunjungan</label>
                                        <select id="hari_kunjungan" name="hari_kunjungan"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="senin">Senin</option>
                                            <option value="selasa">Selasa</option>
                                            <option value="rabu">Rabu</option>
                                            <option value="kamis">Kamis</option>
                                            <option value="jumat">Jumat</option>
                                            <option value="sabtu">Sabtu</option>
                                            <option value="minggu">Minggu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-center">
                                    <button type="submit"
                                        class="bg-teal-400 transition hover:scale-105 text-white font-bold py-2 px-4 rounded-md">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-4 mt-16 text-center text-gray-900">
            <h2 class="text-4xl">Jelajahi Wahana Taman Pintar</h2>
        </div>
        <div class="container grid grid-cols-3 gap-4 max-w-4xl mx-auto pt-16">
            @foreach($wahanaTikets as $tiket)
            <!-- Card -->
            <a href="{{ route('wahana.detail', ['slug' => $tiket->slug]) }}" class="group relative block overflow-hidden">
                {{-- <button class="absolute end-4 top-4 z-10 rounded-full bg-white p-1.5 text-gray-900 transition hover:text-gray-900/75">
                    <span class="sr-only">Wishlist</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                </button> --}}
                <img src="{{ asset('path_to_your_image.jpg') }}" alt="" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72">
                <div class="relative border border-gray-100 bg-white p-6">
                    <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $tiket->nama }}</h3>
                    <p class="mt-1.5 text-sm text-gray-700">Deskripsi Tiket</p>
                    <div class="mb-4">
                        <p class="text-gray-700">Harga Anak: Rp {{ number_format($tiket->harga_anak) }}</p>
                        <p class="text-gray-700">Harga Dewasa: Rp {{ number_format($tiket->harga_dewasa) }}</p>
                    </div>
                    <form method="POST">
                        @csrf
                        <button class="block w-full rounded bg-teal-400 p-4 text-sm font-medium transition hover:scale-105">
                            Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </a>
            @endforeach
        </div>
        <div class="p-4 mt-16 text-center text-gray-900">
            <h2 class="text-4xl">Jelajahi Program Kreativitas Taman Pintar</h2>
        </div>
        <div class="container grid grid-cols-3 gap-4 max-w-4xl mx-auto pt-16">
            @foreach($progTikets as $tiket)
            <!-- Card -->
            <a href="{{ route('wahana.detail', ['slug' => $tiket->slug]) }}" class="group relative block overflow-hidden">
                {{-- <button class="absolute end-4 top-4 z-10 rounded-full bg-white p-1.5 text-gray-900 transition hover:text-gray-900/75">
                    <span class="sr-only">Wishlist</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                </button> --}}
                <img src="{{ asset('path_to_your_image.jpg') }}" alt="" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72">
                <div class="relative border border-gray-100 bg-white p-6">
                    <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $tiket->nama }}</h3>
                    <p class="mt-1.5 text-sm text-gray-700">Deskripsi Tiket</p>
                    <div class="mb-4">
                        <p class="text-gray-700">Harga Anak: Rp {{ number_format($tiket->harga_anak) }}</p>
                        <p class="text-gray-700">Harga Dewasa: Rp {{ number_format($tiket->harga_dewasa) }}</p>
                    </div>
                    <form method="POST">
                        @csrf
                        <button class="block w-full rounded bg-teal-400 p-4 text-sm font-medium transition hover:scale-105">
                            Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </a>
            @endforeach
        </div>

        <!-- About Section -->
        <div class="py-12">
            <!-- About Content -->
        </div>
    </div>
</x-app-layout>

{{--
  <section id="home" class="h-screen flex justify-center items-center bg-gray-100">
    <div class="container h-full">
      <div class="flex flex-wrap">
        <div class="w-full self-center px-4 lg:w-1/2">
          <h1 class="text-base font-semibold text-primary md:text-xl ">Taman Pintar <span class="block font-bold text-dark text-4xl mt-1 lg:text-5xl"></span></h1>
          <h2 class="font-medium text-huruf text-lg mb-5 lg:text-2xl">E-tiketing System</h2>
        </div>
        <div class="w-full self-end px-4 py-20 lg:w-1/2">
          <div class="bg-white shadow-md rounded-lg px-8 py-6">
            <h3 class="text-lg font-medium mb-4">Pencarian Tiket</h3>
            {{-- <form method="POST" action="{{ route('search') }}"> --}}
{{-- @csrf --}}

{{-- <div class="mb-4">
                <x-input-label for="jenis_tiket" :value="__('Jenis Tiket')" />
                <select id="jenis_tiket" name="jenis_tiket" class="block mt-1 w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                  <option value="event">Event</option>
                  <option value="wahana">Wahana</option>
                </select>
              </div>

              <div class="mb-4">
                <x-input-label for="pilihan_tiket" :value="__('Pilihan Tiket')" />
                <select id="pilihan_tiket" name="pilihan_tiket" class="block mt-1 w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </select>
              </div>

              <div class="mb-4">
                <x-input-label for="hari_kunjungan" :value="__('Hari Kunjungan')" />
                <select id="hari_kunjungan" name="hari_kunjungan" class="block mt-1 w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </select>
              </div>

              <div class="mb-4">
                <x-input-label for="jam_kunjungan" :value="__('Jam Kunjungan')" />
                <select id="jam_kunjungan" name="jam_kunjungan" class="block mt-1 w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </select>
              </div>

              <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                  {{ __('Pesan') }}
                </x-primary-button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Komponen Pencarian --}}
{{-- <x-search-bar /> --}}

{{-- <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h2 class="text-xl">Riwayat Pemesanan</h2>
        </div> --}}

{{-- <script>
  const jenisTiketElement = document.getElementById('jenis_tiket');
  const pilihanTiketElement = document.getElementById('pilihan_tiket');
  const hariKunjunganElement = document.getElementById('hari_kunjungan');
  const jamKunjunganElement = document.getElementById('jam_kunjungan');

jenisTiketElement.addEventListener('change', async (e) => {
  const jenisTiket = e.target.value;

  // Fetch data pilihan tiket berdasarkan jenis tiket
  const response = await fetch(`/api/pilihan-tiket/${jenisTiket}`);
  const data = await response.json();

  // Hapus semua opsi lama di dropdown pilihan tiket
  while (pilihanTiketElement.firstChild) {
    pilihanTiketElement.removeChild(pilihanTiketElement.firstChild);
  }

  // Tambahkan opsi baru untuk setiap pilihan tiket
  data.forEach((pilihanTiket) => {
    const option = document.createElement('option');
    option.value = pilihanTiket.id;
    option.textContent = pilihanTiket.nama;
    pilihanTiketElement.appendChild(option);
  });

  // Reset dropdown hari kunjungan dan jam kunjungan
  hariKunjunganElement.selectedIndex = 0;
  jamKunjunganElement.selectedIndex = 0;

  // Tampilkan dropdown hari kunjungan dan jam kunjungan
  hariKunjunganElement.disabled = false;
  jamKunjunganElement.disabled = false;
});

hariKunjunganElement.addEventListener('change', async (e) => {
  const jenisTiket = jenisTiketElement.value;
  const pilihanTiket = pilihanTiketElement.value;
  const hariKunjungan = e.target.value;

  // Fetch data jam kunjungan berdasarkan jenis tiket, pilihan tiket, dan hari kunjungan
  const response = await fetch(`/api/jam-kunjungan/${jenisTiket}/${pilihanTiket}/${hariKunjungan}`);
  const data = await response.json();

  // Hapus semua opsi lama di dropdown jam kunjungan
  while (jamKunjunganElement.firstChild) {
    jamKunjunganElement.removeChild(jamKunjunganElement.firstChild);
  }

  // Tambahkan opsi baru untuk setiap jam kunjungan
  data.forEach((jamKunjungan) => {
    const option = document.createElement('option');
    option.value = jamKunjungan;
    option.textContent = jamKunjungan;
    jamKunjunganElement.appendChild(option);
  });
});

</script> --}}
