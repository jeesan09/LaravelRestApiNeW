<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function adminPolicy($user)
    {
       
            if($user->type == 'admin')
            {

                return true;

            }

                return false;

    }

    public function superAdminPolicy($user)
    {
       
       return $user->type == 'superAdmin';
                
    }
    
    public function userPolicy($user)
    {
       
       return $user->type == 'user';
                
    }
}
