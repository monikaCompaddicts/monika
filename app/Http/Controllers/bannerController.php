<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatebannerRequest;
use App\Http\Requests\UpdatebannerRequest;
use App\Repositories\bannerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class bannerController extends AppBaseController
{
    /** @var  bannerRepository */
    private $bannerRepository;

    public function __construct(bannerRepository $bannerRepo)
    {
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
        $banners = $this->bannerRepository->all();

        return view('banners.index')
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
        $input = $request->all();

        $bann_img = $request->file('banner_image');
        $bann_img_name = 'home-banner-'.time().'.'.$bann_img->getClientOriginalExtension();
        $destinationPath = public_path('image/home_image');
        $bann_img_url = url('public/image/home_image/'.$bann_img_name);
        $bann_img->move($destinationPath, $bann_img_name);

        $input['banner_image'] = $bann_img_url;

        $banner = $this->bannerRepository->create($input);

        Flash::success('Banner saved successfully.');

        return redirect(route('banners.index'));
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

            return redirect(route('banners.index'));
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
        $banner = $this->bannerRepository->findWithoutFail($id);

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('banners.index'));
        }

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
        $banner = $this->bannerRepository->findWithoutFail($id);

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('banners.index'));
        }

        $input = $request->all();

        if($request->has('banner_image')){
            $exists_img_arr = explode('/', $banner->banner_image);
            $exists_img_name = $exists_img_arr[count($exists_img_arr)-1];
            $unlink_path = public_path('image/home_image').'/'.$exists_img_arr[count($exists_img_arr)-1];
            unlink($unlink_path);

            $bann_img = $request->file('banner_image');
            $bann_img_name = 'home-banner-'.time().'.'.$bann_img->getClientOriginalExtension();
            $destinationPath = public_path('image/home_image');
            $bann_img_url = url('public/image/home_image/'.$bann_img_name);
            $bann_img->move($destinationPath, $bann_img_name);

            $input['banner_image'] = $bann_img_url;
        }else{
            $input['banner_image'] = $banner->banner_image;
        }

        $banner = $this->bannerRepository->update($input, $id);

        Flash::success('Banner updated successfully.');
        return redirect('banners/1/edit');
        return redirect(route('banners.index'));
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
