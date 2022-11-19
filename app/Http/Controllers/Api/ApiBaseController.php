<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\LogLevel;
use App\Exceptions\NoAccountException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\RefreshTokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use JWTAuth;

class ApiBaseController extends Controller
{
    protected $refreshTokenService;

    public function __construct(RefreshTokenService $refreshTokenService)
    {
        $this->refreshTokenService = $refreshTokenService;
    }

    /**
     * @param $code
     * @param $message
     * @param $status
     * @param $logLevel
     * @return JsonResponse
     */
    protected function sendError($code, $message, $status, $logLevel = LogLevel::ERROR): JsonResponse
    {
        // Log context
        $context = $this->getContext($code);

        if ($logLevel == LogLevel::DEBUG) {
            Log::debug($message, $context);
        } elseif ($logLevel == LogLevel::INFO) {
            Log::info($message, $context);
        } elseif ($logLevel == LogLevel::WARNING) {
            Log::warning($message, $context);
        } elseif ($logLevel == LogLevel::ERROR) {
            Log::error($message, $context);
        } elseif ($logLevel == LogLevel::ALERT) {
            Log::alert($message, $context);
        }

        $response = [
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
        ];

        return response()->json($response, $status);
    }

    /**
     * Generate JWT and refresh token.
     *
     * @param User $user
     * @return array
     */
    protected function generateJwtResponse(User $user): array
    {
        // Generate JWT
        if (!empty($user)) {
            $token = JWTAuth::fromUser($user);
        } else {
            throw new NoAccountException();
        }

        // Generate a refresh token and store in database
        $refreshToken = $this->refreshTokenService->generateRefreshToken($user->id);

        $response = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => env('JWT_TTL'),
            'refresh_token' => $refreshToken,
        ];

        return $response;
    }

    /**
     * Write debug log.
     *
     * @param $message
     */
    protected function logDebug($message): void
    {
        // Log context
        $context = $this->getContext();

        Log::debug($message, $context);
    }

    /**
     * Write info log.
     *
     * @param $message
     */
    protected function logInfo($message): void
    {
        // Log context
        $context = $this->getContext();

        Log::info($message, $context);
    }

    /**
     * Write warning log.
     *
     * @param $message
     */
    protected function logWarning($message): void
    {
        // Log context
        $context = $this->getContext();

        Log::warning($message, $context);
    }

    /**
     * Get log context.
     *
     * @param $code
     * @return array
     */
    private function getContext($code = null): array
    {
        if ($code) {
            return $context = [
                'code' => $code,
                'user_id' => Auth::check() ? Auth::user()->id : null,
                'input' => request()->all(),
            ];
        }

        return $context = [
                'user_id' => Auth::check() ? Auth::user()->id : null,
                'input' => request()->all(),
            ];
    }
}
