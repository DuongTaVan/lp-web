<?php

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\BoxNotificationTransContent;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BoxNotificationTransContentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BoxNotificationTransContentRepositoryEloquent extends BaseRepository implements BoxNotificationTransContentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BoxNotificationTransContent::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Store data not delivered.
     *
     * @return
     */
    public function getRecordsNotDelivered()
    {
        return $this->model
            ->where([
                ['scheduled_at', '<=', now()->format('Y-m-d H:i:s')],
                'is_delivered' => DBConstant::BOX_NOTIFICATION_TRANS_CONTENT_IS_DELIVERED['not_delivered'],
                'delivered_at' => null,
            ])
            ->get();
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function delivered($id) {
        $this->update([
            'delivered_at' => now(),
            'is_delivered' => DBConstant::BOX_NOTIFICATION_TRANS_CONTENT_IS_DELIVERED['delivered'],
        ], $id);
    }

    /**
     * Get List Box Notification
     *
     * @param  mixed $request
     * @return void
     */
    public function getListBoxNotification($request)
    {
        $perPage = Constant::DEFAULT_LIMIT;
        $sortColumn = $request->input('sort_column', Constant::BOX_NOTIFICATION_SORT_BY_DEFAULT);
        $sortType = $request->input('sort_by', Constant::ORDER_BY_DESC);
        if (isset($request['per_page'])) {
            $perPage = $request['per_page'];
        }

        $boxNotifications = $this->model->select(
            'box_notification_trans_content_id',
            'title',
            'delivered_at',
            'to_type',
            'is_delivered'
        );

        // Search terms if any
        if ($request->filled('title')) {
            $boxNotifications = $boxNotifications->where('title', 'LIKE', "%{$request->title}%");
        }
        if ($request->filled('to_type')) {
            $boxNotifications = $boxNotifications->where('to_type', '=', $request->to_type);
        }
        if ($request->filled('start_date')) {
            $boxNotifications = $boxNotifications->where('scheduled_at', '>=', now()->parse($request->start_date));
        }
        if ($request->filled('end_date')) {
            $boxNotifications = $boxNotifications->where('scheduled_at', '<=', now()->parse($request->end_date)->endOfDay());
        }
        return $boxNotifications->orderBy($sortColumn, $sortType)->paginate($perPage);
    }
}
