<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Write debug log.
     *
     * @param string     $message
     * @param null|array $context
     */
    protected function logDebug(string $message, $context = null): void
    {
        Log::debug($message, ['context' => $context]);
    }

    /**
     * Write info log.
     *
     * @param string     $message
     * @param null|array $context
     */
    protected function logInfo(string $message, $context = null): void
    {
        Log::info($message, ['context' => $context]);
    }

    /**
     * Write warning log.
     *
     * @param string     $message
     * @param null|array $context
     */
    protected function logWarning(string $message, $context = null): void
    {
        Log::warning($message, ['context' => $context]);
    }

    /**
     * Write error log.
     *
     * @param string     $message
     * @param null|array $context
     */
    protected function logError(string $message, $context = null): void
    {
//        Log::error($message, ['context' => $context]);
    }

    /**
     * Write alert log.
     *
     * @param string     $message
     * @param null|array $context
     */
    protected function logAlert(string $message, $context = null): void
    {
        Log::alert($message, ['context' => $context]);
    }
}
