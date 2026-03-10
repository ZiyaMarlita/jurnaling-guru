<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Sistem Monitoring Guru</title>

    {{-- FONT: Plus Jakarta Sans (sesuai style.css) --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- BOOTSTRAP CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- BOOTSTRAP ICONS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    {{-- CUSTOM CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

{{-- FIX: hapus class bg-light dari body, biar style.css yang handle --}}
<body>

<div class="d-flex">

    {{-- ================= SIDEBAR ================= --}}
    {{-- FIX: hapus inline style width & position, sudah dihandle style.css --}}
    <aside class="bg-white border-end">

        <h5 class="fw-bold">
            <i class="bi bi-mortarboard-fill"></i>
            <span>Sistem Jurnal</span>
        </h5>

        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="{{ route('guru.dashboard') }}"
                   class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active fw-semibold text-success' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('guru.jurnal.index') }}"
                   class="nav-link {{ request()->routeIs('guru.jurnal.*') ? 'active fw-semibold text-success' : '' }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Jurnal</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('guru.profil.index') }}"
                   class="nav-link {{ request()->routeIs('guru.profil.*') ? 'active fw-semibold text-success' : '' }}">
                    <i class="bi bi-person"></i>
                    <span>Profil</span>
                </a>
            </li>

        </ul>

        <hr>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>

    </aside>
    {{-- ================= END SIDEBAR ================= --}}


    {{-- ================= MAIN CONTENT ================= --}}
    {{-- FIX: hapus inline style, sudah dihandle style.css --}}
    <main class="flex-grow-1">

        {{-- TOPBAR --}}
        <div class="bg-white border-bottom d-flex justify-content-between align-items-center">

            <div class="fw-semibold">
                @yield('title')
            </div>

            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person-circle fs-4"></i>
                <div>
                    <div class="fw-semibold">{{ Auth::user()->nama_lengkap }}</div>
                    <small class="text-muted">Guru</small>
                </div>
            </div>

        </div>

        {{-- PAGE CONTENT --}}
        {{-- FIX: hapus <div class="p-4"> di sini — padding sudah ada di masing-masing view --}}
        @yield('content')

    </main>
    {{-- ================= END MAIN CONTENT ================= --}}

</div>

{{-- BOOTSTRAP JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>