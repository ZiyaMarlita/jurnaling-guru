@extends('layouts.guru')

@section('title', 'Dashboard Guru')

@section('content')

<div class="p-4 fade-up">

    {{-- HEADER WELCOME --}}
    <div class="card mb-4" style="background:linear-gradient(135deg,#0f172a 0%,#1e3a5f 60%,#0f4c3a 100%);border:none !important;overflow:hidden;position:relative;">
        <div style="position:absolute;inset:0;background:radial-gradient(circle at 80% 50%,rgba(5,150,105,0.15) 0%,transparent 60%);pointer-events:none;"></div>
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3" style="position:relative;">
            <div class="d-flex align-items-center gap-3">
                <img
                    src="{{ $guru->foto ? asset('storage/'.$guru->foto) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->nama_lengkap).'&background=059669&color=fff&size=200' }}"
                    width="60" height="60"
                    class="rounded-circle"
                    style="border:2px solid rgba(255,255,255,0.2);object-fit:cover;"
                    alt="Foto Profil"
                >
                <div>
                    <div style="font-size:18px;font-weight:800;color:#fff;letter-spacing:-0.3px;">{{ Auth::user()->nama_lengkap }}</div>
                    <div style="font-size:13px;color:rgba(255,255,255,0.6);">Guru &nbsp;•&nbsp; Selamat datang kembali 👋</div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('guru.profil.index') }}" class="btn btn-sm" style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);color:#fff;font-weight:600;">
                    <i class="bi bi-person"></i> Profil
                </a>
                <a href="{{ route('guru.jurnal.create') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Jurnal
                </a>
            </div>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4 stagger">

        <div class="col-sm-6 col-md-3">
            <div class="stat-box">
                <div style="width:42px;height:42px;background:var(--brand-light);border-radius:var(--r);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                    <i class="bi bi-journal-check" style="font-size:18px;color:var(--brand);"></i>
                </div>
                <div class="stat-title">Total Jurnal</div>
                <div class="stat-value">{{ $totalJurnal ?? 0 }}</div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="stat-box">
                <div style="width:42px;height:42px;background:#dbeafe;border-radius:var(--r);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                    <i class="bi bi-calendar2-week" style="font-size:18px;color:#1d4ed8;"></i>
                </div>
                <div class="stat-title">Bulan Ini</div>
                <div class="stat-value" style="color:#1d4ed8;">{{ $totalJurnalBulan ?? 0 }}</div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="stat-box">
                <div style="width:42px;height:42px;background:#fef3c7;border-radius:var(--r);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                    <i class="bi bi-star-fill" style="font-size:18px;color:var(--warning);"></i>
                </div>
                <div class="stat-title">Rata-rata Nilai</div>
                <div class="stat-value" style="color:var(--warning);">{{ $rataRata ? number_format($rataRata, 1) : '—' }}</div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="stat-box">
                <div style="width:42px;height:42px;background:var(--bg);border-radius:var(--r);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                    <i class="bi bi-activity" style="font-size:18px;color:var(--text-muted);"></i>
                </div>
                <div class="stat-title">Status Terakhir</div>
                <div class="stat-value" style="font-size:18px;text-transform:capitalize;color:var(--text-primary);">{{ $statusTerakhir ?? '—' }}</div>
            </div>
        </div>

    </div>

    {{-- JURNAL TERBARU --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-clock-history me-2 text-success"></i>Jurnal Terbaru</span>
            <a href="{{ route('guru.jurnal.index') }}" class="btn btn-sm btn-outline-success">
                Lihat Semua
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th class="text-end">Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($jurnalTerbaru as $item)
                    <tr style="cursor:pointer;" onclick="window.location='{{ route('guru.jurnal.show', $item->id) }}'">
                        <td>
                            <span style="font-weight:600;color:var(--brand);">{{ $item->mata_pelajaran }}</span>
                        </td>
                        <td>{{ $item->kelas }}</td>
                        <td>{{ $item->tanggal->format('d M Y') }}</td>
                        <td class="text-end">
                            @if($item->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($item->status === 'dinilai')
                                <span class="badge bg-success">Dinilai</span>
                            @elseif($item->status === 'revisi')
                                <span class="badge bg-danger">Revisi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-x" style="font-size:32px;display:block;margin-bottom:8px;opacity:0.3;"></i>
                            Belum ada jurnal
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection