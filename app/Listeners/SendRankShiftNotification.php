<?php

namespace App\Listeners;

use App\Events\RankWasShifted;
use App\Notifications\RankShifted;

class SendRankShiftNotification
{
    /**
     * Handle the event.
     *
     * @param RankWasShifted $event
     */
    public function handle(RankWasShifted $event)
    {
        $subscribers = $event->delegate->subscribers;

        foreach ($subscribers as $subscriber) {
            $subscriber->notify(new RankShifted($event->delegate));
        }
    }
}
