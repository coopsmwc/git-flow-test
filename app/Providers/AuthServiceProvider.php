<?php
namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('register-user', function ($user) {
            return $user->type === 1;
        });
        
        Gate::define('suspend-account', function ($user) {
            return in_array($user->type, [1, 4]);
        });
        
        Gate::define('activate-licence', function ($user) {
            return in_array($user->type, [1, 3, 4]);
        });
        
        Gate::define('deactivate-licence', function ($user) {
            return in_array($user->type, [1, 4]);
        });
        
        Gate::define('delete-company', function ($user) {
            return in_array($user->type, [1, 4]);
        });
        
        Gate::define('change-admin-password', function ($user) {
            return in_array($user->type, [1, 3, 4]);
        });
        
        Gate::define('unsubscribe-user', function ($user) {
            return $user->type === 2;
        });
        
        Gate::define('hr-users-sales', function ($user) {
            return in_array($user->type, [1, 3, 4]);
        });
    }
}
