<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteContentCreateRequest;
use App\Http\Requests\SiteContentUpdateRequest;
use App\Repositories\SiteContentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SiteContentController extends Controller
{
    /**
     * @var SiteContentRepository
     */
    protected $repository;

    public function __construct(SiteContentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $content = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $content,
            ]);
        }

        return view('site_content.index', compact('content'));
    }

    public function create()
    {
        return view('site_content.create');
    }

    public function store(SiteContentCreateRequest $request)
    {
        try {
            $data = $request->all();

            $data['slug'] = $this->getSlug(Str::slug($data['title']));

            $content = $this->repository->create($data);

            $response = [
                'message' => 'Convocatoria creada.',
                'data'    => $content->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()->route('admin.site_content.index')->with('message', $response['message']);
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    private function getSlug($slug)
    {
        $x = 2;
        $slugAux = $slug;
        $content = $this->repository->findWhere(['slug' => $slug]);
        while ($content->count()) {
            $slugAux = $slug.'-'.$x;
            $content = $this->repository->findWhere(['slug' => $slugAux]);
            $x++;
        }

        return $slugAux;

    }

    public function show($slug)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $content = $this->repository->findByField('slug', $slug);

        if (request()->wantsJson()) {

            return response()->json([
                'success' => boolval($content->count()),
                'content' => $content->first(),
            ]);
        }
    }

    public function edit($id)
    {
        $content = $this->repository->find($id);

        return view('site_content.edit')->with([
            'content' => $content,
        ]);
    }

    public function update(SiteContentUpdateRequest $request, $id)
    {
        try {

            $content = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Convocatoria actualizada.',
                'data'    => $content->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (\Exception $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Página eliminada.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->route('admin.site_content.index')->with('message', 'Página eliminada.');
    }
}
