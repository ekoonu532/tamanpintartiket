<x-app-layout>
    <x-slot name="title">
        Pembayaran Tiket Sukses
    </x-slot>
    <div class="min-h-screen max-w-7xl mx-auto py-16 flex items-center justify-center">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Pembayaran Sukses</h1>
                <p class="text-gray-600">Terima kasih, pembayaran Anda Berhasil. Kode Pembelian Anda adalah: <strong>{{ $pembelian->kode_pembelian }}</strong></p>
                <a href="{{ route('dashboard') }}" class="mt-4 inline-block text-center px-4 py-2 bg-teal-500 text-white rounded hover:bg-teal-600">Kembali ke Beranda</a>
                <a href="{{ route('ticket.show', ['id' => $pembelian->id]) }}"
                    class="mt-4 inline-block text-center px-4 py-2 bg-white border border-teal-400 text-teal-400 rounded hover:bg-teal-600 hover:text-white">Lihat tiket</a>
            </div>
        </div>
    </div>

</x-app-layout>
