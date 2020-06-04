<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //The get admin method accepts two parameters, the first parameter is a key that is usable in your application
        //The second parameter
        Gate::define('isAdmin', function ($user) {
            return $user->role === 'admin';
        });
        Gate::define('isUser', function ($user) {
            return $user->role === 'user';
        });
        Gate::define('isTreasurer', function ($user) {
            return $user->role === 'treasurer';
        });
        Gate::define('isMediaController', function ($user) {
            return $user->role === 'mediacontroller';
        });
        Gate::define('isSecreatary', function ($user) {
            return $user->role === 'secreatary';
        });
        Gate::define('isProjectLead', function ($user) {
            return $user->role === 'projectlead';
        });
        Passport::routes();

        //
    }
}