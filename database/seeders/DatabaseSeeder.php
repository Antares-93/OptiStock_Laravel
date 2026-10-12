<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
       // 1. Akun Default Admin & Staff
        $admin = User::create([
            'username' => 'admin',
            'name'     => 'Admin OptiStock',
            'email'    => 'admin@optistock.test',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        User::create([
            'username' => 'staff',
            'name'     => 'Staff Gudang',
            'email'    => 'staff@optistock.test',
            'password' => Hash::make('staff123'),
            'role'     => 'staff',
        ]);
        // 2. Master Kategori
        $cat1 = Category::create(['name' => 'Aksesoris Komputer']);
        $cat2 = Category::create(['name' => 'Elektronik']);

        // 3. Master Supplier
        $sup1 = Supplier::create([
            'name'    => 'PT Sinar Jaya Abadi',
            'phone'   => '081234567890',
            'address' => 'Jakarta Barat',
        ]);

        $sup2 = Supplier::create([
            'name'    => 'CV Mitra Mandiri',
            'phone'   => '089876543210',
            'address' => 'Bandung',
        ]);

        // 4. Produk Awal
        $prod1 = Product::create([
            'category_id'   => $cat1->id,
            'sku'           => '001',
            'name'          => 'Mouse Logitech',
            'price'         => 80000,
            'stock'         => 10,
            'minimum_stock' => 5,
        ]);

        $prod2 = Product::create([
            'category_id'   => $cat1->id,
            'sku'           => '002',
            'name'          => 'Keyboard Asus',
            'price'         => 200000,
            'stock'         => 15,
            'minimum_stock' => 5,
        ]);

        // 5. Relasi Many-to-Many
        $prod1->suppliers()->attach($sup1->id, ['supplier_price' => 75000]);
        $prod2->suppliers()->attach($sup2->id, ['supplier_price' => 185000]);
    }
}