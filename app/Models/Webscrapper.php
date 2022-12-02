<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
include_once public_path("libraries/simple_html_dom.php");

class Webscrapper extends Model
{
    use HasFactory;

    public function findObjects($url, $name = ""): array
    {
        $html = @file_get_html($url);
        if ($html && !empty($name)) {
            return $html->find($name);
        } else {
            return [];
        }
    }

    /* Push or update product in db */
    public function updateProducts(array $products)
    {
        
        $externalIds = Product::pluck('external_id')->toArray();

        $exIdsArray = [];
        foreach ($products as $product) {
            $exIdsArray[] = $product['external_id'];
            if (in_array($product['external_id'], $externalIds)) {
                Product::where('external_id', $product['external_id'])->update([
                    'external_id' => $product->external_id,
                    'name' => $product->name,
                    'current_price' => $product->current_price,
                    'old_price' => $product->old_price,
                    'promotion' => $product->promotion,
                    'url' => $product->url,
                ]);
            } else {
                Product::create([
                    'external_id' => $product->external_id,
                    'name' => $product->name,
                    'current_price' => $product->current_price,
                    'old_price' => $product->old_price,
                    'promotion' => $product->promotion,
                    'url' => $product->url,
                ]);
            }
        }

        $disabledNum = 0;
        foreach($externalIds as $externalId) {
            $product = Product::where('external_id', $externalId)->first();
            if(in_array($externalId, $exIdsArray)) {
                $product->update(['active' => 1]);
            } else {
                $product->update(['active' => 0]);
            }
        }

        echo sprintf("Disabled products: %d \n", $disabledNum);
    }

    public function createPriceHistory(array $products)
    {
        foreach ($products as $product) {
            PriceHistory::create([
                'external_id' => $product->external_id,
                'price' => $product->current_price,
            ]);
        }
    }

    public function findProduct($seeds, $tagName, $tagPrice, $tagOldPrice, $tagUrl)
    {
        $result = [];
        foreach ($seeds as $seed) {
            $id = (int) $seed->getAttribute('data-product_id');
            $old_price = !empty($seed->find($tagOldPrice)) ? (float) str_replace(',', '.', $seed->find($tagOldPrice)[0]->plaintext) : 0;
            $product = new Product([
                'external_id' => $id,
                'name' => $seed->find($tagName)[0]->plaintext,
                'current_price' => (float) str_replace(',', '.', $seed->find($tagPrice)[0]->plaintext),
                'old_price' => $old_price,
                'promotion' => $old_price <= 0 ? '0' : '1',
                'url' => "https://www.dolina-noteci.pl" . $seed->find($tagUrl)[0]->href
            ]);

            $result[$id] = $product;
        }
        return $result;
    }
}