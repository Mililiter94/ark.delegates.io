<?php

namespace App\Console\Commands\Polling;

use App\Events\RankWasShifted;
use App\Models\Delegate;
use App\Models\User;
use App\Services\Ark\Database;
use Illuminate\Console\Command;

class PollDelegates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ark:poll:delegates';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Database $database)
    {
        $delegates = $database->delegates();

        for ($i = 0; $i < \count($delegates); ++$i) {
            $delegate = $delegates[$i];

            $this->line('Polling Delegate: <info>'.$delegate['username'].'</info>');

            try {
                $model = Delegate::findByUsername($delegate['username']);
            } catch (\Exception $e) {
                $model = User::first()->delegates()->updateOrCreate([
                    'country_id' => 1,
                    'username'   => $delegate['username'],
                    'address'    => $delegate['address'],
                    'public_key' => $delegate['public_key'],
                    'rank'       => $i + 1,
                    'votes'      => $delegate['vote_balance'],
                ]);

                $model->extra_attributes = $this->getDefaultSettings();
            }

            // Store the old rank to compare
            $oldRank = $model->rank;

            // Update rank & votes
            $model->update([
                'rank'  => $i + 1,
                'votes' => $delegate['vote_balance'],
            ]);

            // Update
            $model->extra_attributes->set('statistics.producedBlocks', $delegate['produced_blocks']);
            $model->extra_attributes->set('statistics.missedBlocks', $delegate['missed_blocks']);
            // @TODO: calculate or grab from API
            $model->extra_attributes->set('statistics.approval', $delegate['approval']);
            $model->extra_attributes->set('statistics.productivity', $delegate['productivity']);
            $model->save();

            // Ranks changed, notify subscribers
            if ($oldRank !== $model->rank) {
                event(new RankWasShifted($model));
            }

            $model->save();
        }
    }

    /**
     * @return array
     */
    private function getDefaultSettings(): array
    {
        return [
            'profile' => [
                'proposal'   => null,
                'logo'       => null,
                'website'    => null,
                'details'    => null,
            ],
            'sharing' => [
                'percentage'      => 0,
                'frequency'       => 'Daily',
                'threshold'       => 0,
                'running_balance' => 'yes',
                'covers_fee'      => 'yes',
                'details'         => null,
            ],
            'voting' => [
                'requirements' => [
                    'min_balance'  => 0,
                    'max_balance'  => 0,
                    'registration' => 'no',
                    'details'      => null,
                ],
                'fidelity' => [
                    'period'  => null,
                    'share'   => 0,
                    'details' => null,
                ],
            ],
            'calculator' => [
                'cap_at_maximum_balance'       => 'no',
                'ignore_above_maximum_balance' => 'no',
                'details'                      => null,
            ],
        ];
    }
}
