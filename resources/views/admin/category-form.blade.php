@extends('admin.layout')
@section('admin')
<div class="mb-6 flex items-center justify-between gap-4">
    <h1 class="text-4xl font-black text-zinc-900 dark:text-white">
        {{ isset($category) && $category->exists ? 'Modifier Catégorie' : 'Nouvelle Catégorie' }}
    </h1>
    <a href="{{ route('admin.categories.index') }}" class="text-sm font-bold text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">Retour à la liste</a>
</div>

<div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-950/50">
    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ isset($category) && $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
        class="grid gap-6"
    >
        @csrf
        @if(isset($category) && $category->exists)
            @method('PUT')
        @endif

        <div class="grid gap-6 md:grid-cols-2">
            <!-- Name -->
            <div class="grid gap-2">
                <label class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Nom de la catégorie</label>
                <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required class="w-full rounded-lg border border-zinc-300 bg-transparent px-4 py-2.5 outline-none transition-all focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 dark:border-zinc-700" placeholder="Ex: Chaussures de sport">
            </div>

            <!-- Slug -->
            <div class="grid gap-2">
                <label class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Slug (URL)</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" class="w-full rounded-lg border border-zinc-300 bg-transparent px-4 py-2.5 outline-none transition-all focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 dark:border-zinc-700" placeholder="chaussures-de-sport">
            </div>

            <!-- Note: Sous-catégories sont gérées dans une table séparée -->
            <!-- Image -->
            <div class="grid gap-2">
                <label class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Image de la catégorie</label>
                <input type="file" name="image" accept="image/*" class="w-full rounded-lg border border-zinc-300 bg-transparent px-4 py-2 outline-none transition-all focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 dark:border-zinc-700">
            </div>

            <!-- Description -->
            <div class="col-span-1 md:col-span-2 grid gap-2">
                <label class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Description</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border border-zinc-300 bg-transparent px-4 py-2.5 outline-none transition-all focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 dark:border-zinc-700" placeholder="Petite description de la catégorie">{{ old('description', $category->description ?? '') }}</textarea>
            </div>


        </div>

        <div class="mt-4 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-cyan-600 px-6 py-3 font-bold text-white shadow-md transition-all hover:bg-cyan-700 hover:shadow-lg focus:ring-4 focus:ring-cyan-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
