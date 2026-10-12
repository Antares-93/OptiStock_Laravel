@extends('layouts.app')

@section('content')
<div style="max-width: 560px; margin: 1rem auto;">
    <div class="form-card">
        <h2 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-bottom: 0.35rem;">
            Catat Barang Masuk
        </h2>
        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1.5rem;">
            Penambahan stok persediaan barang dari supplier
        </p>

        @if ($errors->any())
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 0.85rem; border-radius: 8px; margin-bottom: 1.25rem; font-size: 0.85rem;">
                @foreach ($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('stock.in') }}">
            @csrf

            <div class="form-group">
                <label>Pilih Produk</label>
                <select name="product_id" class="form-control" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->sku }} — {{ $p->name }} (Sisa stok: {{ $p->stock }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Jumlah Masuk (Unit)</label>
                <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" required>
            </div>

            <div class="form-group">
                <label>Keterangan / Catatan</label>
                <input type="text" name="notes" class="form-control" value="{{ old('notes') }}" placeholder="Contoh: Restock faktur PO-019">
            </div>

            <div style="display: flex; gap: 0.75rem; justify-content: flex-end; margin-top: 1.75rem;">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Stok Masuk</button>
            </div>
        </form>
    </div>
</div>
@endsection