<?php

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MessageRepository;
use App\Models\Message;
use App\Validators\MessageValidator;

/**
 * Class MessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MessageRepositoryEloquent extends BaseRepository implements MessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Message::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     *Get list message from promotional message
     *
     * @param $request
     *
     * @return mixed|void
     */
    public function listMessages($request)
    {
        $isOption = $this->isOptionMessage($request);
        $result = $this->getMessages($isOption);

        return $result;
    }

    /**
     * Count unread message.
     *
     * @return mixed
     */
    public function getUnReadMessage()
    {
        return $this->model
            ->where('to_user_id', auth()->guard('client')->user()->user_id)
            ->where('is_read', DBConstant::MESSAGE_NOT_READ)
            ->count();
    }

    /**
     * Check Option From Request.
     *
     * @param $request
     *
     * @return array
     */
    public function isOptionMessage($request)
    {
        if (isset($request->month) && isset($request->year) && Constant::MESSAGE_LIST_ASC == $request->option) {
            $date = $request->year . '/' . $request->month . '/01';
            $data = [
                'startDate' => Carbon::parse($date)->startOfMonth()->toDateString(),
                'endDate' => Carbon::parse($date)->endOfMonth()->toDateString(),
                'year' => $request->year,
                'month' => $request->month,
                'orderBy' => Constant::MESSAGE_BY_ASC,
            ];
        } elseif (isset($request->option) && !empty($request->option) && Constant::MESSAGE_LIST_ASC == $request->option) {
            $data = [
                'startDate' => Carbon::now()->startOfMonth()->toDateString(),
                'endDate' => Carbon::now()->endOfMonth()->toDateString(),
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
                'orderBy' => Constant::MESSAGE_BY_ASC,
            ];
        } elseif (isset($request->month)) {
            $date = $request->year . '/' . $request->month . '/01';
            $data = [
                'startDate' => Carbon::parse($date)->startOfMonth()->toDateString(),
                'endDate' => Carbon::parse($date)->endOfMonth()->toDateString(),
                'year' => $request->year,
                'month' => $request->month,
                'orderBy' => Constant::MESSAGE_BY_DESC,
            ];
        } else {
            $data = [
                'startDate' => Carbon::now()->startOfMonth()->toDateString(),
                'endDate' => Carbon::now()->endOfMonth()->toDateString(),
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
                'orderBy' => Constant::MESSAGE_BY_DESC,
            ];
        }

        return $data;
    }

    /**
     * Get list messages.
     *
     * @param $data
     *
     * @return array
     */
    public function getMessages($data)
    {
        //TODO teacher my page message
        $listMessage = $this->model
            ->with('promotionalMessage')
            ->where('to_user_id', auth()->guard('client')->user()->user_id)
            ->whereBetween('created_at', [$data['startDate'], $data['endDate']])
            ->groupby('id')
            ->orderBy('id', $data['orderBy'])
            ->paginate(Constant::PER_PAGE_DEFAULT);

        return [
            'dataOption' => $data,
            'notifications' => $listMessage,
        ];
    }
}
