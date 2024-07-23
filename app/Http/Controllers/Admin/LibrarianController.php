<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LibrarianController extends Controller
{
    public function index(Request $request)
    {
        $librarians = User::query()
            ->where('role', User::ROLES['Librarian']);

        $librarians->when($request->search, function (Builder $query) use ($request) {
            $query->where(function (Builder $q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                    ->orWhere('username', 'LIKE', "%{$request->search}%")
                    ->orWhere('telephone', 'LIKE', "%{$request->search}%");
            });
        });

        $librarians = $librarians->latest()->paginate(25);

        return view('admin.librarians.index')->with([
            'librarians' => $librarians,
        ]);
    }

    public function create()
    {
        return view('admin.librarians.create');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'unique:' . User::class],
            'address' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string'],
            'gender' => ['required', Rule::in(User::GENDERS)],
            'password' => ['required', 'string', 'confirmed', 'max:255'],
        ]);

        $credentials['role'] = User::ROLES['Librarian'];

        $password = $credentials['password'];
        $credentials['password'] = Hash::make($password);

        User::create($credentials);

        return redirect()
            ->route('admin.librarians.index')
            ->with(
                'success',
                "Berhasil menambah pustakawan.
                <br />
                Username: {$credentials['username']}
                <br />
                Password: {$password}"
            );
    }

    public function edit($id)
    {
        $librarian = User::query()
            ->where('role', User::ROLES['Librarian'])
            ->findOrFail($id);

        return view('admin.librarians.edit')->with('librarian', $librarian);
    }

    public function update(Request $request, $id)
    {
        $librarian = User::query()
            ->where('role', User::ROLES['Librarian'])
            ->findOrFail($id);

        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', Rule::unique(User::class)->ignore($librarian->id)],
            'address' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string'],
            'gender' => ['required', Rule::in(User::GENDERS)],
        ]);

        $credentials['role'] = User::ROLES['Librarian'];

        $successMessage = "Berhasil mengedit pustakawan. <br /> Username: {$credentials['username']}";

        if ($request->filled('password')) {
            $newPassword = $request->validate([
                'password' => ['required', 'string', 'confirmed', 'max:255'],
            ])['password'];

            $credentials['password'] = Hash::make($newPassword);

            $successMessage .= " <br /> Password Baru: {$newPassword}";
        }

        $librarian->update($credentials);

        return redirect()
            ->route('admin.librarians.index')
            ->with('success', $successMessage);
    }

    public function destroy($id)
    {
        $librarian = User::query()
            ->where('role', User::ROLES['Librarian'])
            ->findOrFail($id);

        $librarian->delete();

        return redirect()
            ->route('admin.librarians.index')
            ->with('success', 'Berhasil menghapus pustakawan.');
    }
}
