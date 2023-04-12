<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class ProductAnaliseController extends Controller
{
    public function index()
    {
        return view('layouts.discount')->with('products', $this->biggestDiscount());
    }

    public function biggestDiscount()
    {
        $result = Product::all()->filter(function ($product) {
            return !$product->fake_promotion && $product->active && $product->discount['percentage'] > 5;
        })->sortByDesc('discount.percentage')->paginate(25);

        return $result;
    }

    public function addProductToCompare(Request $request)
    {
        $result = [];

        if (Session::exists('productsToCompare')) {
            $result = Session::get('productsToCompare');
        }

        if(in_array($request->productId, $result)) {
            return response()->json(['status' => 'danger', 'message' => "Ten produkt został już dodany do porównania."], 400);
        }

        $result[] = $request->productId;
        $result = array_unique($result, SORT_REGULAR);
        Session::put('productsToCompare', $result);

        return response()->json(['status' => 'success', 'message' => "Pomyślnie dodano produkt do porównania."], 200);
    }

    public function getProductsFromSession()
    {
        $productsId = Session::get('productsToCompare');
        $result = [];

        if (is_array($productsId) && count($productsId) > 0) {
            for ($i = 0; $i < count($productsId); $i++) {
                $result[] = Product::where('id', $productsId[$i])->first();
            }
        }

        return $result;
    }

    public function removeProductFromSession($removeProductId)
    {
        $collection = collect(Session::get('productsToCompare'));
        $result = $collection->filter(function ($productId) use ($removeProductId) {
            return $productId != $removeProductId;
        })->values()->toArray();

        Session::put('productsToCompare', $result);

        Session::put('alert', ['status' => 'success', 'message' => "Pomyślnie usunięto produkt."]);
        return back();
    }

    public function compareIndex()
    {
        return view('layouts.compare')->with('products', $this->getProductsFromSession());
    }
}
