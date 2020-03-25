<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Brand;
use App\Variants;
class Products extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'category_id', 'brand_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class); //belongsTo berarti di tabel product terdapat category_id
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function variant(){
        return $this->hasMany(Variants::class); //ini berarti product_id muncul di tabel Variants
    }
}
