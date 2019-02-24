<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(User::class)
            ->create([
                'email'    => 'trusty@delegates.io',
                'password' => Hash::make('password'),
            ])
            ->assignRole('admin');

        if (app()->environment('local', 'testing')) {
            factory(User::class)
                ->create([
                'email' => 'dummy@delegates.io',
                'password' => Hash::make('password'),
                ])
                ->assignRole('delegate');
        }
    }
}
