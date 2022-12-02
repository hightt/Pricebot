<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PriceHistory;
use App\Models\Webscrapper;

class WebScrapperController extends Controller
{
    public function index(Webscrapper $webScrapper)
    {
        $products = $this->getProductsFromApi($webScrapper);
        /* Insert or update products in `products` table */
        $webScrapper->updateProducts($products);

        /*Insert price history products in `prices_history` table */

        $webScrapper->createPriceHistory($products);
    }

    public function getProductsFromApi($webScrapper)
    {
        $seed = [];
        $arrayUrl = [
            "https://www.dolina-noteci.pl/pol_m_Karma-dla-psa-231.html?counter=",
            "https://www.dolina-noteci.pl/pol_m_Karma-dla-kota-244.html?counter=",
            "https://www.dolina-noteci.pl/pol_m_Dla-Ciebie-261.html?counter=",
            "https://www.dolina-noteci.pl/pol_m_Akcesoria-265.html?counter=",
        ];

        for ($j = 0; $j < count($arrayUrl); $j++) {
        // for ($j = 1; $j <= 1; $j++) {
            $flag = true;
            $i = 0;

            while ($flag) {
                $url = $arrayUrl[$j] . $i;
                echo sprintf("*** Open: %s \n", $url);
                $objects = $webScrapper->findObjects($url, '.product');
                if (!empty($objects)) {
                    $seed[] = $webScrapper->findProduct($objects, "a.product__name", "strong.price", "del.price", "a.product__icon");
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
}
