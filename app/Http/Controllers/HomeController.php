<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getDashboardData()
    {
        $cat= Category::count();
        $prod= Product::count();
        $data = [
            'total_cat' => $cat,
            'total_prod' => $prod,
        ];
        return response()->success('success',$data);
    }
}
