<?php

namespace App\Http\Controllers;

use App\Helpers\OrderHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        
        // Get stats safely
        $totalDeposited = 0;
        $totalSpent = 0;
        
        try {
            if (Schema::hasTable('deposits')) {
                $totalDeposited = DB::table('deposits')
                    ->where('user_id', $user->id)
                    ->where('status', 'success')
                    ->sum('amount') ?? 0;
            }
        } catch (\Exception $e) {
            $totalDeposited = 0;
        }
        
        try {
            if (Schema::hasTable('orders')) {
                // Try different column names for price
                $priceColumn = 'total_price'; // Default
                if (Schema::hasColumn('orders', 'price')) {
                    $priceColumn = 'price';
                } elseif (Schema::hasColumn('orders', 'total_price')) {
                    $priceColumn = 'total_price';
                } elseif (Schema::hasColumn('orders', 'amount')) {
                    $priceColumn = 'amount';
                } else {
                    $priceColumn = null;
                }
                
                if ($priceColumn) {
                    $totalSpent = DB::table('orders')
                        ->where('user_id', $user->id)
                        ->whereIn('status', ['completed', 'active', 'success'])
                        ->sum($priceColumn) ?? 0;
                }
            }
        } catch (\Exception $e) {
            $totalSpent = 0;
        }
        
        // Get recent transactions safely
        $transactions = collect();
        
        try {
            // Get deposits
            if (Schema::hasTable('deposits')) {
                $recentDeposits = DB::table('deposits')
                    ->where('user_id', $user->id)
                    ->where('status', 'success')
                    ->select('id', 'note as service_name', 'amount as price', 'created_at', DB::raw("'deposit' as type"))
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
                $transactions = $transactions->merge($recentDeposits);
            }
            
            // Get orders if table and columns exist
            if (Schema::hasTable('orders')) {
                $serviceNameCol = Schema::hasColumn('orders', 'service_name') ? 'service_name' : 
                                 (Schema::hasColumn('orders', 'product_name') ? 'product_name' : 
                                 (Schema::hasColumn('orders', 'name') ? 'name' : 'id'));
                
                $priceCol = Schema::hasColumn('orders', 'price') ? 'price' : 
                           (Schema::hasColumn('orders', 'total_price') ? 'total_price' : 
                           (Schema::hasColumn('orders', 'amount') ? 'amount' : null));
                
                if ($priceCol) {
                    $recentOrders = DB::table('orders')
                        ->where('user_id', $user->id)
                        ->select('id', DB::raw("$serviceNameCol as service_name"), DB::raw("$priceCol as price"), 'created_at', DB::raw("'order' as type"))
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->get();
                    $transactions = $transactions->merge($recentOrders);
                }
            }
        } catch (\Exception $e) {
            // Silent fail - just show empty transactions
        }
        
        // Sort by date and limit
        $transactions = $transactions->sortByDesc('created_at')->take(10)->values();
        
        return view('pages.account', compact('user', 'totalDeposited', 'totalSpent', 'transactions'));
    }
}
