<?php

namespace App\Providers;

use App\Enums\PrivilegeEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * 
         * The directive checks whether the user is an administrator,
         * by comparing the user's privilege id 
         * to the privilege id of PrivilegeEnum::ADMIN
         * 
         * @return string
         */
        Blade::directive('isAdmin', function () {
            return "<?php if(auth()->check() && auth()->user()->privileges->contains('id', '" . PrivilegeEnum::ADMIN->value . "')): ?>";
        });

        /** 
         * End tag closing isAdmin 
         * 
         * @return string
         */
        Blade::directive('endisAdmin', function () {
            return "<?php endif; ?>";
        });
    }
}
