<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Stats Cards
        $totalUsers = User::count();
        $totalStores = Store::count();
        $totalTransactions = Transaction::count();
        $newUsersToday = User::whereDate('created_at', today())->count();

        // 2. Stores by Category (Donut Chart)
        $storesByCategory = Category::selectRaw('name as category, COUNT(*) as total')
            ->groupBy('name')
            ->get();

        // 3. System Monthly Revenue (Bar Chart)
        $monthlyRevenue = Transaction::where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("DATE_FORMAT(created_at, '%b') as month, SUM(total_price) as total")
            ->groupBy('month')
            ->orderBy('created_at')
            ->get();

        // 4. System Daily Stats (Area Chart)
        $dailyStats = Transaction::where('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 5. Recent Activity
        $recentStores = Store::with('owner')->latest()->take(3)->get();

        // 6. Top Stores
        $topStores = Store::with('owner')
            ->withCount('transactions')
            ->withSum('transactions', 'total_price')
            ->orderBy('transactions_sum_total_price', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalStores', 'totalTransactions', 'newUsersToday',
            'storesByCategory', 'monthlyRevenue', 'dailyStats', 'recentStores', 'topStores'
        ));
    }

    public function user()
    {
        $users = User::with('store')->get();
        $stores = Store::all();
        return view('admin.user', compact('users', 'stores'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required|min:6',
            'store_id' => 'nullable|exists:stores,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'store_id' => $request->store_id,
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function userUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'store_id' => 'nullable|exists:stores,id',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->store_id = $request->store_id;
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function userDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function store()
    {
        $stores = Store::with(['owner', 'cashiers'])->get();
        return view('admin.store', compact('stores'));
    }
}
