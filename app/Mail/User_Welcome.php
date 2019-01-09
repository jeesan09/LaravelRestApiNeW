<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class User_Welcome extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public $upassword;
     public $name;



    public function __construct($userPassward,$userName)
    {
        // dd($userPassward);
     
       $this->upassword=$userPassward;
       $this->name=$userName;
      // dd($upassword);
        
      
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
           $viewPassword=$this->upassword;
           $viewName=$this->name;

        return $this->markdown('emails.users.welcome',
            [
                'password' => $viewPassword,
                'UserName' => $viewName
            ]);
    }
}
