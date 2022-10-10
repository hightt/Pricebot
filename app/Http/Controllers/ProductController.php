<?php

namespace App\Http\Controllers;

use App\Models\Product;
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

        // $p = new Product;
        // $products = $this->fetchAndUploadProducts(new Product);
        // $p->updateProducts($products);


        return view('layouts.main');
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

        foreach($records as $record) {
            if($record->promotion == 0){
                $record->promotion = "<i style='color: red;'>✕</i>";
                $record->old_price = "<i style='color: red;'>✕</i>";
            }
            else {
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

    public function fetchAndUploadProducts($product)
    {

        $seed = [];

        $arrayUrl = [
            "https://www.dolina-noteci.pl/pol_m_Karma-dla-psa-231.html?counter=",
            "https://www.dolina-noteci.pl/pol_m_Karma-dla-kota-244.html?counter=",
            "https://www.dolina-noteci.pl/pol_m_Dla-Ciebie-261.html?counter=",
            "https://www.dolina-noteci.pl/pol_m_Akcesoria-265.html?counter=",
        ];

        for ($j = 0; $j < count($arrayUrl); $j++) {
        // for ($j = 2; $j < 3; $j++) {
            $flag = true;
            $i = 0;

            while ($flag) {
                $url = $arrayUrl[$j] . $i;
                $objects = $product->findObjects($url, '.product');
                if (!empty($objects)) {
                    $seed[] = $product->findProduct($objects);
                    $i++;
                } else {
                    /* No more products to fetch */
                    $flag = false;
                }
            }
        }

        // Merge all arrays inside $seed into one
        file_put_contents("result.txt", print_r(array_merge(...$seed), true));
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
        //
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
