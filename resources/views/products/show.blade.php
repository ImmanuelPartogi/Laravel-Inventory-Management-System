@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <div>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus produk ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="img-fluid mb-3" style="max-height: 300px;">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="img-fluid mb-3" style="max-height: 300px;">
                    @endif

                    <h4>{{ $product->name }}</h4>
                    <p class="text-muted">{{ $product->category->name }}</p>
                    <h5 class="text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</h5>

                    <div class="mt-3">
                        @if($product->isLowStock())
                            <span class="badge bg-danger p-2">
                                <i class="fas fa-exclamation-triangle me-1"></i> Stok Menipis
                            </span>
                        @else
                            <span class="badge bg-success p-2">
                                <i class="fas fa-check me-1"></i> Stok Cukup
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Informasi Produk</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">ID Produk</div>
                        <div class="col-md-8">{{ $product->id }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nama</div>
                        <div class="col-md-8">{{ $product->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Kategori</div>
                        <div class="col-md-8">{{ $product->category->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Harga</div>
                        <div class="col-md-8">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Stok</div>
                        <div class="col-md-8">
                            {{ $product->stock_quantity }} unit
                            @if($product->isLowStock())
                                <span class="badge bg-danger ms-2">Stok Menipis</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Batas Minimum Stok</div>
                        <div class="col-md-8">{{ $product->min_stock_threshold }} unit</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal Ditambahkan</div>
                        <div class="col-md-8">{{ $product->created_at->format('d M Y H:i') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Terakhir Diperbarui</div>
                        <div class="col-md-8">{{ $product->updated_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Deskripsi</h5>
                </div>
                <div class="card-body">
                    {!! nl2br(e($product->description ?? 'Tidak ada deskripsi tersedia.')) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
