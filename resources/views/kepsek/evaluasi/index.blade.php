@extends('layouts.kepsek')

@section('title', 'Data Evaluasi')

@section('content')

<div class="p-4 fade-up">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('kepsek.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="page-header" style="margin:0;">
            <h4 style="margin:0;">Data Evaluasi</h4>
            <small>Daftar penilaian terhadap jurnal guru</small>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-clipboard-check me-2 text-success"></i>Daftar Evaluasi</span>
            <span class="badge bg-primary">Total: {{ $evaluasi->total() }}</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Guru</th>
                        <th>Tanggal Jurnal</th>
                        <th>Mata Pelajaran</th>
                        <th style="width:100px;" class="text-center">Nilai</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($evaluasi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="font-weight:600;">
                            {{ optional(optional(optional($item->jurnal)->guru)->user)->nama_lengkap ?? '—' }}
                        </td>
                        <td>{{ optional(optional($item->jurnal)->tanggal)->format('d M Y') ?? '—' }}</td>
                        <td>{{ optional($item->jurnal)->mata_pelajaran ?? '—' }}</td>
                        <td class="text-center">
                            @php
                                $nilai = $item->nilai;
                                $nc = $nilai >= 85 ? 'bg-success' : ($nilai >= 70 ? 'bg-primary' : ($nilai >= 60 ? 'bg-warning' : 'bg-danger'));
                            @endphp
                            <span class="badge fs-6 {{ $nc }}">{{ $nilai }}</span>
                        </td>
                        <td style="color:var(--text-muted);font-size:13px;">{{ $item->catatan ?: '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox" style="font-size:32px;display:block;margin-bottom:8px;opacity:0.3;"></i>
                            Belum ada evaluasi
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($evaluasi->hasPages())
        <div class="card-footer d-flex justify-content-end">
            {{ $evaluasi->links() }}
        </div>
        @endif
    </div>

</div>

@endsection