<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Return;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPustakawan = User::where('role', User::ROLES['Librarian'])->count();
        $jumlahMember = User::where('role', User::ROLES['Member'])->count();
        $jumlahBuku = Book::count();
        $jumlahPeminjaman = Borrow::count();

        return view('admin.dashboard', compact('jumlahPustakawan', 'jumlahMember', 'jumlahBuku', 'jumlahPeminjaman'));
    }
}
