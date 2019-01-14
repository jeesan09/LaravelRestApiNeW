<?php

namespace App\Http\Controllers;

use App\Notifications\DaatBaseNotification;
use App\Notifications\MailNotification;
use App\Traits\MyAuth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      use MyAuth;

    public function __construct()
    {
         $this->middleware('jwt.auth');
        
    } 


    public function index()
    {
        $when = now()->addSeconds(5);

        

        $user=$this->Current_User();
        $user->notify((new MailNotification($user))->delay($when));//perfectly Sending mail to current Loged in User;
        return 'ok';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function DataBaseNotification(Request $request)
    {
        //
        $user=$this->Current_User();
        $user->notify(new DaatBaseNotification($user));



        return 'fine';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function CurrentUserNotification()
    { 
        //return 'working';
        $Current_User= $this->Current_User();//Using Trait
      
        $notificaton_of_User=$Current_User->notifications->count();//this retuns all filds of notification table;
       
       if($notificaton_of_User > 0){

        foreach ($Current_User->notifications as $notification) {
            $dataa[]=$notification->data['data'];
         }
       
         return $dataa;

        }

        else{

            return 'U dont have any Notifications';
        }

    }

    public function CurrentUserTotalNotification()
    { 
      //  return 'working';
        $Current_User= $this->Current_User();//Using Trait
     
        $notificaton_of_User=$Current_User->unreadNotifications->count();
  
        return $notificaton_of_User;
    }
    public function CurrentUser_UnreadNotification()
    { 
      //  return 'working';
        $Current_User= $this->Current_User();
        $Unread_notificaton_of_User=$Current_User->unreadNotifications->count();
        if ($Unread_notificaton_of_User >= 1) {
        foreach ($Current_User->unreadNotifications as $notification) 
        {

           // if ($Unread_notificaton_of_User >= 1) {
                # code...
              $dataa[]=$notification->data['data'];
              $notification->markAsRead();
              
          //  }



         }
         return $dataa;
      }
       

       return 'all Notifications are Read';
           
         
    }

    public function CurrentUser_ReadNotification()
    { 
      //  return 'working';
         $Current_User= $this->Current_User();
            foreach ($Current_User->readNotifications as $notification) {
                $dataa[]=$notification->data['data'];
             }
         return $dataa;     

    }    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
