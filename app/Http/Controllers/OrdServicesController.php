<?php

namespace App\Http\Controllers;

use App\Services\AdyService;
use Illuminate\Http\Request;

class OrdServicesController extends Controller
{
    protected $adyService;

    public function __construct(AdyService $adyService)
    {
        $this->adyService = $adyService;
    }

    /**
     * Display the ord-services page (API GSM Services)
     */
    public function index(Request $request)
    {
        $categoryFilter = $request->input('cat');
        $searchQuery = trim($request->input('q', ''));
        
        // Get products from ADY API
        $data = $this->adyService->getProductsByCategory($categoryFilter, $searchQuery);
        
        // Pagination (initial load 30, rest via JS infinite scroll)
        $allProducts = $data['products'];
        $initialLimit = 30;
        $initialProducts = array_slice($allProducts, 0, $initialLimit, true);
        
        // All products for infinite scroll (JSON)
        $allProductsJson = json_encode(array_values($allProducts), JSON_UNESCAPED_UNICODE);
        
        // Category icons for sidebar
        $categoryIcons = $this->adyService->getCategoryIcons();
        
        return view('pages.ord-services', [
            'categoryFilter' => $categoryFilter,
            'searchQuery' => $searchQuery,
            'categories' => $data['categories'],
            'products' => $initialProducts,
            'totalProducts' => $data['total'],
            'filteredCount' => $data['filtered_count'],
            'allProductsJson' => $allProductsJson,
            'categoryIcons' => $categoryIcons,
            'fromCache' => $data['from_cache'],
            'apiError' => $data['api_error'] ?? null,
        ]);
    }
}
