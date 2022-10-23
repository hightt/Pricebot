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
    public function __invoke()
    {
        $external_ids = DB::select(
            DB::raw("SELECT DISTINCT external_id FROM price_histories ph  WHERE external_id IN (SELECT ph2.external_id
        FROM price_histories ph2
        GROUP BY ph2.external_id
        HAVING (COUNT(DISTINCT ph2.price) = 1) = 0)")
        );

        $totalExIds = [];
        foreach($external_ids as $ex_id) {
            $totalExIds[] = $ex_id->external_id;
            echo "'" . $ex_id->external_id . "',";
        }
        die;

    }
}
