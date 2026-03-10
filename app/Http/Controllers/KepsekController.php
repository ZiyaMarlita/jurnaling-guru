<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurnal;
use App\Models\Evaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class KepsekController extends Controller
{
    /* ======================================================
       DASHBOARD
    ====================================================== */
    public function dashboard()
    {
        $now = Carbon::now();

        $totalGuru      = User::where('role', 'guru')->count();
        $totalJurnal    = Jurnal::count();
        $totalEvaluasi  = Evaluasi::count();
        $belumEvaluasi  = Jurnal::where('status', 'pending')->count();

        $jurnalHariIni  = Jurnal::whereDate('created_at', $now->toDateString())->count();
        $jurnalBulanIni = Jurnal::whereMonth('created_at', $now->month)
                                ->whereYear('created_at', $now->year)
                                ->count();

        return view('kepsek.dashboard', compact(
            'totalGuru',
            'totalJurnal',
            'totalEvaluasi',
            'belumEvaluasi',
            'jurnalHariIni',
            'jurnalBulanIni'
        ));
    }

    /* ======================================================
       DATA JURNAL
    ====================================================== */
    public function index()
    {
        $jurnal = Jurnal::with(['guru.user', 'evaluasi'])
            ->latest()
            ->paginate(10);

        return view('kepsek.jurnal.index', compact('jurnal'));
    }

    public function show($id)
    {
        $jurnal = Jurnal::with(['guru.user', 'evaluasi'])
            ->findOrFail($id);

        return view('kepsek.jurnal.detail', compact('jurnal'));
    }

    /* ======================================================
       SIMPAN EVALUASI
    ====================================================== */
    public function evaluasi(Request $request, $id)
    {
        $request->validate([
            'nilai'   => 'required|integer|min:1|max:100',
            'catatan' => 'nullable|string|max:500',
        ]);

        $jurnal = Jurnal::with('evaluasi')->findOrFail($id);

        if ($jurnal->evaluasi) {
            return back()->with('error', 'Jurnal ini sudah dievaluasi.');
        }

        Evaluasi::create([
            'jurnal_id' => $jurnal->id,
            'kepsek_id' => Auth::id(),
            'nilai'     => $request->nilai,
            'catatan'   => $request->catatan,
        ]);

        $jurnal->update(['status' => 'dinilai']);

        return back()->with('success', 'Evaluasi berhasil disimpan.');
    }

    /* ======================================================
       DATA GURU
    ====================================================== */
    public function guru()
    {
        $guru = User::where('role', 'guru')
            ->with('guru')
            ->orderBy('nama_lengkap')
            ->paginate(10);

        return view('kepsek.guru.index', compact('guru'));
    }

    public function guruShow($id)
    {
        $guru = User::where('role', 'guru')
            ->with('guru')
            ->findOrFail($id);

        return view('kepsek.guru.detail', compact('guru'));
    }

    /* ======================================================
       DATA EVALUASI
    ====================================================== */
    public function evaluasiIndex()
    {
        $evaluasi = Evaluasi::with('jurnal.guru.user')
            ->latest()
            ->paginate(10);

        return view('kepsek.evaluasi.index', compact('evaluasi'));
    }

    /* ======================================================
       LAPORAN
    ====================================================== */
    public function laporan(Request $request)
    {
        $bulan = $request->filled('bulan') ? $request->bulan : now()->month;
        $tahun = $request->filled('tahun') ? $request->tahun : now()->year;

        $totalGuru     = User::where('role', 'guru')->count();
        $totalJurnal   = Jurnal::count();
        $totalEvaluasi = Evaluasi::count();
        $belumEvaluasi = Jurnal::where('status', 'pending')->count();

        $jurnalPeriode = Jurnal::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count();

        $evaluasiPeriode = Evaluasi::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count();

        $rataRataPeriode = Evaluasi::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->avg('nilai');

        return view('kepsek.laporan.index', compact(
            'totalGuru',
            'totalJurnal',
            'totalEvaluasi',
            'belumEvaluasi',
            'jurnalPeriode',
            'evaluasiPeriode',
            'rataRataPeriode',
            'bulan',
            'tahun'
        ));
    }

    /* ======================================================
       PENGATURAN AKUN
    ====================================================== */
    public function pengaturan()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('kepsek.pengaturan', compact('user'));
    }

    public function updatePengaturan(Request $request)
    {
        $userId = Auth::id();

        if (!$userId) {
            return back()->with('error', 'User belum login.');
        }

        $user = User::findOrFail($userId);

        // Jika hanya simpan foto
        if ($request->has('save_foto')) {
            $request->validate([
                'foto' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            ]);

            if ($request->hasFile('foto')) {
                if ($user->foto) {
                    Storage::disk('public')->delete($user->foto);
                }
                $path = $request->file('foto')->store('foto-kepsek', 'public');
                $user->update(['foto' => $path]);
            }

            return back()->with('success', 'Foto profil berhasil diperbarui.');
        }

        // Simpan informasi akun & password
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|confirmed|min:6',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}