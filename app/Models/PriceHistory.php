<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'external_id', 'price', 'created_at', 'updated_at'];
    protected $guarded = [];
    protected $appends = ['created_at_formatted', 'updated_at_formatted'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'external_id', 'external_id');
    }

    public function getCreatedAtFormattedAttribute()
    {
       return $this->created_at->format('d-m-Y');
    }
    public function getUpdatedAtFormattedAttribute()
    {
       return $this->updated_at->format('d-m-Y');
    }
}
