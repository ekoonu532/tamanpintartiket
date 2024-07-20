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
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold font-Poppins text-gray-800"><i class="fa-solid fa-ticket mr-2"></i>Tiket</h1>
                <form method="GET" action="{{ route('admin.tickets.search') }}" class="flex">
                    <input type="text" name="search" placeholder="Cari tiket..." class="px-4 py-2 border rounded-lg" value="{{ request('search') }}">
                    <button type="submit" class="ml-2 bg-blue-600 text-white px-4 py-2 rounded-lg">Cari</button>
                </form>
                <a href="{{ route('admin.tickets.create') }}" class="btn text-blue-600 hover:text-blue-900 ml-2">Tambah Tiket</a>
            </div>
        </div>

        <div class="mt-4">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Anak</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Dewasa</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ticket->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ticket->kategoriTiket->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp.{{ $ticket->harga_anak != 0 ? number_format($ticket->harga_anak) : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp.{{ $ticket->harga_dewasa != 0 ? number_format($ticket->harga_dewasa) : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button class="btn text-blue-600 hover:text-blue-900" onclick="showTicketDetails('{{ $ticket->tiket_id }}')">Detail</button>
                                <a href="{{ route('admin.tickets.edit', $ticket->tiket_id) }}" class="btn text-yellow-600 hover:text-yellow-900 ml-2">Edit</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="toggle toggle-accent" {{ $ticket->status == 'aktif' ? 'checked' : '' }} data-id="{{ $ticket->tiket_id }}" onchange="toggleTicketStatus(this)">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $tickets->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>

    <div id="ticketDetailModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden w-3/4 md:w-1/2">
            <div class="px-6 py-4 border-b border-gray-200">
                <h5 class="text-xl font-semibold" id="ticketDetailModalLabel">Detail Tiket</h5>
                <button type="button" class="text-gray-500 hover:text-gray-700 float-right" onclick="closeModal()">×</button>
            </div>
            <div class="p-6" id="ticket-details">
                <!-- Detail tiket akan ditampilkan di sini -->
            </div>
            <div class="px-6 py-4 border-t border-gray-200 text-right">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        function showTicketDetails(ticketId) {
            console.log("Ticket ID:", ticketId); // Debugging
            fetch(`/admin/tickets/${ticketId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById('ticket-details').innerText = data.error;
                    } else {
                        let ticketDetails = `
                            <strong>Nama:</strong> ${data.nama}<br>
                            <strong>Deskripsi:</strong> ${data.deskripsi}<br>
                            <strong>Tanggal Mulai:</strong> ${data.tanggal_mulai}<br>
                            <strong>Tanggal Selesai:</strong> ${data.tanggal_selesai}<br>
                            <strong>Harga Anak:</strong> ${data.harga_anak}<br>
                            <strong>Harga Dewasa:</strong> ${data.harga_dewasa}<br>
                            <strong>Kuota:</strong> ${data.kuota}<br>
                            <strong>Usia Minimal:</strong> ${data.usia_minimal}<br>
                            <strong>Status:</strong> ${data.status}<br>
                        `;
                        document.getElementById('ticket-details').innerHTML = ticketDetails;
                    }
                    document.getElementById('ticketDetailModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('ticket-details').innerText = 'Error loading ticket details.';
                });
        }

        function closeModal() {
            document.getElementById('ticketDetailModal').classList.add('hidden');
        }

        function toggleTicketStatus(checkbox) {
            const ticketId = checkbox.getAttribute('data-id');
            const status = checkbox.checked ? 'aktif' : 'tidak aktif';

            fetch(`/admin/tickets/${ticketId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: status,
                        _method: 'PUT'
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        alert('Status tiket berhasil diperbarui');
                        checkbox.checked = status === 'aktif';
                    } else {
                        alert('Gagal memperbarui status tiket');
                        checkbox.checked = !checkbox.checked;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui status tiket');
                    checkbox.checked = !checkbox.checked;
                });
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            const checkboxes = document.querySelectorAll('.toggle');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    toggleTicketStatus(this);
                });
            });
        });
    </script>
@endsection
