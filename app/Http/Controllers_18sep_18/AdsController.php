<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ads;

class AdsController extends Controller
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
	
    public function insertAd()
    {
		$user_id = 1;
		$category_id = 1;
		$title = 'test';
		$description = 'testing';
		$added_on = date('Y-m-d H:i:s');
		$valid_till = date('Y-m-d H:i:s', strtotime(0));
		$status = 1;
		
		$insertAd = new Ads();
		$insertAd->user_id = $user_id;
		$insertAd->category_id = $category_id;
		$insertAd->title = $title;
		$insertAd->description = $description;
		$insertAd->added_on = $added_on;
		$insertAd->valid_till = $valid_till;
		$insertAd->status = $status;
		$insertAd->save();
		
		
		echo "<pre>";print_r(Ads::get());exit;
		return view('home');
    }
	
}
