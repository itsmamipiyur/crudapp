<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Response;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $brands = Brand::withTrashed()->get();
        return view('maintenance/brand', ['brands' => $brands]);
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
        $rules = ['brand_name' => 'required',
                  'brand_desc' => 'required'];

        $this->validate($request, $rules);
        $brand = new Brand;
        $brand->brand_name = $request->brand_name;
        $brand->brand_desc = $request->brand_desc;
        $brand->save();

        return redirect('brand')->with('alert-success', 'Brand was successfully saved.');
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
        $brand = Brand::find($id);
        return Response::json($brand);

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
        $brand = Brand::find($id);
        $name = $brand->brand_name;
        $brand->delete();
        return redirect('brand')->with('alert-success', 'Brand '. $name .' was successfully deleted.');
    }

    public function brand_update(Request $request)
    {
      $rules = ['brand_name' => 'required',
                'brand_desc' => 'required'];

      $id = $request->brand_id;

      $this->validate($request, $rules);
      $brand = Brand::find($id);
      $brand->brand_name = $request->brand_name;
      $brand->brand_desc = $request->brand_desc;
      $brand->save();

      return redirect('brand')->with('alert-success', 'Brand ' . $id . ' was successfully updated.');
    }

    public function brand_restore(Request $request)
    {
      $id = $request->brand_id;
      $brand = Brand::onlyTrashed()->where('id', '=', $id)->firstOrFail();
      $brand->restore();

      return redirect('brand')->with('alert-success', 'Brand ' . $id . ' was successfully restored.');
    }
}
