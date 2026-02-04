<?php

namespace App\Http\Controllers;

use App\Helpers\OrderHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Show account dashboard
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        // Get stats
        $totalDeposited = DB::table('deposits')
            ->where('user_id', $user->id)
            ->where('status', 'success')
            ->sum('amount') ?? 0;
        
        $totalSpent = DB::table('orders')
            ->where('user_id', $user->id)
            ->whereIn('status', ['completed', 'active'])
            ->sum('price') ?? 0;
        
        // Get recent transactions (orders + deposits combined)
        $recentOrders = DB::table('orders')
            ->where('user_id', $user->id)
            ->select('id', 'service_name', 'price', 'created_at', DB::raw("'order' as type"))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $recentDeposits = DB::table('deposits')
            ->where('user_id', $user->id)
            ->where('status', 'success')
            ->select('id', 'note as service_name', 'amount as price', 'created_at', DB::raw("'deposit' as type"))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Merge and sort by date
        $transactions = $recentOrders->merge($recentDeposits)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();
        
        return view('pages.account', compact('user', 'totalDeposited', 'totalSpent', 'transactions'));
    }
}
