<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\ResetPassword;
use App\Services\Portal\PasswordResetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class ResetPasswordController extends Controller
{
    /**
     * @var PasswordResetService
     */
    public $passwordResetService;

    /**
     * ResetPasswordController constructor.
     * @param PasswordResetService $service
     */
    public function __construct(PasswordResetService $service)
    {
        $this->passwordResetService = $service;
    }

    /**
     * Display a form send link password
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('client.auth.reset-password');
    }

    /**
     * Send reset-link email
     *
     * @return RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        return $this->passwordResetService->sendMailResetClient($request);
    }

    /**
     * Display a form reset password
     *
     * @param $token
     * @return mixed
     */
    public function showResetForm($token)
    {
        return $this->passwordResetService->showResetFormClient($token);
    }

    /**
     * Reset new password
     *
     * @param ResetPassword $request
     * @return RedirectResponse
     */
    public function resetPassword(ResetPassword $request)
    {
        return $this->passwordResetService->resetPasswordClient($request);
    }
}
