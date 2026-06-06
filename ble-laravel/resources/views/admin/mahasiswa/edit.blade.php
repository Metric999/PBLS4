@extends('layouts.admin')
@section('title', 'Edit Mahasiswa')

@section('content')
<div class="form-card" style="max-width:780px">
    <div class="form-title">Form Edit Mahasiswa</div>

    <form method="POST" action="{{ route('admin.mahasiswa.update', $mahasiswum->nim) }}">
        @csrf @method('PUT')
        <div class="form-grid">

            <div class="form-group">
                <label>NIM</label>
                <input type="text" value="{{ $mahasiswum->nim }}" disabled
                       style="background:#F3F4F6;color:#6B7280;cursor:not-allowed">
            </div>

            <div class="form-group">
                <label>Nama Lengkap <span class="req">*</span></label>
                <input type="text" name="nama" value="{{ old('nama',$mahasiswum->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Kelas <span class="req">*</span></label>
                <input type="text" name="kelas" value="{{ old('kelas',$mahasiswum->kelas) }}" required>
                @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Semester <span class="req">*</span></label>
                <select name="semester" required>
                    @for($i=1;$i<=8;$i++)
                        <option value="{{ $i }}"
                            {{ old('semester',$mahasiswum->semester)==$i ? 'selected':'' }}>
                            Semester {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="form-group form-full">
                <label>Program Studi <span class="req">*</span></label>
                <input type="text" name="prodi" value="{{ old('prodi',$mahasiswum->prodi) }}" required>
            </div>

            <div class="form-group">
                <label>Username <span class="req">*</span></label>
                <input type="text" name="username"
                       value="{{ old('username',$mahasiswum->username) }}" required>
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Password Baru <small style="color:#9CA3AF">(kosong = tidak berubah)</small></label>
                <input type="password" name="password">
            </div>

            <div class="form-group form-full">
                <label>Jadwal Perkuliahan</label>
                <select name="kelas_jadwal">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelasList as $kls)
                        <option value="{{ $kls }}"
                            {{ old('kelas_jadwal', $mahasiswum->kelas)==$kls ? 'selected':'' }}>
                            {{ $kls }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>
@endsection