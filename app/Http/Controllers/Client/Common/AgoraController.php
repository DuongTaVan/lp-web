<?php

namespace App\Http\Controllers\Client\Common;

use App\Http\Controllers\Controller;
use App\Services\Client\Common\CourseScheduleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\AgoraDynamicKey\RtcTokenBuilder;
use Illuminate\Support\Facades\DB;

class AgoraController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = app(CourseScheduleService::class);
    }

    /**
     * Generate access token from channelName.
     *
     * @param Request $request
     * @return string
     */
    public function token(Request $request)
    {
        \Log::info('Function get token agora');
        DB::connection()->enableQueryLog();
        $diffTime = $request->now ? now()->parse($request->now)->getTimestampMs() - now()->getTimestampMs() : 0;
        $appID = config('app.agora_app_id');
        $appCertificate = config('app.agora_app_certificate');
        $channelName = $request->channelName;
        $csId = $request->csId ?? null;
        $user = auth('client')->id();
        \Log::info('Some one join course', ['cs_id' => $csId, 'user_id' => $user]);
        if (!$channelName || !$csId || !$user) {
            \Log::info('Response', ['diffTime' => $diffTime]);
            return response(['diffTime' => $diffTime]);
        }
        $data = $this->service->addTimeActual($csId);
        $queries = DB::getQueryLog();
        \Log::info('Log sql query', $queries);

        if ($data['isCancel']) {
            \Log::info('Response', [
                'token' => null,
                'isCancel' => $data['isCancel'],
                'actualStartDate' => null,
                'actualEndDate' => null,
            ]);

            return response([
                'token' => null,
                'isCancel' => $data['isCancel'],
                'actualStartDate' => null,
                'actualEndDate' => null,
            ]);
        }
        $role = RtcTokenBuilder::RoleAttendee;
        $privilegeExpiredTs = now()->parse($data['end'])->getTimestamp();
        $response = [
            'token' => RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $user, $role, $privilegeExpiredTs),
            'isCancel' => $data['isCancel'],
            'tokenOk' => $data['tokenOk'],
            'actualStartDate' => $data['start']->toString(),
            'actualEndDate' => $data['end']->toString(),
            'diffTime' => $diffTime
        ];

        \Log::info('Response', $response);

        return response($response);
    }
}
