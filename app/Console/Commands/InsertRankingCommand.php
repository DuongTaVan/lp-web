<?php

namespace App\Console\Commands;

use App\Services\Batch\RankingService;
use Illuminate\Support\Facades\Cache;

class InsertRankingCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ranking:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ranking batch';

    /**
     * Execute the console command.
     *
     * @param RankingService $service
     * @return bool
     */
    public function handle(RankingService $service): bool
    {
        $data = $service->batch06();

        if ($data['success']) {
            Cache::forget('rankings/skills:popular_courses');
            Cache::forget('rankings/consultation:popular_courses');
            Cache::forget('rankings/fortunetelling:popular_courses');
//            $this->logInfo('Batch 06 (Ranking batch) run success');

        }
//        else {
//            $this->logError('Batch 06 (Ranking batch) run failed: ' . $data['message']);
//        }

        return true;
    }
}
