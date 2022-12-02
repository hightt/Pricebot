<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class Product extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'external_id', 'name', 'current_price', 'old_price', 'promotion', 'url', 'active'];
    protected $guarded = [];
    protected $dates  = ['created_at', 'updated_at'];
    protected $appends = ['created_at_formatted', 'updated_at_formatted', 'discount', 'axis_data'];

    public function pricehistories()
    {
        return $this->hasMany(PriceHistory::class, 'external_id', 'external_id');
    }

    public function getProductsAjax(Request $request)
    {
        $columnIndex =  $request->get('order')[0]['column'];
        $columnName = $request->get('columns')[$columnIndex]['data'];
        $columnSortOrder = $request->get('order')[0]['dir'];
        $searchValue = $request->get('search')['value'];

        $totalRecordsWithFilter = Product::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->where('active', 1)->count();

        $records = Product::orderBy($columnName, $columnSortOrder)
            ->where('products.name', 'like', '%' . $searchValue . '%')
            ->where('products.active', 1)
            ->select('products.*')
            ->skip($request->get('start'))
            ->take($request->get('length'))
            ->get();

        foreach ($records as $record) {
            $record->current_price = number_format($record->current_price, 2, '.', '');
            $record->old_price = number_format($record->old_price, 2, '.', '');

            if ($record->promotion == 0) {
                $record->promotion = "<i style='color: red;'>✕</i>";
                $record->old_price = "<i style='color: red;'>✕</i>";
            } else {
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

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->format('H:i d, M Y') : 'Undefined';
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('H:i d, M Y') : 'Undefined';
    }

    public function getDiscountAttribute()
    {
        return $this->promotion ? ((float)$this->old_price - (float)$this->current_price) : 0;
    }

    public function getAxisDataAttribute()
    {
        $data = [];
        foreach($this->pricehistories()->get() as $priceHistory) {
            $data['oyAxis'][] = $priceHistory->created_at_formatted;
            $data['oxAxis'][] = $priceHistory->price;
        }

        return $data;

    }
}
