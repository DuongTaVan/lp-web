<?php

namespace App\Traits;

use App\Enums\DBConstant;
use App\Repositories\ImagePathRepository;

/**
 * Trait TopLabelTrait
 * @package App\Traits
 */
trait CourseImageTrait
{
    private $imagePathRepository;

    public function getImageOfSchedules(&$schedules)
    {
        $this->imagePathRepository = $this->imagePathRepository ?? app(ImagePathRepository::class);

        foreach ($schedules as $item) {
            $this->getImageOfSchedule($item);
        }

        return $schedules;
    }

    public function getImageOfSchedule(&$schedule)
    {
        $this->imagePathRepository = $this->imagePathRepository ?? app(ImagePathRepository::class);
        $courseId = $schedule->parent_course_id ?? $schedule->course_id;
        $image = null;

        if ($schedule->course_schedule_id) {
            $image = $this->imagePathRepository
                ->where([
                    'status' => DBConstant::IMAGE_PATH_STATUS['approved'],
                    'display_order' => DBConstant::IMAGE_COURSE_DISPLAY,
                    'course_schedule_id' => $schedule->course_schedule_id
                ])
                ->orderBy('id', 'DESC')
                ->first();
        }

        if (!$image) {
            $image = $this->imagePathRepository
                ->where([
                    'status' => DBConstant::IMAGE_PATH_STATUS['approved'],
                    'display_order' => DBConstant::IMAGE_COURSE_DISPLAY,
                    'course_id' => $courseId
                ])
                ->orderBy('id', 'DESC')
                ->first();
        }
        $schedule->file_name = $image->file_name ?? '';
        $schedule->dir_path = $image->dir_path ?? '';
        return $schedule;
    }

    public function getImagesOfSchedule(&$schedule)
    {
        $this->imagePathRepository = $this->imagePathRepository ?? app(ImagePathRepository::class);

        $imagePaths = $schedule->course_schedule_id ?
            $this->imagePathRepository->where('course_schedule_id', $schedule->course_schedule_id)->get() :
            [];
        if (!count($imagePaths)) {
            $imagePaths = $this->imagePathRepository->where('course_id', $schedule->course_id)->get();
        }
        $schedule->imagePaths = $imagePaths;

        return $schedule;
    }
}
