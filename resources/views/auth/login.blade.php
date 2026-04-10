@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height:90vh;">
        <div class="col-md-5">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    {{-- HEADER --}}
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-success">
                            Login Sistem Jurnal
                        </h4>
                        <p class="text-muted small">
                            Masuk untuk mengakses dashboard
                        </p>
                    </div>


                    {{-- ALERT ERROR --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif


                    {{-- FORM LOGIN --}}
                    <form method="POST" action="{{ route('login.process') }}">
                        @csrf

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
                                    value="{{ old('email') }}"
                                    placeholder="Masukkan email"
                                    required
                                >
                            </div>
                            @error('email')
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
                                    placeholder="Masukkan password"
                                    required
                                >
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- BUTTON LOGIN --}}
                    <div class="d-flex justify-content-center mt-4">
                        <button class="btn btn-success px-5">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Login
                        </button>
                    </div>

                    </form>

                    {{-- LINK REGISTER --}}
                    <div class="text-center mt-3">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="fw-semibold text-success">
                            Daftar disini
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection