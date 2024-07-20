@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl my-4 mx-auto font-bold font-Poppins text-gray-900 mt-4">Laporan Transaksi</h1>

    <!-- Form Filter -->
    <form action="{{ route('admin.transactions.filter') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Semua</option>
                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
        </div>
        <div class="flex items-end mt-4">
            <button type="submit" class="py-2 px-4 bg-indigo-600 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Filter</button>
        </div>
    </form>

    <form action="{{ route('admin.reports.transactions.export-pdf') }}" method="GET" class="py-2" target="_blank">
        <input type="hidden" name="month" value="{{ request('month') }}">
        <input type="hidden" name="year" value="{{ request('year') }}">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-file-export"></i>Export PDF</button>
    </form>

    <div class="table-responsive">
    <table class="min-w-full bg-white divide-y divide-gray-200 mt-4">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengguna</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Pembelian</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tiket</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Tiket</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sub Total</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Tiket</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pembayaran</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kunjungan</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($transactions as $transaction)
                @foreach($transaction->detailPembelianTikets as $detail)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->kode_pembelian }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->keterangan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->jumlah }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp.{{ number_format($detail->subtotal) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->status_pembayaran }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->tanggal_kunjungan }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    </div>
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
@endsection
