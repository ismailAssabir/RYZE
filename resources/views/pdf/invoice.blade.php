<h1>Facture {{ $order->number }}</h1>
<p>Total: {{ $order->total }} MAD</p>
@foreach($order->items as $item)
    <p>{{ $item->product_name }} x {{ $item->quantity }} - {{ $item->total }} MAD</p>
@endforeach
