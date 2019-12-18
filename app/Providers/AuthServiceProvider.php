<?php

namespace App\Providers;

use App\{Post, User};
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cookie;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    // protected $policies = [
    //     // 'App\Model' => 'App\Policies\ModelPolicy',
    //     Post::class => PostPolicy::class,
    // ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('see-content', function (?User $user) {
            return $user || Cookie::get('accept_terms') === '1';
        });
    }
}
