<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Sistem Monitoring Guru</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="d-flex">

    {{-- SIDEBAR --}}
    <aside class="bg-white border-end">

        <h5 class="fw-bold">
            <i class="bi bi-mortarboard-fill"></i>
            <span>Kepsek Panel</span>
        </h5>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('kepsek.dashboard') }}"
                   class="nav-link {{ request()->routeIs('kepsek.dashboard') ? 'active fw-semibold text-primary' : '' }}">
                    <i class="bi bi-speedometer2"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kepsek.jurnal.index') }}"
                   class="nav-link {{ request()->routeIs('kepsek.jurnal.*') ? 'active fw-semibold text-primary' : '' }}">
                    <i class="bi bi-journal-text"></i><span>Jurnal Guru</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kepsek.guru.index') }}"
                   class="nav-link {{ request()->routeIs('kepsek.guru.*') ? 'active fw-semibold text-primary' : '' }}">
                    <i class="bi bi-people"></i><span>Data Guru</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kepsek.evaluasi.index') }}"
                   class="nav-link {{ request()->routeIs('kepsek.evaluasi.*') ? 'active fw-semibold text-primary' : '' }}">
                    <i class="bi bi-clipboard-check"></i><span>Evaluasi</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kepsek.laporan.index') }}"
                   class="nav-link {{ request()->routeIs('kepsek.laporan.*') ? 'active fw-semibold text-primary' : '' }}">
                    <i class="bi bi-bar-chart-line"></i><span>Laporan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kepsek.pengaturan.index') }}"
                   class="nav-link {{ request()->routeIs('kepsek.pengaturan.*') ? 'active fw-semibold text-primary' : '' }}">
                    <i class="bi bi-gear"></i><span>Pengaturan</span>
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

    {{-- MAIN --}}
    <main class="flex-grow-1">

        {{-- TOPBAR --}}
        <div class="bg-white border-bottom d-flex justify-content-between align-items-center">
            <div class="fw-semibold">@yield('title')</div>
            <div class="d-flex align-items-center gap-2">

                {{-- FOTO / AVATAR --}}
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                         alt="Foto"
                         style="width:36px;height:36px;border-radius:50%;object-fit:cover;
                                border:2px solid var(--line);box-shadow:var(--e1);">
                @else
                    <i class="bi bi-person-circle" style="font-size:26px;color:var(--jade);"></i>
                @endif

                <div>
                    <div class="fw-semibold">{{ Auth::user()->nama_lengkap }}</div>
                    <small class="text-muted">Kepala Sekolah</small>
                </div>
            </div>
        </div>

        @yield('content')

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>