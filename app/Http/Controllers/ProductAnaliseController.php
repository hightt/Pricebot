<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductAnaliseController extends Controller
{
    public function index()
    {
        return view('layouts.discount');
    }

    public function bestDealProductsAjax()
    {
        $collection = collect(Product::where('active', 1)->get());
        
        $result = $collection->filter(function($product) {
            return $product->discount > 0;
        })->sortByDesc('discount')->take(10)->values();

        return response()->json(['result' => $result]);
    }
}
