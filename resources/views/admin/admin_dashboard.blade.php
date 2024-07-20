@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4">
        <h2 class="text-xl font-semibold text-gray-800"><i class="fa-sharp fa-solid fa-gauge mr-2"></i>Dashboard</h2>
        
        <!-- Summary Data -->
        
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Total Users -->
            <div class="bg-gray-100 p-4 md:p-6 lg:p-8 rounded-lg shadow flex items-center">
                <i class="fa-solid fa-users mr-4 fa-2xl"></i>
                <div class="flex flex-col">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Jumlah Pengguna</h3>
                    <h1 class="text-4xl font-bold text-teal-400">{{ $totalUsers }}</h1>
                </div>
            </div>
            <!-- Total Tickets Sold -->
            <div class="bg-gray-100 p-4 md:p-6 lg:p-8 rounded-lg shadow flex items-center">
                <i class="fa-solid fa-ticket mr-4 fa-2xl"></i>
                <div class="flex flex-col">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Jumlah Tiket Terjual</h3>
                    <h1 class="text-4xl font-bold text-teal-400">{{ $totalSoldTickets }}</h1>
                </div>
            </div>
            <!-- Total Revenue -->
            <div class="bg-gray-100 p-4 md:p-6 lg:p-8 rounded-lg shadow flex items-center">
                <i class="fa-solid fa-dollar-sign mr-4 fa-2xl"></i>
                <div class="flex flex-col">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Pendapatan</h3>
                    <h1 class="text-4xl font-bold text-teal-400">Rp.{{ number_format($totalRevenue) }}</h1>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="mt-8 bg-gray-100 p-4 md:p-6 lg:p-8 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Transaksi Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">Nama Pengguna</th>
                            <th class="px-4 py-2 text-left">Jumlah Tiket</th>
                            <th class="px-4 py-2 text-left">Total Harga</th>
                            <th class="px-4 py-2 text-left">Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                        <tr class="{{ $transaction->status_pembayaran == 'success' ? 'bg-green-100 text-green-800' : ($transaction->status_pembayaran == 'pending' ? 'bg-yellow-100 text-yellow-800' : '') }}">
                            <td class="border px-4 py-2">{{ $transaction->user->name }}</td>
                            <td class="border px-4 py-2">{{ $transaction->jumlah_tiket }}</td>
                            <td class="border px-4 py-2">Rp.{{ number_format($transaction->total_harga) }}</td>
                            <td class="border px-4 py-2">{{ $transaction->status_pembayaran }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Charts -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Tickets Sold Chart -->
            <div class="bg-gray-100 p-4 md:p-6 lg:p-8 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tiket Terjual Seiring Waktu</h3>
                <canvas id="ticketsSoldChart"></canvas>
            </div>
            <!-- Revenue Chart -->
            <div class="bg-gray-100 p-4 md:p-6 lg:p-8 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan Seiring Waktu</h3>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        
        <!-- Best Selling Tickets -->
        <div class="mt-8 bg-gray-100 p-4 md:p-6 lg:p-8 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Best Selling Tickets</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($bestSellingTickets as $ticket)
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">{{ $ticket->nama }}</h4>
                        <p class="text-gray-600">{{ $ticket->total_sold }} sold</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ticketsSoldCtx = document.getElementById('ticketsSoldChart').getContext('2d');
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');

        const ticketsSoldData = @json($ticketsSoldData);
        const revenueData = @json($revenueData);

        new Chart(ticketsSoldCtx, {
            type: 'line',
            data: {
                labels: ticketsSoldData.labels,
                datasets: [{
                    label: 'Tiket Terjual',
                    data: ticketsSoldData.data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: revenueData.data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
