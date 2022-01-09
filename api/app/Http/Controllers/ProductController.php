<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(Product::latest()->paginate(9));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'details' => 'required|max:191',
            'product_code' => 'required|max:191',
            'amount' => 'required',
        ]);

        $Product = Product::create([
            'name' => $request->name,
            'details' => $request->details,
            'product_code' => $request->product_code,
            'amount' => $request->amount,
        ]);

        if ($request->category && !empty($request->category)) {
            $Product->categories()->attach($request->category);
        }
        if ($request->brand && !empty($request->brand)) {
            $Product->brands()->attach($request->brand);
        }
        return response()->json('Product created successfully', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            abort(404);
        }
        $brand = $product->brands()->get();
        $category = $product->categories()->get();
        return ProductResource::collection([
            'product' => $product,
            'brands' => $brand,
            'categories' => $category
        ]);
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
