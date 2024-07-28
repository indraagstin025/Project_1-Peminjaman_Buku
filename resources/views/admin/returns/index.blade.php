<x-admin-layout title="List Pengembalian">
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($success = session()->get('success'))
                <div class="card border-left-success mb-3">
                    <div class="card-body">{!! $success !!}</div>
                </div>
            @endif

            <x-admin.search url="{{ route('admin.returns.index') }}" placeholder="Cari pengembalian..." />

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Buku</th>
                            <th>Peminjam</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($restores as $restore)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ isset($restore->book->cover) ? asset('storage/' . $restore->book->cover) : asset('storage/placeholder.png') }}"
                                            alt="{{ $restore->book->title }}" class="img-thumbnail" style="width: 100px;">
                                        <span class="ml-3">{{ $restore->book->title }}</span>
                                    </div>
                                </td>
                                <td>{{ $restore->user->name }}</td>
                                <td>{{ $restore->returned_at->locale('id_ID')->isoFormat('LL') }}</td>
                                <td>
                                    @switch($restore->status)
                                        @case(\App\Models\Restore::STATUSES['Returned'])
                                            <span class="badge badge-success">{{ $restore->status }}</span>
                                        @break

                                        @case(\App\Models\Restore::STATUSES['Not confirmed'])
                                            <span class="badge badge-warning">{{ $restore->status }}</span>
                                        @break

                                        @case(\App\Models\Restore::STATUSES['Past due'])
                                            <span class="badge badge-danger">{{ $restore->status }}</span>
                                        @break

                                        @case(\App\Models\Restore::STATUSES['Fine not paid'])
                                            <span class="badge badge-dark">{{ $restore->status }}</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="mb-2">
                                            <a href="{{ route('admin.returns.edit', $restore) }}" class="btn btn-sm btn-primary edit-button">Edit</a>
                                            <form action="{{ route('admin.returns.destroy', $restore) }}" method="POST" class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger ml-2">Hapus</button>
                                            </form>
                                        </div>
                                        @if ($restore->status === \App\Models\Restore::STATUSES['Not confirmed'])
                                            <form action="{{ route('admin.returns.update', $restore) }}" method="POST" class="w-100 text-center">
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
                    {{ $restores->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const confirmDelete = (event) => {
                    event.preventDefault();
                    const form = event.target;

                    Swal.fire({
                        title: 'Apakah Anda yakin ingin menghapus pengembalian ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Iya',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                };

                document.querySelectorAll('.delete-form').forEach(form => {
                    form.addEventListener('submit', confirmDelete);
                });

                document.querySelectorAll('.confirm-button').forEach(button => {
                    button.addEventListener('click', function (event) {
                        event.preventDefault();
                        const form = button.closest('form');

                        Swal.fire({
                            title: 'Apakah Anda yakin ingin mengkonfirmasi pengembalian ini?',
                            icon: 'warning',
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

                document.querySelectorAll('.edit-button').forEach(button => {
                    button.addEventListener('click', function (event) {
                        event.preventDefault();
                        const url = button.getAttribute('href');

                        Swal.fire({
                            title: 'Apakah Anda yakin ingin mengedit pengembalian ini?',
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
            });
        </script>
    @endsection
</x-admin-layout>
