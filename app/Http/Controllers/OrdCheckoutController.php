<?php

namespace App\Http\Controllers;

use App\Services\AdyService;
use Illuminate\Http\Request;

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

        return view('pages.ord-checkout', [
            'product' => $productData,
            'fromCache' => $productsData['from_cache'] ?? false,
        ]);
    }

    /**
     * Process order submission
     */
    public function submit(Request $request)
    {
        $request->validate([
            'uuid' => 'required|string',
            'imei' => 'nullable|string|max:50',
            'serial' => 'nullable|string|max:100',
            'email' => 'required|email',
            'notes' => 'nullable|string|max:500',
        ]);

        // TODO: Implement order submission to ADY API
        // For now, redirect back with message
        return redirect('/ord-services')->with('info', 'Tính năng đặt hàng đang được phát triển. Vui lòng liên hệ Zalo để đặt hàng.');
    }
}
