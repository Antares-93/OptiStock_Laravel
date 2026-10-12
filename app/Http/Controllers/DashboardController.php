<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Produk
        $totalProducts = Product::count();

        // 2. Total Nilai Barang (Harga x Stok)
        $totalValue = Product::sum(DB::raw('price * stock'));

        // 3. Total Kuantitas Barang Masuk
        $totalIn = StockMovement::where('type', 'in')->sum('quantity') ?: 0;

        // 4. Total Kuantitas Barang Keluar
        $totalOut = StockMovement::where('type', 'out')->sum('quantity') ?: 0;

        // 5. Produk dengan Sisa Stok <= Batas Minimum
        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock', 'asc')
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalValue',
            'totalIn',
            'totalOut',
            'lowStockProducts'
        ));
    }
}