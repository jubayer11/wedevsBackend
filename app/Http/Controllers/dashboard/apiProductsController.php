<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\productRequest;
use App\Http\Requests\productEditRequest;

use App\Http\Resources\productsResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $random = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 3);
        $exploded = explode(',', $request->file);
        $decoded = base64_decode($exploded[1]);
        if (str_contains($exploded[0], 'jpeg')) {
            $extension = 'jpeg';
        } elseif (str_contains($exploded[0], 'png')) {
            $extension = 'png';
        } else {
            $extension = 'jpg';
        }

        $fileName = Str::random() . time() . '.' . $extension;
        $path = public_path() . '/uploads/products/' . $fileName;

        file_put_contents($path, $decoded);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->image = $fileName;
        $product->description = $request->description;
        $product->save();
        $product->uniqueId = $product->id . $random;
        $product->save();
    }

    public function show($id)
    {
        $product = Product::find($id);
        return new productsResource($product);
    }

    public function update(productEditRequest $request, $id)
    {
        //
        $product = Product::find($id);
        if ($request->file != '') {
            $exploded = explode(',', $request->file);
            $decoded = base64_decode($exploded[1]);
            if (str_contains($exploded[0], 'jpeg')) {
                $extension = 'jpeg';
            } elseif (str_contains($exploded[0], 'png')) {
                $extension = 'png';
            } else {
                $extension = 'jpg';
            }

            $fileName = Str::random() . time() . '.' . $extension;
            $path = public_path() . '/uploads/products/' . $fileName;
            file_put_contents($path, $decoded);
            $product->name = $request->name;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->image = $fileName;
            $product->description = $request->description;
            $product->save();
        } else {
            $product->name = $request->name;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->description = $request->description;
            $product->save();
        }


    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
    }


    //home product
    //
    public function getHomeProducts()
    {
        $products = Product::all()->take(3);
        return productsResource::collection($products);
    }
    public function getProductProducts($key,$sort)
    {
        if ($sort==2)
        {
            $products =   Product::query()
                ->where('name', 'LIKE', "%{$key}%")->orderBy('price', 'DESC')->paginate(9);
        }
        else if ($sort==1)
        {
            $products =   Product::query()
                ->where('name', 'LIKE', "%{$key}%")->orderBy('price', 'ASC')->paginate(9);
        }
        else
        {
            $products =   Product::query()
                ->where('name', 'LIKE', "%{$key}%")->paginate(9);
        }

        return productsResource::collection($products);
    }


}
