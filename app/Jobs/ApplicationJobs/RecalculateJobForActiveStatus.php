<?php

namespace App\Jobs\ApplicationJobs;

use App\Models\Internship;
use App\Services\InternshipService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class RecalculateJobForActiveStatus implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly Internship $internship,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(InternshipService $internship): void
    {
        $internship->recalculateActiveStatus($this->internship);
    }

    public function failed($exception = null)
    {
        Log::error('recalculating internship or active status was failed', [$exception]);
    }
}
