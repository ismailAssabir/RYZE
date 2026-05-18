@extends('admin.layout')
@section('admin')
<h1 class="text-4xl font-black">Produit</h1>

<form
    method="POST"
    enctype="multipart/form-data"
    action="{{ $product->exists ? route('admin.products.update',$product) : route('admin.products.store') }}"
    class="mt-6 grid gap-4"
>
    @csrf
    @if($product->exists)
        @method('PUT')
    @endif

    <input name="name" value="{{ old('name',$product->name) }}" class="rounded border-zinc-300 bg-transparent" placeholder="Nom">
    <input name="sku" value="{{ old('sku',$product->sku) }}" class="rounded border-zinc-300 bg-transparent" placeholder="SKU">

    <select name="category_id" class="rounded border-zinc-300 bg-transparent">
        @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected($product->category_id===$c->id)>{{ $c->name }}</option>
        @endforeach
    </select>

    <select name="brand_id" class="rounded border-zinc-300 bg-transparent">
        <option value="">Sans marque</option>
        @foreach($brands as $b)
            <option value="{{ $b->id }}" @selected($product->brand_id===$b->id)>{{ $b->name }}</option>
        @endforeach
    </select>

    <textarea name="description" class="rounded border-zinc-300 bg-transparent" placeholder="Description">{{ old('description',$product->description) }}</textarea>

    <input name="price" value="{{ old('price',$product->price) }}" class="rounded border-zinc-300 bg-transparent" placeholder="Prix">
    <input name="sale_price" value="{{ old('sale_price',$product->sale_price) }}" class="rounded border-zinc-300 bg-transparent" placeholder="Promo">
    <input name="stock" value="{{ old('stock',$product->stock) }}" class="rounded border-zinc-300 bg-transparent" placeholder="Stock">

    {{-- Product images (upload replaces existing images one-by-one with uploaded ones) --}}
    <div class="grid gap-2">
        <label class="text-sm font-bold">Images du produit</label>
        <input type="file" name="images[]" multiple accept="image/*" class="rounded border-zinc-300 bg-transparent">
        <div class="text-xs text-zinc-500">Astuce: l’image 0 devient primary.</div>
    </div>

    <button class="rounded bg-red-600 px-5 py-3 font-bold text-white">Enregistrer</button>
</form>

@endsection

