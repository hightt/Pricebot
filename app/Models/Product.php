<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

include public_path() . "/libraries/simple_html_dom.php";

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['id, external_id, name, current_price, old_price, promotion'];

    public function findObjects($url, $name = ""): array
    {
        $html = @file_get_html($url);
        if ($html && !empty($name)) {
            return $html->find($name);
        } else {
            return [];
        }
    }

    public function findProduct($seeds, $tagName = "a.product__name", $tagPrice = "strong.price", $tagOldPrice = "del.price", $tagUrl = "")
    {

        $result = [];
        foreach ($seeds as $seed) {
            $product = new Product;
            $id = (int) $seed->getAttribute('data-product_id');
            $product->name = $seed->find($tagName)[0]->plaintext;
            $product->current_price = (float) str_replace(',', '.', $seed->find($tagPrice)[0]->plaintext);
            $product->old_price = !empty($seed->find($tagOldPrice)) ? (float) str_replace(',', '.', $seed->find($tagOldPrice)[0]->plaintext) : 0;
            $product->external_id = $id;

            if ($product->old_price <= 0) {
                $product->promotion = 0;
            } else {
                $product->promotion = 1;
            }
            // $product->url = $seed->find($tagUrl)->plaintext;
            // $product->url

            $result[$id] = $product;
        }
        return $result;
    }

    /* Push or update product in db */
    public function updateProducts(array $products)
    {
        $externalIds = Product::all()->pluck('external_id')->toArray();

        $stats = [
            'total' => count($products),
            'update' => 0,
            'insert' => 0,
            'failed' => 0
        ];
        foreach ($products as $product) {
            // echo $product->current_price."\n";
            DB::insert(
                'INSERT INTO products (id, external_id, name, current_price, old_price, promotion)
            VALUES (0, :external_id, :name, :current_price, :old_price, :promotion)',
                [
                    ':external_id' => $product->external_id,
                    ':name' => $product->name,
                    ':current_price' => $product->current_price,
                    ':old_price' => $product->old_price,
                    ':promotion' => $product->promotion
                ]
            );
        }
    }
}
