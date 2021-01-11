<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use DataTables;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Arr;
use App\Traits\ImgaeUpload;
use App\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {

     use ImgaeUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Product::with('category')->orderBy('id', 'desc')->get();
            return DataTables::of($data)
                            ->addColumn('category', function($row) {
                                return $row->category->name;
                            })
                            ->addColumn('status', function($row) {
                                if ($row->is_active == 1)
                                    return 'Active';
                                else
                                    return 'Inactive';
                            })
                            ->addColumn('action', function($row) {
                                $btn = '<a href= "' . route('admin.products.edit', be64($row->id)) . '" class="btn btn-info btn-xs">Edit</a>&nbsp;';
                                $btn .= '<a href= "' . route('admin.products.show', be64($row->id)) . '" class="btn btn-warning btn-xs">View</a>&nbsp;';
                                $btn .= '<a href="#" data-id=' . be64($row->id) . ' class="btn btn-danger btn-xs delete_prod">Delete</a>';
                                return $btn;
                            })
                            ->addIndexColumn()
                            ->make(true);
        }
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $category = Category::all()->toArray();
        $recursiveArray = recursiveElements($category);
        $category = flattenDown($recursiveArray);
        return view('admin.product.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request) {
        $input = $request->all();
        //dd($request->file('images'));
        if (isset($input['prod_id'])) {
            $prod = Product::find(bd64($input['prod_id']));
        }
        $input = Arr::except($input, ['_token', 'prod_id']);
        $input['is_active']=isset($input['is_active'])?1:0;
        if (isset($prod)) {
            $prod->fill($input)->save();
        } else {
            $prod = Product::create($input);
        }
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $files) {
                $extension = $files->getClientOriginalExtension();
                if (in_array($extension, ["jpg", "gif", "jpeg", "png", "bmp","PNG","JPG","JPEG"])) {
                    $imageName = $this->imageUploder($files, '', 'products');
                    $prod->images()->create(['image' => $imageName]);
                }
            }
        }
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $category = Category::all()->toArray();
        $recursiveArray = recursiveElements($category);
        $category = flattenDown($recursiveArray);
        $product= Product::with('images')->whereId(bd64($id))->first();
        return view('admin.product.show',compact('product','category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $category = Category::all()->toArray();
        $recursiveArray = recursiveElements($category);
        $category = flattenDown($recursiveArray);
        $product= Product::with('images')->whereId(bd64($id))->first();
        return view('admin.product.create',compact('product','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $getFiles=ProductImage::where('product_id', bd64($id))->get();
        if(!$getFiles->isEmpty()){
            foreach($getFiles as $v) {
                 Storage::disk('public')->delete('products/'.$v->image);
            }
        }
        Product::whereId(bd64($id))->delete();
       return response()->json([ 'status' => '200', 'success' => 'success']);
    }

}
