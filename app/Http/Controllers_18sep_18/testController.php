<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatetestRequest;
use App\Http\Requests\UpdatetestRequest;
use App\Repositories\testRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class testController extends AppBaseController
{
    /** @var  testRepository */
    private $testRepository;

    public function __construct(testRepository $testRepo)
    {
        $this->testRepository = $testRepo;
    }

    /**
     * Display a listing of the test.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->testRepository->pushCriteria(new RequestCriteria($request));
        $tests = $this->testRepository->all();

        return view('tests.index')
            ->with('tests', $tests);
    }

    /**
     * Show the form for creating a new test.
     *
     * @return Response
     */
    public function create()
    {
        return view('tests.create');
    }

    /**
     * Store a newly created test in storage.
     *
     * @param CreatetestRequest $request
     *
     * @return Response
     */
    public function store(CreatetestRequest $request)
    {
        $input = $request->all();

        $test = $this->testRepository->create($input);

        Flash::success('Test saved successfully.');

        return redirect(route('tests.index'));
    }

    /**
     * Display the specified test.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $test = $this->testRepository->findWithoutFail($id);

        if (empty($test)) {
            Flash::error('Test not found');

            return redirect(route('tests.index'));
        }

        return view('tests.show')->with('test', $test);
    }

    /**
     * Show the form for editing the specified test.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $test = $this->testRepository->findWithoutFail($id);

        if (empty($test)) {
            Flash::error('Test not found');

            return redirect(route('tests.index'));
        }

        return view('tests.edit')->with('test', $test);
    }

    /**
     * Update the specified test in storage.
     *
     * @param  int              $id
     * @param UpdatetestRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatetestRequest $request)
    {
        $test = $this->testRepository->findWithoutFail($id);

        if (empty($test)) {
            Flash::error('Test not found');

            return redirect(route('tests.index'));
        }

        $test = $this->testRepository->update($request->all(), $id);

        Flash::success('Test updated successfully.');

        return redirect(route('tests.index'));
    }

    /**
     * Remove the specified test from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $test = $this->testRepository->findWithoutFail($id);

        if (empty($test)) {
            Flash::error('Test not found');

            return redirect(route('tests.index'));
        }

        $this->testRepository->delete($id);

        Flash::success('Test deleted successfully.');

        return redirect(route('tests.index'));
    }
}
