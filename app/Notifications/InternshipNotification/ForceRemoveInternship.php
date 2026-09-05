<?php

namespace App\Notifications\InternshipNotification;

use App\Enum\Notification\NotificationTypeEnum;
use App\Models\Internship;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ForceRemoveInternship extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public readonly Internship $internship,
        public readonly string $reason
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $internshipUrl = config('app.frontend_url') . "/internship/{$this->internship->id}";

        return (new MailMessage)
            ->subject("Internship Posting Removed: {$this->internship->title}")
            ->view('emails.internship.internship-force-deleted', [
                'userName' => $this->internship->company->company_name,
                'internshipTitle' => $this->internship->title,
                'internshipUrl' => $internshipUrl,
                'reason' => $this->reason,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => NotificationTypeEnum::Warning->value,
            'internship' => $this->internship->id,
            'title' => 'Posted internsihip deleted',
            'message' => "Your posted internship has been deleted by the admin! View email for cause of deletion",
        ];
    }
}
