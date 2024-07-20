<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Tiket') }}
        </h2>
    </x-slot>
    <div class="min-h-screen py-16 items-center justify-center">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Keranjang Tiket</h1>
            @if ($cartItems->isNotEmpty())
                <div class="mb-4">
                    <input type="checkbox" id="select-all" class="mr-2 rounded" onchange="selectAll(this)">
                    <label for="select-all" class="font-semibold">Pilih Semua</label>
                </div>
                <div class="space-y-4">
                    @foreach ($cartItems as $cartItem)
                        <div class="bg-white shadow-md rounded-lg flex items-center justify-between p-4">
                            <div class="flex items-center space-x-4">
                                <input type="checkbox" class="cart-item-checkbox rounded" data-cart-id="{{ $cartItem->id }}" data-total="{{ $cartItem->harga_anak * $cartItem->quantity_anak + $cartItem->harga_dewasa * $cartItem->quantity_dewasa }}" onchange="calculateTotal()">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $cartItem->tiket->nama }}</h3>
                                    <p class="text-gray-600">{{ $cartItem->tiket->kategoriTiket->nama }}</p>
                                    <p class="text-gray-600">
                                        <i class="fas fa-calendar-alt"></i> {{ $cartItem->tanggal_kunjungan }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center space-x-6 p-4 bg-white shadow-md rounded-lg">
                                    @if ($cartItem->tiket->harga_anak > 0)
                                        <div class="flex items-center">
                                            <i class="fas fa-child text-blue-500 text-2xl"></i>
                                            <div class="flex items-center ml-3">
                                                <button class="bg-blue-200 text-blue-700 px-3 py-1 rounded-l hover:bg-blue-300" onclick="updateQuantity(this, -1, '{{ $cartItem->id }}', 'anak')">-</button>
                                                <input type="number" name="quantity_anak" value="{{ $cartItem->quantity_anak }}" class="w-14 p-2 rounded border-t border-b text-center border-blue-300" data-cart-id="{{ $cartItem->id }}" data-price="{{ $cartItem->tiket->harga_anak }}" readonly>
                                                <button class="bg-blue-200 text-blue-700 px-3 py-1 rounded-r hover:bg-blue-300" onclick="updateQuantity(this, 1, '{{ $cartItem->id }}', 'anak')">+</button>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($cartItem->tiket->harga_dewasa > 0)
                                        <div class="flex items-center">
                                            <i class="fas fa-user text-green-500 text-2xl"></i>
                                            <div class="flex items-center ml-3">
                                                <button class="bg-green-200 text-green-700 px-3 py-1 rounded-l hover:bg-green-300" onclick="updateQuantity(this, -1, '{{ $cartItem->id }}', 'dewasa')">-</button>
                                                <input type="number" name="quantity_dewasa" value="{{ $cartItem->quantity_dewasa }}" class="w-14 p-2 rounded border-t border-b text-center border-green-300" data-cart-id="{{ $cartItem->id }}" data-price="{{ $cartItem->tiket->harga_dewasa }}" readonly>
                                                <button class="bg-green-200 text-green-700 px-3 py-1 rounded-r hover:bg-green-300" onclick="updateQuantity(this, 1, '{{ $cartItem->id }}', 'dewasa')">+</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <p class="text-gray-800 font-semibold">
                                    Total: Rp <span id="total-harga-{{ $cartItem->id }}">{{ number_format($cartItem->harga_anak * $cartItem->quantity_anak + $cartItem->harga_dewasa * $cartItem->quantity_dewasa, 0, ',', '.') }}</span>
                                </p>
                                <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <div class="mb-4">
                        <span class="text-lg font-bold">Total Harga: </span>
                        <span id="grand-total" class="text-lg font-bold">Rp 0</span>
                    </div>
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" id="checkout-button" class="bg-green-500 text-white px-6 py-2 rounded" disabled><i class="fas fa-shopping-cart"></i> Checkout</button>
                    </form>
                </div>
            @else
                <p class="text-center">Keranjang Anda kosong.</p>
            @endif
        </div>
    </div>

    <script>
        function updateQuantity(element, change, cartId, type) {
            const input = element.parentElement.querySelector('input');
            let newValue = parseInt(input.value) + change;
            if (newValue < 0) newValue = 0;
            input.value = newValue;

            const quantityAnakInput = document.querySelector(`input[name="quantity_anak"][data-cart-id="${cartId}"]`);
            const quantityDewasaInput = document.querySelector(`input[name="quantity_dewasa"][data-cart-id="${cartId}"]`);
            const quantityAnak = quantityAnakInput ? quantityAnakInput.value : 0;
            const quantityDewasa = quantityDewasaInput ? quantityDewasaInput.value : 0;
            const priceAnak = quantityAnakInput ? quantityAnakInput.getAttribute('data-price') : 0;
            const priceDewasa = quantityDewasaInput ? quantityDewasaInput.getAttribute('data-price') : 0;

            fetch(`/cart/update/${cartId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    quantity_anak: quantityAnak,
                    quantity_dewasa: quantityDewasa
                })
            })
            .then(response => response.json())
            .then(data => {
                const totalHarga = (priceAnak * quantityAnak) + (priceDewasa * quantityDewasa);
                document.getElementById(`total-harga-${cartId}`).innerText = totalHarga.toLocaleString('id-ID');

                // Update total attribute on checkbox
                const checkbox = document.querySelector(`.cart-item-checkbox[data-cart-id="${cartId}"]`);
                if (checkbox) {
                    checkbox.setAttribute('data-total', totalHarga);
                }

                calculateTotal();
            });
        }

        function calculateTotal() {
            const checkboxes = document.querySelectorAll('.cart-item-checkbox:checked');
            let grandTotal = 0;
            let hasValidItems = false;

            checkboxes.forEach(checkbox => {
                const cartId = checkbox.getAttribute('data-cart-id');
                const quantityAnakInput = document.querySelector(`input[name="quantity_anak"][data-cart-id="${cartId}"]`);
                const quantityDewasaInput = document.querySelector(`input[name="quantity_dewasa"][data-cart-id="${cartId}"]`);
                const quantityAnak = quantityAnakInput ? parseInt(quantityAnakInput.value) : 0;
                const quantityDewasa = quantityDewasaInput ? parseInt(quantityDewasaInput.value) : 0;

                if (quantityAnak > 0 || quantityDewasa > 0) {
                    hasValidItems = true;
                    grandTotal += parseFloat(checkbox.getAttribute('data-total'));
                }
            });

            document.getElementById('grand-total').innerText = `Rp ${grandTotal.toLocaleString('id-ID')}`;

            // Enable or disable checkout button based on checkbox selection and valid items
            document.getElementById('checkout-button').disabled = !hasValidItems || checkboxes.length === 0;
        }

        function selectAll(checkbox) {
            const checkboxes = document.querySelectorAll('.cart-item-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
            calculateTotal();
        }

        // Initial calculation
        calculateTotal();
    </script>
</x-app-layout>
