<?php

namespace App\Http\Controllers\project;

use App\customerCart;
use App\Http\Controllers\Controller;
use App\Http\Resources\cartResource;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class apiCartController extends Controller
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

    public function addProductToCart(Request $request)
    {
        $cart = new customerCart();
        $cart->userId = $request->UserId;
        $cart->productId = $request->productId;
        $cart->quantity = $request->quantity;
        $cart->save();
    }

    public function getCartCount($id)
    {
        $cartCount = DB::table('customer_carts')->where('userId', $id)->count();
        return $cartCount;
    }

    public function getCartProduct($userId)
    {
        $user = User::find($userId);
        return cartResource::collection($user->usersCart);
    }

    public function deleteCartProduct($cartId)
    {
        $customerCart = customerCart::find($cartId);
        $customerCart->delete();
    }

    public function updateCartProduct(Request $request)
    {

        foreach ($request->cartProduct as $product) {
            $cart = customerCart::find($product['id']);
            $cart->quantity = $product['customerQuantity'];
            $cart->save();
        }
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
