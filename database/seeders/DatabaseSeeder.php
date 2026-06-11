<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        User::create([
            'name' => 'Admin System',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $storeData = [
            [
                'name' => 'Toko Sembako Jaya',
                'pimpinan_email' => 'pimpinan@gmail.com',
                'kasir_emails' => ['kasir@gmail.com', 'kasir2@gmail.com'],
                'type' => 'Retail',
                'categories' => ['Makanan', 'Minuman', 'Bumbu Dapur', 'Kebutuhan Mandi', 'Snack']
            ],
            [
                'name' => 'Warung Berkah',
                'pimpinan_email' => 'pimpinan2@gmail.com',
                'kasir_emails' => ['kasir3@gmail.com'],
                'type' => 'Grosir',
                'categories' => ['Sembako', 'Elektronik Ringan', 'Alat Tulis']
            ]
        ];

        foreach ($storeData as $index => $data) {
            // Create Pimpinan
            $pimpinan = User::create([
                'name' => 'Pimpinan ' . ($index + 1),
                'email' => $data['pimpinan_email'],
                'password' => Hash::make('password'),
                'role' => 'pimpinan',
            ]);

            // Create Store
            $store = Store::create([
                'user_id' => $pimpinan->id,
                'name' => $data['name'],
                'address' => 'Alamat ' . $data['name'],
                'phone' => '0812' . rand(10000000, 99999999),
                'type' => $data['type'],
            ]);

            $pimpinan->update(['store_id' => $store->id]);

            // Create Kasirs
            $kasirs = [];
            foreach ($data['kasir_emails'] as $kIndex => $email) {
                $kasirs[] = User::create([
                    'name' => 'Kasir ' . ($index + 1) . '-' . ($kIndex + 1),
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => 'kasir',
                    'store_id' => $store->id,
                ]);
            }

            // Create Categories and Products
            foreach ($data['categories'] as $catName) {
                $category = Category::create([
                    'store_id' => $store->id,
                    'name' => $catName,
                ]);

                // Create 3-5 Products per Category
                for ($i = 1; $i <= rand(3, 5); $i++) {
                    $product = Product::create([
                        'store_id' => $store->id,
                        'category_id' => $category->id,
                        'name' => $catName . ' Produk ' . $i,
                        'price' => rand(10, 100) * 500,
                        'stock' => 200, // Initial stock
                    ]);

                    // Initial Stock Log
                    StockLog::create([
                        'product_id' => $product->id,
                        'type' => 'in',
                        'quantity' => 200,
                        'note' => 'Stok awal',
                        'created_at' => Carbon::now()->subDays(31),
                    ]);
                }
            }

            // Create Transactions for the last 30 days
            $products = Product::where('store_id', $store->id)->get();
            
            for ($d = 30; $d >= 0; $d--) {
                $date = Carbon::now()->subDays($d);
                
                // 3-10 transactions per day
                $dailyTransCount = rand(3, 10);
                for ($t = 1; $t <= $dailyTransCount; $t++) {
                    $cashier = $kasirs[array_rand($kasirs)];
                    
                    // Random 1-5 products per transaction
                    $transDetails = [];
                    $totalPrice = 0;
                    $selectedProducts = $products->random(rand(1, min(5, $products->count())));

                    foreach ($selectedProducts as $prod) {
                        $qty = rand(1, 3);
                        $totalPrice += $prod->price * $qty;
                        $transDetails[] = [
                            'product_id' => $prod->id,
                            'quantity' => $qty,
                            'price' => $prod->price,
                        ];
                        
                        // Update product stock (simple way)
                        $prod->decrement('stock', $qty);
                    }

                    $amountPaid = ceil($totalPrice / 5000) * 5000;
                    if ($amountPaid < $totalPrice) $amountPaid += 5000;

                    $transaction = Transaction::create([
                        'store_id' => $store->id,
                        'user_id' => $cashier->id,
                        'invoice_number' => 'INV-' . $store->id . '-' . $date->format('Ymd') . '-' . str_pad($t, 3, '0', STR_PAD_LEFT),
                        'total_price' => $totalPrice,
                        'amount_paid' => $amountPaid,
                        'change' => $amountPaid - $totalPrice,
                        'created_at' => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                    ]);

                    foreach ($transDetails as $detail) {
                        TransactionDetail::create([
                            'transaction_id' => $transaction->id,
                            'product_id' => $detail['product_id'],
                            'quantity' => $detail['quantity'],
                            'price' => $detail['price'],
                            'created_at' => $transaction->created_at,
                        ]);
                    }
                }
            }
        }
    }
}
