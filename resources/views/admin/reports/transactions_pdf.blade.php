<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction Report</title>
    <style>
        /* Add some basic styling for the PDF */
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            display: flex;
            align-items: center; /* Mengatur vertikal ke tengah */
            margin-bottom: 20px;
        }

        .logo {
            width: 100px; /* Sesuaikan ukuran logo sesuai kebutuhan */
            margin-right: 20px; /* Jarak antara logo dan teks */
        }

        .report-info {
            flex-grow: 1; /* Menyebarkan ruang kosong di antara logo dan teks */
            text-align: right;
        }
    </style>
</head>
<body>
    <!-- Header with logo and report info -->
    <div class="header">
        <img src="{{ asset('img/logo.png') }}" alt="logo" class="logo">
        <div class="report-info">
            <h1>Laporan Transaksi</h1>
            <!-- Print filter information -->
            <div>
                <p><strong>Filter Information:</strong></p>
                <p><strong>Bulan:</strong> {{  $month ? \Carbon\Carbon::create()->month($month)->format('F'): 'Semua' }}</p>
                <!-- -->
                <p><strong>Tahun:</strong> {{ $year ? $year : 'Semua' }}</p>
                <p><strong>Status:</strong> {{ $status ? ucfirst($status) : 'Semua' }}</p>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Ticket</th>
                <th>Jumlah Tiket</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                @foreach($transaction->detailPembelianTikets as $detail)
                    <tr>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $detail->keterangan }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>{{ $transaction->total_harga }}</td>
                        <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
