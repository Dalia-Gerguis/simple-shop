<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::take(4)->inRandomOrder()->get(['id', 'name']);

        return BrandResource::collection($brands);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::find($id);
        $products =$brand->products()->paginate(6);

        return BrandResource::collection([
            'brand_details' => $brand,
            'products' => $products
        ]);
    }
}
