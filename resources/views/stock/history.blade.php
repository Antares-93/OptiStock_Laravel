@extends('layouts.app')

@section('content')
<div style="padding: 1rem 0;">
    <div class="table-card">
        <div class="table-header-info">
            <h3 style="margin: 0;">Riwayat Mutasi Stok Barang</h3>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 180px;">WAKTU</th>
                        <th>PRODUK</th>
                        <th style="width: 120px;">TIPE</th>
                        <th style="width: 110px;">JUMLAH</th>
                        <th>PETUGAS</th>
                        <th>CATATAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movements as $m)
                        <tr>
                            <td style="font-size: 0.85rem; color: #64748b;">
                                {{ $m->created_at->format('d M Y, H:i') }}
                            </td>
                            <td>
                                <strong style="color: #0f172a;">{{ $m->product->name }}</strong>
                                <div style="font-size: 0.78rem; color: #64748b;">SKU: {{ $m->product->sku }}</div>
                            </td>
                            <td>
                                @if ($m->type === 'in')
                                    <span class="stock-badge stock-available">MASUK</span>
                                @else
                                    <span class="stock-badge stock-empty">KELUAR</span>
                                @endif
                            </td>
                            <td style="font-weight: 800; font-size: 1rem; color: #0f172a;">
                                {{ $m->quantity }}
                            </td>
                            <td>{{ $m->user->name ?? 'Sistem' }}</td>
                            <td style="color: #64748b;">{{ $m->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                Belum ada riwayat mutasi barang masuk atau keluar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $movements->links() }}
    </div>
</div>
@endsection