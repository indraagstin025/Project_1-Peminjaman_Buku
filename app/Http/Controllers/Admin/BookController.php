<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::query();

        $books->when($request->search, function (Builder $query) use ($request) {
            $query->where(function (Builder $q) use ($request) {
                $q->where('title', 'LIKE', "%{$request->search}%")
                    ->orWhere('publisher', 'LIKE', "%{$request->search}%")
                    ->orWhere('writer', 'LIKE', "%{$request->search}%")
                    ->orWhere('publish_year', 'LIKE', "%{$request->search}%")
                    ->orWhere('category', 'LIKE', "%{$request->search}%");
            });
        });

        $books = $books->latest('id')->paginate(10);

        return view('admin.books.index')->with([
            'books' => $books,
        ]);
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        // Periksa jumlah buku yang ada saat ini
        if (Book::count() >= 10) {
            return redirect()
                ->route('admin.books.index')
                ->with('error', 'Maksimal jumlah buku yang dapat dimasukkan adalah 10.');
        }

        $book = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'synopsis' => ['required', 'string'],
            'publisher' => ['required', 'string', 'max:255'],
            'writer' => ['required', 'string', 'max:255'],
            'publish_year' => ['required', 'numeric'],
            'cover' => ['nullable', 'file', 'image', 'max:2048'],
            'category' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'max:10'],
            'status' => ['required', Rule::in(Book::STATUSES)],
        ]);

        if ($request->hasFile('cover')) {
            $book['cover'] = $request->file('cover')->store('covers');
        }

        $createdBook = Book::create($book);

        // Update status if amount is 0 or more
        $this->updateBookStatus($createdBook);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Berhasil menambah buku.');
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit')->with('book', $book);
    }

    public function update(Request $request, Book $book)
    {
        // Hitung jumlah buku selain buku yang sedang diupdate
        $currentBookCount = Book::where('id', '!=', $book->id)->count();

        // Jika jumlah buku selain yang sedang diupdate >= 10, batalkan update
        if ($currentBookCount >= 10) {
            return redirect()
                ->route('admin.books.index')
                ->with('error', 'Maksimal jumlah buku yang dapat dimasukkan adalah 10.');
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'synopsis' => ['required', 'string'],
            'publisher' => ['required', 'string', 'max:255'],
            'writer' => ['required', 'string', 'max:255'],
            'publish_year' => ['required', 'numeric'],
            'cover' => ['nullable', 'file', 'image', 'max:2048'],
            'category' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'max:10'],
            'status' => ['required', Rule::in(Book::STATUSES)],
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers');

            if (isset($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }
        }

        $book->update($data);

        // Update status based on amount
        $this->updateBookStatus($book);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Berhasil mengedit buku.');
    }

    public function destroy(Book $book)
    {
        if (isset($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }
        
        $book->delete();

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Berhasil menghapus buku.');
    }

    /**
     * Update the status of the book based on its amount.
     *
     * @param Book $book
     * @return void
     */
    protected function updateBookStatus(Book $book)
    {
        if ($book->amount <= 0) {
            $book->status = Book::STATUSES['Unavailable'];
        } else {
            $book->status = Book::STATUSES['Available'];
        }

        $book->save();
    }
}
