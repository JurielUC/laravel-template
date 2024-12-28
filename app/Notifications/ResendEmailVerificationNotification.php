<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ResendEmailVerificationNotification extends Notification
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
            ->subject("Email Verification Link Resent: Complete Your Registration")
            ->greeting("Hello,")
            ->line(new HtmlString("We noticed that you haven't confirmed your email address yet. To complete your registration with Lemery Tourism website, please confirm your email by clicking the link below:"))
            ->line(new HtmlString(""))
            ->line(new HtmlString("<a href='{$verify_url}' style='text-decoration: none;'>Confirm Your Email Address</a>"))
            ->line(new HtmlString(''))
            ->line(new HtmlString("If you didn't receive our first email or if it was sent to your spam folder, we apologize for the inconvenience. This confirmation is important to ensure you can fully access all the features and benefits of your account."))
            ->line(new HtmlString(''))
            ->line(new HtmlString("If you did not sign up for an account, please disregard this email."))
            ->line(new HtmlString(''))
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
            'subject' => "Email Verification Link Resent: Complete Your Registration",
            'message' => "Email verification link has been sent to your email."
        ];
    }
}