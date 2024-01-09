<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\GuidelineCreateRequest;
use App\Http\Requests\GuidelineUpdateRequest;
use App\Repositories\GuidelineRepository;

/**
 * Class GuidelinesController.
 *
 * @package namespace App\Http\Controllers;
 */
class GuidelinesController extends Controller
{
    /**
     * @var GuidelineRepository
     */
    protected $repository;

    /**
     * GuidelinesController constructor.
     *
     * @param GuidelineRepository $repository
     */
    public function __construct(GuidelineRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $guidelines = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $guidelines,
            ]);
        }

        return view('guidelines.index', compact('guidelines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GuidelineCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(GuidelineCreateRequest $request)
    {
        try {

            $guideline = $this->repository->create($request->all());

            $response = [
                'message' => 'Guideline created.',
                'data'    => $guideline->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guideline = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $guideline,
            ]);
        }

        return view('guidelines.show', compact('guideline'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guideline = $this->repository->find($id);

        return view('guidelines.edit', compact('guideline'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GuidelineUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(GuidelineUpdateRequest $request, $id)
    {
        try {

            $guideline = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Guideline updated.',
                'data'    => $guideline->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (Exception $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Guideline deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Guideline deleted.');
    }
}
