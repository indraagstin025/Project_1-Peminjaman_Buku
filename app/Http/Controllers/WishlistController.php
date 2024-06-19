<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->with('book')->get();
        return view('wishlists.index', compact('wishlists'));
    }

    public function store(Book $book)
    {
        $wishlist = Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
        ]);

        return redirect()->back()->with('success', 'Buku telah ditambahkan ke Wishlist.');
    }

    public function destroy(Book $book)
    {
        Wishlist::where('user_id', Auth::id())->where('book_id', $book->id)->delete();
        return redirect()->back()->with('success', 'Buku telah dihapus dari Wishlist.');
    }
}