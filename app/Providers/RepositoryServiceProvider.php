<?php

namespace App\Providers;

use App\Repositories\Eloquent\FlashcardRepository;
use App\Repositories\Eloquent\PracticeRepository;
use App\Repositories\FlashcardRepositoryInterface;
use App\Repositories\PracticeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FlashcardRepositoryInterface::class, FlashcardRepository::class);
        $this->app->bind(PracticeRepositoryInterface::class, PracticeRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
