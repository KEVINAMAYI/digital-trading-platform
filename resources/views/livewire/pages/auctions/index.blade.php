<?php

use App\Models\Auction;
use Livewire\Volt\Component;

new class extends Component {

    public $auctions;

    public function mount()
    {
        $this->auctions = Auction::with('listings')->get();
    }

}; ?>

<div class="max-w-4xl mx-auto p-6">

    @if (session('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition.duration.500ms
            class="mb-3 bg-green-500 text-white p-3 rounded-lg shadow-md"
        >
            {{ session('success') }}
        </div>
    @endif


<!-- Create New Listing Button -->
    <div class="mb-6">
        <a wire:navigate href="{{ route('auctions.create') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            Create New Auction
        </a>
    </div>

    <div class="max-w-5xl mx-auto p-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        <!-- Listings Table (Nested) -->
        @if (!empty($auctions) && $auctions->count())
            <div class="p-4 bg-white dark:bg-gray-900 rounded-lg shadow">
                <table class="w-full border border-gray-300 dark:border-gray-600 rounded-lg">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b">
                            Auction Number
                        </th>
                        <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b">
                            Start Time
                        </th>
                        <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b">
                            End Time
                        </th>
                        <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b">
                            Status
                        </th>
                        <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300 dark:divide-gray-600">


                    @foreach ($auctions as $auction)
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

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-300">{{ $auction->auction_number }}</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-300">{{ $auction->start_time }}</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-300 font-semibold">
                                {{ $auction->end_time }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-300 font-semibold">
                                 <span class="px-1 py-1 rounded-lg {{ $status[1] }}">
                                    {{ $status[0] }}
                                 </span>
                            </td>
                            <td class="px-6 py-4">
                                <a wire:navigate href="{{ route('auctions.view',$auction->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    view
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center py-6 text-gray-500">No auctions found.</p>
        @endif
    </div>
</div>

