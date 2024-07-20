<x-app-layout>
    <x-slot name="title">
        Detail Wahana
    </x-slot>

    <div class="min-h-screen py-16  items-center justify-center">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
            <!-- Container untuk detail tiket -->
            <div class="w-full md:w-3/5 border-r shadow-md bg-white pr-4 py-4 rounded-lg mt-6">
                <!-- Carousel Gambar -->
                <div class="px-4">
                    <div class="h-60 md:h-80 rounded-lg bg-gray-100 mb-4">
                        <figure class="h-full w-full">
                            <img src="{{ asset('storage/' . $tiket->gambar) }}" alt="{{ $tiket->nama }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        </figure>
                    </div>
                </div>

                <!-- Nama, Deskripsi, dan Harga -->
                <div class="flex flex-col space-y-4 px-4">
                    <h2
                        class="mb-2 ml-4 leading-tight tracking-tight font-Poppins font-bold text-gray-800 text-2xl md:text-3xl">
                        {{ $tiket->nama }}
                    </h2>
                    <p class="text-gray-500 ml-4 text-sm">By <a href="#"
                            class="text-indigo-600 hover:underline">Nama Taman Pintar, Yogyakarta</a></p>

                    <div class="flex flex-col space-y-2">
                        <div class="mb-2 ml-4">
                            @if ($tiket->harga_anak > 0 && $tiket->harga_dewasa > 0)
                                <p class="text-gray-900 text-xl font-bold font-Poppins">
                                    Harga Anak: <span class="text-teal-400 text-xl font-bold font-Poppins">Rp
                                        {{ number_format($tiket->harga_anak) }}</span>
                                </p>
                                <p class="text-gray-900 text-xl font-bold font-Poppins">
                                    Harga Dewasa: <span class="text-teal-400 text-xl font-bold font-Poppins"> Rp
                                        {{ number_format($tiket->harga_dewasa) }}</span>
                                </p>
                            @elseif($tiket->harga_anak > 0)
                                <p class="text-gray-900 text-xl font-bold font-Poppins">
                                    Harga: <span class="text-teal-400 text-xl font-bold font-Poppins">Rp
                                        {{ number_format($tiket->harga_anak) }}</span>
                                </p>
                            @elseif($tiket->harga_dewasa > 0)
                                <p class="text-gray-900 text-xl font-bold font-Poppins">
                                    Harga: <span class="text-teal-400 text-xl font-bold font-Poppins">Rp
                                        {{ number_format($tiket->harga_dewasa) }}</span>
                                </p>
                            @endif

                        </div>
                        {{-- <hr class="my-4 border-t py-2 mt-4 border-blue-500"> --}}
                        <div class="rounded shadow-md p-2 border border-teal-400">
                            <p class="text-gray-900 font-semibold font-Poppins">{{ $tiket->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container untuk dropdown -->
            <div class="w-full  md:w-2/5">
                <!-- Dropdown Content -->
                <div class="border rounded-lg mt-6 bg-white p-4">
                    <h3 class="text-gray-800 font-bold mb-2 font-Poppins">Pilih Hari dan Tanggal Kunjungan</h3>
                    <form action="{{ route('order') }}" method="POST">
                        @csrf
                        <select id="hari_tanggal" name="hari_tanggal"
                            class="w-full border-gray-300 rounded-md shadow-md p-2 bg-white focus:border-teal-400 focus:ring focus:ring-teal-400 focus:ring-opacity-50">
                            <option value="" class="bg-white font-Poppins text-gray-900" disabled selected>Pilih
                                salah satu</option>
                            @for ($i = 0; $i < 7; $i++)
                                @php
                                    $hari_indonesia = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                    $tanggal = Carbon\Carbon::now()->addDays($i);
                                    $hari_iso = $tanggal->format('w'); // Get weekday number in ISO-8601 format
                                    $hari = $hari_indonesia[($hari_iso + 6) % 7]; // Adjust for Indonesian weekday numbering
                                    $tanggal_lengkap = $tanggal->translatedFormat('d F Y'); // Format date in Indonesian
                                @endphp
                                <option value="{{ $tanggal->toDateString() }}">{{ $hari }}
                                    {{ $tanggal_lengkap }}</option>
                            @endfor
                        </select>
                    </form>
                    <div id="cardContainer" class="mt-4 border-spacing-1"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('hari_tanggal').addEventListener('change', function() {
            var selectedDate = this.value;
            var tiketId = '{{ $tiket->tiket_id }}';
            var cardContainer = document.getElementById('cardContainer');

            // Hapus card sebelumnya jika ada
            cardContainer.innerHTML = '';

            // Buat card baru
            var card = document.createElement('div');
            card.className = 'bg-white shadow-md rounded-lg p-4 mb-4';

            // Judul card diambil dari nama detail tiket
            var title = document.createElement('h2');
            title.className = 'text-black font-bold mb-2';
            title.textContent = '{{ $tiket->nama }}';
            card.appendChild(title);

            // Garis pembatas
            var divider = document.createElement('hr');
            divider.className = 'my-2 border-gray-300';
            card.appendChild(divider);

            // Tampilkan tanggal yang dipilih
            var selectedDateObj = new Date(selectedDate);

            // Tampilkan hari dari tanggal yang dipilih
            var dayOfWeek = selectedDateObj.toLocaleDateString('id-ID', {
                weekday: 'long'
            });
            var selectedDateElement = document.createElement('p');
            selectedDateElement.className = 'text-gray-500';
            selectedDateElement.textContent = 'Hari Kunjungan: ' + dayOfWeek;
            card.appendChild(selectedDateElement);

            // Fetch kuota dari server
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

                        // Tombol Pesan Sekarang
                        var button = document.createElement('button');
                        button.className =
                            'block w-full rounded bg-teal-400 p-4 text-md font-medium text-white transition hover:scale-105';
                        button.textContent = 'Pesan Sekarang';
                        button.addEventListener('click', function() {
                            // Buat form dinamis
                            var form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route('order') }}';

                            // Tambahkan token CSRF
                            var csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';
                            form.appendChild(csrfToken);

                            // Tambahkan field tanggal yang dipilih
                            var input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'hari_tanggal';
                            input.value = selectedDate;
                            form.appendChild(input);

                            var inputTicketId = document.createElement('input');
                            inputTicketId.type = 'hidden';
                            inputTicketId.name = 'tiket_id';
                            inputTicketId.value = tiketId;
                            form.appendChild(inputTicketId);

                            // Tambahkan form ke body dan submit
                            document.body.appendChild(form);
                            form.submit();
                        });
                        card.appendChild(button);

                        // Tambahkan tombol "Tambah Ke Keranjang"
                        var addToCartButton = document.createElement('button');
                        addToCartButton.className =
                            'block w-full rounded bg-blue-400 p-4 text-lg font-medium text-white transition hover:scale-105 mt-2';
                            addToCartButton.dataset.kategori = '{{ $tiket->kategori }}';
                        addToCartButton.textContent = 'Tambah Ke Keranjang';
                        addToCartButton.addEventListener('click', function() {
                            // Check if the user is logged in by checking for a user identifier (e.g., user ID or token)
                            var userId =
                            '{{ Auth::id() }}'; // Assuming you have access to the user ID in your Blade template
                            if (!userId) {
                                alert(
                                    'Anda harus login untuk menambahkan tiket ke keranjang.');
                                    window.location.href = '{{ route('login') }}'; // Redirect to login page
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
                        // Tampilkan pesan jika kuota 0
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
    </script>


</x-app-layout>
