<x-admin-layout title="List Buku">
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($success = session()->get('success'))
                <div class="card border-left-success">
                    <div class="card-body">{!! $success !!}</div>
                </div>
            @endif

            <a href="{{ route('admin.books.create') }}" class="btn btn-primary my-3">Tambah</a>

            <x-admin.search url="{{ route('admin.books.index') }}" placeholder="Cari buku..." />

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Jumlah Tersedia</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ isset($book->cover) ? asset('storage/' . $book->cover) : asset('storage/placeholder.png') }}"
                                        alt="{{ $book->title }}" class="img-thumbnail" style="width: 100px;">
                                </td>
                                <td>{{ $book->category }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->writer }}</td>
                                <td>{{ $book->publisher }}</td>
                                <td>{{ $book->publish_year }}</td>
                                <td>{{ $book->amount }} buku</td>
                                <td>
                                    @switch($book->status)
                                        @case(\App\Models\Book::STATUSES['Available'])
                                            <span class="badge badge-success">Tersedia</span>
                                        @break

                                        @case(\App\Models\Book::STATUSES['Unavailable'])
                                            <span class="badge badge-warning">Tidak Tersedia</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('admin.books.edit', $book) }}"
                                        class="btn btn-sm btn-primary mb-2 edit-button">Edit</a>

                                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                                        onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-5">
                    {{ $books->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(event) {
                event.preventDefault();
                const form = event.target;
                
                Swal.fire({
                    title: 'Apakah anda yakin ingin menghapus buku ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Iya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }

            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.href;
                    
                    Swal.fire({
                        title: 'Apakah anda ingin mengedit buku ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Iya',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    });
                });
            });
        </script>
    @endsection
</x-admin-layout>
