<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\MyAuth;

use Illuminate\Support\Facades\Mail;
use App\Mail\Registered;
use App\Mail\SendEmailMailable;
use App;
use Carbon\Carbon;


class SendBulkMailController extends Controller
{
    //

    use MyAuth;

    public function __construct()
    {
       //  $this->middleware('jwt.auth')->except('index');
        
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bulk_email_send(Request $request)
    {

        // $data = User::all();
        // return $data[0]->email;

        // Mail::to('jeesan09iub@gmail.com')->send(new Registered());
        // echo "Bulk mail send successfully in the background...";


        $details = [
            'subject' => 'Weekly Notification send by jeesan'
        ];

        // send all mail in the queue.
         // $job = (new \App\Jobs\SendBulkQueueEmail($details)); 

         // dispatch($job);


           $emailJob = (new \App\Jobs\SendBulkQueueEmail($details))->delay(Carbon::now()->addSeconds(3));
           dispatch($emailJob);
       



    //    echo "Bulk mail send successfully in the background...";


       //  return "bulk email sendign";

    }


    
}
