<?php

use App\Models\Bid;
use App\Models\Listing;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Http;

new #[Layout('layouts.app')] class extends Component {

    public $listing, $amount;

    public function mount($listing_id)
    {

        // Check if there are any bids for this listing
        $this->listing = Listing::whereHas('bids')
            ->with('bids')
            ->find($listing_id);

        // If no bids exist, return only the listing without bids
        if (!$this->listing) {
            $this->listing = Listing::find($listing_id);
        }

    }


    public function placeBid()
    {
        $this->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        Bid::create([
            'user_id' => auth()->user()->id,
            'listing_id' => $this->listing->id,
            'amount' => $this->amount,
        ]);

        session()->flash('success', 'Bid placed successfully!');
        $this->reset('amount');
    }


}; ?>

<div class="py-12">
    <div class="w-3/4 mx-auto sm:px-6 lg:px-8">
        <div class="bg-transparent dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="max-w-4xl mx-auto p-6">
                <div class="mt-3 max-w-2xl mx-auto p-6">
                    <!-- Submit Button -->
                    <a wire:navigate href="{{ route('auctions.view',$listing->auction->id) }}"
                       class="mb-5 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <!-- Heroicons Arrow Left -->
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back
                    </a>


                    <h2 class="text-2xl font-semibold">{{ $listing->title }} <br> Base Price :
                        KES {{ $listing->base_price }}</h2>
                    <h4 class="">
                        Previous Auction (Best Offer): KES {{ number_format($listing->bids->max('amount') * 0.9, 2) != '0' ?
                                                                          number_format($listing->bids->max('amount') * 0.9, 2)
                                                                          : number_format($listing->base_price, 2) }}

                    </h4>
                    <h4 class=" mb-5">
                        Current Volume : 1 <br>
                        Previous Auction (Volume) : 1
                    </h4>

                    <form wire:submit.prevent="placeBid" class="space-y-4">
                        <input type="number" wire:model.live="amount" class="w-full p-3 border rounded">
                        @error('amount') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                    <!-- Show Warning if Bid is Below Base Price -->
                        @if($amount && $amount < $listing->base_price)
                            <span class="text-red-600 my-2 text-sm">⚠ Your bid is below the base price!</span>
                        @endif

                        <div>
                            <button type="submit"
                                    class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Place Bid
                            </button>
                        </div>
                    </form>

                    <!-- List of Bids -->
                    <h3 class="mt-6 text-lg font-bold">Bids</h3>
                    @if($listing->bids->isNotEmpty())
                        <ul class="list-disc pl-4">
                            @foreach ($listing->bids->sortByDesc('amount') as $bid)
                                <li class="text-gray-700">
                                    <span class="font-semibold">{{ $bid->user->name ?? 'Guest' }}</span> -
                                    KES {{ number_format($bid->amount, 2) }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No bids placed yet.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

