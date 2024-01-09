<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use App\Repositories\LogosRepository;
use Illuminate\Http\Request;

class LogosController extends Controller
{
    protected $repository;

    public function __construct(LogosRepository $repository)
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
        $logos = $this->repository->orderBy('order', 'ASC')->all();
        if (request()->wantsJson()) {
            return response()->json(compact('logos'));
        }
        return view('logos.index', compact('logos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('logos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|max:150',
                'url' => 'required',
                'order' => 'required|integer',
                'filepath' => 'required|file'
            ]);

            $logo = $this->repository->create($request->all());

            $response = [
                'message' => 'Logo subido exitosamente',
                'data'    => $logo->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()->route('admin.logos.index')->with('message', $response['message']);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('logos.edit', ['logo' => $this->repository->find($id)]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            $request->validate([
                'name' => 'required|max:150',
                'url' => 'required',
                'order' => 'required|integer',
                'filepath' => 'nullable|file'
            ]);

            $logo = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Logo actualizado exitosamente',
                'data'    => $logo->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()->route('admin.logos.index')->with('message', $response['message']);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->route('admin.logos.index')->with('message', 'Logo eliminado exitosamente');

    }
}
