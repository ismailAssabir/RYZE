@extends('layouts.app')
@section('content')<section class="mx-auto max-w-7xl px-4 py-10"><h1 class="text-4xl font-black">Wishlist</h1><div class="mt-6 grid gap-5 md:grid-cols-4">@foreach($items as $item)<x-product-card :product="$item->product"/>@endforeach</div></section>@endsection
