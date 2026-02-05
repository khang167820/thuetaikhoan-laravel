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
    
    /**
     * Show deposit success page
     */
    public function success(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('deposit');
        }
        
        $user = Auth::user();
        $amount = $request->query('amount', 0);
        
        return view('pages.deposit-success', compact('user', 'amount'));
    }
    
    /**
     * Create a new deposit request
     * This saves the deposit to database so webhook can find it
     */
    public function create(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Chưa đăng nhập']);
        }
        
        $user = Auth::user();
        $amount = (int) $request->input('amount', 0);
        $method = $request->input('method', 'bank');
        
        if ($amount < 10000) {
            return response()->json(['success' => false, 'message' => 'Số tiền tối thiểu là 10,000đ']);
        }
        
        // Generate unique transaction ID
        $transactionId = 'NAP' . time() . $user->id;
        
        // Save to database
        $depositId = DB::table('deposits')->insertGetId([
            'user_id' => $user->id,
            'amount' => $amount,
            'method' => $method,
            'status' => 'pending',
            'transaction_id' => $transactionId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return response()->json([
            'success' => true,
            'deposit_id' => $depositId,
            'transaction_id' => $transactionId,
            'amount' => $amount,
        ]);
    }
}

