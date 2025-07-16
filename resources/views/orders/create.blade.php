@extends('layouts.app')

@section('title', 'Tambah Pesanan')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Email Pelanggan</label>
                            <input type="email" class="form-control @error('customer_email') is-invalid @enderror" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="customer_phone" class="form-label">No. Telepon Pelanggan</label>
                    <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}">
                    @error('customer_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                <h5>Produk</h5>
                <div id="product-items">
                    <div class="product-item mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Produk</label>
                                <select name="products[0][id]" class="form-select product-select" required>
                                    <option value="" selected disabled>Pilih produk</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}">
                                            {{ $product->name }} (Stok: {{ $product->stock_quantity }}) - Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="products[0][quantity]" class="form-control product-quantity" min="1" value="1" required>
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-product" style="display: none;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="button" id="add-product" class="btn btn-sm btn-success">
                        <i class="fas fa-plus me-1"></i> Tambah Produk
                    </button>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5>Ringkasan Pesanan</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Item:</span>
                                    <span id="total-items">0</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Total Harga:</span>
                                    <span id="total-price">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let productIndex = 0;

        // Add product item
        $('#add-product').click(function() {
            productIndex++;

            const newItem = `
                <div class="product-item mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Produk</label>
                            <select name="products[${productIndex}][id]" class="form-select product-select" required>
                                <option value="" selected disabled>Pilih produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}">
                                        {{ $product->name }} (Stok: {{ $product->stock_quantity }}) - Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="products[${productIndex}][quantity]" class="form-control product-quantity" min="1" value="1" required>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-product">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            $('#product-items').append(newItem);

            // Show remove button for the first item if there are more than one items
            if ($('.product-item').length > 1) {
                $('.remove-product').show();
            }

            updateSummary();
        });

        // Remove product item
        $(document).on('click', '.remove-product', function() {
            $(this).closest('.product-item').remove();

            // Hide remove button for the last remaining item
            if ($('.product-item').length === 1) {
                $('.remove-product').hide();
            }

            updateSummary();
        });

        // Update quantity and select
        $(document).on('change', '.product-select, .product-quantity', function() {
            updateSummary();
        });

        // Check stock when quantity changes
        $(document).on('change', '.product-quantity', function() {
            const $select = $(this).closest('.product-item').find('.product-select');
            const $option = $select.find('option:selected');
            const stock = parseInt($option.data('stock'));
            const quantity = parseInt($(this).val());

            if (quantity > stock) {
                alert('Jumlah tidak boleh melebihi stok yang tersedia!');
                $(this).val(stock);
                updateSummary();
            }
        });

        // Update order summary
        function updateSummary() {
            let totalItems = 0;
            let totalPrice = 0;

            $('.product-item').each(function() {
                const $select = $(this).find('.product-select');
                const $option = $select.find('option:selected');
                const $quantity = $(this).find('.product-quantity');

                if ($option.val()) {
                    const price = parseFloat($option.data('price'));
                    const quantity = parseInt($quantity.val());

                    totalItems += quantity;
                    totalPrice += price * quantity;
                }
            });

            $('#total-items').text(totalItems);
            $('#total-price').text('Rp ' + totalPrice.toLocaleString('id-ID'));
        }

        // Form submission validation
        $('#orderForm').on('submit', function(e) {
            let valid = false;

            $('.product-select').each(function() {
                if ($(this).val()) {
                    valid = true;
                }
            });

            if (!valid) {
                e.preventDefault();
                alert('Silakan pilih setidaknya satu produk');
            }
        });

        // Initialize summary
        updateSummary();
    });
</script>
@endsection
