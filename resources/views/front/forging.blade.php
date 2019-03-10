@extends('layouts.app')

@section('content')
    <div class="p-8">
        <h2>Top 60 Delegates</h2>
    </div>

    <div class="page-top-100">
        <table class="xhidden sm:table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Username</th>
                    <th>Sharing</th>
                    <th>Votes in Percent</th>
                    <th>Votes</th>
                    <th class="hidden sm:table-cell">Voters</th>
                    <th class="text-right">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($delegates as $delegate)
                    <tr>
                        <td>{{ $delegate->rank }}</td>
                        <td><a href="{{ route('delegate', $delegate->username) }}">{{ $delegate['username'] }}</a></td>
                        <td>{{ $delegate->sharing['percentage'] ?? 0 }}%</td>
                        <td>{{ $delegate->statistics['approval'] ?? 0 }}%</td>
                        <td>{{ format_arktoshi($delegate->votes, 0) }}</td>
                        <td class="hidden sm:table-cell">{{ $delegate->statistics['voters'] ?? 0 }}</td>
                        <td class="text-right"><span class="hidden sm:inline">{{ $delegate->last_block_time->diffForHumans() }}</span> <span class="delegates-status bg-green bg-red bg-yellow bg-orange bg-{{ $delegate->status }}"></span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @foreach ($delegates as $delegate)
            <ul class="info-list hidden">
                <li>
                    <span>Rank</span>
                    <span class="text-right">{{ $delegate->rank }}</span>
                </li>

                <li>
                    <span>Username</span>
                    <span class="text-right"><a href="https://explorer.qredit.network/#/wallets/{{ $delegate['address'] }}">{{ $delegate['username'] }}</a></span>
                </li>

                <li>
                    <span>Votes in Percentage</span>
                    <span class="text-right">{{ $delegate->statistics['approval'] ?? 0 }}%</span>
                </li>

                <li>
                    <span>Votes</span>
                    <span class="text-right">{{ format_arktoshi($delegate->votes / ARKTOSHI, 0) }}</span>
                </li>

                <li>
                    <span>Status</span>
                    <span class="text-right"><span class="hidden sm:inline">{{ $delegate->last_block_time->diffForHumans() }}</span> <span class="delegates-status bg-{{ $delegate->status }}"></span></span>
                </li>
            </ul>
        @endforeach
    </div>

@endsection
