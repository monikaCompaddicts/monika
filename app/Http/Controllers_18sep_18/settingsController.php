<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatesettingsRequest;
use App\Http\Requests\UpdatesettingsRequest;
use App\Repositories\settingsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class settingsController extends AppBaseController
{
    /** @var  settingsRepository */
    private $settingsRepository;

    public function __construct(settingsRepository $settingsRepo)
    {
        $this->settingsRepository = $settingsRepo;
    }

    /**
     * Display a listing of the settings.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->settingsRepository->pushCriteria(new RequestCriteria($request));
        $settings = $this->settingsRepository->all();

        return view('settings.index')
            ->with('settings', $settings);
    }

    /**
     * Show the form for creating a new settings.
     *
     * @return Response
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Store a newly created settings in storage.
     *
     * @param CreatesettingsRequest $request
     *
     * @return Response
     */
    public function store(CreatesettingsRequest $request)
    {
        $input = $request->all();
        $bann_img = $request->file('banner_image');
        $bann_img_name = 'home-banner-'.time().'.'.$bann_img->getClientOriginalExtension();
        $destinationPath = public_path('image/home_image');
        $bann_img_url = url('public/image/home_image/'.$bann_img_name);
        $bann_img->move($destinationPath, $bann_img_name);

        $input['banner_image'] = $bann_img_url;

        $ad_img = $request->file('ad-banner');
        $ad_img_name = 'ad-banner-'.time().'.'.$ad_img->getClientOriginalExtension();
        $destinationPath = public_path('image/home_image');
        $ad_img_url = url('public/image/home_image/'.$ad_img_name);
        $ad_img->move($destinationPath, $ad_img_name);

        $input['ad_banner'] = $ad_img_url;

        //echo $bann_img;
       // echo "<pre>";print_r($input);exit;

        $settings = $this->settingsRepository->create($input);

        Flash::success('Settings saved successfully.');

        return redirect(route('settings.index'));
    }

    /**
     * Display the specified settings.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $settings = $this->settingsRepository->findWithoutFail($id);

        if (empty($settings)) {
            Flash::error('Settings not found');

            return redirect(route('settings.index'));
        }

        return view('settings.show')->with('settings', $settings);
    }

    /**
     * Show the form for editing the specified settings.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $settings = $this->settingsRepository->findWithoutFail($id);

        if (empty($settings)) {
            Flash::error('Settings not found');

            return redirect(route('settings.index'));
        }

        return view('settings.edit')->with('settings', $settings);
    }

    /**
     * Update the specified settings in storage.
     *
     * @param  int              $id
     * @param UpdatesettingsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatesettingsRequest $request)
    {
        $settings = $this->settingsRepository->findWithoutFail($id);

        if (empty($settings)) {
            Flash::error('Settings not found');

            return redirect(route('settings.index'));
        }

        $input = $request->all();

        if($request->has('banner_image')){
            $exists_img_arr = explode('/', $settings->banner_image);
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
            $input['banner_image'] = $settings->banner_image;
        }

        if($request->has('ad_banner')){
            $exists_img_ad_arr = explode('/', $settings->ad_banner);
            $exists_img_ad_name = $exists_img_ad_arr[count($exists_img_ad_arr)-1];
            $unlink_ad_path = public_path('image/home_image').'/'.$exists_img_ad_arr[count($exists_img_ad_arr)-1];
            unlink($unlink_ad_path);

            $ad_img = $request->file('ad_banner');
            $ad_img_name = 'ad-banner-'.time().'.'.$ad_img->getClientOriginalExtension();
            $destinationPath = public_path('image/home_image');
            $ad_img_url = url('public/image/home_image/'.$ad_img_name);
            $ad_img->move($destinationPath, $ad_img_name);

            $input['ad_banner'] = $ad_img_url;
        }else{
            $input['ad_banner'] = $settings->ad_banner;
        }

        $settings = $this->settingsRepository->update($input, $id);

        Flash::success('Settings updated successfully.');

        return redirect('settings/1/edit');
        return redirect(route('settings.index'));
    }

    /**
     * Remove the specified settings from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $settings = $this->settingsRepository->findWithoutFail($id);

        if (empty($settings)) {
            Flash::error('Settings not found');

            return redirect(route('settings.index'));
        }

        $this->settingsRepository->delete($id);

        Flash::success('Settings deleted successfully.');

        return redirect(route('settings.index'));
    }
}
