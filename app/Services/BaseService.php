<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\DBConstant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

abstract class BaseService
{
    /**
     * @var $repository
     */
    public $repository;

    /**
     * HomeService constructor.
     */
    public function __construct()
    {
        $this->repository = app($this->repository());
    }

    /**
     * Abstract repository
     *
     * @return string
     */
    public abstract function repository();

    /**
     * Write debug log.
     *
     * @param string $message
     * @param string|null $code
     */
    protected function logDebug(string $message, string $code = null): void
    {
        // Log context
        $context = $this->getContext($code);

        Log::debug($message, $context);
    }

    /**
     * Write info log.
     *
     * @param string $message
     * @param string|null $code
     */
    protected function logInfo(string $message, string $code = null): void
    {
        // Log context
        $context = $this->getContext($code);

        Log::info($message, $context);
    }

    /**
     * Write warning log.
     *
     * @param string $message
     * @param string|null $code
     */
    protected function logWarning(string $message, string $code = null): void
    {
        // Log context
        $context = $this->getContext($code);

        Log::warning($message, $context);
    }

    /**
     * Get guard
     *
     * @param string $guard
     * @return void
     */
    protected function getGuard(string $guard = 'user')
    {
        return Auth::guard($guard);
    }

    /**
     * Check Admin User
     *
     * @return bool
     */
    public function isAdminUser()
    {
        return Auth::user()->user_type === DBConstant::MGMT_PORTAL_USER_TYPE_ADMIN_USER;
    }

    /**
     * Check client user
     *
     * @return bool
     */
    public function isClientUser()
    {
        return Auth::user()->user_type === DBConstant::MGMT_PORTAL_USER_TYPE_CLIENT_USER;
    }
}
