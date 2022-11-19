<?php

namespace App\Http\Controllers\Client\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Client\Teacher\BankMasterService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class AutoCompleteController extends Controller
{
    private $bankMasterService;

    public function __construct()
    {
        $this->bankMasterService = app(BankMasterService::class);
    }

    /**
     * @return Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     * @throws \Throwable
     */
    public function bankAutocomplete(Request $request)
    {
        if ($request->ajax()) {
            $text = $request->text ?? null;
            $data = $this->bankMasterService->getDataBank($text);
            $html = null;
            if (count($data) > 0) {
                $html = view('client.screen.teacher-register.list-data-bank', compact('data'))->render();
            }
            echo response(['html' => $html]);
        }
    }

    /**
     * @param Request $request
     * @return Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     * @throws \Throwable
     */
    public function branchAutocomplete(Request $request)
    {
        if ($request->ajax()) {
            $bank = $request->bank ?? null;
            $text = $request->text ?? null;
            $data = $this->bankMasterService->getDataBranch($bank, $text);
            $html = null;
            if (count($data) > 0) {
                $html = view('client.screen.teacher-register.list-data-bank', compact('data'))->render();
            }

            return response(['html' => $html]);
        }
    }
}
