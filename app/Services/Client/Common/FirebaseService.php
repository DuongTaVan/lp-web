<?php

declare(strict_types=1);

namespace App\Services\Client\Common;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Services\BaseService;
use App\Services\Client\Teacher\UserService;
use Carbon\Carbon;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Kreait\Firebase\Firestore;
use Kreait\Firebase\Storage;
use Illuminate\Support\Facades\Storage as appStorage;
use Image;

class FirebaseService extends BaseService
{
    private $firestore;
    private $fireStorage;
    protected $userService;

    /**
     * CourseService constructor.
     */
    public function __construct(Firestore $firestore, Storage $fireStorage)
    {
        parent::__construct();
        $this->firestore = $firestore->database();
        $this->fireStorage = $fireStorage;
        $this->userService = app(UserService::class);
    }

    public function repository()
    {
        // TODO: Implement repository() method.
    }

    public function findRoomByCourseScheduleId($courseScheduleId)
    {
        $collectionReference = $this->firestore->collection('rooms')
            ->where('courseScheduleId', '=', (int)$courseScheduleId);
        return $collectionReference->documents();
    }

    /**
     * @param false $isTeacher
     * @param $param
     * @return array
     */
    public function getRoomPrivateChatByUser(bool $isTeacher = false, $param)
    {
        $startMonth = $param['month'] ?? '01';
        $endMonth = $param['month'] ?? '12';
        $userId = auth('client')->id();
        $firstDate = now()->parse($param['year'] . '/' . $startMonth . '/01');
        $lastDate = now()->parse($param['year'] . '/' . $endMonth . '/01')->lastOfMonth()->endOfDay();
        $sort = $param['option'];

        $documentsNotReceiveMessages = [];
        $documents = $this->firestore
            ->collection('rooms')
            ->where('status', 'in', [DBConstant::ROOM_STATUS_NOT_PURCHASED, DBConstant::ROOM_STATUS_STUDENT_CANCEL]);
        if ($isTeacher) {
            $documents = $documents
                ->where('teacher_id', '=', $userId)
                ->where('lastSentDatetimeStudent', '!=', false)
                ->where('lastSentDatetimeStudent', '>=', $firstDate)
                ->where('lastSentDatetimeStudent', '<=', $lastDate)
                ->orderBy('lastSentDatetimeStudent', $sort);
        } else {
            $documents = $documents
                ->where('student_id', '=', $userId)
                ->where('lastSentDatetimeTeacher', '!=', false)
                ->where('lastSentDatetimeTeacher', '>=', $firstDate)
                ->where('lastSentDatetimeTeacher', '<=', $lastDate)
                ->orderBy('lastSentDatetimeTeacher', $sort);
            $documentsNotReceiveMessages = $this->firestore
                ->collection('rooms')
                ->where('status', 'in', [DBConstant::ROOM_STATUS_NOT_PURCHASED, DBConstant::ROOM_STATUS_STUDENT_CANCEL])
                ->where('student_id', '=', $userId)
                ->where('lastSentDatetimeTeacher', '=', false)
                ->where('lastSentDatetimeStudent', '!=', false)
                ->documents()->rows();
        }
        $documents = $documents->documents()->rows();
        $documents = array_merge($documents, $documentsNotReceiveMessages);
        $result = [];
        foreach ($documents as $document) {
            $data = $document->data();
            $checkUserId = $isTeacher ? $data['student_id'] : $data['teacher_id'];
            if (isset($checkUserId)) {
                $userIsArchive = $this->userService->accountIsClose($checkUserId);
            }
            // if has user closed
            if (isset($userIsArchive)) {
                continue;
            }

            $data['isRead'] = true;
            $data['roomId'] = $document->id();
            $data['lastSentDatetime'] = null;
            $data['lastMessage'] = null;
            $lastMessage = $this->getLastMessageOtherUser($document, $userId);

            if ($lastMessage && $lastMessage['lastMessage'] && $lastMessage['lastMessage']->snapshot()->exists()) {
                $lastMessageData = $lastMessage['lastMessage']->snapshot()->data();
                $data['lastMessage'] = $lastMessageData;
                $data['lastSentDatetime'] = $this->formatDatetimeFB($lastMessageData['createdAt']);
                $data['isRead'] = $lastMessageData['is_read'];
            }
            $result[] = $data;
        }

        return $result;
    }

    /**
     * Update last message read
     * @param $roomId
     * @param $lastMessage
     * @param $userId
     */
    public function updateReadLastMessage($roomId, $lastMessage, $userId)
    {
        $lastMessageData = $lastMessage->snapshot()->data();
        if (isset($lastMessageData['readMemberIds']) && !in_array((int)$userId, $lastMessageData['readMemberIds'])) {
            $this->firestore
                ->collection('rooms')
                ->document($roomId)
                ->collection('messages')
                ->document($lastMessage->id())
                ->update([
                    [
                        'path' => 'readMemberIds',
                        'value' => array_merge($lastMessageData['readMemberIds'], [(int)$userId])
                    ]
                ]);
        }
    }

    /**
     * @param $courseScheduleId
     * @param $userId
     * @param $studentId
     * @param int $typeRoom
     * @return string
     */
    public function getRoomByCourse($courseScheduleId, $userId, $studentId, $typeRoom = DBConstant::ROOM_PURCHASED)
    {
        $documents = $this->firestore
            ->collection('rooms')
            ->where('memberIds', 'array-contains', (int)$userId)
            ->where('courseScheduleId', '==', (int)$courseScheduleId)
//            ->where('type', '=', $typeRoom) // TODO
            ->documents();
        foreach ($documents->rows() as $room) {
            $data = $room->data();
            if (isset($data['memberIds']) && in_array((int)$studentId, $data['memberIds'])) {
                $lastMessage = $data['lastMessage'];
                if ($lastMessage) $this->updateReadLastMessage($room->id(), $lastMessage, $studentId);
                return $room->id();
            }
        }
        $room = $this->firestore->collection('rooms')->add([
            'memberIds' => [
                (int)$userId,
                (int)$studentId
            ], // array $toUserId contain $fromUserId
            'type' => (int)$typeRoom,
            'courseScheduleId' => (int)$courseScheduleId,
            'existMessage' => false,
            'lastSentDatetimeStudent' => false,
            'lastMessageStudent' => false,
            'lastSentDatetimeTeacher' => false,
            'lastMessageTeacher' => false,
            'from_user_id' => $studentId,
            'to_user_id' => $userId,
            'createdAt' => Carbon::now(config('app.timezone'))
        ])->snapshot();
        return $room->id();
    }

    /**
     * Create user in firestore database
     *
     * @param $userId
     * @param $data
     * @param null $imageFile
     * @param null $imageName
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function createUser($userId, $data, $imageFile = null, $imageName = null)
    {
        if (is_array($imageFile) && $imageFile['fullPath']) {
            $file = $imageName . '.' . substr(strrchr($imageFile['originalName'], '.'), 1);
            $inputStream = appStorage::disk(config('filesystems.public'))->path($imageFile['path']);
            if (appStorage::disk('public')->putFileAs('firebase-temp-uploads', $inputStream, $file)) {
                $buckets = $this->fireStorage->getBucket();
                $buckets->upload(appStorage::disk('public')->get('firebase-temp-uploads/' . $file), [
                    'name' => "users/" . $file
                ]);
                $data[] = ['path' => 'imageUrl', 'value' => "users/" . $file];

                if (appStorage::disk('public')->exists('firebase-temp-uploads/' . $file)) {
                    appStorage::disk('public')->delete('firebase-temp-uploads/' . $file);
                }

                if (appStorage::disk('public')->exists('tmp/' . $userId)) {
                    appStorage::disk('public')->deleteDirectory('tmp/' . $userId);
                }
            }
        } else if ($imageFile) {
            $extension = $imageFile->getClientOriginalExtension();
            $file = $imageName . '.' . $extension;
            if (appStorage::disk('public')->putFileAs('firebase-temp-uploads', $imageFile, $file)) {
                $buckets = $this->fireStorage->getBucket();
                $buckets->upload(appStorage::disk('public')->get('firebase-temp-uploads/' . $file), [
                    'name' => "users/" . $file
                ]);
                $data[] = ['path' => 'imageUrl', 'value' => "users/" . $file];

                if (appStorage::disk('public')->exists('firebase-temp-uploads/' . $file)) {
                    appStorage::disk('public')->delete('firebase-temp-uploads/' . $file);
                }
            }
        }
        $user = $this->firestore
            ->collection('users')
            ->document($userId);
        if ($user->snapshot()->exists()) {
            $this->firestore->collection('users')->document($userId)->update($data);
        } else {
            $set = [];
            foreach ($data as $item) {
                $set[$item['path']] = $item['value'];
            }
            $this->firestore->collection('users')->document($userId)->set($set);
        }
    }

    /**
     * @param $userId
     * @param null $status
     * @return array
     */
    public function getRoomByUserId($userId, $status = null)
    {
        $result = [];
        $documents = $this->firestore
            ->collection('rooms')
            ->where('memberIds', 'array-contains', $userId);
        if ($status) {
            $documents = $documents
                ->where('status', '=', $status);
        }
        $documents = $documents->documents();
        foreach ($documents->rows() as $doc) {
            $room = $doc->data();
            if ((isset($room['unreadMessageCount']) && $room['unreadMessageCount'] === 0)) continue;
            if (isset($room['courseScheduleId']) && $room['courseScheduleId'] !== null) {
                $lastMessages = $this->firestore
                    ->collection('rooms')
                    ->document($doc->id())
                    ->collection('messages')
                    ->where('userId', '!=', $this->firestore->collection('users')->document((int)$userId))
                    ->documents();

                $lastMessage = null;
                foreach ($lastMessages->rows() as $row) {
                    $message = $row->data();
                    if (($lastMessage && Carbon::create($message['createdAt']->formatAsString())->gt(Carbon::create($lastMessage['createdAt']->formatAsString()))) || !$lastMessage) {
                        $lastMessage = $message;
                    }
                }
                if ($lastMessage) {
                    $room['lastMessage'] = $lastMessage;
                    $room['lastMessage']['createdAt'] = $this->formatDatetimeFB($lastMessage['createdAt']);
                    $room['lastMessage']['readMemberIds'] = $lastMessage['readMemberIds'] ?? [];
                    $room['lastMessage']['userId'] = gettype($lastMessage['userId']) === 'object' ? $lastMessage['userId']->id() : $lastMessage['userId'];
                    $room['lastMessage']['is_read'] = in_array($userId, $room['lastMessage']['readMemberIds']);
                } else {
                    $room['lastMessage'] = null;
                }
                $result[] = $room;
            }
        }
        return $result;
    }

    /**
     * Get room by cs Id and change to type teacher
     *
     * @param int $teacherId
     * @param int $studentId
     * @param int $courseScheduleId
     * @param int $type
     * @return array
     */
    public function getRoomByCourseScheduleId(int $teacherId, int $studentId, int $courseScheduleId, int $type, int $status, $restock = null)
    {
        $documents = $this->firestore
            ->collection('rooms')
            ->where('teacher_id', '=', $teacherId)
            ->where('student_id', '=', $studentId)
            ->where('courseScheduleId', '=', $courseScheduleId)
            ->limit(1)
            ->documents();

        if (count($documents->rows())) {
            $room = $documents->rows()[0];
            $dataUpdate = [
                ['path' => 'type', 'value' => $type],
                ['path' => 'status', 'value' => $status]
            ];
            if ($restock !== null) {
                $dataUpdate[] = ['path' => 'enabledRequestRestock', 'value' => strtoupper((string)$restock) === "TRUE"];
            }

            $room->reference()->update($dataUpdate);
        } else {
            $room = $this->createRoom($teacherId, $studentId, $courseScheduleId, $type, $status, $restock);
        }
        $result = $room->data();
        $result['roomId'] = $room->id();
        $userId = auth('client')->id();
        $result['lastMessage'] = $this->getLastMessageOtherUser($room, $userId);

        return $result;
    }

    /**
     * send message promotion
     *
     * @param int $fromUserId
     * @param int $toUserId
     * @param string $message
     */
    public function sendMessagePromotion(int $teacherId, int $studentId, string $message)
    {
        $room = $this->createRoom($teacherId, $studentId, null, DBConstant::ROOM_TYPE_PROMOTION, DBConstant::ROOM_STATUS_NONE);
        $room = $room->reference();

//        $newMessage = $this->firestore->collection('rooms/' . $room->id() . '/messages')->add([
        $newMessage = $room->collection('messages')->add([
            'userId' => $this->firestore->document('users/' . $teacherId),
            'type' => Constant::MESSAGE_TYPE_TEXT,
            'message' => $message,
            'imageUrl' => null,
            'fileUrl' => null,
            'stickerUrl' => null,
            'userType' => DBConstant::USER_TYPE_TEACHER,
            'is_read' => false,
            'createdAt' => Carbon::now(config('app.timezone'))
        ]);

        $this->updateLastMessage(true, $room, $newMessage->id());
    }

    /**
     * Get total message unread student my_page message
     *
     * @return int[]
     */
    public function getStudentMessageUnread()
    {
        $studentId = auth('client')->id();
        $rooms = $this->firestore
            ->collection('rooms')
            ->where('student_id', '=', $studentId)
            ->documents();
        $purchasedOpen = 0;
        $purchasedNotOpen = 0;
        $notPurchase = 0;
        $promotion = 0;
        $totalMessageUnread = 0;

        foreach ($rooms->rows() as $room) {
            $data = $room->data();
            $lastMessage = $this->getLastMessageOtherUser($room, $studentId);
            if (!$lastMessage || !$lastMessage['lastMessage'] || !$lastMessage['lastMessage']->snapshot()->exists()) {
                continue;
            }

            $lastMessageData = $lastMessage['lastMessage']->snapshot()->data();

            if (isset($lastMessageData['is_read']) && $lastMessageData['is_read']) {
                continue;
            }
            $totalMessageUnread++;

            if (isset($data['courseScheduleId'])) {
                if (!isset($data['type']) && !isset($data['status'])) {
                    continue;
                }

                if ((int)$data['type'] === DBConstant::ROOM_TYPE_OPEN && (int)$data['status'] === DBConstant::ROOM_STATUS_PURCHASED) {
                    $purchasedOpen++;
                }
                if ((int)$data['type'] === DBConstant::ROOM_TYPE_CLOSE &&
                    ((int)$data['status'] === DBConstant::ROOM_STATUS_PURCHASED || (int)$data['status'] === DBConstant::ROOM_STATUS_TEACHER_CANCEL)) {
                    $purchasedNotOpen++;
                }
                if ((int)$data['status'] === DBConstant::ROOM_STATUS_NOT_PURCHASED || (int)$data['status'] === DBConstant::ROOM_STATUS_STUDENT_CANCEL) {
                    $notPurchase++;
                }
            } else {
                if (!isset($data['type'])) {
                    continue;
                }
                if ((int)$data['status'] === DBConstant::ROOM_STATUS_NOT_PURCHASED || ((int)$data['type'] === DBConstant::ROOM_TYPE_PRIVATE)) {
                    $notPurchase++;
                }
                if (((int)$data['type'] === DBConstant::ROOM_TYPE_PROMOTION)) {
                    $promotion++;
                }
            }
        }

        return [
            'total' => $totalMessageUnread,
            'purchasedOpen' => $purchasedOpen,
            'purchasedNotOpen' => $purchasedNotOpen,
            'notPurchase' => $notPurchase,
            'promotion' => $promotion
        ];
    }

    /**
     * get last message other user of room
     *
     * @param DocumentSnapshot $room
     * @param int $currentUserId
     * @return mixed
     */
    private function getLastMessageOtherUser(DocumentSnapshot $room, int $currentUserId)
    {
        $roomData = $room->data();
        if ($roomData['teacher_id'] === $currentUserId) {
            return [
                'lastMessage' => $roomData['lastMessageStudent'],
                'lastSentDatetime' => $this->formatDatetimeFB($roomData['lastSentDatetimeStudent'])
            ];
        }

        if ($roomData['student_id'] === $currentUserId) {
            return [
                'lastMessage' => $roomData['lastMessageTeacher'] ?? null,
                'lastSentDatetime' => $this->formatDatetimeFB($roomData['lastSentDatetimeTeacher'] ?? null)
            ];
        }

        return null;
    }

    private function formatDatetimeFB($datetime)
    {
        if (!$datetime instanceof Timestamp) {
            return $datetime;
        }

        return Carbon::parse($datetime->formatAsString())->tz(config('app.timezone'))->toDateTime();
    }

    /**
     * Get info teacher message unread
     *
     * @param null $service
     */
    public function getTeacherMessageUnread($service = null)
    {
        $teacherId = auth('client')->id();
        $rooms = $this->firestore
            ->collection('rooms')
            ->where('teacher_id', '=', $teacherId)
            ->where('type', '!=', DBConstant::ROOM_TYPE_PROMOTION)
            ->documents();
        $totalMessageUnread = 0;
        $purchased = 0;
        $notPurchased = 0;

        foreach ($rooms->rows() as $room) {
            $data = $room->data();
            $lastMessage = $this->getLastMessageOtherUser($room, $teacherId);
            if (!$lastMessage || !$lastMessage['lastMessage'] || !$lastMessage['lastMessage']->snapshot()->exists()) {
                continue;
            }

            $lastMessageData = $lastMessage['lastMessage']->snapshot()->data();

            if (isset($lastMessageData['is_read']) && $lastMessageData['is_read']) {
                continue;
            }
            $totalMessageUnread++;
            if (in_array((int)$data['type'], [DBConstant::ROOM_TYPE_OPEN, DBConstant::ROOM_TYPE_CLOSE], true) &&
                in_array((int)$data['status'], [DBConstant::ROOM_STATUS_PURCHASED, DBConstant::ROOM_STATUS_TEACHER_CANCEL], true)
            ) {
                $purchased++;
            }

            if ((int)$data['type'] === DBConstant::ROOM_TYPE_PRIVATE ||
                in_array((int)$data['status'], [DBConstant::ROOM_STATUS_NOT_PURCHASED, DBConstant::ROOM_STATUS_STUDENT_CANCEL], true)
            ) {
                $notPurchased++;
            }
        }
        return [
            'totalMessageUnread' => $totalMessageUnread,
            'totalPurchasedUnread' => $purchased,
            'totalNotPurchasedUnread' => $notPurchased,
//            'totalSellers' => $totalSellers,
        ];
    }

    /**
     * Check if user had send message to course_schedule
     * True: update to purchase
     * False: no action
     * @param int $courseScheduleId
     * @param int $studentId
     * @param null $teacherId
     * @param null $status
     */
    public function updateRoomUserPurchase(int $courseScheduleId, int $studentId, $teacherId = null, $status = null)
    {
        $rooms = $this->firestore
            ->collection('rooms')
            ->where('courseScheduleId', '=', $courseScheduleId)
            ->where('student_id', '=', $studentId)
            ->documents();
        if (count($rooms->rows()) > 0) {
            $room = $rooms->rows()[0];

            $room->reference()
                ->update([
                    ['path' => 'status', 'value' => $status]
                ]);
        } else {
            if ($teacherId && $status === DBConstant::ROOM_STATUS_PURCHASED) {
                $this->createRoom($teacherId, $studentId, $courseScheduleId, DBConstant::ROOM_TYPE_OPEN, $status);
            } else {
                \Log::info('Loi teacherId null: ' . $courseScheduleId);
            }
        }
    }

    /**
     * Create new room chat
     */
    private function createRoom($teacherId, $studentId, $courseScheduleId, $type = DBConstant::ROOM_TYPE_OPEN, $status = DBConstant::ROOM_STATUS_NOT_PURCHASED, $restock = false)
    {
        return $this->firestore->collection('rooms')->add([
            'memberIds' => [
                $teacherId,
                $studentId
            ],
            'type' => $type,
            'status' => $status,
            'teacher_id' => $teacherId ?? null,
            'student_id' => $studentId ?? null,
            'courseScheduleId' => $courseScheduleId,
            'existMessage' => false,
            'lastSentDatetimeStudent' => false,
            'lastMessageStudent' => false,
            'lastSentDatetimeTeacher' => false,
            'lastMessageTeacher' => false,
            'enabledRequestRestock' => $restock,
            'createdAt' => Carbon::now(config('app.timezone'))
        ])->snapshot();
    }

    /**
     * update type room where student cancel courses
     * True: update to purchase
     * False: no action
     * @param int $courseScheduleId
     * @param int $studentId
     */
    public function updateRoomStudentCancel(int $courseScheduleId, int $studentId)
    {
        $rooms = $this->firestore
            ->collection('rooms')
            ->where('courseScheduleId', '=', $courseScheduleId)
//            ->where('memberIds', 'array-contains', $studentId)
            ->where('student_id', '=', $studentId)
//            ->where('type', '=', DBConstant::ROOM_PURCHASED)
            ->limit(1)
            ->documents();
        if (count($rooms->rows()) > 0) {
            $room = $rooms->rows()[0];
//            \Log::info('student cancel course schedule: ' . $room->id());
            $this->firestore->collection('rooms')
                ->document($room->id())
                ->update([
                    ['path' => 'status', 'value' => DBConstant::ROOM_STATUS_STUDENT_CANCEL]
                ]);
        }
    }

    /**
     * Get room id user Id
     *
     * @param int $courseScheduleId
     * @param int $studentId
     * @param int $type
     * @return string
     */
    public function getRoomIdCourseSchedule(int $courseScheduleId, int $studentId, int $type)
    {
        $teacherId = auth('client')->id();
        $rooms = $this->firestore
            ->collection('rooms')
            ->where('student_id', '=', $studentId)
            ->where('type', '=', $type)
            ->where('courseScheduleId', '=', $courseScheduleId)
            ->documents();
        if (count($rooms->rows()) > 0) {
            return $rooms->rows()[0]->id();
        }

        return $this->createRoom($teacherId, $studentId, null, DBConstant::ROOM_TYPE_OPEN, $type)->id();
    }

    // message

    /**
     * Get message unread
     */
    public function countMessageUnreadStudent()
    {
        $purchasedOpen = 0; // option1
        $purchasedNotOpen = 0; // option3
        $notPurchase = 0; // option4
        $promotion = 0; // option5
        $totalMessageUnread = 0;

        if (auth('client')->check()) {
            $studentId = auth('client')->id();
            $rooms = $this->firestore
                ->collection('rooms')
                ->where('student_id', '=', $studentId)
//                ->where('lastMessageTeacher', '!=', false)
                ->documents();

            foreach ($rooms->rows() as $room) {
                $data = $room->data();
                $lastMessage = $this->getLastMessageOtherUser($room, $studentId);
                if (!$lastMessage || !$lastMessage['lastMessage'] || !$lastMessage['lastMessage']->snapshot()->exists()) {
                    continue;
                }

                $lastMessageData = $lastMessage['lastMessage']->snapshot()->data();

                if (isset($lastMessageData['is_read']) && $lastMessageData['is_read']) {
                    continue;
                }
                $totalMessageUnread++;

                if (isset($data['courseScheduleId'])) {
                    if (!isset($data['type']) && !isset($data['status'])) {
                        continue;
                    }

                    if ((int)$data['type'] === DBConstant::ROOM_TYPE_OPEN && (int)$data['status'] === DBConstant::ROOM_STATUS_PURCHASED) {
                        $purchasedOpen++;
                    }
                    if ((int)$data['type'] === DBConstant::ROOM_TYPE_CLOSE &&
                        ((int)$data['status'] === DBConstant::ROOM_STATUS_PURCHASED || (int)$data['status'] === DBConstant::ROOM_STATUS_TEACHER_CANCEL)) {
                        $purchasedNotOpen++;
                    }
                    if ((int)$data['status'] === DBConstant::ROOM_STATUS_NOT_PURCHASED || (int)$data['status'] === DBConstant::ROOM_STATUS_STUDENT_CANCEL) {
                        $notPurchase++;
                    }
                } else {
                    if (!isset($data['type'])) {
                        continue;
                    }
                    if (((int)$data['type'] === DBConstant::ROOM_TYPE_PRIVATE)) {
                        $notPurchase++;
                    }
                    if (((int)$data['type'] === DBConstant::ROOM_TYPE_PROMOTION)) {
                        $promotion++;
                    }
                }
            }
        }

        return [
            'total' => $totalMessageUnread,
            'purchasedOpen' => $purchasedOpen,
            'purchasedNotOpen' => $purchasedNotOpen,
            'notPurchase' => $notPurchase,
            'promotion' => $promotion
        ];
    }

    /**
     * remove course schedule => null csId firebase
     * tester confirm
     */
    public function removeRoom(int $courseScheduleId)
    {
        $rooms = $this->firestore->collection('rooms')
            ->where('courseScheduleId', '=', $courseScheduleId)
            ->documents();

        foreach ($rooms->rows() as $room) {
            $room->reference()->update([['path' => 'courseScheduleId', 'value' => null]]);
        }
    }

    /**
     * update last message
     *
     * @param bool $isTeacher
     * @param DocumentReference $room
     * @param string $messageId
     */
    private function updateLastMessage(bool $isTeacher, DocumentReference $room, string $messageId)
    {
        $time = Carbon::now(config('app.timezone'));
        $path = $this->firestore->document('rooms/' . $room->id() . '/messages/' . $messageId);
        if ($isTeacher) {
            $data = [
                ['path' => 'lastSentDatetimeTeacher', 'value' => $time],
                ['path' => 'lastMessageTeacher', 'value' => $path]
            ];
        } else {
            $data = [
                ['path' => 'lastSentDatetimeStudent', 'value' => $time],
                ['path' => 'lastMessageStudent', 'value' => $path]
            ];
        }
        $data[] = ['path' => 'existMessage', 'value' => true];
        $room->update($data);
    }

    /**
     * update status, type room
     *
     * @param int $courseScheduleId
     * @param null $type
     * @param null $status
     */
    public function updateStatusRoomCourse(int $courseScheduleId, $type = null, $status = null)
    {
        if (is_null($type) && is_null($status)) {
            return;
        }

        $rooms = $this->firestore->collection('rooms')
            ->where('courseScheduleId', '=', $courseScheduleId)
            ->documents();

        foreach ($rooms->rows() as $room) {
            $data = [];
            if ($type) {
                $data[] = ['path' => 'type', 'value' => $type];
            }

            if ($status) {
                $data[] = ['path' => 'status', 'value' => $status];
            }
            $room->reference()->update($data);
        }

    }

    /**
     * send message v2
     */
    public function sendMessageSmart(string $message, int $teacherId, int $studentId, $courScheduleId, int $type, int $status, bool $update = false)
    {
        $rooms = $this->firestore->collection('rooms');
        if ($teacherId) {
            $rooms = $rooms->where('teacher_id', '=', $teacherId);
        }

        if ($studentId) {
            $rooms = $rooms->where('student_id', '=', $studentId);
        }

        $courScheduleId = $courScheduleId ?? null;
        $rooms = $rooms->where('courseScheduleId', '=', $courScheduleId)
            ->limit(1)
            ->documents();

        if (count($rooms->rows())) {
            $room = $rooms->rows()[0];
        } else {
            $room = $this->createRoom($teacherId, $studentId, $courScheduleId, $type, $status);
        }

        $newMessage = $room->reference()->collection('messages')
            ->add([
                'userId' => $this->firestore->document('users/' . $teacherId),
                'type' => Constant::MESSAGE_TYPE_TEXT,
                'message' => $message,
                'imageUrl' => null,
                'fileUrl' => null,
                'stickerUrl' => null,
                'userType' => DBConstant::USER_TYPE_TEACHER,
                'is_read' => false,
                'createdAt' => Carbon::now(config('app.timezone'))
            ]);

        $data = [
            ['path' => 'lastSentDatetimeTeacher', 'value' => Carbon::now(config('app.timezone'))],
            ['path' => 'lastMessageTeacher', 'value' => $this->firestore->document('rooms/' . $room->id() . '/messages/' . $newMessage->id())],
        ];
        if ($update) {
            if ($type) {
                $data[] = ['path' => 'type', 'value' => $type];
            }

            if ($status) {
                $data[] = ['path' => 'status', 'value' => $status];
            }
            $room->reference()->update($data);
        }
        $room->reference()->update($data);

    }

    /**
     * Get room id Room user - teacher 1 - 1
     * @param int $teacherId
     * @param int $userId
     * @return string
     */
    public function getRoomPrivateChat(int $teacherId, int $userId)
    {
        return $this->getDataRoomPrivateChat($teacherId, $userId)->id();
    }

    /**
     * Get room id Room user - teacher 1 - 1
     * @param int $teacherId
     * @param int $studentId
     * @return \Google\Cloud\Firestore\DocumentSnapshot
     */
    public function getDataRoomPrivateChat(int $teacherId, int $studentId)
    {
        $documents = $this->firestore
            ->collection('rooms')
            ->where('teacher_id', '=', $teacherId)
            ->where('student_id', '=', $studentId)
            ->where('courseScheduleId', '=', null)
            ->where('type', '=', DBConstant::ROOM_TYPE_PRIVATE)
            ->limit(1)
            ->documents();

        if (count($documents->rows()) > 0) {
            return $documents->rows()[0];
        }
        // create room chat
        return $this->createRoom($teacherId, $studentId, null, DBConstant::ROOM_TYPE_PRIVATE, DBConstant::ROOM_STATUS_NOT_PURCHASED);
    }

    /**
     * get list room chat by csId
     *
     * @param int $courseScheduleId
     * @param int $userId
     * @param null $type
     * @return array
     */
    public function getListRoomByCourseSchedule(int $courseScheduleId, int $userId, $type = null)
    {
        $docRef = $this->firestore
            ->collection('rooms')
            ->where('courseScheduleId', '=', $courseScheduleId);

        if ($type) {
            if (is_int($type)) {
                $docRef = $docRef->where('status', '=', $type);
            } elseif (is_array($type)) {
                $docRef = $docRef->where('status', 'in', $type);
            }
        }

        $docRef = $docRef->documents();
        $noMessage = true;
        $isRead = true;
        foreach ($docRef->rows() as $row) {
            $lastMessage = $this->getLastMessageOtherUser($row, $userId);
            if ($lastMessage && $lastMessage['lastMessage'] && $lastMessage['lastMessage']->snapshot()->exists()) {
                $noMessage = false;
                $isRead = $lastMessage['lastMessage']->snapshot()->data()['is_read'];
            }
        }

        return [
            'no_message' => $noMessage,
            'is_read' => $isRead
        ];
    }

    /**
     * get room chat by roomId
     *
     * @param string $roomId
     * @param int $userId
     * @return array
     */
    public function getRoomById(string $roomId, int $userId)
    {
        $docRef = $this->firestore
            ->collection('rooms')
            ->document($roomId);
        $snapshot = $docRef->snapshot();

        if ($snapshot->exists()) {
            $data = $snapshot->data();

            if ($data['teacher_id'] === $userId || $data['student_id'] === $userId) {
                return $data;
            }
        }

        return [];
    }

    /**
     * Send message to multi room by roomId
     *
     * @param array $roomIds
     * @param int $userId
     */
    public function sendMessageToRoomIds(array $roomIds, int $userId, string $message)
    {
        foreach ($roomIds as $roomId) {
            $this->sendMessageToRoomId($roomId, $userId, $message);
        }
    }

    /**
     * Send message to room by roomId
     *
     * @param string $roomId
     * @param int $userId
     * @param string $message
     */
    public function sendMessageToRoomId(string $roomId, int $userId, string $message)
    {
        $room = $this->firestore
            ->collection('rooms')
            ->document($roomId);
        $snapshot = $room->snapshot();

        if ($snapshot->exists()) {
            $data = $snapshot->data();

            if ((isset($data['teacher_id']) && $data['teacher_id'] === $userId) ||
                (isset($data['student_id']) && $data['student_id'] === $userId)) {
                $newMessage = $room->collection('messages')->add([
                    'userId' => $this->firestore->document('users/' . $userId),
                    'type' => Constant::MESSAGE_TYPE_TEXT,
                    'message' => $message,
                    'imageUrl' => null,
                    'fileUrl' => null,
                    'stickerUrl' => null,
                    'userType' => DBConstant::USER_TYPE_TEACHER,
                    'readMemberIds' => [
                        (int)$userId
                    ],
                    'is_read' => false,
                    'createdAt' => Carbon::now(config('app.timezone'))
                ]);

                $isTeacher = $data['teacher_id'] === $userId;
                $this->updateLastMessage($isTeacher, $room, $newMessage->id());
            }
        }
    }

    /**
     * get room chat promotion
     *
     * @param string $sort
     * @return array
     */
    public function getRoomPromotion(string $sort = 'DESC')
    {
        $userId = auth('client')->id();
        $documents = $this->firestore
            ->collection('rooms')
            ->where('student_id', '=', $userId)
            ->where('type', '=', DBConstant::ROOM_TYPE_PROMOTION)
            ->orderBy('lastSentDatetimeTeacher', $sort)
            ->documents()
            ->rows();

        $result = [];
        foreach ($documents as $document) {
            $data = $document->data();
            $lastMessage = $this->getLastMessageOtherUser($document, $userId);
            if (!$lastMessage || !$lastMessage['lastMessage'] || !$lastMessage['lastMessage']->snapshot()->exists()) {
                continue;
            }

            $lastMessageData = $lastMessage['lastMessage']->snapshot()->data();
            $data['roomId'] = $document->id();
            $data['isRead'] = $lastMessageData['is_read'] ?? false;
            $data['messageId'] = $lastMessage['lastMessage']->snapshot()->id();
            $data['lastMessage'] = $lastMessageData;
            $data['lastSentDatetime'] = $this->formatDatetimeFB($lastMessageData['createdAt']);
            $result[] = $data;
        }

        return $result;
    }

    public function updateIsRead($request)
    {
        $roomId = $request->roomId;
        $messageId = $request->messageId;

        if (!$roomId || !$messageId) {
            return false;
        }

        $message = $this->firestore
            ->collection('rooms')
            ->document($roomId)
            ->collection('messages')
            ->document($messageId);
        if ($message->snapshot()->exists()) {
            $message->update([['path' => 'is_read', 'value' => true]]);

            return true;
        }

        return false;
    }

    // livestream
    /**
     * Get
     * @param int $courseScheduleId
     */
    public function getLivestream(int $courseScheduleId)
    {
        $documents = $this->firestore
            ->document('live_streams/' . $courseScheduleId);

        if (!$documents->snapshot()->exists()) {
            $this->firestore->collection('live_streams')
                ->document($courseScheduleId)
                ->set([]);
        }
    }

    /**
     * Send
     *
     * @params $courseScheduleId
     * @params $message
     */
    public function sendLiveStreamComment($courseScheduleId, $message, $forceSend = false, $type = null)
    {
        $userId = auth('client')->id();
        $this->firestore->collection('live_streams/' . $courseScheduleId . '/comments')->add([
            'userId' => $this->firestore->collection('users')->document($userId),
            'message' => $message,
            'type' => $type,
            'createdAt' => Carbon::now(config('app.timezone'))
        ]);
        return true;
    }

    /**
     * remove room
     */
    public function deleteRoomStudent($userId)
    {
        $rooms = $this->firestore->collection('rooms')
            ->where('student_id', '=', $userId)
            ->documents();

        foreach ($rooms->rows() as $room) {
            $room->reference()->delete();
        }
    }

    /**
     * remove room
     */
    public function deleteRoomTeacher($userId)
    {
        $rooms = $this->firestore->collection('rooms')
            ->where('teacher_id', '=', $userId)
            ->documents();

        foreach ($rooms->rows() as $room) {
            $room->reference()->delete();
        }
    }
}
