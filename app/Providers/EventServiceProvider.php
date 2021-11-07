<?php

namespace App\Providers;

use App\Models\Album;
use App\Models\AlbumLog;
use App\Models\Artist;
use App\Models\ArtistLog;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

        Album::updated(function($albumCopy)
        {
            $albumLog = new AlbumLog();
            $albumLog->user_id = auth()->user()->id;
            $albumLog->album_id = $albumCopy->id;
            $albumLog->artist = $albumCopy->artist;
            $albumLog->album = $albumCopy->album;
            $albumLog->img = $albumCopy->img;
            $albumLog->info = $albumCopy->info;

            $albumLog->save();
        });

        Artist::updated(function($artistCopy)
        {
            $artistLog = new ArtistLog();
            $artistLog->user_id = auth()->user()->id;
            $artistLog->artist_id = $artistCopy->id;
            $artistLog->artist = $artistCopy->artist;
            $artistLog->img = $artistCopy->img;

            $artistLog->save();
        });
    }
}
