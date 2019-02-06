<?php

namespace App\Jobs;

use App\Models\Delegate;
use App\Services\Ark\Client;
use Illuminate\Bus\Queueable;
use App\Events\VoteWasShifted;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PollVoters implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Models\Delegate
     */
    public $delegate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Delegate $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Client $client)
    {
        // Current vote data...
        $votesBefore = $this->delegate->voters()->sum('balance');
        $activeVoters = $this->delegate->voters()->pluck('address');

        // Store voters...
        $votersList = collect($client->voters($this->delegate['public_key']));

        // Update each voter...
        foreach ($votersList as $voter) {
            // Update...
            $this->delegate->voters()->updateOrCreate([
                'address' => $voter['address'],
            ], $voter);

            // Used to be a voter...
            $wasVoting = $activeVoters->contains($voter['address']);
            $noLongerVoting = ! $votersList->pluck('address')->contains($voter['address']);

            if ($wasVoting && $noLongerVoting) {
                Voter::whereAddress($voter['address'])->delete();
            }
        }

        // Compare votes count...
        $votesAfter = $this->delegate->voters()->sum('balance');

        $this->triggerEvent($this->delegate, $votesBefore, $votesAfter);
    }

    /**
     * Decide if we trigger an event.
     *
     * @param \App\Models\Delegate $delegate
     * @param int                  $oldFigure
     * @param int                  $newFigure
     */
    private function triggerEvent(Delegate $delegate, int $oldFigure, int $newFigure): void
    {
        if ($oldFigure <= 0 || $newFigure <= 0) {
            return;
        }

        $percentChange = abs((1 - $oldFigure / $newFigure) * 100);

        if ($percentChange >= 1) {
            event(new VoteWasShifted($delegate));
        }
    }
}
