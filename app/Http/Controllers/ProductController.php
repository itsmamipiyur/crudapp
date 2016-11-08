<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;
use Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::withTrashed()->get();
        $categories = Category::orderBy('category_name')->pluck('category_name', 'id');
        $brands = Brand::orderBy('brand_name')->pluck('brand_name', 'id');
        return view('maintenance.product', ['products' => $products, 'categories' => $categories, 'brands' => $brands]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = ['product_name' => 'required',
                  'product_desc' => 'required',
                  'product_category' => 'required',
                  'product_brand' => 'required'];

        $this->validate($request, $rules);
        $product = new Product;
        $product->product_name = trim($request->product_name);
        $product->product_desc = trim($request->product_desc);
        $product->category_id = trim($request->product_category);
        $product->brand_id = trim($request->product_brand);
        $product->save();

        return redirect('product')->with('alert-success', 'Product was successfully saved.');
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
        $product = Product::find($id);
        return Response::json(['id' => $product->id,
                              'product_name' => $product->product_name,
                              'product_desc' => $product->product_desc,
                              'category_name' => $product->category->category_name,
                              'brand_name' => $product->brand->brand_name]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $product = Product::find($id);
        $name = $product->product_name;
        $product->delete();
        return redirect('product')->with('alert-success', 'Product '. $name .' was successfully deleted.');
    }

    public function product_update(Request $request)
    {
        //
        $rules = ['product_name' => 'required',
                  'product_desc' => 'required',
                  'product_category' => 'required',
                  'product_brand' => 'required'];

        $this->validate($request, $rules);
        $product = Product::find($request->product_id);
        $product->product_name = trim($request->product_name);
        $product->product_desc = trim($request->product_desc);
        $product->category_id = trim($request->product_category);
        $product->brand_id = trim($request->product_brand);
        $product->save();

        return redirect('product')->with('alert-success', 'Product was successfully updated.');
    }

    public function product_restore(Request $request)
    {
      $id = $request->product_id;
      $product = Product::onlyTrashed()->where('id', '=', $id)->firstOrFail();
      $name = $product->product_name;
      $product->restore();

      return redirect('product')->with('alert-success', 'Product ' . $name . ' was successfully restored.');
    }
}
