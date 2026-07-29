<?php

namespace App\Jobs\ApplicationJobs;

use App\Mail\ApplicationMails\NewApplyMails\ApplicationSubmittedStudentMail;
use App\Mail\ApplicationMails\NewApplyMails\NewApplicantCompanyMail;
use App\Models\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewApplyMailJob implements ShouldQueue
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
        $application = $this->application->load(
            'student.user',
            'internship.company.user'
        );

        $studentUser = $application->student->user;

        $companyUser = $application->internship->company->user;

        Log::info('Sending a mail to the student');
        Log::info($studentUser);


        Log::info('Sending a mail to the company user');
        Log::info($companyUser);

        // Mail::to($studentUser->email)->send(new ApplicationSubmittedStudentMail($studentUser));
        // Mail::to($companyUser->email)->send(new NewApplicantCompanyMail($companyUser));
    }

    public function failed($exception = null)
    {
        Log::info('Sending new apply email failed!');
    }
}
