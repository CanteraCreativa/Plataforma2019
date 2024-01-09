<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SkillCreateRequest;
use App\Http\Requests\SkillUpdateRequest;
use App\Repositories\SkillRepository;

/**
 * Class SkillsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SkillsController extends Controller
{
    /**
     * @var SkillRepository
     */
    protected $repository;

    /**
     * SkillsController constructor.
     *
     * @param SkillRepository $repository
     */
    public function __construct(SkillRepository $repository)
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
        $skills = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $skills,
            ]);
        }

        return view('skills.index', compact('skills'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SkillCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SkillCreateRequest $request)
    {
        try {
            $skill = $this->repository->create($request->all());

            $response = [
                'message' => 'Skill created.',
                'data'    => $skill->toArray(),
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
        $skill = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $skill,
            ]);
        }

        return view('skills.show', compact('skill'));
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
        $skill = $this->repository->find($id);

        return view('skills.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SkillUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(SkillUpdateRequest $request, $id)
    {
        try {
            $skill = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Skill updated.',
                'data'    => $skill->toArray(),
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
                'message' => 'Skill deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Skill deleted.');
    }
}
