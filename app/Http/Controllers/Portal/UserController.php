<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\UserListRequest;
use App\Services\Portal\UserService;
use App\Traits\RealtimeTrait;

class UserController extends Controller
{
    use RealtimeTrait;
    /**
     * @var UserService
     */
    public $userService;


    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show user list
     *
     * @param UserListRequest $request
     * @return int
     */
    public function index(UserListRequest $request)
    {
        $users = $this->userService->getData($request);

        return view('portal.modules.users.index')->with([
            'data' => $users,
        ]);
    }

    /**
     * Show user detail.
     *
     * @param $userId
     * @return mixed
     */
    public function show($userId)
    {
        $user = $this->userService->getUserDetail($userId);

        return view('portal.modules.users.user-detail')->with([
            'user' => $user,
        ]);
    }

    /**
     * Show user detail.
     *
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function readConnectVerification(int $userId)
    {
        $parts = parse_url(url()->previous());
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
        }else {
            $query = [];
        }
        $this->userService->readConnectVerification($userId);
        try {
            $this->sendEvent('realtime', [
                'url' => '/portal/identity/identity-verification-image',
                'screen' => 'IDENTITY',
                'id' => $userId
            ]);
        } catch (\Exception $e) {}

        return redirect()->route('portal.identity.identity-verification-image', $query)->with('message', trans('message.box_notification_create_success'));
    }
}
