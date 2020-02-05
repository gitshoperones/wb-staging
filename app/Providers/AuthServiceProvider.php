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

        Gate::define('edit-profile', 'App\Policies\Profile@edit');
        Gate::define('update-profile', 'App\Policies\Profile@edit');

        Gate::define('create-job-post', 'App\Policies\JobPost@create');
        Gate::define('store-job-post', 'App\Policies\JobPost@store');
        Gate::define('edit-job-post', 'App\Policies\JobPost@edit');
        Gate::define('update-job-post', 'App\Policies\JobPost@update');

        Gate::define('create-job-quote', 'App\Policies\JobQuote@create');
        Gate::define('store-job-quote', 'App\Policies\JobQuote@store');
        Gate::define('show-job-quote', 'App\Policies\JobQuote@show');
        Gate::define('edit-job-quote', 'App\Policies\JobQuote@edit');
        Gate::define('update-job-quote', 'App\Policies\JobQuote@update');
        Gate::define('respond-job-quote', 'App\Policies\JobQuote@respond');

        Gate::define('update-user', 'App\Policies\User@update');

        Gate::define('pay-invoice', 'App\Policies\Invoice@pay');
        Gate::define('show-invoice', 'App\Policies\Invoice@show');
    }
}
