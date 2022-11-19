<?php


namespace App\Services\Common;


use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Jobs\SendNotifyMail;
use App\Mail\SendMailNotify;
use App\Repositories\PromotionalMessageRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Mail;

class MessageService extends BaseService
{
    private $userRepository;

    /**
     * CourseService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return PromotionalMessageRepository::class;
    }

    /**
     * Get messages
     *
     * @param $request
     * @return array
     */
    public function list($request)
    {
        try {
            $perPage = $request->perpage ?? Constant::PER_PAGE_DEFAULT;

            return [
                'success' => true,
                'data' => $this->repository->list($perPage)
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    /**
     * Send email when enable notify
     *
     * @param array $toUserIds
     */
    public function sendEmailNotify($fromUserId, array $toUserIds, string $message, $url)
    {
        if (!count($toUserIds)) {
            return;
        }

        $emails = $this->userRepository
            ->join('notification_settings as ns', 'ns.user_id', '=', 'users.user_id')
            ->where('ns.message', DBConstant::NOTIFICATION_SETTING_ENABLED)
            ->whereIn('users.user_id', $toUserIds)
            ->pluck('email')->toArray();

        $user = $this->userRepository
            ->getUserDetail($fromUserId);

//        foreach ($emails as $email) {
//            $emailJob = new SendNotifyMail($user->full_name, $email, $message, $url);
//            dispatch($emailJob);
//        }
    }
}
