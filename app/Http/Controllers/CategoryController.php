<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use DataTables;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if ($request->ajax()) {
            $data = Category::with('parent')->orderBy('id','desc')->get();
            return DataTables::of($data)
                            ->addColumn('parent', function($row){
                                if(isset($row->parent_id) && !empty($row->parent_id))
                                    return $row->parent->name;
                                else
                                    return '-';
                            })
                            ->addColumn('action', function($row){
                                $btn = '<a href= "' . route('admin.category.edit', be64($row->id)) . '" class="btn btn-info btn-xs">Edit</a>&nbsp;';
                                $btn .= '<a href= "' . route('admin.category.show', be64($row->id)) . '" class="btn btn-warning btn-xs">View</a>&nbsp;';
                                $btn .= '<a href="#" data-id='.be64($row->id).' class="btn btn-danger btn-xs delete_cat">Delete</a>';
                                return $btn;
                            })
                            ->addIndexColumn()
                            ->make(true);
        }
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all()->toArray();
        $recursiveArray = recursiveElements($category);
        $parent = flattenDown($recursiveArray);
        return view('admin.category.create',compact('parent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
       $input = $request->all();
        if (isset($input['cat_id'])) 
            $category = Category::find(bd64($request->cat_id));
        else 
            $category = new Category();
        $input = Arr::except($input, ['_token','cat_id']);
        $category->fill($input)->save();
        return redirect()->route('admin.category.index');
   }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $category=Category::find(bd64($id));
      $parent= Category::where('id','!=', bd64($id))->get()->toArray();
        $recursiveArray = recursiveElements($parent);
        $parent = flattenDown($recursiveArray);
       return view('admin.category.show',compact('parent','category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=Category::find(bd64($id));
        $parent= Category::where('id','!=', bd64($id))->get()->toArray();
        $recursiveArray = recursiveElements($parent);
        $parent = flattenDown($recursiveArray);
        return view('admin.category.create',compact('parent','category'));
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
        Category::whereId(bd64($id))->delete();
        return response()->json([ 'status' => '200', 'success' => 'success']);
    }
}
