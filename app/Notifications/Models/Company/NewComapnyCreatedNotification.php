<?php

namespace App\Notifications\Models\Company;

use App\Models\Company;
use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Broadcasting\Channel;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewComapnyCreatedNotification extends Notification
{
    use Queueable;

    public $user;
    public $company;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Company $company)
    {
        $this->user = $user;
        $this->company = $company;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'mail',
            'database',
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['notifications.' . $this->user->uuid];
    }


    public function broadcastAs()
    {
        return 'new-company-created';
    }

    /**
     * Get the type of the notification being broadcast.
     *
     * @return string
     */
    public function broadcastType()
    {
        return 'broadcast';
    }

    /**
     * Get the type of the notification being broadcast.
     *
     * @return string
     */
    public function databaseType()
    {
        return 'new-company-created';
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new \App\Mail\Models\Company\NewCompanyCreatedMail($user, $company));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
