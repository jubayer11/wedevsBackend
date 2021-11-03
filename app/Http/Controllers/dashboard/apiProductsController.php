<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\productRequest;
use App\Http\Resources\productsResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class apiProductsController extends Controller
{
    //
    public function index()
    {
        $products = Product::all();
        return productsResource::collection($products);
    }

    public function store(productRequest $request)
    {

        $exploded = explode(',', $request->image);
        $decoded = base64_decode($exploded[1]);
        if (str_contains($exploded[0], 'jpeg')) {
            $extension = 'jpeg';
        } elseif (str_contains($exploded[0], 'png')) {
            $extension = 'png';
        } else {
            $extension = 'jpg';
        }

        $fileName = Str::random() . time() . '.' . $extension;
        $path = public_path() . '/Uploads/products' . $fileName;
        file_put_contents($path, $decoded);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->image = $fileName;
        $product->description = $request->description;
        $product->save();
    }

    public function show($id)
    {
        $product = Product::find($id);
        return new productsResource($product);
    }

    public function update(productRequest $request, $id)
    {
        //
        $product = Product::find($id);
        if ($request->image!= $product->image)
        {
            $exploded = explode(',', $request->image);
            $decoded = base64_decode($exploded[1]);
            if (str_contains($exploded[0], 'jpeg')) {
                $extension = 'jpeg';
            } elseif (str_contains($exploded[0], 'png')) {
                $extension = 'png';
            } else {
                $extension = 'jpg';
            }

            $fileName = Str::random() . time() . '.' . $extension;
            $path = public_path() . '/Uploads/products' . $fileName;
            file_put_contents($path, $decoded);

        }


        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->image = $fileName;
        $product->description = $request->description;
        $product->save();
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
    }


}
