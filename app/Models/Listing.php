<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bids()
    {
        return $this->hasMany(Bid::class, 'listing_id');
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

}
