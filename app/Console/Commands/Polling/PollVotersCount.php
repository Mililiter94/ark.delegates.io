<?php

namespace App\Console\Commands\Polling;

use App\Models\Delegate;
use App\Services\Ark\Database;
use Illuminate\Console\Command;

class PollVotersCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ark:poll:voters-count';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Database $database)
    {
        foreach (Delegate::all() as $delegate) {
            $this->line('Polling Voters: <info>'.$delegate['username'].'</info>');

            $votersList = collect($database->voters($delegate['public_key']));

            $delegate->extra_attributes->set('statistics.voters', $votersList->count());
            $delegate->save();
        }
    }
}
