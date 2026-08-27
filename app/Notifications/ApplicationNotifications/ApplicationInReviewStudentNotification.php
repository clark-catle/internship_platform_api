<?php

namespace App\Notifications\ApplicationNotifications;

use App\Enum\Notification\NotificationTypeEnum;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationInReviewStudentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public readonly Application $application)
    {
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
        $applicationUrl = config('app.frontend_url') . "/applications/{$this->application->id}";

        return (new MailMessage)
            ->subject("Your Application for {$this->application->internship->title} Has Been Viewed")
            ->view('emails.application.application-viewed', [
                'userName' => $notifiable->name,
                'companyName' => $this->application->internship->company->name,
                'internshipTitle' => $this->application->internship->title,
                'applicationUrl' => $applicationUrl,
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
            'type' => NotificationTypeEnum::Success->value,
            'application_id' => $this->application->id,
            'title' => 'Application Viewed',
            'message' => "Your application for {$this->application->internship->title} has been viewed",
        ];
    }
}
