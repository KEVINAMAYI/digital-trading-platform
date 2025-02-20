<?php


use App\Models\Auction;
use App\Models\Listing;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {

    public $auctions, $auction_id, $title, $base_price;

    public function mount($auction_id)
    {
        $this->auction_id = $auction_id;
        $this->auctions = Auction::all();
    }

    public function store()
    {

        $this->validate([
            'auction_id' => 'required|string',
            'title' => 'required|string',
            'base_price' => 'required|numeric',
        ]);

        // Create the listing with auction_id
        Listing::create([
            'auction_id' => $this->auction_id,
            'title' => $this->title,
            'base_price' => $this->base_price,
        ]);

        session()->flash('success', 'Listing created successfully!');

        $this->redirect(route('auctions.view', $this->auction_id), navigate: true);
        $this->reset('title', 'base_price');
    }

}; ?>

<div class="py-12">
    <div class="w-3/4 mx-auto sm:px-6 lg:px-8">
        <div class="bg-transparent dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="max-w-2xl mt-3 mx-auto   dark:bg-gray-800">
                <!-- Submit Button -->
                <a wire:navigate href="{{ route('auctions.view',$auction_id) }}"
                   class="my-3 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <!-- Heroicons Arrow Left -->
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back
                </a>
            </div>

            <div class="max-w-2xl mt-3 mx-auto p-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg">

                <form wire:submit.prevent="store" class="space-y-6">
                @csrf

                <!-- Auction Number -->
                    <div>
                        <label for="auction_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Auction
                        </label>
                        <select wire:model="auction_id" disabled id="auction_number"
                                class="mt-2 block text-dark w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500
            @error('auction_id') border-red-500 @enderror" aria-readonly="">
                            <option value="">Select an Auction</option>
                            @foreach($auctions as $auction)
                                <option value="{{ $auction->id }}" {{ $auction->id === $auction_id ? 'selected' : '' }}>
                                    {{ $auction->auction_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('auction_id')
                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Title
                        </label>
                        <input type="text" wire:model="title" id="title"
                               class="mt-2 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500
                   @error('title') border-red-500 @enderror">
                        @error('title')
                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Base Price -->
                    <div>
                        <label for="base_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Base Price
                        </label>
                        <input type="number" step="0.01" wire:model="base_price" id="base_price"
                               class="mt-2 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500
                   @error('base_price') border-red-500 @enderror">
                        @error('base_price')
                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Create Listing
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

