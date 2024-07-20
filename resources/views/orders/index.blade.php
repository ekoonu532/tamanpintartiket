<x-app-layout>
    <x-slot name="title">
        Form Pemesanan Tiket
    </x-slot>
    <div class="min-h-screen py-16 flex items-center justify-center">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
            <!-- Container untuk detail tiket -->
            @if ($selectedTicket)
                <div class="w-full md:w-3/5 border-r bg-white pr-4 py-4 rounded-lg mt-6">
                    <!-- Carousel Gambar -->
                    <div class="px-4">
                        <div class="h-60 md:h-80 rounded-lg bg-gray-100 mb-4">
                            <figure class="h-full w-full">
                                <img src="{{ asset('storage/' . $selectedTicket->gambar) }}"
                                    alt="{{ $selectedTicket->nama }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            </figure>
                        </div>
                    </div>

                    <!-- Nama, Deskripsi, dan Harga -->
                    <div class="flex flex-col space-y-4 px-4">
                        <h2
                            class="mb-1 leading-tight tracking-tight font-Poppins font-bold text-gray-800 text-2xl md:text-3xl ml-4">
                            {{ $selectedTicket->nama }}</h2>
                        <p class="text-gray-500 text-sm ml-4">By <a href="#"
                                class="text-indigo-600 hover:underline">Taman Pintar, Yogyakarta</a></p>

                       <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 ml-4">
                            <div class="flex-1">
                                @if ($selectedDate)
                                    @php
                                        \Carbon\Carbon::setLocale('id'); // Set locale ke Bahasa Indonesia
                                        $formattedDate = \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y');
                                    @endphp
                                    <p class="text-gray-900 text-lg font-serif font-bold mb-2">Tanggal Kunjungan: {{ $formattedDate }}</p>
                                @endif

                                @if ($selectedTicket->harga_anak > 0)
                                    <p class="text-gray-900 text-xl font-bold font-Poppins">Harga Tiket Anak: <span class="text-teal-400 text-xl font-bold font-Poppins"> Rp {{ number_format($selectedTicket->harga_anak) }}</span></p>
                                @endif
                                @if ($selectedTicket->harga_dewasa > 0)
                                    <p class="text-gray-900 text-xl font-bold font-Poppins">Harga Tiket Dewasa: <span class="text-teal-400 text-xl font-bold font-Poppins"> Rp {{ number_format($selectedTicket->harga_dewasa) }}</span></p>
                                @endif
                            </div>
                            <div class="border rounded-lg bg-teal-400 my-4 p-4 md:w-1/3 md:ml-auto md:mr-0">
                                <h3 class="text-white font-bold mb-2 font-Poppins">Informasi Kuota</h3>
                                <p class="text-white font-Poppins" id="sisa-kuota">Loading...</p>
                                <!-- Ini akan diperbarui oleh JavaScript -->
                            </div>
                        </div>

                        <hr class="my-4 border-t border-gray-300">

                        <p class="text-gray-900 font-semibold font-Poppins">{{ $selectedTicket->deskripsi }}</p>

                        <!-- Informasi Tiket Terkait -->
                        @if ($relatedTicket)
                            <div class="mt-6 bg-gray-100 p-4 rounded-lg">
                                <h3 class="text-gray-800 font-bold mb-2">Pembelian Tiket ini Termasuk Pembelian Tiket
                                </h3>
                                <p class="text-gray-700 font-semibold">{{ $relatedTicket->nama }}</p>
                                @if ($relatedTicket->harga_anak > 0)
                                    <p class="text-gray-600">Harga Tiket Anak: Rp
                                        {{ number_format($relatedTicket->harga_anak) }}</p>
                                @endif
                                @if ($relatedTicket->harga_dewasa > 0)
                                    <p class="text-gray-600">Harga Tiket Dewasa: Rp
                                        {{ number_format($relatedTicket->harga_dewasa) }}</p>
                                @endif
                                <p class="text-gray-600">{{ $relatedTicket->deskripsi }}</p>
                            </div>
                        @endif

                    </div>
                </div>
            @endif

            <!-- Container untuk form pemesanan -->
            <div class="w-full md:w-2/5">
                <div class="border rounded-lg mt-6 bg-white p-4">
                    <h3 class="text-gray-800 font-bold mb-2">Form Pemesanan Tiket</h3>

                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                        <input type="hidden" name="selected_ticket_name" value="{{ $selectedTicket->nama }}">
                        <input type="hidden" name="tiket_id" value="{{ $selectedTicket->tiket_id }}">
                        <input type="hidden" name="harga_anak" value="{{ $selectedTicket->harga_anak }}">
                        <input type="hidden" name="harga_dewasa" value="{{ $selectedTicket->harga_dewasa }}">
                        <input type="hidden" name="total_harga" id="total_harga_input" value="0">
                        @if ($relatedTicket)
                        <input type="hidden" name="related_ticket_id" value="{{ $relatedTicket->tiket_id }}">
                        @endif


                        @if ($relatedTicket)
                            <input type="hidden" name="related_ticket_id" value="{{ $relatedTicket->tiket_id }}">
                            <input type="hidden" name="related_ticket_name" value="{{ $relatedTicket->nama }}">
                            <input type="hidden" name="related_ticket_harga_anak"
                                value="{{ $relatedTicket->harga_anak }}">
                            <input type="hidden" name="related_ticket_harga_dewasa"
                                value="{{ $relatedTicket->harga_dewasa }}">
                        @endif

                        <!-- Form fields for name, email, phone, etc. -->
                        <div>
                            <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                            <x-text-input id="nama_lengkap" class="block mt-1 mb-3 w-full" type="text"
                                name="nama_lengkap" :value="Auth::user()->name" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                        </div>

                        {{-- <div class="mt-4">
                            <div class="col-md-6 mb-3">
                                <label for="nomor_hp" class="block font-medium text-sm text-gray-700">Nomor HP:</label>
                                <input type="number"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    id="nomor_hp" name="nomor_hp" required>
                                <x-input-error :messages="$errors->get('nomor_hp')" class="mt-2" />
                            </div>
                        </div> --}}


                        <div class="mb-3">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="Auth::user()->email" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="flex justify-between">
                            @if ($selectedTicket->harga_anak > 0)
                                <div class="w-full md:w-1/2 mb-3 mt-1">
                                    <label for="jumlah_anak" class="block font-medium text-sm text-gray-700">Jumlah
                                        Tiket Anak:</label>
                                    <input type="number"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        id="jumlah_anak" name="jumlah_anak" min="0" value="0">
                                    <x-input-error :messages="$errors->get('jumlah_anak')" class="mt-2" />
                                </div>
                            @endif

                            @if ($selectedTicket->harga_dewasa > 0)
                                <div class="w-full md:w-1/2 mb-3">
                                    <label for="jumlah_dewasa" class="block font-medium text-sm text-gray-700">Jumlah
                                        Tiket Dewasa:</label>
                                    <input type="number"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        id="jumlah_dewasa" name="jumlah_dewasa" min="0" value="0">
                                    <x-input-error :messages="$errors->get('jumlah_dewasa')" class="mt-2" />
                                </div>
                            @endif
                            
                            
                        </div>
                        @if ($relatedTicket)
    <div class="flex justify-between">
        @if ($relatedTicket->harga_anak > 0)
            <div class="w-full md:w-1/2 mb-3 mt-1">
                <label for="jumlah_terkait_anak" class="block font-medium text-sm text-gray-700">Jumlah Tiket Terkait Anak:</label>
                <input type="number"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    id="jumlah_terkait_anak" name="jumlah_terkait_anak" min="0" value="0">
                <x-input-error :messages="$errors->get('jumlah_terkait_anak')" class="mt-2" />
            </div>
        @endif

        @if ($relatedTicket->harga_dewasa > 0)
            <div class="w-full md:w-1/2 mb-3">
                <label for="jumlah_terkait_dewasa" class="block font-medium text-sm text-gray-700">Jumlah Tiket Terkait Dewasa:</label>
                <input type="number"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    id="jumlah_terkait_dewasa" name="jumlah_terkait_dewasa" min="0" value="0">
                <x-input-error :messages="$errors->get('jumlah_terkait_dewasa')" class="mt-2" />
            </div>
        @endif
    </div>
@endif



                        <div class="text-gray-700 mb-4 py-4">
                            <h4 class="font-bold mb-2">Syarat dan Ketentuan Berkunjung:</h4>
                            <ul class="list-disc pl-4">
                                <li>Menjaga kebersihan Taman Pintar</li>
                                <li>Mengikuti himbauan dan petunjuk petugas Taman Pintar</li>
                                <li>Tiket yang sudah dibayar tidak dapat dikembalikan <span
                                        class="text-red-600">(non-refundable)</span></li>
                            </ul>
                            <div class="flex items-center mt-2">
                                <input type="checkbox" id="syarat_dan_ketentuan" class="checkbox checkbox-accent">
                                <label for="syarat_dan_ketentuan" class="ml-2">Saya menyetujui syarat dan ketentuan
                                    di atas</label>
                            </div>
                            <div id="error-message" class="text-red-600 mt-2" style="display: none;">Silakan setujui syarat dan ketentuan terlebih dahulu.</div>
                        </div>

                        <div class="flex justify-center mb-4">
                            <button type="button" onclick="cekSimulasiHarga()"
                                class="text-center px-3 text-xs font-bold p-2 bg-teal-400 font-Poppins rounded text-white transition hover:scale-105">Cek
                                Simulasi Harga</button>
                        </div>

                        <div class="table-responsive md-6 mb-4">
                            <table class="table table-bordered w-full">
                                <thead>
                                    <tr>
                                        <th>Keterangan</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="tiket_anak_row" style="display: none;">
                                        <td>Tiket Anak</td>
                                        <td id="jumlah_anak_display">0</td>
                                        <td><span id="subtotal_anak">Rp 0</span></td>
                                        <td><span id="total_harga_anak">Rp 0</span></td>
                                    </tr>
                                    <tr id="tiket_dewasa_row" style="display: none;">
                                        <td>Tiket Dewasa</td>
                                        <td id="jumlah_dewasa_display">0</td>
                                        <td><span id="subtotal_dewasa">Rp 0</span></td>
                                        <td><span id="total_harga_dewasa">Rp 0</span></td>
                                    </tr>
                                    @if ($relatedTicket)
                                        <tr id="tiket_terkait_anak_row" style="display: none;">
                                            <td><span>{{ $relatedTicket->nama }}</span>Anak</td>
                                            <td id="jumlah_terkait_anak_display">0</td>
                                            <td><span id="harga_terkait_anak">Rp
                                                    {{ number_format($relatedTicket->harga_anak) }}</span></td>
                                            <td><span id="subtotal_terkait_anak">Rp 0</span></td>
                                        </tr>
                                        <tr id="tiket_terkait_dewasa_row" style="display: none;">
                                            <td><span>{{ $relatedTicket->nama }}</span>Dewasa</td>
                                            <td id="jumlah_terkait_dewasa_display">0</td>
                                            <td><span id="harga_terkait_dewasa">Rp
                                                    {{ number_format($relatedTicket->harga_dewasa) }}</span></td>
                                            <td><span id="subtotal_terkait_dewasa">Rp 0</span></td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th style="border-top: 2px solid black;">Total</th>
                                        <td style="border-top: 2px solid black;"></td>
                                        <td style="border-top: 2px solid black;"></td>
                                        <td style="border-top: 2px solid black;"><span id="total_harga">Rp 0</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" id="btn_lanjut_pembayaran"
                            class="block w-full rounded bg-teal-400 p-4 text-sm font-bold font-Poppins text-white transition hover:scale-105"
                            disabled>Lanjut Ke Pembayaran</button>

                        <!-- Modal -->
                        <div id="exitModal"
                            class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
                            <div class="bg-white p-6 rounded-lg">
                                <h2 class="text-lg font-bold mb-4">Konfirmasi Keluar</h2>
                                <p class="mb-4">Anda yakin ingin keluar dari halaman ini?</p>
                                <div class="flex justify-end">
                                    <button id="cancelButton"
                                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded mr-2">Batal</button>
                                    <button id="confirmButton"
                                        class="px-4 py-2 bg-red-600 text-white rounded">Keluar</button>
                                </div>
                            </div>
                        </div>

                        <script>
     function cekSimulasiHarga() {
    var jumlahAnakInput = document.getElementById('jumlah_anak');
    var jumlahDewasaInput = document.getElementById('jumlah_dewasa');
    var jumlahAnak = jumlahAnakInput ? parseInt(jumlahAnakInput.value) : 0;
    var jumlahDewasa = jumlahDewasaInput ? parseInt(jumlahDewasaInput.value) : 0;
    var hargaAnak = {{ $selectedTicket->harga_anak }};
    var hargaDewasa = {{ $selectedTicket->harga_dewasa }};
    var totalHargaTiket = jumlahAnak * hargaAnak + jumlahDewasa * hargaDewasa;
    var totalHargaTerkaitAnak = 0;
    var totalHargaTerkaitDewasa = 0;

    // Check if there is a related ticket
    @if ($relatedTicket)
        var jumlahTerkaitAnakInput = document.getElementById('jumlah_terkait_anak');
        var jumlahTerkaitDewasaInput = document.getElementById('jumlah_terkait_dewasa');
        var jumlahTerkaitAnak = jumlahTerkaitAnakInput ? parseInt(jumlahTerkaitAnakInput.value) : 0;
        var jumlahTerkaitDewasa = jumlahTerkaitDewasaInput ? parseInt(jumlahTerkaitDewasaInput.value) : 0;
        var hargaAnakTerkait = {{ $relatedTicket->harga_anak }};
        var hargaDewasaTerkait = {{ $relatedTicket->harga_dewasa }};
        totalHargaTerkaitAnak = jumlahTerkaitAnak * hargaAnakTerkait;
        totalHargaTerkaitDewasa = jumlahTerkaitDewasa * hargaDewasaTerkait;
    @endif

    // Bersihkan pesan kesalahan sebelumnya
    var errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(function(message) {
        message.remove();
    });

    // Hapus border merah sebelumnya
    if (jumlahAnakInput) jumlahAnakInput.style.borderColor = '';
    if (jumlahDewasaInput) jumlahDewasaInput.style.borderColor = '';

    // Validasi input
    if (jumlahAnak === 0 && jumlahDewasa === 0) {
        if (jumlahAnakInput) jumlahAnakInput.style.borderColor = 'red';
        if (jumlahDewasaInput) jumlahDewasaInput.style.borderColor = 'red';
        addErrorMessage(jumlahAnakInput || jumlahDewasaInput, 'Jumlah tiket masih kosong');
        return;
    }

    // Ubah tampilan tabel sesuai dengan jumlah tiket
    var tiketAnakRow = document.getElementById('tiket_anak_row');
    var tiketDewasaRow = document.getElementById('tiket_dewasa_row');
    if (jumlahAnak > 0) {
        tiketAnakRow.style.display = 'table-row';
    } else {
        tiketAnakRow.style.display = 'none';
    }
    if (jumlahDewasa > 0) {
        tiketDewasaRow.style.display = 'table-row';
    } else {
        tiketDewasaRow.style.display = 'none';
    }

    // Hitung subtotal dan total harga
    var subtotalAnak = jumlahAnak * hargaAnak;
    var subtotalDewasa = jumlahDewasa * hargaDewasa;
    var totalHarga = subtotalAnak + subtotalDewasa + totalHargaTerkaitAnak + totalHargaTerkaitDewasa;

    // Update informasi tiket terkait dalam tabel
     @if ($relatedTicket)
        var tiketTerkaitAnakRow = document.getElementById('tiket_terkait_anak_row');
        var tiketTerkaitDewasaRow = document.getElementById('tiket_terkait_dewasa_row');
        if (jumlahTerkaitAnak > 0) {
            tiketTerkaitAnakRow.style.display = 'table-row';
            document.getElementById('jumlah_terkait_anak_display').innerText = jumlahTerkaitAnak;
            document.getElementById('subtotal_terkait_anak').innerText = 'Rp ' + totalHargaTerkaitAnak.toLocaleString();
        } else {
            tiketTerkaitAnakRow.style.display = 'none';
        }
        if (jumlahTerkaitDewasa > 0) {
            tiketTerkaitDewasaRow.style.display = 'table-row';
            document.getElementById('jumlah_terkait_dewasa_display').innerText = jumlahTerkaitDewasa;
            document.getElementById('subtotal_terkait_dewasa').innerText = 'Rp ' + totalHargaTerkaitDewasa.toLocaleString();
        } else {
            tiketTerkaitDewasaRow.style.display = 'none';
        }
    @endif


    // Tampilkan total harga pada tabel
    document.getElementById('jumlah_anak_display').innerText = jumlahAnak;
    document.getElementById('jumlah_dewasa_display').innerText = jumlahDewasa;
    document.getElementById('total_harga_anak').innerText = 'Rp ' + subtotalAnak.toLocaleString();
    document.getElementById('total_harga_dewasa').innerText = 'Rp ' + subtotalDewasa.toLocaleString();
    document.getElementById('subtotal_anak').innerText = 'Rp ' + subtotalAnak.toLocaleString();
    document.getElementById('subtotal_dewasa').innerText = 'Rp ' + subtotalDewasa.toLocaleString();
    document.getElementById('total_harga').innerText = 'Rp ' + totalHarga.toLocaleString();
    document.getElementById('total_harga_input').value = totalHarga;
}

                            function addErrorMessage(inputElement, message) {
                                var errorMessage = document.createElement('div');
                                errorMessage.className = 'error-message';
                                errorMessage.style.color = 'red';
                                errorMessage.style.fontSize = '12px';
                                errorMessage.innerText = message;
                                inputElement.parentNode.appendChild(errorMessage);
                            }

                            document.addEventListener("DOMContentLoaded", function() {
                                var selectedDate = '{{ $selectedDate }}';
                                var tiketId = '{{ $selectedTicket->tiket_id }}';

                                // Fetch data kuota
                                fetch(`/tiket/kuota?tanggal=${selectedDate}&tiket_id=${tiketId}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.kuota !== undefined && data.nama !== undefined) {
                                            var sisaKuotaElement = document.getElementById('sisa-kuota');
                                            sisaKuotaElement.textContent = 'Sisa Kuota: ' + data.kuota + ' tiket';
                                        } else {
                                            console.error('Data kuota tidak ditemukan atau tidak lengkap:', data);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error fetching kuota:', error);
                                    });
                            });

                            var checkboxSyarat = document.getElementById('syarat_dan_ketentuan');
                            var btnLanjutPembayaran = document.getElementById('btn_lanjut_pembayaran');
                            var errorMessage = document.getElementById('error-message');

                            checkboxSyarat.addEventListener('change', function() {
                                btnLanjutPembayaran.disabled = !this.checked;
                                if (this.checked) {
                                    errorMessage.style.display = 'none';
                                }
                            });


                            btnLanjutPembayaran.addEventListener('click', function() {
                                var jumlahAnak = document.getElementById('jumlah_anak').value;
                                var jumlahDewasa = document.getElementById('jumlah_dewasa').value;

                                if (!checkboxSyarat.checked) {
                                    errorMessageSyarat.style.display = 'block';
                                } else if (jumlahAnak == 0 && jumlahDewasa == 0) {
                                    errorMessageJumlah.style.display = 'block';
                                } else {
                                    // Submit form jika semua valid
                                    document.querySelector('form').submit();
                                }
                            });
                        </script>



</x-app-layout>