<?php

namespace App\Console\Commands\Polling;

use App\Models\Delegate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use GrahamCampbell\GuzzleFactory\GuzzleFactory;

class PollAvatars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ark:poll:avatars';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Delegate::all()->each(function ($delegate) {
            $logo = $delegate->extra_attributes->profile['logo'];

            if (! $logo) {
                return $this->pollAvatar($delegate);
            }

            if (! Storage::disk('public')->exists($logo)) {
                return $this->pollAvatar($delegate);
            }
        });
    }

    /**
     * Poll an arkvatar and store it.
     * @param  Delegate $delegate
     * @return void
     */
    private function pollAvatar(Delegate $delegate): void
    {
        $this->line('Polling Delegate: <info>'.$delegate['username'].'</info>');

        $delegate->extra_attributes->set('profile.logo', 'https://api.adorable.io/avatars/512/'.$delegate['address']);
        $delegate->save();
    }
}
