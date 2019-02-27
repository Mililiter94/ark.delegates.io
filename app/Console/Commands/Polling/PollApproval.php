<?php

namespace App\Console\Commands\Polling;

use App\Models\Delegate;
use App\Services\Ark\Client;
use Illuminate\Console\Command;

class PollApproval extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ark:poll:approval';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Client $client)
    {
        $all_delegates = $client->delegates();
        
        foreach (Delegate::all() as $delegate) {
            $this->line('Polling Approval: <info>'.$delegate['username'].'</info>');

            foreach ($all_delegates as $this_delegate) {
                if($delegate['username'] == $this_delegate['username']) {
                    $this->line('Found Approval: <info>'.$this_delegate['username'].'</info>');
                    $delegate->extra_attributes->set('statistics.approval', $this_delegate['approval']);
                    $delegate->extra_attributes->set('statistics.productivity', $this_delegate['productivity']);            
                    $delegate->save();
                }    
            } 
        }
        
    }
}
