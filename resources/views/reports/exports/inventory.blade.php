<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventori</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2 {
            text-align: center;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .summary {
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: right;
        }
        .low-stock {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Laporan Inventori</h1>

    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ $date->format('d M Y H:i') }}</p>
    </div>

    <div class="summary">
        <p><strong>Total Produk:</strong> {{ $totalProducts }}</p>
        <p><strong>Total Nilai Inventori:</strong> Rp {{ number_format($totalValue, 0, ',', '.') }}</p>
        <p><strong>Produk Stok Menipis:</strong> {{ $lowStockProducts->count() }}</p>
    </div>

    <h2>Daftar Produk</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Nilai Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="text-center {{ $product->isLowStock() ? 'low-stock' : '' }}">
                        {{ $product->stock_quantity }}
                    </td>
                    <td class="text-right">
                        Rp {{ number_format($product->price * $product->stock_quantity, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($lowStockProducts->count() > 0)
        <h2>Produk Stok Menipis</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Stok Saat Ini</th>
                    <th>Batas Minimum</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockProducts as $index => $product)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td class="text-center low-stock">{{ $product->stock_quantity }}</td>
                        <td class="text-center">{{ $product->min_stock_threshold }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
