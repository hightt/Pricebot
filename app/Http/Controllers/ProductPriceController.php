<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ProductPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.best_deal');
    }

    public function getAjaxPriceHistory(Product $product)
    {
        // Get product with discount > $discountRange
        $discountRange = 20;

        $collection = collect(Product::all())->filter(function ($item) use ($discountRange){
            return $item->discount > $discountRange;
        })->sortBy('discount');

        return $product->dataToChart($collection);
    }
}
