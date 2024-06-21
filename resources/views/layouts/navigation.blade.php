<div class="fixed-top">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <div class="container-fluid">
            <a class="navbar-brand fs-4 fw-bold" href="{{ route('home') }}">Peminjaman Buku</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarItems"
                aria-controls="navbarItems" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarItems">
                <div class="navbar-nav ms-auto">
                    @auth
                        <a class="nav-link text-light fw-bold {{ request()->routeIs('wishlists.index') ? 'active' : '' }}" href="{{ route('wishlists.index') }}">Wishlist</a>
                        <a class="nav-link text-light fw-bold {{ request()->routeIs('my-books.*') ? 'active' : '' }}" href="{{ route('my-books.index') }}">Buku-ku</a>
                        <a class="nav-link text-light fw-bold {{ request()->routeIs('chat.index') ? 'active' : '' }}" href="{{ route('chat.index') }}">Chat</a>
                        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Anda yakin ingin keluar?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-link nav-link fw-bold text-light" type="submit">Logout</button>
                        </form>
                    @endauth

                    @guest
                        <a class="nav-link fw-bold text-light" href="{{ route('login') }}">Login</a>
                        <a class="nav-link fw-bold text-light" href="{{ route('register') }}">Register</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    @auth
    @if (in_array(auth()->user()->role, [\App\Models\User::ROLES['Admin'], \App\Models\User::ROLES['Librarian']]))
        <div class="navbar px-5 bg-primary text-light d-flex justify-content-between">
            <span>Anda adalah <b>{{ auth()->user()->role }}</b></span>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Ke Dashboard</a>
        </div>
    @endif
@endauth

</div>
