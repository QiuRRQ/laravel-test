<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Products;
use App\Category;
use App\Brand;
use App\OrdersDetails;
class Variants extends Model
{
    //
    protected $fillable = [
        'color', 'size', 'stock', 'price', 'products_id', 'disabled',
    ];

    public function product(){
        return $this->belongsTo(Products::class, 'id');
    }

    public function hasCategory(){
        return $this->hasOneThrough(Category::class, Products::class);
    }
    public function hasBrand(){
        return $this->hasOneThrough(Category::class, Products::class);
    }
    public function hasOrder(){
        return $this->belongsToMany(OrdersDetails::class, 'id');
    }
}
