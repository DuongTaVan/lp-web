<?php

namespace App\Services\Client\Common;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Repositories\ImagePathRepository;
use App\Services\BaseService;

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
     * upload image to s3
     *
     * @param $request
     * @return array
     */
    public function uploadImage($request)
    {
        $file = $request->file;
        $userId = $request->userId ?? Auth('client')->id();
        $path = $request->path ?? "users/$userId/" . Constant::DIRECTORY_PATH['background'];
        $type = $request->type;

        return $this->repository->uploadUserImage($file, $userId, $path, $type);
    }

    /**
     * upload image to s3
     *
     * @param $request
     * @return array
     */
    public function removeImage($request)
    {
        $imageS3Url = $request->path;
        $explodeUrl = explode('/', $imageS3Url);
        $fileName = end($explodeUrl);
        // delete 3 first and 1 last item to get path
        array_pop($explodeUrl);
        $explodeUrl = array_slice($explodeUrl, 3);
        $path = implode('/', $explodeUrl);
        return $this->repository->removeUserImage($path, $fileName);
    }

    /**
     * get list image
     *
     * @param int $userId
     * @param int $type
     * @return array
     */
    public function getListImage(int $userId, int $type)
    {
        return $this->repository
            ->findWhere([
                'user_id' => $userId,
                'type' => $type
            ]);
    }
}
