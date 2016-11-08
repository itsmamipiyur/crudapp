<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::withTrashed()->get();
        return view('maintenance.category', ['categories' => $categories]);
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
        $rules = ['category_name' => 'required',
                  'category_desc' => 'required'];

        $this->validate($request, $rules);
        $category = new Category;
        $category->category_name = $request->category_name;
        $category->category_desc = $request->category_desc;
        $category->save();

        return redirect('category')->with('alert-success', 'Category was successfully saved.');
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
        $category = Category::find($id);
        return Response::json($category);
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
        $category = Category::find($id);
        $name = $category->category_name;
        $category->delete();
        return redirect('category')->with('alert-success', 'Category '. $name .' was successfully deleted.');
    }

    public function category_update(Request $request)
    {
      $rules = ['category_name' => 'required',
                'category_desc' => 'required'];

      $id = $request->category_id;

      $this->validate($request, $rules);
      $category = Category::find($id);
      $category->category_name = $request->category_name;
      $category->category_desc = $request->category_desc;
      $category->save();

      return redirect('category')->with('alert-success', 'Category ' . $category->category_name . ' was successfully updated.');
    }

    public function category_restore(Request $request)
    {
      $id = $request->category_id;
      $category = Category::onlyTrashed()->where('id', '=', $id)->firstOrFail();
      $name = $category->category_name;
      $category->restore();

      return redirect('category')->with('alert-success', 'category ' . $name . ' was successfully restored.');
    }
}
