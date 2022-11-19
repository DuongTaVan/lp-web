<?php

namespace App\Console\Commands;

use App\Services\Batch\TeacherRankService;
use Illuminate\Console\Command;

class ChangeTeacherRankCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teacher-rank:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change teacher rank ';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(TeacherRankService $service)
    {
        $result = $service->changeTeacherRank();

//        if ($result['success']) {
//            $this->logInfo('Batch 09  success');
//        } else {
//            $this->logError('Batch 09  run failed: ' . $result['message']);
//        }

        return true;
    }
}
