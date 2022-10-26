<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.changed_price_list');
    }

    public function getAjaxPriceHistory()
    {
        $external_ids = DB::select(
            DB::raw("SELECT DISTINCT external_id FROM price_histories ph  WHERE external_id IN (SELECT ph2.external_id
        FROM price_histories ph2
        GROUP BY ph2.external_id
        HAVING (COUNT(DISTINCT ph2.price) = 1) = 0)")
        );


        $results = [];
        foreach ($external_ids as $val) {
            $product = Product::where('external_id', $val->external_id)->first();
            $results[$product->id] = [
                'details' => $product->toArray(),
                'price_history' => $product->pricehistories()->get()->toArray()
            ];
        }



        foreach ($results as $price_history) {
            foreach($price_history['price_history'] as $history) {
                $results[$price_history['details']['id']]['labels'][] =  $history['created_at_formatted'];
                $results[$price_history['details']['id']]['prices'][] =  $history['price'];
            }

        }
        // echo "<pre>";
        //     echo print_r($results);
        // echo "</pre>";
        return $results;
    }
}
