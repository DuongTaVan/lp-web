<?php

declare(strict_types=1);

namespace App\Services\Common;

use App\Enums\DBConstant;
use App\Mail\IdentityVerification;
use App\Repositories\ImagePathRepository;
use App\Repositories\TransferHistoryRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Traits\RealtimeTrait;
use Illuminate\Support\Facades\Mail;

class UserService extends BaseService
{
    use RealtimeTrait;
    private $imagePathRepository;

    /**
     * TeacherService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->imagePathRepository = app(ImagePathRepository::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return UserRepository::class;
    }

    /**
     * @param string $personId
     * @param string $status
     */
    public function verifyIdentity(string $personId, string $status)
    {
        $user = $this->repository->where('str_person_id', $personId)->first();
        if (!$user) {
            return;
        }
        if ($status === 'verified') {
            $session = DBConstant::CONNECT_VERIFICATION_SESSION_SUCCESS;
            $identity = DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED;
            Mail::to($user->email)->queue(new IdentityVerification('【Lappi】本人確認完了のお知らせ。',  $user->full_name, true));
            // update all image identity
            $this->imagePathRepository->identityImage($user->user_id, DBConstant::IMAGE_PATH_STATUS['approved']);
            \Log::debug('【Lappi】本人確認完了のお知らせ。');
        } else if ($user->connect_verification_session !== DBConstant::CONNECT_VERIFICATION_SESSION_SUCCESS) {
            $session = DBConstant::CONNECT_VERIFICATION_SESSION_FAIL;
            $identity = DBConstant::IDENTITY_VERIFICATION_STATUS_REJECTED;
            Mail::to($user->email)->queue(new IdentityVerification('【Lappi】本人確認の審査否認のお知らせ。',  $user->full_name, false));
            $this->imagePathRepository->identityImage($user->user_id, DBConstant::IMAGE_PATH_STATUS['reject']);
            \Log::debug('【Lappi】本人確認の審査否認のお知らせ。');
        }
        if (isset($session)) {
            $user->connect_verification_session = $session;
        }
        if (isset($identity)) {
            $user->identity_verification_status = $identity;
        }
        $user->connect_verification_read = DBConstant::CONNECT_VERIFICATION_NOT_READ;
        $user->save();

        try {
            $this->sendEvent('realtime', [
                'url' => '/portal/business/business-verification-image',
                'screen' => 'BUSINESS',
                'id' => $user->user_id
            ]);
            $this->sendEvent('realtime', [
                'url' => '/portal/identity/identity-verification-image',
                'screen' => 'IDENTITY',
                'id' => $user->user_id
            ]);
        } catch (\Exception $e) {}
    }
}
