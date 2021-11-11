<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;


class customerOrder extends Model
{
    //
    use LogsActivity;

    protected $fillable = ['orderId', 'productId', 'price', 'quantity', 'status'];

    protected static $logAttributes = ['orderId', 'productId', 'price', 'quantity', 'status','orderProduct.name','orderProduct.image','usersOrder.users.name'];

    protected static $recordEvents = ['deleted','updated'];
    public function usersOrder()
    {
        return $this->belongsTo(Order::class, 'orderId', 'id');
    }
    public function orderProduct()
    {
        return $this->belongsTo(Product::class,'productId','id');
    }

}
