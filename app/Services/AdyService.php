<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdyService
{
    const API_ENDPOINT = 'https://api.adyunlocker.com';
    const CACHE_TTL = 3600; // 1 hour

    /**
     * Get ADY API token from settings
     */
    public function getToken(): string
    {
        $setting = DB::table('settings')->where('key', 'ady_api_token')->first();
        return $setting?->value ?? '';
    }

    /**
     * Get USD to VND exchange rate
     */
    public function getUsdRate(): float
    {
        $setting = DB::table('settings')->where('key', 'usd_to_vnd_rate')->first();
        return (float)($setting?->value ?? 25000);
    }

    /**
     * Get markup percentage
     */
    public function getMarkupPercent(): float
    {
        $setting = DB::table('settings')->where('key', 'ady_markup_percent')->first();
        return (float)($setting?->value ?? 20);
    }

    /**
     * Convert USD to VND with markup
     */
    public function convertUsdToVnd(float $usdPrice): int
    {
        $rate = $this->getUsdRate();
        $markup = 1 + ($this->getMarkupPercent() / 100);
        return (int)round($usdPrice * $rate * $markup);
    }

    /**
     * Call ADY API
     */
    public function callApi(string $method, string $endpoint, array $data = []): array
    {
        $token = $this->getToken();
        if (empty($token)) {
            return ['error' => 'API Token chưa được cấu hình'];
        }

        $url = self::API_ENDPOINT . $endpoint;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->timeout(30);

            if ($method === 'GET') {
                $response = $response->get($url, $data);
            } else {
                $response = $response->post($url, $data);
            }

            if ($response->failed()) {
                return [
                    'error' => 'HTTP ' . $response->status(),
                    'http_code' => $response->status(),
                    'response' => $response->body()
                ];
            }

            $decoded = $response->json();
            if ($decoded !== null) {
                $decoded['http_code'] = $response->status();
                return $decoded;
            }

            return ['raw' => $response->body(), 'http_code' => $response->status()];
        } catch (\Exception $e) {
            Log::error('ADY API Error: ' . $e->getMessage());
            return ['error' => 'API Error: ' . $e->getMessage()];
        }
    }

    /**
     * Get all products from ADY API (with cache)
     */
    public function getProducts(bool $forceRefresh = false): array
    {
        $cacheKey = 'ady_products_laravel';

        if (!$forceRefresh) {
            $cached = Cache::get($cacheKey);
            if ($cached && isset($cached['products'])) {
                $cached['from_cache'] = true;
                return $cached;
            }
        }

        $result = $this->callApi('GET', '/api/reseller/v1/products');

        if (isset($result['error'])) {
            // Try fallback from database cache
            $dbCache = DB::table('settings')->where('key', 'ady_products_cache')->first();
            if ($dbCache && $dbCache->value) {
                $oldCache = json_decode($dbCache->value, true);
                if ($oldCache && !empty($oldCache['products'])) {
                    $oldCache['from_cache'] = true;
                    $oldCache['cache_warning'] = true;
                    $oldCache['api_error'] = $result['error'];
                    return $oldCache;
                }
            }
            return ['success' => false, 'error' => $result['error'], 'products' => []];
        }

        if (isset($result['status']) && $result['status'] === 'success' && isset($result['data'])) {
            $products = $result['data']['products'] ?? [];
            
            $data = [
                'success' => true,
                'currency' => $result['data']['currency'] ?? 'USD',
                'categories' => $result['data']['categories'] ?? [],
                'products' => $products,
                'from_cache' => false
            ];

            // Cache in memory and database
            if (!empty($products)) {
                Cache::put($cacheKey, $data, self::CACHE_TTL);
                
                // Also save to database for fallback
                DB::table('settings')->updateOrInsert(
                    ['key' => 'ady_products_cache'],
                    ['value' => json_encode($data), 'updated_at' => now()]
                );
            }

            return $data;
        }

        return ['success' => false, 'error' => 'Invalid response format', 'products' => []];
    }

    /**
     * Classify product into category based on name
     */
    public function classifyProduct(string $productName): string
    {
        $name = strtolower($productName);
        
        $categoryKeywords = [
            'iCloud & FMI' => ['icloud', 'fmi', 'find my', 'findmy', 'activation lock'],
            'Carrier Unlock' => ['carrier', 'network unlock', 'sim unlock', 'factory unlock', 'unlock code'],
            'IMEI Check' => ['imei', 'check', 'blacklist', 'carrier check', 'gsma'],
            'Samsung' => ['samsung', 'galaxy', 'frp samsung'],
            'Apple / iPhone' => ['apple', 'iphone', 'ipad', 'ios', 'macbook', 'apple id'],
            'Xiaomi' => ['xiaomi', 'redmi', 'poco', 'mi account', 'miui'],
            'Huawei' => ['huawei', 'honor', 'huawei id'],
            'Bypass A12+' => [
                'a12+', 'a12 plus', 'hfz', 'hello screen a12', 'bypass a12', 'frp a12',
                'activator a12', 'xr to ', 'xs to ', '11 to ', '12 to ', '13 to ',
                'frpfile', 'iremove', 'mina', 'frp king', 'ramdisk',
            ],
            'FRP Bypass' => ['frp', 'google account', 'bypass', 'passcode', 'hello'],
            'MDM & Supervision' => ['mdm', 'supervision', 'remote management'],
            'Mua sơ đồ' => [
                'schematic', 'schematics', 'sơ đồ', 'diagram', 'boardview',
                'borneo', 'jcid', 'orion', 'estech', 'zxw', 'wuxinji',
            ],
            'Software & Tools' => ['tool', 'software', 'license', 'unlocktool', 'chimera', 'octoplus', 'z3x', 'umt', 'mrt', 'nck'],
            'Server Credits' => ['credit', 'server', 'pack'],
            'Data Services' => ['data plan', 'esim', 'topup', 'recharge'],
            'Gift Cards' => ['gift card', 'itunes', 'google play', 'steam', 'playstation', 'xbox'],
            'Game' => ['game', 'gaming', 'pubg', 'free fire', 'mobile legends'],
        ];

        foreach ($categoryKeywords as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($name, strtolower($keyword)) !== false) {
                    return $category;
                }
            }
        }

        return 'Khác';
    }

    /**
     * Get products grouped by category with counts
     */
    public function getProductsByCategory(string $categoryFilter = null, string $searchQuery = null): array
    {
        $productsData = $this->getProducts();
        $products = $productsData['products'] ?? [];

        $categoryCount = [];
        $filteredProducts = [];

        foreach ($products as $uuid => $product) {
            $name = $product['name'] ?? '';
            $category = $this->classifyProduct($name);

            // Count by category
            if (!isset($categoryCount[$category])) {
                $categoryCount[$category] = 0;
            }
            $categoryCount[$category]++;

            // Apply filters
            if ($categoryFilter && $category !== $categoryFilter) continue;
            if ($searchQuery && stripos($name, $searchQuery) === false) continue;

            $filteredProducts[$uuid] = [
                'uuid' => $uuid,
                'name' => $name,
                'category' => $category,
                'priceUsd' => (float)($product['price'] ?? 0),
                'priceVnd' => $this->convertUsdToVnd((float)($product['price'] ?? 0)),
                'deliveryTime' => $product['delivery_time'] ?? 'N/A'
            ];
        }

        // Sort categories by count descending
        arsort($categoryCount);
        
        // Move "Khác" to end
        if (isset($categoryCount['Khác'])) {
            $khac = $categoryCount['Khác'];
            unset($categoryCount['Khác']);
            $categoryCount['Khác'] = $khac;
        }

        // Pin priority categories
        $pinCats = ['Mua sơ đồ', 'Bypass A12+'];
        $pinned = [];
        foreach ($pinCats as $c) {
            if (isset($categoryCount[$c])) {
                $pinned[$c] = $categoryCount[$c];
                unset($categoryCount[$c]);
            }
        }
        $categoryCount = $pinned + $categoryCount;

        return [
            'products' => $filteredProducts,
            'categories' => $categoryCount,
            'total' => count($products),
            'filtered_count' => count($filteredProducts),
            'from_cache' => $productsData['from_cache'] ?? false,
            'api_error' => $productsData['api_error'] ?? null,
        ];
    }

    /**
     * Get category icons for sidebar
     */
    public function getCategoryIcons(): array
    {
        return [
            'iCloud & FMI' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>',
            'Carrier Unlock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg>',
            'IMEI Check' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
            'Samsung' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="9" y1="18" x2="15" y2="18"/></svg>',
            'Apple / iPhone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>',
            'Xiaomi' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M9 6h6"/></svg>',
            'Huawei' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><circle cx="12" cy="10" r="3"/></svg>',
            'Software & Tools' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>',
            'FRP Bypass' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            'MDM & Supervision' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
            'Server Credits' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/></svg>',
            'Data Services' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>',
            'Gift Cards' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="8" width="18" height="13" rx="2"/><path d="M12 8V21"/></svg>',
            'Game' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"/><line x1="6" y1="12" x2="10" y2="12"/><line x1="8" y1="10" x2="8" y2="14"/></svg>',
            'Mua sơ đồ' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>',
            'Bypass A12+' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
            'Khác' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>',
        ];
    }
}
