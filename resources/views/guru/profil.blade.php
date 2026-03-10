@extends('layouts.guru')

@section('title', 'Profil Guru')

@section('content')

<div class="p-4 fade-up">

    <div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- HEADER --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="page-header" style="margin:0;">
                <h4 style="margin:0;">Profil Guru</h4>
                <small>Kelola informasi data pribadi kamu</small>
            </div>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="alert alert-success mb-4">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-circle me-2 text-success"></i>Informasi Profil
            </div>
            <div class="card-body">

                {{-- FOTO PROFIL --}}
                <div class="text-center mb-4">
                    <img
                        src="{{ ($guru && $guru->foto) ? asset('storage/'.$guru->foto) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama_lengkap).'&background=059669&color=fff&size=200' }}"
                        id="previewFoto"
                        class="rounded-circle"
                        style="width:90px;height:90px;object-fit:cover;border:3px solid var(--border);box-shadow:var(--shadow);"
                        alt="Foto Profil"
                    >
                    <div style="font-size:12px;color:var(--text-muted);margin-top:8px;">
                        Klik "Foto Profil" di bawah untuk mengganti
                    </div>
                </div>

                <form action="{{ route('guru.profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap"
                                   class="form-control @error('nama_lengkap') is-invalid @enderror"
                                   value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                            @error('nama_lengkap')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control"
                                   value="{{ old('nip', $guru->nip ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control"
                                   value="{{ old('tempat_lahir', $guru->tempat_lahir ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                   value="{{ old('tanggal_lahir', optional($guru->tanggal_lahir)->format('Y-m-d') ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">— Pilih —</option>
                                <option value="Laki-laki"  {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') === 'Laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan"  {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') === 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control"
                                   value="{{ old('jabatan', $guru->jabatan ?? '') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">
                                Foto Profil
                                <span style="font-weight:400;color:var(--text-muted);font-size:12px;">(Opsional)</span>
                            </label>
                            <input type="file" name="foto"
                                   class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/jpg,image/jpeg,image/png"
                                   onchange="previewImage(event)">
                            <small style="font-size:12px;color:var(--text-muted);">
                                Kosongkan jika tidak ingin mengganti foto (jpg/jpeg/png, maks 2MB)
                            </small>
                            @error('foto')<small class="text-danger d-block">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" rows="3" class="form-control">{{ old('alamat', $guru->alamat ?? '') }}</textarea>
                        </div>

                        <div class="col-12 d-flex justify-content-between pt-2">
                            <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>
    </div>

</div>

@push('scripts')
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = () => {
        document.getElementById('previewFoto').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endpush

@endsection