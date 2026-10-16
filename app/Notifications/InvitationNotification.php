<?php

namespace App\Notifications;

use App\Models\Invitation;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitationNotification extends Notification
{
    public function __construct(public Invitation $invitation)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $companyName = $this->invitation->company->name;

        return (new MailMessage)
            ->subject("You're invited to join {$companyName}")
            ->greeting($this->invitation->name ? "Hi {$this->invitation->name}," : 'Hello!')
            ->line("You have been invited to join {$companyName} as {$this->invitation->role}.")
            ->action('Accept Invitation', route('invitations.show', $this->invitation->token))
            ->line('This link expires on '.$this->invitation->expires_at->format('d M Y').'.');
    }
}
