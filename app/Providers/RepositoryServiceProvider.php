<?php

namespace App\Providers;

use App\Intefaces\FieldRepositoryInterface;
use App\Intefaces\FileRepositoryInterface;
use App\Intefaces\OfferCooperationRepositoryInterface;
use App\Intefaces\ProjectRepositoryInterface;
use App\Intefaces\StatusOfferRepositoryInterface;
use App\Intefaces\StatusProjectRepositoryInterface;
use App\Intefaces\UserFieldRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use App\Repositories\FieldRepository;
use App\Repositories\FileRepository;
use App\Repositories\OfferCooperationRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\StatusOfferRepository;
use App\Repositories\StatusProjectRepository;
use App\Repositories\UserFieldRepository;
use App\Repositories\UserRepository;
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
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(OfferCooperationRepositoryInterface::class, OfferCooperationRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(FieldRepositoryInterface::class, FieldRepository::class);
        $this->app->bind(UserFieldRepositoryInterface::class, UserFieldRepository::class);
        $this->app->bind(StatusProjectRepositoryInterface::class, StatusProjectRepository::class);
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
        $this->app->bind(StatusOfferRepositoryInterface::class, StatusOfferRepository::class);
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
