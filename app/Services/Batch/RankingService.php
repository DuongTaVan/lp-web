<?php

namespace App\Services\Batch;

use App\Enums\Constant;
use App\Repositories\ApplicantRepository;
use App\Repositories\CourseRepository;
use App\Repositories\RankingRepository;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;

class RankingService extends BaseService

{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $courseRepository;
    public $applicantRepository;

    /**
     * HomeService constructor. 
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->courseRepository = app(CourseRepository::class);
        $this->applicantRepository = app(ApplicantRepository::class);
    }

    /**
     * User repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return RankingRepository::class;
    }

    /**
     * Batch 06 Ranking batch
     *
     * @return array
     */
    public function batch06(): array
    {
        DB::beginTransaction();
        try {
            // set value.
            $runBatchCompleted = false;
            $offset = 0;

            while (!$runBatchCompleted) {

                // 1-1) Get the target data every 1,000 records from DB.
                $courses = $this->courseRepository->getMainCourses()->offset(
                    $offset * Constant::BATCH_RECORD_LIMIT
                )->limit(
                    Constant::BATCH_RECORD_LIMIT
                )->get();

                // Break when no target.
                if (!count($courses)) {
                    $runBatchCompleted = true;

                    break;
                }

                // 1-2) Loop as many times as the number of data at 1-1).
                foreach ($courses as $course) {
                    // 1-2-1) Get count of applicants.
                    $applicantsCount = $this->applicantRepository->getDataCountByCourseId($course->course_id);

                    // 1-2-2) Create ranking.
                    $this->repository->create([
                        'category' => $course->type,
                        'target_date' => now()->subDay()->format('Y-m-d'),
                        'course_id' => $course->course_id,
                        'num_of_applicants' => $applicantsCount,
                    ]);
                }

                $offset++;
            }
            DB::commit();

            return [
                'success' => true
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
