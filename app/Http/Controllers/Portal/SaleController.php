<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\SaleRequest;
use App\Services\Portal\SaleService;

class SaleController extends Controller
{
    /**
     * Get data to show in dashboard
     *
     * @param SaleRequest $request
     * @param SaleService $saleService
     * @return \Illuminate\View\View|mixed
     */
    public function index(SaleRequest $request, SaleService $saleService)
    {
        $request->flash();
        $searchParam = $request->all();
        $data = $saleService->getSalesData($request);

        return view('portal.modules.sale-detail.list')->with([
            'data' => $data,
            'searchParam' => $searchParam,
        ]);
    }
}
