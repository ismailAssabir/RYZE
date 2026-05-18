<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmed extends Notification
{
    use Queueable;

    public function __construct(private Order $order) {}
    public function via(object $notifiable): array { return ['mail', 'database']; }
    public function toMail(object $notifiable): MailMessage { return (new MailMessage)->subject('Commande RYZE confirmee')->line("Votre commande {$this->order->number} est enregistree.")->line("Total: {$this->order->total} MAD"); }
    public function toArray(object $notifiable): array { return ['order_id' => $this->order->id, 'number' => $this->order->number]; }
}
