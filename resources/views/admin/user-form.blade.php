@extends('admin.layout')
@section('admin')
<div class="mb-6 flex items-center justify-between gap-4">
    <h1 class="text-4xl font-black text-zinc-900 dark:text-white">
        {{ isset($user) && $user->exists ? 'Modifier Utilisateur' : 'Nouvel Utilisateur' }}
    </h1>
    <a href="{{ route('admin.users.index') }}" class="text-sm font-bold text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">Retour à la liste</a>
</div>

<div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-950/50">
    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ isset($user) && $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}"
        class="grid gap-6"
    >
        @csrf
        @if(isset($user) && $user->exists)
            @method('PUT')
        @endif

        <div class="grid gap-6 md:grid-cols-2">
            <!-- Name -->
            <div class="grid gap-2">
                <label class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Nom complet</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required class="w-full rounded-lg border border-zinc-300 bg-transparent px-4 py-2.5 outline-none transition-all focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 dark:border-zinc-700" placeholder="Ex: Jean Dupont">
            </div>

            <!-- Email -->
            <div class="grid gap-2">
                <label class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Adresse e-mail</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required class="w-full rounded-lg border border-zinc-300 bg-transparent px-4 py-2.5 outline-none transition-all focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 dark:border-zinc-700" placeholder="jean@example.com">
            </div>

            <!-- Password -->
            <div class="grid gap-2">
                <label class="text-sm font-bold text-zinc-700 dark:text-zinc-300">
                    Mot de passe
                    @if(isset($user) && $user->exists) <span class="text-xs font-normal text-zinc-500">(Laisser vide pour ne pas modifier)</span> @endif
                </label>
                <input type="password" name="password" {{ isset($user) && $user->exists ? '' : 'required' }} class="w-full rounded-lg border border-zinc-300 bg-transparent px-4 py-2.5 outline-none transition-all focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 dark:border-zinc-700" placeholder="••••••••">
            </div>

            <!-- Role -->
            <div class="grid gap-2">
                <label class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Rôle</label>
                <select name="role" class="w-full rounded-lg border border-zinc-300 bg-transparent px-4 py-2.5 outline-none transition-all focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 dark:border-zinc-700">
                    <option value="user" @selected(old('role', $user->role ?? '') === 'user')>Utilisateur</option>
                    <option value="admin" @selected(old('role', $user->role ?? '') === 'admin')>Administrateur</option>
                </select>
            </div>
            
            <!-- Phone -->
            <div class="grid gap-2">
                <label class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Téléphone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="w-full rounded-lg border border-zinc-300 bg-transparent px-4 py-2.5 outline-none transition-all focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 dark:border-zinc-700" placeholder="+212 600 000 000">
            </div>

            <!-- Avatar -->
            <div class="grid gap-2">
                <label class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Avatar</label>
                <input type="file" name="avatar" accept="image/*" class="w-full rounded-lg border border-zinc-300 bg-transparent px-4 py-2 outline-none transition-all focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 dark:border-zinc-700">
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
