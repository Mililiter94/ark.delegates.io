<?php

namespace Tests\Feature\Notifications;

use Tests\TestCase;
use App\Models\User;
use App\Models\Delegate;
use App\Notifications\VoteShifted;
use Illuminate\Support\Facades\Notification;

/**
 * @coversNothing
 */
class VoteShiftedTest extends TestCase
{
    /** @test */
    public function it_should_notify_the_user()
    {
        Notification::fake();

        $delegate = factory(Delegate::class)->create();

        $user = factory(User::class)->create();
        $user->notify(new VoteShifted($delegate));

        Notification::assertSentTo(
            $user,
            VoteShifted::class,
            function ($notification, $channels) use ($delegate) {
                return $notification->delegate->id === $delegate->id;
            }
        );
    }
}
