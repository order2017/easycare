<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use URL;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!App::isLocal()) {
            URL::forceSchema(env('URL_SCHEMA', 'http'));
            $_SERVER['HTTPS'] = 'on';
        }
        Validator::extend('mobile', 'App\Validators\MobileValidator@validate');
        Validator::extend('rules', function ($attribute, $value, $parameters) {
            $keys = ['winning_rate', 'winning_rate'];
            foreach ($value as $key => $rule) {
                foreach ($keys as $keyName) {
                    if ($rule[$keyName] == '') {
                        return false;
                    }
                }
            }
            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
