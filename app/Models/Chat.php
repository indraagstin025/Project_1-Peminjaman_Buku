<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'librarian_id', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function librarian()
    {
        return $this->belongsTo(User::class, 'librarian_id');
    }
}
