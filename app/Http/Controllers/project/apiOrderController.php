<?php

namespace App\Http\Controllers\project;

use App\customerCart;
use App\customerOrder;
use App\Http\Controllers\Controller;
use App\Http\Resources\orderHistoryResource;
use App\Http\Resources\orderProductResource;
use App\Http\Resources\userOrderResource;
use App\Notifications\orderNotification;
use App\Order;
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class apiOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['JWT','role:user|admin']);
        if (env('APP_ENV') == 'testing'
            && array_key_exists("HTTP_AUTHORIZATION", request()->server())) {
            JWTAuth::setRequest(\Route::getCurrentRequest());
        }
    }
    public function getUserOrder($id)
    {
        //
        $user = User::find($id);
        return userOrderResource::collection($user->UserOrders);


    }

    public function getAllOrder()
    {
        //
        $order = Order::all();
        return userOrderResource::collection($order);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editOrder(Request $request, $id)
    {
        //
        $order = Order::find($id);
        if ($order->status != 4 && $request->status == 4) {
            foreach ($order->orderProduct as $product) {
                $item = Product::find($product->id);
                $item->quantity -= $product->pivot->quantity;
                $item->save();

            }
        }
        $order->status = $request->status;
        $order->save();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $order = new Order();
        $order->userId = $request->userId;
        $order->billingAddress = $request->address;
        $order->save();
        foreach ($request->orderProduct as $orders) {
            $orderProduct = new customerOrder();
            $orderProduct->orderId = $order->id;
            $orderProduct->productId = $orders['productId'];
            $orderProduct->quantity = $orders['customerQuantity'];
            $orderProduct->price = $orders['price'];
            $orderProduct->save();
            $cart = customerCart::find($orders['id']);
            $cart->delete();
        }
        $user = User::find(1);
        $customer = User::find($request->userId);
        $user->notify(new orderNotification($customer));

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showProduct($id)
    {
        //
        $order = Order::find($id);
        return orderProductResource::collection($order->orderProduct);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $request)
    {
        //
        foreach ($request->updateProduct as $orders) {
            $orderProduct = customerOrder::find($orders['id']);
            $orderProduct->productId = $orders['productId'];
            $orderProduct->quantity = $orders['customerQuantity'];
            $orderProduct->price = $orders['price'];
            $orderProduct->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function orderDeleteProduct($id)
    {
        //
        $orderProduct = customerOrder::find($id);
        $orderProduct->delete();

    }

    public function UserOrderHistory($orderId)
    {

        $products = DB::table('activity_log')
            ->where("properties->attributes->orderId", '=', $orderId)->orderBy('id', 'DESC')->get();
        foreach ($products as $product) {
            $product->properties = json_decode($product->properties);
        }

        return orderHistoryResource::collection($products);

    }


}
