<?php

namespace App\Http\Controllers;

use App\Models\Addtocart;
use Exception;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

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
        try{
            $category=Category::count();
            $product=Product::count();
            $user=User::count();
            $completed_product=Addtocart::where('is_completed',1)->count();
            $pending_product=Addtocart::where('is_completed',0)->count();
            return view('home',compact('category','product','user','completed_product','pending_product'));
        }
        catch(Exception $ex){
            return abort('404');
            return redirect()->route('login')->withError($ex->getMessage());
        }
    }
}
