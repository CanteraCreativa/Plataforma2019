<?php

namespace App\Http\Controllers;

use App\Exports\InscriptionsExport;
use App\Exports\UsersExport;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AnnouncementCreateRequest;
use App\Http\Requests\AnnouncementUpdateRequest;

use App\Repositories\AnnouncementRepository;
use App\Repositories\GuidelineRepository;
use App\Repositories\InterestRepository;
use App\Repositories\SkillRepository;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class AnnouncementsController.
 *
 * @package namespace App\Http\Controllers;
 */
class AnnouncementsController extends Controller
{
    /**
     * @var AnnouncementRepository
     */
    protected $repository;

    /**
     * @var GuidelineRepository
     */
    protected $repository_guideline;

    /**
     * AnnouncementsController constructor.
     *
     * @param AnnouncementRepository $repository
     */
    public function __construct(
        AnnouncementRepository $repository,
        GuidelineRepository $repository_guideline,
        InterestRepository $repository_interest,
        SkillRepository $repository_skill
    )
    {
        $this->repository = $repository;
        $this->repository_guideline = $repository_guideline;
        $this->repository_interest = $repository_interest;
        $this->repository_skill = $repository_skill;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        if ($skill = request()->query('skill')) {
            $this->repository->whereHas('skills', function($q) use ($skill){
                $q->where('announcement_skill.skill_id', (int)$skill);
            });
        }
        if ($interest = request()->query('interest')) {
            $this->repository->whereHas('interests', function($q) use ($interest){
                $q->where('announcement_interest.interest_id', (int)$interest);
            });
        }
        if ($guideline = request()->query('guideline')) {
            $this->repository->whereHas('guidelines', function($q) use ($guideline){
                $q->where('announcement_guideline.guideline_id', (int)$guideline);
            });
        }
        if ($creative = request()->query('creative')) {
            $this->repository->whereHas('subscribers', function($q) use ($creative){
                $q->where('creative_datas.id', (int)$creative);
            });
        }

        if(request()->query('orderby', false)) {
            $this->repository->orderBy(request()->query('orderby', false), 'DESC');
        }

        if (request()->wantsJson()) {

            $announcements = $this->repository->findWhere(['active' => 1]);

            return response()->json([
                'data' => $announcements,
            ]);
        }

        $announcements = $this->repository->all();

        return view('announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guidelines = $this->repository_guideline->all();
        $interests = $this->repository_interest->all();
        $skills = $this->repository_skill->all();

        return view('announcements.create')->with([
            'guidelines' => $guidelines,
            'interests' => $interests,
            'skills' => $skills,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AnnouncementCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AnnouncementCreateRequest $request)
    {
        try {

            $announcement = $this->repository->create($this->getWithDefaultData($request->all()));

            $announcement->guidelines()->sync($request->input('guidelines'));
            $announcement->skills()->sync($request->input('skills'));
            $announcement->interests()->sync($request->input('interests'));

            $response = [
                'message' => 'Convocatoria creada.',
                'data'    => $announcement->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->route('admin.announcements.index')->with('message', $response['message']);
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
        $announcement = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $announcement,
            ]);
        }

        return view('announcements.show', compact('announcement'));
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
        $announcement = $this->repository->find($id);

        $guidelines = $this->repository_guideline->all();
        $interests = $this->repository_interest->all();
        $skills = $this->repository_skill->all();

        return view('announcements.edit')->with([
            'announcement' => $announcement,
            'guidelines'   => $guidelines,
            'interests'    => $interests,
            'skills'       => $skills,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AnnouncementUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(AnnouncementUpdateRequest $request, $id)
    {
        try {

            $announcement = $this->repository->update($this->getWithDefaultData($request->all()), $id);

            $announcement->guidelines()->sync($request->input('guidelines'));
            $announcement->skills()->sync($request->input('skills'));
            $announcement->interests()->sync($request->input('interests'));

            // TODO: delete previous files (image_thumbnail, image_banner, file_rules) if they are updated

            $response = [
                'message' => 'Convocatoria actualizada.',
                'data'    => $announcement->toArray(),
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
                'message' => 'Convocatoria eliminada.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->route('admin.announcements.index')->with('message', 'Convocatoria eliminada.');
    }

    public function activate($id)
    {
        $announcement = $this->repository->find($id);
        $announcement->active = !$announcement->active;
        $announcement->save();
        $estado = $announcement->active ? 'activada' : 'suspendida';
        return redirect()->back()->with('message', 'La convocatoria ha sido '.$estado);
    }


    public function subscribe($id)
    {
        $announcement = $this->repository->find($id);

        $user = auth()->user();
        $endDate = Carbon::createFromFormat('Y-m-d', $announcement->end_date)->add('1 day');
        if (\Carbon\Carbon::today() > $endDate) {
            return response()->json([
                'error'   => true,
                'message' => 'El período para suscribirse a esta convocatoria ya cerró'
            ], 422);
        }

        $subscribed = $user->account->creativeData->subscriptions()->toggle([$announcement->id]);

        return response()->json([
            'data' => [
                'subscribed' => in_array($id, $subscribed["attached"])
            ]
        ]);
    }

    public function exportInscriptions()
    {
        return Excel::download(new InscriptionsExport(), 'inscriptions.xlsx');
    }

    private function getWithDefaultData($data)
    {
        $data['first_prize'] = isset($data['first_prize']) ? $data['first_prize'] : 0;
        $data['second_prize'] = isset($data['second_prize']) ? $data['second_prize'] : 0;
        $data['third_prize'] = isset($data['third_prize']) ? $data['third_prize'] : 0;
        $data['image_banner'] = isset($data['image_banner']) ? $data['image_banner'] : '';
        return $data;
    }
}
