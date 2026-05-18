@extends('layouts.app')
@section('content')<section class="mx-auto max-w-7xl px-4 py-10"><h1 class="text-4xl font-black">Commandes</h1>@foreach($orders as $order)<div class="mt-4 rounded border border-zinc-200 p-4 dark:border-zinc-800">{{ $order->number }} - {{ $order->status }}</div>@endforeach{{ $orders->links() }}</section>@endsection
