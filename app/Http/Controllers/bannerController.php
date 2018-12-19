<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatebannerRequest;
use App\Http\Requests\UpdatebannerRequest;
use App\Repositories\bannerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use File;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class bannerController extends AppBaseController
{
    /** @var  bannerRepository */
    private $bannerRepository;

    public function __construct(bannerRepository $bannerRepo)
    {
        $this->middleware('auth');
        $this->bannerRepository = $bannerRepo;
    }

    /**
     * Display a listing of the banner.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->bannerRepository->pushCriteria(new RequestCriteria($request));
        $banners = $this->bannerRepository->get()->first();

        return view('banners.edit')
            ->with('banners', $banners);
    }

    /**
     * Show the form for creating a new banner.
     *
     * @return Response
     */
    public function create()
    {
        return view('banners.create');
    }

    /**
     * Store a newly created banner in storage.
     *
     * @param CreatebannerRequest $request
     *
     * @return Response
     */
    public function store(CreatebannerRequest $request)
    {
        $input                   = $request->all();

        if($request->has('logo')) {
            $logo_img            = $request->file('logo');
            $logo_img_name       = 'logo-'.time().'.'.$logo_img->getClientOriginalExtension();
            $logoDestinationPath = public_path('image/home_image');
            $logo_img_url        = 'public/image/home_image/'.$logo_img_name;
            $logo_img->move($logoDestinationPath, $logo_img_name);

            $input['logo']       = $logo_img_url;  
        }
        
        if($request->has('loader')) {

            $loader                = $request->file('loader');
            $loader_name           = 'loader-'.time().'.'.$loader->getClientOriginalExtension();
            $loaderDestinationPath = public_path('image/logo');
            $loader_img_url        = 'public/image/logo/'.$loader_name;
            $loader->move($loaderDestinationPath, $loader_name);        
            $input['loader']       = $loader_img_url;
        }

        if($request->has('banner_image')) {    

            $bann_img        = $request->file('banner_image');
            $bann_img_name   = 'home-banner-'.time().'.'.$bann_img->getClientOriginalExtension();
            $destinationPath = public_path('image/home_image');
            $bann_img_url    = 'public/image/home_image/'.$bann_img_name;
            $bann_img->move($destinationPath, $bann_img_name);

            $input['banner_image'] = $bann_img_url;
         }   

        $banner = $this->bannerRepository->create($input);

        Flash::success('Settings saved successfully.');

       // return view('banners.edit')->with('banner', $banner);
        return redirect(route('banners.edit', [$banner->id]));
    }

    /**
     * Display the specified banner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $banner = $this->bannerRepository->findWithoutFail($id);

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('banners.create'));
        }

        return view('banners.show')->with('banner', $banner);
    }

    /**
     * Show the form for editing the specified banner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $banner = $this->bannerRepository->get()->first();

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('banners.create'));
        }
        //print_r($banner); exit;
        //print_r($banner); exit;
        return view('banners.edit')->with('banner', $banner);
    }

    /**
     * Update the specified banner in storage.
     *
     * @param  int              $id
     * @param UpdatebannerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatebannerRequest $request)
    {
        //echo "<pre>";print_r($request->all());exit;
        $banner = $this->bannerRepository->get()->first();

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('banners.edit'))->withErrors('Select title');
        }

        $input = $request->all();

        if($request->has('banner_image')){
            if($banner->banner_image) {                
                File::delete($banner->banner_image);                
            } 
            $bann_img        = $request->file('banner_image');
            $bann_img_name   = 'home-banner-'.time().'.'.$bann_img->getClientOriginalExtension();
            $destinationPath = public_path('image/home_image');
            $bann_img_url    = 'public/image/home_image/'.$bann_img_name;
            $bann_img->move($destinationPath, $bann_img_name);
            $input['banner_image'] = $bann_img_url;   
        } else {
            $input['banner_image'] = $banner->banner_image;
        }   

        if($request->has('logo')) {
            if($banner->logo) {
              File::delete($banner->logo);                  
            }

            $logo_img            = $request->file('logo');
            $logo_img_name       = 'logo-'.time().'.'.$logo_img->getClientOriginalExtension();
            $logoDestinationPath = public_path('image/home_image');
            $logo_img_url        = 'public/image/home_image/'.$logo_img_name;
            $logo_img->move($logoDestinationPath, $logo_img_name);
            $input['logo'] = $logo_img_url;   
        } else {
            $input['logo'] = $banner->logo;
        }
        
        if($request->has('loader')) {
            if($banner->loader) {
                File::delete($banner->loader);                     
            }
            $loader                = $request->file('loader');
            $loader_name           = 'loader-'.time().'.'.$loader->getClientOriginalExtension();
            $loaderDestinationPath = public_path('image/logo');
            $loader_img_url        = 'public/image/logo/'.$loader_name;
            $loader->move($loaderDestinationPath, $loader_name);        
            $input['loader']       = $loader_img_url;        
        } else {
            $input['loader']       = $banner->loader;   
        }

        $banner = $this->bannerRepository->update($input, $id);

        Flash::success('Settings saved successfully.');
       
        return redirect(route('banners.edit', [$banner->id]));
        //return redirect(route('banners.edit'));
    }

    /**
     * Remove the specified banner from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $banner = $this->bannerRepository->findWithoutFail($id);

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('banners.index'));
        }

        $this->bannerRepository->delete($id);

        Flash::success('Banner deleted successfully.');

        return redirect(route('banners.index'));
    }
}
