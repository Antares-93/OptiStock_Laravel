<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    // Form Barang Masuk
    public function createIn()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.in', compact('products'));
    }

    // Proses Simpan Barang Masuk
    public function storeIn(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
            'notes'      => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::lockForUpdate()->findOrFail($request->product_id);
            $product->increment('stock', $request->quantity);

            StockMovement::create([
                'product_id' => $product->id,
                'user_id'    => auth()->id(),
                'type'       => 'in',
                'quantity'   => $request->quantity,
                'notes'      => $request->notes,
            ]);
        });

        return redirect()->route('stock.history')
            ->with('success', "Stok barang masuk sebanyak {$request->quantity} unit berhasil dicatat.");
    }

    // Form Barang Keluar
    public function createOut()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.out', compact('products'));
    }

    // Proses Simpan Barang Keluar (Cegah Stok Minus)
    public function storeOut(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
            'notes'      => ['nullable', 'string', 'max:255'],
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->withErrors([
                'quantity' => "Stok tidak mencukupi! Sisa stok fisik saat ini hanya {$product->stock} unit."
            ])->withInput();
        }

        DB::transaction(function () use ($request, $product) {
            $lockedProduct = Product::lockForUpdate()->findOrFail($product->id);
            $lockedProduct->decrement('stock', $request->quantity);

            StockMovement::create([
                'product_id' => $lockedProduct->id,
                'user_id'    => auth()->id(),
                'type'       => 'out',
                'quantity'   => $request->quantity,
                'notes'      => $request->notes,
            ]);
        });

        return redirect()->route('stock.history')
            ->with('success', "Stok barang keluar sebanyak {$request->quantity} unit berhasil dicatat.");
    }

    // Histori Mutasi Stok
    public function history()
    {
        $movements = StockMovement::with(['product', 'user'])
            ->latest()
            ->paginate(15);

        return view('stock.history', compact('movements'));
    }
}