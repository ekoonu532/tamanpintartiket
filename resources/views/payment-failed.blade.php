<x-app-layout>
    <x-slot name="title">
        Pembayaran Gagal
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="min-h-screen py-16 flex items-center justify-center">
                <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center">
                    <h2 class="mb-4 text-2xl font-bold font-Poppins text-red-600">Pembayaran Gagal</h2>
                    <p class="font-Poppins font-bold text-gray-800">Maaf, pembayaran Anda gagal. Karena melebihi batas waktu pembayaran Silakan coba lagi.</p>
                    <a href="{{ route('profile.pesanan') }}" class="mt-4 bg-teal-500 text-white px-4 py-2 rounded-md transition hover:bg-teal-600">Kembali ke Pesanan Saya</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
