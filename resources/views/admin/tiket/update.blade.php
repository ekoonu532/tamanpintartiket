@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-8">
            <h1 class="text-2xl font-semibold font-Poppins text-gray-800">Edit Tiket</h1>
            <form method="POST" action="{{ route('admin.tickets.update', $ticket->tiket_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Form fields here -->
                    <div>
                        <x-input-label for="nama" :value="__('Nama Tiket')" />
                        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama"
                            value="{{ $ticket->nama }}" required autofocus autocomplete="name" />
                    </div>
                    <div>
                        <x-input-label for="slug" :value="__('Slug')" />
                        <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug"
                            value="{{ $ticket->slug }}" required />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                        <textarea id="deskripsi" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" name="deskripsi" required>{{ $ticket->deskripsi }}</textarea>
                    </div>
                    <div>
                        <x-input-label for="kategori_tiket_id" :value="__('Kategori Tiket')" />
                        <select id="kategori_tiket_id" name="kategori_tiket_id"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoriTiket as $kategori)
                                <option value="{{ $kategori->kategori_tiket_id }}"
                                    @if ($ticket->kategori_tiket_id == $kategori->kategori_tiket_id) selected @endif>{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="gambar" :value="__('Gambar')" />
                        <input id="gambar" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="file"
                            name="gambar" />
                    </div>
                    <div class="md:col-span-2" id="tanggalFields">
                        <div>
                            <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                            <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="date" name="tanggal_mulai"
                                value="{{ $ticket->tanggal_mulai }}" />
                        </div>
                        <div>
                            <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                            <x-text-input id="tanggal_selesai" class="block mt-1 w-full" type="date"
                                name="tanggal_selesai" value="{{ $ticket->tanggal_selesai }}" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="harga_anak" :value="__('Harga Anak')" />
                        <x-text-input id="harga_anak" class="block mt-1 w-full" type="number" name="harga_anak"
                            value="{{ $ticket->harga_anak }}" required />
                    </div>
                    <div>
                        <x-input-label for="harga_dewasa" :value="__('Harga Dewasa')" />
                        <x-text-input id="harga_dewasa" class="block mt-1 w-full" type="number" name="harga_dewasa"
                            value="{{ $ticket->harga_dewasa }}" required />
                    </div>
                    <div>
                        <x-input-label for="kuota" :value="__('Kuota')" />
                        <x-text-input id="kuota" class="block mt-1 w-full" type="number" name="kuota"
                            value="{{ $ticket->kuota }}" required />
                    </div>
                    <div>
                        <x-input-label for="usia_minimal" :value="__('Usia Minimal')" />
                        <x-text-input id="usia_minimal" class="block mt-1 w-full" type="number" name="usia_minimal"
                            value="{{ $ticket->usia_minimal }}" required />
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <input type="checkbox" name="status" id="status" class="toggle toggle-accent" {{ $ticket->status == 'aktif' ? 'checked' : '' }} data-toggle-on="aktif" data-toggle-off="tidak aktif">
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="window.history.back();"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md shadow-md mr-2">Batal</button>
                    <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-md shadow-md">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Konfirmasi Batal -->
    <div id="cancelConfirmModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                Batalkan Perubahan
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin membatalkan perubahan yang belum disimpan?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="cancelEdit()">
                        Ya, Batalkan
                    </button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeCancelModal()">
                        Tidak, Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Simpan -->
    <div id="saveConfirmModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                Simpan Perubahan
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menyimpan perubahan yang telah Anda lakukan?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="saveChanges()">
                        Ya, Simpan
                    </button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeSaveModal()">
                        Tidak, Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Your existing content -->

    <script>
        // Function to show confirmation modal when cancelling edit
        function showCancelModal() {
            document.getElementById('cancelConfirmModal').classList.remove('hidden');
            document.getElementById('cancelConfirmModal').classList.add('block');
        }

        // Function to hide confirmation modal for cancelling edit
        function closeCancelModal() {
            document.getElementById('cancelConfirmModal').classList.remove('block');
            document.getElementById('cancelConfirmModal').classList.add('hidden');
        }

        // Function to handle cancellation of edit
        function cancelEdit() {
            closeCancelModal(); // Close the cancel confirmation modal
            // Redirect to the ticket index page
            window.location.href = "{{ route('admin.tickets.index') }}";
        }

        // Function to show confirmation modal when saving changes
        function showSaveModal() {
            document.getElementById('saveConfirmModal').classList.remove('hidden');
            document.getElementById('saveConfirmModal').classList.add('blok');
        }

        function closeSaveModal() {
            document.getElementById('saveConfirmModal').classList.remove('block');
            document.getElementById('saveConfirmModal').classList.add('hidden');
        }


        function saveChanges() {
            closeSaveModal();
            document.getElementById('editForm').submit();
        }


        document.addEventListener('DOMContentLoaded', function() {
            const kategoriTiketSelect = document.getElementById('kategori_tiket_id');
            const tanggalFields = document.getElementById('tanggalFields');

            function toggleTanggalFields() {
                const selectedOption = kategoriTiketSelect.options[kategoriTiketSelect.selectedIndex].text;
                if (selectedOption === 'Event') {
                    tanggalFields.style.display = 'grid';
                } else {
                    tanggalFields.style.display = 'none';
                }
            }

            kategoriTiketSelect.addEventListener('change', toggleTanggalFields);

            // Initial check
            toggleTanggalFields();
        });

        document.addEventListener('DOMContentLoaded', function() {
        const statusCheckbox = document.getElementById('status');
        statusCheckbox.addEventListener('change', function() {
            this.value = this.checked ? 'aktif' : 'tidak aktif';
        });
        // Set the initial value of the checkbox
        statusCheckbox.value = statusCheckbox.checked ? 'aktif' : 'tidak aktif';
    });

    </script>
@endsection
