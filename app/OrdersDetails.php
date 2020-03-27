<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Variants;
use App\User;
use App\Orders;
class OrdersDetails extends Model
{
    //

    public function getvariant(){
        return $this->belongsToMany(Variants::class);
    }

    public function order(){
        return $this->belongsTo(Orders::class, 'orders_id');
    }

}
