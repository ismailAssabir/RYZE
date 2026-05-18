@extends('admin.layout')
@section('admin')
<div class="flex items-center justify-between gap-4">
    <h1 class="text-4xl font-black text-zinc-900 dark:text-white">Produits</h1>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-cyan-600 px-5 py-2.5 text-sm font-bold text-white shadow-md transition-colors hover:bg-cyan-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-cyan-500/30">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
        Ajouter
    </a>
</div>

<div class="mt-6 overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-950/50">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-zinc-600 dark:text-zinc-400">
            <thead class="border-b border-zinc-200 bg-zinc-50/50 text-xs uppercase tracking-wider text-zinc-500 dark:border-zinc-800 dark:bg-zinc-900/50 dark:text-zinc-400">
                <tr>
                    <th class="px-6 py-4 font-semibold">SKU</th>
                    <th class="px-6 py-4 font-semibold">Nom</th>
                    <th class="px-6 py-4 font-semibold">Prix</th>
                    <th class="px-6 py-4 font-semibold">Stock</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @foreach($products as $p)
                <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-900/50">
                    <td class="whitespace-nowrap px-6 py-4 font-medium text-zinc-900 dark:text-white">{{ $p->sku }}</td>
                    <td class="px-6 py-4 font-bold text-zinc-900 dark:text-white">{{ $p->name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ number_format($p->price, 2) }} MAD</td>
                    <td class="whitespace-nowrap px-6 py-4">
                        @if($p->stock > 10)
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">{{ $p->stock }}</span>
                        @elseif($p->stock > 0)
                            <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">{{ $p->stock }}</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/30 dark:text-red-400">0</span>
                        @endif
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if(\Illuminate\Support\Facades\Route::has('admin.products.show'))
                                <a href="{{ route('admin.products.show', $p) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 shadow-sm transition-all hover:bg-zinc-50 hover:text-cyan-600 focus:ring-4 focus:ring-zinc-100 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-400 dark:hover:bg-zinc-900 dark:hover:text-cyan-400 dark:focus:ring-zinc-800" title="Show">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                </a>
                            @endif

                            <a href="{{ route('admin.products.edit', $p) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-amber-200 bg-amber-50 text-amber-600 shadow-sm transition-all hover:bg-amber-100 hover:text-amber-700 focus:ring-4 focus:ring-amber-50 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-500 dark:hover:bg-amber-900/50 dark:focus:ring-amber-900/30" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                            </a>

                            @if(\Illuminate\Support\Facades\Route::has('admin.products.destroy'))
                                <form method="POST" action="{{ route('admin.products.destroy', $p) }}" class="m-0 delete-confirm-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 shadow-sm transition-all hover:bg-red-100 hover:text-red-700 focus:ring-4 focus:ring-red-50 dark:border-red-900/50 dark:bg-red-950/30 dark:text-red-500 dark:hover:bg-red-900/50 dark:focus:ring-red-900/30" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
