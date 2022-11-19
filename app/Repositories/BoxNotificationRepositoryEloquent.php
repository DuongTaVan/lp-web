<?php

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BoxNotificationRepository;
use App\Models\BoxNotification;

/**
 * Class BoxNotificationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BoxNotificationRepositoryEloquent extends BaseRepository implements BoxNotificationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BoxNotification::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     * @return mixed
     * @throws ValidatorException
     *
     */
    public function createBoxNotification(array $attributes, int $boxNotificationTransContentId)
    {
        foreach ($attributes as $user) {
            $this->create([
                "user_id" => $user['user_id'],
                "box_notification_master_content_id" => null,
                "box_notification_trans_content_id" => $boxNotificationTransContentId,
                "is_read" => DBConstant::BOX_NOTIFICATION_IS_READ['not_read'],
                "read_at" => null
            ]);
        }

        return true;
    }

    /**
     * Get box notification
     *
     * @param $data
     * @return mixed
     */
    public function getBoxNotificationList($data)
    {
        // Request params
        return $this->model
            ->leftJoin(
                'box_notification_master_contents',
                'box_notifications.box_notification_master_content_id',
                '=',
                'box_notification_master_contents.box_notification_master_content_id'
            )
            ->leftJoin(
                'box_notification_trans_contents',
                'box_notifications.box_notification_trans_content_id',
                '=',
                'box_notification_trans_contents.box_notification_trans_content_id'
            )
            ->where('box_notifications.user_id', $data)
            ->select(
                'box_notifications.id',
                'box_notification_trans_contents.title as title',
                'box_notification_trans_contents.body as body',
                'box_notifications.is_read as is_read',
                'box_notifications.created_at as created_at')
            ->where('to_type', DBConstant::BOX_NOTIFICATION_TRANS_CONTENT_TYPE['to_all'])
            ->orderBy('box_notifications.created_at', Constant::ORDER_BY_DESC)
            ->get();
    }

    /**
     * Get box notification.
     *
     * @return mixed
     */
    public function getBoxNotificationUnRead()
    {
        return $this->model->where([
            'user_id' => auth('client')->user()->user_id,
            'is_read' => DBConstant::BOX_NOTIFICATION_IS_READ['not_read']
        ])->join(
            'box_notification_trans_contents as bn',
            'bn.box_notification_trans_content_id',
            '=',
            'box_notifications.box_notification_trans_content_id'
        )
            ->where('to_type', DBConstant::BOX_NOTIFICATION_TRANS_CONTENT_TYPE['to_all'])
            ->selectRaw('box_notifications.*, bn.title, bn.body')
            ->orderBy('created_at', Constant::ORDER_BY_DESC)
            ->get();
    }

    /**
     *  Update read flag
     *
     * @param $boxNoticeIds
     * @return array
     */
    public function updateReadFlag(array $boxNoticeIds)
    {
        if (count($boxNoticeIds) > 0) {
            return $this->model
                ->where([
                    'user_id' => auth('client')->id(),
                ])
                ->whereIn('id', $boxNoticeIds)
                ->update(['is_read' => DBConstant::BOX_NOTIFICATION_IS_READ['read']]);
        } else {
            return $this->model
                ->where([
                    'user_id' => auth('client')->id(),
                    'is_read' => DBConstant::BOX_NOTIFICATION_IS_READ['not_read']
                ])
                ->update(['is_read' => DBConstant::BOX_NOTIFICATION_IS_READ['read']]);
        }

    }

    /**
     * Get box notification
     *
     * @param $boxNotificationId
     * @return mixed
     */
    public function getBoxNotificationById($boxNotificationId)
    {
        return $this->model
            ->leftJoin(
                'box_notification_master_contents',
                'box_notifications.box_notification_master_content_id',
                '=',
                'box_notification_master_contents.box_notification_master_content_id'
            )
            ->leftJoin(
                'box_notification_trans_contents',
                'box_notifications.box_notification_trans_content_id',
                '=',
                'box_notification_trans_contents.box_notification_trans_content_id'
            )
            ->where('box_notifications.id', $boxNotificationId)
            ->select(
                'id',
                DB::raw("CONCAT_WS('', box_notification_master_contents.title, box_notification_trans_contents.title) as title"),
                DB::raw("CONCAT_WS('', box_notification_master_contents.body, box_notification_trans_contents.body) as body"),
                'box_notifications.created_at', 'box_notifications.is_read'
            )
            ->first();
    }

    /**
     * Get list notifications by option
     *
     * @param $request
     * @return array
     */
    public function getNotificationList($request)
    {
        $isOption = $this->isOptionNotification($request);
        $result = $this->getBoxNotificationListByOption($isOption);

        return $result;
    }

    /**
     * Get list notifications
     *
     * @param $data
     *
     * @return array
     */
    public function getBoxNotificationListByOption($data)
    {
        $listMessage = $this->model
            ->leftJoin(
                'box_notification_master_contents',
                'box_notifications.box_notification_master_content_id',
                '=',
                'box_notification_master_contents.box_notification_master_content_id'
            )
            ->leftJoin(
                'box_notification_trans_contents',
                'box_notifications.box_notification_trans_content_id',
                '=',
                'box_notification_trans_contents.box_notification_trans_content_id'
            )
            ->whereBetween('box_notifications.created_at', [$data['startDate'], $data['endDate']])
            ->where('box_notifications.user_id', auth()->guard('client')->user()->user_id)
            ->where('to_type', DBConstant::BOX_NOTIFICATION_TRANS_CONTENT_TYPE['to_teacher'])
            ->select('box_notifications.id', 'box_notification_trans_contents.title as title', 'box_notification_trans_contents.body as body', 'box_notifications.is_read as is_read',
                'box_notifications.created_at as created_at', 'box_notification_trans_contents.delivered_at')
            ->groupby('box_notifications.id')
            ->orderBy('box_notifications.id', $data['orderBy'])
            ->paginate(Constant::PER_PAGE_DEFAULT);
        return [
            'dataOption' => $data,
            'notifications' => $listMessage,
        ];
    }

    /**
     * Check Option From Request.
     *
     * @param $request
     *
     * @return array
     */
    public function isOptionNotification($request)
    {
        if (isset($request->month) && isset($request->year) && Constant::MESSAGE_LIST_ASC == $request->option) {
            $date = $request->year . '/' . $request->month . '/01';
            $data = [
                'startDate' => Carbon::parse($date)->startOfMonth()->startOfDay()->toDateTime(),
                'endDate' => Carbon::parse($date)->endOfMonth()->endOfDay()->toDateTime(),
                'year' => $request->year,
                'month' => $request->month,
                'orderBy' => Constant::MESSAGE_BY_ASC,
            ];
        } elseif (isset($request->option) && !empty($request->option) && Constant::MESSAGE_LIST_ASC == $request->option) {
            $data = [
                'startDate' => Carbon::now()->startOfMonth()->startOfDay()->toDateTime(),
                'endDate' => Carbon::now()->endOfMonth()->endOfDay()->toDateTime(),
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
                'orderBy' => Constant::MESSAGE_BY_ASC,
            ];
        } elseif (isset($request->month)) {
            $date = $request->year . '/' . $request->month . '/01';
            $data = [
                'startDate' => Carbon::parse($date)->startOfMonth()->startOfDay()->toDateTime(),
                'endDate' => Carbon::parse($date)->endOfMonth()->endOfDay()->toDateTime(),
                'year' => $request->year,
                'month' => $request->month,
                'orderBy' => Constant::MESSAGE_BY_DESC,
            ];
        } else {
            $data = [
                'startDate' => Carbon::now()->startOfMonth()->startOfDay()->toDateTime(),
                'endDate' => Carbon::now()->endOfMonth()->endOfDay()->toDateTime(),
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
                'orderBy' => Constant::MESSAGE_BY_DESC,
            ];
        }

        return $data;
    }

    public function getUnReadNotification()
    {
        return $this->model
            ->join(
                'box_notification_trans_contents as bn',
                'bn.box_notification_trans_content_id',
                '=',
                'box_notifications.box_notification_trans_content_id'
            )
            ->where('user_id', auth()->guard('client')->user()->user_id)
            ->where('is_read', DBConstant::MESSAGE_NOT_READ)
            ->where('to_type', DBConstant::BOX_NOTIFICATION_TRANS_CONTENT_TYPE['to_teacher'])
            ->count();
    }
}
