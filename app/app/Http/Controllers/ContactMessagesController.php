<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ContactMessageCreateRequest;
use App\Http\Requests\ContactMessageUpdateRequest;
use App\Repositories\ContactMessageRepository;

/**
 * Class ContactMessagesController.
 *
 * @package namespace App\Http\Controllers;
 */
class ContactMessagesController extends Controller
{
    /**
     * @var ContactMessageRepository
     */
    protected $repository;

    /**
     * ContactMessagesController constructor.
     *
     * @param ContactMessageRepository $repository
     */
    public function __construct(ContactMessageRepository $repository)
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
        $contactMessages = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $contactMessages,
            ]);
        }

        return view('contactMessages.index', compact('contactMessages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ContactMessageCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ContactMessageCreateRequest $request)
    {
        try {
            $data = $request->all();
            if(is_null($data['message']))
                $data['message'] = '';

            $contactMessage = $this->repository->create($data);

            $response = [
                'message' => 'ContactMessage created.',
                'data'    => $contactMessage->toArray(),
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
        $contactMessage = $this->repository->update(['read' => true], $id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $contactMessage,
            ]);
        }

        return view('contactMessages.show', compact('contactMessage'));
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
        $contactMessage = $this->repository->find($id);

        return view('contactMessages.edit', compact('contactMessage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ContactMessageUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ContactMessageUpdateRequest $request, $id)
    {
        try {
            $contactMessage = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ContactMessage updated.',
                'data'    => $contactMessage->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->route('admin.contact-messages.index')->with('message', $response['message']);
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
                'message' => 'ContactMessage deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->route('admin.contact-messages.index')->with('message', 'ContactMessage deleted.');
    }
}
