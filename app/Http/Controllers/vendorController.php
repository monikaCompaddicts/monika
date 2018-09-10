<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatevendorRequest;
use App\Http\Requests\UpdatevendorRequest;
use App\Repositories\vendorRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class vendorController extends AppBaseController
{
    /** @var  vendorRepository */
    private $vendorRepository;

    public function __construct(vendorRepository $vendorRepo)
    {
        $this->vendorRepository = $vendorRepo;
    }

    /**
     * Display a listing of the vendor.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->vendorRepository->pushCriteria(new RequestCriteria($request));
        $vendors = $this->vendorRepository->all();

        return view('vendors.index')
            ->with('vendors', $vendors);
    }

    /**
     * Show the form for creating a new vendor.
     *
     * @return Response
     */
    public function create()
    {
        return view('vendors.create');
    }

    /**
     * Store a newly created vendor in storage.
     *
     * @param CreatevendorRequest $request
     *
     * @return Response
     */
    public function store(CreatevendorRequest $request)
    {
        $input = $request->all();

        $vendor = $this->vendorRepository->create($input);

        Flash::success('Vendor saved successfully.');

        return redirect(route('vendors.index'));
    }

    /**
     * Display the specified vendor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $vendor = $this->vendorRepository->findWithoutFail($id);

        if (empty($vendor)) {
            Flash::error('Vendor not found');

            return redirect(route('vendors.index'));
        }

        return view('vendors.show')->with('vendor', $vendor);
    }

    /**
     * Show the form for editing the specified vendor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $vendor = $this->vendorRepository->findWithoutFail($id);

        if (empty($vendor)) {
            Flash::error('Vendor not found');

            return redirect(route('vendors.index'));
        }

        return view('vendors.edit')->with('vendor', $vendor);
    }

    /**
     * Update the specified vendor in storage.
     *
     * @param  int              $id
     * @param UpdatevendorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatevendorRequest $request)
    {
        $vendor = $this->vendorRepository->findWithoutFail($id);

        if (empty($vendor)) {
            Flash::error('Vendor not found');

            return redirect(route('vendors.index'));
        }

        $vendor = $this->vendorRepository->update($request->all(), $id);

        Flash::success('Vendor updated successfully.');

        return redirect(route('vendors.index'));
    }

    /**
     * Remove the specified vendor from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $vendor = $this->vendorRepository->findWithoutFail($id);

        if (empty($vendor)) {
            Flash::error('Vendor not found');

            return redirect(route('vendors.index'));
        }

        $this->vendorRepository->delete($id);

        Flash::success('Vendor deleted successfully.');

        return redirect(route('vendors.index'));
    }
}
