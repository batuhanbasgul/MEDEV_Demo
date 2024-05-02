<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Is the user admin gate.
         */
        Gate::define('admin', function ($user) {
            if ($user->authority == 'admin') {
                return true;
            } else {
                return false;
            }
        });

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Is the user client gate.
         */
        Gate::define('client', function ($user) {
            if ($user->authority == 'client') {
                return true;
            } else {
                return false;
            }
        });

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Is the user subclient gate.
         */
        Gate::define('subclient', function ($user) {
            if ($user->authority == 'subclient') {
                return true;
            } else {
                return false;
            }
        });

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Is the user temporary gate.
         */
        Gate::define('temporary', function ($user) {
            if ($user->authority == 'temporary') {
                return true;
            } else {
                return false;
            }
        });

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Is the user's authorization is equol or higher than target user's authorization.
         */
        Gate::define('crud-show', function ($user, $target_user) {
            if($user->authority == 'admin'){
                return true;
            }else if($user->authority == 'client'){
                if($target_user->authority == 'admin'){
                    return false;
                }else{
                    return true;
                }
            }else if($user->authority == 'subclient'){
                if($target_user->authority == 'admin' || $target_user->authority == 'client' || $target_user->authority == 'subclient'){
                    return false;
                }else{
                    return true;
                }
            }else if($user->authority == 'temporary'){
                return false;
            }else{
                return false;
            }
        });
    }
}
