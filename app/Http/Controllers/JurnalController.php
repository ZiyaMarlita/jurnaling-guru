<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jurnal;

class JurnalController extends Controller
{

    /* =============================
       LIST DATA JURNAL
    ============================= */

    public function index(Request $request)
    {
        $guru = Auth::user()->guru;

        if (!$guru) {
            return redirect()->route('guru.dashboard')
                ->with('error', 'Data guru tidak ditemukan');
        }

        $query = Jurnal::where('guru_id', $guru->id);

        /* SEARCH */
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('mata_pelajaran', 'like', '%' . $request->search . '%')
                  ->orWhere('kelas', 'like', '%' . $request->search . '%');
            });
        }

        /* FILTER STATUS */
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jurnal = $query->latest()->paginate(10);

        /* STATISTIK */
        $stat = Jurnal::where('guru_id', $guru->id);

        $totalJurnal  = (clone $stat)->count();
        $totalDinilai = (clone $stat)->where('status', 'dinilai')->count();
        $totalRevisi  = (clone $stat)->where('status', 'revisi')->count();
        $totalPending = (clone $stat)->where('status', 'pending')->count();

        $rataRata = (clone $stat)
            ->join('evaluasi', 'jurnal.id', '=', 'evaluasi.jurnal_id')
            ->avg('evaluasi.nilai');

        /* NOTIFIKASI */
        $notifikasi = (clone $stat)
            ->where('status', 'dinilai')
            ->latest()
            ->take(5)
            ->get();

        return view('guru.jurnal.index', compact(
            'jurnal',
            'totalJurnal',
            'totalDinilai',
            'totalRevisi',
            'totalPending',
            'rataRata',
            'notifikasi'
        ));
    }


    /* =============================
       FORM TAMBAH JURNAL
    ============================= */

    public function create()
    {
        return view('guru.jurnal.create');
    }


    /* =============================
       SIMPAN JURNAL
    ============================= */

    public function store(Request $request)
    {
        $guru = Auth::user()->guru;

        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan');
        }

        $request->validate([
            'tanggal'        => 'required|date',
            'jam_pelajaran'  => 'required|string|max:50',
            'mata_pelajaran' => 'required|string|max:100',
            'kelas'          => 'required|string|max:50',
            'materi'         => 'required|string',
            'kendala'        => 'nullable|string',
        ]);

        Jurnal::create([
            'guru_id'        => $guru->id,
            'tanggal'        => $request->tanggal,
            'jam_pelajaran'  => $request->jam_pelajaran,
            'mata_pelajaran' => $request->mata_pelajaran,
            'kelas'          => $request->kelas,
            'materi'         => $request->materi,
            'kendala'        => $request->kendala,
            'status'         => 'pending',
        ]);

        return redirect()->route('guru.jurnal.index')
            ->with('success', 'Jurnal berhasil ditambahkan');
    }


    /* =============================
       DETAIL JURNAL
    ============================= */

    public function show($id)
    {
        $guru = Auth::user()->guru;

        $jurnal = Jurnal::where('guru_id', $guru->id)
            ->with('evaluasi')
            ->findOrFail($id);

        return view('guru.jurnal.detail', compact('jurnal'));
    }


    /* =============================
       FORM EDIT JURNAL
    ============================= */

    public function edit($id)
    {
        $guru = Auth::user()->guru;

        $jurnal = Jurnal::where('guru_id', $guru->id)
            ->findOrFail($id);

        if ($jurnal->status === 'dinilai') {
            return redirect()->route('guru.jurnal.index')
                ->with('error', 'Jurnal yang sudah dinilai tidak bisa diedit');
        }

        return view('guru.jurnal.edit', compact('jurnal'));
    }


    /* =============================
       UPDATE JURNAL
    ============================= */

    public function update(Request $request, $id)
    {
        $guru = Auth::user()->guru;

        $jurnal = Jurnal::where('guru_id', $guru->id)
            ->findOrFail($id);

        if ($jurnal->status === 'dinilai') {
            return back()->with('error', 'Jurnal yang sudah dinilai tidak bisa diubah');
        }

        $request->validate([
            'tanggal'        => 'required|date',
            'jam_pelajaran'  => 'required|string|max:50',
            'mata_pelajaran' => 'required|string|max:100',
            'kelas'          => 'required|string|max:50',
            'materi'         => 'required|string',
            'kendala'        => 'nullable|string',
        ]);

        $jurnal->update([
            'tanggal'        => $request->tanggal,
            'jam_pelajaran'  => $request->jam_pelajaran,
            'mata_pelajaran' => $request->mata_pelajaran,
            'kelas'          => $request->kelas,
            'materi'         => $request->materi,
            'kendala'        => $request->kendala,
        ]);

        return redirect()->route('guru.jurnal.index')
            ->with('success', 'Jurnal berhasil diperbarui');
    }


    /* =============================
       HAPUS JURNAL
    ============================= */

    public function destroy($id)
    {
        $guru = Auth::user()->guru;

        $jurnal = Jurnal::where('guru_id', $guru->id)
            ->findOrFail($id);

        if ($jurnal->status === 'dinilai') {
            return back()->with('error', 'Jurnal yang sudah dinilai tidak bisa dihapus');
        }

        $jurnal->delete();

        return back()->with('success', 'Jurnal berhasil dihapus');
    }
}