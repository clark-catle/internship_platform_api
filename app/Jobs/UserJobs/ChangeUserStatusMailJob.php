<?php

namespace App\Jobs\UserJobs;

use App\Mail\UserMails\ChangeUserStatusMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ChangeUserStatusMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backOff = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly User $user) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('sending change status email using job');
        // Mail::to($this->user->email)->send(new ChangeUserStatusMail($this->user));
    }

    public function failed($exception = null)
    {
        Log::info('sending change status email FAILS using job');
    }
}
