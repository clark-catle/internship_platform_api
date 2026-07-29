<?php

namespace App\Jobs\ApplicationJobs;

use App\Mail\ApplicationMails\StudentApplicationDecisionStageMail;
use App\Models\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ApplicationDecisionStageMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 4;

    public int $backOff = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(public Application $application) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $application = $this->application->load(['student.user']);

        $studentUser = $application->student->user;

        Log::info('Sending decision stage email to student application!');
        Log::info($studentUser);
        // Mail::to($studentUser->email)->send(new StudentApplicationDecisionStageMail($studentUser));
    }

    public function failed($exception = null)
    {
        Log::info('Sending decision stage email to student application failed!');
    }
}
