<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'auctions/index')
    ->name('auctions.index');

//auctions
Route::view('auctions', 'auctions/index')
    ->middleware(['auth'])
    ->name('auctions.index');

Route::view('create-auction', 'auctions/create')
    ->middleware(['auth'])
    ->name('auctions.create');

//listings
Route::view('listings', 'listings/index')
    ->middleware(['auth'])
    ->name('listings.index');

Volt::route('create-listing/{auction_id}', 'pages.listings.create')
    ->middleware(['auth'])
    ->name('listings.create');

//bids
Volt::route('bids/{listing_id}', 'pages.bids.index')
    ->name('bids.index');

Volt::route('auctions/{auction_id}', 'pages.auctions.view')
    ->name('auctions.view');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
