@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height:90vh;">
        <div class="col-md-5">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    {{-- HEADER --}}
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-success">Registrasi Akun</h4>
                        <p class="text-muted small">Buat akun untuk menggunakan sistem jurnal</p>
                    </div>

                    {{-- ALERT SUCCESS --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    {{-- ALERT ERROR --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    {{-- FORM REGISTER --}}
                    <form method="POST" action="{{ route('register.process') }}">
                        @csrf

                        {{-- NAMA LENGKAP --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input
                                    type="text"
                                    name="nama_lengkap"
                                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    placeholder="Masukkan nama lengkap"
                                    value="{{ old('nama_lengkap') }}"
                                    required
                                >
                            </div>
                            @error('nama_lengkap')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Masukkan email"
                                    value="{{ old('email') }}"
                                    required
                                >
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- ROLE --}}
                        <div class="mb-3">
                            <label class="form-label">Daftar Sebagai</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person-badge"></i>
                                </span>
                                <select
                                    name="role"
                                    class="form-select @error('role') is-invalid @enderror"
                                    required
                                >
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>
                                        -- Pilih Role --
                                    </option>
                                    <option value="guru"   {{ old('role') === 'guru'   ? 'selected' : '' }}>
                                        Guru
                                    </option>
                                    <option value="kepsek" {{ old('role') === 'kepsek' ? 'selected' : '' }}>
                                        Kepala Sekolah
                                    </option>
                                </select>
                            </div>
                            @error('role')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password (min. 6 karakter)"
                                    required
                                >
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- KONFIRMASI PASSWORD --}}
                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-shield-lock"></i>
                                </span>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password"
                                    required
                                >
                            </div>
                        </div>

                        {{-- BUTTON --}}
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-person-plus"></i> Daftar
                            </button>
                        </div>

                    </form>

                    {{-- LINK LOGIN --}}
                    <div class="text-center mt-3">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="fw-semibold text-success">
                            Login disini
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection