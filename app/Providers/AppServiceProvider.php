<?php

namespace App\Providers;

use App\Events\TagCreated;
use App\Listeners\sendTagNotification;
use App\Services\PostService;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Psy\Readline\Hoa\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostService::class, function ($app) {
            return new PostService();
        });

        $this->app->bind(PageService::class, function ($app) {
            return new PageService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
//        Event::listen(TagCreated::class, sendTagNotification::class);
        broadcast::routes(['middleware' => ['auth:api']]);
    }
}
