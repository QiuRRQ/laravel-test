<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Products;
class Category extends Model
{
    //
    protected $fillable = [
        'name', 'parent_id',
    ];
    public function product(){
        return $this->hasMany(Products::class);
    }
}
