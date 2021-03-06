<?php

namespace App\Providers;

use App\Intefaces\FieldRepositoryInterface;
use App\Intefaces\FileRepositoryInterface;
use App\Intefaces\OfferCooperationRepositoryInterface;
use App\Intefaces\ProjectRepositoryInterface;
use App\Intefaces\RequestCooperationRepositoryInterface;
use App\Intefaces\RightRepositoryInterface;
use App\Intefaces\StatusOfferRepositoryInterface;
use App\Intefaces\StatusProjectRepositoryInterface;
use App\Intefaces\StatusRequestRepositoryInterface;
use App\Intefaces\StatusUserRepositoryInterface;
use App\Intefaces\UserFieldRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use App\Repositories\FieldRepository;
use App\Repositories\FileRepository;
use App\Repositories\OfferCooperationRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\RequestCooperationRepository;
use App\Repositories\RightRepository;
use App\Repositories\StatusOfferRepository;
use App\Repositories\StatusProjectRepository;
use App\Repositories\StatusRequestRepository;
use App\Repositories\StatusUserRepository;
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
        $this->app->bind(RequestCooperationRepositoryInterface::class, RequestCooperationRepository::class);
        $this->app->bind(StatusUserRepositoryInterface::class, StatusUserRepository::class);
        $this->app->bind(RightRepositoryInterface::class, RightRepository::class);
        $this->app->bind(RequestCooperationRepositoryInterface::class, RequestCooperationRepository::class);
        $this->app->bind(StatusRequestRepositoryInterface::class, StatusRequestRepository::class);
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
