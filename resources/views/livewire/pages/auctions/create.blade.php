<?php

use App\Models\Auction;

use Livewire\Volt\Component;

new class extends Component {

    public $auction_number, $start_time, $end_time;

    public function store()
    {
        $this->validate([
            'auction_number' => 'required|unique:auctions',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        Auction::create([
            'auction_number' => $this->auction_number,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        session()->flash('success', 'Auction created successfully!');
        $this->redirect(route('auctions.index'), navigate: true);
        $this->reset();
    }

}; ?>


<div class="max-w-xl mx-auto p-6 bg-white shadow-lg rounded-lg">

    <form wire:submit.prevent="store" class="space-y-4">
        <div class="mt-4">
            <label class="block text-gray-700">Auction Number</label>
            <input type="text" wire:model="auction_number" class="w-full p-3 border rounded">
            @error('auction_number') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <label class="block text-gray-700">Start Time</label>
            <input type="datetime-local" wire:model="start_time" class="w-full p-3 border rounded">
            @error('start_time') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <label class="block text-gray-700">End Time</label>
            <input type="datetime-local" wire:model="end_time" class="w-full p-3 border rounded">
            @error('end_time') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit"
                class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            Create Auction
        </button>
    </form>
</div>
