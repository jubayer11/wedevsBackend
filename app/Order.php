<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity');
    }
    public function orderProduct()
    {
        return $this->belongsToMany(Product::class,'customer_orders','orderId','productId')->withPivot('quantity','id','productId','price');
    }
    public function users()
    {
        return $this->belongsTo(User::class,'userId','id');
    }
}
