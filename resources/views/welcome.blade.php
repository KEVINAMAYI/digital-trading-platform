<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DTP</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
            <livewire:welcome.navigation />
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <img src="{{ asset('coding-test-logo.jpg') }}" class="rounded-full block h-12 w-12" alt="Logo">
            </div>

            <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-white mt-6">Welcome to AuctionMaster</h1>
            <p class="text-lg text-center text-gray-600 dark:text-gray-300 mt-4">
                The premier online auction platform where buyers and sellers connect to win the best deals.
            </p>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Live Bidding</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Bid in real-time on exciting auctions happening now.</p>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Competitive Prices</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Win products at the best prices through our transparent bidding system.</p>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Seamless Transactions</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Secure and easy payments for a hassle-free experience.</p>
                </div>
            </div>

            <div class="flex justify-center mt-10">
                <a href="{{ route('auctions.index') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition">
                    Start Bidding Now
                </a>
            </div>
        </div>
    </div>
    </body>
</html>
