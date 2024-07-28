<x-app-layout>
    <section class="mt-5 py-5">
        @if ($message = session()->get('success'))
            <div class="container">
                <div class="card bg-success text-white p-3">
                    {{ $message }}
                </div>
            </div>
        @endif

        @error('default')
            <div class="container">
                <div class="card bg-danger text-white p-3">
                    {{ $message }}
                </div>
            </div>
        @enderror

        <h2 class="mt-4 fs-4 fw-bold ms-4 mb-4 text-uppercase" style="font-size: 24px; color: #4a4a4a;">Sedang di-pinjam</h2>

        <div class="container">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">Cover</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tenggat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($currentBorrows as $currentBorrow)
                            <tr>
                                <td>
                                    <a href="{{ route('preview', $currentBorrow->book) }}">
                                        <img src="{{ isset($currentBorrow->book->cover) ? asset('storage/' . $currentBorrow->book->cover) : asset('storage/placeholder.png') }}"
                                            alt="{{ $currentBorrow->book->title }}" class="img-thumbnail" style="max-width: 100px;">
                                    </a>
                                </td>
                                <td>{{ $currentBorrow->book->title }}</td>
                                <td>
                                    @if (!$currentBorrow->confirmation)
                                        <span class="badge bg-warning text-dark">Belum dikonfirmasi</span>
                                    @else
                                        @switch($currentBorrow->restore?->status)
                                            @case(\App\Models\Restore::STATUSES['Not confirmed'])
                                            @case(\App\Models\Restore::STATUSES['Past due'])
                                                <span class="badge bg-secondary">Menunggu konfirmasi pengembalian...</span>
                                            @break

                                            @case(\App\Models\Restore::STATUSES['Fine not paid'])
                                                <span class="badge bg-danger">
                                                    Denda terlambat: Rp
                                                    {{ number_format($currentBorrow->restore->fine, 0, ',', '.') }},-
                                                </span>
                                            @break

                                            @default
                                                <span class="badge bg-success">Terkonfirmasi</span>
                                        @endswitch
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $due = $currentBorrow->borrowed_at->addDays($currentBorrow->duration);
                                    @endphp
                                    <span class="fw-bold text-{{ $due > now() ? 'success' : 'danger' }}">{{ $due->locale('id_ID')->diffForHumans() }}</span>
                                </td>
                                <td>
                                    @if (!$currentBorrow->confirmation)
                                        <form action="{{ route('my-books.cancel', $currentBorrow->id) }}" method="POST" class="cancel-form">
                                            @csrf
                                            @method('POST')
                                            <button type="button" class="btn btn-danger btn-sm cancel-btn">Batalkan Peminjaman</button>
                                        </form>
                                    @else
                                        @if ($currentBorrow->restore?->status !== \App\Models\Restore::STATUSES['Fine not paid'])
                                            @if (!isset($currentBorrow->restore))
                                                <form action="{{ route('my-books.update', $currentBorrow) }}" method="POST" class="return-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="btn btn-success btn-sm return-btn">Kembalikan</button>
                                                </form>
                                            @endif
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $currentBorrows->links() }}
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <h2 class="fs-4 fw-bold ms-4 mb-4 text-uppercase" style="font-size: 24px; color: #4a4a4a;">Peminjaman terbaru anda</h2>

        <div class="container">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th scope="col">Cover</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentBorrows as $recentBorrow)
                            <tr>
                                <td>
                                    <a href="{{ route('preview', $recentBorrow->book) }}">
                                        <img src="{{ isset($recentBorrow->book->cover) ? asset('storage/' . $recentBorrow->book->cover) : asset('storage/placeholder.png') }}"
                                            alt="{{ $recentBorrow->book->title }}" class="img-thumbnail" style="max-width: 100px;">
                                    </a>
                                </td>
                                <td>{{ $recentBorrow->book->title }}</td>
                                <td>
                                    <span class="fw-bold text-decoration-underline">{{ $recentBorrow->restore->returned_at->locale('id_ID')->isoFormat('LL') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cancelForms = document.querySelectorAll('.cancel-form');
            const returnForms = document.querySelectorAll('.return-form');

            cancelForms.forEach(form => {
                form.querySelector('.cancel-btn').addEventListener('click', function() {
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Anda yakin ingin membatalkan peminjaman buku ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, batalkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            returnForms.forEach(form => {
                form.querySelector('.return-btn').addEventListener('click', function() {
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Anda yakin ingin mengembalikan buku ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, kembalikan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
