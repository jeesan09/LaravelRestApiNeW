<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use Mail;

use App\Mail\SendEmailMailable;
use App\Mail\Registered;
use App\Mail\SendEmailTest;



class SendBulkQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
 //   public $timeout = 7200;     

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        // $counter = 0;
        // $data = User::all();
        // $input['subject'] = $this->details['subject'];

        //  echo "Bulk mail send successfully in the background...";

        Mail::to('jeesan09iub@gmail.com')->send( new SendEmailTest());



        // foreach ($data as $key => $value) {
        //   // //  dd( $input['email']);
        //   //   $input['email'] = $value->email;
        //   //   $input['name'] = $value->name;
        //   //   \Mail::send('emails.test', [], function($message) use($input){
        //   //       $message->to($input['email'], $input['name'])
        //   //           ->subject($input['subject']);
        //   //   });


        //     Mail::to( $value[0]->email)->send(new Registered());

        //     $counter=$counter +1;

        // }
    }
}
