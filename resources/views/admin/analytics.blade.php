@extends('admin.layout')
@section('admin')<h1 class="text-4xl font-black">Analytics</h1><div class="mt-6 grid gap-3">@foreach($orders as $row)<div class="rounded bg-zinc-100 p-4 dark:bg-zinc-900">{{ $row->day }} - {{ number_format($row->total,2) }} MAD</div>@endforeach</div>@endsection
