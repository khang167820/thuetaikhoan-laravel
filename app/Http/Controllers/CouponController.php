<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    /**
     * Display the coupons page
     */
    public function index()
    {
        // Get active coupons from database
        $coupons = DB::table('coupons')
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.coupons', compact('coupons'));
    }
}
