<?php

namespace App\Http\Controllers\Portal;

use App\Enums\DBConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\IdentityVerificationImageListRequest;
use App\Http\Requests\Portal\ImagePathRequest;
use App\Services\Portal\ImagePathService;
use App\Services\Portal\IdentityImageService;
use App\Services\Portal\UserService;
use App\Traits\RealtimeTrait;
use Illuminate\Http\Request;

class ImagePathController extends Controller
{
    use RealtimeTrait;
    /**
     * show business verification image
     *
     * @param ImagePathRequest $request
     * @param ImagePathService $imagePathService
     * @return \Illuminate\View\View|mixed
     */
    public function index(ImagePathRequest $request, ImagePathService $imagePathService)
    {
        $data = $imagePathService->getImagePathList($request);
        $searchParams = $request->all();

        return view('portal.modules.businessImage.list')->with([
            'data' => $data,
            'searchParams' => $searchParams
        ]);
    }

    public function getDetailIdentity(Request $request, int $id, IdentityImageService $service)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $data = $service->getDetail($id);
            $html = $data ? view('portal.components.realtime.identity', compact('data'))->render() : '';

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function getCountIdentity(Request $request, UserService $service)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $data = $service->countIdentityNotVerificationImage();

            return response()->json([
                'success' => true,
                'count' => $data
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function getCountBusiness(Request $request, IdentityImageService $service)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $data = $service->businessNotVerificationImage();

            return response()->json([
                'success' => true,
                'count' => $data
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function getDetailBusiness(Request $request, int $id, ImagePathService $service)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $data = $service->getDetail($id);
            $html = $data ? view('portal.components.realtime.business', compact('data'))->render() : '';

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * approve reject applying business image path
     *
     * @param ImagePathRequest $request
     * @param ImagePathService $imagePathService
     * @return \Illuminate\View\View|mixed
     */
    public function approveBusinessVerificationImage(ImagePathRequest $request, ImagePathService $imagePathService, UserService $userService)
    {
        $parts = parse_url(url()->previous());
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
        }else {
            $query = [];
        }
        if(!in_array($request->status, DBConstant::IMAGE_PATH_STATUS) && $request->status > DBConstant::IMAGE_PATH_STATUS['applying']) {
            return redirect()->route('portal.business.business-verification-image')->with('message', trans('message.approve_business_image_fail'));
        }

        $userService->repository->where('user_id', $request->user_id)->update(['business_card_verification_status' => $request->status_user]);
        $user = $userService->repository->where('user_id', $request->user_id)->first();
        $data = $imagePathService->approve($request, $user->full_name);
        try {
            $this->sendEvent('realtime', [
                'url' => '/portal/business/business-verification-image',
                'screen' => 'BUSINESS',
                'id' => $request->user_id
            ]);
        } catch (\Exception $e) {}
        if ($data && $request->status == DBConstant::IMAGE_PATH_STATUS['approved']) {
            return redirect()->route('portal.business.business-verification-image', $query)->with('message', trans('message.approve_business_image_success'));
        }

        return redirect()->route('portal.business.business-verification-image', $query)->with('message', trans('message.reject_business_image_success'));
    }

    /**
     * Show identity verification image list.
     *
     * @param IdentityVerificationImageListRequest $request
     * @param IdentityImageService $identityImageService
     * @return mixed
     */
    public function getIdentityVerificationImage(IdentityVerificationImageListRequest $request, IdentityImageService $identityImageService)
    {
        $searchParams = $request->all();
        $imagePaths = $identityImageService->getIdentityVerificationImage($request);

        return view('portal.modules.identityImage.list')->with([
            'data' => $imagePaths,
            'searchParams' => $searchParams,
        ]);
    }

    /**
     * Approve identity verification image
     *
     * @param Request $request
     * @param $id $image_path_id
     * @param IdentityImageService $identityImageService
     * @param UserService $userService
     * @return mixed
     */
    public function approveIdentityVerificationImage(Request $request, $id, IdentityImageService $identityImageService, UserService $userService )
    {
        $parts = parse_url(url()->previous());
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
        }else {
            $query = [];
        }

        if(!in_array($request->status, DBConstant::IMAGE_PATH_STATUS) && $request->status > DBConstant::IMAGE_PATH_STATUS['applying']) {
            return redirect()->route('portal.identity.identity-verification-image')->with('message', trans('message.approve_identity_image_fail'));
        }

        $userService->repository->where('user_id', $request->user_id)->update(['identity_verification_status' => $request->status_user]);
        $user = $userService->repository->where('user_id', $request->user_id)->first();
        $data = $identityImageService->approve($request, $id, $user->full_name);
        if ($data && $request->status == DBConstant::IMAGE_PATH_STATUS['approved']) {
            return redirect()->route('portal.identity.identity-verification-image',$query)->with('message', trans('message.approve_identity_image_success'));
        }

        return redirect()->route('portal.identity.identity-verification-image', $query)->with('message', trans('message.reject_identity_image_success'));
    }
}

