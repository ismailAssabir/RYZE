@extends('layouts.app')
@section('title','Panier')
@section('content')
<section class="mx-auto max-w-5xl px-4 py-10"><h1 class="text-4xl font-black">Panier</h1>
@foreach($lines as $line)<div class="mt-4 flex items-center justify-between rounded-lg border border-zinc-200 p-4 dark:border-zinc-800"><div><b>{{ $line->product->name }}</b><p>{{ $line->quantity }} x {{ $line->unit_price }} MAD</p></div><form method="POST" action="{{ route('cart.destroy',$line) }}">@csrf @method('DELETE')<button class="text-red-600">Supprimer</button></form></div>@endforeach
<div class="mt-6 rounded-lg bg-zinc-100 p-6 dark:bg-zinc-900"><p>Total: <b>{{ number_format($totals['total'],2) }} MAD</b></p><a href="{{ route('checkout.create') }}" class="mt-4 inline-flex rounded bg-red-600 px-5 py-3 font-bold text-white">Checkout</a></div>
</section>
@endsection
