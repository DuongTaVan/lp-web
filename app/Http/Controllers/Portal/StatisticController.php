<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\StatisticRequest;
use App\Http\Requests\Portal\TermStatisticRequest;
use App\Services\Portal\StatisticService;

class StatisticController extends Controller
{
    /**
     * Get data to show in dashboard
     *
     * @param StatisticRequest $request
     * @param StatisticService $statisticService
     * @return \Illuminate\View\View|mixed
     */
    public function index(StatisticRequest $request, StatisticService $statisticService)
    {
        $request->flash();
        $searchParam = $request->all();
        $data = $statisticService->getStatisticsData($request);
        return view('portal.modules.statistic.statisticList')->with([
            'data' => $data,
            'searchParam' => $searchParam,
        ]);
    }

    /**
     * Get data to show in dashboard
     *
     * @param TermStatisticRequest $request
     * @param StatisticService $statisticService
     * @return \Illuminate\View\View|mixed
     */
    public function termStatistic(TermStatisticRequest $request, StatisticService $statisticService)
    {
        $searchParam = $request->all();
        $year = $request->year ?? now()->year;
        $data = $statisticService->getTermStatisticsData($request);

        return view('portal.modules.term-statistic.list')->with([
            'data' => $data,
            'searchParam' => $searchParam,
            'year' => $year,
        ]);
    }
}
