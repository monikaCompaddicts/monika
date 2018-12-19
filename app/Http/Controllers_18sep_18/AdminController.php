<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\vendor;
use Flash; 
use Redirect; 

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
		$categories = Category::where('parent_category', 0)->orderBy('category_order', 'asc')->get();
        Flash::success('Category saved successfully.');
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
            $categories[$i]['image'] = $category->image;
            $categories[$i]['parent_category'] = $category->parent_category;
            $categories[$i]['added_on'] = $category->added_on;
            $categories[$i]['status'] = $category->status;
            $categories[$i]['child_category'] = $count_child_category;
            $i++;
        }
        return json_encode($categories);
    }

    public function createCategory(){
        $parentCategories = Category::where('parent_category', 0)->get();
        $parent_categories = array();
        $parent_categories[0] = 'Select';
        foreach ($parentCategories as $value) {
           $parent_categories[$value->id] = $value->name;
        }
        return view('category/create', ['parent_categories' => $parent_categories]);
    }

    public function saveNewCategory(Request $r){
        $image = $r->file('image');
        $image_name = $r->category_name.'-'.time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('image/category_image');
        $image_url = url('public/image/category_image/'.$image_name);
        $image->move($destinationPath, $image_name);

        if($r->parent_category == 0){
            $cat_count = Category::where('parent_category', 0)->count();
            $cat_order = $cat_count+1;
        }else{
            $cat_order = 0;
        }

        $insertCategory = new Category;
        $insertCategory->name = $r->category_name;
        $insertCategory->image = $image_url;
        $insertCategory->parent_category = $r->parent_category;
        $insertCategory->category_order = $cat_order;
        $insertCategory->added_on = date('Y-m-d H:i:s');
        $insertCategory->status = 1;
        $insertCategory->save();
        $categories = Category::where('parent_category', 0)->get();
        Flash::success('Category saved successfully.');
        return redirect('/admin/category');
    }

    public function editCategory(Request $r){
        if($r->has('image')){
            $exists_cat = Category::where('id', $r->category_id)->first();
            $exists_img_arr = explode('/', $exists_cat->image);
            $exists_img_name = $exists_img_arr[count($exists_img_arr)-1];
            $unlink_path = public_path('image/category_image').'/'.$exists_img_arr[count($exists_img_arr)-1];
            unlink($unlink_path);

            $image = $r->file('image');
            $image_name = $r->category_name.'-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('image/category_image');
            $image_url = url('public/image/category_image/'.$image_name);
            $image->move($destinationPath, $image_name);
        }

        $insertCategory = Category::where('id', $r->category_id)->first();
        $insertCategory->name = $r->category_name;
        if($r->has('image')){
            $insertCategory->image = $image_url;
        }
        $insertCategory->save();
        //$categories = Category::where('parent_category', 0)->get();
        Flash::success('Category saved successfully.');
        return redirect('/admin/category');
    }

    public function deleteCategory(Request $r){
        $id = $r->id;
        //Category::where('id', $id)->delete();
        $id_arr = array($id);
        $temp_arr = array($id);
        $categories = Category::where('parent_category', $id)->get();

        if(count($categories) > 0){
            $this->deleteSubCategories(json_encode($id_arr), json_encode($temp_arr));
        }else{
            Category::where('id', $id)->delete();
        }
        return 1;
    }

    function deleteSubCategories($id_json, $temp_json){
        $id_arr = json_decode($id_json);
        $temp_arr = json_decode($temp_json);
       
        $categories = Category::whereIn('parent_category', $temp_arr)->get();

        $count = 0;
        $temp_arr = array();

        if(count($categories) > 0){
            foreach($categories as $cat){
                $id_arr[] = $cat->id;
                $temp_arr[] = $cat->id;
            }
            $this->deleteSubCategories(json_encode($id_arr), json_encode($temp_arr));
        }else{
            Category::whereIn('id', $id_arr)->delete();
            echo 1;exit;
        }   
    }

    public function changeVendorStatus(Request $r){
        $vendor_id = $r->vendor_id;
        $status = $r->status;
        vendor::where('id', $vendor_id)->update(['status' => $status]);
        return 1;
    }

    public function sendMailToVendor($id){
        $vendor = vendor::where('id', $id)->first();
        $email = $vendor->email;
        return Redirect::back();
        //echo $email;exit;
    }

    public function orderCategory(Request $r){
        $ids = $r->ids;
        $id_arr = json_decode(stripslashes($ids));
        $i = 1;
        foreach($id_arr as $k => $cat_id){
            Category::where('id', $cat_id)->update(['category_order' => $i]);
            $i++;
        }
    }

    public function childCategory($parent_id, $category_json){
        $category_arr = json_decode($category_json);
        $categories = Category::where('parent_category', $parent_id)->get();
        
        //return json_encode($category_arr);
        return json_encode($categories);
    }
}
