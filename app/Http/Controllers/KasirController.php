<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function dashboard()
    {
        $storeId = Auth::user()->store_id;

        // 1. Stats Cards
        $todaySales = Transaction::where('store_id', $storeId)
            ->whereDate('created_at', today())
            ->sum('total_price');
        $lowStockCount = Product::where('store_id', $storeId)
            ->where('stock', '<', 10)
            ->count();
        $todayTransactionsCount = Transaction::where('store_id', $storeId)
            ->whereDate('created_at', today())
            ->count();
        $totalProducts = Product::where('store_id', $storeId)->count();
        
        // 2. Sales by Category (Donut Chart - Today)
        $salesByCategory = TransactionDetail::join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.store_id', $storeId)
            ->whereDate('transactions.created_at', today())
            ->selectRaw('categories.name as category, SUM(transaction_details.quantity * transaction_details.selling_price) as total')
            ->groupBy('categories.name')
            ->get();

        // 3. Hourly Sales (Bar Chart - Today)
        $hourlySales = Transaction::where('store_id', $storeId)
            ->whereDate('created_at', today())
            ->selectRaw('HOUR(created_at) as hour, SUM(total_price) as total')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        // 4. Personal Sales Trend (Area Chart - Last 7 Days)
        $salesDaily = Transaction::where('store_id', $storeId)
            ->where('user_id', Auth::id())
            ->where('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 5. Recent Activity (My Latest Transactions)
        $recentTransactions = Transaction::where('user_id', Auth::id())
            ->latest()
            ->take(3)
            ->get();

        // 6. Top Products (Leader Table - Today)
        $topProducts = TransactionDetail::join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.store_id', $storeId)
            ->whereDate('transactions.created_at', today())
            ->selectRaw('products.id, products.name, products.selling_price, SUM(transaction_details.quantity) as total_qty, SUM(transaction_details.quantity * transaction_details.selling_price) as revenue')
            ->groupBy('products.id', 'products.name', 'products.selling_price')
            ->orderBy('revenue', 'desc')
            ->take(5)
            ->get();

        return view('kasir.dashboard', compact(
            'todaySales', 'lowStockCount', 'todayTransactionsCount', 'totalProducts',
            'salesByCategory', 'hourlySales', 'salesDaily', 'recentTransactions', 'topProducts'
        ));
    }

    public function transaction()
    {
        $storeId = Auth::user()->store_id;
        $products = Product::where('store_id', $storeId)->where('stock', '>', 0)->get();
        return view('kasir.transaction', compact('products'));
    }

    public function transactionStore(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'amount_paid' => 'required|numeric',
            'transaction_date' => 'nullable|date',
        ]);

        $storeId = Auth::user()->store_id;
        $totalPrice = 0;

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $totalPrice += $product->selling_price * $item['quantity'];
        }

        if ($request->amount_paid < $totalPrice) {
            return redirect()->back()->withErrors(['msg' => 'Amount paid is not enough.']);
        }

        try {
            DB::beginTransaction();

            $createdAt = $request->transaction_date ? $request->transaction_date . ' ' . date('H:i:s') : now();

            $transaction = Transaction::create([
                'store_id' => $storeId,
                'user_id' => Auth::id(),
                'invoice_number' => 'INV-' . time(),
                'total_price' => $totalPrice,
                'amount_paid' => $request->amount_paid,
                'change' => $request->amount_paid - $totalPrice,
                'created_at' => $createdAt,
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'purchase_price' => $product->purchase_price,
                    'selling_price' => $product->selling_price,
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Transaction completed successfully. Invoice: ' . $transaction->invoice_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function history()
    {
        $storeId = Auth::user()->store_id;
        $transactions = Transaction::where('store_id', $storeId)
            ->where('user_id', Auth::id())
            ->with('details.product')
            ->latest()
            ->paginate(10);
            
        return view('kasir.history', compact('transactions'));
    }

    public function stock()
    {
        $storeId = Auth::user()->store_id;
        $products = Product::where('store_id', $storeId)->get();
        return view('kasir.stock', compact('products'));
    }
}
