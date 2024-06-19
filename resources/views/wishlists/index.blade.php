<x-app-layout>
    <section class="py-5 bg-body-tertiary">
        <div class="container">
            <br>
            <br>
            <h2 class="fs-4 fw-bold mb-4">Wishlist Anda</h2>

            @if ($wishlists->isEmpty())
                <p>Anda belum memiliki buku di Wishlist.</p>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                    @foreach ($wishlists as $wishlist)
                        <div class="col">
                            <div class="card">
                                <img src="{{ $wishlist->book->cover ? asset('storage/' . $wishlist->book->cover) : asset('storage/placeholder.png') }}" class="card-img-top" alt="{{ $wishlist->book->title }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $wishlist->book->title }}</h5>
                                    <p class="card-text">{{ $wishlist->book->writer }}</p>
                                    <form action="{{ route('wishlists.destroy', $wishlist->book) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus buku ini dari Wishlist?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus dari Wishlist</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-app-layout>