<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Saya') }}
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

            <div class="space-y-6 lg:col-span-3 order-1 lg:order-2">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <nav class="flex flex-wrap space-x-2 mb-4 sm:order-1 order-2">
                        <a href="{{ route('profile.pesanan', ['status' => 'all']) }}"
                            class="inline-block bg-{{ $status == 'all' ? 'teal-400 text-white font-bold' : 'white text-gray-900' }} border border-{{ $status == 'all' ? 'white' : 'gray-900' }} font-bold rounded-full py-2 px-4 transition duration-300 ease-in-out hover:bg-teal-400 hover:text-white hover:border-teal-400">{{ __('Semua') }}</a>
                        <a href="{{ route('profile.pesanan', ['status' => 'pending']) }}"
                            class="inline-block bg-{{ $status == 'pending' ? 'teal-400 text-white font-bold' : 'white text-gray-900' }} border border-{{ $status == 'pending' ? 'white' : 'gray-900' }} font-bold rounded-full py-2 px-4 transition duration-300 ease-in-out hover:bg-teal-400 hover:text-white hover:border-teal-400">{{ __('Belum Bayar') }}</a>
                        <a href="{{ route('profile.pesanan', ['status' => 'success']) }}"
                            class="inline-block bg-{{ $status == 'success' ? 'teal-400 text-white font-bold' : 'white text-gray-900' }} border border-{{ $status == 'success' ? 'white' : 'gray-900' }} font-bold rounded-full py-2 px-4 transition duration-300 ease-in-out hover:bg-teal-400 hover:text-white hover:border-teal-400">{{ __('Selesai') }}</a>
                        <a href="{{ route('profile.pesanan', ['status' => 'failed']) }}"
                            class="inline-block bg-{{ $status == 'failed' ? 'teal-400 text-white font-bold' : 'white text-gray-900' }} border border-{{ $status == 'failed' ? 'white' : 'gray-900' }} font-bold rounded-full py-2 px-4 transition duration-300 ease-in-out hover:bg-teal-400 hover:text-white hover:border-teal-400">{{ __('Gagal') }}</a>
                    </nav>

                    <h3 class="text-lg font-medium text-gray-900">{{ __('Daftar Pesanan') }}</h3>
                    <div class="overflow-x-auto mt-4 sm:order-2 order-1">
                        <table class="min-w-full bg-white divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Kode Pembelian') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Tanggal Pembelian') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Total Harga') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status Pembayaran') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Aksi') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Sisa Waktu') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($orders as $index => $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->kode_pembelian }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp.{{ number_format($order->total_harga) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->status_pembayaran }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($order->status_pembayaran === 'pending')
                                                <a href="{{ route('payment.page', ['kode_pembelian' => $order->kode_pembelian]) }}" class="text-blue-500 hover:underline">Ke Pembayaran</a>
                                            @elseif($order->status_pembayaran === 'success')
                                                <a href="{{ route('ticket.show', ['id' => $order->id]) }}" class="text-green-500 hover:underline">Lihat Tiket</a>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($order->status_pembayaran === 'pending')
                                                <div id="timer-{{ $order->kode_pembelian }}" class="text-red-500"></div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap" colspan="7">{{ __('Tidak ada pesanan yang ditemukan.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 sm:order-3 order-2">{{ $orders->links('vendor.pagination.tailwind') }}</div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function startOrderTimer(expiredAt, display) {
            const updateTimer = () => {
                const now = new Date().getTime();
                const distance = expiredAt - now;

                if (distance < 0) {
                    display.textContent = "00:00";
                    clearInterval(timerInterval);
                    return;
                }

                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                display.textContent = `${minutes}m ${seconds}s`;
            };

            const timerInterval = setInterval(updateTimer, 1000);
            updateTimer(); // Initial call to set the timer immediately
        }

        @foreach ($orders as $order)
            @if ($order->status_pembayaran === 'pending')
                const expiredAt = new Date("{{ \Carbon\Carbon::parse($order->expired_at)->toIso8601String() }}").getTime();
                const display = document.getElementById('timer-{{ $order->kode_pembelian }}');
                startOrderTimer(expiredAt, display);
            @endif
        @endforeach
    </script>
</x-app-layout>
