<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\ErrorType;
use App\Enums\LogLevel;
use App\Exceptions\NoAccountException;
use App\Http\Requests\RefreshJwtRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends ApiBaseController
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Issue JWT token for development use.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getJwtForDevelopment(int $userId): JsonResponse
    {
        $user = User::where('user_id', $userId)->first();
        if (!$user) {
            throw new NoAccountException();
        }

        // Generate JWT response
        $result = $this->generateJwtResponse($user);

        return $this->sendSuccess($result, 'Issued test tokens successfully.');
    }

    /**
     * Refresh JWT token.
     *
     * @param RefreshJwtRequest $request
     * @return JsonResponse
     */
    public function refreshJwt(RefreshJwtRequest $request): JsonResponse
    {
        try {
            // Check if JWT exists
            if (!$token = JWTAuth::getToken()) {
                return $this->sendError(ErrorType::CODE_4000, __('errors.MSG_4000'), ErrorType::STATUS_4000, LogLevel::DEBUG);
            }
        } catch (JWTException $e) {
            $this->logDebug('JWT is invalid.');
        }

        // Get user ID from JWT
        $payload = JWTAuth::decode($token);
        $userId = $payload['sub'];

        // Get user entity
        $user = User::find($userId);
        if (!$user) {
            throw new NoAccountException();
        }

        // Delete the currently registered refresh token
        $this->refreshTokenService->checkValidRefreshToken($userId, $request->refresh_token);

        $result = $this->generateJwtResponse($user);

        return $this->sendSuccess($result, 'Refresh a token successfully.');
    }
}
