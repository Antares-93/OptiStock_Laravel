@extends('layouts.app')

@section('content')
<div style="padding: 1rem 0 2rem;">
    <div style="margin-bottom: 1.75rem;">
        <h2 style="font-size: 1.75rem; font-weight: 800; color: #0f172a; letter-spacing: -0.025em;">Ringkasan Inventaris</h2>
        <p style="color: #64748b; font-size: 0.9rem;">Statistik dan status stok barang gudang terkini</p>
    </div>

    <!-- 4 Kotak Kolom Metrik -->
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-label">Total Jenis Produk</span>
            <span class="stat-value">{{ $totalProducts }}</span>
        </div>

        <div class="stat-card">
            <span class="stat-label">Total Nilai Barang</span>
            <span class="stat-value">Rp {{ number_format($totalValue, 0, ',', '.') }}</span>
        </div>

        <div class="stat-card">
            <span class="stat-label">Total Barang Masuk</span>
            <span class="stat-value in">{{ $totalIn }}</span>
        </div>

        <div class="stat-card">
            <span class="stat-label">Total Barang Keluar</span>
            <span class="stat-value out">{{ $totalOut }}</span>
        </div>
    </div>

    <!-- Tabel Peringatan Stok Rendah -->
    <div class="table-card">
        <div class="table-header-info" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: #b91c1c; font-weight: 700;">Peringatan Stok Rendah / Menipis</h3>
            <span style="font-size: 0.8rem; font-weight: 600; color: #64748b;">Di bawah batas minimum</span>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 140px;">SKU</th>
                        <th>NAMA PRODUK</th>
                        <th>KATEGORI</th>
                        <th style="width: 140px;">SISA STOK</th>
                        <th style="width: 150px;">BATAS MINIMUM</th>
                        <th style="width: 140px;">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowStockProducts as $item)
                        <tr>
                            <td style="font-weight: 700; font-family: monospace;">{{ $item->sku }}</td>
                            <td style="font-weight: 600; color: #0f172a;">{{ $item->name }}</td>
                            <td><span style="color: #475569;">{{ $item->category->name }}</span></td>
                            <td style="font-weight: 800; color: #dc2626;">{{ $item->stock }}</td>
                            <td>{{ $item->minimum_stock }}</td>
                            <td>
                                <span class="stock-badge stock-empty">Perlu Restock</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                Semua stok produk saat ini dalam kondisi aman (di atas batas minimum).
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection