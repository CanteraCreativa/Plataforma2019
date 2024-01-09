<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\ContactMessageRepository::class, \App\Repositories\ContactMessageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CreativeDataRepository::class, \App\Repositories\CreativeDataRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SkillRepository::class, \App\Repositories\SkillRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\InterestRepository::class, \App\Repositories\InterestRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GuidelineRepository::class, \App\Repositories\GuidelineRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AnnouncementRepository::class, \App\Repositories\AnnouncementRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\InscriptionRepository::class, \App\Repositories\InscriptionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SubmissionRepository::class, \App\Repositories\SubmissionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SiteContentRepository::class, \App\Repositories\SiteContentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\LogosRepository::class, \App\Repositories\LogosRepositoryEloquent::class);
        //:end-bindings:
    }
}
