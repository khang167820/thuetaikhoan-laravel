<?php

namespace App\Http\Controllers;

use App\Services\AdyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdCheckoutController extends Controller
{
    protected AdyService $adyService;

    public function __construct(AdyService $adyService)
    {
        $this->adyService = $adyService;
    }

    /**
     * Display checkout page for GSM API service
     */
    public function show(Request $request)
    {
        $uuid = $request->input('uuid');
        
        if (!$uuid) {
            return redirect('/ord-services')->with('error', 'Vui lòng chọn dịch vụ');
        }

        // Get products from ADY API
        $productsData = $this->adyService->getProducts();
        $products = $productsData['products'] ?? [];

        // Find the product by UUID
        $product = $products[$uuid] ?? null;

        if (!$product) {
            return redirect('/ord-services')->with('error', 'Dịch vụ không tồn tại');
        }

        // Prepare product data for view
        $productData = [
            'uuid' => $uuid,
            'name' => $product['name'] ?? 'Unknown',
            'priceUsd' => (float)($product['price'] ?? 0),
            'priceVnd' => $this->adyService->convertUsdToVnd((float)($product['price'] ?? 0)),
            'deliveryTime' => $product['delivery_time'] ?? 'N/A',
            'category' => $this->adyService->classifyProduct($product['name'] ?? ''),
        ];

        // Get user balance if logged in
        $userBalance = 0;
        if (Auth::check()) {
            $userBalance = Auth::user()->balance ?? 0;
        }

        return view('pages.ord-checkout', [
            'product' => $productData,
            'fromCache' => $productsData['from_cache'] ?? false,
            'userBalance' => $userBalance,
        ]);
    }

    /**
     * Process order submission
     */
    public function submit(Request $request)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'error' => 'Vui lòng đăng nhập để đặt hàng',
                'redirect' => '/login'
            ]);
        }
        
        $request->validate([
            'uuid' => 'required|string',
            'imei' => 'nullable|string|max:50',
            'serial' => 'nullable|string|max:100',
            'email' => 'required|email',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $uuid = $request->input('uuid');
        $email = $request->input('email');
        $imei = $request->input('imei', '');
        $serial = $request->input('serial', '');
        $notes = $request->input('notes', '');
        
        // Get product to calculate price
        $productsData = $this->adyService->getProducts();
        $products = $productsData['products'] ?? [];
        $product = $products[$uuid] ?? null;
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'error' => 'Sản phẩm không tồn tại'
            ]);
        }
        
        $priceVnd = $this->adyService->convertUsdToVnd((float)($product['price'] ?? 0));
        
        // Build fields for ADY API
        $fields = [
            'IMEI' => $imei,
            'Serial' => $serial,
            'Email' => $email,
            'Notes' => $notes,
            'Quantity' => 1,
        ];
        
        // Remove empty fields
        $fields = array_filter($fields, fn($v) => $v !== '' && $v !== null);
        
        // Process order
        $result = $this->adyService->processOrder(
            Auth::id(),
            $uuid,
            $fields,
            $priceVnd
        );
        
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'tracking_code' => $result['tracking_code'],
                'order_id' => $result['order_id'],
                'redirect' => '/don-ady?code=' . $result['tracking_code']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => $result['error']
            ]);
        }
    }
    
    /**
     * Display order result page
     */
    public function orderResult(Request $request)
    {
        $code = $request->input('code');
        
        if (!$code || !Auth::check()) {
            return redirect('/ord-services');
        }
        
        $order = \Illuminate\Support\Facades\DB::table('ady_orders')
            ->where('tracking_code', $code)
            ->where('user_id', Auth::id())
            ->first();
            
        if (!$order) {
            return redirect('/ord-services')->with('error', 'Không tìm thấy đơn hàng');
        }
        
        return view('pages.ord-result', compact('order'));
    }
}
