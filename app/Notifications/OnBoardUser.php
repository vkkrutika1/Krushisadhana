<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OnBoardUser extends Notification
{
    use Queueable;
    public $resetUrl = '';
    public $welcomeName = '';
    /**
     * Create a new notification instance.
     */
    public function __construct($name, $url)
    {
        $this->resetUrl = $url; 
        $this->welcomeName = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line("Welcome $this->welcomeName,")
                    ->line('By clicking the below button you will be able to create new password and onboard into portal')
                    ->action('On Board', $this->resetUrl)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
