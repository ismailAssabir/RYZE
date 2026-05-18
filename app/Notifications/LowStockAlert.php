<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockAlert extends Notification
{
    use Queueable;

    public function __construct(private Product $product) {}
    public function via(object $notifiable): array { return ['mail', 'database']; }
    public function toMail(object $notifiable): MailMessage { return (new MailMessage)->subject('Stock faible RYZE')->line("{$this->product->name} est a {$this->product->stock} unites."); }
    public function toArray(object $notifiable): array { return ['product_id' => $this->product->id, 'stock' => $this->product->stock]; }
}
