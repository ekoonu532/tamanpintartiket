<x-app-layout>
    <x-slot name="title">
        Tiket Saya
    </x-slot>

    <div class="min-h-screen py-16 items-center justify-center">
        <div class="max-w-7xl mx-auto px-4 py-4 justify-center">
            <h1 class="text-2xl font-bold mt-5 mb-5 text-center">Riwayat Pembelian Tiket</h1>

            @if($unusedTickets->isEmpty() && $expiredTickets->isEmpty())
                <p>Anda belum memiliki riwayat pembelian tiket.</p>
            @else
                <h2 class="text-xl font-bold mt-5 mb-5">Tiket Belum Digunakan</h2>
                <div class="space-y-4 mb-4">
                    @foreach($unusedTickets as $pembelian)
                        <div class="bg-white shadow-md rounded-lg p-4">
                            <a href="{{ route('ticket.show', ['id' => $pembelian->id]) }}" class="block">
                                <h2 class="text-xl font-semibold mb-2">Kode: {{ $pembelian->kode_pembelian }}</h2>
                                <p><strong>Status:</strong> {{ $pembelian->status_pembayaran }}</p>
                                <p><strong>Total:</strong> Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</p>
                            </a>
                            <div class="mt-4 space-y-2">
                                @foreach($pembelian->detailPembelianTikets as $detail)
                                    <div class="flex items-center bg-gray-100 p-2 rounded-lg">
                                        <img src="{{ asset('storage/' . $detail->tiket->gambar) }}" alt="{{ $detail->tiket->nama }}" class="w-16 h-16 object-contain rounded-lg mr-4">
                                        <div>
                                            <h3 class="text-md font-medium">{{ $detail->tiket->nama }}</h3>
                                            <p><strong>Kategori:</strong> {{ $detail->tiket->kategoriTiket->nama }}</p>
                                            <p><strong>Jenis Tiket:</strong> {{ $detail->keterangan }}</p>
                                            <p><strong>Jumlah:</strong> {{ $detail->jumlah }}</p>
                                            <p><strong>Tanggal Kunjungan:</strong> {{ $detail->tanggal_kunjungan }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <h2 class="text-xl font-bold mt-5 mb-5">Tiket Melewati Batas Tanggal Kunjungan</h2>
                <div class="space-y-4 mb-4">
                    @foreach($expiredTickets as $pembelian)
                        <div class="bg-gray-200 shadow-md rounded-lg p-4">
                            <a href="{{ route('ticket.show', ['id' => $pembelian->id]) }}" class="block">
                                <h2 class="text-xl font-semibold mb-2">Kode: {{ $pembelian->kode_pembelian }}</h2>
                                <p><strong>Status:</strong> {{ $pembelian->status_pembayaran }}</p>
                                <p><strong>Total:</strong> Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</p>
                            </a>
                            <div class="mt-4 space-y-2">
                                @foreach($pembelian->detailPembelianTikets as $detail)
                                    <div class="flex items-center bg-gray-100 p-2 rounded-lg">
                                        <img src="{{ asset('storage/' . $detail->tiket->gambar) }}" alt="{{ $detail->tiket->nama }}" class="w-16 h-16 object-contain rounded-lg mr-4">
                                        <div>
                                            <h3 class="text-md font-medium">{{ $detail->tiket->nama }}</h3>
                                            <p><strong>Kategori:</strong> {{ $detail->tiket->kategoriTiket->nama }}</p>
                                            <p><strong>Jenis tiket:</strong> {{ $detail->keterangan }}</p>
                                            <p><strong>Jumlah:</strong> {{ $detail->jumlah }}</p>
                                            <p><strong>Tanggal Kunjungan:</strong> {{ $detail->tanggal_kunjungan }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
