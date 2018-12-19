<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Category;
use App\Models\location;
use App\Models\banner;
use App\Models\vendor;
use App\Models\Ads;
use App\Models\AdImages;
use Validator;
use File;

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
	
    public function getCategory()    {
        $category_arr = array();
		$categories = Category::where('parent_category', 0)->orderBy('category_order', 'asc')->get();
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

    public function getLocations()    {
        $data = array();
        $locations = location::get();
        for($i=0; $i<count($locations); $i++){
            $data[$i]['id'] = $locations[$i]->id;
            $data[$i]['market_name'] = $locations[$i]->market_name;
            $data[$i]['address'] = $locations[$i]->address;
        }
        
        return json_encode($data);

    }

    public function getbanners()    {
        $data = array();
        $banner = banner::first();
        //for($i=0; $i<count($locations); $i++){
            $data['id'] = $banner->id;
            $data['banner_heading'] = $banner->banner_heading;
            $data['banner_description'] = $banner->banner_description;
            $data['banner_image'] = $banner->banner_image;
       // }
        
        return json_encode($data);

    }

    public function addVendor(Request $r){
        $data = array();
        $name = $r->name;
        $email = $r->email;
        $phone = $r->mobile;
        $user_type = $r->user_type;
        $user_type = 1;
        //return 1;

        $email_validator = Validator::make($r->all(), [
            'email' => 'required|email'
        ]);

        $phone_validator = Validator::make($r->all(), [
            'mobile' => 'required|min:10|max:10'
        ]);

        if ($email_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'email';
            $data['message'] = 'Invalid Email Id!!';
            return json_encode($data);
        }

        if ($phone_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'mobile';
            $data['message'] = 'Invalid Mobile Number!';  
            return json_encode($data);
        }
        //$password = $r->password;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $password = $randomString;
        
        if($user_type == 1){
            $exist_data = vendor::where('email', $email)->get();
            if(count($exist_data) == 0){
                $exist_phone_data = vendor::where('phone', $phone)->get();
                if(count($exist_phone_data) == 0){
                    $insertVendor = new vendor();
                    $insertVendor->name = $name;
                    $insertVendor->email = $email;
                    $insertVendor->phone = $phone;
                    $insertVendor->password = $password;
                    $insertVendor->status = 1;
                    $insertVendor->created_at = date("Y-m-d H:i:s");
                    $insertVendor->updated_at = date("Y-m-d H:i:s");
                    $insertVendor->save();
    
                    $emaildata['name'] = $name;
                    $emaildata['password'] = $password;
                    $user = new \stdClass();
                    $user->email = $email;
    
                    Mail::send('emails.addVendor',$emaildata, function ($message)  use ($user){
    		            $message->to($user->email);
    		            $message->subject('VMandi Account Password');
    		        });
    
                    $data['status'] = 1;
                    $data['id'] = $insertVendor->id;
                    $data['name'] = $insertVendor->name;
                    $data['email'] = $insertVendor->email;
                    $data['phone'] = $insertVendor->phone;
                    $data['status'] = $insertVendor->status;
                    $data['message'] = 'Registered Successfully.';
                }else{
                    $data['status'] = 0;
                    $data['err_key'] = 'mobile';
                    $data['message'] = 'Mobile Number Already Exists!';                
                }
            }else{
                $data['status'] = 0;
                $data['err_key'] = 'email';
                $data['message'] = 'Email Id Already Exists!';
            }
        }

        return json_encode($data);
    }

    public function loginVendor(Request $r){
        $data = array();
        $email_or_phone = $r->email_or_mobile;
        $password = $r->password;

        $email_validator = Validator::make($r->all(), [
            'email_or_mobile' => 'required'
        ]);

        $password_validator = Validator::make($r->all(), [
            'password' => 'required'
        ]);

        if ($email_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'email';
            $data['message'] = 'Email or Mobile is required!';
            return json_encode($data);
        }

        if ($password_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'password';
            $data['message'] = 'Password Required!';  
            return json_encode($data);
        }

        $vendor_data = array();
        $exist_data = vendor::where('email', $email_or_phone)->where('password', $password)->get();
        
        if(count($exist_data) == 0){
            $exist_phone_data = vendor::where('phone', $email_or_phone)->where('password', $password)->get();
            if(count($exist_phone_data) == 0){
                $data['status'] = 0;
                $data['message'] = 'User Not Found!';
            }else{
                $vendor_data = $exist_phone_data;
            }
        }else{
            $vendor_data = $exist_data;
        }

        if(count($vendor_data) != 0){
            $data['status'] = 1;
            $data['id'] = $vendor_data[0]->id;
            $data['name'] = $vendor_data[0]->name;
            $data['email'] = $vendor_data[0]->email;
            $data['phone'] = $vendor_data[0]->phone;
            //$data['status'] = $exist_data[0]->status;
            $data['message'] = 'LoggedIn Successfully.';
        }
        return json_encode($data);
    }

    public function getSubCategory($parent_id){
    	$categories = Category::where('parent_category', $parent_id)->get();
    	$category_arr = array();
		//return json_encode($categories);
		if(count($categories) > 0){
			$category_arr['status'] = 1;
	        for($i = 0; $i<count($categories); $i++){
	            $category_arr[$i]['id'] = $categories[$i]->id;
	            $category_arr[$i]['name'] = $categories[$i]->name;
	            $category_arr[$i]['image'] = $categories[$i]->image;
	            $category_arr[$i]['status'] = $categories[$i]->status;
	        }
	    }else{
	    	$category_arr['status'] = 0;
	    }
        
        return json_encode($category_arr);
    }

    public function postAd(Request $r){
    	$data = array();

    	$user_id = $r->user_id;
    	if($r->sub_category_id == ''){
    		$category_id = $r->category_id;
    	}else{
			$category_id = $r->sub_category_id;
		}
		
		$title = $r->title;
		$description = $r->description;
		$added_on = date('Y-m-d H:i:s');
		$valid_till = date('Y-m-d H:i:s', strtotime(0));
		$status = 1;
        $files = $r->file();

        $user_validator = Validator::make($r->all(), [
            'user_id' => 'required',
        ]);
        if ($user_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'user_id';
            $data['message'] = 'Login to Post Ad!';
            return json_encode($data);
        }
        
        $cat_validator = Validator::make($r->all(), [
            'category_id' => 'required',
        ]);
        if ($cat_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'category_id';
            $data['message'] = 'Category is required!';
            return json_encode($data);
        }
        
        $titlet_validator = Validator::make($r->all(), [
            'title' => 'required',
        ]);
        if ($titlet_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'title';
            $data['message'] = 'Title is required!';
            return json_encode($data);
        }
        $data[0] = count($files);
        
        if(count($files) == 0){
            $data['status'] = 0;
            $data['err_key'] = 'file';
            $data['message'] = 'Image is required!';
            return json_encode($data);
        }else{            
            $img_ext_arr = ["jpg", "jpeg", "png"];
            foreach($files as $file){
                $image_ext = $file->getClientOriginalExtension();
                if (!in_array($image_ext, $img_ext_arr)){
                    $data['status'] = 0;
                    $data['err_key'] = 'file';
                    $data['message'] = 'Invalid File Type!';
                    return json_encode($data);
                }
            }
        }
		
		$insertAd = new Ads();
		$insertAd->user_id = $user_id;
		$insertAd->category_id = $category_id;
		$insertAd->title = $title;
		$insertAd->description = $description;
		$insertAd->added_on = $added_on;
		$insertAd->valid_till = $valid_till;
		$insertAd->status = $status;
		$insertAd->save();
		$ad_id = $insertAd->id;

        $i = 0;
        foreach($files as $file){
         
    		$image = $file;
            $image_name = $ad_id.'_'.time().'_'.$i.'.'.$image->getClientOriginalExtension();
      //       if (! File::exists(public_path('image/ad_images/'.$category_id))) {
    		//     File::makeDirectory('image/ad_images/'.$category_id, $mode = 0777, true, true);
    		// }
            $destinationPath = public_path('image/ad_images/');
            $image_url = url('public/image/ad_images/'.$image_name);
            $image->move($destinationPath, $image_name);

    		$insertAdImage = new AdImages();
    		$insertAdImage->ad_id = $ad_id;
    		$insertAdImage->image = $image_url;
    		$insertAdImage->save();
            $i++;
        }

		$data['status'] = 1;
		$data['message'] = 'Ad Inserted Successfully.';

		return json_encode($data);
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

