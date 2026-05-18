@props(['product'])
<article class="group overflow-hidden rounded-lg border border-zinc-200 bg-white transition hover:-translate-y-1 hover:shadow-xl dark:border-zinc-800 dark:bg-zinc-950">
    <a href="{{ route('products.show', $product) }}" class="block aspect-square bg-zinc-100 dark:bg-zinc-900">
        @php
            $firstPath = $product->images->first()->path ?? 'images/ryze-logo.jpeg';
            $src = str_starts_with($firstPath, 'storage/')
                ? asset($firstPath)
                : asset('storage/'.$firstPath);
        @endphp
        <img src="{{ $src }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition group-hover:scale-105">

    </a>
    <div class="p-4">
        <div class="text-xs uppercase text-red-600">{{ $product->category?->name }}</div>
        <h3 class="mt-1 line-clamp-2 font-bold">{{ $product->name }}</h3>
        <div class="mt-3 flex items-center justify-between">
            <span class="font-black">{{ number_format($product->final_price, 2) }} MAD</span>
            @if($product->sale_price)<span class="text-sm text-zinc-500 line-through">{{ number_format($product->price, 2) }}</span>@endif
        </div>
        <form method="POST" action="{{ route('cart.store', $product) }}" class="mt-4">@csrf
            <button class="w-full rounded bg-zinc-950 px-4 py-2 text-sm font-bold text-white dark:bg-white dark:text-black">Ajouter</button>
        </form>
    </div>
</article>
