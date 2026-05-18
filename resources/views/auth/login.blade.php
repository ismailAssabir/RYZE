@extends('layouts.app')
@section('title','Connexion')
@section('content')
<section class="mx-auto max-w-md px-4 py-16"><h1 class="text-4xl font-black">Connexion</h1>
<form method="POST" action="{{ route('login') }}" class="mt-6 grid gap-4">@csrf
    <input name="email" type="email" class="rounded border-zinc-300 bg-transparent" placeholder="Email" required>
    <input name="password" type="password" class="rounded border-zinc-300 bg-transparent" placeholder="Mot de passe" required>
    <label class="text-sm"><input type="checkbox" name="remember"> Remember me</label>
    <button class="rounded bg-red-600 px-5 py-3 font-bold text-white">Se connecter</button>
    <a href="{{ route('password.request') }}" class="text-sm text-red-600">Mot de passe oublie ?</a>
</form></section>
@endsection
