<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminController extends Controller
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
	 public function getCategories()
    {
        $category_arr = array();
        $getCategory_arr = $this->childCategory(0, json_encode($category_arr));
       // $categories = json_decode($getCategory_arr);
		$categories = Category::where('parent_category', 0)->get();
		return view('category/index', ['categories' => $categories]);
    }

    public function getChildCategory(Request $r){
        $parent_id = $r->parent_id;
        $category_arr = Category::where('parent_category', $parent_id)->get();
        $categories = array();
        $i = 0;
        foreach ($category_arr as $category) {
            $count_child_category = Category::where('parent_category', $category->id)->count();
            $categories[$i]['id'] = $category->id;
            $categories[$i]['name'] = $category->name;
            $categories[$i]['parent_category'] = $category->parent_category;
            $categories[$i]['added_on'] = $category->added_on;
            $categories[$i]['status'] = $category->status;
            $categories[$i]['child_category'] = $count_child_category;
            $i++;
        }
        return json_encode($categories);
    }

    public function childCategory($parent_id, $category_json){
        $category_arr = json_decode($category_json);
        $categories = Category::where('parent_category', $parent_id)->get();
        foreach ($categories as $category) {
            $category_arr[$parent_id][$category->id] = $category->name;
            $this->childCategory($category->id, json_encode($category_arr));
        }
        return json_encode($category_arr);
    }
}
