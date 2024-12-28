<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserEmailVerificationNotification extends Notification
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

        $verify_url = env('APP_URL')."/user/verified?code={$user['remember_token']}&email={$user['email']}";

        return (new MailMessage)
            ->subject("Welcome to Lemery Tourism website: Complete Your Registration")
            ->greeting("Hello,")
            ->line(new HtmlString("Thank you for signing up with Lemery Tourism website! We're excited to have you on board."))
            ->line(new HtmlString(""))
            ->line(new HtmlString("To complete your registration and verify your email address, please click the link below:"))
            ->line(new HtmlString(""))
            ->line(new HtmlString("<a href='{$verify_url}' style='text-decoration: none;'>Confirm Your Email Address</a>"))
            ->line(new HtmlString(''))
            ->line(new HtmlString("If you did not create an account with us, please ignore this email."))
            ->line(new HtmlString('If you have any questions or need assistance, feel free to reach out to our support team at [support@example.com].'))
            ->line(new HtmlString(''))
            ->salutation(new HtmlString('Best Regards, <br /><i>Lemery Tourism Administrator</i>'));
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
        
        $url = env('FRONTEND_APP_URL').'';

        return [
            'url' => $url,
            'action' => 'View',
            'subject' => "Welcome to Lemery Tourism website.",
            'message' => "Thank you for signing up to the Lemery Tourism website. Explore our features and stay updated with the latest events, attractions, and activities in Lemery."
        ];
    }
}