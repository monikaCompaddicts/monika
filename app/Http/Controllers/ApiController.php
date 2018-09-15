<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\location;
use App\Models\banner;
use App\Models\vendor;
use Validator;

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
                
                $to = "$email";
                $subject = "VMandi - Registered Successfully";
                
                $message = "
                <html>
                <head>
                <title>VMandi - Registered Successfully</title>
                </head>
                <body>
                <p>Hello ".$name."</p>
                <p>Please find your login details below: </p>
                <table>
                <tr>
                <th>Name</th>
                <th>Password</th>
                <th>Email</th>
                <th>Mobile No.</th>
                </tr>
                <tr>
                <td>".$name."</td>
                <td>".$password."</td>
                <td>".$email."</td>
                <td>".$phone."</td>
                </tr>
                </table>
                </body>
                </html>
                ";
                
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                
                // More headers
                $headers .= 'From: <monika@compaddicts.com>' . "\r\n";
                //$headers .= 'Cc: myboss@example.com' . "\r\n";
                
                mail("monikacs0026@gmail.com",$subject,$message,$headers);


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

        return json_encode($data);
    }

    public function loginVendor(Request $r){
        $data = array();
        $email_or_phone = $r->email_or_mobile;
        $password = $r->password;
        // $data['password'] = $password;
        // return json_encode($data);
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
                $vendor_data = $exist_phone_data[0];
            }
        }else{
            $vendor_data = $exist_data[0];
        }

        if(count($vendor_data) != 0){
            $data['status'] = 1;
            $data['id'] = $exist_data[0]->id;
            $data['name'] = $exist_data[0]->name;
            $data['email'] = $exist_data[0]->email;
            $data['phone'] = $exist_data[0]->phone;
            //$data['status'] = $exist_data[0]->status;
            $data['message'] = 'LoggedIn Successfully.';
        }
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

