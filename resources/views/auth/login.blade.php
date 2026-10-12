@extends('layouts.app')

@section('content')
<div style="min-height: calc(100vh - 160px); display: flex; align-items: center; justify-content: center;">
    <div style="
        width: 100%;
        max-width: 360px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.75rem 1.5rem;
        box-shadow: 0 4px 15px -2px rgba(15, 23, 42, 0.05);
    ">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">
                Login Petugas
            </h2>
            <p style="font-size: 0.8rem; color: #64748b; margin: 0;">
                Masuk ke sistem kelola inventaris
            </p>
        </div>

        @if ($errors->any())
            <div style="
                background: #fef2f2;
                border: 1px solid #fecaca;
                color: #b91c1c;
                border-radius: 8px;
                padding: 0.65rem 0.85rem;
                font-size: 0.8rem;
                margin-bottom: 1.25rem;
            ">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase;">
                    Username
                </label>
                <input 
                    type="text" 
                    name="username" 
                    value="{{ old('username') }}" 
                    placeholder="Masukkan username" 
                    required 
                    autofocus
                    style="
                        width: 100%;
                        padding: 0.6rem 0.85rem;
                        font-family: inherit;
                        font-size: 0.875rem;
                        background: #f8fafc;
                        border: 1px solid #e2e8f0;
                        border-radius: 8px;
                        outline: none;
                        box-sizing: border-box;
                    "
                >
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase;">
                    Password
                </label>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Masukkan password" 
                    required
                    style="
                        width: 100%;
                        padding: 0.6rem 0.85rem;
                        font-family: inherit;
                        font-size: 0.875rem;
                        background: #f8fafc;
                        border: 1px solid #e2e8f0;
                        border-radius: 8px;
                        outline: none;
                        box-sizing: border-box;
                    "
                >
            </div>

            <button 
                type="submit" 
                class="btn btn-primary"
                style="width: 100%; padding: 0.65rem; font-size: 0.875rem;"
            >
                Masuk
            </button>
        </form>

        <div style="text-align: center; margin-top: 1.25rem;">
            <a href="{{ route('catalog') }}" style="font-size: 0.8rem; color: #64748b; text-decoration: none;">
                ← Kembali ke Katalog
            </a>
        </div>
    </div>
</div>
@endsection