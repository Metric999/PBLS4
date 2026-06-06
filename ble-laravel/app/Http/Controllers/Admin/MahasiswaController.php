<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswas = Mahasiswa::query()
            ->when($request->search, fn($q) =>
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('nim', 'like', "%{$request->search}%"))
            ->when($request->kelas,    fn($q) => $q->where('kelas', $request->kelas))
            ->when($request->semester, fn($q) => $q->where('semester', $request->semester))
            ->orderBy('nama')
            ->paginate(20)
            ->withQueryString();

        // Untuk dropdown filter kelas
        $kelasList = Mahasiswa::distinct()->orderBy('kelas')->pluck('kelas');

        return view('admin.mahasiswa.index', compact('mahasiswas', 'kelasList'));
    }

    public function create()
    {
        // Daftar kelas dari jadwal yang sudah ada
        $kelasList = Jadwal::distinct()->orderBy('kelas')->pluck('kelas');
        return view('admin.mahasiswa.create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim'          => 'required|string|max:20|unique:mahasiswas,nim',
            'nama'         => 'required|string|max:100',
            'kelas'        => 'required|string|max:15',
            'semester'     => 'required|integer|min:1|max:14',
            'prodi'        => 'required|string|max:100',
            'username'     => 'required|string|unique:mahasiswas,username',
            'password'     => 'nullable|string|min:6',
            'kelas_jadwal' => 'nullable|string',
        ]);

        $mahasiswa = Mahasiswa::create([
            'nim'      => $validated['nim'],
            'nama'     => $validated['nama'],
            'kelas'    => $validated['kelas'],
            'semester' => $validated['semester'],
            'prodi'    => $validated['prodi'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password'] ?? $validated['nim']),
        ]);

        // Sinkron jadwal berdasarkan kelas yang dipilih
        if (! empty($validated['kelas_jadwal'])) {
            $jadwalIds = Jadwal::where('kelas', $validated['kelas_jadwal'])
                ->pluck('id_jadwal');
            $mahasiswa->jadwals()->sync($jadwalIds);
        }

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswum)
    {
        $kelasList = Jadwal::distinct()->orderBy('kelas')->pluck('kelas');
        return view('admin.mahasiswa.edit', compact('mahasiswum', 'kelasList'));
    }

    public function update(Request $request, Mahasiswa $mahasiswum)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:100',
            'kelas'        => 'required|string|max:15',
            'semester'     => 'required|integer|min:1|max:14',
            'prodi'        => 'required|string|max:100',
            'username'     => "required|string|unique:mahasiswas,username,{$mahasiswum->nim},nim",
            'password'     => 'nullable|string|min:6',
            'kelas_jadwal' => 'nullable|string',
        ]);

        $updateData = [
            'nama'     => $validated['nama'],
            'kelas'    => $validated['kelas'],
            'semester' => $validated['semester'],
            'prodi'    => $validated['prodi'],
            'username' => $validated['username'],
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $mahasiswum->update($updateData);

        // Update jadwal sesuai kelas baru
        if (! empty($validated['kelas_jadwal'])) {
            $jadwalIds = Jadwal::where('kelas', $validated['kelas_jadwal'])
                ->pluck('id_jadwal');
            $mahasiswum->jadwals()->sync($jadwalIds);
        }

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswum)
    {
        $mahasiswum->delete();
        return back()->with('success', 'Mahasiswa berhasil dihapus.');
    }
}