<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'OptiStock' }} — Inventory Management System</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="app-layout">
       <!-- Sidebar Navigasi Kiri -->
        <aside class="app-sidebar">
            <a href="{{ auth()->check() ? route('dashboard') : route('catalog') }}" class="sidebar-brand">
                <span class="brand-dot"></span>
                <span>Opti<strong>Stock</strong></span>
            </a>

            <nav class="sidebar-nav">
                @auth
                    {{-- 1. Menu Utama --}}
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('products.index') }}" class="sidebar-link {{ request()->routeIs('products.*') || request()->routeIs('catalog') ? 'active' : '' }}">
                        Katalog Produk
                    </a>

                    {{-- Garis Pembatas 1 --}}
                    <div style="border-top: 1.5px solid #cbd5e1; width: 100%; flex-shrink: 0; margin: 10px 0;"></div>

                    {{-- 2. Operasional Stok --}}
                    <a href="{{ route('stock.in') }}" class="sidebar-link {{ request()->routeIs('stock.in') ? 'active' : '' }}">
                        Stok Masuk
                    </a>
                    <a href="{{ route('stock.out') }}" class="sidebar-link {{ request()->routeIs('stock.out') ? 'active' : '' }}">
                        Stok Keluar
                    </a>
                    <a href="{{ route('stock.history') }}" class="sidebar-link {{ request()->routeIs('stock.history') ? 'active' : '' }}">
                        Histori Mutasi
                    </a>

                    @if(auth()->user()->role === 'admin')
                        {{-- Garis Pembatas 2 --}}
                        <div style="border-top: 1.5px solid #cbd5e1; width: 100%; flex-shrink: 0; margin: 10px 0;"></div>

                        {{-- 3. Master Data --}}
                        <a href="{{ route('categories.index') }}" class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            Kategori
                        </a>
                        <a href="{{ route('suppliers.index') }}" class="sidebar-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                            Supplier
                        </a>
                        <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            Kelola User
                        </a>
                    @endif
                @else
                    <a href="{{ route('catalog') }}" class="sidebar-link active">
                        Katalog Publik
                    </a>
                @endauth
            </nav>

            <!-- Profil & Logout -->
            <div class="sidebar-footer">
                @auth
                    <div class="user-profile-badge">
                        <div>
                            <div style="font-size: 0.85rem; font-weight: 700; color: #0f172a;">{{ auth()->user()->username }}</div>
                            <div style="font-size: 0.7rem; font-weight: 800; color: #059669; text-transform: uppercase;">{{ auth()->user()->role }}</div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: #ef4444; font-size: 0.8rem; font-weight: 700; cursor: pointer;">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%;">
                        Login Petugas →
                    </a>
                @endauth
            </div>
        </aside>

        <!-- Area Konten Utama Kanan -->
        <div class="app-main">
            <header class="top-header">
                <div style="font-size: 0.95rem; font-weight: 600; color: #64748b;">
                    Sistem Manajemen Inventaris Toko
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('products.create') }}" class="btn btn-primary" style="font-size: 0.82rem; padding: 0.5rem 1rem;">
                                + Tambah Produk
                            </a>
                        @endif
                    @endauth
                </div>
            </header>

            <main class="main-content">
                @if (session('success'))
                    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 600;">
                        ✓ {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 600;">
                        ⚠ {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>