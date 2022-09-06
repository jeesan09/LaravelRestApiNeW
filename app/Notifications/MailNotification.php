<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
     public $upassword;
     public $Name;



    public function __construct(User $user)
    {
        // dd($userPassward);
     
      
       $this->Name=$user->name;
      // dd($upassword);
        
      
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
       // return ['mail','database'];//it can be done if want to do both send mail and send Notification
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $name=$this->Name;
        //dd($name);
        return (new MailMessage)
                    ->greeting('Hello!'.$name)
                    ->line('Hellow.dfgfg dfgsdfgsd sdfgsdfgdfg')
                    ->error()
                    ->subject('Notification Subject')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you  '.$name.' for using  our application!');
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
            'data'=>'this is my first Notification Data',
        ];
    }
}
