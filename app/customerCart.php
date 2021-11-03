<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customerCart extends Model
{
    //

    public function usersCart()
    {
        return $this->belongsToMany(customerCart::class,'customer_carts','userId','cartId');
    }
}
