<?php

namespace App\Providers;

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
        Validator::extend('max_files_in_dir', 'App\Rules\MaxNumOfFiles@validate');
        Validator::extend('min_files_in_dir', 'App\Rules\MinFilesInDir@validate');
    }
}
