<?php

use App\Models\Listing;
use Livewire\Volt\Component;

new class extends Component {

    public $listings;

    public function mount()
    {
        $this->listings = Listing::all();
    }

}; ?>

<div class="max-w-6xl mx-auto px-4 py-6">


    <!-- Create New Listing Button -->
    <div class="mb-6">
        <a wire:navigate href="{{ route('listings.create') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            Create New Listing
        </a>
    </div>

    <!-- Responsive Table Container -->
    <!-- Responsive Table Container -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        <table class="w-full min-w-full border border-gray-300 dark:border-gray-600 rounded-lg">
            <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b">Title</th>
                <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b">Base Price</th>
                <th class="px-6 py-4 text-start text-gray-800 dark:text-gray-200 font-semibold border-b ">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-300 dark:divide-gray-600">
            @if (!empty($listings) && $listings->count())
                @foreach ($listings as $listing)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-300 ">{{ $listing->title }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-30">
                            KES {{ number_format($listing->base_price, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            <a wire:navigate href="{{ route('bids.index',$listing->id) }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Bid
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="text-center py-6 text-gray-500">No listings found.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>


</div>
