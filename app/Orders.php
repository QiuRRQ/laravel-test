<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\OrderDetails;
class Orders extends Model
{
    //
    protected $fillable = [
        'user_id', 'date_ordered', 'order_status', 'total_price',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function order_details(){
        return $this->hasMany(OrderDetails::class); 
    }
}
