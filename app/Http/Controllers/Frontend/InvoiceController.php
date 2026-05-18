<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __invoke(Order $order)
    {
        $this->authorize('view', $order);

        return Pdf::loadView('pdf.invoice', ['order' => $order->load('items')])
            ->download("invoice-{$order->number}.pdf");
    }
}
