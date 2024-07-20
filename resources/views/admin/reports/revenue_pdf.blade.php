<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Revenue Report</title>
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
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px; /* Sesuaikan ukuran logo sesuai kebutuhan */
        }

        .report-info {
            text-align: right;
        }
    </style>
</head>
<body>
    <!-- Header with logo and report info -->
    <div class="header">
        <img src="{{ asset('img/logo.png') }}" alt="logo" class="logo">
        <div class="report-info">
            <h1>Laporan Pendapatan</h1>
            <!-- Print filter information -->
            <div>
                <p><strong>Keterangan Filter:</strong></p>
                <p><strong>Bulan:</strong> {{ $month ? \Carbon\Carbon::create()->month($month)->format('F') : 'Semua' }}</p>
                <p><strong>Tahun:</strong> {{ $year ? $year : 'Semua' }}</p>
                <p><strong>Kategori:</strong> {{ $kategori ? $kategori : 'Semua' }}</p>
            </div>
        </div>
    </div>

    <!-- Revenue Data Table -->
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Kategori</th>
                <th>Jumlah Tiket Terjual</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueData as $data)
                <tr>
                    <td>{{ $data->month }}</td>
                    <td>{{ $data->kategori }}</td>
                    <td>{{ $data->total_sold }}</td>
                    <td>Rp. {{ number_format($data->total_revenue) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
