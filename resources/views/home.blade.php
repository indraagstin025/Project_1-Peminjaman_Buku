<x-app-layout>
    <section class="hero-section" style="background: url('your-background-image.jpg') no-repeat center center; background-size: cover; position: relative;">
        <div style="background: rgba(0, 0, 0, 0.6); position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
        <div class="container text-center py-5" style="position: relative; z-index: 2;">
            <br><br><br>
            <h1 class="display-4 fw-bold text-white d-none d-md-block">Selamat Datang di Pinjam Buku!</h1>
            <h2 class="fw-bold text-white d-block d-md-none">Selamat Datang di Pinjam Buku!</h2>
            <form action="{{ route('search') }}" method="GET" class="search-form mt-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari buku...">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M15.646 14.354l-3.782-3.782A5.93 5.93 0 0 0 13 6c0-3.313-2.687-6-6-6S1 2.687 1 6s2.687 6 6 6c1.285 0 2.465-.418 3.438-1.122l3.782 3.782a1 1 0 0 0 1.414-1.414zM2 6a4 4 0 1 1 8 0a4 4 0 0 1-8 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="fw-bold text-center mb-4">Kategori Buku</h2>
            <ul class="nav nav-tabs justify-content-center" id="categoryTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="popular-tab" data-bs-toggle="tab" data-bs-target="#popular" type="button" role="tab" aria-controls="popular" aria-selected="true">Paling Populer</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="newest-tab" data-bs-toggle="tab" data-bs-target="#newest" type="button" role="tab" aria-controls="newest" aria-selected="false">Terbaru</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="novel-tab" data-bs-toggle="tab" data-bs-target="#novel" type="button" role="tab" aria-controls="novel" aria-selected="false">Novel</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="comic-tab" data-bs-toggle="tab" data-bs-target="#comic" type="button" role="tab" aria-controls="comic" aria-selected="false">Komik</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="encyclopedia-tab" data-bs-toggle="tab" data-bs-target="#encyclopedia" type="button" role="tab" aria-controls="encyclopedia" aria-selected="false">Ensiklopedia</button>
                </li>
            </ul>

            <div class="tab-content mt-4" id="categoryTabsContent">
                <!-- Konten tab -->
                @foreach (['popular' => $popularBooks, 'newest' => $newestBooks, 'novel' => $novelBooks, 'comic' => $comicBooks, 'encyclopedia' => $encyclopediaBooks] as $category => $books)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $category }}" role="tabpanel" aria-labelledby="{{ $category }}-tab">
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        @foreach ($books as $book)
                        <div class="col mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ isset($book->cover) ? asset('storage/' . $book->cover) : asset('storage/placeholder.png') }}" class="card-img-top img-fluid" style="height: 400px; object-fit: cover;" alt="{{ $book->title }}">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $book->title }}</h5>
                                    <p class="card-text">{{ $category == 'popular' ? "Dipinjam " . $book->borrows_count . " kali" : ($category == 'newest' ? "Terbit " . $book->created_at->locale('id_ID')->diffForHumans() : "Kategori: " . ucfirst($category)) }}</p>
                                    <a href="{{ route('preview', $book) }}" class="btn btn-primary stretched-link">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
