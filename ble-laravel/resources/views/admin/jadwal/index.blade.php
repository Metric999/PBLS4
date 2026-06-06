@extends('layouts.admin')
@section('title', 'Jadwal')

@section('content')

<div class="action-bar">
    <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Jadwal
    </a>
</div>

<div class="card">
    <form method="GET">
        <div class="filter-bar">
            <input type="text" name="search" placeholder="Cari Kelas..."
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline" style="padding:8px 20px">Cari</button>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline" style="padding:8px 16px">Reset</a>
        </div>
    </form>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>Kelas</th>
                    <th>Hari</th>
                    <th>Waktu</th>
                    <th>Mata Kuliah</th>
                    <th>Ruangan</th>
                    <th>Dosen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $j)
                <tr>
                    <td>{{ $j->kelas }}</td>
                    <td>{{ $j->hari }}</td>
                    <td>{{ substr($j->jam_mulai,0,5) }}-{{ substr($j->jam_selesai,0,5) }}</td>
                    <td>{{ $j->mataKuliah->nama_matkul }}</td>
                    <td>{{ $j->ruangan->nama_ruangan }}</td>
                    <td>{{ $j->dosen->nama }}</td>
                    <td style="display:flex;gap:6px;align-items:center">
                        <a href="{{ route('admin.jadwal.edit', $j->id_jadwal) }}"
                           class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('admin.jadwal.destroy', $j->id_jadwal) }}"
                              method="POST" style="display:inline"
                              onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:32px;color:#9CA3AF">
                        Belum ada jadwal.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $jadwals->withQueryString()->links() }}
</div>
@endsection