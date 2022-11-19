<?php

namespace App\Services\Portal;

use App\Enums\DBConstant;
use App\Mail\VerifyImage;
use App\Repositories\ImagePathRepository;
use Illuminate\Support\Facades\Mail;

class IdentityImageService extends BaseService
{
    /**
     * Image Path repository class
     *
     * @return string
     */
    public function repository()
    {
        return ImagePathRepository::class;
    }

    /**
     * Show identity verification image list.
     *
     * @param $request
     * @return mixed
     */
    public function getIdentityVerificationImage($request)
    {
        return $this->repository->getIdentityVerificationImage($request);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getDetail(int $id)
    {
        return $this->repository->getIdentityDetail($id);
    }

    /**
     * Approve identity verification image
     *
     * @param $request
     * @param $id $image_path_id
     * @return mixed
     */
    public function approve($request, $id, $userName)
    {
        $email = $this->repository->join('users', 'users.user_id', '=', 'image_paths.user_id')
            ->where('id', $id)->select('email', 'image_paths.user_id')->firstOrFail();
        if ($request->status == DBConstant::IMAGE_PATH_STATUS['approved']) {
            Mail::to($email->email)->queue(new VerifyImage('【Lappi】本人確認完了のお知らせ', 0, $userName));
        } else {
            Mail::to($email->email)->queue(new VerifyImage('【Lappi】本人確認非承認のお知らせ', 1, $userName));
        }
        $data = $request->only('status');
        return $this->repository->where(['user_id' => $email->user_id, 'type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION])->update($data);
    }

    /**
     * Count identity not verification image.
     *
     * @return mixed
     */
    public function countIdentityNotVerificationImage()
    {
        return $this->repository->countIdentityNotVerificationImage();
    }

    /**
     * Business not verification image.
     *
     * @return mixed
     */
    public function businessNotVerificationImage()
    {
        return $this->repository->businessNotVerificationImage();
    }
}
