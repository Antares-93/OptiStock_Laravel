@extends('layouts.app')

@section('content')
<div style="display: grid; grid-template-columns: 340px 1fr; gap: 2rem; align-items: start;">
    <div class="form-card">
        <h3 style="font-size: 1.15rem; font-weight: 800; margin-bottom: 1.25rem;">Buat Akun Petugas</h3>
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="Nama Lengkap" class="form-control" placeholder="Masukkan Nama Lengkap" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password (Minimal 4 karakter)" required>
            </div>
            <div class="form-group">
                <label>Role Hak Akses</label>
                <select name="role" class="form-control" required>
                    <option value="staff">Staff Gudang</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan User</button>
        </form>
    </div>

    <div class="table-card">
        <div class="table-header-info">
            <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800;">Daftar Pengguna Sistem</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>PENGGUNA</th>
                        <th>ROLE</th>
                        <th style="width: 100px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                        <tr>
                            <td>
                                <strong>{{ $u->name }}</strong>
                                <div style="font-size: 0.8rem; color: #64748b;">@<span>{{ $u->username }}</span> • {{ $u->email }}</div>
                            </td>
                            <td>
                                <span class="stock-badge stock-available">{{ strtoupper($u->role) }}</span>
                            </td>
                            <td>
                                @if($u->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-weight: 700;">Hapus</button>
                                    </form>
                                @else
                                    <span style="font-size: 0.8rem; color: #94a3b8;">Sedang Aktif</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection