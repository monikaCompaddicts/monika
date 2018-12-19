<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
//use App\Mail\SendMailable;vendor
use Illuminate\Support\Facades\Hash;
use App\Models\Ads;
use App\Models\vendor;
use App\Models\AdEnquiry;
use App\Models\Customer;
use App\Models\Category;
use App\User;
use DB;
use Flash;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_vendors = vendor::get()->count();
        $total_customers = Customer::get()->count();
        $total_ads = Ads::get()->count();
        $total_request = AdEnquiry::get()->count();

        $user_ad_enquiries = DB::table('ads')
                            ->leftJoin('ad_enquiry', 'ads.id', '=', 'ad_enquiry.ad_id')
                            ->orderBy('ad_enquiry.id', 'desc')
                            ->select('ads.category_id as aden_cat_id', 'ad_enquiry.id as aden_id', 'ad_enquiry.ad_id as aden_ad_id', 'ad_enquiry.user_id as aden_user_id', 'ad_enquiry.user_type as aden_user_type', 'ad_enquiry.message as aden_message', 'ad_enquiry.created_at as aden_created_at')
                            ->get();

        $messages = array();
        $i = 0;
        foreach($user_ad_enquiries as $user_ad_enquiry){
            if(!empty($user_ad_enquiry->aden_id)){
                if($user_ad_enquiry->aden_user_type == 1){
                    $user_name = vendor::where('id', $user_ad_enquiry->aden_user_id)->first();
                }else{
                    $user_name = Customer::where('id', $user_ad_enquiry->aden_user_id)->first();
                }
                if($user_name == ''){
                    $name = '';
                }else{
                    $name = $user_name->name;
                }
                
                $ad_title = Ads::where('id', $user_ad_enquiry->aden_ad_id)->first();
                $category = Category::where('id', $user_ad_enquiry->aden_cat_id)->first();

                $messages[$i]['id'] = $user_ad_enquiry->aden_id;
                $messages[$i]['ad_id'] = $user_ad_enquiry->aden_ad_id;
                $messages[$i]['cat_id'] = $category->id;
                $messages[$i]['cat_name'] = $category->name;
                $messages[$i]['ad_title'] = $ad_title->title;
                $messages[$i]['post_user_id'] = $user_ad_enquiry->aden_user_id;
                $messages[$i]['user_name'] = $name;
                $messages[$i]['user_type'] = $user_ad_enquiry->aden_user_type;
                $messages[$i]['message'] = $user_ad_enquiry->aden_message;
                if(date("d-M-Y", strtotime($user_ad_enquiry->aden_created_at)) == date("d-M-Y")){
                	$messages[$i]['time'] = 'Today '.date("H:i", strtotime($user_ad_enquiry->aden_created_at));
                }else if(date("d-M-Y", strtotime($user_ad_enquiry->aden_created_at)) == date('d-M-Y',strtotime("-1 days"))){
                	$messages[$i]['time'] = 'Yesterday '.date("H:i", strtotime($user_ad_enquiry->aden_created_at));
                }else{
                	$messages[$i]['time'] = date("d-M-Y H:i", strtotime($user_ad_enquiry->aden_created_at));
                }
                if($i == 8){
                    break;
                }
                $i++;
            }
        }

        $vendors = vendor::orderBy('id', 'desc')->get();
        $latest_vendors = array();
        $j = 0;

        foreach($vendors as $vendor){
        	$latest_vendors[$j]['id'] = $vendor->id;
        	$latest_vendors[$j]['name'] = $vendor->name;
        	if($vendor->status == 1){
	        	$latest_vendors[$j]['status'] = 'Active';
	        }else{
	        	$latest_vendors[$j]['status'] = 'Inactive';
	        }

	        if(date("d-M-Y", strtotime($vendor->created_at)) == date("d-M-Y")){
            	$latest_vendors[$j]['time'] = 'Today';
            }else if(date("d-M-Y", strtotime($vendor->created_at)) == date('d-M-Y',strtotime("-1 days"))){
            	$latest_vendors[$j]['time'] = 'Yesterday';
            }else{
            	$latest_vendors[$j]['time'] = date("d M y", strtotime($vendor->created_at));
            }

            if($j == 5){
            	break;
            }
            $j++;
        }

        $ads = Ads::orderBy('id', 'desc')->get();
        $latest_ads = array();

        $k = 0;
        foreach($ads as $ad){
        	$category_name = Category::where('id', $ad->category_id)->first();
        	$latest_ads[$k]['id'] = $ad->id;
        	$latest_ads[$k]['user_id'] = $ad->user_id;
        	$latest_ads[$k]['title'] = $ad->title;
        	$latest_ads[$k]['description'] = $ad->description;
        	$latest_ads[$k]['category_name'] = $category_name->name;
        	if($k == 3){
            	break;
            }
            $k++;
        }

        //echo "<pre>";print_r($latest_vendors);exit;
        return view('dashboard.index', ['total_vendors' => $total_vendors, 'total_customers' => $total_customers, 'total_ads' => $total_ads, 'total_request' => $total_request, 'messages' => $messages, 'latest_vendors' => $latest_vendors, 'latest_ads' => $latest_ads]);
        // return view('home');
    }

    public function profile(){
        $sess_arr = session()->all();
        foreach ( $sess_arr as $key => $value ){
            if ( stripos( $key, 'login_web' ) !== false ){
                $user_id = $value;
                break;
            }
        }

        $user = User::where('id', $user_id)->first();
        return view('profile.index', ['user' => $user]);
        echo "<pre>";print_r($user_data);echo $user_data->name;exit;
        echo $user_id;exit;
    }

    public function updateUserData(Request $r){
        $id = $r->id;
        $name = $r->name;
        $email = $r->email;

        $validator = Validator::make($r->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id
        ]);

        if ($validator->fails()) {
            $message = '';
            $failedRules = $validator->failed();
            if(isset($failedRules['name'])) {
                $message = 'Name cannot be null.<br>';
            }

            if(isset($failedRules['email']['Required'])) {
                $message = $message.'Email id cannot be null.';
            }

            if(isset($failedRules['email']['Email'])) {
                $message = $message.'Invalid email id.';
            }

            if(isset($failedRules['email']['Unique'])) {
                $message = $message.'Email id already exists.';
            }

            Flash::error($message);
            return redirect('profile');
        }

        User::where('id', $id)->update(['name' => $name, 'email' => $email]);
        $user = User::where('id', $id)->first();
        Flash::success('Admin Details Updated Successfully.');
        return redirect('profile');
    }

    public function changeUserPassword(Request $r){
        $new_password = $r->new_password;
        $confirm_password = $r->confirm_password;
        $id = $r->id;

        $validator = Validator::make($r->all(), [
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);

        if ($validator->fails()) {
            $message = '';
            $failedRules = $validator->failed();
            if(isset($failedRules['new_password'])) {
                $message = 'New password is required.<br>';
            }

            if(isset($failedRules['confirm_password'])) {
                $message = $message.'Confirm password is required.';
            }

            Flash::error($message);
            return redirect('profile');
        }

        if($new_password == $confirm_password){
            $new_pwd = Hash::make($new_password);
            User::where('id', $id)->update(['password' => $new_pwd]);
            Flash::success('Password Updated Successfully.');
            return redirect('profile');
        }else{
            Flash::error('Confirm password should be same as new password!');
            return redirect('profile');
        }
    }

    public function mail()
    {
       $data = ['name' => 'Krunal'];


        Mail::send('emails.name',$data, function ($message) {
            $message->to('monika@compaddicts.com');
            $message->subject('VMandi testing');
        });
       //Mail::to('monika@compaddicts.com')->send(new SendMailable($name));
       //Mail::to('monika@compaddicts.com')->send(new \App\Mail\SendMailable($user));
       
       echo 'Email was sent';exit;
    }
}
