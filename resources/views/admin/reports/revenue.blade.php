@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-2xl my-4 mx-auto font-bold font-Poppins text-gray-900 mt-4">Laporan Pendapatan</h2>
    
    <div class="bg-gray-100 p-8 rounded-lg shadow w-full mb-4 md:w-3/4 mx-auto">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan Seiring Waktu</h3>
        <div class="w-1/2 h-64 mx-auto">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.reports.revenue') }}" class="mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700">Bulan</label>
                <select id="month" name="month" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Semua</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                <select id="year" name="year" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Semua</option>
                    @foreach(range(date('Y'), date('Y') - 10) as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="kategori" name="kategori" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Semua</option>
                    @foreach($kategoriTiket as $kategori)
                        <option value="{{ $kategori->kategori_tiket_id }}" {{ request('kategori') == $kategori->kategori_tiket_id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            {{-- <div>
                <label for="nama_tiket" class="block text-sm font-medium text-gray-700">Nama Tiket</label>
                <input type="text" id="nama_tiket" name="nama_tiket" value="{{ request('nama_tiket') }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div> --}}
        </div>
        <div class="mt-4">
            <button type="submit" class="py-2 px-4 bg-indigo-600 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Filter</button>
        </div>
    </form>
    <form action="{{ route('admin.reports.revenue.export-pdf') }}" method="GET" class="py-3" target="_blank">
        <input type="hidden" name="month" value="{{ request('month') }}">
        <input type="hidden" name="year" value="{{ request('year') }}">
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-file-export"></i>Export PDF</button>
    </form>

    <!-- Revenue Data Table -->
    <table class="min-w-full bg-white divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Tiket Terjual</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($revenueData as $data)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $data->month }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $data->kategori }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $data->total_sold }}</td>
                <td class="px-6 py-4 whitespace-nowrap">Rp. {{ number_format($data->total_revenue) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $revenueData->links() }}
    </div>
</div>
<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyRevenueData = @json($monthlyRevenueData);
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyRevenueData.labels,
            datasets: [{
                label: 'Total Pendapatan',
                data: monthlyRevenueData.data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
});
</script>
@endsection
