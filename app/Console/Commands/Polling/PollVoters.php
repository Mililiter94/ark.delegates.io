<?php

namespace App\Console\Commands\Polling;

use App\Models\Delegate;
use App\Services\Ark\Client;
use App\Jobs\PollVoters as Job;
use Illuminate\Console\Command;

class PollVoters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ark:poll:voters';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Client $client)
    {
        foreach (Delegate::all() as $delegate) {
            Job::dispatch($delegate);
        }
    }
}
