@component('layouts.app')
    {{-- <x-slot name="title">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight"> --}}
    {{-- {{ __('Home') }} --}}
    {{-- </h2> --}}
    {{-- </x-slot> --}} --}}

    <div class="min-h-screen bg-gray-100">
        <!-- Navbar -->


        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-400 to-teal-400">
            <!-- Hero Content -->
            <div class="glass h-screen flex flex-col justify-center items-center">
                <div
                    class="max-w-7xl mx-auto flex flex-col lg:flex-row justify-center items-center space-y-8 lg:space-y-0 lg:space-x-8">
                    <!-- Teks -->
                    <div class="text-center lg:text-left">
                        <h1 class="text-4xl font-bold font-Poppins text-white">Selamat Datang di Taman Pintar!</h1>
                        <p class="mt-4 text-lg  font-Poppins  text-white">Temukan petualangan seru dan belajar di
                            wahana-wahana kami.</p>
                    </div>
                    <!-- Pencarian atau Pemilihan Tiket -->
                    <div class="bg-white py-8 rounded-lg shadow-lg lg:w-2/5">
                        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
                            <form action="{{ route('order') }}" method="POST">
                                @csrf
                                <div class="text-lg font-bold font-Poppins text-gray-800 text-center mb-4">
                                    Rencanakan Harimu!
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                                    <div>
                                        <label for="jenis_wahana"
                                            class="block text-sm font-Poppins font-bold text-gray-700">Kategori
                                            Tiket</label>
                                        <select id="jenis_wahana" name="jenis_wahana"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="" class="bg-white font-Poppins text-gray-900" disabled
                                                selected>Pilih salah satu</option>
                                            <option value="wahana">Wahana</option>
                                            <option value="program_kreativitas">Program Kreativitas</option>
                                            <option value="event">Event</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="jenis_tiket"
                                            class="block text-sm font-bold font-Poppins text-gray-700">Pilih Tiket</label>
                                        <select id="jenis_tiket" name="jenis_tiket"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="" class="bg-white  font-Poppins text-gray-900" disabled
                                                selected>Pilih Salah Satu</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="hari_kunjungan"
                                            class="block text-sm font-bold font-Poppins text-gray-700">Pilih Hari
                                            Kunjungan</label>
                                        <select id="hari_kunjungan" name="hari_kunjungan"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="" class="bg-white font-Poppins text-gray-900" disabled
                                                selected>Pilih salah satu</option>
                                            @for ($i = 0; $i < 7; $i++)
                                                @php
                                                    $hari_indonesia = [
                                                        'Senin',
                                                        'Selasa',
                                                        'Rabu',
                                                        'Kamis',
                                                        'Jumat',
                                                        'Sabtu',
                                                        'Minggu',
                                                    ];
                                                    $tanggal = Carbon\Carbon::now()->addDays($i);
                                                    $hari_iso = $tanggal->format('w'); // Get weekday number in ISO-8601 format
                                                    $hari = $hari_indonesia[($hari_iso + 6) % 7]; // Adjust for Indonesian weekday numbering
                                                    $tanggal_lengkap = $tanggal->translatedFormat('d F Y'); // Format date in Indonesian
                                                @endphp
                                                <option value="{{ $tanggal->toDateString() }}">{{ $hari }}
                                                    {{ $tanggal_lengkap }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-center">
                                    <button type="button" id="cari_tiket"
                                        class="block w-32 rounded bg-teal-400 p-2 text-sm text-white font-Poppins font-bold transition hover:scale-105 ease-in-out">
                                        Cari
                                    </button>
                                </div>
                            </form>

                            <div id="cardContainer" class="mt-4 border-spacing-1"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>






        <!-- Main Content -->
        <!-- Main Content -->
        <!-- Main Content -->
        <div class="container mx-auto pt-16 px-4 py-4 mb-4 sm:px-6 lg:px-8 lg:max-w-7xl">
            @if ($eventTikets->isNotEmpty())
                <div
                    class="p-2 text-left rounded-md text-sm font-bold text-gray-900 border-b-4 glass bg-gradient-to-r from-teal-400 to-blue-500 mt-8">
                    <h2 class="text-lg text-white">Jelajahi Event Taman Pintar</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-8 justify-center">
                    @foreach ($eventTikets as $tiket)
                        <a href="{{ route('event.detail', ['slug' => $tiket->slug]) }}"
                            class="group relative block overflow-hidden">
                            <div class="card w-96 bg-base-100 shadow-xl mx-auto">
                                <figure>
                                    <img src="{{ asset('storage/' . $tiket->gambar) }}" alt="{{ $tiket->nama }}"
                                        class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72">
                                </figure>
                                <div class="card-body">
                                    <h2 class="card-title">
                                        {{ $tiket->nama }}
                                        <div class="badge badge-secondary">Baru</div>
                                    </h2>
                                    <p>Deskripsi Tiket</p>
                                    <p class="text-gray-700">Mulai:
                                        {{ \Carbon\Carbon::parse($tiket->tanggal_mulai)->format('d M Y') }}</p>
                                    <p class="text-gray-700">Selesai:
                                        {{ \Carbon\Carbon::parse($tiket->tanggal_selesai)->format('d M Y') }}</p>
                                    <div>
                                        @if ($tiket->harga_anak > 0 && $tiket->harga_dewasa > 0)
                                            <p class="text-gray-700">Harga Anak: Rp {{ number_format($tiket->harga_anak) }}
                                            </p>
                                            <p class="text-gray-700">Harga Dewasa: Rp
                                                {{ number_format($tiket->harga_dewasa) }}</p>
                                        @else
                                            <p class="text-gray-700">Harga: Rp
                                                {{ number_format($tiket->harga_anak + $tiket->harga_dewasa) }}</p>
                                        @endif
                                    </div>
                                    <div class="card-actions justify-end">
                                        <div class="badge badge-outline">Event</div>
                                        <div class="badge badge-outline">Tiket</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="p-2 text-left rounded-md text-sm font-bold text-gray-900 border-b-4 bg-white">
                <h2 class="text-2xl text-center font-poppins">Jelajahi Wahana Taman Pintar!!</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-8 justify-center">
                @foreach ($wahanaTikets as $tiket)
                    <a href="{{ route('wahana.detail', ['slug' => $tiket->slug]) }}"
                        class="group relative block overflow-hidden">
                        <div class="card w-96 bg-base-100 shadow-xl mx-auto">
                            <figure>
                                <img src="{{ asset('storage/' . $tiket->gambar) }}" alt="{{ $tiket->nama }}"
                                    class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72">
                            </figure>
                            <div class="card-body">
                                <h2 class="card-title">
                                    {{ $tiket->nama }}
                                    <div class="badge badge-secondary">Baru</div>
                                </h2>
                                <!--<p>Deskripsi Tiket</p>-->
                                <div>
                                    @if ($tiket->harga_anak > 0 && $tiket->harga_dewasa > 0)
                                        <p class="text-gray-700">Harga Anak: Rp {{ number_format($tiket->harga_anak) }}</p>
                                        <p class="text-gray-700">Harga Dewasa: Rp {{ number_format($tiket->harga_dewasa) }}
                                        </p>
                                    @else
                                        <p class="text-gray-700">Harga: Rp
                                            {{ number_format($tiket->harga_anak + $tiket->harga_dewasa) }}</p>
                                    @endif
                                </div>
                                <div class="card-actions justify-end">
                                    <div class="badge badge-outline">Wahana</div>
                                    <div class="badge badge-outline">Tiket</div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div
                class="relative -mx-4 sm:-mx-6 lg:-mx-8 p-2 text-left max-w-full rounded-md text-sm font-bold text-gray-900 border-b-4 mt-8">
                <h2 class="text-2xl text-center font-poppins">Program Kreativitas Taman Pintar</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-8 justify-center">
                @foreach ($progTikets as $tiket)
                    <a href="{{ route('wahana.detail', ['slug' => $tiket->slug]) }}"
                        class="group relative block overflow-hidden">
                        <div class="card w-96 bg-base-100 shadow-xl mx-auto">
                            <figure>
                                <img src="{{ asset('storage/' . $tiket->gambar) }}" alt="{{ $tiket->nama }}"
                                    class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72">
                            </figure>
                            <div class="card-body">
                                <h2 class="card-title">
                                    {{ $tiket->nama }}
                                    <div class="badge badge-secondary">Baru</div>
                                </h2>
                                <!--<p>Deskripsi Tiket</p>-->
                                <div>
                                    @if ($tiket->harga_anak > 0 && $tiket->harga_dewasa > 0)
                                        <p class="text-gray-700">Harga Anak: Rp {{ number_format($tiket->harga_anak) }}</p>
                                        <p class="text-gray-700">Harga Dewasa: Rp {{ number_format($tiket->harga_dewasa) }}
                                        </p>
                                    @else
                                        <p class="text-gray-700">Harga: Rp
                                            {{ number_format($tiket->harga_anak + $tiket->harga_dewasa) }}</p>
                                    @endif
                                </div>
                                <div class="card-actions justify-end">
                                    <div class="badge badge-outline">Program</div>
                                    <div class="badge badge-outline">Tiket</div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>





        <!-- About Section -->

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var kategoriSelect = document.getElementById('jenis_wahana');
            var tiketSelect = document.getElementById('jenis_tiket');
            var cariButton = document.getElementById('cari_tiket');
            var cardContainer = document.getElementById('cardContainer');

            var tikets = {
                wahana: @json($wahanaTikets),
                program_kreativitas: @json($progTikets),
                event: @json($eventTikets)
            };

            kategoriSelect.addEventListener('change', function() {
                var kategori = this.value;
                tiketSelect.innerHTML =
                    '<option value="" class="bg-white text-gray-900" disabled selected>Pilih Salah Satu</option>';

                if (tikets[kategori]) {
                    tikets[kategori].forEach(function(tiket) {
                        if (tiket && tiket.tiket_id && tiket.nama) {
                            var option = document.createElement('option');
                            option.value = tiket.tiket_id;
                            option.text = tiket.nama;
                            tiketSelect.appendChild(option);
                        } else {
                            console.error('Invalid tiket data:', tiket);
                        }
                    });
                } else {
                    console.error('Kategori tidak valid:', kategori);
                }
            });

            cariButton.addEventListener('click', function() {
                var kategori = kategoriSelect.value;
                var tiketId = tiketSelect.value;
                var selectedDate = document.getElementById('hari_kunjungan').value;

                if (!kategori || !tiketId || !selectedDate) {
                    alert('Silakan pilih kategori tiket, tiket, dan hari kunjungan.');
                    return;
                }

                var tiket = tikets[kategori].find(t => t.tiket_id == tiketId);
                cardContainer.innerHTML = ''; // Clear previous cards

                // Create new card
                var card = document.createElement('div');
                card.className = 'bg-white shadow-md rounded-lg p-4 mb-4';

                // Card title from ticket name
                var title = document.createElement('h2');
                title.className = 'text-black font-bold mb-2';
                title.textContent = tiket.nama;
                card.appendChild(title);

                var divider = document.createElement('hr');
                divider.className = 'my-2 border-gray-300';
                card.appendChild(divider);

                var selectedDateObj = new Date(selectedDate);
                var dayOfWeek = selectedDateObj.toLocaleDateString('id-ID', {
                    weekday: 'long'
                });
                var selectedDateElement = document.createElement('p');
                selectedDateElement.className = 'text-gray-500';
                selectedDateElement.textContent = 'Hari Kunjungan: ' + dayOfWeek;
                card.appendChild(selectedDateElement);

                if (tiket.tiket_terkait_id) {
                    var tiketTerkait = tikets[kategori].find(t => t.tiket_id == tiket.tiket_terkait_id);
                    var relatedTicketInfo = document.createElement('p');
                    relatedTicketInfo.className = 'text-gray-700';
                    relatedTicketInfo.textContent = 'Pembelian ini juga termasuk tiket: ' + tiketTerkait
                        .nama;
                    card.appendChild(relatedTicketInfo);
                }

                fetch(`/tiket/kuota?tanggal=${selectedDate}&tiket_id=${tiketId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.kuota > 0) {
                            var quota = document.createElement('p');
                            quota.className = 'text-black opacity-75 mb-2';
                            quota.textContent = 'Kuota: ' + data.kuota;
                            card.appendChild(quota);

                            var divider = document.createElement('hr');
                            divider.className = 'my-2 border-gray-300';
                            card.appendChild(divider);

                            var pesanButton = document.createElement('button');
                            pesanButton.className =
                                'block w-full rounded bg-teal-400 p-4 text-lg font-medium text-white transition hover:scale-105';
                            pesanButton.textContent = 'Pesan Sekarang';
                            pesanButton.addEventListener('click', function() {
                                var form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '{{ route('order') }}';

                                var csrfToken = document.createElement('input');
                                csrfToken.type = 'hidden';
                                csrfToken.name = '_token';
                                csrfToken.value = '{{ csrf_token() }}';
                                form.appendChild(csrfToken);

                                var inputDate = document.createElement('input');
                                inputDate.type = 'hidden';
                                inputDate.name = 'hari_tanggal';
                                inputDate.value = selectedDate;
                                form.appendChild(inputDate);

                                var inputTicketId = document.createElement('input');
                                inputTicketId.type = 'hidden';
                                inputTicketId.name = 'tiket_id';
                                inputTicketId.value = tiketId;
                                form.appendChild(inputTicketId);

                                document.body.appendChild(form);
                                form.submit();
                            });
                            card.appendChild(pesanButton);

                            var addToCartButton = document.createElement('button');
                            addToCartButton.className =
                                'block w-full rounded bg-blue-400 p-4 text-lg font-medium text-white transition hover:scale-105 mt-2';
                            addToCartButton.textContent = 'Tambah Ke Keranjang';
                            addToCartButton.addEventListener('click', function() {
                                // Check if the user is logged in by checking for a user identifier (e.g., user ID or token)
                                var userId =
                                '{{ Auth::id() }}'; // Assuming you have access to the user ID in your Blade template
                                if (!userId) {
                                    alert(
                                        'Anda harus login untuk menambahkan tiket ke keranjang.');
                                    return;
                                }

                                var cartData = {
                                    kategori: kategori,
                                    tiket_id: tiketId,
                                    tanggal_kunjungan: selectedDate,
                                    _token: '{{ csrf_token() }}'
                                };

                                fetch('/cart/add', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify(cartData)
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('Tiket telah ditambahkan ke keranjang.');
                                        } else if (data.message) {
                                            alert(data
                                            .message); // Show the specific error message from the server
                                        } else {
                                            throw new Error(
                                                'Gagal menambahkan tiket ke keranjang.');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Terjadi kesalahan:', error);
                                        alert(
                                            'Terjadi kesalahan saat menambahkan tiket ke keranjang.');
                                    });
                            });
                            card.appendChild(addToCartButton);

                            var footnote = document.createElement('p');
                            footnote.className = 'text-gray-500 block mt-2';
                            footnote.textContent =
                                'Klik tombol "Pesan Sekarang" atau "Tambah Ke Keranjang" untuk melanjutkan proses pemesanan tiket.';
                            card.appendChild(footnote);

                        } else {
                            var alertContainer = document.createElement('div');
                            alertContainer.className =
                                'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative';
                            alertContainer.setAttribute('role', 'alert');

                            var alertMessage = document.createElement('p');
                            alertMessage.textContent =
                                'Kuota tiket untuk tanggal tersebut sudah habis. Silakan pilih tanggal lain.';
                            alertContainer.appendChild(alertMessage);

                            card.appendChild(alertContainer);
                        }

                        cardContainer.appendChild(card);
                    })
                    .catch(error => {
                        console.error('Error fetching kuota:', error);
                    });
            });
        });
    </script>

@endcomponent
