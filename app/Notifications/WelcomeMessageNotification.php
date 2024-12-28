<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class WelcomeMessageNotification extends Notification
{
    use Queueable;

    public $_data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($_data)
    {
        $this->_data = $_data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $_data = $this->_data;
        $user = $_data['user'];

        $app_title = env('APP_TITLE');
    
        return (new MailMessage)
            ->subject("Welcome to {$app_title} website")
            ->greeting("Hello {$user['first_name']},")
            ->line(new HtmlString("Welcome to the {$app_title} website! We're thrilled to have you join our community."))
            ->line(new HtmlString("Explore our features and stay updated with the latest events, attractions, and activities in Lemery."))
            ->line(new HtmlString("Feel free to personalize your profile, and discover what our platform has to offer."))
            ->line(new HtmlString(""))
            ->line(new HtmlString("If you have any questions or need assistance, don't hesitate to reach out to our support team."))
            ->line(new HtmlString(''))
            ->salutation(new HtmlString("Best Regards, <br /><i>{$app_title} Administrator</i>"));
    }
    
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $_data = $this->_data;
        $user = $_data['user'];

        $app_title = env('APP_TITLE');
        
        $url = env('FRONTEND_APP_URL').'/welcome';
    
        return [
            'url' => $url,
            'action' => 'View',
            'subject' => "Welcome to {$app_title} website",
            'message' => "Thank you for signing up to the {$app_title} website. Explore our features and stay updated with the latest events, attractions, and activities in Lemery."
        ];
    }    
}