<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Restore;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MyBookController extends Controller
{
    public function index()
    {
        $currentBorrows = Borrow::query()
            ->with('book')
            ->whereBelongsTo(auth()->user())
            ->whereDoesntHave('restore', function (Builder $query) {
                $query->where('confirmation', true);
            })
            ->latest('id')
            ->paginate(6);

        $recentBorrows = Borrow::query()
            ->with(['book', 'restore'])
            ->whereBelongsTo(auth()->user())
            ->whereHas('restore', function (Builder $query) {
                $query->where('confirmation', true);
            })
            ->latest('id')
            ->limit(6)
            ->get();

        return view('my-books')->with([
            'currentBorrows' => $currentBorrows,
            'recentBorrows' => $recentBorrows,
        ]);
    }

    public function update($id)
    {
        $borrow = Borrow::findOrFail($id);

        if (!$borrow->confirmation || isset($borrow->restore)) {
            return back()->withErrors('Peminjaman ini tidak sesuai!');
        }

        $returnStatus = $borrow->borrowed_at->addDays($borrow->duration) > now() ? Restore::STATUSES['Not confirmed'] : Restore::STATUSES['Past due'];

        Restore::create([
            'returned_at' => now(),
            'status' => $returnStatus,
            'confirmation' => 0,
            'book_id' => $borrow->book->id,
            'user_id' => auth()->id(),
            'borrow_id' => $borrow->id,
            'amount' => $borrow->amount,  // Track the amount being returned
        ]);

        return redirect()->route('my-books.index')->with('success', 'Berhasil mengajukan pengembalian!');
    }

    protected function hasBorrowedBook($userId, $bookId)
    {
        return Borrow::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->whereDoesntHave('restore', function (Builder $query) {
                $query->where('confirmation', true);
            })
            ->exists();
    }

    protected function countBorrowedBooksByUser($userId, $bookId)
    {
        return Borrow::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->whereDoesntHave('restore', function (Builder $query) {
                $query->where('confirmation', true);
            })
            ->sum('amount');
    }

    public function store(Request $request, Book $book)
    {
        $userId = auth()->id();
        $amountRequested = $request->amount;
    
        // Check if the user has already borrowed this book and not returned it
        $amountBorrowed = $this->countBorrowedBooksByUser($userId, $book->id);
    
        if ($amountBorrowed + $amountRequested > 2) {
            return redirect()
                ->route('preview', $book)
                ->withErrors(['amount' => 'Anda sudah mencapai batas maksimal peminjaman buku ini.']);
        }
    
        // Check if there is any pending return for this book
        $pendingReturn = Borrow::where('user_id', $userId)
            ->where('book_id', $book->id)
            ->whereHas('restore', function (Builder $query) {
                $query->where('confirmation', false);
            })
            ->exists();
    
        if ($pendingReturn) {
            return redirect()
                ->route('preview', $book)
                ->withErrors(['amount' => 'Anda sudah mencapai batas maksimal peminjaman buku ini.']);
        }
    
        $request->validate([
            'duration' => ['required', 'numeric', 'min:1', 'max:7'],
            'amount' => ['required', 'numeric', 'max:' . $book->amount],
        ]);
    
        Borrow::create([
            'borrowed_at' => now(),
            'duration' => $request->duration,
            'amount' => $request->amount,
            'confirmation' => false,
            'book_id' => $book->id,
            'user_id' => auth()->id(),
        ]);
    
        return redirect()->route('my-books.index')->with('success', 'Berhasil mengajukan peminjaman!');
    }
    

    public function cancel($id)
    {
        $borrow = Borrow::findOrFail($id);
    
        if ($borrow->confirmation) {
            return back()->withErrors('Peminjaman ini sudah dikonfirmasi dan tidak bisa dibatalkan!');
        }
    
        $borrow->delete();
    
        return redirect()->route('my-books.index')->with('success', 'Peminjaman berhasil dibatalkan!');
    }
}

