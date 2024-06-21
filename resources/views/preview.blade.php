<!-- resources/views/preview.blade.php -->
<x-app-layout>
    <section class="container min-vh-100">
        <br>
        <br>
        <div class="row row-cols-1 row-cols-lg-2 g-5" style="padding-top: 7rem; padding-bottom: 3rem">
            <div class="col">
                <img class="d-block rounded-4 mx-auto width" style="width: 50%"
                    src="{{ isset($book->cover) ? asset('storage/' . $book->cover) : asset('storage/placeholder.png') }}"
                    alt="{{ $book->title }}" />
            </div>
            <div class="col">
                <div class="d-flex align-items-center">
                    <h1 class="m-0 fw-bold">{{ $book->title }} ({{ $book->publish_year }})</h1>

                    <div class="ms-3 px-3 py-1 text-white bg-primary rounded-5">
                        {{ $book->category }}
                    </div>
                </div>

                <h2 class="my-3 fs-5">
                    Karya: <span class="fw-bold">{{ $book->writer }}</span>
                </h2>
                
                <h2 class="my-3 fs-5">
                    Jumlah tersedia: <span class="fw-bold">{{ $book->amount }} buku</span>
                </h2>

                <div class="mt-5">
                    {!! $book->synopsis !!}
                </div>

                @if (auth()->check())
                    <form class="my-5" action="{{ route('my-books.store', $book) }}" method="POST">
                        @csrf
                        @method('POST')
                        
                        <div class="row row-cols-1 row-cols-lg-2 mb-3">
                            <div>
                                <label for="duration">Durasi</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="duration" value="{{ old('duration') }}">
                                    <span class="input-group-text">hari</span>
                                </div>
                                @error('duration')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="amount">Jumlah Buku (maks: {{ $book->amount }} buku)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="amount" value="{{ old('amount') }}">
                                    <span class="input-group-text">buku</span>
                                </div>
                                @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg d-block mx-auto px-5">Pinjam
                            Buku</button>
                    </form>

                    {{-- Form untuk menambahkan ke wishlist --}}
                    <form action="{{ route('wishlists.store', $book) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-lg d-block mx-auto px-5">Tambah ke Wishlist</button>
                    </form>
                @elseif ($book->amount > 0)
                    <button type="button" class="btn btn-outline-secondary btn-lg d-block mx-auto px-5 my-5"
                        disabled>Anda harus login untuk bisa meminjam</button>
                @else
                    <button type="button" class="btn btn-outline-secondary btn-lg d-block mx-auto px-5 my-5"
                        disabled>Buku tidak tersedia</button>
                @endif

                <!-- Review and Rating Section -->
                <div class="mt-5">
                    <h3>Rating: {{ round($book->average_rating, 1) }} / 5 ({{ $book->total_reviews }} ulasan)</h3>
                    @foreach ($book->reviews as $review)
                        <div class="mb-3">
                            <strong>{{ $review->user->name }}</strong>
                            <div>
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="bi bi-star{{ $i < $review->rating ? '-fill' : '' }}" style="color: gold;"></i>
                                @endfor
                            </div>
                            <p>{{ $review->review }}</p>
                        </div>
                    @endforeach
                </div>

                @if (auth()->check() && auth()->user()->role === 'Member')
                    @if (!$book->reviews()->where('user_id', auth()->id())->exists())
                        <form action="{{ route('reviews.store', $book) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="rating">Rating</label>
                                <select name="rating" id="rating" class="form-control">
                                    <option value="1">1 - Sangat Buruk</option>
                                    <option value="2">2 - Buruk</option>
                                    <option value="3">3 - Cukup</option>
                                    <option value="4">4 - Baik</option>
                                    <option value="5">5 - Sangat Baik</option>
                                </select>
                                @error('rating')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="review">Review</label>
                                <textarea name="review" id="review" rows="5" class="form-control">{{ old('review') }}</textarea>
                                @error('review')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Review</button>
                        </form>
                    @else
                        <p>Anda sudah memberikan review untuk buku ini.</p>
                    @endif
                @endif
            </div>
        </div>
    </section>
</x-app-layout>
