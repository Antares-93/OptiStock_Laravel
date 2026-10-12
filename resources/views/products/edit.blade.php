@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 1rem auto;">
    <div class="form-card">
        <h2 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-bottom: 0.35rem;">
            Edit Data Produk
        </h2>
        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1.5rem;">
            Perbarui data detail barang atau foto produk
        </p>

        @if ($errors->any())
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 0.85rem; border-radius: 8px; margin-bottom: 1.25rem; font-size: 0.85rem;">
                @foreach ($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($product->image && file_exists(public_path('uploads/products/' . $product->image)))
                <div style="margin-bottom: 1.25rem; text-align: center;">
                    <img 
                        src="{{ asset('uploads/products/' . $product->image) }}" 
                        alt="{{ $product->name }}" 
                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 1px solid #e2e8f0;"
                    >
                    <div style="font-size: 0.78rem; color: #64748b; margin-top: 0.3rem;">Foto saat ini</div>
                </div>
            @endif

            <div class="form-group">
                <label>Ganti Foto Produk (Opsional)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label>Kode SKU</label>
                <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
            </div>

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" class="form-control" required>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Harga Satuan (Rp)</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label>Batas Minimum Stok</label>
                    <input type="number" name="minimum_stock" class="form-control" value="{{ old('minimum_stock', $product->minimum_stock) }}" min="0" required>
                </div>
            </div>

            <div style="display: flex; gap: 0.75rem; justify-content: flex-end; margin-top: 1.75rem;">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection