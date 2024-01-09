<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\InscriptionCreateRequest;
use App\Http\Requests\InscriptionUpdateRequest;
use App\Repositories\InscriptionRepository;

/**
 * Class InscriptionsController.
 *
 * @package namespace App\Http\Controllers;
 */
class InscriptionsController extends Controller
{
    /**
     * @var InscriptionRepository
     */
    protected $repository;

    /**
     * InscriptionsController constructor.
     *
     * @param InscriptionRepository $repository
     */
    public function __construct(InscriptionRepository $repository)
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
        $inscriptions = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $inscriptions,
            ]);
        }

        return view('inscriptions.index', compact('inscriptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  InscriptionCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InscriptionCreateRequest $request)
    {
        try {

            $inscription = $this->repository->create($request->all());

            $response = [
                'message' => 'Inscription created.',
                'data'    => $inscription->toArray(),
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
        $inscription = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $inscription,
            ]);
        }

        return view('inscriptions.show', compact('inscription'));
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
        $inscription = $this->repository->find($id);

        return view('inscriptions.edit', compact('inscription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  InscriptionUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(InscriptionUpdateRequest $request, $id)
    {
        try {

            $inscription = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Inscription updated.',
                'data'    => $inscription->toArray(),
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
                'message' => 'Inscription deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Inscription deleted.');
    }
}
