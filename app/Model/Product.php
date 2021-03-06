<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = [
        'title',
        'photo',
        'content',
        'department_id',
        'trade_id',
        'manu_id',
        'color_id',
        'size_id',
        'currency_id',
        'price',
        'stock',
        'start_at',
        'end_at',
        'start_offer_at',
        'end_offer_at',
        'price_offer',
        'other_data',
        'weight',
        'weight_id',
        'status',
        'reason',
    ];

    function other_data()
    {
        return $this->hasMany('App\Model\OtherData', 'product_id', 'id');
    }
    function malls()
    {
        return $this->hasMany('App\Model\MallProduct', 'product_id', 'id');
    }

    function files()
    {
        return $this->hasMany('App\File', 'relation_id', 'id')->where('file_type', 'product');
    }
}
