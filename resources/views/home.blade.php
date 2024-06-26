<x-app-layout>
    <section class="hero-section">
        <div class="container text-center py-5">
            <br><br><br>
            <h1 class="display-4 fw-bold">Selamat Datang di Pinjam Buku!</h1>
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
                <div class="tab-pane fade show active" id="popular" role="tabpanel" aria-labelledby="popular-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach ($popularBooks as $popularBook)
                        <div class="col mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ isset($popularBook->cover) ? asset('storage/' . $popularBook->cover) : asset('storage/placeholder.png') }}" class="card-img-top" alt="{{ $popularBook->title }}">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $popularBook->title }}</h5>
                                    <p class="card-text">Dipinjam <span class="fw-bold">{{ $popularBook->borrows_count }}</span> kali</p>
                                    <a href="{{ route('preview', $popularBook) }}" class="btn btn-primary stretched-link">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="newest" role="tabpanel" aria-labelledby="newest-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach ($newestBooks as $newestBook)
                        <div class="col mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ isset($newestBook->cover) ? asset('storage/' . $newestBook->cover) : asset('storage/placeholder.png') }}" class="card-img-top" alt="{{ $newestBook->title }}">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $newestBook->title }}</h5>
                                    <p class="card-text">Terbit {{ $newestBook->created_at->locale('id_ID')->diffForHumans() }}</p>
                                    <a href="{{ route('preview', $newestBook) }}" class="btn btn-primary stretched-link">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="novel" role="tabpanel" aria-labelledby="novel-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach ($novelBooks as $novelBook)
                        <div class="col mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ isset($novelBook->cover) ? asset('storage/' . $novelBook->cover) : asset('storage/placeholder.png') }}" class="card-img-top" alt="{{ $novelBook->title }}">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $novelBook->title }}</h5>
                                    <p class="card-text">Kategori: Novel</p>
                                    <a href="{{ route('preview', $novelBook) }}" class="btn btn-primary stretched-link">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="comic" role="tabpanel" aria-labelledby="comic-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach ($comicBooks as $comicBook)
                        <div class="col mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ isset($comicBook->cover) ? asset('storage/' . $comicBook->cover) : asset('storage/placeholder.png') }}" class="card-img-top" alt="{{ $comicBook->title }}">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $comicBook->title }}</h5>
                                    <p class="card-text">Kategori: Komik</p>
                                    <a href="{{ route('preview', $comicBook) }}" class="btn btn-primary stretched-link">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="encyclopedia" role="tabpanel" aria-labelledby="encyclopedia-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach ($encyclopediaBooks as $encyclopediaBook)
                        <div class="col mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ isset($encyclopediaBook->cover) ? asset('storage/' . $encyclopediaBook->cover) : asset('storage/placeholder.png') }}" class="card-img-top" alt="{{ $encyclopediaBook->title }}">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $encyclopediaBook->title }}</h5>
                                    <p class="card-text">Kategori: Ensiklopedia</p>
                                    <a href="{{ route('preview', $encyclopediaBook) }}" class="btn btn-primary stretched-link">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
