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

    public function getProductsAjax(Request $request)
    {
        $columnIndex =  $request->get('order')[0]['column'];
        $columnName = $request->get('columns')[$columnIndex]['data'];
        $columnSortOrder = $request->get('order')[0]['dir'];
        $searchValue = $request->get('search')['value'];

        $totalRecordsWithFilter = Product::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->where('active', 1)->count();

        $records = Product::orderBy($columnName, $columnSortOrder)
            ->where('products.name', 'like', '%' . $searchValue . '%')
            ->where('products.active', 1)
            ->select('products.*')
            ->skip($request->get('start'))
            ->take($request->get('length'))
            ->get();

        foreach ($records as $record) {
            $record->current_price = number_format($record->current_price, 2, '.', '');
            $record->old_price = number_format($record->old_price, 2, '.', '');

            if ($record->promotion == 0) {
                $record->promotion = "<i style='color: red;'>✕</i>";
                $record->old_price = "<i style='color: red;'>✕</i>";
            } else {
                $record->promotion = "<i style='color: green;'>✓</i>";
            }
        }
        return json_encode(
            array(
                "draw" => intval($request->get('draw')),
                "iTotalRecords" => Product::all()->count(),
                "iTotalDisplayRecords" => $totalRecordsWithFilter,
                "aaData" => $records
            )
        );
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


    public function getDetailsAjax(Product $product)
    {
        // Get product with discount > $discountRange
        $discountRange = 20;
        return $product->dataToChart($product);
    }

}
