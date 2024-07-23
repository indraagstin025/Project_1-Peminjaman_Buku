<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public const STATUSES = [
        'Available' => 'Tersedia',
        'Unavailable' => 'Tidak tersedia',
        'Borrowed' => 'Dipinjam',
    ];

    protected $fillable = [
        'title',
        'synopsis',
        'publisher',
        'writer',
        'publish_year',
        'cover',
        'category',
        'amount',
        'status',
    ];

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        $totalReviews = $this->reviews()->count();

        if ($totalReviews > 0) {
            $totalRating = $this->reviews()->sum('rating');
            return $totalRating / $totalReviews;
        }

        return 0;
    }
}
