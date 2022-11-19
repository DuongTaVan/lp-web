<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\ActiveAccountRequest;
use App\Http\Requests\Client\Auth\RegisterRequest;
use App\Http\Requests\Client\Auth\ResendEmailRequest;
use App\Services\Client\Common\ClientService;
use Illuminate\Http\RedirectResponse;
use URL;

class RegisterController extends Controller
{
    /**
     * @var ClientService
     */
    private $clientService;

    /**
     * RegisterController constructor.
     *
     * @param ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * Show form register.
     *
     * @return void
     */
    public function showForm()
    {
        return view('client.auth.register');
    }

    /**
     * Handle register
     *    * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function handleRegister(RegisterRequest $request)
    {
        $request->flash();
        return $this->clientService->register($request);
    }

    /**
     * Show form register less twenty years old.
     *
     * @param $userId
     * @return void
     */
    public function showFormRegisterLessTwenty($userId = null)
    {
        if ($userId) {
            $user = $this->clientService->findUserNotAuthenticated($userId);
            return view('client.auth.register-less-twenty-year-old', ['user' => $user]);
        }
        return view('client.auth.register-less-twenty-year-old');
    }

    /**
     * Active account
     *
     * @param ActiveAccountRequest $request
     *
     * @return RedirectResponse
     */
    public function activeAccount(ActiveAccountRequest $request)
    {
        $result = $this->clientService->activeAccount($request);
        if (!$result['success']) {
            return redirect()->route('client.register-form')->with('error', $result['message']);
        }
        $userTypeRequest = \Request::get('user_type') ? \Request::get('user_type') : null;
        if (null !== \Request::get('change_email')) {
            return redirect()->route('client.home');
        }

        return view('client.auth.register-complete')->with(['user_type' => $userTypeRequest]);
    }

    /**
     * Resend email
     *
     * @param ResendEmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendEmail(ResendEmailRequest $request)
    {
        $result = $this->clientService->resendEmail($request);
        if (!$result['success']) {
            return response()->json(['message' => 'error']);
        }

        return response()->json(['message' => 'success']);
    }
}
