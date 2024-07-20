<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Tiket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-4 shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Detail Pembelian Tiket</h3>
                    <p>Kode Pembelian: {{ $pembelian->kode_pembelian }}</p>
                    <p>Total Harga: Rp.{{ number_format($pembelian->total_harga) }}</p>
                    <h4 class="text-md font-medium text-gray-900 mt-4">Detail Tiket</h4>
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full bg-white divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tiket</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori Tiket</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kunjungan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Download</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($detailPembelian as $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->keterangan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->tiket->kategoriTiket->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->jumlah }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->tanggal_kunjungan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('ticket.download', ['id' => $pembelian->id, 'detailId' => $detail->id]) }}" target="_blank" class="inline-block bg-teal-500 text-white font-bold py-2 px-4 rounded hover:bg-teal-700">
                                                <i class="fas fa-download mr-2"></i> Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-end mr-6 mt-4">
                        @php
                            $routeName = '';
                            $slug = '';
                            if ($detail->tiket) {
                                if ($detail->tiket->kategoriTiket) {
                                    $kategoriNama = $detail->tiket->kategoriTiket->nama;
                                    $slug = $detail->tiket->slug;

                                    if ($kategoriNama == 'Wahana') {
                                        $routeName = 'wahana.detail';
                                    } elseif ($kategoriNama == 'Program Kreativitas') {
                                        $routeName = 'programkreativitas.detail';
                                    } elseif ($kategoriNama == 'Event') {
                                        $routeName = 'event.detail';
                                    }
                                }
                            }
                        @endphp

                        @if($routeName && $slug)
                            <a href="{{ route($routeName, ['slug' => $slug]) }}" class="inline-block text-center mr-4 px-4 py-2 bg-white border border-teal-400 text-teal-400 rounded hover:bg-teal-600 hover:text-white">Beli Lagi</a>
                        @endif
                    </div>
                    <h4>Keterangan Penggunaan Tiket</h4>
                    <p>1. Tiket ini hanya berlaku pada tanggal kunjungan yang tertera.</p>
                    <p>2. Harap membawa tiket ini saat kunjungan.</p>
                    <p>3. Tunjukkan tiket ini di pintu masuk.</p>
                    <p>4. Tiket tidak dapat dipindahtangankan atau diuangkan kembali.</p>
                    <p>5. Patuhi semua peraturan yang berlaku di lokasi kunjungan.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
