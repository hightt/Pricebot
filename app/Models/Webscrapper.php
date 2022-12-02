<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Mail\UpdateProducts;
use Illuminate\Support\Facades\Mail;

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
        $msg = "";
        $stats = [
            'total' => count($products),
            'created' => 0,
            'updated' => 0,
            'enabled' => 0,
            'disabled' => 0,
        ];

        $current = 0;
        foreach ($products as $product) {
            $current++;
            $exIdsArray[] = $product['external_id'];
            if (in_array($product['external_id'], $externalIds)) {
                try {
                    Product::where('external_id', $product['external_id'])->update([
                        'external_id' => $product->external_id,
                        'name' => $product->name,
                        'current_price' => $product->current_price,
                        'old_price' => $product->old_price,
                        'promotion' => $product->promotion,
                        'url' => $product->url,
                    ]);
                    $msg .= sprintf("[%d/%d][%s] Product[%d] updated | current_price: %.2f | old_price: %.2f \n", $current, $stats['total'], date('H:i:s'), $product->external_id, $product->current_price, $product->old_price);
                    $stats['updated']++;
                } catch(Exception $e) {
                    $msg .= sprintf("[%d/%d][%s] Update product[%d] exception: %s \n", $current, $stats['total'], date('H:i:s'), $product['external_id'], $e->getMessage());

                }
            } else {
                try {
                    Product::create([
                        'external_id' => $product->external_id,
                        'name' => $product->name,
                        'current_price' => $product->current_price,
                        'old_price' => $product->old_price,
                        'promotion' => $product->promotion,
                        'url' => $product->url,
                    ]);
                    $msg .= sprintf("[%d/%d][%s] Product[%d] created \n | current_price: %.2f | old_price: %.2f \n", $current, $stats['total'], date('H:i:s'), $product['external_id'], $product['price'], $product['old_price']);
                    $stats['created']++;
                } catch(Exception $e) {
                    $msg .= sprintf("[%d/%d][%s] Create product[%d] exception: %s \n", $current, $stats['total'], date('H:i:s'), $product['external_id'], $e->getMessage());

                }
            }
        }

        foreach($externalIds as $externalId) {
            $product = Product::where('external_id', $externalId)->first();
            if(in_array($externalId, $exIdsArray)) {
                $product->update(['active' => 1]);
                $msg .= sprintf("[%s] Product [%d] enabled \n", date('H:i:s'), $product->external_id);
                $stats['enabled']++;
            } else {
                $product->update(['active' => 0]);
                $msg .= sprintf("[%s] Product [%d] disabled \n", date('H:i:s'), $product->external_id);
                $stats['disabled']++;
            }
        }

        // create daily log
        $fileName = sprintf("%s.log", date("Y.m.d"));
        Storage::disk('logs')->put($fileName, $msg);

        $this->sendEmailUpdateSummary($stats);
    }

    public function sendEmailUpdateSummary(array $stats) : void
    {
        Mail::to('konrad.da121@gmail.com')->send(new UpdateProducts($stats));
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
