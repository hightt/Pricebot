<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'external_id', 'name', 'current_price', 'old_price', 'promotion', 'url', 'active'];
    protected $guarded = [];
    protected $dates  = ['created_at', 'updated_at'];
    protected $appends = ['created_at_formatted', 'updated_at_formatted'];

    public function pricehistories()
    {
        return $this->hasMany(PriceHistory::class, 'external_id', 'external_id');
    }



    public function dataToChart($products)
    {
        $results = [];

        foreach ($products as $val) {
            /* Fix necessary if in array $products isset only one product */
            if (!isset($val->id)) {
                $val = $products;
            }

            $results[$val->id] = [
                'details' => $val->toArray(),
                'price_history' => $val->pricehistories()->get()->toArray()
            ];
            foreach ($results[$val->id]['price_history'] as $priceHistory) {
                $results[$val->id]['labels'][] =  $priceHistory['created_at_formatted'];
                $results[$val->id]['prices'][] =  $priceHistory['price'];
            }
        }

        return $results;
    }
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('H:i d, M Y');
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return $this->updated_at->format('d-m-Y');
    }

    public function getDiscountAttribute()
    {
        return $this->promotion > 0 ? ($this->old_price - $this->current_price) : 0;
    }
}
