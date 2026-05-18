@extends('layouts.app')
@section('title','Shop')
@section('content')
<section class="mx-auto max-w-7xl px-4 py-10">
    <h1 class="text-4xl font-black">Shop RYZE</h1>
    <form class="mt-6 grid gap-3 rounded-lg border border-zinc-200 p-4 dark:border-zinc-800 md:grid-cols-5">
        <input name="q" value="{{ request('q') }}" class="rounded border-zinc-300 bg-transparent" placeholder="Recherche">
        <select name="category" class="rounded border-zinc-300 bg-transparent"><option value="">Categorie</option>@foreach($categories as $c)<option value="{{ $c->slug }}" @selected(request('category')===$c->slug)>{{ $c->name }}</option>@endforeach</select>
        <select name="brand" class="rounded border-zinc-300 bg-transparent"><option value="">Marque</option>@foreach($brands as $b)<option value="{{ $b->slug }}" @selected(request('brand')===$b->slug)>{{ $b->name }}</option>@endforeach</select>
        <select name="sort" class="rounded border-zinc-300 bg-transparent"><option value="">Nouveautes</option><option value="price_asc">Prix croissant</option><option value="price_desc">Prix decroissant</option><option value="popular">Populaires</option></select>
        <button class="rounded bg-red-600 px-4 py-2 font-bold text-white">Filtrer</button>
    </form>
    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">@foreach($products as $product)<x-product-card :product="$product"/>@endforeach</div>
    <div class="mt-8">{{ $products->links() }}</div>
</section>
@endsection
