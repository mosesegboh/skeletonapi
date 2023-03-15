<?php

namespace App\Listeners;

use App\Events\AuthorsFetched;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use App\Helper\ApiLogin;

class AuthorsFetchedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AuthorsFetched $event)
    {
        ApiLogin::instance()->makeCall('authors', 'POST', ApiLogin::instance()->useDefaultToken(), json_encode([
            'first_name' => $event->authorData['authorFirstName'],
            'last_name' => $event->authorData['authorLastName'],
            'birthday' => $event->authorData['authorBirthday'],
            'biography' => $event->authorData['authorBiography'],
            'gender' => $event->authorData['authorGender'],
            'place_of_birth' => $event->authorData['authorPlaceOfBirth'],
        ]));
    }
}
