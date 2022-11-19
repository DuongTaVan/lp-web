<?php

namespace App\Http\Controllers\Portal\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Auth\ResetPasswordRequest;
use App\Http\Requests\Portal\Auth\SendMailRequest;
use App\Services\Portal\PasswordResetService;

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
        return view('portal.auth.send-mail');
    }

    /**
     * Send reset-link email
     *
     * @param SendMailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(SendMailRequest $request)
    {
        return $this->passwordResetService->sendResetLinkEmail($request);
    }

    /**
     * Display a form reset password
     *
     * @param $token
     * @return mixed
     */
    public function showResetForm($token)
    {
        return $this->passwordResetService->showResetForm($token);
    }

    /**
     * Reset new password
     *
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->passwordResetService->resetPassword($request);
    }
}
