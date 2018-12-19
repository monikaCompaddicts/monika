<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\vendor;
use App\Models\CmsTitle;
use App\Models\CMS;
use App\Models\Advertisement;
use App\Models\Ads;
use App\Models\AdImages;
use App\Models\AdEnquiry;
use App\Models\Customer;
use App\Models\Ticker;
use Flash; 
use Redirect; 
use Validator; 
use App\Models\adDimension;
use App\Models\advertisementClients;
use DB;
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
            $categories[$i]['description'] = $category->description;
            $categories[$i]['unit'] = $category->unit;
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
        $description = $r->category_description;
        $unit = $r->unit;

        if($r->parent_category == 0){
            $cat_count = Category::where('parent_category', 0)->count();
            $cat_order = $cat_count+1;
        }else{
            $cat_order = 0;
        }

        $insertCategory = new Category;
        $insertCategory->name = $r->category_name;
        $insertCategory->image = $image_url;
        $insertCategory->description = $description;
        $insertCategory->unit = $unit;
        $insertCategory->parent_category = $r->parent_category;
        $insertCategory->category_order = $cat_order;
        $insertCategory->added_on = date('Y-m-d H:i:s');
        $insertCategory->status = 1;
        $insertCategory->save();
        $categories = Category::where('parent_category', 0)->get();
        Flash::success('Category saved successfully.');
        return redirect('/category');
    }

    public function editCategory(Request $r){
        //print_r($r->all()); exit;
        if($r->has('image')){
            $exists_cat = Category::where('id', $r->category_id)->first();
            $exists_img_arr = explode('/', $exists_cat->image);
            $exists_img_name = $exists_img_arr[count($exists_img_arr)-1];
            $unlink_path = public_path('image/category_image').'/'.$exists_img_arr[count($exists_img_arr)-1];
            if (file_exists($unlink_path)) {
                unlink($unlink_path);
            }

            $image = $r->file('image');
            $image_name = $r->category_name.'-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('image/category_image');
            $image_url = url('public/image/category_image/'.$image_name);
            $image->move($destinationPath, $image_name);
        }

        $insertCategory = Category::where('id', $r->category_id)->first();
        $insertCategory->name = $r->category_name;
        $insertCategory->description = $r->category_description;
        $insertCategory->unit = $r->unit;
        if($r->has('image')){
            $insertCategory->image = $image_url;
        }
        $insertCategory->save();
        //$categories = Category::where('parent_category', 0)->get();
        Flash::success('Category saved successfully.');
        return redirect('/category');
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
            $ads = Ads::where('category_id', $id)->get();
            foreach($ads as $ad){
                // Ads::where('id', $ad->id)->delete();
                // AdImages::where('ad_id', $ad->id)->delete();
                $ads_del = Ads::find($ad->id);
                $ads_del->ad_images()->delete();
                $ads_del->ad_enquiry()->delete();
                $ads_del->ad_loctaion()->delete();
                $ads_del->delete();
            }
        }
        Flash::success('Deleted Successfully.');
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
            $ads = Ads::whereIn('category_id', $id_arr)->get();
            foreach($ads as $ad){
                // Ads::where('id', $ad->id)->delete();
                // AdImages::where('ad_id', $ad->id)->delete();
                $ads_del = Ads::find($ad->id);
                $ads_del->ad_images()->delete();
                $ads_del->ad_enquiry()->delete();
                $ads_del->ad_loctaion()->delete();
                $ads_del->delete();
            }
            Flash::success('Deleted Successfully.');
            echo 1;exit;
        }   
    }

    public function changeVendorStatus(Request $r){
        $vendor_id = $r->vendor_id;
        $status = $r->status;
        vendor::where('id', $vendor_id)->update(['status' => $status]);
        return 1;
    }

    public function changeAdStatus(Request $r){
        $ad_id = $r->ad_id;
        $status = $r->status;
        Ads::where('id', $ad_id)->update(['status' => $status]);
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

    public function cms(){
        $cms_title_all = CmsTitle::get();
        $cms_titles = array();
        $cms_titles[0] = 'Select Title';
        foreach($cms_title_all as $val){
            $cms_titles[$val->id] = $val->title;
        }
        return view('cms/create', ['cms_titles' => $cms_titles]);
    }

    public function getCMSContent(Request $r){
        $tilte_id = $r->cms_id;
        $tilte_arr = CMS::where('title', $tilte_id)->get();
        if(count($tilte_arr) == 0){
            return 0;
        }else{
            return json_encode($tilte_arr[0]);
        }
    }

    public function updateCMS(Request $r){
        $cms_title = $r->cms_title;
        $cms_description = $r->cms_description;
        if($cms_title == 0){
            return Redirect::back()->withInput()->withErrors('Select title');
        }

        $tilte_arr = CMS::where('title', $cms_title)->get();
        if(count($tilte_arr) == 0){
            $insertCMS = new CMS;
            $insertCMS->title = $cms_title;
            $insertCMS->content = $cms_description;
            $insertCMS->save();
            Flash::success('Saved Successfully.');
        }else{
            CMS::where('id', $tilte_arr[0]->id)->update(['title' => $cms_title, 'content' => $cms_description]);
            Flash::success('Updated Successfully.');
        }
        return redirect('/cms');
    }

    public function childCategory($parent_id, $category_json){
        $category_arr = json_decode($category_json);
        $categories = Category::where('parent_category', $parent_id)->get();
        
        //return json_encode($category_arr);
        return json_encode($categories);
    }

    public function advertisement(){
        $data['dimension'] = adDimension::get(['dimension']);
        $data['clients']   = advertisementClients::get(['name', 'email', 'mobile']); 

        return view('advertisement/create', ['data' => $data]);
    }

    public function saveAdvertisement(Request $r) {
        print_r($r->all());
    }

    public function updateAdvertisement(Request $r){
        $position_1_img = $r->position_1_img;
        $position_1_title = $r->position_1_title;
        $position_1_link = $r->position_1_link;
        $position_2_img = $r->position_2_img;
        $position_2_title = $r->position_2_title;
        $position_2_link = $r->position_2_link;
        $position_3_img = $r->position_3_img;
        $position_3_title = $r->position_3_title;
        $position_3_link = $r->position_3_link;

        $validator = Validator::make($r->all(), [
            'position_1_title' => 'required',
            'position_1_link' => 'required',
            'position_2_title' => 'required',
            'position_2_link' => 'required',
            'position_3_title' => 'required',
            'position_3_link' => 'required',
        ]);

        if ($validator->fails()) {
            $message = '';
            $failedRules = $validator->failed();

            if(isset($failedRules['position_1_title']['Required'])) {
                $message = $message.'First position title is required.<br>';
            }
            if(isset($failedRules['position_1_link']['Required'])) {
                $message = $message.'First position link is required.<br>';
            }
            if(isset($failedRules['position_2_title']['Required'])) {
                $message = $message.'Second position title is required.<br>';
            }
            if(isset($failedRules['position_2_link']['Required'])) {
                $message = $message.'Second position link is required.<br>';
            }
            if(isset($failedRules['position_3_title']['Required'])) {
                $message = $message.'Third position title is required.<br>';
            }
            if(isset($failedRules['position_3_link']['Required'])) {
                $message = $message.'Third position link is required.<br>';
            }

            return Redirect::back()->withInput()->withErrors($message);
        }

        $advertisements = Advertisement::get();

        if($r->has('position_1_img')){
            $exists_img_arr1 = explode('/', $advertisements[0]->image);
            $exists_img_name1 = $exists_img_arr1[count($exists_img_arr1)-1];
            $unlink_path1 = public_path('image/advertisement_image').'/'.$exists_img_arr1[count($exists_img_arr1)-1];
            if (file_exists($unlink_path1)) {
                unlink($unlink_path1);
            }       

            $adv_img1 = $r->file('position_1_img');
            $adv_img_name1 = 'advertisement-1-'.time().'.'.$adv_img1->getClientOriginalExtension();
            $destinationPath1 = public_path('image/advertisement_image');
            $adv_img_url1 = url('public/image/advertisement_image/'.$adv_img_name1);
            $adv_img1->move($destinationPath1, $adv_img_name1);

            $position_1_img = $adv_img_url1;
        }else{
            $position_1_img = $advertisements[0]->image;
        }

        if($r->has('position_2_img')){
            $exists_img_arr2 = explode('/', $advertisements[1]->image);
            $exists_img_name2 = $exists_img_arr2[count($exists_img_arr2)-1];
            $unlink_path2 = public_path('image/advertisement_image').'/'.$exists_img_arr2[count($exists_img_arr2)-1];
            if (file_exists($unlink_path2)) {
                unlink($unlink_path2);
            }

            $adv_img2 = $r->file('position_2_img');
            $adv_img_name2 = 'advertisement-2-'.time().'.'.$adv_img2->getClientOriginalExtension();
            $destinationPath2 = public_path('image/advertisement_image');
            $adv_img_url2 = url('public/image/advertisement_image/'.$adv_img_name2);
            $adv_img2->move($destinationPath2, $adv_img_name2);

            $position_2_img = $adv_img_url2;
        }else{
            $position_2_img = $advertisements[1]->image;
        }

        if($r->has('position_3_img')){
            $exists_img_arr3 = explode('/', $advertisements[2]->image);
            $exists_img_name3 = $exists_img_arr3[count($exists_img_arr3)-1];
            $unlink_path3 = public_path('image/advertisement_image').'/'.$exists_img_arr3[count($exists_img_arr3)-1];
            if (file_exists($unlink_path3)) {
                unlink($unlink_path3);
            }

            $adv_img3 = $r->file('position_3_img');
            $adv_img_name3 = 'advertisement-3-'.time().'.'.$adv_img3->getClientOriginalExtension();
            $destinationPath3 = public_path('image/advertisement_image');
            $adv_img_url3 = url('public/image/advertisement_image/'.$adv_img_name3);
            $adv_img3->move($destinationPath3, $adv_img_name3);

            $position_3_img = $adv_img_url3;
        }else{
            $position_3_img = $advertisements[1]->image;
        }

        Advertisement::where('id', 1)->update(['title' => $position_1_title, 'image' => $position_1_img, 'link' => $position_1_link]);

        Advertisement::where('id', 2)->update(['title' => $position_2_title, 'image' => $position_2_img, 'link' => $position_2_link]);

        Advertisement::where('id', 3)->update(['title' => $position_3_title, 'image' => $position_3_img, 'link' => $position_3_link]);

        Flash::success('Advertisement updated successfully.');
        return redirect('advertisement');
    }

    public function vendorAd($ad_id){
        //echo $ad_id;exit;

        $ad = Ads::where('id', $ad_id)->first();
        $ad_images = AdImages::where('ad_id', $ad_id)->get();

        $ad_enquiries = AdEnquiry::where('ad_id', $ad_id)->orderBy('id', 'desc')->paginate(5);

        return view('vendors.ad_show')->with(['ad' => $ad, 'ad_images' => $ad_images, 'ad_enquiries' => $ad_enquiries]);
    }
    
    public function customers(){
        $customers = Customer::paginate('15');
        return view('customers.index')->with(['customers' => $customers]);
    }

    public function ticker(){
        $ticker = Ticker::get();

        return view('ticker.index')->with(['ticker' => $ticker]);
    }

    public function saveTicker(Request $r){
        $count = $r->count_ticker;
        $deleted_ids = $r->deleted_ids;
        $all_request = $r->all();

        if($deleted_ids != ''){
            $deleted_ids_arr = explode(',', $deleted_ids);
            foreach($deleted_ids_arr as $deleted_id){
                Ticker::where('id', $deleted_id)->delete();
            }
        }

        for($i=1; $i <= $count; $i++){
            if($all_request['id_'.$i] == ''){
                $saveTricker = new Ticker();
            }else{
                $saveTricker = Ticker::where('id', $all_request['id_'.$i])->first();
            }
            $saveTricker->product_name = $all_request['name_'.$i];
            $saveTricker->product_price = $all_request['price_'.$i];
            $saveTricker->save();
        }

        Flash::success('Updated successfully.');
        return redirect('ticker');
    }
}
