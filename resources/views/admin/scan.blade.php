@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Scan Tiket</h1>

    <!-- Pesan Sukses -->
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pesan Error -->
    @if (session('error'))
        <div class="bg-red-500 text-white p-4 mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Area Scanner -->
    <div id="scanner" class="border border-gray-300 p-4 mb-4">
        <video id="preview"></video>
    </div>

    <!-- Form Tersembunyi -->
    <form id="scanForm" action="{{ route('admin.scan.process') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="qrCodeData" id="qrCodeData">
    </form>

    <!-- Pesan Error Kamera -->
    <div id="cameraError" class="bg-red-500 text-white p-4 mb-4 hidden">
        Kamera tidak ditemukan atau tidak dapat diakses.
    </div>
</div>

<!-- Tambahkan CDN Instascan -->
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });
        let cameraError = document.getElementById('cameraError');

        scanner.addListener('scan', function (content) {
            document.getElementById('qrCodeData').value = content;
            document.getElementById('scanForm').submit();
        });

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                let selectedCamera = cameras[0]; // Default to the first camera

                // Try to find the back camera
                cameras.forEach(function(camera) {
                    if (camera.name.toLowerCase().includes('back')) {
                        selectedCamera = camera;
                    }
                });

                scanner.start(selectedCamera).catch(function (e) {
                    cameraError.classList.remove('hidden');
                    console.error('Failed to start scanner: ', e);
                });
            } else {
                cameraError.classList.remove('hidden');
                console.error('No cameras found.');
            }
        }).catch(function (e) {
            cameraError.classList.remove('hidden');
            console.error('Error finding cameras: ', e);
        });
    });
</script>
@endsection
