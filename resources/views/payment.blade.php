<x-app-layout>
    <x-slot name="title">
        Pembayaran Tiket
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="min-h-screen py-16 flex items-center justify-center">
                <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center">
                    <h2 class="mb-4 text-2xl font-bold font-Poppins text-gray-800">Pembayaran Tiket</h2>
                    <p class="font-Poppins font-bold">Kode Pembelian: {{ $pembelian->kode_pembelian }}</p>
                    {{-- <p class="font-Poppins font-bold">Tanggal Kunjungan: {{ $pembelian->detailPembelian->tanggal_kunjungan }}</p> --}}
                    <p class="font-Poppins font-bold">Total Harga: Rp {{ number_format($pembelian->total_harga, 2) }}</p>

                    @if (Carbon\Carbon::now()->greaterThan($pembelian->expired_at))
                        <div class="text-red-500 font-Poppins mt-4">
                            Pesanan ini sudah kedaluwarsa. Silakan lakukan pemesanan ulang.
                        </div>
                    @else
                    <div class="mt-4">
                        <p class="text-lg text-red-500 font-Poppins">Silakan lakukan pembayaran dalam waktu:</p>
                        <div id="timer" class="text-2xl text-center font-bold"></div>
                    </div>
                    <div class="w-full mt-6">
                        <h3 class="text-lg font-semibold font-Poppins ml-6 text-gray-800 mb-2">Detail Pesanan</h3>
                        <div class="overflow-x-auto mt-4">
                            <table class="min-w-full bg-white divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tiket</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kunjungan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($detailPembelian as $detail)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->keterangan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->jumlah }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->tanggal_kunjungan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($detail->harga_satuan, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($detail->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button id="pay-button" class="bg-teal-500 text-white px-4 py-2 rounded-md transition hover:bg-teal-600">Bayar</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    console.log(result);
                    alert('Pembayaran sukses!');
                    window.location.href = '{{ route('payment.success', $pembelian->kode_pembelian) }}';
                },
                onPending: function(result) {
                    console.log(result);
                    alert('Pembayaran pending!');
                },
                onError: function(result) {
                    console.log(result);
                    alert('Pembayaran gagal!');
                    window.location.href = '{{ route('payment.failed') }}';
                },
                onClose: function() {
                    console.log('Pembayaran dibatalkan!');
                }
            });
        };

        // Timer countdown
        const expiredAt = new Date('{{ \Carbon\Carbon::parse($pembelian->expired_at)->toIso8601String() }}').getTime();
        const timerElement = document.getElementById('timer');

        function updateTimer() {
            const now = new Date().getTime();
            const distance = expiredAt - now;

            if (distance < 0) {
                clearInterval(timerInterval);
                timerElement.innerHTML = "Waktu pembayaran habis";
                window.location.href = '{{ route('payment.failed') }}';
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            timerElement.innerHTML = `${minutes}m ${seconds}s`;
        }

        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer(); // Initial call to set the timer immediately
    </script>
</x-app-layout>
