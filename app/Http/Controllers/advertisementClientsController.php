<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateadvertisementClientsRequest;
use App\Http\Requests\UpdateadvertisementClientsRequest;
use App\Repositories\advertisementClientsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class advertisementClientsController extends AppBaseController
{
    /** @var  advertisementClientsRepository */
    private $advertisementClientsRepository;

    public function __construct(advertisementClientsRepository $advertisementClientsRepo)
    {
        $this->advertisementClientsRepository = $advertisementClientsRepo;
    }

    /**
     * Display a listing of the advertisementClients.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->advertisementClientsRepository->pushCriteria(new RequestCriteria($request));
        $advertisementClients = $this->advertisementClientsRepository->all();

        return view('advertisement_clients.index')
            ->with('advertisementClients', $advertisementClients);
    }

    /**
     * Show the form for creating a new advertisementClients.
     *
     * @return Response
     */
    public function create()
    {
        return view('advertisement_clients.create');
    }

    /**
     * Store a newly created advertisementClients in storage.
     *
     * @param CreateadvertisementClientsRequest $request
     *
     * @return Response
     */
    public function store(CreateadvertisementClientsRequest $request)
    {
        $input = $request->all();

        $advertisementClients = $this->advertisementClientsRepository->create($input);

        Flash::success('Advertisement Clients saved successfully.');

        return redirect(route('advertisementClients.index'));
    }

    /**
     * Display the specified advertisementClients.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $advertisementClients = $this->advertisementClientsRepository->findWithoutFail($id);

        if (empty($advertisementClients)) {
            Flash::error('Advertisement Clients not found');

            return redirect(route('advertisementClients.index'));
        }

        return view('advertisement_clients.show')->with('advertisementClients', $advertisementClients);
    }

    /**
     * Show the form for editing the specified advertisementClients.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $advertisementClients = $this->advertisementClientsRepository->findWithoutFail($id);

        if (empty($advertisementClients)) {
            Flash::error('Advertisement Clients not found');

            return redirect(route('advertisementClients.index'));
        }

        return view('advertisement_clients.edit')->with('advertisementClients', $advertisementClients);
    }

    /**
     * Update the specified advertisementClients in storage.
     *
     * @param  int              $id
     * @param UpdateadvertisementClientsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateadvertisementClientsRequest $request)
    {
        $advertisementClients = $this->advertisementClientsRepository->findWithoutFail($id);

        if (empty($advertisementClients)) {
            Flash::error('Advertisement Clients not found');

            return redirect(route('advertisementClients.index'));
        }

        $advertisementClients = $this->advertisementClientsRepository->update($request->all(), $id);

        Flash::success('Advertisement Clients updated successfully.');

        return redirect(route('advertisementClients.index'));
    }

    /**
     * Remove the specified advertisementClients from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $advertisementClients = $this->advertisementClientsRepository->findWithoutFail($id);

        if (empty($advertisementClients)) {
            Flash::error('Advertisement Clients not found');

            return redirect(route('advertisementClients.index'));
        }

        $this->advertisementClientsRepository->delete($id);

        Flash::success('Advertisement Clients deleted successfully.');

        return redirect(route('advertisementClients.index'));
    }

    public function toggleClientStatus(Request $r) {
        $client_id     = $r->client_id;
        $client_status = $r->status;

        if($client_status) {
            DB::table('advertisement_clients')->where('id', $client_id)->update(['status' => "1"]);
            DB::table('advertisements')->where('client', $client_id)->update(['status' => "1"]);
        } else {
            DB::table('advertisement_clients')->where('id', $client_id)->update(['status' => "0"]);
            DB::table('advertisements')->where('client', $client_id)->update(['status' => "0"]);                
        }

    }
}
