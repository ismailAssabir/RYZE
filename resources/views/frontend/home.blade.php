@extends('layouts.app')
@section('title','Accueil')
@section('content')
<section class="relative overflow-hidden bg-black text-white">
    <div class="mx-auto grid min-h-[620px] max-w-7xl items-center gap-10 px-4 py-12 md:grid-cols-2">
        <div>
            <p class="text-sm font-bold uppercase text-lime-400">Sport performance store</p>
            <h1 class="mt-4 max-w-2xl text-5xl font-black leading-tight md:text-7xl">RYZE</h1>
            <p class="mt-5 max-w-xl text-lg text-zinc-300">Vêtements, chaussures, accessoires, équipements fitness et nutrition pour pousser chaque session plus loin.</p>
            <div class="mt-8 flex gap-3">
                <a href="{{ route('shop') }}" class="rounded bg-red-600 px-6 py-3 font-bold text-white">Acheter</a>
                <a href="{{ route('page','categories') }}" class="rounded border border-white/30 px-6 py-3 font-bold">Explorer</a>
            </div>
        </div>
        <img src="{{ asset('images/ryze-logo.jpeg') }}" class="mx-auto max-h-[420px] rounded-lg object-cover shadow-2xl shadow-lime-500/20" alt="RYZE logo">
    </div>
</section>
<section class="mx-auto max-w-7xl px-4 py-12">
    <div class="flex items-end justify-between"><h2 class="text-3xl font-black">Tendances</h2><a href="{{ route('shop') }}" class="font-bold text-red-600">Voir tout</a></div>
    <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">@foreach($trending as $product)<x-product-card :product="$product"/>@endforeach</div>
</section>
<section class="bg-zinc-100 py-12 dark:bg-zinc-950"><div class="mx-auto max-w-7xl px-4"><h2 class="text-3xl font-black">Categories</h2><div class="mt-6 grid gap-4 md:grid-cols-4">@foreach($categories as $category)<a href="{{ route('shop',['category'=>$category->slug]) }}" class="rounded-lg bg-white p-6 font-black shadow-sm dark:bg-zinc-900">{{ $category->name }}</a>@endforeach</div></div></section>
@endsection
