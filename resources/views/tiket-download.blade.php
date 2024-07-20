<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiket Pembelian</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .ticket {
            width: 300px;
            margin: 20px auto;
            padding: 10px;
            border: 2px dashed #333;
            border-radius: 8px;
            background-color: #fff;
        }
        .ticket .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .ticket .header img {
            height: 50px;
        }
        .ticket h3 {
            color: #38b2ac;
            margin: 10px 0;
        }
        .ticket .details {
            margin-bottom: 10px;
        }
        .ticket .details p {
            margin: 4px 0;
            font-size: 14px;
        }
        .ticket .details p strong {
            color: #2c5282;
        }
        .ticket .qr-code {
            text-align: center;
            margin-top: 10px;
        }
        .ticket .qr-code svg {
            max-width: 100px;
            height: 100px;
        }
        .ticket table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }
        .ticket table, .ticket th, .ticket td {
            border: 1px solid #ddd;
        }
        .ticket th, .ticket td {
            padding: 6px;
            text-align: left;
        }
        .ticket th {
            background-color: #f7fafc;
        }
        .ticket .footer {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 12px;
        }
        .ticket .footer p {
            margin: 4px 0;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <img src="{{ asset('img/logo.png') }}" alt="logo">
            <h3>Tiket Pembelian</h3>
        </div>
        <div class="details">
            <p><strong>Kode Pembelian:</strong> {{ $pembelian->kode_pembelian }}</p>
            <p><strong>Total Harga:</strong> Rp.{{ number_format($pembelian->total_harga) }}</p>
            <p><strong>Tanggal Kunjungan:</strong> {{ $detailPembelian->tanggal_kunjungan }}</p>
        </div>
        <div class="qr-code">
            <h4>Scan QR Code:</h4>
            {!! $qrCodeSvg !!}
        </div>
        <h4>Detail Tiket</h4>
        <table>
            <thead>
                <tr>
                    <th>Nama Tiket</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $detailPembelian->keterangan }}</td>
                    <td>{{ $detailPembelian->jumlah }}</td>
                </tr>
            </tbody>
        </table>
        <div class="footer">
            <h4>Keterangan Penggunaan Tiket</h4>
            <p>1. Tiket ini hanya berlaku pada tanggal kunjungan yang tertera.</p>
            <p>2. Harap membawa tiket ini saat kunjungan.</p>
            <p>3. Tunjukkan tiket ini di pintu masuk.</p>
            <p>4. Tiket tidak dapat dipindahtangankan atau diuangkan kembali.</p>
            <p>5. Patuhi semua peraturan yang berlaku di lokasi kunjungan.</p>
        </div>
    </div>
</body>
</html>
