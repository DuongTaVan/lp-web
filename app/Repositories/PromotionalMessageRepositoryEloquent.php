<?php

namespace App\Repositories;

use App\Enums\Constant;
use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PromotionalMessageRepository;
use App\Models\PromotionalMessage;
use App\Validators\PromotionalMessageValidator;

/**
 * Class PromotionalMessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PromotionalMessageRepositoryEloquent extends BaseRepository implements PromotionalMessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PromotionalMessage::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get list message
     * @param $perPage
     * @return mixed
     */
    public function listPromotionalMessages($request)
    {
        $isOption = $this->isOptionPromotionalMessage($request);

        return $this->promotionalMessage($isOption);
    }

    /**
     * Get option promotional message list.
     *
     * @param $request
     * @return array
     */
    public function isOptionPromotionalMessage($request)
    {
        if (isset($request->month) && isset($request->year) && Constant::PROMOTIONAL_MESSAGE_LIST_ASC == $request->option) {
            $date = $request->year . '/' . $request->month . '/01';
            $data = [
                'startDate' => Carbon::parse($date)->startOfMonth()->toDateString(),
                'endDate' => Carbon::parse($date)->endOfMonth()->toDateString(),
                'year' => $request->year,
                'month' => $request->month,
                'orderBy' => Constant::PROMOTIONAL_MESSAGE_BY_ASC,
            ];
        } elseif (isset($request->option) && !empty($request->option) && Constant::PROMOTIONAL_MESSAGE_LIST_ASC == $request->option) {
            $data = [
                'startDate' => Carbon::now()->startOfMonth()->toDateString(),
                'endDate' => Carbon::now()->endOfMonth()->toDateString(),
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
                'orderBy' => Constant::PROMOTIONAL_MESSAGE_BY_ASC,
            ];
        } elseif (isset($request->month)) {
            $date = $request->year . '/' . $request->month . '/01';
            $data = [
                'startDate' => Carbon::parse($date)->startOfMonth()->toDateString(),
                'endDate' => Carbon::parse($date)->endOfMonth()->toDateString(),
                'year' => $request->year,
                'month' => $request->month,
                'orderBy' => Constant::PROMOTIONAL_MESSAGE_BY_DESC,
            ];
        } else {
            $data = [
                'startDate' => Carbon::now()->startOfMonth()->toDateString(),
                'endDate' => Carbon::now()->endOfMonth()->toDateString(),
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
                'orderBy' => Constant::PROMOTIONAL_MESSAGE_BY_DESC,
            ];
        }

        return $data;
    }

    public function promotionalMessage($data)
    {
        //TODO teacher my page notice
        $listPromotionalMessages = $this->model
            ->where('from_user_id', auth()->guard('client')->user()->user_id)
            ->whereBetween('created_at', [$data['startDate'], $data['endDate']])
            ->groupby('promotional_message_id')
            ->orderBy('promotional_message_id', $data['orderBy'])
            ->paginate(Constant::PER_PAGE_DEFAULT);

        return [
            'dataOption' => $data,
            'notices' => $listPromotionalMessages,
        ];
    }
}
