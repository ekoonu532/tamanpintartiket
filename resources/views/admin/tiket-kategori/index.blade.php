@extends('layouts.admin')

@section('content')
@if (session('success'))
        <div id="successAlert" role="alert" class="alert alert-success flex justify-between items-center bg-green-500 text-white font-bold p-4 rounded-lg mb-4">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button class="text-white font-bold" onclick="document.getElementById('successAlert').style.display='none'">X</button>
        </div>
    @endif
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4">
            <h1 class="text-xl font-semibold text-gray-800"><i class="fa-solid fa-layer-group mr-2"></i>Kategori Tiket</h1>
            <div class="mt-4">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            <!-- Add more columns here if needed -->
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($kategori as $category)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $category->kategori_tiket_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $category->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $category->deskripsi}}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.ticket-categories.edit',  $category->kategori_tiket_id) }}"
                                        class="btn text-yellow-600 hover:text-yellow-900 ml-2">Edit</a>
                                </td>
                                <!-- Add more columns here if needed --
                                <!-- Add more columns here if needed -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
