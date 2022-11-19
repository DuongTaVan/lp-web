<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Enums\Constant;
use App\Http\Requests\Portal\BoxNotificationTransContent\CreateRequest;
use App\Services\Portal\BoxNotificationTransContentService;
use Illuminate\Http\Request;

/**
 * Class BoxNotificationTransContentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class BoxNotificationTransContentsController extends Controller
{
    /**
     * BoxNotificationTransContentsController constructor.
     *
     * @param BoxNotificationTransContentService $service
     */
    public function __construct(BoxNotificationTransContentService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BoxNotificationCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $data = $this->service->createData($request);
        if ($data) {
            return redirect()->route('portal.box-notification-trans-contents.index')
                ->with('message', trans('message.box_notification_create_success'));
        }

        return redirect()->route('portal.box-notification-trans-contents.create')->with('message', trans('message.box_notification_fail'));
    }


    /**
     * Create now box notification
     *
     * @return void
     */
    public function create()
    {
        return view("portal.modules.box-notification.createBoxNotification");
    }

    public function index(Request $request)
    {
        $data = $this->service->getListBoxNotification($request);
        $searchParams = $request->all();
        $request->flash();
        return view('portal.modules.box-notification.list')->with([
            'data' => $data,
            'searchParams' => $searchParams,
        ]);
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        return view('portal.modules.box-notification.detail')->with([
            'data' => $data
        ]);
    }
}
