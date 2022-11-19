<?php

namespace App\Services\Portal;

use App\Enums\DBConstant;
use App\Mail\BusinessVerifyImage;
use App\Mail\VerifyImage;
use App\Repositories\ImagePathRepository;
use Illuminate\Support\Facades\Mail;

class ImagePathService extends BaseService
{
    /**
     * User repository class
     *
     * @return string
     */
    public function repository()
    {
        return ImagePathRepository::class;
    }

    /**
     * Get data to show on Show identity verification image list
     *
     * @param $request
     * @return array
     */
    public function getImagePathList($request)
    {
        // 1-1 Get images.
        $images = $this->repository->getImageData($request);
        return [
            'images' => $images
        ];
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getDetail(int $id)
    {
        return $this->repository->getDetail($id);
    }

    /**
     * Approve business verification image
     *
     * @param $request
     * @param $id $image_path_id
     * @return mixed
     */
    public function approve($request, $user_name)
    {
        $email = $this->repository->join('users', 'users.user_id', '=', 'image_paths.user_id')
            ->where('id', $request->id)->select('email')->firstOrFail();
        if ($request->status == DBConstant::IMAGE_PATH_STATUS['approved']) {
            Mail::to($email)->queue(new BusinessVerifyImage('資格証明画像承認', 0 , $user_name));
        } else {
            Mail::to($email)->queue(new BusinessVerifyImage('資格証明画像非承認', 1 , $user_name));
        }

        $request->merge(['updated_at' => now()]);

        return $this->repository->update($request->all(), $request->id);
    }
}
