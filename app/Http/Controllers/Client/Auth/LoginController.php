<?php

namespace App\Http\Controllers\Client\Auth;

use App\Enums\DBConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use URL;

class LoginController extends Controller
{
    /**
     * Show form login.
     *
     * @return void
     */
    public function showForm()
    {
        return view('client.auth.login');
    }

    /**
     * Login for portal
     *
     * @param LoginRequest $request
     * @param UserRepository $userRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request, UserRepository $userRepository)
    {
        $request->flash();
        $credentials = [
            'email' => $request->input('email'),
            'login_type' => DBConstant::LOGIN_TYPE_EMAIL,
            'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            'registration_status' => DBConstant::REGISTRATION_STATUS_AUTHENTICATED
        ];

        $user = $userRepository->findWhere($credentials)->first();
        if (!$user) {
            return back()->with('error', __('errors.MSG_4015'));
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', __('errors.MSG_4015'));
        }

        \auth()->guard('client')->login($user);

        return redirect()->route('client.home');
    }

    /**
     * Logout for portal
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function logout(Request $request)
    {
        $logoutStatus = Auth::guard('client')->logout();

        if (!$logoutStatus) {
            return redirect(URL::previous());
        }
        $request->session()->flush();

        return redirect()->route('client.home');
    }
}
