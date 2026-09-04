<?php

namespace App\Notifications\CompanyNotifications;

use App\Enum\Notification\NotificationTypeEnum;
use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public readonly Company $company)
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
        $companyUrl = config('app.frontend_url') . "/profile";

        return (new MailMessage)
            ->subject("Your Company Has Been Verified")
            ->view('emails.company.company-verified', [
                'companyName' => $this->company->company_name,
                'companyUrl' => $companyUrl,
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
            'title' => 'Company account verified',
            'message' => "Your company account has been verified by the admin!",
        ];
    }
}
