<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\InterestCreateRequest;
use App\Http\Requests\InterestUpdateRequest;
use App\Repositories\InterestRepository;

/**
 * Class InterestsController.
 *
 * @package namespace App\Http\Controllers;
 */
class InterestsController extends Controller
{
    /**
     * @var InterestRepository
     */
    protected $repository;

    /**
     * InterestsController constructor.
     *
     * @param InterestRepository $repository
     */
    public function __construct(InterestRepository $repository)
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
        $interests = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $interests,
            ]);
        }

        return view('interests.index', compact('interests'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  InterestCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InterestCreateRequest $request)
    {
        try {
            $interest = $this->repository->create($request->all());

            $response = [
                'message' => 'Interest created.',
                'data'    => $interest->toArray(),
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
        $interest = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $interest,
            ]);
        }

        return view('interests.show', compact('interest'));
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
        $interest = $this->repository->find($id);

        return view('interests.edit', compact('interest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  InterestUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(InterestUpdateRequest $request, $id)
    {
        try {
            $interest = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Interest updated.',
                'data'    => $interest->toArray(),
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
                'message' => 'Interest deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Interest deleted.');
    }
}
