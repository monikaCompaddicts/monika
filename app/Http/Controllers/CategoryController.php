<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
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
     * @return \Illuminate\Http\Response
     */
	 public function getCategory()
    {
        $category_arr = array();
		$categories = Category::get();
		return json_encode($categories);
    }
	
    public function addCategory()
    {
        
		$name = 'Cars';
		$parent_category = 1;
		$added_on = date('Y-m-d H:i:s');
		$status = 1;
		
		$insertCategory = new Category();
		$insertCategory->name = $name;
		$insertCategory->parent_category = $parent_category;
		$insertCategory->added_on = $added_on;
		$insertCategory->status = $status;
		$insertCategory->save();
		//echo "<pre>";print_r(Category::get());exit;
		return view('home');
    }
}
