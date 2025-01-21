<?php

namespace App\Providers;

use App\Models\Entreprise;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;


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
    // Fetch enterprise data from the database
    $entreprise = Entreprise::where("check_document",1)->first(); // Assuming you're fetching a single enterprise record
    // Share the enterprise data with all views
    View::share('entreprise', $entreprise);

        Schema::defaultStringLength(191);
        Paginator::useBootstrap();


    }
}
