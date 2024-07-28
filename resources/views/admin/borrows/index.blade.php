<x-admin-layout title="List Peminjaman">
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($success = session()->get('success'))
                <div class="card border-left-success mb-3">
                    <div class="card-body">{!! $success !!}</div>
                </div>
            @endif

            <x-admin.search url="{{ route('admin.borrows.index') }}" placeholder="Cari peminjaman..." />

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Buku</th>
                            <th>Peminjam</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($borrows as $borrow)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ isset($borrow->book->cover) ? asset('storage/' . $borrow->book->cover) : asset('storage/placeholder.png') }}"
                                            alt="{{ $borrow->book->title }}" class="img-thumbnail" style="width: 100px;">
                                        <span class="ml-3">{{ $borrow->book->title }}</span>
                                    </div>
                                </td>
                                <td>{{ $borrow->user->name }}</td>
                                <td>{{ $borrow->borrowed_at->locale('id_ID')->isoFormat('LL') }}</td>
                                <td>{{ $borrow->duration }} hari</td>
                                <td>
                                    @switch($borrow->confirmation)
                                        @case(true)
                                            <span class="badge badge-success">Terkonfirmasi</span>
                                        @break

                                        @case(false)
                                            <span class="badge badge-warning">Menunggu konfirmasi</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="mb-2">
                                            <a href="{{ route('admin.borrows.edit', $borrow) }}" class="btn btn-sm btn-primary edit-button">Edit</a>
                                            <form action="{{ route('admin.borrows.destroy', $borrow) }}" method="POST" onsubmit="return confirmDelete(event)" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger ml-2">Hapus</button>
                                            </form>
                                        </div>
                                        @if (!$borrow->confirmation)
                                            <form action="{{ route('admin.borrows.update', $borrow) }}" method="POST" class="w-100 text-center">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="confirmation" value="1">
                                                <button type="button" class="btn btn-sm btn-success confirm-button">Konfirmasi</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-5">
                    {{ $borrows->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                function confirmDelete(event) {
                    event.preventDefault();
                    const form = event.target;

                    Swal.fire({
                        title: 'Apakah Anda yakin ingin menghapus peminjaman ini?',
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

                const confirmButtons = document.querySelectorAll('.confirm-button');
                confirmButtons.forEach(button => {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        const form = this.closest('form');

                        Swal.fire({
                            title: 'Apakah Anda yakin ingin mengonfirmasi peminjaman ini?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Iya',
                            cancelButtonText: 'Tidak'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });

                const editButtons = document.querySelectorAll('.edit-button');
                editButtons.forEach(button => {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        const url = this.getAttribute('href');

                        Swal.fire({
                            title: 'Apakah Anda yakin ingin mengedit peminjaman ini?',
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

                document.querySelectorAll('form[onsubmit="return confirmDelete(event)"]').forEach(form => {
                    form.addEventListener('submit', confirmDelete);
                });
            });
        </script>
    @endsection
</x-admin-layout>
