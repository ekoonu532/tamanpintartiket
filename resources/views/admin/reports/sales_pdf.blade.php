<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report</title>
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
            <h1>Laporan Penjualan Tiket</h1>
            <!-- Print filter information -->
            <div>
                <p><strong>Filter Information:</strong></p>
                <p><strong>Bulan:</strong> {{ $month ? \Carbon\Carbon::create()->month($month)->format('F') : 'Semua' }}</p>
                <p><strong>Tahun:</strong> {{ $year ? $year : 'Semua' }}</p>
                <p><strong>Kategori:</strong> {{ $kategori ? $kategori : 'Semua' }}</p>
                <p><strong>Nama Tiket:</strong> {{ $namaTiket ? $namaTiket : 'Semua' }}</p>
            </div>
        </div>
    </div>

    <!-- Sales report table -->
    <table>
        <thead>
            <tr>
                <th>Nama Tiket</th>
                <th>Kategori Tiket</th>
                <th>Jumlah Terjual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesData as $data)
                <tr>
                    <td>{{ $data->nama_tiket }}</td>
                    <td>{{ $data->nama_kategori }}</td>
                    <td>{{ $data->total_sold }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
