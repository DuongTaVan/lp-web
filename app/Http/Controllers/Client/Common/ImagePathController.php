<?php

namespace App\Http\Controllers\Client\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Common\ImagePathUploadRequest;
use App\Services\Client\Common\ImagePathService;
use Illuminate\Http\Request;

class ImagePathController extends Controller
{
    protected $imagePathService;

    public function __construct()
    {
        $this->imagePathService = app(ImagePathService::class);
    }

    /**
     * upload Image
     *
     * @param Request $request
     */
    function uploadImage(ImagePathUploadRequest $request)
    {
        return $this->imagePathService->uploadImage($request);
    }

    /**
     * remove Image
     *
     * @param Request $request
     */
    function removeImageBackground(Request $request)
    {
        return $this->imagePathService->removeImage($request);
    }

    function getContent(Request $request)
    {
        return 'data:image/png;base64,' . base64_encode(file_get_contents($request->image));
    }
}
