<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LowStockNotification extends Notification
{
    use Queueable;

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Peringatan Stok Menipis')
            ->line('Stok produk berikut sudah menipis:')
            ->line('Produk: ' . $this->product->name)
            ->line('Stok saat ini: ' . $this->product->stock_quantity)
            ->line('Batas minimum stok: ' . $this->product->min_stock_threshold)
            ->action('Lihat Produk', url('/products/' . $this->product->id))
            ->line('Silakan tambah stok segera!');
    }

    public function toArray($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'current_stock' => $this->product->stock_quantity,
            'min_threshold' => $this->product->min_stock_threshold,
        ];
    }
}
