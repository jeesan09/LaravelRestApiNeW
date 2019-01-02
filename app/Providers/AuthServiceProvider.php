<?php

namespace App\Providers;

use App\Policies\MyPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class => MyPolicy::class,


    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
        Gate::define('admin-gate','App\Policies\MyPolicy@adminPolicy');//Using Policy
        Gate::define('superAdmin-gate','App\Policies\MyPolicy@superAdminPolicy');
        Gate::define('user-gate','App\Policies\MyPolicy@userPolicy');

/*      Not Using Policy
        Gate::define('superAdmin-gate', function ($user) {
        return $user->type == 'superAdmin';
        });

        Gate::define('user-gate', function ($user) {
        return $user->type == 'user';
        });*/

    }
}
