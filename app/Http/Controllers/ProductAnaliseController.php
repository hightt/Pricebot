<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductAnaliseController extends Controller
{
    public function index()
    {
        return view('layouts.discount')->with('products', $this->biggestDiscount());
    }

    public function biggestDiscount()
    {
        $result = Product::all()->filter(function($product) {
            return !$product->fake_promotion && $product->active && $product->discount['percentage'] > 20;
        })->sortByDesc('discount')->paginate(25);
        
        return $result;
    }
}
