@extends('admin.layout')
@section('admin')
<h1 class="text-4xl font-black">Dashboard</h1>
<div class="mt-6 grid gap-4 md:grid-cols-4">
    <div class="rounded-lg bg-zinc-100 p-5 dark:bg-zinc-900"><p>Revenus</p><b class="text-2xl">{{ number_format($revenue,2) }} MAD</b></div>
    <div class="rounded-lg bg-zinc-100 p-5 dark:bg-zinc-900"><p>Ventes</p><b class="text-2xl">{{ $sales }}</b></div>
    <div class="rounded-lg bg-zinc-100 p-5 dark:bg-zinc-900"><p>Clients</p><b class="text-2xl">{{ $users }}</b></div>
    <div class="rounded-lg bg-zinc-100 p-5 dark:bg-zinc-900"><p>Produits</p><b class="text-2xl">{{ $products }}</b></div>
</div>
<h2 class="mt-8 text-2xl font-black">Stock faible</h2>@foreach($lowStock as $product)<div class="mt-2 rounded border border-red-500/30 p-3">{{ $product->name }} - {{ $product->stock }}</div>@endforeach
@endsection
