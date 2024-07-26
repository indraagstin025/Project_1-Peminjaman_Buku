<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $borrows = Borrow::with(['book', 'user']);

        $borrows->when($request->search, function (Builder $query) use ($request) {
            $query->where(function (Builder $q) use ($request) {
                $q->whereHas('book', function (Builder $query) use ($request) {
                    $query->where('title', 'LIKE', "%{$request->search}%");
                })
                ->orWhereHas('user', function (Builder $query) use ($request) {
                    $query->where('name', 'LIKE', "%{$request->search}%");
                });
            });
        });

        $borrows = $borrows->latest('id')->paginate(10);

        return view('admin.borrows.index')->with([
            'borrows' => $borrows,
        ]);
    }

    public function edit(Borrow $borrow)
    {
        return view('admin.borrows.edit')->with([
            'borrow' => $borrow,
        ]);
    }

    public function update(Request $request, Borrow $borrow)
    {
        $data = $request->validate([
            'confirmation' => ['required', Rule::in([1])],
        ]);

        if (!$borrow->confirmation) {
            $borrow->book()->decrement('amount', $borrow->amount);

            $book = $borrow->book;
            if ($book->amount <= 0) {
                $book->update(['status' => Book::STATUSES['Unavailable']]);
            }
        }

        $borrow->update($data);

        return redirect()
            ->route('admin.borrows.index')
            ->with('success', 'Berhasil mengubah status konfirmasi peminjaman.');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'user_id' => ['required', 'exists:users,id'],
            'duration' => ['required', 'integer'],
        ]);

        $book = Book::findOrFail($data['book_id']);
        $user = auth()->user();

        // Check if the user already borrowed the book and hasn't returned it yet
        $existingBorrowCount = Borrow::where('user_id', $data['user_id'])
            ->where('book_id', $data['book_id'])
            ->whereNull('returned_at')
            ->count();

        if ($existingBorrowCount >= 3) {
            return redirect()
                ->back()
                ->with('error', 'You have already borrowed the maximum of 3 copies of this book and haven\'t returned them yet.');
        }

        if ($book->amount < 1) {
            return redirect()
                ->back()
                ->with('error', 'This book is currently not available for borrowing.');
        }

        Borrow::create($data);

        // Decrease the amount of the book
        $book->decrement('amount');

        return redirect()
            ->route('admin.borrows.index')
            ->with('success', 'Book borrowed successfully.');
    }

    public function destroy(Borrow $borrow)
    {
        $borrow->book()->increment('amount', $borrow->amount);

        $book = $borrow->book;
        if ($book->amount > 0 && $book->status === Book::STATUSES['Unavailable']) {
            $book->update(['status' => Book::STATUSES['Available']]);
        }

        $borrow->delete();

        return redirect()
            ->route('admin.borrows.index')
            ->with('success', 'Berhasil menghapus peminjaman.');
    }
}
