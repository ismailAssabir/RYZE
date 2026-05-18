@extends('layouts.app')
@section('title','Commande')
@section('content')<section class="mx-auto max-w-4xl px-4 py-10"><h1 class="text-4xl font-black">{{ $order->number }}</h1><p class="mt-3">Statut: <b>{{ $order->status }}</b></p><p>Total: <b>{{ $order->total }} MAD</b></p><a href="{{ route('orders.invoice',$order) }}" class="mt-5 inline-flex rounded bg-red-600 px-5 py-3 font-bold text-white">Facture PDF</a></section>@endsection
