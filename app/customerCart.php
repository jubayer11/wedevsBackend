<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customerCart extends Model
{
    //

    public function usersCart()
    {
        return $this->belongsToMany(Product::class,'customer_carts','userId','productId');
    }
}
