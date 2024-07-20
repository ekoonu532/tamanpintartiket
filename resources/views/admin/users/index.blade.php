@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4">
            <h2 class="text-xl font-semibold text-gray-800">
                <i class="fa-solid fa-users mr-2"></i>Pengguna
            </h2>
            <div class="mt-4">
                <!-- Formulir Pencarian -->
                <form method="GET" action="{{ route('admin.users.index') }}" class="w-full md:w-1/2 lg:w-1/4 justify-center mb-4 flex space-x-2">
                    <input type="text" name="search" placeholder="Cari pengguna..." value="{{ request('search') }}" class="px-4 py-2 border rounded w-full">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Cari</button>
                </form>

                <!-- Tabel Pengguna -->
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->role }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button class="btn text-blue-600 hover:text-blue-900 detail-button" data-id="{{ $user->id }}">Detail</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Pengguna tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="detailModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">
                                User Detail
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="modalContent">
                                    <!-- Detail content will be inserted here -->
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm close-button">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const detailButtons = document.querySelectorAll('.detail-button');
            const modal = document.getElementById('detailModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');
            const closeButton = document.querySelector('.close-button');

            detailButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const userId = button.getAttribute('data-id');
                    fetch(`/admin/users/${userId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                modalTitle.textContent = 'Error';
                                modalContent.innerHTML = '<p>User not found</p>';
                            } else {
                                modalTitle.textContent = `Detail User: ${data.name}`;
                                modalContent.innerHTML = `
                                    <p><strong>ID:</strong> ${data.id}</p>
                                    <p><strong>Name:</strong> ${data.name}</p>
                                    <p><strong>Email:</strong> ${data.email}</p>
                                    <p><strong>Role:</strong> ${data.role}</p>
                                `;
                            }
                            modal.classList.remove('hidden');
                        });
                });
            });

            closeButton.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            window.addEventListener('click', (event) => {
                if (event.target == modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
