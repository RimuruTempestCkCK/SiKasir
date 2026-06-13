<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PimpinanController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $store = Store::where('user_id', $user->id)->first();
        
        if (!$store) {
            return redirect('/login')->withErrors(['msg' => 'Store not found.']);
        }

        // 1. Stats Cards
        $totalProducts = Product::where('store_id', $store->id)->count();
        $totalCashiers = User::where('store_id', $store->id)->where('role', 'kasir')->count();
        $totalSales = Transaction::where('store_id', $store->id)->sum('total_price') ?: 0;
        $totalStock = Product::where('store_id', $store->id)->sum('stock') ?: 0;
        
        $totalProfit = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.store_id', $store->id)
            ->selectRaw('SUM((transaction_details.selling_price - transaction_details.purchase_price) * transaction_details.quantity) as profit')
            ->first()->profit ?: 0;

        // 2. Total Sales by Category (Donut Chart)
        $salesByCategory = TransactionDetail::join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.store_id', $store->id)
            ->selectRaw('categories.name as category, SUM(transaction_details.quantity * transaction_details.selling_price) as total')
            ->groupBy('categories.name')
            ->get();

        // 3. Monthly Sales (Bar Chart - Last 6 Months)
        $monthlySales = Transaction::where('store_id', $store->id)
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("DATE_FORMAT(created_at, '%b') as month, SUM(total_price) as total")
            ->groupBy('month')
            ->orderBy('created_at')
            ->get();

        // 4. Earning Statistics (Area Chart - Last 7 Days)
        $salesDaily = Transaction::where('store_id', $store->id)
            ->where('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 5. Recent Activity (Latest Transactions)
        $recentTransactions = Transaction::where('store_id', $store->id)
            ->with('cashier')
            ->latest()
            ->take(3)
            ->get();

        // 6. Top Products (Leader Table)
        $topProducts = TransactionDetail::join('products', 'transaction_details.product_id', '=', 'products.id')
            ->where('products.store_id', $store->id)
            ->selectRaw('products.id, products.name, products.selling_price, SUM(transaction_details.quantity) as total_qty, SUM(transaction_details.quantity * transaction_details.selling_price) as revenue')
            ->groupBy('products.id', 'products.name', 'products.selling_price')
            ->orderBy('revenue', 'desc')
            ->take(5)
            ->get();

        return view('pimpinan.dashboard', compact(
            'store', 'totalProducts', 'totalCashiers', 'totalSales', 'totalStock', 'totalProfit',
            'salesByCategory', 'monthlySales', 'salesDaily', 'recentTransactions', 'topProducts'
        ));
    }

    public function storeInfo()
    {
        $store = Auth::user()->ownedStore;
        return view('pimpinan.store', compact('store'));
    }

    public function product()
    {
        $store = Auth::user()->ownedStore;
        $products = Product::where('store_id', $store->id)->with('category')->get();
        $categories = Category::where('store_id', $store->id)->get();
        return view('pimpinan.product', compact('products', 'categories'));
    }

    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $store = Auth::user()->ownedStore;

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('products', 'public');
        }

        Product::create([
            'store_id' => $store->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'stock' => $request->stock,
            'photo' => $photoPath,
        ]);

        return redirect()->back()->with('success', 'Product added successfully.');
    }

    public function productUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('photo')) {
            if ($product->photo) {
                Storage::disk('public')->delete($product->photo);
            }
            $product->photo = $request->file('photo')->store('products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
        ]);

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    public function productDelete($id)
    {
        $product = Product::findOrFail($id);
        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function kasir()
    {
        $store = Auth::user()->ownedStore;
        $cashiers = User::where('store_id', $store->id)->where('role', 'kasir')->get();
        return view('pimpinan.kasir', compact('cashiers'));
    }

    public function kasirStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $store = Auth::user()->ownedStore;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'kasir',
            'store_id' => $store->id,
        ]);

        return redirect()->back()->with('success', 'Cashier added successfully.');
    }

    public function kasirUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->back()->with('success', 'Cashier updated successfully.');
    }

    public function kasirDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Cashier deleted successfully.');
    }

    public function stock()
    {
        $store = Auth::user()->ownedStore;
        $products = Product::where('store_id', $store->id)->get();
        return view('pimpinan.stock', compact('products'));
    }

    public function stockAdd(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        \DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);
            $product->increment('stock', $request->quantity);

            StockLog::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $request->quantity,
                'note' => $request->note,
            ]);
        });

        return redirect()->back()->with('success', 'Stock added successfully.');
    }

    public function reportTransaction(Request $request)
    {
        $store = Auth::user()->ownedStore;
        $query = Transaction::where('store_id', $store->id);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                \Carbon\Carbon::parse($startDate)->startOfDay(),
                \Carbon\Carbon::parse($endDate)->endOfDay()
            ]);
        }

        // Clone query for summary totals before pagination
        $summaryQuery = clone $query;
        $totalRevenue = $summaryQuery->sum('total_price');
        $totalTransactionsCount = $summaryQuery->count();
        
        // Manual profit calculation for filtered data to keep it efficient
        $totalProfit = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.store_id', $store->id)
            ->when($startDate && $endDate, function($q) use ($startDate, $endDate) {
                return $q->whereBetween('transactions.created_at', [
                    \Carbon\Carbon::parse($startDate)->startOfDay(),
                    \Carbon\Carbon::parse($endDate)->endOfDay()
                ]);
            })
            ->selectRaw('SUM((transaction_details.selling_price - transaction_details.purchase_price) * transaction_details.quantity) as profit')
            ->first()->profit ?: 0;

        $transactions = $query->with(['cashier', 'details.product'])
            ->latest()
            ->paginate(50)
            ->withQueryString(); // Keep filter parameters when clicking next page

        return view('pimpinan.report.transaction', compact(
            'transactions', 'startDate', 'endDate', 
            'totalRevenue', 'totalProfit', 'totalTransactionsCount'
        ));
    }

    public function reportStock(Request $request)
    {
        $store = Auth::user()->ownedStore;
        $query = StockLog::whereHas('product', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        });

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                \Carbon\Carbon::parse($startDate)->startOfDay(),
                \Carbon\Carbon::parse($endDate)->endOfDay()
            ]);
        }

        // Clone for summary calculations
        $summaryQuery = clone $query;
        $totalStockIn = $summaryQuery->where('type', 'in')->sum('quantity');
        
        $summaryQueryOut = clone $query;
        $totalStockOut = $summaryQueryOut->where('type', 'out')->sum('quantity');
        
        $lowStockProducts = Product::where('store_id', $store->id)->where('stock', '<=', 10)->count();

        $stockLogs = $query->with('product')
            ->latest()
            ->paginate(50)
            ->withQueryString();

        return view('pimpinan.report.stock', compact(
            'stockLogs', 'totalStockIn', 'totalStockOut', 'lowStockProducts', 
            'startDate', 'endDate'
        ));
    }
}
