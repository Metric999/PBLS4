@extends('layouts.admin')
@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="form-card" style="max-width:780px">
    <div class="form-title">Form Tambah Mahasiswa</div>

    <form method="POST" action="{{ route('admin.mahasiswa.store') }}">
        @csrf
        <div class="form-grid">

            {{-- NIM --}}
            <div class="form-group">
                <label>NIM <span class="req">*</span></label>
                <input type="text" name="nim" value="{{ old('nim') }}" required>
                @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Nama Lengkap --}}
            <div class="form-group">
                <label>Nama Lengkap <span class="req">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Kelas --}}
            <div class="form-group">
                <label>Kelas <span class="req">*</span></label>
                <input type="text" name="kelas" placeholder="contoh: IF3C-Pagi"
                       value="{{ old('kelas') }}" required>
                @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Semester --}}
            <div class="form-group">
                <label>Semester <span class="req">*</span></label>
                <select name="semester" required>
                    @for($i=1;$i<=8;$i++)
                        <option value="{{ $i }}" {{ old('semester')==$i ? 'selected':'' }}>
                            Semester {{ $i }}
                        </option>
                    @endfor
                </select>
                @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Program Studi --}}
            <div class="form-group form-full">
                <label>Program Studi <span class="req">*</span></label>
                <input type="text" name="prodi" value="{{ old('prodi') }}" required>
                @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Username --}}
            <div class="form-group">
                <label>Username <span class="req">*</span></label>
                <input type="text" name="username" value="{{ old('username') }}" required>
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label>Password <span class="req">*</span></label>
                <input type="password" name="password" placeholder="Kosong = NIM sebagai password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Jadwal Perkuliahan --}}
            <div class="form-group form-full">
                <label>Jadwal Perkuliahan <span class="req">*</span></label>
                <select name="kelas_jadwal" id="kelasJadwal">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelasList as $kls)
                        <option value="{{ $kls }}" {{ old('kelas_jadwal')==$kls ? 'selected':'' }}>
                            {{ $kls }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_jadwal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small style="color:#9CA3AF;font-size:12px;margin-top:3px">
                    Jadwal akan otomatis terpilih berdasarkan kelas yang dipilih
                </small>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>
@endsection