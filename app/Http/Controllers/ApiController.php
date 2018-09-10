<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\location;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //header('Access-Control-Allow-Origin: *');        
        //header('Access-Control-Allow-Headers: Content-type, X-Auth-Token, Authorization, Origin');
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function testApi(){
        $data = array('id' => 'tgb','name' => 'qwert','age' => 'ssdfs');
        return json_encode($data);
    }
	 public function getCategory()
    {
        $category_arr = array();
		$categories = Category::where('parent_category', 0)->get();
		//return json_encode($categories);
        for($i = 0; $i<count($categories); $i++){
            $category_arr[$i]['id'] = $categories[$i]->id;
            $category_arr[$i]['name'] = $categories[$i]->name;
            $category_arr[$i]['image'] = $categories[$i]->image;
            $category_arr[$i]['status'] = $categories[$i]->status;

            $child_categories = Category::where('parent_category', $categories[$i]->id)->get();
            for($j = 0; $j<count($child_categories); $j++){
                $category_arr[$i]['child_category'][$j]['id'] = $child_categories[$j]->id;
                $category_arr[$i]['child_category'][$j]['name'] = $child_categories[$j]->name;
                $category_arr[$i]['child_category'][$j]['image'] = $child_categories[$j]->image;
                $category_arr[$i]['child_category'][$j]['status'] = $child_categories[$j]->status;
            }
        }
        
        return json_encode($category_arr);

    }

    public function getLocations(){
        $data = array();
        $locations = location::get();
        for($i=0; $i<count($locations); $i++){
            $data[$i]['market_name'] = $locations[$i]->market_name;
            $data[$i]['address'] = $locations[$i]->address;
        } 
        return json_encode($data);  
    }
}

