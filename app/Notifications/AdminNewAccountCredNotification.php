<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AdminNewAccountCredNotification extends Notification
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
        $password = $_data['password'];
        
        $url = env('FRONTEND_APP_URL').'/admin/login';
    
        return (new MailMessage)
            ->subject("Welcome to Lemery Tourism Website")
            ->greeting("Hi {$user['first_name']},")
            ->line(new HtmlString("I hope this email finds you well."))
            ->line(new HtmlString(""))
            ->line(new HtmlString("Your account has been created."))
            ->line(new HtmlString(""))
            ->line(new HtmlString("<strong>Credentials</strong>"))
            ->line(new HtmlString("<strong>Email: </strong> {$user['email']}"))
            ->line(new HtmlString("<strong>Password: </strong> {$password}"))
            ->line(new HtmlString(""))
            ->line(new HtmlString("Login <a href='{$url}'>here</a>."))
            ->line(new HtmlString("If you have any questions or need assistance, please don't hesitate to contact our support team."))
            ->line(new HtmlString(''))
            ->salutation(new HtmlString('Best Regards, <br /><i>Lemery Tourism Website</i>'));
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
        
        $url = env('FRONTEND_APP_URL').'/admin/login';
    
        return [
            'url' => $url,
            'action' => 'View',
            'subject' => "Welcome to Lemery Tourism Website",
            'message' => "Your credentials has been sent to your email."
        ];
    }    
}