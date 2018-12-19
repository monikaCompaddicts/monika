<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Models\Category;
use App\Models\location;
use App\Models\banner;
use App\Models\vendor;
use App\Models\Ads;
use App\Models\AdImages;
use App\Models\Customer;
use App\Models\ReceiveAlertUsers;
use App\Models\Advertisement;
use App\Models\UserType;
use App\Models\CMS;
use App\Models\CmsTitle;
use App\Models\AdEnquiry;
use App\Models\AdLocations;
use App\Models\AdUnits;
use App\Models\ContactUs;
use App\Models\States;
use App\Models\Ticker;
use App\Models\review;
use App\Models\Report;
use Validator;
use File;
use DB;
use Cache;

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
            $category_arr[$i]['description'] = $categories[$i]->description;
            $category_arr[$i]['unit'] = $categories[$i]->unit;

            $child_categories = Category::where('parent_category', $categories[$i]->id)->get();
            if(count($child_categories) == 0){
               // $category_arr[$i]['child_category'] = array();
            }else{
                for($j = 0; $j<count($child_categories); $j++){
                    $category_arr[$i]['child_category'][$j]['id'] = $child_categories[$j]->id;
                    $category_arr[$i]['child_category'][$j]['name'] = $child_categories[$j]->name;
                    $category_arr[$i]['child_category'][$j]['image'] = $child_categories[$j]->image;
                    $category_arr[$i]['child_category'][$j]['status'] = $child_categories[$j]->status;
                    $category_arr[$i]['child_category'][$j]['description'] = $child_categories[$j]->description;
                    $category_arr[$i]['child_category'][$j]['unit'] = $child_categories[$j]->unit;
                }
            }
        }
        
        return json_encode($category_arr);

    }
    
    public function getCategoryApp()    {
        $category_arr = array();
        $categories = Category::where('parent_category', 0)->orderBy('category_order', 'asc')->get();
        //return json_encode($categories);
        if(count($categories) == 0){
            $category_arr['status'] = 0;
            $category_arr['message'] = 'No category founds!';
        }else{
            $category_arr['status'] = 1;
            for($i = 0; $i<count($categories); $i++){
                $category_arr['category'][$i]['id'] = $categories[$i]->id;
                $category_arr['category'][$i]['name'] = $categories[$i]->name;
                $category_arr['category'][$i]['image'] = $categories[$i]->image;
                $category_arr['category'][$i]['status'] = $categories[$i]->status;
                $category_arr['category'][$i]['description'] = $categories[$i]->description;
                $category_arr['category'][$i]['unit'] = $categories[$i]->unit;
    
                $child_categories = Category::where('parent_category', $categories[$i]->id)->get();
                if(count($child_categories) == 0){
                    $category_arr['category'][$i]['child_category'] = array();
                }else{
                    for($j = 0; $j<count($child_categories); $j++){
                        $category_arr['category'][$i]['child_category'][$j]['id'] = $child_categories[$j]->id;
                        $category_arr['category'][$i]['child_category'][$j]['name'] = $child_categories[$j]->name;
                        $category_arr['category'][$i]['child_category'][$j]['image'] = $child_categories[$j]->image;
                        $category_arr['category'][$i]['child_category'][$j]['status'] = $child_categories[$j]->status;
                        $category_arr['category'][$i]['child_category'][$j]['description'] = $child_categories[$j]->description;
                        $category_arr['category'][$i]['child_category'][$j]['unit'] = $child_categories[$j]->unit;
                    }
                }
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
            $data[$i]['market'] = $locations[$i]->market_name.' ('.$locations[$i]->address.')';
        }
        
        return json_encode($data);

    }

    public function getbanners()    {
        $data = array();
        $banner = banner::first();
        //for($i=0; $i<count($locations); $i++){
            $data['id'] = $banner->id;
            $data['banner_heading'] = str_replace('"', "'", $banner->banner_heading);
            $data['banner_description'] = str_replace('"', "'", $banner->banner_description);
            $data['banner_image'] = str_replace('"', "'", $banner->banner_image);
       // }
        
        return stripslashes(json_encode($data));

    }

    public function addVendor(Request $r){
        $data = array();
        $name = $r->name;
        $email = $r->email;
        $phone = $r->mobile;
        $user_type = $r->user_type;
        $pincode = $r->pincode;
        //return 1;
        $name_validator = Validator::make($r->all(), [
            'name' => 'required'
        ]);

        $email_validator = Validator::make($r->all(), [
            'email' => 'required|email'
        ]);

        $phone_validator = Validator::make($r->all(), [
            'mobile' => 'required|min:10|max:10'
        ]);
        
        $pincode_validator = Validator::make($r->all(), [
            'pincode' => 'required|min:6|max:6'
        ]);

        if ($name_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'name';
            $data['message'] = 'Invalid name type!';
            return json_encode($data);
        }

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
        
        if ($pincode_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'pincode';
            $data['message'] = 'Invalid Postal Code!';  
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
                    $insertVendor->pincode = $pincode;
                    $insertVendor->status = 1;
                    $insertVendor->created_at = date("Y-m-d H:i:s");
                    $insertVendor->updated_at = date("Y-m-d H:i:s");
                    $insertVendor->save();

                    $insertUserType = new UserType();
                    $insertUserType->user_type = $user_type;
                    $insertUserType->user_id = $insertVendor->id;
                    $insertUserType->save();
    
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
                    $data['address'] = '';
                    $data['city'] = '';
                    $data['pincode'] = $insertVendor->pincode;
                    //$data['house'] = '';
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
        else{
            $exist_data = Customer::where('email', $email)->get();
            if(count($exist_data) == 0){
                $exist_phone_data = Customer::where('phone', $phone)->get();
                if(count($exist_phone_data) == 0){
                    $insertCustomer = new Customer();
                    $insertCustomer->name = $name;
                    $insertCustomer->email = $email;
                    $insertCustomer->phone = $phone;
                    $insertCustomer->password = $password;
                    $insertCustomer->pincode = $pincode;
                    $insertCustomer->status = 1;
                    $insertCustomer->added_on = date("Y-m-d H:i:s");
                    $insertCustomer->updated_on = date("Y-m-d H:i:s");
                    $insertCustomer->save();

                    $insertUserType = new UserType();
                    $insertUserType->user_type = $user_type;
                    $insertUserType->user_id = $insertCustomer->id;
                    $insertUserType->save();
    
                    $emaildata['name'] = $name;
                    $emaildata['password'] = $password;
                    $user = new \stdClass();
                    $user->email = $email;
    
                    Mail::send('emails.addVendor',$emaildata, function ($message)  use ($user){
                        $message->to($user->email);
                        $message->subject('VMandi Account Password');
                    });
    
                    $data['status'] = 1;
                    $data['id'] = $insertCustomer->id;
                    $data['name'] = $insertCustomer->name;
                    $data['email'] = $insertCustomer->email;
                    $data['phone'] = $insertCustomer->phone;
                    $data['status'] = $insertCustomer->status;
                    $data['address'] = '';
                    $data['city'] = '';
                    $data['pincode'] = $insertCustomer->pincode;
                    //$data['house'] = '';
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
    
    public function addVendorProvider(Request $r){
        $data = array();
        $name = $r->name;
        $email = $r->email;
        $user_type = $r->user_type;
        $provider = $r->provider;
        $provider_id = $r->provider_id;
        //return 1;
        $name_validator = Validator::make($r->all(), [
            'name' => 'required'
        ]);

        $email_validator = Validator::make($r->all(), [
            'email' => 'required|email'
        ]);

        if ($name_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'name';
            $data['message'] = 'Invalid name type!';
            return json_encode($data);
        }

        if ($email_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'email';
            $data['message'] = 'Invalid Email Id!!';
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
                $insertVendor = new vendor();
                $insertVendor->name = $name;
                $insertVendor->email = $email;
                $insertVendor->password = $password;
                $insertVendor->status = 1;
                $insertVendor->provider = $provider;
                $insertVendor->provider_id = $provider_id;
                $insertVendor->created_at = date("Y-m-d H:i:s");
                $insertVendor->updated_at = date("Y-m-d H:i:s");
                $insertVendor->save();

                $insertUserType = new UserType();
                $insertUserType->user_type = $user_type;
                $insertUserType->user_id = $insertVendor->id;
                $insertUserType->save();

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
                $data['address'] = '';
                $data['city'] = '';
                $data['pincode'] = '';
                $data['user_type'] = $user_type;
                //$data['house'] = '';
                $data['message'] = 'LoggedIn Successfully.';
            }else{
                $data['status'] = 1;
                $data['id'] = $exist_data[0]->id;
                $data['name'] = $exist_data[0]->name;
                $data['email'] = $exist_data[0]->email;
                $data['phone'] = $exist_data[0]->phone;
                $data['status'] = $exist_data[0]->status;
                $data['address'] = $exist_data[0]->address;
                $data['city'] = $exist_data[0]->city;
                $data['pincode'] = $exist_data[0]->pincode;
                $data['user_type'] = $user_type;
                //$data['house'] = '';
                $data['message'] = 'LoggedIn Successfully.';
            }
        }
        else{
            $exist_data = Customer::where('email', $email)->get();
            if(count($exist_data) == 0){
                $insertCustomer = new Customer();
                $insertCustomer->name = $name;
                $insertCustomer->email = $email;
                $insertCustomer->password = $password;
                $insertCustomer->status = 1;
                $insertCustomer->provider = $provider;
                $insertCustomer->provider_id = $provider_id;
                $insertCustomer->added_on = date("Y-m-d H:i:s");
                $insertCustomer->updated_on = date("Y-m-d H:i:s");
                $insertCustomer->save();

                $insertUserType = new UserType();
                $insertUserType->user_type = $user_type;
                $insertUserType->user_id = $insertCustomer->id;
                $insertUserType->save();

                $emaildata['name'] = $name;
                $emaildata['password'] = $password;
                $user = new \stdClass();
                $user->email = $email;

                Mail::send('emails.addVendor',$emaildata, function ($message)  use ($user){
                    $message->to($user->email);
                    $message->subject('VMandi Account Password');
                });

                $data['status'] = 1;
                $data['id'] = $insertCustomer->id;
                $data['name'] = $insertCustomer->name;
                $data['email'] = $insertCustomer->email;
                $data['phone'] = $insertCustomer->phone;
                $data['status'] = $insertCustomer->status;
                $data['address'] = '';
                $data['city'] = '';
                $data['pincode'] = '';
                $data['user_type'] = $user_type;
                //$data['house'] = '';
                $data['message'] = 'LoggedIn Successfully.';
            }else{
                $data['status'] = 1;
                $data['id'] = $exist_data[0]->id;
                $data['name'] = $exist_data[0]->name;
                $data['email'] = $exist_data[0]->email;
                $data['phone'] = $exist_data[0]->phone;
                $data['status'] = $exist_data[0]->status;
                $data['address'] = $exist_data[0]->address;
                $data['city'] = $exist_data[0]->city;
                $data['pincode'] = $exist_data[0]->pincode;
                $data['user_type'] = $user_type;
                //$data['house'] = '';
                $data['message'] = 'LoggedIn Successfully.';
            }
        }

        return json_encode($data);
    }

    public function loginVendor(Request $r){
        $data = array();
        $email_or_phone = $r->email_or_mobile;
        $password = $r->password;
        $user_type = $r->user_type;

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

        if($user_type == 1){
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
                $data['user_type'] = 1;
                $data['id'] = $vendor_data[0]->id;
                $data['name'] = $vendor_data[0]->name;
                $data['email'] = $vendor_data[0]->email;
                $data['phone'] = $vendor_data[0]->phone;
                $data['address'] = $vendor_data[0]->address;
                $data['city'] = $vendor_data[0]->city;
                $data['pincode'] = $vendor_data[0]->pincode;
                //$data['house'] = $vendor_data[0]->house;
                $data['message'] = 'LoggedIn Successfully.';
            }
        }
        else{
            $customer_data = array();
            $exist_data = Customer::where('email', $email_or_phone)->where('password', $password)->get();
            
            if(count($exist_data) == 0){
                $exist_phone_data = Customer::where('phone', $email_or_phone)->where('password', $password)->get();
                if(count($exist_phone_data) == 0){
                    $data['status'] = 0;
                    $data['message'] = 'User Not Found!';
                }else{
                    $customer_data = $exist_phone_data;
                }
            }else{
                $customer_data = $exist_data;
            }

            if(count($customer_data) != 0){
                $data['status'] = 1;
                $data['user_type'] = 2;
                $data['id'] = $customer_data[0]->id;
                $data['name'] = $customer_data[0]->name;
                $data['email'] = $customer_data[0]->email;
                $data['phone'] = $customer_data[0]->phone;
                $data['address'] = $customer_data[0]->address;
                $data['city'] = $customer_data[0]->city;
                $data['pincode'] = $customer_data[0]->pincode;
                //$data['house'] = $customer_data[0]->house;
                //$data['status'] = $exist_data[0]->status;
                $data['message'] = 'LoggedIn Successfully.';
            }
        }
        return json_encode($data);
    }

    public function forgotPassword(Request $r){
        $data = array();
        $email_or_phone = $r->email_or_mobile;
        $user_type = $r->user_type;

        $validator = Validator::make($r->all(), [
            'email_or_mobile' => 'required',
            'user_type' => 'required'
        ]);

        if ($validator->fails()) {

            $failedRules = $validator->failed();

            if(isset($failedRules['email_or_mobile'])) {
                $data['status'] = 0;
                $data['email_or_mobile'] = 'Email or Mobile is required!';                
            }

            if(isset($failedRules['user_type'])) {
                $data['status'] = 0;
                $data['user_type'] = 'User type is required!';                
            }

            return json_encode($data);
        }

        $user_email_data = array();
        $user_phone_data = array();

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $password = $randomString;

        if($user_type == 1){
            $vendor_data = array();
            $exist_data = vendor::where('email', $email_or_phone)->get();
            
            if(count($exist_data) == 0){
                $exist_phone_data = vendor::where('phone', $email_or_phone)->get();
                if(count($exist_phone_data) == 0){
                    $data['status'] = 0;
                    $data['message'] = 'Vendor Not Found!';
                }else{
                    $user_phone_data = $exist_phone_data;
                    $id = $user_phone_data[0]->id;
                    vendor::where('id', $id)->update(['password' => $password]);
                }
            }else{
                $user_email_data = $exist_data;
                $id = $user_email_data[0]->id;
                vendor::where('id', $id)->update(['password' => $password]);
            }
        }
        else{
            $customer_data = array();
            $exist_data = Customer::where('email', $email_or_phone)->get();
            
            if(count($exist_data) == 0){
                $exist_phone_data = Customer::where('phone', $email_or_phone)->get();
                if(count($exist_phone_data) == 0){
                    $data['status'] = 0;
                    $data['message'] = 'Customer Not Found!';
                }else{
                    $user_phone_data = $exist_phone_data;
                    $id = $user_phone_data[0]->id;
                    Customer::where('id', $id)->update(['password' => $password]);
                }
            }else{
                $user_email_data = $exist_data;
                $id = $user_phone_data[0]->id;
                Customer::where('id', $id)->update(['password' => $password]);
            }
        }
        
        if(count($user_email_data) != 0){
            $name = $user_email_data[0]->name;
            $email = $user_email_data[0]->email;
            $phone = $user_email_data[0]->phone;

            $emaildata['name'] = $name;
            $emaildata['password'] = $password;
            $user = new \stdClass();
            $user->email = $email;

            Mail::send('emails.forgotPassword',$emaildata, function ($message)  use ($user){
                $message->to($user->email);
                $message->subject('VMandi Account Frogot Password');
            });
            
            $data['status'] = 1;
            $data['message'] = "Your password has been updated and send to your email id successfully.";
        }

        if(count($user_phone_data) != 0){
            $name = $user_phone_data[0]->name;
            $email = $user_phone_data[0]->email;
            $phone = $user_phone_data[0]->phone;
            
            $data['status'] = 1;
            $data['message'] = "Your password has been updated and send to your mobile number successfully.";
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
    
    public function getSubCategoryApp($parent_id){
        $categories = Category::where('parent_category', $parent_id)->get();
        $category_arr = array();
        //return json_encode($categories);
        if(count($categories) > 0){
            $category_arr['status'] = 1;
            for($i = 0; $i<count($categories); $i++){
                $category_arr['sub_category'][$i]['id'] = $categories[$i]->id;
                $category_arr['sub_category'][$i]['name'] = $categories[$i]->name;
                $category_arr['sub_category'][$i]['image'] = $categories[$i]->image;
                $category_arr['sub_category'][$i]['status'] = $categories[$i]->status;
            }
        }else{
            $category_arr['status'] = 0;
        }
        
        return json_encode($category_arr);
    }
    
    public function checkImage(Request $r){
        $r_image = $r->images;
        //echo $r_image;exit;
        //base64Mime($r_image)
        // receive image as POST Parameter
        $image = str_replace('data:image/png;base64,', '', $r_image);
        $image = str_replace(' ', '+', $image);
        // Decode the Base64 encoded Image
        $data = base64_decode($image);
        // Create Image path with Image name and Extension
        //$destinationPath = public_path('image/ad_images/');
        $file = public_path('image/') . "MyImage" . '.jpg';
        // Save Image in the Image Directory
        $success = file_put_contents($file, $data);

        echo $success;exit;
        
    }
    
    public function getStates(){
        $data['states'] = States::orderBy('state_name', 'asc')->get()->toArray();
        return json_encode($data);
    }
    
    public function postAd(Request $r){
        $data = array();
        $app_or_web = $r->app_or_web; //Send this key only from app
        $user_id = $r->user_id;
        if($r->sub_category_id == ''){
            $category_id = $r->category_id;
        }else{
            $category_id = $r->sub_category_id;
        }
        
        $title = $r->title;
        $description = $r->description;
        $price = $r->price;
        $unit = $r->unit;
        $brand_name = $r->brand_name;
        $breed_name = $r->breed_name;
        
        $address = $r->address;
        $city = $r->city;
        $state = $r->state;
        $pincode = $r->pincode;
        
        $added_on = date('Y-m-d H:i:s');
        $valid_till = date('Y-m-d H:i:s', strtotime(0));
        $status = 1;
        $files = $r->file();
        if (array_key_exists("app_or_web",$r->all())){
            $files = json_decode($r->file);
        }
        
        $address_validator = Validator::make($r->all(), [
            'user_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'string|min:3|max:500'
        ]);

        if ($address_validator->fails()) {

            $failedRules = $address_validator->failed();
            
            if(isset($failedRules['user_id'])) {
                $data['status'] = 0;
                $data['user_id'] = 'Please login to post an ad!';                
            }
            
            if(isset($failedRules['category_id'])) {
                $data['status'] = 0;
                $data['category_id'] = 'Category is required!';                
            }
            
            if(isset($failedRules['title'])) {
                $data['status'] = 0;
                $data['title'] = 'Ttitle is required!';                
            }
            
            if(isset($failedRules['description'])) {
                $data['status'] = 0;
                $data['description'] = 'Description must not exceed to 500 characters!';                
            }
            
            return json_encode($data);
        }
       
        
        if(count($files) == 0){
            $data['status'] = 0;
            $data['err_key'] = 'file';
            $data['message'] = 'Image is required!';
            return json_encode($data);
        }else{     
            if (array_key_exists("app_or_web",$r->all())){
                //$files = $r->file;
            }else{
                $img_ext_arr = ["jpg", "jpeg", "png"];
                foreach($files as $file){
                    $image_ext = strtolower($file->getClientOriginalExtension());
                    if (!in_array($image_ext, $img_ext_arr)){
                        $data['status'] = 0;
                        $data['err_key'] = 'file';
                        $data['message'] = 'Invalid File Type!';
                        return json_encode($data);
                    }
                }
            }
        }
        
        $insertAd = new Ads();
        $insertAd->user_id = $user_id;
        $insertAd->category_id = $category_id;
        $insertAd->title = $title;
        $insertAd->description = $description;
        $insertAd->price = $price;
        $insertAd->unit = $unit;
        $insertAd->brand_name = $brand_name;
        $insertAd->breed_name = $breed_name;
        $insertAd->address = $address;
        $insertAd->city = $city;
        $insertAd->state = $state;
        $insertAd->pincode = $pincode;
        //$insertAd->location = $locations[0];
        $insertAd->added_on = $added_on;
        $insertAd->valid_till = $valid_till;
        $insertAd->status = $status;
        $insertAd->save();
        $ad_id = $insertAd->id;
        
       
        
        $i = 0;
        if (array_key_exists("app_or_web",$r->all())){
            foreach($files as $app_img){
                $image = str_replace('data:image/png;base64,', '', $app_img);
                $image = str_replace(' ', '+', $image);
                $input_img = base64_decode($image);
                $file = public_path('image/ad_images/') . $ad_id.'_'.time().'_'.$i. '.jpg';
                $image_url = url('public/image/ad_images/'.$ad_id.'_'.time().'_'.$i. '.jpg');
                $success = file_put_contents($file, $input_img);
                
                $insertAdImage = new AdImages();
                $insertAdImage->ad_id = $ad_id;
                $insertAdImage->image = $image_url;
                $insertAdImage->save();
                $i++;
            }
        }else{
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
        }

        $data['status'] = 1;
        $data['ad_id'] = $ad_id;
        $data['message'] = 'Ad Inserted Successfully.';

        return json_encode($data);
    }
    
    /*
    old
    public function postAd(Request $r){
        $data = array();
        $app_or_web = $r->app_or_web; //Send this key only from app
        $user_id = $r->user_id;
        if($r->sub_category_id == ''){
            $category_id = $r->category_id;
        }else{
            $category_id = $r->sub_category_id;
        }
        
        $title = $r->title;
        $description = $r->description;
        $price = $r->price;
        $unit = $r->unit;
        $brand_name = $r->brand_name;
        $breed_name = $r->breed_name;
        
        $address = $r->address;
        $city = $r->city;
        $state = $r->state;
        $pincode = $r->pincode;
        
        //$locations = json_decode($r->locations);
        //echo "<pre>";print_r($r->all());print_r($locations);exit;
        $added_on = date('Y-m-d H:i:s');
        $valid_till = date('Y-m-d H:i:s', strtotime(0));
        $status = 1;
        $files = $r->file();
        if (array_key_exists("app_or_web",$r->all())){
            $files = json_decode($r->file);
        }

        
        
        $address_validator = Validator::make($r->all(), [
            'user_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'string|min:3|max:500',
            'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'unit' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required|min:6|max:6'
        ]);

        if ($address_validator->fails()) {

            $failedRules = $address_validator->failed();
            
            if(isset($failedRules['user_id'])) {
                $data['status'] = 0;
                $data['user_id'] = 'Please login to post an ad!';                
            }
            
            if(isset($failedRules['category_id'])) {
                $data['status'] = 0;
                $data['category_id'] = 'Category is required!';                
            }
            
            if(isset($failedRules['title'])) {
                $data['status'] = 0;
                $data['title'] = 'Ttitle is required!';                
            }
            
            if(isset($failedRules['description'])) {
                $data['status'] = 0;
                $data['description'] = 'Description must not exceed to 500 characters!';                
            }
            
            if(isset($failedRules['price']['Required'])) {
                $data['status'] = 0;
                $data['price'] = 'Price is required!';                
            }
            
            if(isset($failedRules['price']['Regex'])) {
                $data['status'] = 0;
                $data['price'] = 'Invalid price!';                
            }
            
            if(isset($failedRules['unit'])) {
                $data['status'] = 0;
                $data['unit'] = 'Unit is required!';                
            }
            
            if(isset($failedRules['address'])) {
                $data['status'] = 0;
                $data['address'] = 'Address is required!';                
            }
            
            if(isset($failedRules['city'])) {
                $data['status'] = 0;
                $data['city'] = 'City is required!';                
            }
            
            if(isset($failedRules['state'])) {
                $data['status'] = 0;
                $data['state'] = 'State is required!';                
            }
            
            if(isset($failedRules['pincode']['Required'])) {
                $data['status'] = 0;
                $data['pincode'] = 'Pincode is required!';                
            }
            
            if(isset($failedRules['pincode']['Min'])) {
                $data['status'] = 0;
                $data['pincode_min'] = 'Pincode should have minimum 6 digits!';                
            }

            if(isset($failedRules['pincode']['Max'])) {
                $data['status'] = 0;
                $data['pincode_max'] = 'Pincode should have maximum 6 digits!';                
            }
            return json_encode($data);
        }
        
        if(count($files) == 0){
            $data['status'] = 0;
            $data['err_key'] = 'file';
            $data['message'] = 'Image is required!';
            return json_encode($data);
        }else{     
            if (array_key_exists("app_or_web",$r->all())){
                //$files = $r->file;
            }else{
                $img_ext_arr = ["jpg", "jpeg", "png"];
                foreach($files as $file){
                    $image_ext = strtolower($file->getClientOriginalExtension());
                    if (!in_array($image_ext, $img_ext_arr)){
                        $data['status'] = 0;
                        $data['err_key'] = 'file';
                        $data['message'] = 'Invalid File Type!';
                        return json_encode($data);
                    }
                }
            }
        }
        
        $insertAd = new Ads();
        $insertAd->user_id = $user_id;
        $insertAd->category_id = $category_id;
        $insertAd->title = $title;
        $insertAd->description = $description;
        $insertAd->price = $price;
        $insertAd->unit = $unit;
        $insertAd->brand_name = $brand_name;
        $insertAd->breed_name = $breed_name;
        $insertAd->address = $address;
        $insertAd->city = $city;
        $insertAd->state = $state;
        $insertAd->pincode = $pincode;
        //$insertAd->location = $locations[0];
        $insertAd->added_on = $added_on;
        $insertAd->valid_till = $valid_till;
        $insertAd->status = $status;
        $insertAd->save();
        $ad_id = $insertAd->id;
        
        $i = 0;
        if (array_key_exists("app_or_web",$r->all())){
            foreach($files as $app_img){
                $image = str_replace('data:image/png;base64,', '', $app_img);
                $image = str_replace(' ', '+', $image);
                $input_img = base64_decode($image);
                $file = public_path('image/ad_images/') . $ad_id.'_'.time().'_'.$i. '.jpg';
                $image_url = url('public/image/ad_images/'.$ad_id.'_'.time().'_'.$i. '.jpg');
                $success = file_put_contents($file, $input_img);
                
                $insertAdImage = new AdImages();
                $insertAdImage->ad_id = $ad_id;
                $insertAdImage->image = $image_url;
                $insertAdImage->save();
                $i++;
            }
        }else{
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
        }

        $data['status'] = 1;
        $data['ad_id'] = $ad_id;
        $data['message'] = 'Ad Inserted Successfully.';

        return json_encode($data);
    }
    */

    public function getAd($vendor_id = ''){
        $data = array();

        if($vendor_id == ''){
            $ad_data = Ads::where('status', 1)->orderBy('id', 'desc')->get();
        }else{
            $ad_data = Ads::where('user_id', $vendor_id)->orderBy('id', 'desc')->get();
        }

        if(count($ad_data) == 0){
            $data['status'] = 0;
            $data['message'] = 'No Ads Found.';
        }else{
            $data['status'] = 1;
            $i = 0;
            foreach($ad_data as $ad){
                $category = Category::where('id', $ad->category_id)->get();
                //$unit = AdUnits::where('id', $ad->unit)->first();
                // $locations = array();
                // $ad_locations = AdLocations::where('ad_id', $ad->id)->get();
                // foreach($ad_locations as $ad_location){
                //     $loc = location::where('id', $ad_location->location)->first();
                //     if($loc == ''){
                //         $locations[] = '';
                //     }else{
                //         $locations[] = $loc->market_name;
                //     }
                // }
               // echo "<pre>";print_r($category);exit;
                $data['ad'][$i]['id'] = $ad->id;
                $data['ad'][$i]['category'] = $category[0]->name;
                $data['ad'][$i]['title'] = $ad->title;
                $data['ad'][$i]['price'] = $ad->price;
                //$data['ad'][$i]['unit'] = $unit->name;
                $data['ad'][$i]['unit'] = $ad->unit;
                $data['ad'][$i]['address'] = $ad->address;
                $data['ad'][$i]['city'] = $ad->city;
                $data['ad'][$i]['pincode'] = $ad->pincode;
                $data['ad'][$i]['state'] = $ad->state;
                //$data['ad'][$i]['state_name'] = States::where('id', $ad->state)->first()->state_name;
                $data['ad'][$i]['brand_name'] = $ad->brand_name;
                $data['ad'][$i]['breed_name'] = $ad->breed_name;
                $data['ad'][$i]['description'] = $ad->description;
                
                $images = AdImages::where('ad_id', $ad->id)->get();
                $j = 0;
                foreach($images as $img){
                    $data['ad'][$i]['images'][$j] = $img->image;
                    $j++;
                }
                $i++;
            }
        }
        return json_encode($data);
    }
    
    public function getAdApp($vendor_id = ''){
        $data = array();

        if($vendor_id == ''){
            $ad_data = Ads::where('status', 1)->orderBy('id', 'desc')->get();
        }else{
            $ad_data = Ads::where('user_id', $vendor_id)->orderBy('id', 'desc')->get();
        }

        if(count($ad_data) == 0){
            $data['status'] = 0;
            $data['message'] = 'No Ads Found.';
        }else{
            $data['status'] = 1;
            $i = 0;
            foreach($ad_data as $ad){
                $category = Category::where('id', $ad->category_id)->get();
                //$unit = AdUnits::where('id', $ad->unit)->first();
                // $locations = array();
                // $ad_locations = AdLocations::where('ad_id', $ad->id)->get();
                // foreach($ad_locations as $ad_location){
                //     $loc = location::where('id', $ad_location->location)->first();
                //     if($loc == ''){
                //         $locations[] = '';
                //     }else{
                //         $locations[] = $loc->market_name;
                //     }
                // }
               // echo "<pre>";print_r($category);exit;
                $data['ads'][$i]['id'] = $ad->id;
                $data['ads'][$i]['category'] = $category[0]->name;
                $data['ads'][$i]['title'] = $ad->title;
                $data['ads'][$i]['price'] = $ad->price;
                //$data['ads'][$i]['unit'] = $unit->name;
                $data['ads'][$i]['unit'] = $ad->unit;
                // $data['ads'][$i]['locations'] = $locations;
                $data['ad'][$i]['address'] = $ad->address;
                $data['ad'][$i]['city'] = $ad->city;
                $data['ad'][$i]['pincode'] = $ad->pincode;
                $data['ad'][$i]['state'] = $ad->state;
                //$data['ad'][$i]['state_name'] = States::where('id', $ad->state)->first()->state_name;
                $data['ads'][$i]['brand_name'] = $ad->brand_name;
                $data['ads'][$i]['breed_name'] = $ad->breed_name;
                $data['ads'][$i]['description'] = $ad->description;
                
                $images = AdImages::where('ad_id', $ad->id)->get();
                $j = 0;
                foreach($images as $img){
                    $data['ads'][$i]['images'][$j] = $img->image;
                    $j++;
                }
                $i++;
            }
        }
        return json_encode($data);
    }
    
    public function getAdByCategory(Request $r)
    {
        $data = array();
        $category_id = $r->cat_id;
        $keyword = $r->keyword;
        
        if($category_id != '' && $keyword == ''){
            $cats = Category::where('id', $category_id)->first();
            if($cats->parent_category == 0){
                $data['cat_id'] = $cats->id;
                $data['cat_name'] = $cats->name;
            }else{
                $cats = Category::where('id', $cats->parent_category)->first();
                $data['cat_id'] = $cats->id;
                $data['cat_name'] = $cats->name;
            }
            
            $ids_arr = [$category_id];
            $sub_categories = Category::where('parent_category', $category_id)->get();
           
            if(count($sub_categories) > 0) {
                foreach ($sub_categories as $sub_category) {
                    array_push($ids_arr, $sub_category->id);     
                }     
            }
            
            $data['ads'] = [];
           $ads_result = Ads::where('status', 1)->whereIn('category_id', $ids_arr)->get();
           //echo "<pre>";print_r($ads_result);exit;
           foreach ($ads_result as $key => $value) {
            //echo "<pre>";print_r($value);exit;
                $ads_images = AdImages::where('ad_id', $value->id)->get(); 
                
                // $locations = array();
                // $ad_locations = AdLocations::where('ad_id', $value->id)->get();
                // foreach($ad_locations as $ad_location){
                //     $loc = location::where('id', $ad_location->location)->first();
                //     if($loc == ''){
                //         $locations[] = '';
                //     }else{
                //         $locations[] = $loc->market_name;
                //     }
                // }

                $data['ads'][$key] = $value;
                //$data['ads'][$key]['state_name'] = States::where('id', $value->state)->first()->state_name;
                $imgs = [];
                foreach ($ads_images as $ad_iamge) {
                    array_push($imgs, $ad_iamge->image);
                }
                $data['ads'][$key]['images'] = $imgs;

                $cats = Category::where('id', $value->category_id)->first();
                if($cats->parent_category == 0){
                    $data['ads'][$key]['cat_id'] = $cats->id;
                    $data['ads'][$key]['category_name'] = $cats->name;
                    $data['ads'][$key]['sub_category_id'] = '';
                    $data['ads'][$key]['sub_category_name'] = '';
                }else{
                    $p_cats = Category::where('id', $cats->parent_category)->first();
                    $data['ads'][$key]['cat_id'] = $p_cats->id;
                    $data['ads'][$key]['category_name'] = $p_cats->name;
                    $data['ads'][$key]['sub_category_id'] = $cats->id;
                    $data['ads'][$key]['sub_category_name'] = $cats->name;
                }

            }
            return json_encode($data);
        }
        else if($category_id != '' && $keyword != ''){
            $cats = Category::where('id', $category_id)->first();
            if($cats->parent_category == 0){
                $data['cat_id'] = $cats->id;
                $data['cat_name'] = $cats->name;
            }else{
                $cats = Category::where('id', $cats->parent_category)->first();
                $data['cat_id'] = $cats->id;
                $data['cat_name'] = $cats->name;
            }
            
            $ids_arr = [$category_id];
            $sub_categories = Category::where('parent_category', $category_id)->get();
           
            if(count($sub_categories) > 0) {
                foreach ($sub_categories as $sub_category) {
                    array_push($ids_arr, $sub_category->id);     
                }     
            }
            
            $data['ads'] = [];
           //$ads_result = Ads::whereIn('category_id', $ids_arr)->get();
           $ads_result = Ads::where('status', 1)->whereIn('category_id', $ids_arr)
                        ->where(function($query) use ($keyword)
                        {
                            $query->where('title', 'like', '%'.$keyword.'%')
                                  ->orWhere('description', 'like', '%'.$keyword.'%');
                        })
                        ->get();

           foreach ($ads_result as $key => $value) {
                $ads_images = AdImages::where('ad_id', $value->id)->get();     
                $data['ads'][$key] = $value;
                
                // $locations = array();
                // $ad_locations = AdLocations::where('ad_id', $value->id)->get();
                // foreach($ad_locations as $ad_location){
                //     $loc = location::where('id', $ad_location->location)->first();
                //     if($loc == ''){
                //         $locations[] = '';
                //     }else{
                //         $locations[] = $loc->market_name;
                //     }
                // }
                // $data['ads'][$key]['location'] = $locations;
                //$data['ads'][$key]['state_name'] = States::where('id', $value->state)->first()->state_name;
                
                $imgs = [];
                foreach ($ads_images as $ad_iamge) {
                    array_push($imgs, $ad_iamge->image);
                }
                $data['ads'][$key]['images'] = $imgs;

                $cats = Category::where('id', $value->category_id)->first();
                if($cats->parent_category == 0){
                    $data['ads'][$key]['cat_id'] = $cats->id;
                    $data['ads'][$key]['category_name'] = $cats->name;
                    $data['ads'][$key]['sub_category_id'] = '';
                    $data['ads'][$key]['sub_category_name'] = '';
                }else{
                    $p_cats = Category::where('id', $cats->parent_category)->first();
                    $data['ads'][$key]['cat_id'] = $p_cats->id;
                    $data['ads'][$key]['category_name'] = $p_cats->name;
                    $data['ads'][$key]['sub_category_id'] = $cats->id;
                    $data['ads'][$key]['sub_category_name'] = $cats->name;
                }

            }
            return json_encode($data);
        }
        else if($category_id == '' && $keyword != ''){
            $data['ads'] = [];
            //$ads_result = Ads::whereIn('category_id', $ids_arr)->get();
            $ads_result = Ads::where('status', 1)->where('title', 'like', '%'.$keyword.'%')->orWhere('description', 'like', '%'.$keyword.'%')->get();
            
            
            foreach ($ads_result as $key => $value) {
                $ads_images = AdImages::where('ad_id', $value->id)->get();     
                $data['ads'][$key] = $value;
                $imgs = [];
                foreach ($ads_images as $ad_iamge) {
                    array_push($imgs, $ad_iamge->image);
                }
                $data['ads'][$key]['images'] = $imgs;
                
               // $data['ads'][$key]['state_name'] = States::where('id', $value->state)->first()->state_name;
                
                // $locations = array();
                // $ad_locations = AdLocations::where('ad_id', $value->id)->get();
                // foreach($ad_locations as $ad_location){
                //     $loc = location::where('id', $ad_location->location)->first();
                //     if($loc == ''){
                //         $locations[] = '';
                //     }else{
                //         $locations[] = $loc->market_name;
                //     }
                // }
                // $data['ads'][$key]['location'] = $locations;

                $cats = Category::where('id', $value->category_id)->first();
                if($cats->parent_category == 0){
                    $data['ads'][$key]['cat_id'] = $cats->id;
                    $data['ads'][$key]['category_name'] = $cats->name;
                    $data['ads'][$key]['sub_category_id'] = '';
                    $data['ads'][$key]['sub_category_name'] = '';
                }else{
                    $p_cats = Category::where('id', $cats->parent_category)->first();
                    $data['ads'][$key]['cat_id'] = $p_cats->id;
                    $data['ads'][$key]['category_name'] = $p_cats->name;
                    $data['ads'][$key]['sub_category_id'] = $cats->id;
                    $data['ads'][$key]['sub_category_name'] = $cats->name;
                }

            }
            return json_encode($data);
        }else{
            return 0;
        }

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

    public function receiveAlertUser(Request $r){
        $data = array();
        $category = $r->category;
        $locality = $r->locality;
        $email = $r->email;
        $mobile = $r->mobile;

        $category_validator = Validator::make($r->all(), [
            'category' => 'required'
        ]);

        $locality_validator = Validator::make($r->all(), [
            'locality' => 'required'
        ]);

        $email_validator = Validator::make($r->all(), [
            'email' => 'required|email'
        ]);

        $phone_validator = Validator::make($r->all(), [
            'mobile' => 'required|min:10|max:10'
        ]);

        if ($category_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'category';
            $data['message'] = 'Please Select Category!';
            return json_encode($data);
        }

        if ($locality_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'locality';
            $data['message'] = 'Please Select Locality!';
            return json_encode($data);
        }

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

        $insertAlerts = new ReceiveAlertUsers();
        $insertAlerts->category = $category;
        $insertAlerts->locality = $locality;
        $insertAlerts->email = $email;
        $insertAlerts->mobile = $mobile;
        $insertAlerts->save();

        $emaildata = array();

        $user = new \stdClass();
        $user->email = $email;

        Mail::send('emails.subscribe',$emaildata, function ($message)  use ($user){
            $message->to($user->email);
            $message->subject('Welcome to V-Mandi');
        });

        $data['status'] = 1;
        $data['message'] = 'Successfully Subscribed.';
        return json_encode($data);
    }

    public function searchAds(Request $r) {
        // location based search logic is to done
        $data = [];
        $category_id = $r->category;
        $ad_data = [];
        if($category_id != null) {
            $ad_data = Ads::where('status', 1)->where('category_id', $category_id)->get();            ;
        }
        
        if(count($ad_data) == 0){
            $data['status'] = 0;
            $data['message'] = 'No Ads Found.';
        }else{
            $data['status'] = 1;
            $i = 0;
            foreach($ad_data as $ad){
                $category = Category::where('id', $ad->category_id)->get();
                //$unit = AdUnits::where('id', $ad->unit)->first();
                // $locations = array();
                // $ad_locations = AdLocations::where('ad_id', $ad->id)->get();
                // foreach($ad_locations as $ad_location){
                //     $loc = location::where('id', $ad_location->location)->first();
                //     if($loc == ''){
                //         $locations[] = '';
                //     }else{
                //         $locations[] = $loc->market_name;
                //     }
                // }
               // echo "<pre>";print_r($category);exit;
                $data[$i]['id'] = $ad->id;
                $data[$i]['category'] = $category[0]->name;
                $data[$i]['title'] = $ad->title;
                $data[$i]['description'] = $ad->description;
                $data[$i]['price'] = $ad->price;
                //$data[$i]['unit'] = $unit->name;
                $data[$i]['unit'] = $ad->unit;
                //$data[$i]['locations'] = $locations;
                $data[$i]['address'] = $ad->address;
                $data[$i]['city'] = $ad->city;
                $data[$i]['pincode'] = $ad->pincode;
                $data[$i]['state'] = $ad->state;
                //$data[$i]['state_name'] = States::where('id', $ad->state)->first()->state_name;
                
                $images = AdImages::where('ad_id', $ad->id)->get();
                $j = 0;
                foreach($images as $img){
                    $data[$i]['images'][$j] = $img->image;
                    $j++;
                }
                $i++;
            }
        }
        return json_encode($data);
    }
    
    public function getAdvertisement($page = 'home') {
        $dimensions_result    = DB::table('ad_dimensions')->where('position_name', 'like', '%' . $page . '%')->get(['dimension']);

        $dimensions = [];
        foreach ($dimensions_result as $value) {
            array_push($dimensions, $value->dimension);
        }
        
        $today     = date('Y-m-d');
        

        $advertisements = DB::table('advertisements')
        ->select('advertisements.image', 'advertisements.url', 'ad_dimensions.dimension')
        ->join('ad_dimensions','ad_dimensions.id','=','advertisements.dimension')
        ->where('advertisements.start_date', '<=', $today)->where('advertisements.end_date', '>=', $today)->where('status', 1)->whereIn('ad_dimensions.dimension', $dimensions)->inRandomOrder()->limit(3)->get();
        

        
          return  $advertisements;

        // $advertisement_data = Advertisement::get();

        // if(count($advertisement_data) == 0){
        //     $data['status'] = 0;
        //     $data['message'] = 'No Advertisement Found.';
        // }else{
        //     $data['status'] = 1;
        //     $i = 0;
        //     foreach($advertisement_data as $ad){
        //         $data[$i]['id'] = $ad->id;
        //         $data[$i]['title'] = $ad->title;
        //         $data[$i]['image'] = $ad->image;
        //         $data[$i]['link'] = $ad->link;
        //         $i++;
        //     }
        // }
        // return json_encode($data);
    }
    
    public function getAdvertisementApp(){
        $data = array();

        $advertisement_data = Advertisement::get();

        if(count($advertisement_data) == 0){
            $data['status'] = 0;
            $data['message'] = 'No Advertisement Found.';
        }else{
            $data['status'] = 1;
            $i = 0;
            foreach($advertisement_data as $ad){
                $data['advertisement'][$i]['id'] = $ad->id;
                $data['advertisement'][$i]['title'] = $ad->title;
                $data['advertisement'][$i]['image'] = $ad->image;
                $data['advertisement'][$i]['link'] = $ad->link;
                $i++;
            }
        }
        return json_encode($data);
    }
    
    public function getCMS(){
        $data = array();
        $cms_data = CmsTitle::get();
        //echo "<pre>";print_r($cms_data);exit;
        foreach($cms_data as $cms){
            $content = CMS::where('title', $cms->id)->get();
            if(count($content) == 0){
                $data[$cms->title_key] = '';
            }else{
                $data[$cms->title_key] = $content[0]->content;
            }
        }
        return json_encode($data);
    }

    public function updateUserProfile(Request $r){

        $data = array();
        $name = $r->name;
        $email = $r->email;
        $phone = $r->mobile;
        $user_id = $r->user_id;
        $user_type = $r->user_type;

        $name_validator = Validator::make($r->all(), [
            'name' => 'required|regex:/^[\pL\s\-]+$/u|min:2'
        ]);

        $email_validator = Validator::make($r->all(), [
            'email' => 'required|email'
        ]);

        $phone_validator = Validator::make($r->all(), [
            'mobile' => 'required|min:10|max:10'
        ]);

        if ($name_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'name';
            $data['message'] = 'Invalid Name Type!';
            return json_encode($data);
        }

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
        //echo $phone;exit;
        if($user_type == 1){
            $exist_data = vendor::where('email', $email)->where('id', '!=', $user_id)->get();
            if(count($exist_data) == 0){
                $exist_phone_data = vendor::where('phone', $phone)->where('id', '!=', $user_id)->get();
                if(count($exist_phone_data) == 0){

                    vendor::where('id', $user_id)->update(['name' => $name, 'email' => $email, 'phone' => $phone, 'updated_at' => date("Y-m-d H:i:s")]);
                    
                    $data['status'] = 1;
                    $data['name'] = $name;
                    $data['email'] = $email;
                    $data['phone'] = $phone;
                    $data['message'] = 'Updated Successfully.';
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
        else{
            $exist_data = Customer::where('email', $email)->where('id', '!=', $user_id)->get();
            if(count($exist_data) == 0){
                $exist_phone_data = Customer::where('phone', $phone)->where('id', '!=', $user_id)->get();
                if(count($exist_phone_data) == 0){

                    Customer::where('id', $user_id)->update(['name' => $name, 'email' => $email, 'phone' => $phone, 'updated_on' => date("Y-m-d H:i:s")]);
    
                    $data['status'] = 1;
                    $data['name'] = $name;
                    $data['email'] = $email;
                    $data['phone'] = $phone;
                    $data['message'] = 'Updated Successfully.';
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

    public function updateUserAddress(Request $r){

        $data = array();
        $address = $r->address;
        $city = $r->city;
        $pincode = $r->pincode;
        //$house = $r->house;
        $user_id = $r->user_id;
        $user_type = $r->user_type;

        $validator = Validator::make($r->all(), [
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required|min:6|max:6',
            //'house' => 'required',
        ]);

        if ($validator->fails()) {

            $failedRules = $validator->failed();

            if(isset($failedRules['address'])) {
                $data['status'] = 0;
                $data['address'] = 'Address is required!';                
            }

            if(isset($failedRules['city'])) {
                $data['status'] = 0;
                $data['city'] = 'City is required!';                
            }

            if(isset($failedRules['house'])) {
                $data['status'] = 0;
                $data['house'] = 'City is required!';                
            }

            if(isset($failedRules['pincode']['Required'])) {
                $data['status'] = 0;
                $data['pincode_req'] = 'Pincode is required!';                
            }

            if(isset($failedRules['pincode']['Min'])) {
                $data['status'] = 0;
                $data['pincode_min'] = 'Pincode should have minimum 6 digits!';                
            }

            if(isset($failedRules['pincode']['Max'])) {
                $data['status'] = 0;
                $data['pincode_max'] = 'Pincode should have maximum 6 digits!';                
            }

            return json_encode($data);
        }

        if($user_type == 1){
            vendor::where('id', $user_id)->update(['address' => $address, 'city' => $city, 'pincode' => $pincode, 'updated_at' => date("Y-m-d H:i:s")]);
                    
            $data['status'] = 1;
            $data['address'] = $address;
            $data['city'] = $city;
            //$data['house'] = $house;
            $data['pincode'] = $pincode;
            $data['message'] = 'Updated Successfully.';
        }
        else{
            Customer::where('id', $user_id)->update(['address' => $address, 'city' => $city, 'pincode' => $pincode, 'updated_on' => date("Y-m-d H:i:s")]);
    
            $data['status'] = 1;
            $data['address'] = $address;
            $data['city'] = $city;
            //$data['house'] = $house;
            $data['pincode'] = $pincode;
            $data['message'] = 'Updated Successfully.';
        }

        return json_encode($data);

    }

    public function getUserDetails(Request $r){
        $user_id = $r->user_id;
        $user_type = $r->user_type;

        if($user_type == 1){
            $user_data = vendor::where('id', $user_id)->first();
            
            if($user_data == ''){
                $data['status'] = 0;
                $data['status'] = 'User not found!';
            }else{
                $data['status'] = 1;
                $data['name'] = $user_data->name;
                $data['email'] = $user_data->email;
                $data['phone'] = $user_data->phone;
                $data['address'] = $user_data->address;
                $data['city'] = $user_data->city;
                $data['pincode'] = $user_data->pincode;
               // $data['house'] = $user_data->house;
            }
        }else{
            $user_data = Customer::where('id', $user_id)->first();
            if($user_data == ''){
                $data['status'] = 0;
                $data['status'] = 'User not found!';
            }else{
                $data['status'] = 1;
                $data['name'] = $user_data->name;
                $data['email'] = $user_data->email;
                $data['phone'] = $user_data->phone;
                $data['address'] = $user_data->address;
                $data['city'] = $user_data->city;
                $data['pincode'] = $user_data->pincode;
               // $data['house'] = $user_data->house;
            }
        }

        return json_encode($data);
    }

    public function changePassword(Request $r){
        $data = array();
        $old_pwd = $r->old_pwd;
        $new_pwd = $r->new_pwd;
        $confirm_pwd = $r->confirm_pwd;
        $user_id = $r->user_id;
        $user_type = $r->user_type;

        $validator = Validator::make($r->all(), [
            'old_pwd' => 'required',
            'new_pwd' => 'required',
            'confirm_pwd' => 'required'
        ]);

        if ($validator->fails()) {

            $failedRules = $validator->failed();

            if(isset($failedRules['old_pwd'])) {
                $data['status'] = 0;
                $data['old_pwd'] = 'Old Password is required!';                
            }

            if(isset($failedRules['new_pwd'])) {
                $data['status'] = 0;
                $data['new_pwd'] = 'New Password is required!';                
            }

            if(isset($failedRules['confirm_pwd'])) {
                $data['status'] = 0;
                $data['confirm_pwd'] = 'Confirm Password is required!';                
            }

            return json_encode($data);
        }

        if($user_type == 1){
            $user_data = vendor::where('id', $user_id)->where('password', $old_pwd)->first();
            if($user_data == ''){
                $data['status'] = 0;
                $data['old_pwd'] = 'Invalid Old Password!';
            }else{
                if($new_pwd == $confirm_pwd){
                    vendor::where('id', $user_id)->update(['password' => $new_pwd]);
                    $data['status'] = 1;
                    $data['message'] = 'Your Password Updated Successfully.';
                }else{
                    $data['status'] = 0;
                    $data['confirm_pwd'] = 'New Password and Confirm Password should be same!';
                }
            }
        }else{
            $user_data = Customer::where('id', $user_id)->where('password', $old_pwd)->first();
            if($user_data == ''){
                $data['status'] = 0;
                $data['old_pwd'] = 'Invalid Old Password!';
            }else{
                if($new_pwd == $confirm_pwd){
                    Customer::where('id', $user_id)->update(['password' => $new_pwd]);
                    $data['status'] = 1;
                    $data['message'] = 'Your Password Updated Successfully.';
                }else{
                    $data['status'] = 0;
                    $data['confirm_pwd'] = 'New Password and Confirm Password should be same!';
                }
            }
        }

        return json_encode($data);
    }

    public function getDashboard(Request $r){
        $data = array();
        $user_id = $r->user_id;
        $user_type = $r->user_type;

        $validator = Validator::make($r->all(), [
            'user_id' => 'required',
            'user_type' => 'required'
        ]);

        if ($validator->fails()) {

            $failedRules = $validator->failed();

            if(isset($failedRules['user_id'])) {
                $data['status'] = 0;
                $data['user_id'] = 'User id is required!';                
            }

            if(isset($failedRules['user_type'])) {
                $data['status'] = 0;
                $data['user_type'] = 'User type is required!';                
            }

            return json_encode($data);
        }

        $endDate = date("Y-m-d",strtotime($r->endDate."-2 day"));

        if($user_type == 1){
            $total_ad_posted = Ads::where('user_id', $user_id)->get()->count();
        }else{
            $total_ad_posted = '';
        }

        if($user_type == 1){
            $latest_ad_posted = Ads::where('user_id', $user_id)->where('added_on', '>=', $endDate.' 00:00:00')->get()->count();
        }else{
            $latest_ad_posted = '';
        }

        if($user_type == 1){
            $total_posted_ads = Ads::where('user_id', $user_id)->get();
            $messages_count = 0;
            foreach($total_posted_ads as $ad_posted){
                $total_ad_messages = AdEnquiry::where('ad_id', $ad_posted->id)->get()->count();
                $messages_count = $messages_count+$total_ad_messages;
            }
            
        }else{
            $messages_count = Ads::where('user_id', $user_id)->get()->count();
        }

        $user_ad_enquiries = DB::table('ads')
                            ->leftJoin('ad_enquiry', 'ads.id', '=', 'ad_enquiry.ad_id')
                            ->where('ads.user_id', $user_id)
                            ->orderBy('ad_enquiry.id', 'desc')
                            ->select('ad_enquiry.id as aden_id', 'ad_enquiry.ad_id as aden_ad_id', 'ad_enquiry.user_id as aden_user_id', 'ad_enquiry.user_type as aden_user_type', 'ad_enquiry.message as aden_message', 'ad_enquiry.created_at as aden_created_at')
                            ->get();
        //echo "<pre>";print_r($user_ad_enquiries);exit;
        $messages = array();
        $i = 0;
        foreach($user_ad_enquiries as $user_ad_enquiry){
            if(!empty($user_ad_enquiry->aden_id)){
                if($user_ad_enquiry->aden_user_type == 1){
                    $user_name = vendor::where('id', $user_ad_enquiry->aden_user_id)->first();
                }else{
                    $user_name = Customer::where('id', $user_ad_enquiry->aden_user_id)->first();
                }
                
                $ad_title = Ads::where('id', $user_ad_enquiry->aden_ad_id)->first();

                $messages[$i]['id'] = $user_ad_enquiry->aden_id;
                $messages[$i]['ad_id'] = $user_ad_enquiry->aden_ad_id;
                $messages[$i]['ad_title'] = $ad_title->title;
                $messages[$i]['post_user_id'] = $user_ad_enquiry->aden_user_id;
                $messages[$i]['user_name'] = $user_name->name;
                $messages[$i]['user_type'] = $user_ad_enquiry->aden_user_type;
                $messages[$i]['message'] = $user_ad_enquiry->aden_message;
                $messages[$i]['time'] = date("H:i", strtotime($user_ad_enquiry->aden_created_at));
                if($i == 2){
                    break;
                }
                $i++;
            }
        }

        $user_trending_ads = Ads::where('user_id', $user_id)->orderBy('views', 'desc')->get();
        $j = 0;
        $trending_ads = array();
        foreach($user_trending_ads as $user_trending_ad){
            $trending_ads[$j]['ad_id'] = $user_trending_ad->id;
            $trending_ads[$j]['title'] = $user_trending_ad->title;
            $trending_ads[$j]['views'] = $user_trending_ad->views;
            $trending_ads[$j]['request'] = AdEnquiry::where('ad_id', $user_trending_ad->id)->get()->count();
            if($j == 3){
                break;
            }
            $j++;
        }

        $data['total_ad_posted'] = $total_ad_posted;
        $data['latest_ad_posted'] = $latest_ad_posted;
        $data['messages_count'] = $messages_count;
        $data['messages'] = $messages;
        $data['trending_ads'] = $trending_ads;

        return json_encode($data);
    }

    public function getAdDetail($ad_id){
        $data = array();

        Ads::where('id', $ad_id)->increment('views');
        $ad_data = Ads::where('id', $ad_id)->first();
        $ad_images = AdImages::where('ad_id', $ad_id)->get();
        //$unit = AdUnits::where('id', $ad_data->unit)->first();
        // $locations = array();
        // $ad_locations = AdLocations::where('ad_id', $ad_data->id)->get();
        // foreach($ad_locations as $ad_location){
        //     $loc = location::where('id', $ad_location->location)->first();
        //     if($loc == ''){
        //         $locations[] = '';
        //     }else{
        //         $locations[] = $loc->market_name;
        //     }
        // }

        $data['id'] = $ad_data->id;
        $data['title'] = $ad_data->title;
        $data['description'] = $ad_data->description;
        $data['price'] = $ad_data->price;
        $data['unit'] = $ad_data->unit;
        //$data['unit'] = $unit->name;
        $data['brand_name'] = $ad_data->brand_name;
        $data['breed_name'] = $ad_data->breed_name;
        //$data['locations'] = $locations;
        $data['address'] = $ad_data->address;
        $data['city'] = $ad_data->city;
        $data['pincode'] = $ad_data->pincode;
        $data['state'] = $ad_data->state;
        //$data['state_name'] = States::where('id', $ad_data->state)->first()->state_name;
        $data['views'] = $ad_data->views;
        $data['added_on'] = date("d M, Y H:i", strtotime($ad_data->added_on));

        $imgs = [];
        foreach ($ad_images as $ad_iamge) {
            array_push($imgs, $ad_iamge->image);
        }
        $data['images'] = $imgs;

        $user_detail = vendor::where('id', $ad_data->user_id)->first();
        $data['user']['id'] = $user_detail->id;
        $data['user']['name'] = $user_detail->name;
        $data['user']['email'] = $user_detail->email;
        $data['user']['phone'] = $user_detail->phone;

        $category_detail = Category::where('id', $ad_data->category_id)->first();
        $parent_category = Category::where('id', $category_detail->parent_category)->first();
        $data['category']['cat_id'] = $parent_category->id;
        $data['category']['cat_name'] = $parent_category->name;
        $data['category']['sub_cat_id'] = $category_detail->id;
        $data['category']['sub_cat_name'] = $category_detail->name;

        return json_encode($data);
    }

    public function getVendorAdDetail($ad_id = ''){
        $data = array();

        if($ad_id == ''){
            return json_encode($data);
        }

        //Ads::where('id', $ad_id)->increment('views');
        $ad_data = Ads::where('id', $ad_id)->first();
        $ad_images = AdImages::where('ad_id', $ad_id)->get();

        if($ad_data == ''){
            return json_encode($data);
        }
        
        //$unit = AdUnits::where('id', $ad_data->unit)->first();
        // $locations = array();
        // $ad_locations = AdLocations::where('ad_id', $ad_data->id)->get();
        // $lo = 0;
        // foreach($ad_locations as $ad_location){
        //     $loc = location::where('id', $ad_location->location)->first();
        //     if($loc == ''){
        //         $locations[$lo]['id'] = '';
        //         //$locations[$lo]['market_name'] = '';
        //         $locations[$lo]['market'] = '';
        //     }else{
        //         $locations[$lo]['id'] = $loc->id;
        //         //$locations[$lo]['market_name'] = $loc->market_name;
        //         $locations[$lo]['market'] = $loc->market_name.' ('.$loc->address.')';
        //     }
        //     $lo++;
        // }

        $data['id'] = $ad_data->id;
        $data['title'] = $ad_data->title;
        $data['description'] = $ad_data->description;
        $data['price'] = $ad_data->price;
        $data['brand_name'] = $ad_data->brand_name;
        $data['breed_name'] = $ad_data->breed_name;
        $data['price'] = $ad_data->price;
        //$data['unit_id'] = $unit->id;
        $data['unit'] = $ad_data->unit;
        //$data['unit'] = $ad_data->name;
        // $data['locations'] = $locations;
        $data['address'] = $ad_data->address;
        $data['city'] = $ad_data->city;
        $data['pincode'] = $ad_data->pincode;
        $data['state'] = $ad_data->state;
        //$data['state_name'] = States::where('id', $ad_data->state)->first()->state_name;
        
        $data['views'] = $ad_data->views;
        $data['added_on'] = date("d M, Y H:i", strtotime($ad_data->added_on));

        // $imgs = [];
        // foreach ($ad_images as $ad_iamge) {
        //     array_push($imgs, $ad_iamge->image);
        // }
        // $data['images'] = $imgs;
        
        $imgs = [];
        $i_count = 0;
        foreach ($ad_images as $ad_iamge) {
            $imgs[$i_count]['img_id'] = $ad_iamge->id;
            $imgs[$i_count]['image'] = $ad_iamge->image;
            $i_count++;
        }
        $data['images'] = $imgs;

        $user_detail = vendor::where('id', $ad_data->user_id)->first();
        $data['user']['id'] = $user_detail->id;
        $data['user']['name'] = $user_detail->name;
        $data['user']['email'] = $user_detail->email;
        $data['user']['phone'] = $user_detail->phone;

        $category_detail = Category::where('id', $ad_data->category_id)->first();
        $parent_category = Category::where('id', $category_detail->parent_category)->first();
        $data['category']['cat_id'] = $parent_category->id;
        $data['category']['cat_name'] = $parent_category->name;
        $data['category']['sub_cat_id'] = $category_detail->id;
        $data['category']['sub_cat_name'] = $category_detail->name;

        $ad_enquiries = AdEnquiry::where('ad_id', $ad_id)->get();
        $e = 0;
        foreach($ad_enquiries as $ad_enquiry){
            if($ad_enquiry->user_type == 1){
                $user_detail = vendor::where('id', $ad_enquiry->user_id)->first();
            }else{
                $user_detail = Customer::where('id', $ad_enquiry->user_id)->first();
            }
            $data['ad_post'][$e]['message'] = $ad_enquiry->message;
            $data['ad_post'][$e]['time'] = $ad_enquiry->created_at;
            $data['ad_post'][$e]['customer_name'] = $user_detail->name;
            $data['ad_post'][$e]['customer_email'] = $user_detail->email;
            $data['ad_post'][$e]['customer_phone'] = $user_detail->phone;
            $e++;
        }

        return json_encode($data);
    }

    public function sendEnquiry(Request $r){
        $data = array();
        $user_id = $r->user_id;
        $user_type = $r->user_type;
        $ad_id = $r->ad_id;
        $message = $r->message;
        $vendor_email = $r->vendor_email;
        $vendor_name = $r->vendor_name;

        $validator = Validator::make($r->all(), [
            'user_id' => 'required',
            'user_type' => 'required',
            'ad_id' => 'required',
            'message' => 'required',
            'vendor_email' => 'required',
            'vendor_name' => 'required',
        ]);

        if ($validator->fails()) {

            $failedRules = $validator->failed();

            if(isset($failedRules['user_id'])) {
                $data['status'] = 0;
                $data['user_id'] = 'User id is required!';                
            }

            if(isset($failedRules['user_type'])) {
                $data['status'] = 0;
                $data['user_type'] = 'User type is required!';                
            }

            if(isset($failedRules['ad_id'])) {
                $data['status'] = 0;
                $data['ad_id'] = 'Ad id is required!';                
            }

            if(isset($failedRules['message'])) {
                $data['status'] = 0;
                $data['message'] = 'Message is required!';                
            }

            if(isset($failedRules['vendor_email'])) {
                $data['status'] = 0;
                $data['vendor_email'] = 'Vendor email is required!';                
            }

            if(isset($failedRules['vendor_name'])) {
                $data['status'] = 0;
                $data['vendor_name'] = 'Vendor name is required!';                
            }

            return json_encode($data);
        }

        $insertAdEnquiry = new AdEnquiry();
        $insertAdEnquiry->ad_id = $ad_id;
        $insertAdEnquiry->user_id = $user_id;
        $insertAdEnquiry->user_type = $user_type;
        $insertAdEnquiry->message = $message;
        $insertAdEnquiry->created_at = date('Y-m-d H:i:s');
        $insertAdEnquiry->save();

        if($user_type == 1){
            $user_data = vendor::where('id', $user_id)->first();
        }else{
            $user_data = Customer::where('id', $user_id)->first();
        }

        $ad_data = Ads::where('id', $ad_id)->first();

        $category_detail = Category::where('id', $ad_data->category_id)->first();
        $parent_category = Category::where('id', $category_detail->parent_category)->first();

        $emaildata['name'] = $user_data->name;
        $emaildata['email'] = $user_data->email;
        $emaildata['phone'] = $user_data->phone;
        $emaildata['ad_message'] = $message;
        $emaildata['ad_title'] = $ad_data->title;
        if(!empty($parent_category)){
            $emaildata['cat_name'] = $parent_category->name;
            $emaildata['sub_cat_name'] = $category_detail->name;
        }else{
            $emaildata['cat_name'] = $category_detail->name;
            $emaildata['sub_cat_name'] = '';
        }
        $emaildata['vendor_name'] = $vendor_name;

        $user = new \stdClass();
        $user->email = $vendor_email;
        $user->ad_title = $ad_data->title;

        Mail::send('emails.sendEnquiryToVendor',$emaildata, function ($message)  use ($user){
            $message->to($user->email);
            $message->subject('Request for '.$user->ad_title.' - VMandi');
        });

        $data['status'] = 1;
        $data['message'] = 'Enquiry Send Successfully.';
        
        return json_encode($data);
    }
    
    public function deleteAdImage(Request $r){
        $data = array();
        $img_id = $r->img_id;
        
        $validator = Validator::make($r->all(), [
            'img_id' => 'required'
        ]);

        if ($validator->fails()) {

            $failedRules = $validator->failed();

            if(isset($failedRules['img_id'])) {
                $data['status'] = 0;
                $data['img_id'] = 'Image id is required!';                
            }
            
            return json_encode($data);
        }
        
        $all_ad_images = AdImages::where('id', $img_id)->get();

        foreach($all_ad_images as $all_ad_image){
            $img_name_arr = explode('/', $all_ad_image->image);
            $img_name = $img_name_arr[count($img_name_arr)-1];
            $destinationPath = public_path('image/ad_images/');
            $file_name = $destinationPath.'/'.$img_name;
            if (file_exists($file_name)) {
                unlink($file_name);
            }
            AdImages::where('id', $all_ad_image->id)->delete();
        }
        
        $data['success'] = 1;
        $data['message'] = 'Image deleted successfully.';
        
        return json_encode($data);
    }

    public function editAd(Request $r){
        $data = array();

        $ad_id = $r->ad_id;
        $app_or_web = $r->app_or_web;
        $ad_img_remove_id = $r->ad_img_remove_id; 
        if($r->sub_category_id == ''){
            $category_id = $r->category_id;
        }else{
            $category_id = $r->sub_category_id;
        }
        
        $title = $r->title;
        $description = $r->description;
        $price = $r->price;
        $unit = $r->unit;
        $brand_name = $r->brand_name;
        $breed_name = $r->breed_name;
        $address = $r->address;
        $city = $r->city;
        $state = $r->state;
        $pincode = $r->pincode;
       // $locations = json_decode($r->locations);
        //$added_on = date('Y-m-d H:i:s');
        //$valid_till = date('Y-m-d H:i:s', strtotime(0));
        //$status = 1;
        $files = $r->file();
        if (array_key_exists("app_or_web",$r->all())){
            $files = json_decode($r->file);
        }
        

        $validator = Validator::make($r->all(), [
            'ad_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'string|min:3|max:500',
            'unit' => 'required',
            'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required|min:6|max:6',
        ]);

        if ($validator->fails()) {

            $failedRules = $validator->failed();

            if(isset($failedRules['ad_id'])) {
                $data['status'] = 0;
                $data['ad_id'] = 'Ad id is required!';                
            }

            if(isset($failedRules['category_id'])) {
                $data['status'] = 0;
                $data['category_id'] = 'Category id is required!';                
            }

            if(isset($failedRules['title'])) {
                $data['status'] = 0;
                $data['title'] = 'Title is required!';                
            }

            if(isset($failedRules['description'])) {
                $data['status'] = 0;
                $data['description'] = 'Description must not exceed to 500 characters!';                
            }
            
            if(isset($failedRules['unit'])) {
                $data['status'] = 0;
                $data['unit'] = 'Please select unit!';                
            }
            
            if(isset($failedRules['price']['Required'])) {
                $data['status'] = 0;
                $data['price'] = 'Price is required!';                
            }
            
            if(isset($failedRules['price']['Regex'])) {
                $data['status'] = 0;
                $data['price'] = 'Invalid price!';                
            }
            
            if(isset($failedRules['address'])) {
                $data['status'] = 0;
                $data['address'] = 'Address is required!';                
            }
            
            if(isset($failedRules['city'])) {
                $data['status'] = 0;
                $data['city'] = 'City is required!';                
            }
            
            if(isset($failedRules['state'])) {
                $data['status'] = 0;
                $data['state'] = 'State is required!';                
            }
            
            if(isset($failedRules['pincode']['Required'])) {
                $data['status'] = 0;
                $data['pincode'] = 'Pincode is required!';                
            }
            
            if(isset($failedRules['pincode']['Min'])) {
                $data['status'] = 0;
                $data['pincode_min'] = 'Pincode should have minimum 6 digits!';                
            }

            if(isset($failedRules['pincode']['Max'])) {
                $data['status'] = 0;
                $data['pincode_max'] = 'Pincode should have maximum 6 digits!';                
            }
            
            return json_encode($data);
        }
        
        // if(count($locations) < 1){
        //     $data['status'] = 0;
        //     $data['err_key'] = 'locations';
        //     $data['message'] = 'Atleast one location is required!';
        //     return json_encode($data);
        // }
        
        // AdLocations::where('ad_id', $ad_id)->delete();
        // $l = 0;
        // foreach($locations as $k_l => $location){
        //     $insertLocation = new AdLocations();
        //     $insertLocation->ad_id = $ad_id;
        //     $insertLocation->location = $location;
        //     $insertLocation->save();
        //     $l++;
        // }

        
        //$data[0] = count($files);
        
        $check_ad_images = AdImages::where('ad_id', $ad_id)->get();
        $check_image_arr = array();
        foreach($check_ad_images as $check_ad_image){
            $check_image_arr[] = $check_ad_image->id;
        }
        sort($check_image_arr);
        
        if($ad_img_remove_id != ''){
            $ad_img_remove_id_arr = explode(',', $ad_img_remove_id);
            sort($ad_img_remove_id_arr);
        
            if ($check_image_arr==$ad_img_remove_id_arr){
                if(count($files) == 0){
                    $data['status'] = 0;
                    $data['file'] = 'Image is required!';
                    return json_encode($data);
                }
            }
            
        }
        
        // if(count($files) == 0){
        //     $data['status'] = 0;
        //     $data['file'] = 'Image is required!';
        //     return json_encode($data);
        // }else{ 
        if (array_key_exists("app_or_web",$r->all())){
                //$files = $r->file;
        }else{
            $img_ext_arr = ["jpg", "jpeg", "png"];
            foreach($files as $file){
                $image_ext = strtolower($file->getClientOriginalExtension());
                if (!in_array($image_ext, $img_ext_arr)){
                    $data['status'] = 0;
                    $data['err_key'] = 'file';
                    $data['message'] = 'Invalid File Type!';
                    return json_encode($data);
                }
            }
        }
        // }
        
        $insertAd = Ads::where('id', $ad_id)->first();
        $insertAd->category_id = $category_id;
        $insertAd->title = $title;
        $insertAd->description = $description;
        $insertAd->brand_name = $brand_name;
        $insertAd->breed_name = $breed_name;
        $insertAd->price = $price;
        $insertAd->address = $address;
        $insertAd->city = $city;
        $insertAd->pincode = $pincode;
        $insertAd->state = $state;
        $insertAd->save();
        
        if($ad_img_remove_id != ''){
            $ad_img_remove_id_arr = explode(',', $ad_img_remove_id);

            $all_ad_images = AdImages::whereIn('id', $ad_img_remove_id_arr)->get();

            foreach($all_ad_images as $all_ad_image){
                $img_name_arr = explode('/', $all_ad_image->image);
                $img_name = $img_name_arr[count($img_name_arr)-1];
                $destinationPath = public_path('image/ad_images/');
                $file_name = $destinationPath.'/'.$img_name;
                if (file_exists($file_name)) {
                    unlink($file_name);
                }
                AdImages::where('id', $all_ad_image->id)->delete();
            }
        }

        $i = 0;
        if (array_key_exists("app_or_web",$r->all())){
            AdImages::where('ad_id', $ad_id)->delete();
            foreach($files as $app_img){
                $image = str_replace('data:image/png;base64,', '', $app_img);
                $image = str_replace(' ', '+', $image);
                $input_img = base64_decode($image);
                $file = public_path('image/ad_images/') . $ad_id.'_'.time().'_'.$i. '.jpg';
                $image_url = url('public/image/ad_images/'.$ad_id.'_'.time().'_'.$i. '.jpg');
                $success = file_put_contents($file, $input_img);
                
                $insertAdImage = new AdImages();
                $insertAdImage->ad_id = $ad_id;
                $insertAdImage->image = $image_url;
                $insertAdImage->save();
                $i++;
            }
        }else{
            foreach($files as $file){
             
                $image = $file;
                $image_name = $ad_id.'_'.time().'_'.$i.'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('image/ad_images/');
                $image_url = url('public/image/ad_images/'.$image_name);
                $image->move($destinationPath, $image_name);
    
                $insertAdImage = new AdImages();
                $insertAdImage->ad_id = $ad_id;
                $insertAdImage->image = $image_url;
                $insertAdImage->save();
                $i++;
            }
        }

        $data['status'] = 1;
        $data['ad_id'] = $ad_id;
        $data['message'] = 'Ad Updated Successfully.';

        return json_encode($data);
    }

    public function deleteVendorAd(Request $r){
        $data = array();
        $ad_id = $r->ad_id;

        $validator = Validator::make($r->all(), [
            'ad_id' => 'required'
        ]);

        if ($validator->fails()) {

            $failedRules = $validator->failed();

            if(isset($failedRules['ad_id'])) {
                $data['status'] = 0;
                $data['ad_id'] = 'Ad id is required!';                
            }

            return json_encode($data);
        }

        $ads = Ads::find($ad_id);
        $ads->ad_images()->delete();
        $ads->ad_enquiry()->delete();
        $ads->ad_loctaion()->delete();
        $ads->delete();

        $data['status'] = 1;
        $data['message'] = 'Ad Deleted Successfully.';
        return json_encode($data);
    }
    
    public function getCustomerAd($customer_id, $user_type){
        $data = array();

        $adEnquiries = AdEnquiry::select('ad_id')->where('user_type', $user_type)->where('user_id', $customer_id)->groupBy('ad_id')->get();
        $ad_ids = array();
        foreach($adEnquiries as $adEnquiry){
            $ad_ids[] = $adEnquiry->ad_id;
        }

        $ad_data = Ads::whereIn('id', $ad_ids)->orderBy('id', 'desc')->get();
        
        if(count($ad_data) == 0){
            $data['status'] = 0;
            $data['message'] = 'No Ads Found.';
        }else{
            $data['status'] = 1;
            $i = 0;
            foreach($ad_data as $ad){
                $category = Category::where('id', $ad->category_id)->get();
                //$unit = AdUnits::where('id', $ad->unit)->first();
                // $locations = array();
                // $ad_locations = AdLocations::where('ad_id', $ad->id)->get();
                // foreach($ad_locations as $ad_location){
                //     $loc = location::where('id', $ad_location->location)->first();
                //     if($loc == ''){
                //         $locations[] = '';
                //     }else{
                //         $locations[] = $loc->market_name;
                //     }
                // }
               // echo "<pre>";print_r($category);exit;
                $data['ad'][$i]['id'] = $ad->id;
                $data['ad'][$i]['category'] = $category[0]->name;
                $data['ad'][$i]['title'] = $ad->title;
                $data['ad'][$i]['description'] = $ad->description;
                
                $data['ad'][$i]['price'] = $ad->price;
                $data['ad'][$i]['unit'] = $ad->unit;
                //$data['ad'][$i]['locations'] = $locations;
                $data['ad'][$i]['brand_name'] = $ad->brand_name;
                $data['ad'][$i]['breed_name'] = $ad->breed_name;
                
                $data['ad'][$i]['address'] = $ad->address;
                $data['ad'][$i]['city'] = $ad->city;
                $data['ad'][$i]['pincode'] = $ad->pincode;
                $data['ad'][$i]['state'] = $ad->state;
                $data['ad'][$i]['status'] = $ad->status;
                //$data['ad'][$i]['state_name'] = States::where('id', $ad->state)->first();
                
                $images = AdImages::where('ad_id', $ad->id)->get();
                $j = 0;
                foreach($images as $img){
                    $data['ad'][$i]['images'][$j] = $img->image;
                    $j++;
                }
                $i++;
            }
        }
        return json_encode($data);
    }
    
    public function getCustomerAdDetail(Request $r){
        $data = array();
        $customer_id = $r->customer_id;
        $ad_id = $r->ad_id;
        $user_type = $r->user_type;

        $validator = Validator::make($r->all(), [
            'ad_id' => 'required',
            'customer_id' => 'required',
            'user_type' => 'required'
        ]);

        if ($validator->fails()) {

            $failedRules = $validator->failed();

            if(isset($failedRules['ad_id'])) {
                $data['status'] = 0;
                $data['ad_id'] = 'Ad id is required!';                
            }

            if(isset($failedRules['customer_id'])) {
                $data['status'] = 0;
                $data['customer_id'] = 'Customer id is required!';                
            }
            
            if(isset($failedRules['user_type'])) {
                $data['status'] = 0;
                $data['user_type'] = 'User type is required!';                
            }

            return json_encode($data);
        }

        //Ads::where('id', $ad_id)->increment('views');
        $ad_data = Ads::where('id', $ad_id)->first();
        $ad_images = AdImages::where('ad_id', $ad_id)->get();
        //$unit = AdUnits::where('id', $ad_data->unit)->first();

        if($ad_data == ''){
            return json_encode($data);
        }

        $data['ad']['id'] = $ad_data->id;
        $data['ad']['title'] = $ad_data->title;
        $data['ad']['description'] = $ad_data->description;
        $data['ad']['price'] = $ad_data->price;
        // $data['ad']['unit'] = $unit->name;
        $data['ad']['unit'] = $ad_data->unit;
        //$data['ad']['locations'] = $locations;
        $data['ad']['address'] = $ad_data->address;
        $data['ad']['city'] = $ad_data->city;
        $data['ad']['pincode'] = $ad_data->pincode;
        $data['ad']['state'] = $ad_data->state;
        //$data['ad']['state_name'] = States::where('id', $ad_data->state)->first()->state_name;
                
        $data['ad']['brand_name'] = $ad_data->brand_name;
        $data['ad']['breed_name'] = $ad_data->breed_name;
        $data['ad']['views'] = $ad_data->views;
        $data['ad']['added_on'] = date("d M, Y H:i", strtotime($ad_data->added_on));

        // $imgs = [];
        // foreach ($ad_images as $ad_iamge) {
        //     array_push($imgs, $ad_iamge->image);
        // }
        // $data['images'] = $imgs;
        
        $imgs = [];
        $i_count = 0;
        foreach ($ad_images as $ad_iamge) {
            $imgs[$i_count]['img_id'] = $ad_iamge->id;
            $imgs[$i_count]['image'] = $ad_iamge->image;
            $i_count++;
        }
        $data['ad']['images'] = $imgs;

        $user_detail = vendor::where('id', $ad_data->user_id)->first();
        $data['user']['id'] = $user_detail->id;
        $data['user']['name'] = $user_detail->name;
        $data['user']['email'] = $user_detail->email;
        $data['user']['phone'] = $user_detail->phone;

        $category_detail = Category::where('id', $ad_data->category_id)->first();
        $parent_category = Category::where('id', $category_detail->parent_category)->first();
        $data['category']['cat_id'] = $parent_category->id;
        $data['category']['cat_name'] = $parent_category->name;
        $data['category']['sub_cat_id'] = $category_detail->id;
        $data['category']['sub_cat_name'] = $category_detail->name;

        $ad_enquiries = AdEnquiry::where('ad_id', $ad_id)->where('user_id', $customer_id)->where('user_type', $user_type)->orderBy('id', 'desc')->get();
        
        if(count($ad_enquiries) > 0){
            $e = 0;
            foreach($ad_enquiries as $ad_enquiry){
                if($ad_enquiry->user_type == 1){
                    $user_detail = vendor::where('id', $ad_enquiry->user_id)->first();
                }else{
                    $user_detail = Customer::where('id', $ad_enquiry->user_id)->first();
                }
                $data['ad_post'][$e]['message'] = $ad_enquiry->message;
                $data['ad_post'][$e]['time'] = $ad_enquiry->created_at;
                $data['ad_post'][$e]['customer_name'] = $user_detail->name;
                $data['ad_post'][$e]['customer_email'] = $user_detail->email;
                $data['ad_post'][$e]['customer_phone'] = $user_detail->phone;
                $e++;
            }
        }else{
            $e = 0;
            $data['ad_post'][$e]['message'] = '';
            $data['ad_post'][$e]['time'] = '';
            $data['ad_post'][$e]['customer_name'] = '';
            $data['ad_post'][$e]['customer_email'] = '';
            $data['ad_post'][$e]['customer_phone'] = '';
        }

        return json_encode($data);
    }
    
    public function getAdUnit(){
        $data = array();
        $units = AdUnits::get()->toArray();
        $data['units'] = $units;
        
        return json_encode($data);
    }
    
    public function contactUs(Request $r){
        $data = array();
        $name = $r->name;
        $email = $r->email;
        $mobile_no = $r->mobile_no;
        $subject = $r->subject;
        $message = $r->message;

        $validator = Validator::make($r->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'mobile_no' => 'required|min:10|max:10',
            'message' => 'required'
        ]);

        if ($validator->fails()) {

            $failedRules = $validator->failed();

            if(isset($failedRules['name'])) {
                $data['status'] = 0;
                $data['name'] = 'Name is required!';                
            }

            if(isset($failedRules['email']['Required'])) {
                $data['status'] = 0;
                $data['email'] = 'Email id is required!';                
            }

            if(isset($failedRules['email']['Email'])) {
                $data['status'] = 0;
                $data['email'] = 'Invalid email id!';                
            }

            if(isset($failedRules['subject'])) {
                $data['status'] = 0;
                $data['subject'] = 'Subject is required!';                
            }

            if(isset($failedRules['mobile_no']['Min'])) {
                $data['status'] = 0;
                $data['mobile_no'] = 'Mobile number should have minimum 10 numbers!';                
            }

            if(isset($failedRules['mobile_no']['Max'])) {
                $data['status'] = 0;
                $data['mobile_no'] = 'Mobile number should have maximum 10 numbers!';                
            }

            if(isset($failedRules['mobile_no']['Required'])) {
                $data['status'] = 0;
                $data['mobile_no'] = 'Mobile number is required!';                
            }

            if(isset($failedRules['message'])) {
                $data['status'] = 0;
                $data['message'] = 'Message is required!';                
            }

            return json_encode($data);
        }

        $admin_email = User::first()->email;

        $emaildata['name'] = $name;
        $emaildata['email'] = $email;
        $emaildata['mobile_no'] = $mobile_no;
        $emaildata['subject'] = $subject;
        $emaildata['msg'] = $message;
        $emaildata['posted_on'] = date('Y-m-d H:i:s');
        
        ContactUs::insert($emaildata);
        
        $user = new \stdClass();
        $user->email = trim($admin_email);
        $user->subject = $subject;

        Mail::send('emails.contactUs',$emaildata, function ($message)  use ($user){
            $message->to($user->email);
            $message->subject($user->subject);
        });

        $data['status'] = 1;
        $data['status'] = 'Your message send successfully.';
        
        return json_encode($data);
    }

    public function changeAdStatus(Request $r){
        $data = array();
        $ad_id = $r->ad_id;
        
        $ad_id_validator = Validator::make($r->all(), [
            'ad_id' => 'required'
        ]);

        if ($ad_id_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'ad_id';
            $data['message'] = 'Ad id required!';
            return json_encode($data);
        }

        $ad_data = Ads::where('id', $ad_id)->first();
        if($ad_data->status == 1){
            Ads::where('id', $ad_id)->update(['status' => 0]);
        }else{
            Ads::where('id', $ad_id)->update(['status' => 1]);
        }

        $data['status'] = 1;
        $data['status'] = 'Ad status updated successfully.';
        
        return json_encode($data);
    }
    
    public function getTicker(){
        $ticker = Ticker::get();
        
        if(count($ticker) == 0){
            $data['status'] = 0;
            $data['message'] = 'No records found!';
        }else{
            $data['status'] = 1;
            
            for($i=0; $i<count($ticker); $i++){
                $data['ticker'][$i]['product_name'] = $ticker[$i]->product_name;
                $data['ticker'][$i]['product_price'] = $ticker[$i]->product_price;
            }
        }
        
        return json_encode($data);
    }
    
    public function saveReview(Request $r) {  
        $data      = []; 
        $user_id   = $r->user_id;
        $user_type = $r->user_type; 
        $review    = $r->review; 
        $rating    = $r->rating;       
        //return $review;

        $review_validator = Validator::make($r->all(), [
            'review' => 'required'
        ]);        

        if ($review_validator->fails()) {
            $data['status'] = 0;
            $data['err_key'] = 'review';
            $data['message'] = 'Please type some text.';
            return $data;
        }  

        $reviewModel            = new review();
        $reviewModel->user_id   = $user_id;
        $reviewModel->user_type = $user_type;
        $reviewModel->review    = $review;
        $reviewModel->rating    = $rating;

        $reviewModel->save();  
        
        $data['status'] = 1;        
        $data['message'] = 'Thanks for your feedback.';
        return $data; 
    }

    public function getReviews() {
        $data        = [];
        $reviewModel = new review();
        $vendorModel = new Vendor();
        $reviews     = $reviewModel->orderBy('id', 'desc')->get();
        foreach ($reviews as $key=>$review) {
            //$vendorModel = new Vendor();
            $vendorInfo              = $vendorModel->select('name')->where('id', $review->user_id)->first();    
            $data['reviews'][$key]['name'] = $vendorInfo->name;
            $data['reviews'][$key]['review']    = $review->review;
            $data['reviews'][$key]['rating']    = $review->rating;
            $data['reviews'][$key]['post_date']    = $review->created_at; 
        }
        return $data;
        // echo "<pre>";
        // print_r($data);

    }
    
    public function postReport(Request $r){
        $data = array();
        $reason = $r->reason;
        $information = $r->information;
        $ad_id = $r->ad_id;
        
        $validator = Validator::make($r->all(), [
            'reason' => 'required',
            'information' => 'required',
            'ad_id' => 'required'
        ]);

        if ($validator->fails()) {

            $failedRules = $validator->failed();

            if(isset($failedRules['reason'])) {
                $data['status'] = 0;
                $data['reason'] = 'Reason is required!';                
            }
            
            if(isset($failedRules['information'])) {
                $data['status'] = 0;
                $data['information'] = 'Information is required!';                
            }
            
            if(isset($failedRules['ad_id'])) {
                $data['status'] = 0;
                $data['ad_id'] = 'Ad id is required!';                
            }
            
            return json_encode($data);
        }
            
        
        Report::insert(['ad_id' => $ad_id, 'reason' => $reason, 'information' => $information]);
        
        $data['status'] = 1;
        $data['message'] = 'Report submitted successfully.';
        
        return json_encode($data);
    }
    
    // save posted ad without login
    public function saveAdWithoutLogin(Request $r) {
            //return $r->email; exit;
            $validator = Validator::make($r->all(), [
                'name'         => 'required',
                'email'        => 'required|email',
                'mobile'       => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
                'userpincode'  => 'required|min:6|max:6',
                'category_id'  => 'required',
                'title'        => 'required',
                'description'  => 'string|min:3|max:500',
                'price'        => 'required|regex:/^\d*(\.\d{1,2})?$/',
                'unit'         => 'required',
                'address'      => 'required',
                'city'         => 'required',
                'state'        => 'required',
                'pincode'      => 'required|min:6|max:6'
            ]);
           
            if ($validator->fails()) {
                return response()->json($validator->errors()); 
            }
            
            $data    = [];
            $app_or_web  = $r->app_or_web; //Send this key only from app
            
            if (array_key_exists("app_or_web",$r->all())){
                $files = json_decode($r->file);
            }  else {
                $files = $r->file();
            }          
            
            if(count($files) == 0) {
                $data['status']  = 0;
                $data['file'] = ['Image is required!'];
                return json_encode($data);
            } else {     
                if (array_key_exists("app_or_web",$r->all())){
                    
                } else {
                    $img_ext_arr = ["jpg", "jpeg", "png"];
                    foreach($files as $file){
                        $image_ext = $file->getClientOriginalExtension();
                        if (!in_array($image_ext, $img_ext_arr)){
                            $data['status']  = 0;
                            $data['file'] = 'file';
                            $data['message'] = ['Invalid File Type!'];
                            return json_encode($data);
                        }
                    }
                }
            }
            
            $otp = rand(111111, 999999);
            Cache::put('otp', $otp, 3); // key, value, expiry time(minute)
            
            $emaildata['otp'] = $otp;
            $user = new \stdClass();
            $user->email = $r->email;
            //exit;
             
            Mail::send('emails.otp',$emaildata, function ($message)  use ($user){
                $message->to($user->email);
                $message->subject('VMandi OTP');
            });    
            // if the user already exist   
            $email = $r->email;    
            
            Cache::put('useremail', $email, 3);
            Cache::put('usermobile', $r->mobile, 3);
            $data['status']  = 1;
            $data['otp_status']     = 1;
            $data['message'] = "OTP has been sent at $email";
            return json_encode($data);
    }  
    
    public function matchOtp(Request $r) {
        $otp = Cache::get('otp');
        if($otp) {
            $validator = Validator::make($r->all(), [
                    'name'         => 'required',
                    'email'        => 'required|email',
                    'mobile'       => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
                    'userpincode'  => 'required|min:6|max:6',
                    'category_id'  => 'required',
                    'title'        => 'required',
                    'description'  => 'string|min:3|max:500',
                    'price'        => 'required|regex:/^\d*(\.\d{1,2})?$/',
                    'unit'         => 'required',
                    'address'      => 'required',
                    'city'         => 'required',
                    'state'        => 'required',
                    'pincode'      => 'required|min:6|max:6'
                ]);
        
                if ($validator->fails()) {
                    return response()->json($validator->errors()); 
                }
                
                $data    = [];
                $app_or_web  = $r->app_or_web; //Send this key only from app
                
                if (array_key_exists("app_or_web",$r->all())){
                    $files = json_decode($r->file);
                }  else {
                    $files = $r->file();
                }          
                
                if(count($files) == 0) {
                    $data['status']  = 0;
                    $data['file'] = ['file'];
                    $data['message'] = ['Image is required!'];
                    return json_encode($data);
                } else {     
                    if (array_key_exists("app_or_web",$r->all())){
                        
                    } else {
                        $img_ext_arr = ["jpg", "jpeg", "png"];
                        foreach($files as $file){
                            $image_ext = $file->getClientOriginalExtension();
                            if (!in_array($image_ext, $img_ext_arr)){
                                $data['status']  = 0;
                                $data['file'] = 'file';
                                $data['message'] = ['Invalid File Type!'];
                                return json_encode($data);
                            }
                        }
                    }
                }
            
            $userOtp   = $r->otp;
            $serverOtp = Cache::get('otp');
            if($userOtp == $serverOtp) {
                
                if($r->sub_category_id == '') {
                    $category_id = $r->category_id;
                } else {
                    $category_id = $r->sub_category_id;
                }
                $name        = $r->name;
                $email       = $r->email;
                $mobile      = $r->mobile;
                $userpincode = $r->userpincode;
                
                $title       = $r->title;
                $description = $r->description;
                $price       = $r->price;
                $unit        = $r->unit;
                $brand_name  = $r->brand_name;
                $breed_name  = $r->breed_name;
                
                $address     = $r->address;
                $city        = $r->city;
                $state       = $r->state;
                $pincode     = $r->pincode;
                $name        = $r->name;
                $email       = $r->email;
                $mobile      = $r->mobile;
                $userpincode = $r->userpincode;
                
                $added_on    = date('Y-m-d H:i:s');
                $valid_till  = date('Y-m-d H:i:s', strtotime(0));
                $status      = 1;
                $files       = $r->file();
                if (array_key_exists("app_or_web",$r->all())){
                    $files = json_decode($r->file);
                }  else {
                    $files = $r->file();
                }         
        
                //$data[0] = count($files);
                
                if(count($files) == 0) {
                    
                    $data['status']  = 0;
                    $data['err_key'] = 'file';
                    $data['message'] = 'Image is required!';
                    return json_encode($data);
                } else {     
                    if (array_key_exists("app_or_web",$r->all())){
                        
                    } else {
                        $img_ext_arr = ["jpg", "jpeg", "png"];
                        foreach($files as $file){
                            $image_ext = $file->getClientOriginalExtension();
                            if (!in_array($image_ext, $img_ext_arr)){
                                $data['status']  = 0;
                                $data['err_key'] = 'file';
                                $data['message'] = 'Invalid File Type!';
                                return json_encode($data);
                            }
                        }
                    }
                }
                
                $vendorCheck = new Vendor();
                $vendorInfo  = $vendorCheck->where('email', Cache::get('useremail'))->orWhere('phone', Cache::get('usermobile'))->first();
                Cache::delete('usermobile');
                Cache::delete('useremail');
                if($vendorInfo) {
                    $user_id = $vendorInfo->id;
                    $user_name = $vendorInfo->name;
                    $user_email = $vendorInfo->email;
                    $user_address = $vendorInfo->address;
                    $user_phone = $vendorInfo->phone;
                    $user_city = $vendorInfo->city;
                    $user_pincode = $vendorInfo->pincode;
                } else {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 8; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
        
                $password = $randomString;
                
                
                $insertVendor = new vendor();
                $insertVendor->name = $name;
                $insertVendor->email = $email;
                $insertVendor->phone = $mobile;
                $insertVendor->password = $password;
                $insertVendor->pincode = $userpincode;
                $insertVendor->status = 1;
                $insertVendor->created_at = date("Y-m-d H:i:s");
                $insertVendor->updated_at = date("Y-m-d H:i:s");
                $insertVendor->save();
                $user_id = $insertVendor->id;
                $insertUserType = new UserType();
                $insertUserType->user_type = 1;
                $insertUserType->user_id = $user_id;
                $insertUserType->save();
        
                $emaildata['name'] = $name;
                $emaildata['password'] = $password;
                $user = new \stdClass();
                $user->email = $email;
        
                Mail::send('emails.addVendor',$emaildata, function ($message)  use ($user){
                    $message->to($user->email);
                    $message->subject('VMandi Account Password');
                });
                
                $user_id = $insertVendor->id;
                $user_name = $insertVendor->name;
                $user_email = $insertVendor->email;
                $user_address = $insertVendor->address;
                $user_city = $insertVendor->city;
                $user_pincode = $insertVendor->pincode;
                $user_phone = $insertVendor->phone;
                
            }
            
            $insertAd = new Ads();
            $insertAd->user_id = $user_id;
            $insertAd->category_id = $category_id;
            $insertAd->title = $title;
            $insertAd->description = $description;
            $insertAd->price = $price;
            $insertAd->unit = $unit;
            $insertAd->brand_name = $brand_name;
            $insertAd->breed_name = $breed_name;
            $insertAd->address = $address;
            $insertAd->city = $city;
            $insertAd->state = $state;
            $insertAd->pincode = $pincode;
            //$insertAd->location = $locations[0];
            $insertAd->added_on = $added_on;
            $insertAd->valid_till = $valid_till;
            $insertAd->status = $status;
            $insertAd->save();
            $ad_id = $insertAd->id;
            
            $i = 0;
            if (array_key_exists("app_or_web",$r->all())){
                foreach($files as $app_img){
                    $image = str_replace('data:image/png;base64,', '', $app_img);
                    $image = str_replace(' ', '+', $image);
                    $input_img = base64_decode($image);
                    $file = public_path('image/ad_images/') . $ad_id.'_'.time().'_'.$i. '.jpg';
                    $image_url = url('public/image/ad_images/'.$ad_id.'_'.time().'_'.$i. '.jpg');
                    $success = file_put_contents($file, $input_img);
                    
                    $insertAdImage = new AdImages();
                    $insertAdImage->ad_id = $ad_id;
                    $insertAdImage->image = $image_url;
                    $insertAdImage->save();
                    $i++;
                }
            }else{
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
            }
            $data['id'] = $user_id;
            $data['user_type'] = 1;
            $data['name'] = $user_name;
            $data['email'] = $user_email;
            $data['phone'] = $user_phone;
            $data['address'] = $user_address;
            $data['city'] = $user_city;
            $data['pincode'] = $user_pincode;
            $data['status'] = 1;
            $data['ad_id'] = $ad_id;
            $data['message'] = 'Ad Inserted Successfully.';
    
            return json_encode($data);
                
            } else {
                $data['status']  = 0;
                //$data['otp']  = Cache::get('otp');
                $data['otp_status'] = 0;
                $data['message'] = "Wrong OTP entered";
                return json_encode($data);
            }
        } else {
            $data['status']  = 0;
            $data['otp_status']     = 0;
            $data['message'] = "OTP is expired";
            return json_encode($data);
        }   
    }
    
    public function resendOtp() {
        $otp = Cache::get('otp');
        if($otp) {
            $emaildata['otp'] = $otp;
            $user = new \stdClass();
            $user->email = Cache::get('useremail');;
            //exit;
             
            Mail::send('emails.otp',$emaildata, function ($message)  use ($user){
                $message->to($user->email);
                $message->subject('VMandi OTP');
            }); 
            
            $data['status']  = 1;
            $data['otp_status']     = 1;
            $data['message'] = "OTP has been sent at $user->email";
            return json_encode($data);
        } else {
            $data['status']  = 0;
            $data['otp_status']     = 0;
            $data['message'] = "Session is expired! Please post again.";
            return json_encode($data);
        }
    }

    public function siteInfo() {
        $bannerModel = new banner;
        $siteInfo = $bannerModel->get()->first();
        return $siteInfo;
    }
    
}

