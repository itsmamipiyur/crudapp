<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use Response;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $branches = Branch::withTrashed()->get();
        return view('maintenance.branch', ['branches' => $branches]);
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
        $rules = ['branch_name' => 'required',
                  'branch_desc' => 'required'];

        $this->validate($request, $rules);
        $branch = new Branch;
        $branch->branch_name = $request->branch_name;
        $branch->branch_desc = $request->branch_desc;
        $branch->save();

        return redirect('branch')->with('alert-success', 'Branch was successfully saved.');
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
        $branch = Branch::find($id);
        return Response::json($branch);
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
        $branch = Branch::find($id);
        $branch->delete();
        return redirect('branch')->with('alert-success', 'Branch '. $id .' was successfully deleted.');
    }

    public function branch_update(Request $request)
    {
      $rules = ['branch_name' => 'required',
                'branch_desc' => 'required'];

      $id = $request->branch_id;

      $this->validate($request, $rules);
      $branch = Branch::find($id);
      $branch->branch_name = $request->branch_name;
      $branch->branch_desc = $request->branch_desc;
      $branch->save();

      return redirect('branch')->with('alert-success', 'Branch ' . $id . ' was successfully updated.');
    }

    public function branch_restore(Request $request)
    {
      $id = $request->branch_id;
      $branch = Branch::onlyTrashed()->where('id', '=', $id)->firstOrFail();
      $branch->restore();

      return redirect('branch')->with('alert-success', 'Branch ' . $id . ' was successfully restored.');
    }
}
