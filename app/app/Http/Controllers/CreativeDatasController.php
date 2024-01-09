<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreativeDataCreateRequest;
use App\Http\Requests\CreativeDataUpdateRequest;
use App\Http\Requests\UpdateProfileImageRequest;
use App\Http\Requests\UpdateBackgroundImageRequest;
use App\Repositories\CreativeDataRepository;

/**
 * Class CreativeDatasController.
 *
 * @package namespace App\Http\Controllers;
 */
class CreativeDatasController extends Controller
{
    /**
     * @var CreativeDataRepository
     */
    protected $repository;

    /**
     * CreativeDatasController constructor.
     *
     * @param CreativeDataRepository $repository
     */
    public function __construct(CreativeDataRepository $repository)
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
        $creativeDatas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $creativeDatas,
            ]);
        }

        return view('creativeDatas.index', compact('creativeDatas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreativeDataCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreativeDataCreateRequest $request)
    {
        try {
            $creativeDatum = $this->repository->create($request->all());

            $response = [
                'message' => 'CreativeData created.',
                'data'    => $creativeDatum->fresh()->toArray(),
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
        $creativeDatum = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $creativeDatum,
            ]);
        }

        return view('creativeDatas.show', compact('creativeDatum'));
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
        $creativeDatum = $this->repository->find($id);

        return view('creativeDatas.edit', compact('creativeDatum'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreativeDataUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(CreativeDataUpdateRequest $request, $id)
    {
        try {
            $data = $request->all();
            $request['gender'] = \App\Enums\UserGender::{$request->input('gender')}();
            $request['birth_date'] = (new Carbon($request['birth_date']))->format('Y-m-d');
            $creativeDatum = $this->repository->update($request->except(['skills', 'interests']), $id);
            $creativeDatum->skills()->sync(collect($request->input('skills'))->keyBy('id')->map(function($item) { return [ 'skill_id' => $item['id'], 'level' => $item['level'] ]; }));
            $creativeDatum->interests()->sync($request->input('interests'));

            $response = [
                'message' => 'CreativeData updated.',
                'data'    => $creativeDatum->fresh()->toArray(),
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
                'message' => 'CreativeData deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'CreativeData deleted.');
    }

    public function activate($id)
    {
        $creativeDatum = $this->repository->find($id);
        $creativeDatum->account->user->active = !$creativeDatum->account->user->active;
        $creativeDatum->account->user->save();
        $estado = $creativeDatum->account->user->active ? 'activado' : 'suspendido';
        return redirect()->back()->with('message', 'El usuario ha sido suspendido');
    }


    public function updateProfileImage(UpdateProfileImageRequest $request)
    {
        $creativeData = auth()->user()->account->creativeData;
        $creativeData = $this->repository->update($request->only(['profile_image']), $creativeData->id);

        $response = [
            'message' => 'Imagen de perfil actualizada',
            'data'    => $creativeData->fresh()->toArray(),
        ];

        if ($request->wantsJson()) {
            return response()->json($response);
        }
        return response()->json($response);
        //return redirect()->back()->with('message', $response['message']);
    }

    public function updateBackgroundImage(UpdateBackgroundImageRequest $request)
    {
        $creativeData = auth()->user()->account->creativeData;
        $creativeData = $this->repository->update($request->only(['background_image']), $creativeData->id);

        $response = [
            'message' => 'Imagen de fondo actualizada',
            'data'    => $creativeData->fresh()->toArray(),
        ];

        if ($request->wantsJson()) {
            return response()->json($response);
        }
        return redirect()->back()->with('message', $response['message']);
    }

    public function resendVerificationEmail($id)
    {
        $this->repository->find($id)->account->user->sendEmailVerificationNotification();

        return redirect()->back()->with('message', 'Envío de confirmación exitoso');
    }
}
