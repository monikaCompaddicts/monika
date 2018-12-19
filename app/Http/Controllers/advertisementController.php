<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateadvertisementRequest;
use App\Http\Requests\UpdateadvertisementRequest;
use App\Repositories\advertisementRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\adDimension;
use App\Models\advertisementClients;
use App\Models\Advertisement;
use DB;
use File;

class advertisementController extends AppBaseController
{
    /** @var  advertisementRepository */
    private $advertisementRepository;

    public function __construct(advertisementRepository $advertisementRepo)
    {
        $this->advertisementRepository = $advertisementRepo;
    }

    /**
     * Display a listing of the advertisement.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->advertisementRepository->pushCriteria(new RequestCriteria($request));
        $advertisements = $this->advertisementRepository->all();

        //$advertisements[0]);

        return view('advertisements.index')->with(['advertisements' => $advertisements]);
    }

    /**
     * Show the form for creating a new advertisement.
     *
     * @return Response
     */
    public function create()
    {
        $data['clients']   = advertisementClients::get()->where('status', '1');
        $data['dimension'] = adDimension::get(['dimension', 'position_name', 'id']);
        //print_r($data); 

        return view('advertisements.create', ['data' => $data]);
    }

    /**
     * Store a newly created advertisement in storage.
     *
     * @param CreateadvertisementRequest $request
     *
     * @return Response
     */
    public function store(CreateadvertisementRequest $request)
    {
        $input = $request->all();

        //print_r($request->file('image'));exit;
        if($request->has('image')) {

            $image            = $request->file('image');
            //print_r($image); exit;
            $image_name       = 'advertisement-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath  = public_path('image/advertisement_image');
            $image_url        = 'public/image/advertisement_image/'.$image_name;
            $image->move($destinationPath, $image_name);

            $input['image']   = $image_url;
        } else {
            return back()->withInput()->withErrors(['Please select the Image']);
        }

        $advertisement = $this->advertisementRepository->create($input);


        Flash::success('Advertisement saved successfully.');

        return redirect(route('advertisements.index'));
    }

    /**
     * Display the specified advertisement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        
        $advertisement = $this->advertisementRepository->findWithoutFail($id);

        if (empty($advertisement)) {
            Flash::error('Advertisement not found');

            return redirect(route('advertisements.index'));
        }

        return view('advertisements.show')->with(['advertisement' => $advertisement]);
    }

    /**
     * Show the form for editing the specified advertisement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $data['dimension'] = adDimension::get(['dimension', 'position_name', 'id']);
        $data['clients']   = advertisementClients::get();

        $advertisement = $this->advertisementRepository->findWithoutFail($id);

        if (empty($advertisement)) {
            Flash::error('Advertisement not found');

            return redirect(route('advertisements.index'));
        }

        return view('advertisements.edit')->with(['advertisement' => $advertisement, 'data' => $data]);
    }

    /**
     * Update the specified advertisement in storage.
     *
     * @param  int              $id
     * @param UpdateadvertisementRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateadvertisementRequest $request)
    {
        $input = $request->all();
        $advertisement = $this->advertisementRepository->findWithoutFail($id);

        if (empty($advertisement)) {
            Flash::error('Advertisement not found');

            return redirect(route('advertisements.index'));
        }

        if($request->has('image')) {
            File::delete($advertisement->image);

            $image            = $request->file('image');
            //print_r($image); exit;
            $image_name       = 'advertisement-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath  = public_path('image/advertisement_image');
            $image_url        = 'public/image/advertisement_image/'.$image_name;
            $image->move($destinationPath, $image_name);

            $input['image']   = $image_url;
        } else {
            $input['image'] = $advertisement->image;
        }

        $advertisement = $this->advertisementRepository->update($input, $id);

        Flash::success('Advertisement updated successfully.');

        return redirect(route('advertisements.index'));
    }

    /**
     * Remove the specified advertisement from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $advertisement = $this->advertisementRepository->findWithoutFail($id);

        if (empty($advertisement)) {
            Flash::error('Advertisement not found');

            return redirect(route('advertisements.index'));
        }
        
        File::delete($advertisement->image);
        DB::select("delete from advertisements where id = '$id'");

        Flash::success('Advertisement deleted successfully.');

        return redirect(route('advertisements.index'));
    }

    public function changeAdvertismenteStatus(Request $r) {

        DB::table('advertisements')
            ->where('id', $r->advertisement_id)
            ->update(['status' => $r->status]);
                    
    }
}
