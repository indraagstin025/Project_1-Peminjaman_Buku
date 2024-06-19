<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::with(['user', 'librarian'])->get();
        return view('chat.index', compact('chats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);

        $librarian = User::where('role', 'Pustakawan')->first();

        Chat::create([
            'user_id' => Auth::id(),
            'librarian_id' => $librarian->id,
            'message' => $request->message,
        ]);

        return redirect()->route('chat.index');
    }
}
