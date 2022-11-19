<?php


namespace App\Services\Client\Review;


use App\Enums\Constant;
use App\Repositories\ReviewRepository;
use App\Services\BaseService;

class ReviewService extends BaseService
{
    /**
     * @return string
     */
    public function repository()
    {
        return ReviewRepository::class;
    }

    /**
     * Get list review of teacher
     *
     * @param $request
     * @param $id
     * @return array
     */
    public function listReviewOfTeacher($request, $id)
    {
        try {
            $perPage = $request->perpage ?? Constant::PER_PAGE_DEFAULT;

            return [
                'success' => true,
                'data' => $this->repository->listReviewOfTeacher($perPage, $id)
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }
}
