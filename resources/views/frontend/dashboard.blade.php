@extends('layouts.app')
@section('title','Dashboard')
@section('content')<section class="mx-auto max-w-7xl px-4 py-10"><h1 class="text-4xl font-black">Mon espace</h1><p class="mt-2">Points fidelite: {{ auth()->user()->loyalty_points }}</p><div class="mt-6 grid gap-4">@foreach($orders as $order)<a href="{{ route('orders.show',$order) }}" class="rounded border border-zinc-200 p-4 dark:border-zinc-800">{{ $order->number }} - {{ $order->status }} - {{ $order->total }} MAD</a>@endforeach</div></section>@endsection
