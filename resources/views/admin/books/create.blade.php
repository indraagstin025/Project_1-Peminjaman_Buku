<x-admin-layout title="Tambah Buku">
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="row" action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" id="bookForm">
                @csrf
                @method('POST')

                <div class="col-12 col-md-6 mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="writer" class="form-label">Penulis</label>
                    <input type="text" name="writer" class="form-control" id="writer" value="{{ old('writer') }}">
                    @error('writer')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="synopsis" class="form-label">Sinopsis</label>
                    <textarea name="synopsis" class="form-control" id="synopsis">{{ old('synopsis') }}</textarea>
                    @error('synopsis')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <input type="text" name="category" class="form-control" id="category" value="{{ old('category') }}">
                    @error('category')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="cover" class="form-label">Cover <small>(max: 2MB)</small></label>
                    <input type="file" name="cover" class="form-control" id="cover" value="{{ old('cover') }}">
                    @error('cover')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="publisher" class="form-label">Penerbit</label>
                    <input type="text" name="publisher" class="form-control" id="publisher" value="{{ old('publisher') }}">
                    @error('publisher')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="publish_year" class="form-label">Tahun Terbit</label>
                    <input type="number" name="publish_year" class="form-control" id="publish_year" value="{{ old('publish_year') }}">
                    @error('publish_year')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="amount" class="form-label">Jumlah</label>
                    <input type="number" name="amount" class="form-control" id="amount" value="{{ old('amount') }}">
                    @error('amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        @foreach (\App\Models\Book::STATUSES as $status)
                            <option @selected(old('status') === $status) value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex w-100 mt-3 justify-content-end">
                    <a href="{{ route('admin.books.index') }}" class="btn btn-warning mx-3">Kembali</a>
                    <button type="submit" class="btn btn-primary mx-3" id="submitButton">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
        <script>
            ClassicEditor
                .create(document.getElementById('synopsis'))
                .catch(error => {
                    console.error(error);
                });

            document.getElementById('bookForm').addEventListener('submit', function(event) {
                let isValid = true;
                let fields = ['title', 'writer', 'synopsis', 'category', 'cover', 'publisher', 'publish_year'];
                fields.forEach(function(field) {
                    let value = document.getElementById(field).value.trim();
                    if (!value) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Mohon lengkapi semua field yang wajib diisi!'
                    });
                }
            });
        </script>
    @endsection
</x-admin-layout>
