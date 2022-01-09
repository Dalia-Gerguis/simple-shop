<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = session()->get('cart');
        if (!empty($cart)) {
            $total = 0;
            foreach ($cart as $key => $item) {
                $product = Product::find($item['id']);
                if ($product) {
                    $item['brands'] = $product->brands()->get();
                    $item['categories'] = $product->categories()->get();
                    $cart[$key] = $item;
                }
                $total += ($item['amount'] * $item['quantity']);
            }
            $data = [
                'cart' => $cart,
                'total' => (int)$total
            ];
            return response()->json($data, 200);
        }
        return response()->json("empty cart", 404);
        // CartResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);

        if (!$product) {

            abort(404);
        }

        $cart = session()->get('cart');

        // if cart is empty then this the first product
        if (!$cart) {

            $cart = [
                $id => [
                    "id" => $id,
                    "name" => $product->name,
                    "quantity" => $request->quantity,
                    "amount" => $product->amount,
                    "image" => $product->image,
                    "details" => $product->details
                ]
            ];

            session()->put('cart', $cart);

            return response()->json('Product added to cart successfully!', 201);
        }

        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {

            $cart[$id]['quantity'] += $request->quantity;

            session()->put('cart', $cart);

            return response()->json('Product added to cart successfully!', 200);
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "id" => $id,
            "name" => $product->name,
            "quantity" => $request->quantity,
            "amount" => $product->amount,
            "image" => $product->image,
            "details" => $product->details
        ];

        session()->put('cart', $cart);

        return response()->json('Product added to cart successfully!', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
