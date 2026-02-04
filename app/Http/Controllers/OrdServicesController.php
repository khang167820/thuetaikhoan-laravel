<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdServicesController extends Controller
{
    /**
     * Display the ord-services page (API GSM Services)
     */
    public function index(Request $request)
    {
        $category = $request->input('cat', null);
        
        // Categories for the sidebar
        $categories = [
            'Data Services' => 'Dịch vụ Data',
            'Software & Tools' => 'Phần mềm & Công cụ',
            'Apple / iPhone' => 'Apple / iPhone',
            'Xiaomi' => 'Xiaomi',
            'IMEI Check' => 'Kiểm tra IMEI',
            'iCloud & FMI' => 'iCloud & FMI',
            'Samsung' => 'Samsung',
            'FRP Bypass' => 'FRP Bypass',
        ];
        
        return view('pages.ord-services', compact('category', 'categories'));
    }
}
