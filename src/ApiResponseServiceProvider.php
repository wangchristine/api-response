<?php

namespace CHHW\ApiResponse;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishing();

        Collection::macro('paginate', function ($perPage = 15, $pageName = 'page', $page = null) {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            $total = $this->count();
            $results = $this->forPage($page, $perPage)->values();

            $paginator = new LengthAwarePaginator($results, $total, $perPage, $page, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]);

            return $paginator;
        });

        Collection::macro('simplePaginate', function ($perPage = 15, $pageName = 'page', $page = null) {
            $page = $page ?: Paginator::resolveCurrentPage($pageName);
            $results = $this->slice(($page - 1) * $perPage)->take($perPage + 1)->values();

            $paginator = new Paginator($results, $perPage, $page, [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]);

            return $paginator;
        });
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/config/response.php' => app()->configPath('response.php'),
        ]);
    }
}
