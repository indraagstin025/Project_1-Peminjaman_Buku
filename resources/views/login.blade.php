<x-guest-layout title="Login">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5"> 
                <div class="card shadow-sm rounded-4"> 
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h2 class="mb-0">
                            <i class="fas fa-book-open me-2"></i> Perpustakaan
                        </h2>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="username" class="form-control" id="username" value="{{ old('username') }}">
                                </div>
                                @error('username')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" id="password">
                                </div>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill">Login</button>

                            <div class="mt-3 text-center">
                                Belum punya akun? <a href="{{ route('register') }}">Daftar!</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        @if(session('login_error'))
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '{{ session('login_error') }}',
            });
        @endif
    </script>
</x-guest-layout>
