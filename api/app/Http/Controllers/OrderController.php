<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',

        ]);
        $cart = session()->get('cart');
        if (!$cart || empty($cart)) {
            return response()->json('There are no items in the cart!', 404);
        }
        $order = Auth::user()->orders()->create([
            'amount' => $request->total,
            'status' => $request->status,
        ]);
        if (! $order) {
            return response()->json('Can not create this order');
        }
        foreach ($cart as $key => $item) {
            $order->orderItem()->create([
                'product_id' => $item['id'],
                'quantity' => $item['quantity']
            ]);
        }
        session()->forget('cart');
        return response()->json('Order created successfully');
    }
}
