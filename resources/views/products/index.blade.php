@extends('layouts.app')

@section('content')
<div style="margin-top: 0.5rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h1 style="font-size: 1.75rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">
            Katalog Produk
        </h1>
        <p style="color: #64748b; font-size: 0.88rem; margin: 0;">
            Ketersediaan stok barang inventaris secara real-time
        </p>
    </div>
    <div style="font-size: 0.88rem; font-weight: 700; color: #475569;">
        Total: <span style="color: #0f172a;">{{ $products->total() }} Produk</span>
    </div>
</div>

<!-- Form Filter Horizontal di Bagian Atas -->
<div class="top-filter-bar">
    <form method="GET" action="{{ route('products.index') }}" class="top-filter-form">
        <div style="flex: 1; min-width: 250px;">
            <input 
                type="text" 
                name="q" 
                value="{{ request('q') }}" 
                class="form-control" 
                placeholder="Cari nama barang atau SKU..."
            >
        </div>

        <div style="min-width: 200px;">
            <select name="category" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Filter</button>
        @if(request('q') || request('category'))
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>
</div>

<!-- Grid Kartu Produk -->
<div class="products-grid">
    @forelse ($products as $p)
        <div class="product-card">
            <!-- Tampilan Foto Produk -->
            <div class="product-image-box" style="overflow: hidden; background: #f1f5f9;">
                @if ($p->image && file_exists(public_path('uploads/products/' . $p->image)))
                    <img 
                        src="{{ asset('uploads/products/' . $p->image) }}" 
                        alt="{{ $p->name }}" 
                        style="width: 100%; height: 100%; object-fit: cover;"
                    >
                @else
                    <span style="font-size: 3rem; opacity: 0.7;">📦</span>
                @endif
            </div>

            <div class="product-info">
                <div class="product-category-tag">{{ $p->category->name }}</div>
                <div class="product-name">{{ $p->name }}</div>
                <div class="product-sku">SKU: {{ $p->sku }}</div>
                
                <div class="product-footer">
                    <div class="product-price">
                        Rp {{ number_format($p->price, 0, ',', '.') }}
                    </div>
                    <div>
                        @if ($p->stock > 0)
                            <span class="stock-badge stock-available">Tersedia ({{ $p->stock }})</span>
                        @else
                            <span class="stock-badge stock-empty">Habis</span>
                        @endif
                    </div>
                </div>

                <!-- Tombol Edit & Hapus Khusus Admin -->
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div style="display: flex; gap: 0.5rem; margin-top: 0.85rem; padding-top: 0.75rem; border-top: 1px dashed #e2e8f0;">
                        <a href="{{ route('products.edit', $p) }}" class="btn btn-secondary" style="flex: 1; padding: 0.45rem 0.5rem; font-size: 0.78rem;">
                            Edit
                        </a>
                        <form action="{{ route('products.destroy', $p) }}" method="POST" style="flex: 1; margin: 0;" onsubmit="return confirm('Yakin ingin menghapus produk {{ $p->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="width: 100%; padding: 0.45rem 0.5rem; font-size: 0.78rem;">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 4rem 2rem; text-align: center; color: #94a3b8;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🔍</div>
            <div style="font-weight: 700; color: #0f172a;">Produk tidak ditemukan</div>
        </div>
    @endforelse
</div>

<div style="margin-top: 2rem;">
    {{ $products->links() }}
</div>
@endsection