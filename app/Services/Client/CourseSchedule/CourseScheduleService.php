<?php


namespace App\Services\Client\CourseSchedule;


use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use App\Traits\CourseImageTrait;
use App\Traits\ManageFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CourseScheduleService extends BaseService
{
    use ManageFile, CourseImageTrait;

    private $firebaseService;
    private $purchaseRepository;
    private $userRepository;
    private $courseRepository;

    /**
     * @return string
     */
    public function repository()
    {
        return CourseScheduleRepository::class;
    }

    public function __construct()
    {
        parent::__construct();
        $this->firebaseService = app(FirebaseService::class);
        $this->purchaseRepository = app(PurchaseRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->courseRepository = app(CourseRepository::class);
    }

    /**
     * Get course schedule history
     *
     * @param $request
     *
     * @return mixed
     */
    public function listHistory($request)
    {
        try {
            $perPage = $request->perpage ?? Constant::PER_PAGE_DEFAULT;
            return [
                'success' => true,
                'data' => $this->repository->listHistory($perPage)
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    /**
     * List Course Schedule Visited
     *
     * @return mixed
     */
    public function listCourseScheduleVisited()
    {
        // Check user exists.
        if (!Auth::guard('client')->check()) {
            return [
                'success' => false,
                'message' => __('errors.MSG_5023')
            ];
        }
        //  purchased courses, took place, not canceled

        return $this->repository->listCourseScheduleVisited();
    }

    /**
     * Get all info courses
     *
     * @param $courseScheduleId
     *
     * @return mixed
     */
    public function getAllInfoCourse($courseScheduleId)
    {
        $data = $this->repository->getAllInfoCourse($courseScheduleId);
        if ($data) {
            $data->image = $this->getS3FileUrl($data->dir_path . '/' . $data->file_name)
                ?? asset('assets/img/portal/default-image.svg');
            $data->profile_image = $this->getS3FileUrl($data->profile_image)
                ?? asset('assets/img/clients/header-common/not-login.svg');
            $data->start_datetime = Carbon::parse($data->start_datetime);
            $data->end_datetime = Carbon::parse($data->end_datetime);
            $courseSchedules = [$data];
            $this->getImageOfSchedules($courseSchedules);
            $data = $courseSchedules[0];

            return $data;
        }

        return null;
    }

    /**
     * Get list service or teacher
     *
     * @param $request
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function listServiceTeacher($request)
    {
        switch ($request->tab) {
            case 'clone':
                $data = $this->courseRepository->getNewCoursesCloneOfTeacher($request);
                return view('client.screen.teacher.my-page.services.service-list-clone')->with('services', $data);
            case 'new':
                $data = $this->courseRepository->getNewCoursesOfTeacher($request);
                return view('client.screen.teacher.my-page.services.service-new')->with('services', $data);
            case 'draft':
                $data = $this->courseRepository->getDraffCourse($request);
                return view('client.screen.teacher.my-page.services.service-list-draft')->with('services', $data);
            case 'cancel':
                $data = $this->repository->listServiceTeacher([
                    DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                    DBConstant::COURSE_SCHEDULES_STATUS_PENDING
                ], $request);
                return view('client.screen.teacher.my-page.services.service-list-cancel')->with('services', $data);
            default:
                $data = $this->repository->listServiceTeacher([
                    DBConstant::COURSE_SCHEDULES_STATUS_OPEN
                ], $request);
                return view('client.screen.teacher.my-page.services.service-list')->with('services', $data);
        }
    }

    /**
     * Get list service or teacher
     *
     * @param $request
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function totalCourseScheduleOpen()
    {
        return $this->repository->totalCourseScheduleOpen();
    }

    /**
     * Get list students applicant.
     *
     * @param $courseScheduleId
     * @param $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getListStudent($courseScheduleId, $request)
    {
        $data = $this->repository->getListStudent($courseScheduleId, $request);

        return view('client.screen.teacher.my-page.order-status')->with([
            'courseSchedule' => $data['courseSchedule'],
            'students' => $data['listStudent']
        ]);
    }

    /**
     * Get course viewed recently
     *
     * @return mixed|null
     */
    public function listCourseScheduleViewed()
    {
        $courseViewedRecently = null;
        if (Auth::guard('client')->check()) {
            $courseViewedRecently = $this->courseRepository->getCourseViewedRecently($this->repository->getOneScheduleOfCourseRecently());
        }

        return $courseViewedRecently;
    }

    /**
     * Get list course buyer
     *
     * @param $request
     * @return array
     */
    public function getListCourseScheduleMessage($request)
    {
        $params = [
            'page' => $request->page ?? 1,
            'limit' => DBConstant::ITEM_PER_PAGE['10'], // default
            'year' => $request->year ?? date("Y"), // default current year,
            'month' => $request->month ?? date("m"), // default current month,
            'option' => (isset($request->option) && (int)$request->option === 2) ? 'ASC' : 'DESC', // 1: DESC, 0: ASC default 1
//            'option' => 'DESC', // 1: DESC, 0: ASC default 1
        ];
        $teacherId = auth('client')->id();
        $date = $params['year'] . '/' . $params['month'] . '/01';
        $selectFields = [
            'course_schedules.course_schedule_id as courseScheduleId',
            'course_schedules.start_datetime',
            'course_schedules.end_datetime',
            'course_schedules.actual_start_date',
            'course_schedules.actual_end_date',
            'course_schedules.title as courseScheduleTitle',
            'course_schedules.price',
            'course_schedules.status',
            'totalMember', 'co.type', 'parent_course_id'
        ];

        $courseSchedules = $this->repository
            ->select($selectFields)
            ->join('courses as co', 'co.course_id', '=', 'course_schedules.course_id')
            ->join(\DB::raw("(SELECT purchases.course_schedule_id, count(*) totalMember FROM `purchases`
                JOIN purchase_details ON purchases.purchase_id = purchase_details.purchase_id
                    AND purchase_details.item = 'course' AND purchases.student_canceled_at IS NULL
                GROUP BY course_schedule_id) sub"), function ($join) {
                $join->on('sub.course_schedule_id', '=', 'course_schedules.course_schedule_id');
            })
            ->where([
                'co.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                'co.user_id' => $teacherId,
                'course_schedules.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION
            ])
            ->whereIn('co.type', [DBConstant::COURSE_TYPE_MAIN, DBConstant::COURSE_TYPE_SUB])
            ->where('course_schedules.status', '!=', DBConstant::COURSE_SCHEDULES_STATUS_DRAFT)
            ->whereNull('course_schedules.parent_course_schedule_id')
            ->whereBetween('course_schedules.start_datetime', [Carbon::parse($date)->startOfMonth()->startOfDay()->toDateTime(), Carbon::parse($date)->endOfMonth()->endOfDay()->toDateTime()])
            ->groupBy('course_schedules.course_schedule_id')
            ->orderBy('course_schedules.start_datetime', $params['option']);

        $totalRecord = $courseSchedules->get()->count();
        $courseSchedules = $courseSchedules
            ->limit($params['limit'])
            ->offset(((int)$params['page'] - 1) * (int)$params['limit'])
            ->get();
        // get info is read in firebase
        foreach ($courseSchedules as $courseSchedule) {
            if ($courseSchedule['type'] && $courseSchedule['parent_course_id']) {
                $course = $this->courseRepository->find($courseSchedule['parent_course_id']);
                if ($course) {
//                    $courseSchedule->courseScheduleTitle = $course->title;
                    $courseSchedule->image = $course->imagePathByDisplayOrder->thumbnail ?? null;
                }
            }
            $type = [DBConstant::ROOM_STATUS_PURCHASED, DBConstant::ROOM_STATUS_TEACHER_CANCEL];
            $data = $this->firebaseService->getListRoomByCourseSchedule($courseSchedule->courseScheduleId, $teacherId, $type);
            $courseSchedule->noMessage = $data['no_message'];
            $courseSchedule->isRead = $data['is_read'];
        }
//        }

        return [
            'data' => $courseSchedules,
            'pagination' => [
                'total' => $totalRecord,
                'totalPage' => (int)ceil($totalRecord / (int)$params['limit']),
                'limit' => 10,
                'page' => $request->page ?? 1
            ],
            'date' => [
                'month' => $params['month'],
                'year' => $params['year']
            ]
        ];
    }

    /**
     * @param $courseScheduleId
     * @param $request
     */
//    public function getDetailMessageNotBuyer($courseScheduleId, $params)
//    {
//        $courseSchedule = $this->repository->with(['course.user', 'course.imagePathByDisplayOrder'])
//            ->join('courses', function ($query) {
//                $query->on('courses.course_id', '=', 'course_schedules.course_id')
//                    ->where('courses.is_archived', DBConstant::NOT_ARCHIVED_FLAG);// check course is deleted
//            })
//            ->findOrFail($courseScheduleId);
//        $userId = auth()->guard('client')->id();
//        $sort = $params['option'] === 'DESC';
//        $type = $courseSchedule->status === 0 ? DBConstant::ROOM_TYPE_OPEN : DBConstant::ROOM_TYPE_CLOSE;
//        $status = DBConstant::ROOM_NOT_PURCHASED;
//        $rooms = $this->firebaseService
//            ->getRoomByCourseScheduleId($courseScheduleId, $userId, $type, $status);
//        $total = count($rooms);
//        $rooms = collect($rooms)->sortBy(function ($room) {
//            return $room['lastMessage']['createdAt'] ?? null;
//        }, SORT_REGULAR, $sort)->forPage($params['page'], $params['limit'])->toArray();
//        $data = [];
//        foreach ($rooms as $room) {
//            if (isset($room['memberIds'])) {
//                $studentId = collect($room['memberIds'])->filter(function ($id) use ($userId) {
//                    return $id !== (int)$userId;
//                })->first();
//                if ($studentId) {
//                    $user = $this->userRepository->getUserPrivateChat($studentId);
//                    if (count($user) === 0) continue;
//                    $user['age'] = round($user['current_age'] / 10, 0, PHP_ROUND_HALF_DOWN) * 10;
//                    $data[] = array_merge($room, $user);
//                }
//            }
//        }
//        return [
//            'courseSchedule' => $courseSchedule,
//            'messages' => $data,
//            'total' => $total
//        ];
//    }

    /**
     *
     */
    public function getListPrivateChat($params)
    {
        $rooms = $this->firebaseService->getRoomPrivateChatByUser(true, $params);
        $totalRecord = count($rooms);
        $rooms = collect($rooms)->forPage($params['page'], $params['limit']);
        $result = [];
        $selectListUser = [
            'user_id',
            'nickname',
            'last_name_kanji',
            'first_name_kanji',
            'user_type',
            'name_use',
            'date_of_birth',
            'sex'
        ];

        foreach ($rooms as $key => $room) {
            $courseSchedule = [];
            if ($room['courseScheduleId']) {
                $data = $this->repository->findByField('course_schedule_id', $room['courseScheduleId'], ['title', 'price'])->first();

                if ($data) {
                    $courseSchedule['title'] = $data->title;
                    $courseSchedule['price'] = $data->price;
                }
            }
            $room['age'] = 0;
            if (!isset($room['student_id'])) {
                continue;
            }
            $currentUser = $this->userRepository->findByField('user_id', $room['student_id'], $selectListUser)->first();
            if (!$currentUser) {
                continue;
            }
            $room['age'] = floor($currentUser->current_age / 10) * 10;
            $result[] = array_merge($room, $currentUser->toArray(), $courseSchedule);
        }

        return [
            'total' => $totalRecord,
            'users' => $result
        ];
    }

    /**
     * Get list message not buyer (include private chat)
     *
     * @param $request
     * @return array
     */
//    public function getListMessageNotBuyer($request)
//    {
//        $params = [
//            'page' => $request->page ?? 1,
//            'limit' => 10, // default
//            'year' => $request->year ?? date("Y"), // default current year,
//            'month' => $request->month ?? date("m"), // default current month,
//            'option' => isset($request->option) ? $request->option == 1 ? 'DESC' : 'ASC' : 'DESC', // 1: DESC, 0: ASC default 1
//        ];
//        $date = $params['year'] . '/' . $params['month'] . '/01';
//        $teacherId = auth()->guard('client')->id();
//        $courseScheduleIds = $this->firebaseService
//            ->getListRoomIdNotBuyer($teacherId, DBConstant::ROOM_NOT_PURCHASED);
//
//        $fields = [
//            'course_schedules.title as courseScheduleTitle',
//            'course_schedules.start_datetime as start_datetime',
//            'course_schedules.end_datetime as end_datetime',
//            'course_schedules.price as price',
//            'course_schedules.course_schedule_id as courseScheduleId',
//            'course_schedules.status as status'
//        ];
//        $courseSchedules = $this->repository
//            ->select($fields)
//            ->join('courses', function ($query) {
//                $query->on('courses.course_id', '=', 'course_schedules.course_id')
//                    ->where('courses.is_archived', DBConstant::NOT_ARCHIVED_FLAG);// check course is deleted
//            })
//            ->join('users', 'users.user_id', 'courses.user_id')
//            ->where('users.is_archived', DBConstant::NOT_ARCHIVED_FLAG)
//            ->where('courses.user_id', $teacherId)
//            ->whereIn('course_schedule_id', array_keys($courseScheduleIds))
//            ->orderBy('course_schedules.start_datetime', $params['option'])
//            ->whereBetween('course_schedules.start_datetime', [Carbon::parse($date)->startOfMonth()->startOfDay()->toDateTime(), Carbon::parse($date)->endOfMonth()->endOfDay()->toDateTime()])
//            ->paginate($params['limit']);
//        foreach ($courseSchedules as $courseSchedule) {
//            $courseSchedule->isRead = $courseScheduleIds[$courseSchedule->courseScheduleId]['isRead'];
//            $courseSchedule->totalUser = $courseScheduleIds[$courseSchedule->courseScheduleId]['total'];
//        }
//
//        return [
//            'data' => $courseSchedules,
//            'pagination' => [
//                'total' => $courseSchedules->total(),
//                'totalPage' => $courseSchedules->lastPage(),
//                'limit' => 10,
//                'page' => $request->page ?? 1
//            ],
//            'date' => [
//                'month' => $params['month'],
//                'year' => $params['year']
//            ]
//        ];
//    }

    /**
     * @param $courseScheduleId
     * @param $params
     * @return array
     */
    public function getListBuyerMessage($courseScheduleId, $params)
    {
        $teacherId = auth('client')->id();
        $courseSchedule = $this->repository->with(['course.user', 'course.imagePathByDisplayOrder'])
            ->join('courses', function ($query) use ($teacherId) {
                $query->on('courses.course_id', '=', 'course_schedules.course_id')
                    ->where('courses.is_archived', DBConstant::NOT_ARCHIVED_FLAG)// check course is deleted
                    ->where('courses.user_id', $teacherId);
            })
            ->select('course_schedules.*', 'courses.parent_course_id')
            ->findOrFail($courseScheduleId);

        // get list user purchase
        $purchases = $this->purchaseRepository
            ->join('purchase_details as pd', function ($query) {
                $query->on('pd.purchase_id', '=', 'purchases.purchase_id')
                    ->where('pd.item', DBConstant::PURCHASE_ITEM_COURSE_TYPE);
            })
            ->join('users as u', 'u.user_id', '=', 'purchases.user_id')
            ->where([
                'purchases.course_schedule_id' => $courseScheduleId,
                'u.is_archived' => DBConstant::NOT_ARCHIVED_FLAG
            ])
            ->whereNull('purchases.student_canceled_at')
            ->orderBy('purchases.purchased_at', $params['option'])
            ->select([
                'purchases.purchase_id',
                'purchases.purchased_at',
                'u.nickname',
                'u.user_type',
                'u.sex',
                'u.date_of_birth',
                'u.user_id',
                'u.last_name_kanji',
                'u.first_name_kanji',
                'u.name_use'
            ]);

        $totalRecord = $purchases->get();

        foreach ($totalRecord as $purchase) {
            $type = $courseSchedule->status === DBConstant::COURSE_SCHEDULES_STATUS_OPEN ? DBConstant::ROOM_TYPE_OPEN : DBConstant::ROOM_TYPE_CLOSE;
            $status = $courseSchedule->status === DBConstant::COURSE_SCHEDULES_STATUS_PENDING || $courseSchedule->status === DBConstant::COURSE_SCHEDULES_STATUS_CANCELED ?
                DBConstant::ROOM_STATUS_TEACHER_CANCEL : DBConstant::ROOM_STATUS_PURCHASED;
            $lastMessage = $this->firebaseService
                ->getRoomByCourseScheduleId($teacherId, $purchase->user_id, $courseScheduleId, $type, $status);
            $purchase->age = round(Carbon::parse($purchase->date_of_birth)->age / 10, 0, PHP_ROUND_HALF_DOWN) * 10;
            if ($lastMessage['roomId']) {
                $purchase->roomId = $lastMessage['roomId'];
            }
            if ($lastMessage['lastMessage'] && $lastMessage['lastMessage']['lastMessage'] && $lastMessage['lastMessage']['lastMessage']->snapshot()->exists()) {
                $purchase->lastMessageDate = $lastMessage['lastMessage']['lastSentDatetime'];
                $lastMessage = $lastMessage['lastMessage']['lastMessage']->snapshot()->data();
                $purchase->isRead = $lastMessage['is_read'];
            }
        }

        $offset = ((int)$params['page'] - 1) * (int)$params['limit'];
        $showRecord = $totalRecord->slice($offset, (int)$params['limit']);

        // get images course schedule
        $courseSchedules = [$courseSchedule];
        $this->getImageOfSchedules($courseSchedules);
        $courseSchedule = $courseSchedules[0];

        return [
            'courseSchedule' => $courseSchedule,
            'total' => $totalRecord->count(),
            'totalRecord' => $totalRecord,
            'messages' => $showRecord,
        ];
    }

    /**
     * Get firestore room by coures schedule, user
     *
     * @param $courseScheduleId
     * @param $studentId
     * @return array
     */
    public function getRoomIdByCourseScheduleUser($courseScheduleId, $studentId)
    {
        $userPurchase = $this->repository
            ->join('purchases', 'purchases.course_schedule_id', 'course_schedules.course_schedule_id')
            ->where('course_schedules.course_schedule_id', $courseScheduleId)
            ->where('purchases.user_id', $studentId)
            ->whereIn('purchases.status', [DBConstant::PURCHASES_STATUS_CAPTURED, DBConstant::PURCHASES_STATUS_CANCELED_AFTER_CAPTURE, DBConstant::PURCHASES_STATUS_NOT_CAPTURED])
            ->first();
        $status = !!$userPurchase ? DBConstant::ROOM_STATUS_PURCHASED : DBConstant::ROOM_STATUS_NOT_PURCHASED;
        $roomId = $this->firebaseService->getRoomIdCourseSchedule((int)$courseScheduleId, (int)$studentId, $status);
        return [
            'roomType' => $status,
            'roomId' => $roomId
        ];
    }

    /**
     * @param $userId
     */
    public function getPrivateChatRoom($userId)
    {
        $teacherId = auth()->guard('client')->id();
        return $this->firebaseService->getRoomPrivateChat($teacherId, $userId);
    }

    /**
     * Teacher send message 1 - 1 vs student
     *
     * @param $studentId
     */
    public function sendMessagePrivate($studentId, $message)
    {
//        $this->firebaseService->teacherSendMessagePrivate($studentId, $message);
    }

    /**
     *
     * Teacher send message to student
     *
     * @param $fromUserId
     * @param $message
     * @param null $teacherId
     * @param null $courseScheduleId
     * @param int $typeRoom
     */
    public function sendMessage($fromUserId, $message, $teacherId = null, $courseScheduleId = null, $typeRoom = 1)
    {
        $this->firebaseService->sendMessage($fromUserId, $message, $teacherId, $courseScheduleId, $typeRoom, true);
    }

    /**
     * send message to roomIds
     *
     * @param array $roomIds
     * @param int $userId
     * @param string $message
     */
    public function sendMessageToRoomIds(array $roomIds, int $userId, string $message)
    {
        $this->firebaseService->sendMessageToRoomIds($roomIds, $userId, $message);
    }

    /**
     *
     * Teacher send message to all student buyer
     *
     * @param $fromUserId
     * @param $message
     * @param null $teacherId
     * @param null $courseScheduleId
     * @param int $typeRoom
     */
//    public function sendMessageToAll($courseScheduleId, $message, $roomType, $teacherId)
//    {
//        $userIds = [];
//        if ((int)$roomType === DBConstant::ROOM_NOT_PURCHASED) {
//            $type = DBConstant::ROOM_NOT_PURCHASED;
//            $status = DBConstant::ROOM_NOT_PURCHASED;
//            $rooms = $this->firebaseService
//                ->getRoomByCourseScheduleId($courseScheduleId, $teacherId, $type, $status);
//            foreach ($rooms as $room) {
//                $userId = collect($room['memberIds'])->filter(function ($id) use ($teacherId) {
//                    return (int)$id !== (int)$teacherId;
//                })->first();
//                $userIds[] = $userId;
//            }
//        } else {
//            $userIds = $this->purchaseRepository
//                ->select('user_id')
//                ->where('course_schedule_id', $courseScheduleId)
//                ->whereIn('status', [DBConstant::PURCHASES_STATUS_CAPTURED, DBConstant::PURCHASES_STATUS_CANCELED_AFTER_CAPTURE, DBConstant::PURCHASES_STATUS_NOT_CAPTURED])
//                ->get();
//            $userIds = $userIds->unique('user_id')->pluck('user_id')->toArray();
//        }
//        SendMessageToAllUser::dispatch($userIds, $message, $teacherId, $courseScheduleId, $roomType);
//    }

    /**
     * Find course schedule by id
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function findCourseSchedule($courseScheduleId)
    {
        return $this->repository
            ->with('course')
            ->findWhere(['course_schedule_id' => $courseScheduleId])
            ->first();
    }

    /**
     * get course schedule by course id
     *
     * @param $courseId
     * @return mixed
     */
    public function getNearestCourseScheduleByCourseId($courseId, $test = false)
    {
        $userId = auth()->guard('client')->user()->user_id ?? null;
        $countCourseOpen = $this->repository
            ->where([
                'course_id' => $courseId,
                'type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                ['course_schedules.purchase_deadline', '>', now()]
            ])
            ->whereRaw('course_schedules.num_of_applicants < course_schedules.fixed_num')
            ->count();
        if ($countCourseOpen <= 0) {
            return $this->repository
                ->where([
                    'course_id' => $courseId,
                    'type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                    // 'status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN
                ])
                ->whereIn('course_schedules.status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN, DBConstant::COURSE_SCHEDULES_STATUS_CLOSED, DBConstant::COURSE_SCHEDULES_STATUS_RECORDED])
                ->leftJoin('purchases', function ($q) use ($userId) {
                    $q->on('purchases.course_schedule_id', 'course_schedules.course_schedule_id')
                        ->where('purchases.user_id', $userId)
                        ->where('purchases.status', DBConstant::PURCHASES_STATUS_NOT_CAPTURED);
                })
                ->select([
                    'course_schedules.*',
                    'course_schedules.status as closeAll',
                    'purchases.user_id as p_user_id',
                ])
                ->orderBy('start_datetime', 'ASC')
                ->first();
        }

        $result = $this->repository
            ->where([
                'course_id' => $courseId,
                'type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                ['course_schedules.purchase_deadline', '>', now()]
            ])
            ->whereRaw('course_schedules.num_of_applicants < course_schedules.fixed_num')
            ->leftJoin('purchases', function ($q) use ($userId) {
                $q->on('purchases.course_schedule_id', 'course_schedules.course_schedule_id')
                    ->where('purchases.user_id', $userId)
                    ->where('purchases.status', DBConstant::PURCHASES_STATUS_NOT_CAPTURED);
            })
            ->select([
                'course_schedules.*',
                'purchases.user_id as p_user_id',
            ])
            ->orderBy('start_datetime', 'ASC')
            ->get()->first(function($courseSchedule) {
                return !$courseSchedule->p_user_id;
            });
        if (!$result) {
            return null;
        }
        $result['count_open'] = $countCourseOpen;

        return $result;
    }
}
