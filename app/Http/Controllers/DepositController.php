<?php

namespace App\Http\Controllers;

use App\Helpers\OrderHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    /**
     * Show deposit page
     */
    public function index()
    {
        $user = Auth::user();
        $bankInfo = OrderHelper::getBankInfo();
        
        // Generate unique deposit code for this user
        $depositCode = $user ? 'NAP' . $user->id . date('dmy') : 'NAP' . time();
        
        // Get deposit history if logged in
        $deposits = collect();
        if ($user) {
            $deposits = DB::table('deposits')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
        }
        
        return view('pages.deposit', compact('bankInfo', 'depositCode', 'user', 'deposits'));
    }
    
    /**
     * Check deposit status (for AJAX polling)
     */
    public function checkStatus(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Chưa đăng nhập']);
        }
        
        $user = Auth::user();
        
        // Check for new deposits in last 5 minutes
        $recentDeposit = DB::table('deposits')
            ->where('user_id', $user->id)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->orderBy('created_at', 'desc')
            ->first();
        
        if ($recentDeposit) {
            return response()->json([
                'success' => true,
                'deposit' => $recentDeposit,
                'balance' => $user->balance,
            ]);
        }
        
        return response()->json([
            'success' => false,
            'balance' => $user->balance,
        ]);
    }
}
