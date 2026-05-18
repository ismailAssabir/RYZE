@extends('admin.layout')
@section('admin')
    @php
        // Detect current admin resource to show correct actions.
        // route names like: admin.users.index, admin.categories.index, ...
        $resourceName = request()->route()?->getName();
        $resourceName = is_string($resourceName) ? $resourceName : '';
        $resourceKey = $resourceName ? str_replace('admin.', '', str_replace('.index', '', $resourceName)) : '';

        $routeBase = $resourceKey ? ('admin.' . $resourceKey) : '';
    @endphp

    <div class="flex items-center justify-between gap-4">
        <h1 class="text-4xl font-black text-zinc-900 dark:text-white">{{ $title }}</h1>

        @php
            $showAdd = in_array($resourceKey, ['users', 'categories']) || \Illuminate\Support\Facades\Route::has($routeBase . '.create');
            $createRoute = \Illuminate\Support\Facades\Route::has($routeBase . '.create') ? route($routeBase . '.create') : '#';
        @endphp

        @if($showAdd)
            <a href="{{ $createRoute }}" class="inline-flex items-center gap-2 rounded-lg bg-cyan-600 px-5 py-2.5 text-sm font-bold text-white shadow-md transition-colors hover:bg-cyan-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-cyan-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Ajouter
            </a>
        @endif
    </div>

    <div class="mt-6 grid gap-4">
        @foreach($items as $item)
            @php
                $showActions = in_array($resourceKey, ['users', 'categories']) || \Illuminate\Support\Facades\Route::has($routeBase . '.show');
                $showRoute = \Illuminate\Support\Facades\Route::has($routeBase . '.show') ? route($routeBase . '.show', $item) : '#';
                $editRoute = \Illuminate\Support\Facades\Route::has($routeBase . '.edit') ? route($routeBase . '.edit', $item) : '#';
                $destroyRoute = \Illuminate\Support\Facades\Route::has($routeBase . '.destroy') ? route($routeBase . '.destroy', $item) : '#';
            @endphp
            <div class="flex items-center justify-between rounded-xl border border-zinc-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md dark:border-zinc-800 dark:bg-zinc-950/50">
                <div class="flex items-center gap-4 min-w-0">
                    @if($resourceKey === 'users')
                        @if(!empty($item->avatar))
                            <img src="{{ Storage::url($item->avatar) }}" alt="{{ $item->name }}" class="h-12 w-12 shrink-0 rounded-full object-cover shadow-sm ring-2 ring-white dark:ring-zinc-900">
                        @else
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-cyan-500 to-blue-600 text-lg font-bold text-white shadow-sm ring-2 ring-white dark:ring-zinc-900">
                                {{ strtoupper(substr($item->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                    @elseif($resourceKey === 'categories' && !empty($item->image))
                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="h-12 w-12 shrink-0 rounded-lg object-cover shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-800">
                    @endif

                    <div class="min-w-0">
                        <div class="truncate text-lg font-bold text-zinc-900 dark:text-white">#{{ $item->id }} {{ $item->name ?? $item->number ?? $item->title ?? $item->code ?? $item->email ?? 'Item' }}</div>
                        @if(isset($item->created_at))
                            <div class="mt-1 flex items-center gap-1.5 text-sm font-medium text-zinc-500 dark:text-zinc-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                                {{ $item->created_at->format('Y-m-d') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    @if($showActions)
                        <a href="{{ $showRoute }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 shadow-sm transition-all hover:bg-zinc-50 hover:text-cyan-600 focus:ring-4 focus:ring-zinc-100 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-400 dark:hover:bg-zinc-900 dark:hover:text-cyan-400 dark:focus:ring-zinc-800" title="Show">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                        </a>

                        <a href="{{ $editRoute }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-amber-200 bg-amber-50 text-amber-600 shadow-sm transition-all hover:bg-amber-100 hover:text-amber-700 focus:ring-4 focus:ring-amber-50 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-500 dark:hover:bg-amber-900/50 dark:focus:ring-amber-900/30" title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                        </a>

                        @php
                            $isUserAndAdmin = $resourceKey === 'users' && isset($item->role) && $item->role === 'admin';
                        @endphp
                        @if(!$isUserAndAdmin)
                        <form method="POST" action="{{ $destroyRoute }}" class="m-0 delete-confirm-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 shadow-sm transition-all hover:bg-red-100 hover:text-red-700 focus:ring-4 focus:ring-red-50 dark:border-red-900/50 dark:bg-red-950/30 dark:text-red-500 dark:hover:bg-red-900/50 dark:focus:ring-red-900/30" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                            </button>
                        </form>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{ $items->links() }}
@endsection


