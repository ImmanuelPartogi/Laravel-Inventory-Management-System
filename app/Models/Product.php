<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Notification;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock_quantity',
        'min_stock_threshold',
        'image_path'
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke order_items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Cek apakah stok menipis
    public function isLowStock()
    {
        return $this->stock_quantity <= $this->min_stock_threshold;
    }

    // Mengurangi stok saat ada pesanan
    public function decreaseStock($quantity)
    {
        $this->stock_quantity -= $quantity;
        $this->save();

        // Kirim notifikasi jika stok menipis
        if ($this->isLowStock()) {
            // Kirim ke semua admin
            $admins = User::all();
            Notification::send($admins, new LowStockNotification($this));
        }

        return $this;
    }
}
