@extends('layouts.kepsek')

@section('title', 'Dashboard')

@section('content')

<div class="p-4 fade-up">

    {{-- WELCOME HEADER --}}
    <div class="card mb-4" style="background:linear-gradient(135deg,#047857 0%,#059669 60%,#10b981 100%);border:none !important;overflow:hidden;position:relative;">
        <div style="position:absolute;inset:0;background:radial-gradient(circle at 80% 50%,rgba(255,255,255,0.08) 0%,transparent 60%);pointer-events:none;"></div>
        <div class="card-body p-4" style="position:relative;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <div style="font-family:'Sora',sans-serif;font-size:20px;font-weight:800;color:#fff;letter-spacing:-0.4px;">Dashboard Kepala Sekolah</div>
                    <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:2px;">Sistem Monitoring Jurnal Guru</div>
                </div>
            </div>
        </div>
    </div>

    {{-- STATISTIK + KALENDER --}}
    <div class="row g-4 mb-4">

        {{-- KIRI: STATISTIK --}}
        <div class="col-lg-8">

            {{-- STAT UTAMA --}}
            <div class="row g-3 mb-3 stagger">
                <div class="col-sm-6">
                    <div class="stat-box">
                        <div style="width:42px;height:42px;background:#dbeafe;border-radius:var(--r8);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                            <i class="bi bi-people-fill" style="font-size:18px;color:#1d4ed8;"></i>
                        </div>
                        <div class="stat-title">Total Guru</div>
                        <div class="stat-value" style="color:#1d4ed8;">{{ $totalGuru }}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="stat-box">
                        <div style="width:42px;height:42px;background:#d1fae5;border-radius:var(--r8);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                            <i class="bi bi-journal-text" style="font-size:18px;color:#059669;"></i>
                        </div>
                        <div class="stat-title">Total Jurnal</div>
                        <div class="stat-value" style="color:#059669;">{{ $totalJurnal }}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="stat-box">
                        <div style="width:42px;height:42px;background:#d1fae5;border-radius:var(--r8);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                            <i class="bi bi-clipboard-check-fill" style="font-size:18px;color:#059669;"></i>
                        </div>
                        <div class="stat-title">Total Evaluasi</div>
                        <div class="stat-value">{{ $totalEvaluasi }}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="stat-box">
                        <div style="width:42px;height:42px;background:#fff1f2;border-radius:var(--r8);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                            <i class="bi bi-exclamation-circle-fill" style="font-size:18px;color:#f43f5e;"></i>
                        </div>
                        <div class="stat-title">Belum Dievaluasi</div>
                        <div class="stat-value" style="color:#f43f5e;">{{ $belumEvaluasi }}</div>
                    </div>
                </div>
            </div>

            {{-- INFO HARI INI --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="stat-box d-flex align-items-center gap-3 text-start" style="padding:16px 20px;">
                        <div style="width:46px;height:46px;background:#fffbeb;border-radius:var(--r8);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="bi bi-calendar-day" style="font-size:20px;color:#f59e0b;"></i>
                        </div>
                        <div>
                            <div class="stat-title" style="text-align:left;">Jurnal Hari Ini</div>
                            <div class="stat-value" style="color:#f59e0b;font-size:26px;line-height:1;">{{ $jurnalHariIni }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-box d-flex align-items-center gap-3 text-start" style="padding:16px 20px;">
                        <div style="width:46px;height:46px;background:#f5f3ff;border-radius:var(--r8);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="bi bi-calendar-month" style="font-size:20px;color:#8b5cf6;"></i>
                        </div>
                        <div>
                            <div class="stat-title" style="text-align:left;">Jurnal Bulan Ini</div>
                            <div class="stat-value" style="color:#8b5cf6;font-size:26px;line-height:1;">{{ $jurnalBulanIni }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- KANAN: KALENDER --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-calendar3 me-2 text-success"></i>Kalender</span>
                    <span id="cal-month-label" style="font-size:12px;color:var(--ink-muted);font-weight:500;"></span>
                </div>
                <div class="card-body p-3">

                    {{-- NAV BULAN --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button id="cal-prev" class="btn btn-secondary btn-sm" style="padding:4px 10px;">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <span id="cal-title" style="font-family:'Sora',sans-serif;font-size:14px;font-weight:700;color:var(--ink);"></span>
                        <button id="cal-next" class="btn btn-secondary btn-sm" style="padding:4px 10px;">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>

                    {{-- GRID HARI --}}
                    <div id="cal-grid" style="display:grid;grid-template-columns:repeat(7,1fr);gap:2px;text-align:center;"></div>

                </div>
            </div>
        </div>

    </div>

    {{-- MENU CEPAT --}}
    <div class="card">
        <div class="card-header">
            <i class="bi bi-grid-3x3-gap me-2 text-success"></i>Menu Sistem
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="{{ route('kepsek.jurnal.index') }}" class="menu-box text-decoration-none">
                        <i class="bi bi-journal-text"></i>
                        <span>Data Jurnal Guru</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('kepsek.guru.index') }}" class="menu-box text-decoration-none">
                        <i class="bi bi-people-fill"></i>
                        <span>Data Guru</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('kepsek.laporan.index') }}" class="menu-box text-decoration-none">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>Laporan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
(function() {
    const today = new Date();
    let current = new Date(today.getFullYear(), today.getMonth(), 1);

    const days   = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
    const months = ['Januari','Februari','Maret','April','Mei','Juni',
                    'Juli','Agustus','September','Oktober','November','Desember'];

    function render() {
        const year  = current.getFullYear();
        const month = current.getMonth();

        document.getElementById('cal-title').textContent = months[month] + ' ' + year;
        document.getElementById('cal-month-label').textContent = year;

        const grid = document.getElementById('cal-grid');
        grid.innerHTML = '';

        days.forEach(d => {
            const el = document.createElement('div');
            el.textContent = d;
            el.style.cssText = 'font-size:10px;font-weight:700;color:var(--ink-muted);padding:4px 0;letter-spacing:0.03em;';
            grid.appendChild(el);
        });

        const firstDay = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            grid.appendChild(document.createElement('div'));
        }

        for (let d = 1; d <= totalDays; d++) {
            const el = document.createElement('div');
            el.textContent = d;

            const isToday = (d === today.getDate() &&
                             month === today.getMonth() &&
                             year === today.getFullYear());

            const isSun = new Date(year, month, d).getDay() === 0;

            el.style.cssText = `
                font-size:12px;
                font-weight:${isToday ? '700' : '400'};
                padding:5px 2px;
                border-radius:6px;
                cursor:default;
                color:${isToday ? '#fff' : isSun ? '#f43f5e' : 'var(--ink)'};
                background:${isToday ? '#059669' : 'transparent'};
                transition:background 0.15s;
            `;

            if (!isToday) {
                el.addEventListener('mouseenter', () => el.style.background = '#d1fae5');
                el.addEventListener('mouseleave', () => el.style.background = 'transparent');
            }

            grid.appendChild(el);
        }
    }

    document.getElementById('cal-prev').addEventListener('click', () => {
        current.setMonth(current.getMonth() - 1);
        render();
    });

    document.getElementById('cal-next').addEventListener('click', () => {
        current.setMonth(current.getMonth() + 1);
        render();
    });

    render();
})();
</script>
@endpush

@endsection