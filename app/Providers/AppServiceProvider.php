<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\JobQuote;
use App\Contracts\PaymentGateway;
use App\Observers\InvoiceObserver;
use App\Observers\JobQuoteObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Services\AssemblyPaymentGateway;
use App\Console\Commands\ModelMakeCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JobQuote::observe(JobQuoteObserver::class);
        Invoice::observe(InvoiceObserver::class);

        Blade::if('couple', function () {
            return Auth::user() && Auth::user()->account === 'couple';
        });

        Blade::if('vendor', function () {
            return Auth::user() && Auth::user()->account === 'vendor';
        });

        Blade::if('activeAccount', function () {
            return Auth::user() && Auth::user()->status === 'active';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend('command.model.make', function ($command, $app) {
            return new ModelMakeCommand($app['files']);
        });

        $this->app->alias('bugsnag.multi', \Illuminate\Contracts\Logging\Log::class);
        $this->app->alias('bugsnag.multi', \Psr\Log\LoggerInterface::class);

        $this->app->singleton(PaymentGateway::class, function () {
            return new AssemblyPaymentGateway(
                config('paymentgateway.env'),
                config('paymentgateway.email'),
                config('paymentgateway.token')
            );
        });
    }
}
