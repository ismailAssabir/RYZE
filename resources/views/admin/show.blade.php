@extends('admin.layout')
@section('admin')
<div class="mb-6 flex items-center justify-between gap-4">
    <h1 class="text-4xl font-black text-zinc-900 dark:text-white">Détails : {{ $item->name ?? $item->title ?? $item->number ?? ('#' . $item->id) }}</h1>
    <div class="flex gap-2">
        @if(isset($editRoute))
            <a href="{{ $editRoute }}" class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-5 py-2.5 text-sm font-bold text-white shadow-md transition-colors hover:bg-amber-600 focus:ring-4 focus:ring-amber-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                Modifier
            </a>
        @endif
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 rounded-lg border border-zinc-200 bg-white px-5 py-2.5 text-sm font-bold text-zinc-600 shadow-sm transition-colors hover:bg-zinc-50 focus:ring-4 focus:ring-zinc-200 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-300 dark:hover:bg-zinc-900">
            Retour
        </a>
    </div>
</div>

<div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-950/50">
    <div class="border-b border-zinc-200 bg-zinc-50/50 px-6 py-5 dark:border-zinc-800 dark:bg-zinc-900/50">
        <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Informations Complètes</h3>
    </div>
    <div class="p-0">
        <dl class="divide-y divide-zinc-200 dark:divide-zinc-800">
            @foreach($item->toArray() as $key => $value)
                @if(!in_array($key, ['password', 'remember_token', 'email_verified_at']) && !is_array($value) && !is_object($value))
                    <div class="grid grid-cols-1 gap-1 px-6 py-4 transition-colors hover:bg-cyan-50/30 sm:grid-cols-3 sm:gap-4 dark:hover:bg-cyan-900/10">
                        <dt class="text-sm font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            {{ str_replace('_', ' ', $key) }}
                        </dt>
                        <dd class="text-sm font-medium text-zinc-900 sm:col-span-2 dark:text-zinc-200">
                            @if(in_array($key, ['avatar', 'image', 'logo', 'thumbnail', 'path']) && !empty($value))
                                <a href="{{ Storage::url($value) }}" target="_blank">
                                    <img src="{{ Storage::url($value) }}" class="h-16 w-16 rounded-lg object-cover ring-1 ring-zinc-200 dark:ring-zinc-800 transition-transform hover:scale-110">
                                </a>
                            @elseif($key === 'is_active' || $key === 'status')
                                @if($value)
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">Actif</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-bold text-red-800 dark:bg-red-900/30 dark:text-red-400">Inactif</span>
                                @endif
                            @elseif($key === 'role')
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold {{ $value === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-400' }}">
                                    {{ strtoupper($value) }}
                                </span>
                            @else
                                {{ $value ?? '-' }}
                            @endif
                        </dd>
                    </div>
                @endif
            @endforeach
        </dl>
    </div>
</div>
@endsection
