<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'external_id', 'price', 'created_at', 'updated_at'];
    protected $guarded = [];



    public function product()
    {
        return $this->belongsTo(Product::class, 'external_id', 'external_id');
    }


    public function createPriceHistory(array $products)
    {
        $i = 0;
        foreach ($products as $product) {
            PriceHistory::create([
                'external_id' => $product->external_id,
                'price' => $product->current_price,
            ]);
            $i++;
        }
        echo "*** CREATED: " . $i . " HISTORY PRICES*** \n";
    }
}
