<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restore extends Model
{
    use HasFactory;

    // Nama tabel secara eksplisit disebutkan karena tidak sesuai konvensi Laravel (tabel returns)
    protected $table = "returns";
    
    public $timestamps = false;

    // Definisi status pengembalian
    public const STATUSES = [
        'Returned' => 'Telah dikembalikan',
        'Not confirmed' => 'Belum dikonfirmasi',
        'Past due' => 'Terlambat',
        'Fine not paid' => 'Belum membayar denda',
    ];

    protected $fillable = [
        'returned_at',
        'fine',
        'status',
        'confirmation',
        'book_id',
        'user_id',
        'borrow_id',
    ];

    protected $casts = [
        'returned_at' => 'datetime',
    ];

    // Relasi dengan model Book
    public function book() {
        return $this->belongsTo(Book::class);
    }

    // Relasi dengan model User
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan model Borrow (peminjaman)
    public function borrow() {
        return $this->belongsTo(Borrow::class);
    }
}

