<?php

namespace App\Services\Ark;

use ArkX\Eloquent\Models\Block;
use ArkX\Eloquent\Models\Wallet;
use Illuminate\Support\Collection;

class Database
{
    public function wallet(string $address): Wallet
    {
        return Wallet::findByAddress($address);
    }

    public function voters(string $publicKey): Collection
    {
        return Wallet::vote($publicKey)->get();
    }
    public function votes(string $publicKey): int
    {
        return Wallet::vote($publicKey)->sum('balance');
    }

    public function delegate(string $username): Wallet
    {
        return Wallet::findByUsername($username);
    }

    public function delegates(): Collection
    {
        return Wallet::whereNotNull('username')->orderByDesc('vote_balance')->get();
    }

    public function lastBlock(string $publicKey): Block
    {
        return Block::generator($publicKey)->orderByDesc('timestamp')->first();
    }
}
