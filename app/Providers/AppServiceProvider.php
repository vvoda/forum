<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(191); //fix migration errors (keys too long)
        // $this->app->bind('App\Repositories\\RepositoryInterface', 'App\Repositories\\Repository');
        $this->app->bind('App\Repositories\Message\MessageRepositoryInterface', 'App\Repositories\Message\MessageRepository');
        $this->app->bind('App\Repositories\File\FileRepositoryInterface', 'App\Repositories\File\FileRepository');
        $this->app->bind('App\Repositories\Topic\TopicRepositoryInterface', 'App\Repositories\Topic\TopicRepository');
        $this->app->bind('App\Repositories\User\UserRepositoryInterface', 'App\Repositories\User\UserRepository');
    }

}