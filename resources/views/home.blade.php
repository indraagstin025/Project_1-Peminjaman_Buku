<x-app-layout>
    <section class="d-flex flex-column justify-content-center align-items-center text-center mt-5 py-5 px-4">
        <br><br><br>
        <h1 class="mt-4 fs-2 fw-bold">Selamat Datang di Perpustakaan Online!</h1>
        <form action="{{ route('search') }}" method="GET" class="position-relative d-flex w-100 my-4" style="max-width: 630px">
            <input type="text" name="search" class="form-control" placeholder="Cari buku..." />
            <button type="submit" class="btn btn-link position-absolute bottom-0 end-0" style="bottom: 4px; right: 1px;">
                <svg class="text-body-tertiary" fill="currentColor" x="0px" y="0px" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M 9 2 C 5.1458514 2 2 5.1458514 2 9 C 2 12.854149 5.1458514 16 9 16 C 10.747998 16 12.345009 15.348024 13.574219 14.28125 L 14 14.707031 L 14 16 L 19.585938 21.585938 C 20.137937 22.137937 21.033938 22.137938 21.585938 21.585938 C 22.137938 21.033938 22.137938 20.137938 21.585938 19.585938 L 16 14 L 14.707031 14 L 14.28125 13.574219 C 15.348024 12.345009 16 10.747998 16 9 C 16 5.1458514 12.854149 2 9 2 z M 9 4 C 11.773268 4 14 6.2267316 14 9 C 14 11.773268 11.773268 14 9 14 C 6.2267316 14 4 11.773268 4 9 C 4 6.2267316 6.2267316 4 9 4 z"></path>
                </svg>
            </button>
        </form>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="fs-4 fw-bold ms-4 mb-4 text-center">Kategori Buku</h2>
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
                <div class="tab-pane fade show active" id="popular" role="tabpanel" aria-labelledby="popular-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        @foreach ($popularBooks as $popularBook)
                            <a href="{{ route('preview', $popularBook) }}" class="col text-dark text-decoration-none">
                                <div class="card h-100 rounded-4">
                                    <img src="{{ isset($popularBook->cover) ? asset('storage/' . $popularBook->cover) : asset('storage/placeholder.png') }}" alt="{{ $popularBook->title }}" class="card-img-top rounded-4">
                                    <div class="card-body text-center">
                                        <h3 class="card-title fs-5 fw-bold mb-5">{{ $popularBook->title }}</h3>
                                        <span class="fs-6">Dipinjam <span class="fw-bold text-decoration-underline">{{ $popularBook->borrows_count }}</span> kali</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="newest" role="tabpanel" aria-labelledby="newest-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        @foreach ($newestBooks as $newestBook)
                            <a href="{{ route('preview', $newestBook) }}" class="col text-dark text-decoration-none">
                                <div class="card h-100 rounded-4">
                                    <img src="{{ isset($newestBook->cover) ? asset('storage/' . $newestBook->cover) : asset('storage/placeholder.png') }}" alt="{{ $newestBook->title }}" class="card-img-top rounded-4">
                                    <div class="card-body text-center">
                                        <h3 class="card-title fs-5 fw-bold mb-5">{{ $newestBook->title }}</h3>
                                        <span class="fs-6">Terbit <span class="fw-bold text-decoration-underline">{{ $newestBook->created_at->locale('id_ID')->diffForHumans() }}</span></span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="novel" role="tabpanel" aria-labelledby="novel-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        @foreach ($novelBooks as $novelBook)
                            <a href="{{ route('preview', $novelBook) }}" class="col text-dark text-decoration-none">
                                <div class="card h-100 rounded-4">
                                    <img src="{{ isset($novelBook->cover) ? asset('storage/' . $novelBook->cover) : asset('storage/placeholder.png') }}" alt="{{ $novelBook->title }}" class="card-img-top rounded-4">
                                    <div class="card-body text-center">
                                        <h3 class="card-title fs-5 fw-bold mb-5">{{ $novelBook->title }}</h3>
                                        <span class="fs-6">Kategori: Novel</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="comic" role="tabpanel" aria-labelledby="comic-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        @foreach ($comicBooks as $comicBook)
                            <a href="{{ route('preview', $comicBook) }}" class="col text-dark text-decoration-none">
                                <div class="card h-100 rounded-4">
                                    <img src="{{ isset($comicBook->cover) ? asset('storage/' . $comicBook->cover) : asset('storage/placeholder.png') }}" alt="{{ $comicBook->title }}" class="card-img-top rounded-4">
                                    <div class="card-body text-center">
                                        <h3 class="card-title fs-5 fw-bold mb-5">{{ $comicBook->title }}</h3>
                                        <span class="fs-6">Kategori: Komik</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="encyclopedia" role="tabpanel" aria-labelledby="encyclopedia-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        @foreach ($encyclopediaBooks as $encyclopediaBook)
                            <a href="{{ route('preview', $encyclopediaBook) }}" class="col text-dark text-decoration-none">
                                <div class="card h-100 rounded-4">
                                    <img src="{{ isset($encyclopediaBook->cover) ? asset('storage/' . $encyclopediaBook->cover) : asset('storage/placeholder.png') }}" alt="{{ $encyclopediaBook->title }}" class="card-img-top rounded-4">
                                    <div class="card-body text-center">
                                        <h3 class="card-title fs-5 fw-bold mb-5">{{ $encyclopediaBook->title }}</h3>
                                        <span class="fs-6">Kategori: Ensiklopedia</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
