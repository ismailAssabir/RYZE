@extends('layouts.app')
@section('title','Inscription')
@section('content')
<section class="mx-auto max-w-md px-4 py-16"><h1 class="text-4xl font-black">Inscription</h1>
<form method="POST" action="{{ route('register') }}" class="mt-6 grid gap-4">@csrf
    <input name="name" class="rounded border-zinc-300 bg-transparent" placeholder="Nom" required>
    <input name="email" type="email" class="rounded border-zinc-300 bg-transparent" placeholder="Email" required>
    <input name="password" type="password" class="rounded border-zinc-300 bg-transparent" placeholder="Mot de passe" required>
    <input name="password_confirmation" type="password" class="rounded border-zinc-300 bg-transparent" placeholder="Confirmation" required>
    <button class="rounded bg-red-600 px-5 py-3 font-bold text-white">Creer le compte</button>
</form></section>
@endsection
