@extends('layouts.app')
@section('title','Checkout')
@section('content')
<section class="mx-auto max-w-4xl px-4 py-10"><h1 class="text-4xl font-black">Checkout</h1>
<form method="POST" action="{{ route('checkout.store') }}" class="mt-6 grid gap-4">@csrf
    <input name="shipping_address[name]" class="rounded border-zinc-300 bg-transparent" placeholder="Nom complet">
    <input name="shipping_address[email]" class="rounded border-zinc-300 bg-transparent" placeholder="Email">
    <input name="shipping_address[phone]" class="rounded border-zinc-300 bg-transparent" placeholder="Telephone">
    <input name="shipping_address[address]" class="rounded border-zinc-300 bg-transparent" placeholder="Adresse">
    <input name="shipping_address[city]" class="rounded border-zinc-300 bg-transparent" placeholder="Ville">
    <select name="payment_method" class="rounded border-zinc-300 bg-transparent"><option value="cod">Cash on Delivery</option><option value="stripe">Stripe</option><option value="paypal">PayPal</option></select>
    <button class="rounded bg-red-600 px-5 py-3 font-bold text-white">Confirmer {{ number_format($totals['total'],2) }} MAD</button>
</form></section>
@endsection
