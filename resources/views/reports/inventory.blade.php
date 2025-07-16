@extends('layouts.app')

@section('title', 'Laporan Inventori')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12 text-end">
            <a href="{{ route('reports.generate', ['type' => 'inventory']) }}" class="btn btn-success" target="_blank">
                <i class="fas fa-file-excel me-1"></i> Export Laporan
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Grafik Nilai Inventori per Kategori</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Ringkasan Inventori</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-7">Total Produk</div>
                        <div class="col-5 text-end">{{ $totalProducts }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-7">Total Nilai Inventori</div>
                        <div class="col-5 text-end">Rp {{ number_format($totalValue, 0, ',', '.') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-7">Produk Stok Menipis</div>
                        <div class="col-5 text-end">{{ $lowStockProducts->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Produk Stok Menipis</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($lowStockProducts as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $product->name }}
                                <span class="badge bg-danger rounded-pill">{{ $product->stock_quantity }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center">Tidak ada produk dengan stok menipis</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Daftar Produk</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Nilai Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock_quantity }}</td>
                                <td>Rp {{ number_format($product->price * $product->stock_quantity, 0, ',', '.') }}</td>
                                <td>
                                    @if($product->isLowStock())
                                        <span class="badge bg-danger">Stok Menipis</span>
                                    @else
                                        <span class="badge bg-success">Stok Cukup</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Chart for category values
    var categoryNames = [];
    var categoryValues = [];
    var backgroundColors = [
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 99, 132, 0.6)',
        'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)',
        'rgba(153, 102, 255, 0.6)',
        'rgba(255, 159, 64, 0.6)',
        'rgba(199, 199, 199, 0.6)'
    ];

    @foreach($categories as $name => $data)
        categoryNames.push('{{ $name }}');
        categoryValues.push({{ $data['value'] }});
    @endforeach

    var ctx = document.getElementById('categoryChart').getContext('2d');
    var categoryChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: categoryNames,
            datasets: [{
                data: categoryValues,
                backgroundColor: backgroundColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var value = context.parsed || 0;
                            return label + ': Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
