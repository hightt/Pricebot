<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
include public_path() . "/libraries/simple_html_dom.php";

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'external_id', 'name', 'current_price', 'old_price', 'promotion'];
    protected $guarded = [];
    protected $dates  = ['created_at' , 'updated_at'];
    protected $appends = ['created_at_formatted', 'updated_at_formatted'];
    public function pricehistories()
    {
        return $this->hasMany(PriceHistory::class, 'external_id', 'external_id');
    }
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
            $product->old_price <= 0 ? $product->promotion = 0 : $product->promotion = 1;

            $result[$id] = $product;
        }
        return $result;
    }

    /* Push or update product in db */
    public function updateProducts(array $products)
    {
        $externalIds = Product::all()->pluck('external_id')->toArray();

        $stats = [
            'total' => 0,
            'updated' => 0,
            'created' => 0,
            'failed' => 0,
        ];

        foreach ($products as $product) {
            if (in_array($product['external_id'], $externalIds)) {
                Product::where('external_id', $product['external_id'])->update([
                    'external_id' => $product->external_id,
                    'name' => $product->name,
                    'current_price' => $product->current_price,
                    'old_price' => $product->old_price,
                    'promotion' => $product->promotion,
                ]);
                $stats['updated']++;
            } else {
                Product::create([
                    'external_id' => $product->external_id,
                    'name' => $product->name,
                    'current_price' => $product->current_price,
                    'old_price' => $product->old_price,
                    'promotion' => $product->promotion,
                ]);
                $stats['created']++;
            }
        }

        echo "*** CREATED: " . $stats['created'] . " *** \n";
        echo "*** UPDATED: " . $stats['updated'] . " *** \n";
    }
    public function getCreatedAtFormattedAttribute()
    {
       return $this->created_at->format('H:i d, M Y');
    }
    public function getUpdatedAtFormattedAttribute()
    {
       return $this->updated_at->format('d-m-Y');
    }
}
