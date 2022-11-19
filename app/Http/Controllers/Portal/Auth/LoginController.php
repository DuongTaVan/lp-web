<?php

namespace App\Http\Controllers\Portal\Auth;

use App\Enums\DBConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
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
        return view('portal.auth.login');
    }

    /**
     * Login for portal
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $request->flash();
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'is_archived' => DBConstant::NOT_ARCHIVED_FLAG
        ];

        if (!Auth::guard('portal')->attempt($credentials, true)) {
            return back()->with('message', __('errors.MSG_4016'));
        }

        return redirect()->route('portal.dashboard');
    }

    /**
     * Logout for portal
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function logout()
    {
        $logoutStatus = Auth::guard('portal')->logout();

        if (!$logoutStatus) {
            return redirect(URL::previous());
        }

        return redirect()->route('login');
    }
}
