<!-- resources/views/kontak-kami.blade.php -->
<x-app-layout>
    <x-slot name="title">
        Kontak Kami
    </x-slot>
    <div class="min-h-screen py-16 flex items-center justify-center bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8 mt-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-3xl text-center font-bold mb-8">Kontak Kami</h1>
                <p class="text-center mb-8 text-gray-600">Kami ingin mendengar masukan dan saran dari Anda. Silakan isi formulir di bawah ini untuk mengirimkan feedback Anda.</p>
                <form method="POST" action="" class="max-w-lg mx-auto">
                    {{-- {{ route('feedback.submit') }} --}}
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                        <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Pesan:</label>
                        <textarea id="message" name="message" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
