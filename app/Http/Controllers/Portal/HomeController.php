<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\HomeRequest;
use App\Services\Portal\HomeService;

class HomeController extends Controller
{
    /**
     * Get data to show in dashboard
     *
     * @param HomeRequest $request
     * @param HomeService $homeService
     * @return \Illuminate\View\View|mixed
     */
    public function index(HomeRequest $request, HomeService $homeService)
    {
        $now = now()->parse($request->month);
        $periods = [$now->format('m'), $now->format('Y')];
        $searchParams = $request->all();
        $data = $homeService->getData($request);
        return view('portal.home.index')->with([
            'data' => $data,
            'date' => $periods,
            'searchParams' => $searchParams,
        ]);
    }
}
