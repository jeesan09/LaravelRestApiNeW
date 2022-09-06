<?php

namespace App\Jobs;

use App\Mail\User_Welcome;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class WelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $upassword;
    public $name;
    public $email;

    public function __construct($userPassward,$userName,$usermail)
    {
        // dd($userPassward);
     
       $this->upassword=$userPassward;
       $this->name=$userName;
       $this->email=$usermail;
      // dd($userName);
        
      
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $MailPassword=$this->upassword;
        $MailName=$this->name;
        $userEmail=$this->email;
        Mail::to($userEmail)->send(new User_Welcome($MailPassword,$MailName));
    }
}
