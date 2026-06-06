@extends('layouts.admin')
@section('title', 'Mahasiswa')

@section('content')

{{-- Tombol Tambah --}}
<div class="action-bar">
    <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Mahasiswa
    </a>
</div>

{{-- Tabel dalam card --}}
<div class="card">
    <form method="GET">
        <div class="filter-bar">
            <input type="text" name="search" placeholder="Cari Nama / NIM..."
                   value="{{ request('search') }}">
            <select name="kelas" style="width:110px">
                <option value="">Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k }}" {{ request('kelas')==$k ? 'selected':'' }}>{{ $k }}</option>
                @endforeach
            </select>
            <select name="semester" style="width:130px">
                <option value="">Semester</option>
                @for($i=1;$i<=8;$i++)
                    <option value="{{ $i }}" {{ request('semester')==$i ? 'selected':'' }}>Semester {{ $i }}</option>
                @endfor
            </select>
            <button type="submit" class="btn btn-outline" style="padding:8px 16px">Filter</button>
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline" style="padding:8px 16px">Reset</a>
        </div>
    </form>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Semester</th>
                    <th>Prodi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswas as $m)
                <tr>
                    <td>{{ $m->nim }}</td>
                    <td>{{ $m->nama }}</td>
                    <td>{{ $m->kelas }}</td>
                    <td>{{ $m->semester }}</td>
                    <td>{{ $m->prodi }}</td>
                    <td style="display:flex;gap:6px;align-items:center">
                        <a href="{{ route('admin.mahasiswa.edit', $m->nim) }}"
                           class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('admin.mahasiswa.destroy', $m->nim) }}"
                              method="POST" style="display:inline"
                              onsubmit="return confirm('Hapus mahasiswa {{ $m->nama }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:32px;color:#9CA3AF">
                        Belum ada data mahasiswa.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $mahasiswas->withQueryString()->links() }}
</div>
@endsection