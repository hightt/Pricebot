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
        // $this->cronJobUpdateProducts(new Product);
        return view('layouts.main');
    }

    public function cronJobUpdateProducts()
    {
        $product = new Product;
        $products = $this->getProductsFromApi($product);
        /* Insert or update products in `products` table */
        $product->updateProducts($products);

        /*Insert price history products in `prices_history` table */
        $price_history = new PriceHistory();
        $price_history->createPriceHistory($products);
    }


    public function getProductsAjax(Request $request)
    {
        $columnIndex =  $request->get('order')[0]['column'];
        $columnName = $request->get('columns')[$columnIndex]['data'];
        $columnSortOrder = $request->get('order')[0]['dir'];
        $searchValue = $request->get('search')['value'];

        $totalRecordsWithFilter = Product::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        $records = Product::orderBy($columnName, $columnSortOrder)
            ->where('products.name', 'like', '%' . $searchValue . '%')
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

    public function getProductsFromApi($product)
    {

        $arrayUrl = [
            "https://www.dolina-noteci.pl/pol_m_Karma-dla-psa-231.html?counter=",
            "https://www.dolina-noteci.pl/pol_m_Karma-dla-kota-244.html?counter=",
            "https://www.dolina-noteci.pl/pol_m_Dla-Ciebie-261.html?counter=",
            "https://www.dolina-noteci.pl/pol_m_Akcesoria-265.html?counter=",
        ];

        $seed = [];
        // for ($j = 0; $j < count($arrayUrl); $j++) {
        for ($j = 1; $j < 3; $j++) {
            $flag = true;
            $i = 0;

            while ($flag) {
                $url = $arrayUrl[$j] . $i;
                $objects = $product->findObjects($url, '.product');
                if (!empty($objects)) {
                    $seed[] = $product->findProduct($objects, "a.product__name", "strong.price", "del.price", "a.product__icon");
                    $i++;
                } else {
                    /* No more products to fetch */
                    $flag = false;
                }
            }
        }

        // Merge all arrays inside $seed into one
        return array_merge(...$seed);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {


        // $product['labels'] = implode(', ', $product['labels']);

        return view('layouts.details')->with('product', $product);
    }


    public function getDetailsAjax($id)
    {
        $product = product::find($id);

        $results = [
            'details' => $product->toArray(),
            'price_history' => $product->pricehistories->toArray()
        ];

        foreach ($results['price_history'] as $price_history) {
            $results['labels'][] =  $price_history['created_at_formatted'];
            $results['prices'][] =  $price_history['price'];
        }

        return $results;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }
}
