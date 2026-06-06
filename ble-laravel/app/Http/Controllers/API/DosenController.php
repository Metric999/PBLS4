<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DosenController extends Controller
{
    /**
     * Daftar jadwal milik dosen yang login.
     */
    public function jadwal(Request $request): JsonResponse
    {
        $jadwals = Jadwal::with(['mataKuliah', 'ruangan'])
            ->where('nidn', $request->user()->nidn)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return response()->json($jadwals);
    }

    /**
     * Daftar hadir mahasiswa pada jadwal tertentu.
     * Filter: kelas, semester, prodi.
     */
    public function daftarHadir(Request $request, int $idJadwal): JsonResponse
    {
        $jadwal = Jadwal::with(['mataKuliah', 'ruangan'])
            ->where('id_jadwal', $idJadwal)
            ->where('nidn', $request->user()->nidn)
            ->firstOrFail();

        $mahasiswas = $jadwal->mahasiswas()
            ->when($request->kelas,    fn($q) => $q->where('kelas', $request->kelas))
            ->when($request->semester, fn($q) => $q->where('semester', $request->semester))
            ->when($request->prodi,    fn($q) => $q->where('prodi', $request->prodi))
            ->get()
            ->map(function ($m) use ($idJadwal) {
                $absensi = Absensi::where('nim', $m->nim)
                    ->where('id_jadwal', $idJadwal)
                    ->whereDate('tanggal', today())
                    ->first();

                return [
                    'nim'          => $m->nim,
                    'nama'         => $m->nama,
                    'kelas'        => $m->kelas,
                    'semester'     => $m->semester,
                    'prodi'        => $m->prodi,
                    'status'       => $absensi?->status ?? 'alpha',
                    'id_absensi'   => $absensi?->id_absensi,
                    'keterangan'   => $absensi?->keterangan,
                ];
            });

        return response()->json([
            'jadwal'     => $jadwal,
            'mahasiswas' => $mahasiswas,
        ]);
    }

    /**
     * Dosen mengubah status absensi (izin / alpha / hadir).
     */
    public function updateAbsensi(Request $request, int $idAbsensi): JsonResponse
    {
        $request->validate([
            'status'     => 'required|in:hadir,izin,alpha',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $absensi = Absensi::findOrFail($idAbsensi);

        // Pastikan absensi ini milik jadwal dosen yang bersangkutan
        $jadwal = Jadwal::where('id_jadwal', $absensi->id_jadwal)
            ->where('nidn', $request->user()->nidn)
            ->firstOrFail();

        $absensi->update([
            'status'     => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'message' => 'Status absensi diperbarui.',
            'data'    => $absensi,
        ]);
    }

    /**
     * Rekap kehadiran mahasiswa per jadwal.
     */
    public function rekap(Request $request, int $idJadwal): JsonResponse
    {
        $jadwal = Jadwal::where('id_jadwal', $idJadwal)
            ->where('nidn', $request->user()->nidn)
            ->firstOrFail();

        $rekap = Absensi::with('mahasiswa')
            ->where('id_jadwal', $idJadwal)
            ->when($request->tanggal_mulai, fn($q) =>
                $q->whereDate('tanggal', '>=', $request->tanggal_mulai))
            ->when($request->tanggal_selesai, fn($q) =>
                $q->whereDate('tanggal', '<=', $request->tanggal_selesai))
            ->orderBy('tanggal')
            ->get()
            ->groupBy('nim')
            ->map(function ($rows, $nim) {
                $m = $rows->first()->mahasiswa;
                return [
                    'nim'     => $nim,
                    'nama'    => $m->nama,
                    'kelas'   => $m->kelas,
                    'hadir'   => $rows->where('status', 'hadir')->count(),
                    'izin'    => $rows->where('status', 'izin')->count(),
                    'alpha'   => $rows->where('status', 'alpha')->count(),
                    'total'   => $rows->count(),
                    'detail'  => $rows->map(fn($r) => [
                        'tanggal' => $r->tanggal->format('Y-m-d'),
                        'status'  => $r->status,
                    ]),
                ];
            })
            ->values();

        return response()->json([
            'jadwal' => $jadwal->load('mataKuliah', 'ruangan'),
            'rekap'  => $rekap,
        ]);
    }
}