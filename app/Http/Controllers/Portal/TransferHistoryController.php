<?php

namespace App\Http\Controllers\Portal;

use App\Enums\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\TransferHistory\TransferHistoryRequest;
use App\Mail\SendMailLappiResendStripe;
use App\Services\Portal\TransferHistoryService;
use App\Traits\RealtimeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TransferHistoryController extends Controller
{
    use RealtimeTrait;
    /**
     * @var service
     */
    public $service;

    /**
     * UserController constructor.
     *
     */
    public function __construct()
    {
        $this->service = app(TransferHistoryService::class);
    }

    /**
     * Get data to show in Withdrawal request list.
     *
     * @param TransferHistoryRequest $request
     * @return \Illuminate\View\View|mixed
     */
    public function index(TransferHistoryRequest $request)
    {
        $searchParam = $request->all();
        $data = $this->service->getTransferHistoryList($request);

        return view('portal.modules.withdrawal.list')->with([
            'data' => $data,
            'searchParam' => $searchParam,
        ]);
    }

    public function getCountTransfer(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $data = $this->service->getTransferHistoryCount();

            return response()->json([
                'success' => true,
                'count' => $data['count'],
                'errorBalance' => $data['errorBalance']
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function getErrorLappi(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $data = $this->service->getTransferHistoryError();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function show(Request $request, int $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $data = $this->service->getDetail($id);
            $html = $data ? view('portal.components.realtime.transfer-history', compact('data'))->render() : '';

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerTransfer(Request $request)
    {
        $parts = parse_url(url()->previous());
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
        } else {
            $query = [];
        }
        $data = $this->service->registerTransfer($request->id);
        if ($data) {
            return redirect()->route('portal.transfer-histories', $query)->with('message', Constant::REGISTER_SUCCESS);
        }

        return redirect()->route('portal.transfer-histories', $query)->with('message');
    }

    /**
     * Register transfer.
     *
     * @return mixed
     */
    public function sendmailTransfer(Request $request)
    {
        $parts = parse_url(url()->previous());
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
        } else {
            $query = [];
        }
        $data = $this->service->sendmailTransfer($request->id);

        $this->sendEvent('realtime', [
            'url' => '/portal/transfer-histories',
            'screen' => 'TRANSFER',
            'id' => $request->id
        ]);
        if ($data) {
            return redirect()->route('portal.transfer-histories', $query);
        }

        return redirect()->route('portal.transfer-histories', $query);
    }

    public function tryAgainTransfer(Request $request)
    {
        $parts = parse_url(url()->previous());
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
        } else {
            $query = [];
        }
        Mail::to(config('app.to_mail_report'))->queue(
            new SendMailLappiResendStripe($request->all())
        );
        $this->service->tryAgainTransfer();

        return redirect()->route('portal.transfer-histories', $query)->with('toast', '再振込依頼をしました。');
    }
}
