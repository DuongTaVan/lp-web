<?php

namespace App\Http\Controllers\Client\Auth;

use App\Enums\Constant;
use App\Http\Controllers\Controller;
use App\Services\Client\Auth\SocialiteService;
use Illuminate\Http\Request;

class SocialiteController extends Controller
{
    /**
     * @var SocialiteService
     */
    protected $socialiteService;

    /**
     * SocialiteController constructor.
     * @param SocialiteService $socialiteService
     */
    public function __construct(SocialiteService $socialiteService)
    {
        $this->socialiteService = $socialiteService;
    }

    /**
     * Get url redirect
     *
     * @param Request $request
     * @param $service
     * @return mixed
     */
    public function getUrlRedirect(Request $request, $service)
    {
        return $this->socialiteService->getUrlRedirect($request->all(), $service);
    }

    /**
     * Handle call back social
     *
     * @param Request $request
     * @param $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleCallBack(Request $request, $service)
    {
        if (session('errors')) {
            return view('client.auth.register-less-twenty-year-old')->with('social', true);
        }

        return $this->socialiteService->handleCallBack($request->all(), $service);
    }
}
