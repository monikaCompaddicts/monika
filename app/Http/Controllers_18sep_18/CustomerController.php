<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
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
	 
	 public function login(){
		 $email = '';
		 $password = md5('123456');
		 $existing_customer = Customer::where('email', $email)->where('password', $password)->first();
		 if(count($existing_customer) == 0){
			 return 0;
		 }else{
			 return 1;
		 }
	 }
    public function register()
    {
		$name = 'Mahesh';
		$email = 'mahesh@gmail.com';
		$password = md5('123456');
		$phone = 9563214780;
		$type = 1;
		$added_on = date('Y-m-d H:i:s');
		$status = 1;
		$address = '25, Near Inox';
		$city = 'Lucknow';
		$pincode = 226001;
		$state = 'UP';
		
		$existing_customer = Customer::where('email', $email)->first();
		if(count($existing_customer) == 0){
			$insertCustomer = new Customer();
			$insertCustomer->name = $name;
			$insertCustomer->email = $email;
			$insertCustomer->password = $password;
			$insertCustomer->phone = $phone;
			$insertCustomer->type = $type;
			$insertCustomer->added_on = $added_on;
			$insertCustomer->status = $status;
			$insertCustomer->address = $address;
			$insertCustomer->city = $city;
			$insertCustomer->pincode = $pincode;
			$insertCustomer->state = $state;
			$insertCustomer->save();
		}else{
			return redirect()->back()->withInput($request->all)->withErrors('Email Id Already Exists!');
		}
		
		echo "<pre>";print_r(Customer::get());exit;
		return view('home');
    }
	
	public function update()
    {
        $id = 1;
		$existing_customer = Customer::where('id !=', $id)->where('email', $email)->first();
		if(count($existing_customer) == 0){
			$customer = Customer::where('id', $id)->first();
			$name = 'Mahesh';
			$email = 'mahesh@gmail.com';
			$password = md5('123456');
			$phone = 8965471230;
			$type = 1;
			$updated_on = date('Y-m-d H:i:s');
			$status = 1;
			$address = '25, Near Inox';
			$city = 'Lucknow';
			$pincode = 226001;
			$state = 'UP';
			
			$updateCustomer = $customer;
			$updateCustomer->name = $name;
			$updateCustomer->email = $email;
			$updateCustomer->password = $password;
			$updateCustomer->phone = $phone;
			$updateCustomer->type = $type;
			$updateCustomer->updated_on = $updated_on;
			$updateCustomer->address = $address;
			$updateCustomer->city = $city;
			$updateCustomer->pincode = $pincode;
			$updateCustomer->state = $state;
			$updateCustomer->save();
		}else{
			return redirect()->back()->withInput($request->all)->withErrors('Email Id Already Exists!');
		}
		echo "<pre>";print_r(Customer::get());exit;
		return view('home');
    }
}
