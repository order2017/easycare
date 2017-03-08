<?php

namespace App\Providers;

use App\NewPaginationPresenter;
use App\NewSimplePaginationPresenter;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class PaginationProvider extends ServiceProvider
{

    public function boot()
    {
        Paginator::presenter(function (AbstractPaginator $paginator) {
            return new NewPaginationPresenter($paginator);
        });
        LengthAwarePaginator::presenter(function (AbstractPaginator $paginator) {
            return new NewSimplePaginationPresenter($paginator);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
