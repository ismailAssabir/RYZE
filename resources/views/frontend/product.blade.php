@extends('layouts.app')
@section('title',$product->name)
@section('content')
<section class="mx-auto grid max-w-7xl gap-10 px-4 py-10 lg:grid-cols-2">
    <div class="grid gap-4">
        @foreach($product->images as $image)
            @php
                $p = $image->path;
                $src = str_starts_with($p ?? '', 'storage/')
                    ? asset($p)
                    : asset('storage/'.$p);
            @endphp
            <img src="{{ $src }}" class="rounded-lg bg-zinc-100 object-cover" alt="{{ $image->alt }}">
        @endforeach
    </div>

    <div>
        <p class="font-bold uppercase text-red-600">{{ $product->brand?->name }}</p>
        <h1 class="mt-2 text-4xl font-black">{{ $product->name }}</h1>
        <p class="mt-4 text-zinc-600 dark:text-zinc-300">{{ $product->description }}</p>
        <div class="mt-6 text-3xl font-black">{{ number_format($product->final_price,2) }} MAD</div>
        <form method="POST" action="{{ route('cart.store',$product) }}" class="mt-6 space-y-4">@csrf
            <input type="number" name="quantity" min="1" value="1" class="w-24 rounded border-zinc-300 bg-transparent">
            <button class="block rounded bg-red-600 px-6 py-3 font-bold text-white">Ajouter au panier</button>
        </form>
        @auth<form method="POST" action="{{ route('wishlist.toggle',$product) }}" class="mt-3">@csrf<button class="font-bold text-red-600">Ajouter aux favoris</button></form>@endauth
    </div>
</section>
<section class="mx-auto max-w-7xl px-4"><h2 class="text-2xl font-black">Avis clients</h2>@foreach($product->reviews as $review)<div class="mt-4 rounded border border-zinc-200 p-4 dark:border-zinc-800"><b>{{ $review->rating }}/5</b> {{ $review->comment }}</div>@endforeach</section>
@endsection
