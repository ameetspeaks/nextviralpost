<?php

namespace App\Notifications;

use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $subscription;

    public function __construct(UserSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Subscription Has Expired')
            ->line('Your subscription to ' . $this->subscription->subscription->name . ' has expired.')
            ->line('To continue using our services, please renew your subscription.')
            ->action('Renew Subscription', route('subscription.select'))
            ->line('Thank you for using our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'subscription_id' => $this->subscription->id,
            'message' => 'Your subscription has expired. Please renew to continue using our services.',
            'action_url' => route('subscription.select'),
        ];
    }
} 