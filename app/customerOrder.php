<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customerOrder extends Model
{
    //
    public function usersOrder()
    {
        return $this->belongsToMany(User::class,'customer_orders','userId','productId');
    }
}
