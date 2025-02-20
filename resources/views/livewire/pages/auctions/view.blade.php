<?php

use App\Models\Auction;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {

    public $auction;

    public function mount($auction_id)
    {
        $this->auction = Auction::whereHas('listings')
            ->with('listings')->find($auction_id);

        // If no bids exist, return only the listing without bids
        if (!$this->auction) {
            $this->auction = Auction::find($auction_id);
        }

    }

}; ?>

<div class="py-12">
    <div class="w-3/4 mx-auto sm:px-6 lg:px-8">
        <div class="bg-transparent dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="max-w-4xl mx-auto p-6">

                <!-- Submit Button -->
                <a wire:navigate href="{{ route('auctions.index') }}"
                   class="mb-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <!-- Heroicons Arrow Left -->
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back
                </a>

                <div class="max-w-5xl mx-auto p-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
                    <div class="space-y-6">
                        <!-- Auction Summary -->
                        <div class="flex justify-between">
                            <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-200">Auction:
                                    <span class="text-blue-600 dark:text-blue-400">{{ $auction->auction_number }}</span>
                                </h3>
                                <p class="text-gray-700 dark:text-gray-300">
                                    <span class="font-semibold">Start Time:</span> {{ $auction->start_time }}
                                </p>
                                <p class="text-gray-700 dark:text-gray-300">
                                    <span class="font-semibold">End Time:</span> {{ $auction->end_time }}
                                </p>
                                @php
                                    $now = now();
                                    if ($auction->start_time > $now) {
                                        $status = ['Upcoming', 'text-yellow-600 text-sm bg-yellow-100 dark:bg-yellow-800 dark:text-yellow-300'];
                                    } elseif ($auction->end_time < $now) {
                                        $status = ['Ended', 'text-red-600 bg-red-100 text-sm dark:bg-red-800 dark:text-red-300'];
                                    } else {
                                        $status = ['Active', 'text-green-600 bg-green-100 text-sm dark:bg-green-800 dark:text-green-300'];
                                    }
                                @endphp

                                <p class="text-gray-700  dark:text-gray-300">
                                    <span class="font-semibold">Status:</span>
                                    <span class="px-1 py-1 rounded-lg {{ $status[1] }}">
                                    {{ $status[0] }}
                                 </span>
                                </p>

                            </div>
                            <div>
                                @if($status[0] !== 'Ended')
                                    <a wire:navigate href="{{ route('listings.create',$auction->id) }}"
                                       class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Add New Listing
                                    </a>
                                @endif
                            </div>
                        </div>


                        <!-- Listings Table (Nested) -->
                        @if ($auction->listings->count())
                            <div class="p-4 bg-white dark:bg-gray-900 rounded-lg shadow">
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Listings</h4>
                                <table class="w-full border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b">
                                            Title
                                        </th>
                                        <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b">
                                            Base Price
                                        </th>
                                        <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b">
                                            Best Offer
                                        </th>
                                        <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b">
                                            Volume
                                        </th>
                                        <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-300 dark:divide-gray-600">
                                    @foreach ($auction->listings as $listing)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-300">{{ $listing->title }}</td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-300 font-semibold">
                                                KES {{ number_format($listing->base_price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-300 font-semibold">
                                                Current: KES {{ number_format($listing->bids->max('amount') ?? 0, 2) }}
                                                <br>
                                                <span class="text-sm text-gray-500 font-medium">
                                                 Previous Auction: KES {{ number_format($listing->bids->max('amount') * 0.9, 2) != '0' ?
                                                                          number_format($listing->bids->max('amount') * 0.9, 2)
                                                                          : number_format($listing->base_price, 2) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-300 font-semibold">
                                                Current: 1 <br>
                                                <span class="text-sm text-gray-500 font-medium">
                                                 Previous Auction: 1
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($status[0] !== 'Ended' && $status[0] !== 'Upcoming')
                                                    <a wire:navigate href="{{ route('bids.index',$listing->id) }}"
                                                       class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                        Bid
                                                    </a>
                                                @else
                                                    <button disabled
                                                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest
                                                                      disabled:opacity-50 disabled:cursor-not-allowed
                                                                      hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300
                                                                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800
                                                                      transition ease-in-out duration-150">
                                                        Bid
                                                    </button>

                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

