<?php

namespace App\Http\Controllers;

use App\Exports\SubmissionsExport;
use App\Models\CreativeData;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SubmissionCreateRequest;
use App\Http\Requests\SubmissionUpdateRequest;
use App\Repositories\SubmissionRepository;

use App\Models\Submission;
use Illuminate\Routing\UrlGenerator;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class SubmissionsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SubmissionsController extends Controller
{
    /**
     * @var SubmissionRepository
     */
    protected $repository;

    /**
     * SubmissionsController constructor.
     *
     * @param SubmissionRepository $repository
     */
    public function __construct(SubmissionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($creativeDataId = false)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        if (auth()->user()->hasRole('admin')) {
            $submissions = $this->repository->all();
        } else {
            $submissions = [];
            $auxSubmissions = $this->repository->orderBy('created_at', 'desc')->fromUser(auth()->user());
            foreach ($auxSubmissions as $submission) {
                if ($submission->active)
                    $submissions[] = $submission;
            }
        }

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $submissions,
            ]);
        }

        return view('submissions.index', compact('submissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SubmissionCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SubmissionCreateRequest $request, \App\Models\Announcement $announcement)
    {
        $user = auth()->user();

        if (date('Y-m-d') > $announcement->end_date) {
            return response()->json([
                'error'   => true,
                'message' => 'El período para subir Piezas ya cerró'
            ], 422);
        }

        $inscription = \App\Models\Inscription::where('creative_data_id', $user->account->creativeData->id)
            ->where('announcement_id', $announcement->id)->first();

        if (! $inscription ) {
            return response()->json([
                'error'   => true,
                'message' => 'Creative not subscribed to Announcement'
            ], 422);
        }

        $request['inscription_id'] = $inscription->id;

        try {
            $submission = $this->repository->create($request->except(['skills']));
            $submission->skills()->sync($request->input('skills'));

            $response = [
                'message' => 'Submission created.',
                'data'    => $submission->toArray(),
            ];

            $user->notifySubmissionStored($submission);

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
        if (auth()->user()->hasRole('admin')) {
            $submission = $this->repository->find($id);
        } else {
            $submission = $this->repository->fromUser(auth()->user())->find($id);
        }

        if (! $submission) {
            abort(404, "No query results for model [App\\Models\\Submissions] ${id}");
        }

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $submission,
            ]);
        }

        return view('submissions.show', compact('submission'));
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
        $submission = $this->repository->find($id);

        return view('submissions.edit', compact('submission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SubmissionUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(SubmissionUpdateRequest $request, $id)
    {
        try {

            $submission = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Submission updated.',
                'data'    => $submission->toArray(),
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
    public function destroy(Submission $submission)
    {

        $deleted = $this->repository->delete($submission->id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Submission deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Submission deleted.');
    }

    public function activate($id)
    {
        $submission = $this->repository->find($id);
        $submission->active = !$submission->active;
        $submission->save();
        $estado = $submission->active ? 'activada' : 'suspendida';
        return redirect()->back()->with('message', 'La idea ha sido '.$estado);
    }

    public function export()
    {
        return Excel::download(new SubmissionsExport(), 'submissions.xlsx');
    }

    public function download(Request $request)
    {
        $submission = $this->repository->find(base64_decode($request->input('id')));

        if (is_null($submission)) {
            abort(401);
        }

        return view('submissions.show_image', compact('submission'));
    }
}
