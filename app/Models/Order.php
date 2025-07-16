<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'total_amount',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function updateStatus($status)
    {
        $this->status = $status;
        $this->save();

        // Jika status berubah menjadi cancelled, kembalikan stok
        if ($status === 'cancelled') {
            foreach ($this->items as $item) {
                $product = $item->product;
                $product->stock_quantity += $item->quantity;
                $product->save();
            }
        }

        return $this;
    }

    // Generate nomor pesanan unik
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $lastOrder = self::latest()->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->order_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
