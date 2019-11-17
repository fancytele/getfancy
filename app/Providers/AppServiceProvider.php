<?php

namespace App\Providers;

use App\Enums\TicketStatus;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('recaptcha', 'App\Validators\ReCaptcha@validate');

        Blade::if('env', function ($environment) {
            return app()->environment($environment);
        });

        Blade::directive('ticket_badge_status', function ($status) {
            return "<?php
                switch ($status) {
                    case '" . TicketStatus::IN_PROGRESS . "':
                        echo 'badge-soft-primary';
                        break;

                    case '" . TicketStatus::COMPLETED . "':
                        echo 'badge-soft-success';
                        break;

                    case '" . TicketStatus::REMOVED . "':
                        echo 'badge-soft-danger';
                        break;

                    default: // PENDING
                        echo 'badge-soft-dark';
                        break;
                } 
            ?>";
        });
    }
}
