<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PriceHistory;
use Illuminate\Http\Request;
use Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.content');
    }

    public function getProductsAjax(Request $request, Product $product)
    {
        return $product->getProductsAjax($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('layouts.details')->with('product', $product);
    }

    public function getProductAjax(Product $product)
    {
        return response()->json($product);
    }

}
