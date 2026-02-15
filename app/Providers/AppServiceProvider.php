<?php

namespace App\Providers;

use App\Domains\Collection\Events\CollectionFailedEvent;
use App\Domains\Collection\Events\CollectionFailedSyncEvent;
use App\Domains\Collection\Events\CollectionSuccessEvent;
use App\Domains\Collection\Events\CollectionSuccessSyncEvent;
use App\Domains\Collection\Listeners\HandleCollectionFailedListener;
use App\Domains\Collection\Listeners\HandleCollectionFailedSyncListener;
use App\Domains\Collection\Listeners\HandleCollectionSuccessListener;
use App\Domains\Collection\Listeners\HandleCollectionSuccessSyncListener;
use App\Domains\Consent\Events\ConsentFailedEvent;
use App\Domains\Consent\Events\ConsentSuccessEvent;
use App\Domains\Consent\Listeners\HandleConsentFailedListener;
use App\Domains\Consent\Listeners\HandleConsentSuccessListener;
use App\Models\Integration;
use App\Policies\IntegrationPolicy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /** testing only */
        if (config('app.env') === 'share') {
            URL::forceRootUrl(config('app.url'));
        }

        Gate::policy(Integration::class, IntegrationPolicy::class);

        Event::listen(ConsentFailedEvent::class, HandleConsentFailedListener::class);
        Event::listen(ConsentSuccessEvent::class, HandleConsentSuccessListener::class);

        Event::listen(CollectionSuccessEvent::class, HandleCollectionSuccessListener::class);
        Event::listen(CollectionSuccessSyncEvent::class, HandleCollectionSuccessSyncListener::class); 
              
        Event::listen(CollectionFailedEvent::class, HandleCollectionFailedListener::class);
        Event::listen(CollectionFailedSyncEvent::class, HandleCollectionFailedSyncListener::class);
    }
}
