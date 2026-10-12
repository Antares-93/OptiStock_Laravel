@extends('layouts.app')

@section('content')
<div style="display: grid; grid-template-columns: 340px 1fr; gap: 2rem; align-items: start;">
    <div class="form-card">
        <h3 style="font-size: 1.15rem; font-weight: 800; margin-bottom: 1.25rem;">Tambah Supplier</h3>
        <form method="POST" action="{{ route('suppliers.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama Supplier</label>
                <input type="text" name="name" class="form-control" placeholder="PT Mitra Sejahtera" required>
            </div>
            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxx">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" class="form-control" rows="3" placeholder="Alamat gudang / vendor"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Supplier</button>
        </form>
    </div>

    <div class="table-card">
        <div class="table-header-info">
            <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800;">Daftar Supplier</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>SUPPLIER</th>
                        <th>KONTAK & ALAMAT</th>
                        <th style="width: 100px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $s)
                        <tr>
                            <td><strong>{{ $s->name }}</strong></td>
                            <td>
                                <div>📞 {{ $s->phone ?? '-' }}</div>
                                <div style="font-size: 0.8rem; color: #64748b;">📍 {{ $s->address ?? '-' }}</div>
                            </td>
                            <td>
                                <form action="{{ route('suppliers.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus supplier ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-weight: 700;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" style="text-align: center; padding: 2.5rem; color: #94a3b8;">Belum ada supplier.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection