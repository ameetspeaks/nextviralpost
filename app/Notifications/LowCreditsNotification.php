<?php

namespace App\Notifications;

use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowCreditsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $subscription;
    protected $remainingCredits;

    public function __construct(UserSubscription $subscription, $remainingCredits)
    {
        $this->subscription = $subscription;
        $this->remainingCredits = $remainingCredits;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Low Credits Alert')
            ->line('You have ' . $this->remainingCredits . ' credits remaining in your subscription.')
            ->line('To avoid interruption of service, please consider upgrading your subscription.')
            ->action('Upgrade Subscription', route('subscription.select'))
            ->line('Thank you for using our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'subscription_id' => $this->subscription->id,
            'remaining_credits' => $this->remainingCredits,
            'message' => 'You have ' . $this->remainingCredits . ' credits remaining.',
            'action_url' => route('subscription.select'),
        ];
    }
} 