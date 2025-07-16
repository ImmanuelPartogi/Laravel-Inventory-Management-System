<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('stock_quantity', '>', 0)->get();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Hitung total
            $total = 0;
            foreach ($validated['products'] as $item) {
                $product = Product::findOrFail($item['id']);

                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Stok tidak cukup untuk produk {$product->name}");
                }

                $total += $product->price * $item['quantity'];
            }

            // Buat pesanan
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'status' => 'pending',
                'total_amount' => $total,
            ]);

            // Tambahkan item pesanan dan kurangi stok
            foreach ($validated['products'] as $item) {
                $product = Product::findOrFail($item['id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                $product->decreaseStock($item['quantity']);
            }

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        return view('orders.edit', compact('order', 'statuses'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->updateStatus($validated['status']);

        return redirect()->route('orders.index')
            ->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function destroy(Order $order)
    {
        // Jika pesanan completed, tidak dapat dihapus
        if ($order->status === 'completed') {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan yang sudah selesai tidak dapat dihapus');
        }

        // Jika pesanan belum cancelled, kembalikan stok
        if ($order->status !== 'cancelled') {
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->stock_quantity += $item->quantity;
                $product->save();
            }
        }

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dihapus');
    }
}
